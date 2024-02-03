<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\RaffleDraw;
use App\Models\DepositRequest;
use App\Models\WithdrawalRequest;
use App\Models\User;
use App\Models\Transactions;
use App\Models\RafflePrizes;
use App\Models\RaffleResult;
use App\Models\Order;
use App\Models\WithdrawalManagement;
use App\Models\UserWithdrawalMethod;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Mail;
use Illuminate\Support\Facades\DB; 
use App\Mail\UserResetPasswordNotification;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
     public function index()
    {
        $total_deposit =  DepositRequest::where('user_id', auth()->guard('web')->user()->id)
            ->where('status', 'Approved')
        ->sum('amount');

        $total_withdrawal =  WithdrawalRequest::where('user_id', auth()->guard('web')->user()->id)
            ->where('status', 'Approved')
        ->sum('amount');

        $total_raffle = Order::leftjoin('order_detail', 'order.id', '=', 'order_detail.order_id')
            ->whereIn('order.user_id', [auth()->guard('web')->user()->id])->get()->groupBy('raffle_id')
        ->count();

        $transactions = Transactions::where('user_id', auth()->guard('web')->user()->id)->get();
        // dd($transactions);

        return view('home', compact('total_raffle', 'total_withdrawal', 'total_deposit','transactions'));
    }

    public function MyProfile(Request $request)
    {
        $data = auth()->guard('web')->user();
        $withdrawal_management = WithdrawalManagement::orderBy('id', 'desc')->get();

        return view('my-profile', compact('data', 'withdrawal_management'));
    }

    public function UpdateProfile(Request $request)
    {
       

        $this->validate($request, [
            'first_name' => ['required'],
            'last_name' => ['required'],
        ]);

        $destinationPath = public_path().'/admin/uploads';
        
        $imagePath ='';
        if($request->file('profile_image')){
            $imageName = '_'.time().'_'.$request->profile_image->getClientOriginalName(); 
            $request->profile_image->move($destinationPath, $imageName);
            $imagePath = 'admin/uploads/'.$imageName;
        }

        User::where('id', auth()->guard('web')->user()->id)->update([

            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
            'viber' => $request->viber,
            'fb_messenger' => $request->fb_messenger,
            'profile_image' => $imagePath ? $imagePath : auth()->guard('web')->user()->profile_image,
        ]);

        if($request->payout_info){

            $destinationPath = public_path().'/uploads/proofs/';
            $qr_path = null;
            if($request->file('qr_code')){
                if($request->file('qr_code')){
                    $imageName = '_'.time().'_'.$request->qr_code->getClientOriginalName(); 
                    $request->qr_code->move($destinationPath, $imageName);
                    $qr_path = 'uploads/proofs/'.$imageName;
                }
            }

            $user_withdrawal = UserWithdrawalMethod::where('user_id', auth()->guard('web')->user()->id)->where('method_id', $request->method_id)->first();
            if($user_withdrawal){
                UserWithdrawalMethod::where('id', $user_withdrawal->id)->update([
                    'account_name' => $request->account_name,
                    'user_id' => auth()->guard('web')->user()->id,
                    'account_number' => $request->account_number,
                    'bank_name' => $request->bank_name,
                    'qr_code' => $qr_path,
                    'method_id' => $request->method_id
                ]);
            }else{
                UserWithdrawalMethod::create([
                    'account_name' => $request->account_name,
                    'account_number' => $request->account_number,
                    'bank_name' => $request->bank_name,
                    'qr_code' => $qr_path,
                    'method_id' => $request->method_id,
                    'user_id' => auth()->guard('web')->user()->id,
                ]);
            }

    

        }

        return back()->with('success', 'Profile updated successfully.');
    }

    public function ChangePassword(Request $request)
    {
        return view('change-password');
    }

    public function UpdatePassword(Request $request)
    {
        $this->validate($request, [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::where('id', auth()->guard('web')->user()->id)->update([ 'password' => Hash::make($request->password)]);
        return back()->with('success', 'Password changed successfully');
    }
    
    public function PasswordReset(Request $request){
        dd('ok');
        return view('auth.passwords.email');
    }
    
    public function UserResetPassword(Request $request)
    {
        dd($request->all());
        $this->validate($request, [
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        $user = User::where('email', $request->email)->where('user_role','User')->first();
        if(!$user) return back()->with('error', "We can't find a user with that email address.");
        $token = Str::random(60);
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' =>  $token,
            'created_at' =>  Carbon::now(),
        ]);
        $data = [
            'first_name' => $user->first_name,
            'reset-link' => url('/').'/password/confirm-password?token='.$token.'&email='.$request->email,
        ];
        
        Mail::to($user->email)->send(new UserResetPasswordNotification($data));
        return back()->with('status', "We have emailed your password reset link!"); 
        
    }
    
    public function Orders(){
        $orders = OrderDetail::leftjoin('order', 'order_detail.order_id', '=', 'order.id')
        ->leftjoin('raffle_draws', 'order_detail.raffle_id', '=', 'raffle_draws.id')
        ->where('order.user_id', auth()->guard('web')->user()->id)->select(
            'order_detail.*',
            'raffle_draws.draw_title'
        )->get();

        return view('my-orders', compact('orders'));
    }

    public function UserMethodDetail(Request $request)
    {
        if($request->method_id){
            $user_withdrawal_methods = UserWithdrawalMethod::where('method_id', $request->method_id)->where('user_id', auth()->guard('web')->user()->id)->first();

            return response()->json([
                'status' => 200,
                'data' => $user_withdrawal_methods,
                'message' => 'User method details fatched successfully',
            ]);
        }else{
            return response()->json([
                'status' => 400,
                'message' => 'Method id is required.', 
            ]);
        }
    }

    public function ClaimPrize(Request $request, $id)
    {
       $prize = RafflePrizes::where('id', $id)->first();
    //    dd($prize);
       return view('claimPrize', compact('prize'));
    }

    public function SaveClaimPrize(Request $request, $id)
    {
        RaffleResult::where('prize_id', $id)->update([
            'user_choice' => $request->prize_choose,
        ]);

        return redirect()->route('raffle-winner')->with('success', 'Prize claimed successfully');
    }
}
