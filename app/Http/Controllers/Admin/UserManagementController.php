<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\DepositRequest;
use App\Models\WithdrawalRequest;
use App\Mail\NewPasswordEmail;
use Validator;
use Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index()
    {
     
        $users = User::orderBy('updated_at', 'desc')->where('user_role', 'User')->get();
        return view('admin.userManagement.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.userManagement.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            
        ]);

        $destinationPath = public_path().'/admin/uploads';
        
        $imagePath ='';
        if($request->file('profile_image')){
            $imageName = '_'.time().'_'.$request->profile_image->getClientOriginalName(); 
            $request->profile_image->move($destinationPath, $imageName);
            $imagePath = 'admin/uploads/'.$imageName;
        }

        // Generate a random password
        $password = Str::random(12);

        $user = User::create([
            'profile_image' => $imagePath,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'user_role' => 'User',
            'phone_number' => $request->phone_number,
            'viber' => $request->viber,
            'fb_messenger' => $request->fb_messenger,
            'password' => Hash::make($password),
        ]);

        $data = [
            'password' => $password,
            'first_name' => $request->first_name,
            'change_password' => url('/').'/change-password',
        ];

        // Send the user an email with their new password
        Mail::to($user->email)->send(new NewPasswordEmail($data));
        

        return redirect()->route('user-management.edit', $user->id)->with('success', 'Created Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $user = User::where('id', $id)->where('user_role', 'User')->first();
        $ttl_deposit =  DepositRequest::where('user_id', $id)
            ->where('status', 'Approved')
        ->sum('amount');

        $ttl_withdrawal =  WithdrawalRequest::where('user_id', $id)
            ->where('status', 'Approved')
        ->sum('amount');
        
        $ip_address =  $request->ip();
        $order = Order::where('user_id', $id)->get()->count();

        return view('admin.userManagement.view', compact('user','ttl_deposit', 'ttl_withdrawal','order', 'ip_address'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::where('id', $id)->where('user_role', 'User')->first();
        return view('admin.userManagement.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
        ]);

        $destinationPath = public_path().'/admin/uploads';

        $profilePath ='';
        $user =  User::where('id',  $id)->first();
        if($request->file('profile_image')){
            
            if($user->profile_image){
                File::delete($destinationPath.'/'.$user->profile_image);
            } 
            $imageName = $id.'_'.time().'_'.$request->profile_image->getClientOriginalName(); 
            $request->profile_image->move($destinationPath, $imageName);
            $profilePath = 'admin/uploads/'.$imageName;
        }
      
        User::where('id', $id)->update([
            'profile_image' => $profilePath ? $profilePath : $user->profile_image,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'viber' => $request->viber,
            'fb_messenger' => $request->fb_messenger,

        ]);
       
        return back()->with('success', 'Updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $users = User::where('id', $id)->delete();
        return back()->with('success', 'Deleted Successfully!');
    }
    
    public function WalletBalance($id){
        
        $wallet = User::where('id', $id)->first();
        return view('admin.userManagement.wallet', compact('wallet'));
    }
    
    public function UpdateWalletBalance(Request $request, $id){
        
        $this->validate($request, [
            'method_name' => ['required', 'string'],
            'wallet_balance' => ['required', 'numeric'],
        ]);
        
        $wallet = User::where('id', $id)->select('wallet_balance')->first();
        
        if($request->method_name == 'Withdraw' && $wallet->wallet_balance < $request->wallet_balance ){
            return back()->withErrors(['wallet_balance' => 'Please check your wallet balance.']);
        } 
        
        
        
        if($request->method_name == 'Withdraw' ){
            User::where('id', $id)->update(['wallet_balance' => $wallet->wallet_balance - $request->wallet_balance ]);
        } 
        
         
        if($request->method_name == 'Deposit' ){
             User::where('id', $id)->update(['wallet_balance' => $wallet->wallet_balance + $request->wallet_balance ]);
        } 
        
       
        
        return redirect()->route('user-management.index');
    }
}
