<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'user_role' => 'User',
            'password' => Hash::make($data['password']),
            
        ]);
    
    }
    
    public function UserRegister(Request $request){
        $usr = User::where('email', $request->email)->first();
        if($usr){
            return response()->json([
                'status' => 400,
                'message' => 'email already taken'
            ]);
        }
        $user =  User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_role' => 'User',
            
        ]);
        
        
        
        if(auth()->guard('web')->attempt(['email' => $request->input('email'),  'password' => $request->input('password')])){
            $user = auth()->guard('web')->user();
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
            return response()->json([
                'status' => 401,
                'message' => 'Something went wrong',
            ]);
        }
        return response()->json([
            'status' => 200,
            'messge' => 'User registered successfully',
            'data' => $data,
        ]);
    }
}
