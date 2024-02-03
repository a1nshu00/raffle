<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WithdrawalManagement;
use App\Models\WithdrawalRequest;
use App\Models\Transactions;
use App\Models\User;
use App\Models\StaffLog;
use App\Mail\ApproveWithdrawalRequest;
use App\Mail\RejectWithdrawalRequest;
use Validator;
use Carbon\Carbon;
use Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class WithdrawalChannelController extends Controller
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
        $withdrawal_channel = WithdrawalManagement::orderBy('updated_at', 'desc')->get();
        return view('admin.withdrawalChannel.index', compact('withdrawal_channel'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.withdrawalChannel.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'method_name' => ['required'],
            'fee' => ['required', 'numeric'],
            'min_amount' => ['required', 'numeric'],
        ]); 
        $withdrawal_channel = WithdrawalManagement::create([
            'fee' => $request->fee,
            'name' => $request->method_name,
            'min_amount' => $request->min_amount,
        ]);
        StaffLog::create([
            'staff_id' => auth()->guard('admin')->user()->id,
            'activity_name' => 'Withdrawal Channel Created',
            'message' => 'Withdrawal channel created by '.auth()->guard('admin')->user()->first_name.' at '. Carbon::now()->format('M d-Y h:i A'),
            'log_time' => Carbon::now(),
        ]);
        return redirect()->route('withdrawal-channel.edit', $withdrawal_channel->id)->with('success', 'Created Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
        $withdrawal_channel = WithdrawalManagement::where('id', $id)->first();
        return view('admin.withdrawalChannel.edit', compact('withdrawal_channel'));
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
        // dd($request->all());
        $this->validate($request, [
            'method_name' => ['required'],
            'fee' => ['required', 'numeric'],
            'min_amount' => ['required','numeric'],
            
        ]);     
        $withdrawal_channel = WithdrawalManagement::where('id', $id)->update([
            'fee' => $request->fee,
            'name' => $request->method_name,
            'min_amount' => $request->min_amount,
        ]);
        StaffLog::create([
            'staff_id' => auth()->guard('admin')->user()->id,
            'activity_name' => 'Withdrawal Channel Updated',
            'message' => 'Withdrawal channel updated by '.auth()->guard('admin')->user()->first_name.' at '. Carbon::now()->format('M d-Y h:i A'),
            'log_time' => Carbon::now(),
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
        $users = WithdrawalManagement::where('id', $id)->delete();
        StaffLog::create([
            'staff_id' => auth()->guard('admin')->user()->id,
            'activity_name' => 'Withdrawal Channel Deleted',
            'message' => 'Withdrawal channel deleted by '.auth()->guard('admin')->user()->first_name.' at '. Carbon::now()->format('M d-Y h:i A'),
            'log_time' => Carbon::now(),
        ]);
        return back()->with('success', 'Deleted Successfully!');
    }
    
     public function WithdrawalRequest(Request $request)
    {
        
        $tab_active = $request->tab_active;

        // Pending Data
        $withdrawal_request_pending = WithdrawalRequest::
        leftjoin('users', 'withdrawal_requests.user_id', '=', 'users.id')
        ->leftjoin('withdrawal_management', 'withdrawal_requests.channel_id', '=', 'withdrawal_management.id')
        ->orderBy('withdrawal_requests.updated_at', 'desc')
        ->where('withdrawal_requests.status', 'Pending')
        ->select(
            'users.first_name',
            'users.email',
            'users.wallet_balance',
            'withdrawal_requests.*',
            'withdrawal_management.name'
        );

        $pending_withdrawal_amount = '';
        if ($tab_active == '#pending') {
            if (!$request->view_all) {
                if ($request->withdrawal_methods) {
                    $withdrawal_request_pending->where('withdrawal_requests.channel_id', $request->withdrawal_methods);
                }
                
                if ($request->from_date && $request->to_date) {
                    $from_date = Carbon::createFromFormat('Y-m-d', $request->from_date)->setTimezone('UTC');
                    $to_date = Carbon::createFromFormat('Y-m-d', $request->to_date)->setTimezone('UTC');
                    
                    $withdrawal_request_pending->whereBetween('withdrawal_requests.created_at', [$from_date, $to_date]);
                
                }
                $withdrawal_request_pending = $withdrawal_request_pending->get();
            }else{
                $withdrawal_request_pending = $withdrawal_request_pending->get();
            }
            $pending_withdrawal_amount = $withdrawal_request_pending->where('status', 'Pending')->sum('amount');
        }else{
            $withdrawal_request_pending->where('withdrawal_requests.created_at', '>=', Carbon::today());
            $withdrawal_request_pending = $withdrawal_request_pending->get();
            $pending_withdrawal_amount = $withdrawal_request_pending->where('status', 'Pending')->sum('amount');
        }


        // Approved Data
        $withdrawal_request_approved = WithdrawalRequest::
        leftjoin('users', 'withdrawal_requests.user_id', '=', 'users.id')
        ->leftjoin('withdrawal_management', 'withdrawal_requests.channel_id', '=', 'withdrawal_management.id')
        ->orderBy('withdrawal_requests.updated_at', 'desc')
        ->where('withdrawal_requests.status', 'Approved')
        ->select(
            'users.first_name',
            'users.email',
            'users.wallet_balance',
            'withdrawal_requests.*',
            'withdrawal_management.name'
        );

        $approved_withdrawal_amount = '';
        if ($tab_active == '#approve') {
            if (!$request->view_all) {
                if ($request->withdrawal_methods) {
                    $withdrawal_request_approved->where('withdrawal_requests.channel_id', $request->withdrawal_methods);
                }
                
                if ($request->from_date && $request->to_date) {
                    $from_date = Carbon::createFromFormat('Y-m-d', $request->from_date)->setTimezone('UTC');
                    $to_date = Carbon::createFromFormat('Y-m-d', $request->to_date)->setTimezone('UTC');
                    
                    $withdrawal_request_approved->whereBetween('withdrawal_requests.created_at', [$from_date, $to_date]);
                
                }
                $withdrawal_request_approved = $withdrawal_request_approved->get();
            }else{
                $withdrawal_request_approved = $withdrawal_request_approved->get();
            }
            $approved_withdrawal_amount = $withdrawal_request_approved->where('status', 'Approved')->sum('amount');
        }else{
            $withdrawal_request_approved->where('withdrawal_requests.created_at', '>=', Carbon::today());
            $withdrawal_request_approved = $withdrawal_request_approved->get();
            $approved_withdrawal_amount = $withdrawal_request_approved->where('status', 'Approved')->sum('amount');
        }

       
        
        $withdrawal_request_rejected = WithdrawalRequest::
        leftjoin('users', 'withdrawal_requests.user_id', '=', 'users.id')
        ->leftjoin('withdrawal_management', 'withdrawal_requests.channel_id', '=', 'withdrawal_management.id')
        ->orderBy('withdrawal_requests.updated_at', 'desc')
        ->where('withdrawal_requests.status', 'Rejected')
        ->select(
            'users.first_name',
            'users.email',
            'users.wallet_balance',
            'withdrawal_requests.*',
            'withdrawal_management.name'
        );

        $rejected_withdrawal_amount = '';
        if ($tab_active == '#rejected') {
            if (!$request->view_all) {
                if ($request->withdrawal_methods) {
                    $withdrawal_request_rejected->where('withdrawal_requests.channel_id', $request->withdrawal_methods);
                }
                
                if ($request->from_date && $request->to_date) {
                    $from_date = Carbon::createFromFormat('Y-m-d', $request->from_date)->setTimezone('UTC');
                    $to_date = Carbon::createFromFormat('Y-m-d', $request->to_date)->setTimezone('UTC');
                    
                    $withdrawal_request_rejected->whereBetween('withdrawal_requests.created_at', [$from_date, $to_date]);
                
                }
                $withdrawal_request_rejected = $withdrawal_request_rejected->get();
            }else{
                $withdrawal_request_rejected = $withdrawal_request_rejected->get();
            }
            $rejected_withdrawal_amount = $withdrawal_request_rejected->where('status', 'Rejected')->sum('amount');
        }else{
            $withdrawal_request_rejected->where('withdrawal_requests.created_at', '>=', Carbon::today());
            $withdrawal_request_rejected = $withdrawal_request_rejected->get();
            $rejected_withdrawal_amount = $withdrawal_request_rejected->where('status', 'Rejected')->sum('amount');
        }


       
        $withdrawal_methods = WithdrawalManagement::orderBy('updated_at', 'desc')->get();
        
        return view('admin.withdrawalRequest.index', compact(
            'withdrawal_methods', 
            'withdrawal_request_pending',
            'withdrawal_request_approved',
            'withdrawal_request_rejected', 
            'tab_active',
            'pending_withdrawal_amount',
            'approved_withdrawal_amount',
            'rejected_withdrawal_amount'
        ));
    }
    
    public function UpdateWithdrawalRequest(Request $request, $id){
        if($request->approve == 'Approve'){
            $withdrawal_request = WithdrawalRequest::where('id', $id)->first();
            $user = User::where('id', $withdrawal_request->user_id)->first();
            WithdrawalRequest::where('id', $id)->update(['status' => 'Approved']);
            Transactions::create([
               'user_id' =>  $user->id,
               'transaction_id' => substr(str_shuffle("0123456789"), 0, 12),
               'type' => 'Withdrawal',
               'amount' => $withdrawal_request->amount,
               'status' => 1
            ]);
            User::where('id', $withdrawal_request->user_id)->update(['wallet_balance' => $user->wallet_balance - $withdrawal_request->amount ]);
            $data  = [
                'user' => $user->first_name,
                'amount' => $withdrawal_request->amount,
                'admin_name' => auth()->guard('admin')->user()->first_name,
            ];
            Mail::to($user->email)->send(new ApproveWithdrawalRequest($data));
            StaffLog::create([
                'staff_id' => auth()->guard('admin')->user()->id,
                'activity_name' => 'Withdrawal Request Approved',
                'message' => 'Withdrawal request approved by '.auth()->guard('admin')->user()->first_name.' at '. Carbon::now()->format('M d-Y h:i A'),
                'log_time' => Carbon::now(),
            ]);
            return back()->with('success', 'Withdrawal request approved.');
            
        }
        if($request->reject == 'rejected'){
            $withdrawal_request = WithdrawalRequest::where('id', $id)->first();
            $user = User::where('id', $withdrawal_request->user_id)->first();
            WithdrawalRequest::where('id', $id)->update(['status' => 'Rejected', 'remarks' => $request->remarks]);
            $data  = [
                'user' => $user->first_name,
                'amount' => $withdrawal_request->amount,
                'admin_name' => auth()->guard('admin')->user()->first_name,
                'remarks' => $request->remarks,
            ];
            Mail::to($user->email)->send(new RejectWithdrawalRequest($data));
            StaffLog::create([
                'staff_id' => auth()->guard('admin')->user()->id,
                'activity_name' => 'Withdrawal Request Rejected',
                'message' => 'Withdrawal request rejected by '.auth()->guard('admin')->user()->first_name.' at '. Carbon::now()->format('M d-Y h:i A'),
                'log_time' => Carbon::now(),
            ]);
            return back()->with('success', 'Withdrawal request rejected.');
        }
       
    }
}
