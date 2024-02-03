<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DepositChannel;
use App\Models\DepositRequest;
use App\Models\User;
use App\Models\Transactions;
use App\Models\StaffLog;
use Validator;
use Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Mail\ApproveDepositRequest;
use App\Mail\RejectDepositRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DepositChannelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $DepositChannel = DepositChannel::orderBy('updated_at', 'desc')->get();
        return view('admin.depositChannel.index', compact('DepositChannel'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.depositChannel.create');
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
        if($request->channel_type == 'Bank'){
            $this->validate($request, [
                'bank_name' => ['required', 'string', 'max:255'],
                'account_number' => ['required','numeric', 'digits_between:9,18'],
                'account_name' => ['required', 'string '],
                'channel_type' => ['required'],
                'name' => ['required'],
                'fee' => ['required','numeric'],
                'min_amount' => ['required','numeric'],
            ]);     
            $DepositChannel = DepositChannel::create([
                'bank_name' => $request->bank_name,
                'account_name' => $request->account_name,
                'account_number' => $request->account_number,
                'channel_type' => $request->channel_type,
                'name' => $request->name,
                'min_amount' => $request->min_amount,
                'fee' => $request->fee,
                'fee_type' => $request->fee_type,
            ]);
        }
        if($request->channel_type == 'E-wallet'){
            $this->validate($request, [
                // 'qr_code' => ['required'],
                'fee' => ['required','numeric'],
                'e_wallet_account_number' => ['required','numeric'],
                'account_name' => ['required', 'string'],
                'channel_type' => ['required'],
                'name' => ['required'],
                'min_amount' => ['required','numeric'],
            ]);   
            $destinationPath = public_path().'/admin/qr';
            $imagePath ='';
            if($request->file('qr_code')){
                $imageName = '_'.time().'_'.$request->qr_code->getClientOriginalName(); 
                $request->qr_code->move($destinationPath, $imageName);
                $imagePath = 'admin/qr/'.$imageName;
            }
            $DepositChannel = DepositChannel::create([
                'qr_code' => $imagePath,
                'fee' => $request->fee,
                'channel_type' => $request->channel_type,
                'name' => $request->name,
                'account_name' => $request->account_name,
                'e_wallet_account_number' => $request->e_wallet_account_number,
                'min_amount' => $request->min_amount,
                'fee_type' => $request->fee_type,
            ]);
        }
        StaffLog::create([
            'staff_id' => auth()->guard('admin')->user()->id,
            'activity_name' => 'Deposit Channel Created',
            'message' => 'Deposit channel created by '.auth()->guard('admin')->user()->first_name.' at '. Carbon::now()->format('M d-Y h:i A'),
            'log_time' => Carbon::now(),
        ]);
        return redirect()->route('deposit-channel.edit', $DepositChannel->id)->with('success', 'Created Successfully');

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
        $DepositChannel = DepositChannel::where('id', $id)->first();
        return view('admin.depositChannel.edit', compact('DepositChannel'));
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
        $deposit_channel = DepositChannel::where('id', $id)->first(); 
        if($request->channel_type == 'Bank'){
            $this->validate($request, [
                'bank_name' => ['required', 'string', 'max:255'],
                'account_number' => ['required','numeric', 'digits_between:9,18'],
                'account_name' => ['required', 'string'],
                'channel_type' => ['required'],
                'name' => ['required'],
                'fee' => ['required', 'numeric'],
                'min_amount' => ['required','numeric'],
            ]);     
            $DepositChannel = DepositChannel::where('id', $id)->update([
                'bank_name' => $request->bank_name,
                'account_name' => $request->account_name,
                'account_number' => $request->account_number,
                'channel_type' => $request->channel_type,
                'name' => $request->name,
                'min_amount' => $request->min_amount,
                'fee' => $request->fee,
                'fee_type' => $request->fee_type,
            ]);
        }
        if($request->channel_type == 'E-wallet'){
            $this->validate($request, [
                'fee' => ['required'],
                'e_wallet_account_number' => ['required','numeric'],
                'account_name' => ['required', 'string'],
                'channel_type' => ['required'],
                'name' => ['required'],
                'min_amount' => ['required','numeric'],
            ]);   
            $destinationPath = public_path().'/admin/qr';
            $imagePath ='';
            if($request->file('qr_code')){
                
                $imageName = '_'.time().'_'.$request->qr_code->getClientOriginalName(); 
                $request->qr_code->move($destinationPath, $imageName);
                $imagePath = 'admin/qr/'.$imageName;
            }
            $DepositChannel = DepositChannel::where('id', $id)->update([
                'qr_code' => $imagePath ? $imagePath : $deposit_channel->qr_code,
                'fee' => $request->fee,
                'channel_type' => $request->channel_type,
                'name' => $request->name,
                'account_name' => $request->account_name,
                'e_wallet_account_number' => $request->e_wallet_account_number,
                'min_amount' => $request->min_amount,
                'fee_type' => $request->fee_type,
            ]);
        }
        StaffLog::create([
            'staff_id' => auth()->guard('admin')->user()->id,
            'activity_name' => 'Deposit Channel Updated',
            'message' => 'Deposit channel updated by '.auth()->guard('admin')->user()->first_name.' at '. Carbon::now()->format('M d-Y h:i A'),
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
        $users = DepositChannel::where('id', $id)->delete();
        StaffLog::create([
            'staff_id' => auth()->guard('admin')->user()->id,
            'activity_name' => 'Deposit Channel Deleted',
            'message' => 'Deposit channel deleted by '.auth()->guard('admin')->user()->first_name.' at '. Carbon::now()->format('M d-Y h:i A'),
            'log_time' => Carbon::now(),
        ]);
        return back()->with('success', 'Deleted Successfully!');
    }

    public function DepositRequest(Request $request)
    {

        $tab_active = $request->tab_active;

        // Approved Data
        $deposit_request_approved = DepositRequest::
        leftjoin('users', 'deposit_requests.user_id', '=', 'users.id')
        ->leftjoin('deposit_channels', 'deposit_requests.channel_id', '=', 'deposit_channels.id')
        ->orderBy('deposit_requests.updated_at', 'desc')
        ->where('deposit_requests.status', 'Approved')
        ->select(
            'users.first_name',
            'users.email',
            'users.wallet_balance', 
            'deposit_requests.*',
            'deposit_channels.channel_type',
            'deposit_channels.account_name',
            'deposit_channels.account_number',
            'deposit_channels.e_wallet_account_number'
        );
        $approved_deposit_amount = '';

        if($tab_active =='#approve'){
           
            if (!$request->view_all) {
                if ($request->deposit_methods) {
                    $deposit_request_approved->where('deposit_requests.channel_id', $request->deposit_methods);
                }
                
                if ($request->from_date && $request->to_date) {
                    $from_date = Carbon::createFromFormat('Y-m-d', $request->from_date)->setTimezone('UTC');
                    $to_date = Carbon::createFromFormat('Y-m-d', $request->to_date)->setTimezone('UTC');
                    
                    $deposit_request_approved->whereBetween('deposit_requests.created_at', [$from_date, $to_date]);
                 
                }
                $deposit_request_approved = $deposit_request_approved->get();
                
            }else{
                $deposit_request_approved = $deposit_request_approved->get();
              
            }
            $approved_deposit_amount = $deposit_request_approved->where('status', 'Approved')->sum('amount');
            
        }else{
            $deposit_request_approved->where('deposit_requests.created_at', '>=', Carbon::today());
            $deposit_request_approved = $deposit_request_approved->get();
            $approved_deposit_amount = $deposit_request_approved->where('status', 'Approved')->sum('amount');
        }

        


        // Pending Data
        $deposit_request_pending = DepositRequest::
        leftjoin('users', 'deposit_requests.user_id', '=', 'users.id')
        ->leftjoin('deposit_channels', 'deposit_requests.channel_id', '=', 'deposit_channels.id')
        ->orderBy('deposit_requests.updated_at', 'desc')
        ->where('deposit_requests.status', 'Pending')
        ->select(
            'users.first_name',
            'users.email',
            'users.wallet_balance', 
            'deposit_requests.*',
            'deposit_channels.channel_type',
            'deposit_channels.account_name',
            'deposit_channels.account_number',
            'deposit_channels.e_wallet_account_number'
        );
        
        $pending_deposit_amount = '';
        if ($tab_active == '#pending') {
            if (!$request->view_all) {
                if ($request->deposit_methods) {
                    $deposit_request_pending->where('deposit_requests.channel_id', $request->deposit_methods);
                }
                
                if ($request->from_date && $request->to_date) {
                    $from_date = Carbon::createFromFormat('Y-m-d', $request->from_date)->setTimezone('UTC');
                    $to_date = Carbon::createFromFormat('Y-m-d', $request->to_date)->setTimezone('UTC');
                    
                    $deposit_request_pending->whereBetween('deposit_requests.created_at', [$from_date, $to_date]);
                
                }
                $deposit_request_pending = $deposit_request_pending->get();
            }else{
                $deposit_request_pending = $deposit_request_pending->get();
            }
            $pending_deposit_amount = $deposit_request_pending->where('status', 'Pending')->sum('amount');
        }else{
            $deposit_request_pending->where('deposit_requests.created_at', '>=', Carbon::today());
            $deposit_request_pending = $deposit_request_pending->get();
            $pending_deposit_amount = $deposit_request_pending->where('status', 'Pending')->sum('amount');
        }


        $deposit_request_rejected = DepositRequest::
        leftjoin('users', 'deposit_requests.user_id', '=', 'users.id')
        ->leftjoin('deposit_channels', 'deposit_requests.channel_id', '=', 'deposit_channels.id')
        ->orderBy('deposit_requests.updated_at', 'desc')
        ->where('deposit_requests.status', 'Rejected')
        ->select(
            'users.first_name',
            'users.email',
            'users.wallet_balance', 
            'deposit_requests.*',
            'deposit_channels.channel_type',
            'deposit_channels.account_name',
            'deposit_channels.account_number',
            'deposit_channels.e_wallet_account_number'
        );

        $rejected_deposit_amount = '';
        if ($tab_active == '#rejected') {
            if (!$request->view_all) {
                if ($request->deposit_methods) {
                    $deposit_request_rejected->where('deposit_requests.channel_id', $request->deposit_methods);
                }
                
                if ($request->from_date && $request->to_date) {
                    $from_date = Carbon::createFromFormat('Y-m-d', $request->from_date)->setTimezone('UTC');
                    $to_date = Carbon::createFromFormat('Y-m-d', $request->to_date)->setTimezone('UTC');
                    
                    $deposit_request_rejected->whereBetween('deposit_requests.created_at', [$from_date, $to_date]);
                
                }
                $deposit_request_rejected = $deposit_request_rejected->get();
            }else{
                $deposit_request_rejected = $deposit_request_rejected->get();
            }
            $rejected_deposit_amount = $deposit_request_rejected->where('status', 'Rejected')->sum('amount');
        }else{
            $deposit_request_rejected->where('deposit_requests.created_at', '>=', Carbon::today());
            $deposit_request_rejected = $deposit_request_rejected->get();
            $rejected_deposit_amount = $deposit_request_rejected->where('status', 'Rejected')->sum('amount');
        }

        $deposit_methods = DepositChannel::orderBy('updated_at', 'desc')->get();
        
        return view('admin.depositRequest.index', compact('deposit_request_approved', 'deposit_request_pending','deposit_request_rejected','tab_active', 'deposit_methods', 'pending_deposit_amount','rejected_deposit_amount','approved_deposit_amount' ));
    }
    
    public function UpdateDepositRequest(Request $request, $id){
        if($request->approve == 'Approve'){
            $depost_request = DepositRequest::where('id', $id)->first();
            $user = User::where('id', $depost_request->user_id)->first();
            DepositRequest::where('id', $id)->update(['status' => 'Approved']);
            Transactions::create([
               'user_id' =>  $user->id,
               'transaction_id' => substr(str_shuffle("0123456789"), 0, 12),
               'type' => 'Deposit',
               'amount' => $depost_request->amount,
               'status' => 1,
            ]);
            User::where('id', $depost_request->user_id)->update(['wallet_balance' => $user->wallet_balance + $depost_request->amount ]);
            $data  = [
                'user' => $user->first_name,
                'amount' => $depost_request->amount,
                'admin_name' => auth()->guard('admin')->user()->first_name,
            ];
            Mail::to($user->email)->send(new ApproveDepositRequest($data));
            StaffLog::create([
                'staff_id' => auth()->guard('admin')->user()->id,
                'activity_name' => 'Deposit Request Approved',
                'message' => 'Deposit request approved by '.auth()->guard('admin')->user()->first_name.' at '. Carbon::now()->format('M d-Y h:i A'),
                'log_time' => Carbon::now(),
            ]);
            return back()->with('success', 'Deposit request approved.');
            
        }
        if($request->reject == 'rejected'){
            
            $depost_request = DepositRequest::where('id', $id)->first();
            $user = User::where('id', $depost_request->user_id)->first();
            DepositRequest::where('id', $id)->update(['status' => 'Rejected', 'remarks' => $request->remarks]);
            $data  = [
                'user' => $user->first_name,
                'amount' => $depost_request->amount,
                'admin_name' => auth()->guard('admin')->user()->first_name,
                'remarks' => $request->remarks,
            ];
            Mail::to($user->email)->send(new RejectDepositRequest($data));
            StaffLog::create([
                'staff_id' => auth()->guard('admin')->user()->id,
                'activity_name' => 'Deposit Request Rejected',
                'message' => 'Deposit request rejected by '.auth()->guard('admin')->user()->first_name.' at '. Carbon::now()->format('M d-Y h:i A'),
                'log_time' => Carbon::now(),
            ]);
            return back()->with('success', 'Deposit request rejected.');
        }
       
    }



}
