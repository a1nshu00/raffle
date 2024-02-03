<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RaffleDraw;
use App\Models\RaffleResult;
use App\Models\StaffLog;
use Validator;
use App\Models\RafflePrizes;
use App\Models\Order;
use App\Models\OrderDetail;
use Carbon\Carbon;

class RaffleDrawController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $raffle_draw = RaffleDraw::orderBy('id', 'desc');
        if($request->view_all){
            $raffle_draw = $raffle_draw->get();
        }else{
            if($request->from_date && $request->to_date){
                $fromDate = Carbon::parse($request->from_date)->startOfDay();
                $toDate = Carbon::parse($request->to_date)->endOfDay();
                $raffle_draw->whereBetween('draw_time', [$fromDate, $toDate]);
            }else{
                $raffle_draw->whereDate('draw_time', Carbon::today());
            }
            $raffle_draw = $raffle_draw->get();

        }
        return view('admin.raffleDraw.index', compact('raffle_draw'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.raffleDraw.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $prize_name = explode(',', $request->prize_name);
        $physical_prize_image = explode(',', $request->physical_prize_image);
        $cash_prize = explode(',', $request->cash_prize);
        $physical_prize = explode(',', $request->physical_prize);
        $admin_fee = explode(',', $request->admin_fee);
       
        $this->validate($request, [
            'type' => ['required', 'string'],
            'draw_title' => ['required', 'string'],
            'buying_amount' => ['required', 'numeric '],
            'draw_time' => ['required'],
            'total_balls' => ['required'],
        ]);
        if($request->streaming_link){
            $this->validate($request, [
                'streaming_link' => ['url'],
            ]);
        }
        
        if($request->type == "Raffle"){
            $this->validate($request, [
                'total_balls' => ['required','numeric', 'max:500'],
            ]);
        }else{
            $this->validate($request, [
                'total_balls' => ['required','numeric', 'max:100'],
            ]);
        }
        $RaffleDraw = RaffleDraw::create([
            'type' => $request->type,
            'draw_title' => $request->draw_title,
            'admin_id' =>  auth()->guard('admin')->user()->id,
            'total_balls' => $request->total_balls,
            'buying_amount' => $request->buying_amount,
            'draw_time' => $request->draw_time,
            'streaming_link' => $request->streaming_link,
        ]);

        if(count($prize_name) > 0){
            foreach ($prize_name as $key => $value) {
                RafflePrizes::create([
                    'raffle_id' => $RaffleDraw->id,
                    'prize_name' => $value,
                    'physical_prize_image' => $physical_prize_image[$key],
                    'cash_prize' =>  (double)$cash_prize[$key],
                    'physical_prize' => $physical_prize[$key],
                    'admin_fee' =>  (double)$admin_fee[$key],
                ]);
            }
        }
        StaffLog::create([
            'staff_id' => auth()->guard('admin')->user()->id,
            'activity_name' => 'Raffle Created',
            'message' => 'Raffle created by '.auth()->guard('admin')->user()->first_name.' at '. Carbon::now()->format('M d-Y h:i A'),
            'log_time' => Carbon::now(),
        ]);

        return redirect()->route('raffle-draw.edit', $RaffleDraw->id)->with('success', 'Raffle created successfully.');

        
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
        $raffle_draw = RaffleDraw::where('id', $id)->first();
        $raffle_prizes = RafflePrizes::whereIn('raffle_id', [$id])->get();
       return view('admin.raffleDraw.edit', compact('raffle_draw', 'raffle_prizes'));
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

        $prize_name = explode(',', $request->prize_name);
        $physical_prize_image = explode(',', $request->physical_prize_image);
        $cash_prize = explode(',', $request->cash_prize);
        $physical_prize = explode(',', $request->physical_prize);
        $admin_fee = explode(',', $request->admin_fee);

        $this->validate($request, [
            'type' => ['required', 'string'],
            'draw_title' => ['required', 'string'],
            'buying_amount' => ['required', 'numeric '],
            'draw_time' => ['required'],
             'total_balls' => ['required'],
        ]);
         if($request->streaming_link){
            $this->validate($request, [
                'streaming_link' => ['url'],
            ]);
        }
        
        if($request->type == "Raffle"){
            $this->validate($request, [
                'total_balls' => ['required','numeric', 'max:500'],
            ]);
        }else{
            $this->validate($request, [
                'total_balls' => ['required','numeric', 'max:100'],
            ]);
        }

        $RaffleDraw = RaffleDraw::where('id', $id)->update([
            'type' => $request->type,
            'draw_title' => $request->draw_title,
            'total_balls' => $request->total_balls,
            'buying_amount' => $request->buying_amount,
            'draw_time' => $request->draw_time,
            'streaming_link' => $request->streaming_link,
        ]);

        RafflePrizes::whereIn('raffle_id', [$id])->delete();

        if(count($prize_name) > 0 && $prize_name[0] != ''){
            foreach ($prize_name as $key => $value) {
                RafflePrizes::create([
                    'raffle_id' => $id,
                    'prize_name' => $value,
                    'physical_prize_image' => $physical_prize_image[$key],
                    'cash_prize' =>  (double)$cash_prize[$key],
                    'physical_prize' => $physical_prize[$key],
                    'admin_fee' =>  (double)$admin_fee[$key],
                ]);
            }
        }
        StaffLog::create([
            'staff_id' => auth()->guard('admin')->user()->id,
            'activity_name' => 'Raffle Updated',
            'message' => 'Raffle updated by '.auth()->guard('admin')->user()->first_name.' at '. Carbon::now()->format('M d-Y h:i A'),
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
        RaffleDraw::where('id', $id)->delete();
        RafflePrizes::whereIn('raffle_id', [$id])->delete();
        StaffLog::create([
            'staff_id' => auth()->guard('admin')->user()->id,
            'activity_name' => 'Raffle Deleted',
            'message' => 'Raffle deleted by '.auth()->guard('admin')->user()->first_name.' at '. Carbon::now()->format('M d-Y h:i A'),
            'log_time' => Carbon::now(),
        ]);
        return back()->with('success', 'Deleted successfully');
    }

    public function PrizeStoreimage(Request $request)
    {
        if($request->image){
            $destinationPath = public_path().'/admin/uploads/prizes';
            
            $imagePath ='';
            if($request->file('image')){
                $imageName = '_'.time().'_'.$request->image->getClientOriginalName(); 
                $request->image->move($destinationPath, $imageName);
                $imagePath = 'admin/uploads/prizes/'.$imageName;
            }
            return response()->json([
                'status' => 200,
                'message' => 'Image upload successfully',
                'imagePath' => $imagePath,
            ]);
        }else{
            return response()->json([
                'status' => 400,
                'message' => 'Please upload an image',
            ]);
        }
    }
     public function Results(Request $request, $id)
    {
        $results =  RaffleResult::leftjoin('users', 'raffle_results.user_id', '=', 'users.id')
            ->leftjoin('raffle_draws', 'raffle_results.raffle_id', '=', 'raffle_draws.id')
            ->whereIn('raffle_results.raffle_id', [$id])
            ->select('users.first_name', 'raffle_draws.draw_title', 'raffle_draws.buying_amount', 'raffle_results.order_id', 'raffle_results.winning_ball', 'raffle_results.user_choice')
        ->get();
        return view('admin.raffleDraw.results', compact('results'));
    }

    public function ResultManage(Request $request, $id)
    {
        $raffle_prizes = RafflePrizes::whereIn('raffle_id', [$id])->get();
        $raffle_result = RaffleResult::leftjoin('raffle_prizes', 'raffle_results.prize_id', '=', 'raffle_prizes.id')
            ->whereIn('raffle_results.raffle_id', [$id])->select('raffle_prizes.prize_name', 'raffle_results.*')->get();
        return view('admin.raffleDraw.resultManage', compact('raffle_prizes','raffle_result', 'id'));
    }

    public function CheckValidBall(Request $request)
    {
        $order_detail = OrderDetail::where('ball_number', $request->ball_number)->where('raffle_id', $request->raffle_id)->first();
        $raffle_draw = RaffleDraw::where('id', $request->raffle_id)->select('total_balls')->first();
        if($request->ball_number < $raffle_draw->total_balls){
        
            if($order_detail){
                return response()->json([
                    'status' => 200,
                    'message' => 'Valid ball',
                ]);
            }else{
                return response()->json([
                    'status' => 400,
                    'message' => 'Invalid ball',
                ]);
            }
        }else{
            return response()->json([
                'status' => 400,
                'message' => 'Invalid ball',
            ]);
        }
        
    }
    public function StoreResult(Request $request, $id)
    {
       
        if($request->result_id){
            $result_id = explode(',', $request->result_id);
            RaffleResult:: whereNotIn('id', $result_id)->delete();
        }else{
            $result_id = '';
        }
        $prize_ids = explode(',', $request->prize_id);
        $winning_balls = explode(',', $request->winning_ball);
        
       
        if(count($winning_balls)){
            foreach($winning_balls as $key => $value) {

                $order_id = OrderDetail::where('ball_number', $value)->where('raffle_id', $id)->first();
                if($order_id){
                    $user_id = Order::where('id', $order_id->order_id)->first();
                }else{
                    $user_id = '';
                }
                if(isset($result_id[$key])){
                    RaffleResult::where('id', $result_id[$key])->update([
                        'order_id' => $order_id ? $order_id->order_id : null,
                        'prize_id' => $prize_ids[$key],
                        'user_id' => $user_id  ? $user_id->user_id : null,
                        'raffle_id' => $id,
                        'winning_ball' => $value,
                    ]);
                }else{
                    RaffleResult::create([
                        'order_id' => $order_id ? $order_id->order_id : null,
                        'prize_id' => $prize_ids[$key],
                        'user_id' => $user_id  ? $user_id->user_id : null,
                        'raffle_id' => $id,
                        'winning_ball' => $value,
                    ]);
                }
            }
            StaffLog::create([
                'staff_id' => auth()->guard('admin')->user()->id,
                'activity_name' => 'Raffle Result Declared',
                'message' => 'Raffle result declared by '.auth()->guard('admin')->user()->first_name.' at '. Carbon::now()->format('M d-Y h:i A'),
                'log_time' => Carbon::now(),
            ]);
            return redirect()->route('raffle-draw.result_manage', $id)->with('success', 'Result declare successfully.');
        }else{
            return back()->with('error', 'Something went wrong.');
        }
    }
    
    public function RaffleDetail(Request $request, $id){
        $raffle_draw = OrderDetail::leftjoin('order', 'order_detail.order_id', '=', 'order.id')
        ->leftjoin('users', 'order.user_id', '=', 'users.id')
        ->where('order_detail.raffle_id', $id)->select(
            'order_detail.*',
            'users.first_name', 
            'users.email'
        )->get();
        
        return view('admin.raffleDraw.view', compact('raffle_draw'));
        
    }
}
