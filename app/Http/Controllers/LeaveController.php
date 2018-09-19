<?php

namespace App\Http\Controllers;

use App\Leave;
use App\Employee;
use Illuminate\Http\Request;
use App\Traits\MetaTrait;
use Carbon\Carbon;
use Session;

class LeaveController extends Controller
{
    use MetaTrait;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $this->meta['title'] = 'Show Leaves';  
        $leaves = Leave::where('employee_id',$id)->get();
        
        return view('admin.leaves.showleaves',$this->metaResponse(),['leaves' => $leaves]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->meta['title'] = 'Create Leave';    
        $employees = Employee::all(); 
        return view('admin.leaves.index',$this->metaResponse(),['employees' => $employees]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $employee_id = $request->employee_id;
        $leave_type = $request->leave_type;
        $dateFrom = $request->datefrom;
        $dateFromTime = Carbon::parse($dateFrom);

        $dateTo = $request->dateto;
        $dateToTime = Carbon::parse($dateTo);

        $reason = $request->reason;
        $status = $request->status;

        $leave = Leave::create([
            'employee_id' => $employee_id,
            'leave_type' => $leave_type,
            'datefrom' => $dateFromTime,
            'dateto' => $dateToTime,
            'reason' => $reason,
            'status' => $status
        ]);
        if($leave){
           return redirect()->back()->with('success','Leave is created succesfully');     
           
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function show(Leave $leave)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->meta['title'] = 'Update Leave';    
        
        $leave = Leave::where('id',$id)->first();        
        return view('admin.leaves.edit',['leave' => $leave],$this->metaResponse());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $leave = Leave::where('employee_id',$id)->first();

      $dateFrom = $request->datefrom;
      $dateFromTime = Carbon::parse($dateFrom);

      $leave->datefrom = $dateFromTime;

      $dateTo = $request->dateto;
      $dateToTime = Carbon::parse($dateTo);

      $leave->dateto = $dateToTime;

      $leave->leave_type = $request->leave_type;

      $leave->reason = $request->reason;
      $leave->status = $request->status;
      $row = $leave->save();
      if($row){
          return redirect()->back()->with('success','Leave is updated succesfully');     
          
       }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function destroy(Leave $leave,$id)
    {
        $leave = Leave::where('employee_id',$id)->first();
        $leave->delete();
        return redirect()->back()->with('success','Leave is deleted succesfully');   
    }
}
