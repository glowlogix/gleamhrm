<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Traits\MetaTrait;
use App\Attandance;
use App\Employee;
use Carbon\Carbon;
use Session;

class AttendanceController extends Controller
{
    use MetaTrait;
    
    public function index($id)
    {
        $this->meta['title'] = 'Show Attendance';  
        $attendance = Attandance::where('employee_id',$id)->get();
        
        return view('admin.attendance.showattendance',$this->metaResponse(),['attendances' => $attendance]);
     
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->meta['title'] = 'Create Attendance';    
        $employees = Employee::all(); 
        
        return view('admin.attendance.index',$this->metaResponse(),['employees' => $employees]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
         $getcheckinTime = $request->checkindatetimepicker;
         $parsecheckinTime= Carbon::parse($getcheckinTime);
         //$checkinTime = $parsecheckinTime->format('Y-m-d H:i:s');

         $getcheckoutTime = $request->checkoutdatetimepicker;
         $parsecheckoutTime = Carbon::parse($getcheckoutTime);
        // $checkoutTime = $parsecheckoutTime->format('Y-m-d H:i:s');

         $delay = $request->delay;
         $hoursLogged = $parsecheckinTime->diffInHours($parsecheckoutTime); 
                  
         $attendacne = Attandance::create([
             'employee_id' => $request->employee_id,
             'delay' => $delay,
             'checkintime' => $parsecheckinTime,
             'checkouttime' => $parsecheckoutTime,
             'hourslogged' => $hoursLogged
         ]);
         if($attendacne){
            return redirect()->back()->with('success','Attendance is created succesfully');     
            
         }
               
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Leave  $leave
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->meta['title'] = 'Update Attendance';    
        
        $attendance = Attandance::where('employee_id',$id)->first();
        $checkinTime = $attendance->checkintime;
        $parsecheckinTime= Carbon::parse($checkinTime);
        $checkinTime = $parsecheckinTime->format('Y/m/d g:i A');

        $checkoutTime = $attendance->checkouttime;
        $parsecheckoutTime= Carbon::parse($checkoutTime);
        $checkoutTime = $parsecheckoutTime->format('Y/m/d g:i A');
        
        return view('admin.attendance.edit',compact('attendance','checkinTime','checkoutTime'),$this->metaResponse());
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $attendance = Attandance::where('employee_id',$id)->first();
          
        $getcheckinTime = $request->checkindatetimepicker;
        $parsecheckinTime= Carbon::parse($getcheckinTime);

        $attendance->checkintime = $parsecheckinTime;

        $getcheckoutTime = $request->checkoutdatetimepicker;
        $parsecheckoutTime = Carbon::parse($getcheckoutTime);

        $attendance->checkouttime = $parsecheckoutTime;

        $attendance->delay = $request->attendance_delay;

        $hoursLogged = $parsecheckinTime->diffInHours($parsecheckoutTime); 
        $attendance->hoursLogged = $hoursLogged;
        $attendance->hoursLogged = $hoursLogged;
        $row = $attendance->save();
        if($row){
            return redirect()->back()->with('success','Attendance is updated succesfully');     
            
         }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $attendance = Attandance::where('employee_id',$id)->first();
        $attendance->delete();
        return redirect()->back()->with('success','Attendance is deleted succesfully');     
        
        
    }

}
