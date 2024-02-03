<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Carbon\Carbon;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
     
    public function login(Request $request){
        $user = User::where('email', $request->email)->where('user_role', 'User')->first();
        if(!$request->check_out){
            if(!$request->email){
                return redirect('/login')->with('email','The email is required field.');
            }
            if(!$user){
                return redirect('/login')->with('email','Whoops! invalid email and password.');
            }
            if(!$request->password){
                return redirect('/login')->with('password','The password is required field.');
            }
            if(!auth()->guard('web')->attempt(['email' => $request->input('email'),  'password' => $request->input('password')])){
                return redirect('/login')->with('email','Whoops! invalid email and password.');
            }
        }
        if($user){
           
            if(auth()->guard('web')->attempt(['email' => $request->input('email'),  'password' => $request->input('password')])){
                $user = auth()->guard('web')->user();
    
                if($user->user_role == 'User'){
                    User::where('id', $user->id)->update([
                        'last_login_time' => Carbon::now(), 
                        'ip_address' => $request->ip()]);
                    if($request->check_out){
                        if($user->wallet_balance >= $request->total_buying_amount ){
                            $user->btn_txt = 'Pay Now';
                        }else{
                            $user->btn_txt = 'Add funds';
                        }
                        return response()->json([
                            'status' => 200,
                            'message' => 'login successfully',
                            'data' =>  $user,
                        ]);
                    }else{
                        return redirect('/dashboard')->with('success','You are Logged in sucessfully.');
                    }
                }
            }else {
                if($request->check_out){
                    return response()->json([
                        'status' => 400,
                        'message' => 'Something went wrong',
                    ]);
                }else{
                    return redirect()->back()->with('error','Whoops! invalid email and password.');
                }
            }
        }else {
            
            if($request->check_out){
              
                return response()->json([
                    'status' => 400,
                    'message' => 'Whoops! invalid email and password.',
                ]);
            }else{
                return redirect('/login')->with('email','Whoops! invalid email and password.');
            }
        }
    }
     
     
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
