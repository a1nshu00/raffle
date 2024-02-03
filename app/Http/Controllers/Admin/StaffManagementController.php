<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\DepositRequest;
use App\Models\StaffLog;
use App\Models\WithdrawalRequest;
use App\Mail\NewPasswordEmail;
use Validator;
use Carbon\Carbon;
use Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class StaffManagementController extends Controller
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
        $staffs = User::orderBy('updated_at', 'desc')->where('user_role', 'Admin')->get();
        return view('admin.staffManagement.index', compact('staffs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.staffManagement.create');
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
            'password' => ['required', 'string', 'min:8', 'confirmed']  
        ]);
    
        $staff = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'user_role' => 'Admin',
            'password' => Hash::make($request->password),
        ]);
        $staffs = User::orderBy('updated_at', 'desc')->where('user_role', 'Admin')->get();

        return redirect()->route('staff-management.index');
        // return redirect()->route('staff-management.edit', $staff->id)->with('success', 'Created Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $staff = User::where('id', $id)->where('user_role', 'Admin')->first();
        return view('admin.staffManagement.edit', compact('staff'));
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
        // $staff = User::where('id', $id)->first();
        if($request->email == $staff->email){
            $this->validate($request, [
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
            ]);
        }else{
            $this->validate($request, [
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            ]);
        }
      
        User::where('id', $id)->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email
        ]);
       
        return back()->with('success', 'Updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $staff = User::where('id', $id)->delete();
        return back()->with('success', 'Deleted Successfully!');
    }

    public function StaffLog(Request $request, $id){
        $logs = StaffLog::where('staff_id', $id);
        if($request->from_date && $request->to_date){
            $from_date = Carbon::parse($request->from_date);
            $to_date = Carbon::parse($request->to_date);
            $logs->whereBetween('created_at', [$from_date, $to_date]);
        }
        $logs = $logs->get();
        return view('admin.staffManagement.logs', compact('logs'));
    }
}
