<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Transactions;
use Session;
use Carbon\Carbon;

class TransactionHistoryController extends Controller
{
    
    public function Transactions(Request $request)
    {

        $transaction_history = Transactions::orderBy('id', 'desc');
        $purchased_amount = '';
        $deposit_amount = '';
        $withdrawal_amount = '';
        $transaction_type_amount = '';

        if($request->from_date && $request->to_date){
            $from_date = Carbon::parse($request->from_date);
            $to_date = Carbon::parse($request->to_date);
            $transaction_history->whereBetween('created_at', [$from_date, $to_date]);
        }
        
        if($request->transaction_type){
            $transaction_history->where('type', $request->transaction_type);
            if($request->from_date && $request->to_date){
                $from_date = Carbon::parse($request->from_date);
                $to_date = Carbon::parse($request->to_date);
                $transaction_type_amount = $transaction_history->whereBetween('created_at', [$from_date, $to_date])->where('type', $request->transaction_type)->sum('amount');
            }else{

                $transaction_type_amount = $transaction_history->where('type', $request->transaction_type)->sum('amount');
            }
        }
    
        $purchased_amount = Transactions::where('type', 'Purchased')->sum('amount');
        $deposit_amount = Transactions::where('type', 'Deposit')->sum('amount');
        $withdrawal_amount = Transactions::where('type', 'Withdrawal')->sum('amount');

        
        $transaction_history = $transaction_history->get();
        

       
       

        return view('admin.transectionHistory', compact('transaction_history', 'purchased_amount', 'deposit_amount', 'withdrawal_amount','transaction_type_amount'));
    }
    
}
