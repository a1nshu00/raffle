<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\StreamingManagement;

class StreamingManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $streaming_management = StreamingManagement::orderBy('updated_at', 'desc')->where('admin_id', auth()->guard('admin')->user()->id)->get();
        return view('admin.streamingManagement.index', compact('streaming_management'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.streamingManagement.create');
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
            'streaming_link' => ['required', 'url'],
        ]); 

        $streaming_management = StreamingManagement::create([
            'streaming_link' => $request->streaming_link,
            'admin_id' =>  auth()->guard('admin')->user()->id,
        ]);

        return redirect()->route('streaming-management.edit', $streaming_management->id)->with('success', 'Created Successfully');
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
        $streaming_management = StreamingManagement::where('id', $id)->first();
        return view('admin.streamingManagement.edit', compact('streaming_management'));
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
            'streaming_link' => ['required', 'url'],
        ]); 

        $streaming_management = StreamingManagement::where('id', $id)->update([
            'streaming_link' => $request->streaming_link,
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
        StreamingManagement::where('id', $id)->delete();
        return back()->with('success', 'Deleted Successfully!');
    }
}
