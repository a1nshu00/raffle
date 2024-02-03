<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\RaffleDraw;
use App\Models\ContactUS;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB; 
use App\Mail\UserResetPasswordNotification;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    
    public function PasswordReset(Request $request){
        return view('auth.passwords.email');
    }
    
    public function UserResetPassword(Request $request)
    {
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
            'reset-link' => url('/').'/password-confirm?token='.$token.'&email='.$request->email,
        ];
        
        Mail::to($user->email)->send(new UserResetPasswordNotification($data));
        return back()->with('success', "We have emailed your password reset link!");    
    }

    public function ConfirmPassword(Request $request)
    {
        $token = $request->token;
        $email = $request->email;
        return view('auth.passwords.reset', compact('token','email'));
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
                if(auth()->guard('web')->attempt(['email' => $request->input('email'),  'password' => $request->input('password')])){
                    $user = auth()->guard('web')->user();
                    if($user->user_role == 'User'){
                        return redirect()->route('dashboard')->with('success','You are Logged in sucessfully.');
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
    
    public function StoreContactUs(Request $request)
    {

        $request->validate([
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'subject' => ['required', 'string'],
            'message' => ['required', 'string'],
        ]);

        
        ContactUS::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);
        return back()->with('success', 'submit successfully.');
    }
}
