<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Traits\MetaTrait;
use App\Attandance;
use App\Employee;
use Carbon\Carbon;
use App\Leave;
use Session;
use App\Salary;
use App\MonthlySalary;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Writer\WriterFactory;
use Box\Spout\Common\Type;
use DB;
use Calendar;

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
             
        $this->validate($request,[
            'checkindatetimepicker' => 'required|before:checkoutdatetimepicker',
            'checkoutdatetimepicker' => 'required'
        ]);
         $getcheckinTime = $request->checkindatetimepicker;
         $parsecheckinTime= Carbon::parse($getcheckinTime);

         $getcheckoutTime = $request->checkoutdatetimepicker;
         $parsecheckoutTime = Carbon::parse($getcheckoutTime);
              
         $delay = $request->delay ? $request->delay  : 0;
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
        
        $attendance = Attandance::where('id',$id)->first();
        
        return view('admin.attendance.edit',compact('attendance'),$this->metaResponse());
        
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
        dd($request);
        // $attendance = Attandance::where('id',$id)->first();
        // $getcheckinTime = $request->checkindatetimepicker;
        // $parsecheckinTime= Carbon::parse($getcheckinTime);

        // $attendance->checkintime = $parsecheckinTime;

        // $getcheckoutTime = $request->checkoutdatetimepicker;
        // $parsecheckoutTime = Carbon::parse($getcheckoutTime);

        // $attendance->checkouttime = $parsecheckoutTime;

        // $attendance->delay = $request->attendance_delay;

        // $hoursLogged = $parsecheckinTime->diffInHours($parsecheckoutTime); 
        // $attendance->hoursLogged = $hoursLogged;
        // $attendance->hoursLogged = $hoursLogged;
        // $row = $attendance->save();
        // if($row){
        //     return redirect()->route('attendance.show',['id' => $attendance->employee_id])->with('success','Attendance is updated succesfully');     
            
        //  }

    }

    public function showAttendance(Request $request){
        $this->meta['title'] = 'Show Attendance';        
        $data = DB::table('employees')->get(); 
        foreach($data as $employee){
            $employee_id = $employee->id;
            $attendance = DB::table('attandances')->where('employee_id', $employee_id)->get(); 
            $leave = DB::table('leaves')->where('employee_id', $employee_id)->get(); 
  
             $events = [];
        
               if($data->count()){
        
                  foreach ($attendance as $key => $value) {

                    $events[] = Calendar::event(
        
                        "present"."\n".$employee->fullname,
        
                        true,
                        new \DateTime($value->checkintime),
        
                        new \DateTime($value->checkouttime.' +1 day'),
                        $value->employee_id,
                        [
                            'color' => 'green'
                        ]
                    );
        
                  }
                  foreach ($leave as $key => $value) {
                    
                    $events[] = Calendar::event(
    
                        $value->leave_type."\n".$employee->fullname,
        
                        true,
                        new \DateTime($value->datefrom),
        
                        new \DateTime($value->dateto.' +1 day'),
                        $value->employee_id,
                        [
                            'color' => 'orange'
                        ]
                    );
        
                    }
               }
               $calendar = Calendar::addEvents($events)
               ->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
                'editable'=> true,
                'eventClick' => 'function(event) {
                    console.log(event);
                    var type = event.title.split("\n")[0];
                    var id = event.id;
                    
                    $("#attendance").val(type);
                    $("#myModal").modal("toggle");
                    // $.ajaxSetup({
                    //     headers: {
                    //       "X-CSRF-TOKEN": $(meta[name=csrf-token]).attr("content")
                    //     }
                    //   });
                    $("#update").on("click",function(){
                       
                        $.ajax({
                            method: "POST", 
                            url: "attendance/update/"+id, 
                            data: {
                                "type" : type,
                                "id" : id,
                                "_token": "{!! csrf_token() !!}",
                            }, 
                            success: function(response){ 
                                console.log(response); 
                            },
                            error: function(jqXHR, textStatus, errorThrown) { 
                                console.log(JSON.stringify(jqXHR));
                                console.log("AJAX error: " + textStatus + " : " + errorThrown);
                            }

                        })

                    });
                    

                }'
            ]);
               
            }
            
              
        return view('admin.attendance.allattendance',$this->metaResponse(),['calendar' => $calendar]);
    }
        
    
    


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $attendance = Attandance::where('id',$id)->first();
        $attendance->delete();
        return redirect()->back()->with('success','Attendance is deleted succesfully');     
        
        
    }

}
