<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\DepositChannelController;
use App\Http\Controllers\Admin\WithdrawalChannelController;
use App\Http\Controllers\Admin\RaffleDrawController;
use App\Http\Controllers\Admin\StreamingManagementController;
use App\Http\Controllers\Admin\TransactionHistoryController;
use App\Http\Controllers\Admin\PageManagementController;
use App\Http\Controllers\Admin\StaffManagementController;
use App\Http\Controllers\RafflesDrawController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\OpenAIController;

use Carbon\Carbon;
use App\Models\RaffleDraw;
use App\Models\RaffleResult;
use App\Models\Page;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/generate-text', [OpenAIController::class, 'generateText']);


Route::get('/', function () {

    // Active Raffles
    $now = Carbon::now();
    $raffle_draw = RaffleDraw::where('status', 'Active')
    ->whereRaw("STR_TO_DATE(draw_time, '%Y-%m-%dT%H:%i') > ?", [$now->format('Y-m-d H:i')])
    ->select('id', 'draw_title', 'type', 'draw_time')
    ->get();
    

    // Latest Results
    $raffle_results = RaffleResult::leftjoin('raffle_prizes', 'raffle_results.prize_id', '=', 'raffle_prizes.id')
        ->leftjoin('users', 'raffle_results.user_id', '=', 'users.id')
        ->leftjoin('raffle_draws', 'raffle_results.raffle_id', '=', 'raffle_draws.id')
        ->where('raffle_results.user_id', '!=', null)
        ->whereRaw("STR_TO_DATE(raffle_draws.draw_time, '%Y-%m-%dT%H:%i') < ?", [$now->format('Y-m-d H:i')])
        ->select(
            'raffle_prizes.cash_prize',
            'users.id',
            'users.first_name',
            'users.last_name',
            'users.profile_image'
        )
    ->orderBy('raffle_results.id', 'desc')
    ->get()->toArray();

    $result = [];
    foreach ($raffle_results as $item) {
        $id = $item['id'];

        if (!isset($result[$id])) {
            // If the 'id' is not encountered before, add the entire item to the result array.
            $result[$id] = $item;
        } else {
            // If the 'id' is already in the result array, add the 'cash_prize' value to the existing item.
            $result[$id]['cash_prize'] += floatval($item['cash_prize']);
        }
    }

    return view('index', compact('raffle_draw', 'result'));
})->name('landing');

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

Route::get('/clear-cache', function () {
   Artisan::call('cache:clear');
   Artisan::call('route:clear');
   Artisan::call('config:clear');

   return "Cache cleared successfully";
});






    /////////////////////////////////////////
   //                                     //
  //        Admin Routes                 //
 //                                     //
/////////////////////////////////////////

Route::group(['prefix' => 'admin', 'namespace' => 'App\Http\Controllers\Admin'], function () {

    // Login And Register
    Route::get('/login', [AdminAuthController::class, 'getLogin'])->name('adminLogin');
    Route::get('/register', [AdminAuthController::class, 'getRegister'])->name('adminRegister');

    Route::post('/post-register', [AdminAuthController::class, 'Register'])->name('admin_register');
    Route::post('/login', [AdminAuthController::class, 'postLogin'])->name('adminLoginPost');
    
    // forget password
    Route::get('/password/reset', [AdminAuthController::class, 'ResetPassword'])->name('admin.password.request');
    Route::post('/email-notification', [AdminAuthController::class, 'CheckResetPassword'])->name('admin.password.notify-email');
    Route::get('/password/confirm-password', [AdminAuthController::class, 'ConfirmPassword']);
    Route::post('/password/update-password', [AdminAuthController::class, 'ResetUpdatePassword'])->name('admin.password.update');


    // Logout
    Route::get('/logout', [AdminAuthController::class, 'adminLogout'])->name('adminLogout');
    
    // Change Password 
    Route::get('/change-password-ad', [AdminAuthController::class, 'ChangePassword'])->name('change-password-ad');
    Route::post('/update-password-ad', [AdminAuthController::class, 'UpdatePassword'])->name('update-password-ad');


    // User Management
    
    
    Route::group(['middleware' => 'adminauth'], function () {
        Route::get('/dashboard', [AdminAuthController::class, 'index'])->name('adminDashboard');
        Route::resource('/user-management', 'UserManagementController');
        Route::resource('/deposit-channel', 'DepositChannelController');
        Route::resource('/withdrawal-channel', 'WithdrawalChannelController');
        Route::resource('/raffle-draw', 'RaffleDrawController');
        Route::resource('/streaming-management', 'StreamingManagementController');
        
        // Result Management
        Route::get('/raffle-draw/{id}/results', [RaffleDrawController::class, 'Results'])->name('raffle-draw.results');
        Route::get('/raffle-draw/{id}/manage-result', [RaffleDrawController::class, 'ResultManage'])->name('raffle-draw.result_manage');
        Route::post('/store-result/{id}', [RaffleDrawController::class, 'StoreResult'])->name('store-result');
        Route::post('/check-valid-ball', [RaffleDrawController::class, 'CheckValidBall'])->name('check-valid-ball');
        Route::get('/raffle-draw-details/{id}', [RaffleDrawController::class, 'RaffleDetail'])->name('raffle-draw-details');
        
        // Wallet
        Route::get('/wallet-balance/{id}', [UserManagementController::class, 'WalletBalance'])->name('wallet-balance');
        Route::post('/update-wallet-balance/{id}', [UserManagementController::class, 'UpdateWalletBalance'])->name('update-wallet-balance');

        // Prize Store session
        Route::post('/store-prize-image', [RaffleDrawController::class, 'PrizeStoreimage'])->name('prize-store-image');
        
        // Deposit Request management
        Route::get('/deposit-request', [DepositChannelController::class, 'DepositRequest'])->name('deposit-request');
        Route::post('/update-depost-request/{id}', [DepositChannelController::class, 'UpdateDepositRequest'])->name('update-depost-request');

        
        // Withdrawal Request Management
        Route::get('/withdrawal-request', [WithdrawalChannelController::class, 'WithdrawalRequest'])->name('withdrawal-request');
        Route::post('/update-withdrawal-request/{id}', [WithdrawalChannelController::class, 'UpdateWithdrawalRequest'])->name('update-withdrawal-request');
        
        // Transaction history
        Route::get('/transaction-history', [TransactionHistoryController::class, 'Transactions'])->name('transaction-history');
        
        // My orders
        Route::get('/my-orders', [AdminAuthController::class, 'Orders'])->name('my-orders-adm');

        // My pages
        Route::resource('/pages', 'PageManagementController');

        // Staff Management
        Route::resource('/staff-management', 'StaffManagementController');
        Route::get('staff-management-log/{id}', [StaffManagementController::class, 'StaffLog'])->name('staff-management-log');
        
    });
});


    /////////////////////////////////////////
   //                                     //
  //        User Routes                  //
 //                                     //
/////////////////////////////////////////
Auth::routes();


Route::get('/about', function(){
    $aboutHtml = Page::where('page_name', 'About')->first();
    return view('about', compact('aboutHtml'));
})->name('about');

Route::get('/how-to-play', function(){
    $how_to_play_html = Page::where('page_name', 'How to Play')->first();
    return view('how-to-play', compact('how_to_play_html'));
})->name('how_to_play');

Route::get('/FAQ', function(){
    $faqHtml = Page::where('page_name', 'FAQ')->first();
    return view('FAQ', compact('faqHtml'));
})->name('FAQ');

Route::get('/contact-us', function(){
    $contact_us_html = Page::where('page_name', 'Contact US')->first();
    return view('contact-us', compact('contact_us_html'));
})->name('contact-us');

Route::get('/privacy-policy', function(){
    $privacy_policy_html = Page::where('page_name', 'Privacy Policy')->first();
    return view('privacy-policy', compact('privacy_policy_html'));
})->name('privacy-policy');

Route::get('/desclimer', function(){
    $disclaimer_html = Page::where('page_name', 'Disclaimer')->first();
    return view('desclimer', compact('disclaimer_html'));
})->name('desclimer');

Route::get('/terms-of-use', function(){
    $term_of_use_html = Page::where('page_name', 'Terms of Use')->first();
    return view('terms-of-use', compact('term_of_use_html'));
})->name('terms-of-use');

Route::get('raffle-draws', [RafflesDrawController::class, 'index'])->name('raffle-draws');
Route::get('raffle-draws/{id}', [RafflesDrawController::class, 'Detail'])->name('raffle-draw-detail');

Route::post('choose-balls', [RafflesDrawController::class, 'BallsChoose'])->name('choose-balls');

// Checkout user register
Route::post('checkout-user-register', [RegisterController::class, 'UserRegister'])->name('user-register');
Route::post('checkout-user-register', [RegisterController::class, 'UserRegister'])->name('user-register');
Route::post('order-raffle', [RafflesDrawController::class, 'OrderRaffle'])->name('order-raffle');

// Add Funds
Route::get('add-funds', [RafflesDrawController::class, 'AddFund'])->name('add-funds');
Route::post('store-funds', [RafflesDrawController::class, 'StoreFunds'])->name('store-funds');
Route::get('deposit-channel-detail', [RafflesDrawController::class, 'DepositChannelDetail'])->name('deposit-channel-detail');

// My profile
Route::get('my-profile', [HomeController::class, 'MyProfile'])->name('my-profile');
Route::post('update-profile', [HomeController::class, 'UpdateProfile'])->name('update-profile');

// withdrawal-request
Route::get('withdrawal-requests', [RafflesDrawController::class,'WithdrawalRequest'])->name('user-withdrawal-request');
Route::get('withdrawal-management-detail', [RafflesDrawController::class, 'WithdrawalManagementDetail'])->name('withdrawal-management-detail');
Route::post('store-withdrawal-request', [RafflesDrawController::class, 'StoreWithdrawalRequest'])->name('store-withdrawal-request');

// transactions
Route::get('transactions', [RafflesDrawController::class, 'Transactions'])->name('transactions');

// Change password 
Route::get('change-password', [HomeController::class, 'ChangePassword'])->name('change-password');
Route::post('update-password', [HomeController::class, 'UpdatePassword'])->name('update-password');

// Forget Password
Route::get('/reset-password', [AuthController::class, 'PasswordReset'])->name('reset-password');
Route::post('/email-reset-notification', [AuthController::class, 'UserResetPassword'])->name('email-notification');
Route::get('/password-confirm', [AuthController::class, 'ConfirmPassword']);
Route::post('/password-update', [AuthController::class, 'ResetUpdatePassword'])->name('password.update');

// Winner User
Route::get('/winners', [RafflesDrawController::class, 'RaffleWinner'])->name('raffle-winner');
Route::get('lastest-results', [RafflesDrawController::class, 'LatestResult'])->name('results');

// Contact us 
Route::post('/store-contact-us', [AuthController::class, 'StoreContactUs'])->name('store-contact-us');

// my order 
Route::get('/orders', [HomeController::class, 'Orders'])->name('my-orders');

// User method details
Route::get('user-method-detail', [HomeController::class, 'UserMethodDetail'])->name('user-method-detail');

// Claim User prize
Route::get('/claim-prize/{id}', [HomeController::class, 'ClaimPrize'])->name('claim-prize');
Route::post('/save-claim-prize/{id}', [HomeController::class, 'SaveClaimPrize'])->name('save-claim-prize');


// Logout
Route::get('/logout', function(){
        auth()->guard('web')->logout();
       
        return redirect(route('login'));
});


