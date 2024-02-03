<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\WithdrawalRequest;
use App\Models\DepositRequest;
use Session;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\RaffleResult;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\ResetPasswordNotification;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{
    
    public function index()
    {
        $now = Carbon::now();
        $ttl_withdrawal_amount = WithdrawalRequest::where('status', 'Approved')->sum('amount');
        $ttl_deposit_amount = DepositRequest::where('status', 'Approved')->sum('amount');
        
        $yesterday = Carbon::yesterday();
        $today = Carbon::today();
        $today_withdrawal_amount = WithdrawalRequest::where('status', 'Approved')->whereDate('created_at', $today)->sum('amount');
        $today_deposit_amount = DepositRequest::where('status', 'Approved')->whereDate('created_at', $today)->sum('amount');
        
        $yesterday_withdrawal_amount = WithdrawalRequest::where('status', 'Approved')->whereDate('created_at', $yesterday)->sum('amount');
        $yesterday_deposit_amount = DepositRequest::where('status', 'Approved')->whereDate('created_at', $yesterday)->sum('amount');

        
        
        $ttl_winning_cash_prize = RaffleResult::leftjoin('raffle_prizes', 'raffle_results.prize_id', '=', 'raffle_prizes.id')
            ->leftjoin('users', 'raffle_results.user_id', '=', 'users.id')
            ->leftjoin('raffle_draws', 'raffle_results.raffle_id', '=', 'raffle_draws.id')
            ->whereRaw("STR_TO_DATE(raffle_draws.draw_time, '%Y-%m-%dT%H:%i') < ?", [$now->format('Y-m-d H:i')])
            ->where('raffle_results.user_choice', 'Cash')
            ->select(
                'raffle_prizes.cash_prize',
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.profile_image'
            )
        ->orderBy('raffle_results.id', 'desc')
        ->sum('raffle_prizes.cash_prize');

        $ttl_physical_prize = RaffleResult::leftjoin('raffle_prizes', 'raffle_results.prize_id', '=', 'raffle_prizes.id')
            ->leftjoin('users', 'raffle_results.user_id', '=', 'users.id')
            ->leftjoin('raffle_draws', 'raffle_results.raffle_id', '=', 'raffle_draws.id')
            ->whereRaw("STR_TO_DATE(raffle_draws.draw_time, '%Y-%m-%dT%H:%i') < ?", [$now->format('Y-m-d H:i')])
            ->where('raffle_results.user_choice', 'Physical Prize')
            ->select(
                'raffle_prizes.cash_prize',
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.profile_image'
            )
        ->orderBy('raffle_results.id', 'desc')
        ->count();
    
        return view('admin.index', compact('ttl_withdrawal_amount', 'ttl_deposit_amount', 'today_deposit_amount', 'today_withdrawal_amount', 'yesterday_withdrawal_amount', 'yesterday_deposit_amount', 'ttl_winning_cash_prize', 'ttl_physical_prize'));
    }

    public function getLogin()
    {
        return view('admin.auth.login');
    }

   
    public function getRegister()
    {
        return view('admin.auth.register');
    }

  
    public function Register(Request $request)
    {
        $this->validate($request, [
            'first_name' => ['required', 'string', 'max:255'],
            // 'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $user =  User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_role' => 'Admin',
        ]);

        // $user->assignRole('Admin');

        return redirect()->route('adminDashboard');
    }

   
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $user = User::where('email', $request->email)->where('user_role', 'Admin')->first();
        if($user){
            if(auth()->guard('admin')->attempt(['email' => $request->input('email'),  'password' => $request->input('password')])){
                $user = auth()->guard('admin')->user();
                if($user->user_role == 'Admin'){
                    return redirect()->route('adminDashboard')->with('success','You are Logged in sucessfully.');
                }
            }else {
                return redirect()->back()->with('error','Whoops! invalid email and password.');
            }
        }else {
            return redirect()->back()->with('error','Whoops! invalid email and password.');
        }
        
    }

    public function ChangePassword(Request $request)
    {
        return view('admin.changePassword');
    }

    public function UpdatePassword(Request $request)
    {
        $this->validate($request, [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        User::where('id', auth('admin')->user()->id)->update(['password' => Hash::make($request->password)]);
        return back()->with('success', 'Password changed successfully!');
    }

    public function adminLogout(Request $request)
    {
        auth()->guard('admin')->logout();
        Session::flush();
        return redirect(route('adminLogin'));
    }
    
    public function ResetPassword(Request $request)
    {
        return view('admin.auth.passwords.email');
    }

    public function CheckResetPassword(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        $user = User::where('email', $request->email)->where('user_role','Admin')->first();
        if(!$user) return back()->with('error', "We can't find a user with that email address.");
        $token = Str::random(60);
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' =>  $token,
            'created_at' =>  Carbon::now(),
        ]);
        $data = [
            'first_name' => $user->first_name,
            'reset-link' => url('/').'/admin/password/confirm-password?token='.$token.'&email='.$request->email,
        ];
        
        Mail::to($user->email)->send(new ResetPasswordNotification($data));
        return back()->with('status', "We have emailed your password reset link!"); 
        
    }

    public function ConfirmPassword(Request $request)
    {
        $token = $request->token;
        $email = $request->email;
        return view('admin.auth.passwords.reset', compact('token','email'));
    }
    

    public function ResetUpdatePassword(Request $request)
    {
        $this->validate($request, [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $reset_password = DB::table('password_resets')->where('token', $request->token)->first();

        $token_after_expire = Carbon::parse($reset_password->created_at)->addHour(1);
        if(Carbon::now() <= $token_after_expire){

            User::where('email', $request->email)->update(['password' =>  Hash::make($request->password)]);
            $user = User::where('email', $request->email)->first();

            if($user){
                if(auth()->guard('admin')->attempt(['email' => $request->input('email'),  'password' => $request->input('password')])){
                    $user = auth()->guard('admin')->user();
                    if($user->user_role == 'Admin'){
                        return redirect()->route('adminDashboard')->with('success','You are Logged in sucessfully.');
                    }
                }else {
                    return redirect()->back()->with('error','Whoops! invalid email and password.');
                }
            }else {
                return redirect()->back()->with('error','Whoops! invalid email and password.');
            }
        }else{
            return back()->with('error', 'Token expired.');
        }


    }
    
    public function Orders(Request $request){
        $orders = OrderDetail::leftjoin('order', 'order_detail.order_id', '=', 'order.id')
        ->leftjoin('raffle_draws', 'order_detail.raffle_id', '=', 'raffle_draws.id')
        ->select(
            'order_detail.*',
            'raffle_draws.draw_title'
        );
        if($request->view_all){
            $orders = $orders->get();
        }else{
            if($request->from_date && $request->to_date){
                $from_date = Carbon::parse($request->from_date);
                $to_date = Carbon::parse($request->to_date);
                $orders->whereBetween('order_detail.created_at', [$from_date, $to_date]);
    
            }else{
                $orders->whereDate('order_detail.created_at', Carbon::today());
            }
            $orders = $orders->get();
        }


       
           

        // dd($orders);

        return view('admin.my-orders', compact('orders'));
    }

}
