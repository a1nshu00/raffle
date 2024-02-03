<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Order;
use App\Models\DepositRequest;
use App\Models\WithdrawalRequest;
use App\Mail\NewPasswordEmail;
use App\Models\StaffLog;
use Carbon\Carbon;
use Validator;
use Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PageManagementController extends Controller
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
     
        $pages = Page::orderBy('updated_at', 'desc')->get();
        return view('admin.pageManagement.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pageManagement.create');
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
            'page_name' => ['required', 'string'],
            'title' => ['required', 'string'],
            'body' => ['required', 'string'],
        ]);
   
        $page = Page::create([
            'admin_id' => auth()->guard('admin')->user()->id,
            'page_name' => $request->page_name,
            'title' => $request->title,
            'body' => $request->body,
        ]);
        StaffLog::create([
            'staff_id' => auth()->guard('admin')->user()->id,
            'activity_name' => 'Page Created',
            'message' => 'Page created by '.auth()->guard('admin')->user()->first_name.' at '. Carbon::now()->format('M d-Y h:i A'),
            'log_time' => Carbon::now(),
        ]);

        return redirect()->route('pages.edit', $page->id)->with('success', 'Created Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
    //    dd('ok');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Page::where('id', $id)->first();
        return view('admin.pageManagement.edit', compact('page'));
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
            'page_name' => ['required', 'string'],
            'title' => ['required', 'string'],
            'body' => ['required', 'string'],
        ]);

        Page::where('id', $id)->update([
            'page_name' => $request->page_name,
            'title' => $request->title,
            'body' => $request->body,

        ]);
        StaffLog::create([
            'staff_id' => auth()->guard('admin')->user()->id,
            'activity_name' => 'Page Updated',
            'message' => 'Page updated by '.auth()->guard('admin')->user()->first_name.' at '. Carbon::now()->format('M d-Y h:i A'),
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
        $page = Page::where('id', $id)->delete();
        StaffLog::create([
            'staff_id' => auth()->guard('admin')->user()->id,
            'activity_name' => 'Page Deleted',
            'message' => 'Page deleted by '.auth()->guard('admin')->user()->first_name.' at '. Carbon::now()->format('M d-Y h:i A'),
            'log_time' => Carbon::now(),
        ]);
        return back()->with('success', 'Deleted Successfully!');
    }
}
