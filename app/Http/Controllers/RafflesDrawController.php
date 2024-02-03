<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\RaffleDraw;
use App\Models\RafflePrizes;
use App\Models\RaffleResult;
use App\Models\User;
use App\Models\UserWithdrawalMethod;
use App\Models\Order;
use App\Models\DepositChannel;
use App\Models\DepositRequest;
use App\Models\WithdrawalManagement;
use App\Models\WithdrawalRequest;
use App\Models\OrderDetail;
use App\Models\Transactions;
use Carbon\Carbon;

class RafflesDrawController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
    */
     
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
     
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $now = Carbon::now();
        $raffle_draw = RaffleDraw::where('status', 'Active')
        ->whereRaw("STR_TO_DATE(draw_time, '%Y-%m-%dT%H:%i') > ?", [$now->format('Y-m-d H:i')])
        ->select('id', 'draw_title', 'type', 'draw_time')
        ->get();
        return view('raffle-draws', compact('raffle_draw'));
    }
    
    public function Detail($id){
         
        $disbaled_balls = [];
        $purchased_balls = OrderDetail::whereIn('raffle_id', [$id])->get();
        
        foreach ($purchased_balls as $key => $value) {
           $disbaled_balls[] = $value->ball_number;
        }
        $raffle_draw = RaffleDraw::where('id', $id)->first()->toArray();
        $draw_prize  = RafflePrizes::whereIn('raffle_id', [$id])->get()->toArray();
        $raffle_draw['prizes'] = $draw_prize;
        
       
        return view('raffle-draw-detail', compact('raffle_draw','disbaled_balls'));
    }
    
    public function BallsChoose(Request $request){
    
        
        $data = [];
        $data['buying_amount'] = $request->buying_amount;
        $data['raffle_id'] = $request->raffle_id;
        $data['total_amount'] = number_format($request->buying_amount * count($request->check_ball), 2);
        $data['chosen_balls'] = $request->check_ball;
        
        $user = auth()->guard('web')->user();
        if($user){
            $data['authenticated'] = 1; 
            $data['wallet_balance'] = $user->wallet_balance;
            if(number_format($request->buying_amount * count($request->check_ball), 2) > $user->wallet_balance){
                $data['flag'] = 'add_funds';
            }else{
                $data['flag'] = 'pay_now';
            }
        }else{
            $data['authenticated'] = 0; 
        }
        
        
        return view('checkout', compact('data'));
    }
    
    public function OrderRaffle(Request $request){
        if(auth()->guard('web')->check()){
            
            $order = Order::create([
                'user_id' => auth()->guard('web')->user()->id,
                'total_buying_amount' => $request->amount * count($request->ball_number),
            ]);
            
            foreach($request->ball_number as $key => $value)
            {
                $order_detail = OrderDetail::create([
                    'order_id' => $order->id,
                    'raffle_id' => $request->raffle_id,
                    'ball_number' => $value,
                    'amount' => $request->amount,
                    
                ]);

                RaffleResult::where('winning_ball', $value)->update([
                    'user_id' => auth()->guard('web')->user()->id,
                    'order_id' => $order->id
                ]);
            }
            
            $transaction = Transactions::create([
                'order_id' => $order->id,
                'user_id' => auth()->guard('web')->user()->id,
                'transaction_id' => 'ABC-123DD',
                'type' => 'Purchased',
                'status' => 1,
                'amount' => $request->amount * count($request->ball_number),
            ]);
            User::where('id', auth()->guard('web')->user()->id)->update(['wallet_balance' => auth()->guard('web')->user()->wallet_balance - ($request->amount * count($request->ball_number))]);
            return redirect()->route('raffle-draws')->with('success', 'Payment successfully');
        }else{
            return redirect()->route('login');
        }
    }

    public function AddFund(Request $request)
    {
        if(auth()->guard('web')->check()){
            $data = $request->all();
            $deposit_channel = DepositChannel::orderBy('id', 'desc')->get();
            $deposit_requests = DepositRequest::leftjoin('deposit_channels', 'deposit_requests.channel_id', '=', 'deposit_channels.id')->where('deposit_requests.user_id', auth()->guard('web')->user()->id)
            ->select('deposit_requests.*', 'deposit_channels.channel_type', 'deposit_channels.fee_type', 'deposit_channels.fee')->get();
            return view('add-funds', compact('deposit_channel','data','deposit_requests'));
        }else{
            return redirect()->route('login');
        }
    }

    public function StoreFunds(Request $request)
    {
        if(auth()->guard('web')->check()){
            
            if($request->amount < $request->min_amount){
                return back()->with('error', 'Amount must greater than minimum amount.');
            }
    
            $destinationPath = public_path().'/uploads/proofs/';
            $imagePath ='';
            if($request->file('screenshot')){
                $imageName = '_'.time().'_'.$request->screenshot->getClientOriginalName(); 
                $request->screenshot->move($destinationPath, $imageName);
                $imagePath = 'uploads/proofs/'.$imageName;
            }
            DepositRequest::create([
                'user_id' => auth()->guard('web')->user()->id,
                'channel_id' => $request->channel_id,
                'amount' => $request->amount,
                'screenshot' => $imagePath,
                'fee' => $request->hidden_fee, 
            ]);
            return back()->with('success', 'Request submit successfully.');
        }else{
            return redirect()->route('login');
        }

    }

    public function DepositChannelDetail(Request $request)
    {
     
        $data = DepositChannel::where('id', $request->channel_id)->first();
        return response()->json([
            'status' => 200,
            'message' => 'Deposit channel detail fatched successfully',
            'data' => $data,
        ]);
    }

    public function WithdrawalRequest(Request $request)
    {
        if(auth()->guard('web')->check()){
            
            $withdrawal_management =WithdrawalManagement::orderBy('id', 'desc')->get();
            $withdrawal_requests  = WithdrawalRequest::leftjoin('withdrawal_management', 'withdrawal_requests.channel_id', '=', 'withdrawal_management.id')->where('withdrawal_requests.user_id', auth()->guard('web')->user()->id)
            ->select('withdrawal_requests.*', 'withdrawal_management.name')->get();
            return view('withdrawal-request', compact('withdrawal_management', 'withdrawal_requests'));
        }else{
            return redirect()->route('login');
        }
    }

    public function WithdrawalManagementDetail(Request $request)
    {
        $data = WithdrawalManagement::where('id', $request->channel_id)->first();
        $user_withdrawal_methods = UserWithdrawalMethod::where('method_id', $request->channel_id)->where('user_id', auth()->guard('web')->user()->id)->first();
        return response()->json([
            'status' => 200,
            'message' => 'Withdrawal channel detail fatched successfully',
            'data' => $data,
            'user_withdrawal_detail' => $user_withdrawal_methods,
        ]);
    }

    public function StoreWithdrawalRequest(Request $request)
    {

        if(auth()->guard('web')->check()){
            
            // Validations
            if($request->amount  > $request->wallet_balance){
                return back()->with('error', 'Amount must less than wallet balance.');
            }
            if($request->amount < $request->min_amount){
                return back()->with('error', 'Amount must greater than minimum amount.');
            }
    
            if($request->method_name != 'Bank'){

                // $imagePath ='';
                // if($request->file('qr_code')){
                //     $destinationPath = public_path().'/uploads/proofs/';
                //     if($request->file('qr_code')){
                //         $imageName = '_'.time().'_'.$request->qr_code->getClientOriginalName(); 
                //         $request->qr_code->move($destinationPath, $imageName);
                //         $imagePath = 'uploads/proofs/'.$imageName;
                //     }
                // }

                // User withdrawal methods  update
                $user_withdrawal_methods = UserWithdrawalMethod::where('user_id', auth()->guard('web')->user()->id)->where('method_id', $request->channel_id)->first();
                if($user_withdrawal_methods){
                    UserWithdrawalMethod::where('id', $user_withdrawal_methods->id)->update([
                        'account_name' => $request->account_name_,
                        'account_number' => $request->e_wallet_account_number,
                        // 'qr_code' => $imagePath ? $imagePath : $user_withdrawal_methods->qr_code,
                        'method_id' => $request->channel_id,
                    ]);
                }else{
                    UserWithdrawalMethod::create([
                        'user_id' => auth()->guard('web')->user()->id,
                        'account_name' => $request->account_name_,
                        'account_number' => $request->e_wallet_account_number,
                        // 'qr_code' => $imagePath ? $imagePath : $user_withdrawal_methods->qr_code,
                        'method_id' => $request->channel_id,
                    ]);
                }
                WithdrawalRequest::create([
                    'user_id' => auth()->guard('web')->user()->id,
                    'channel_id' => $request->channel_id,
                    'amount' => $request->amount,
                    'account_name' => $request->account_name_, 
                    'account_number' => $request->e_wallet_account_number, 
                    // 'qr_code' => $imagePath ? $imagePath : $user_withdrawal_methods->qr_code,
                ]);
            }else{
                $user_withdrawal_methods = UserWithdrawalMethod::where('user_id', auth()->guard('web')->user()->id)->where('method_id', $request->channel_id)->first();
                
                if($user_withdrawal_methods){
                    UserWithdrawalMethod::where('id', $user_withdrawal_methods->id)->update([
                        'account_name' => $request->account_name,
                        'account_number' => $request->account_number,
                        'bank_name' => $request->bank_name,
                        'method_id' => $request->channel_id,
                    ]);
                }else{
                    UserWithdrawalMethod::create([
                        'user_id' => auth()->guard('web')->user()->id,
                        'account_name' => $request->account_name,
                        'account_number' => $request->account_number,
                        'bank_name' => $request->bank_name,
                        'method_id' => $request->channel_id,
                    ]);
                }
                WithdrawalRequest::create([
                    'user_id' => auth()->guard('web')->user()->id,
                    'channel_id' => $request->channel_id,
                    'amount' => $request->amount,
                    'account_name' => $request->account_name, 
                    'account_number' => $request->account_number, 
                    'bank_name' => $request->bank_name,  
                ]);
            }
            return back()->with('success', 'Request submit successfully.');
        }else{
            return redirect()->route('login');
        }
    }

    public function Transactions(Request $request)
    {
        if(auth()->guard('web')->check()){
            
            $transaction = Transactions::where('user_id', auth()->guard('web')->user()->id)->get();
            return view('transactions', compact('transaction'));
        }else{
            return redirect()->route('login');
        }
    }
    
    public function RaffleWinner(Request $request)
    {
       if(auth()->guard('web')->check()){
            $now = Carbon::now();
           
            $raffle_results = RaffleResult::leftjoin('raffle_prizes', 'raffle_results.prize_id', '=', 'raffle_prizes.id')
                ->leftjoin('raffle_draws', 'raffle_results.raffle_id', '=', 'raffle_draws.id')
                ->whereRaw("STR_TO_DATE(raffle_draws.draw_time, '%Y-%m-%dT%H:%i') < ?", [$now->format('Y-m-d H:i')])
                ->where('raffle_results.user_id', auth()->guard('web')->user()->id)
                ->select(
                    'raffle_results.winning_ball',
                    'raffle_prizes.prize_name',
                    'raffle_prizes.physical_prize_image',
                    'raffle_prizes.cash_prize',
                    'raffle_prizes.physical_prize',
                    'raffle_draws.draw_title',
                    'raffle_draws.draw_time',
                    'raffle_results.prize_id',
                    'raffle_results.user_choice'
                );
            if($request->from_date && $request->to_date){
                $raffle_results->whereBetween('raffle_draws.draw_time', [$request->from_date, $request->to_date]);
            }


            $raffle_results = $raffle_results->get();
            // dd($raffle_results);
            return view('winners', compact('raffle_results'));
        }else{
            return redirect()->route('login');
        }
    }
    public function LatestResult(Request $request)
    {
        $now = Carbon::now();
        $raffle_results = RaffleResult::leftjoin('raffle_prizes', 'raffle_results.prize_id', '=', 'raffle_prizes.id')
            ->leftjoin('raffle_draws', 'raffle_results.raffle_id', '=', 'raffle_draws.id')
            ->where('raffle_results.user_id', '!=', null)
            ->whereRaw("STR_TO_DATE(raffle_draws.draw_time, '%Y-%m-%dT%H:%i') < ?", [$now->format('Y-m-d H:i')])
            ->leftjoin('users', 'raffle_results.user_id', '=', 'users.id')
            ->select(
                'raffle_results.winning_ball',
                'raffle_prizes.prize_name',
                'raffle_prizes.physical_prize_image',
                'raffle_prizes.cash_prize',
                'raffle_prizes.physical_prize',
                'raffle_draws.draw_title',
                'raffle_draws.draw_time',
                'users.first_name',
                'users.last_name',
                'users.profile_image'
            )
        ->get();
        return view('latest-results', compact('raffle_results'));
    }
}
