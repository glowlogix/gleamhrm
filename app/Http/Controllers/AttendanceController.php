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
            'checkindatetimepicker' => 'required|before_or_equal:checkoutdatetimepicker',
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
    public function update(Request $request)
    {
        $id = $request->id;
        $startDate = $request->datefrom;
        $endDate = $request->dateto;

        $leave = Leave::where('employee_id',$id)->first();
        if($request->type== "present"){
            return response()->json('present');               
        }
        else{            
        $leave->leave_type = $request->type;
        
        if($startDate){
        $ParsestartDate= Carbon::parse($startDate);

        $leave->datefrom = $ParsestartDate;
        }
        if($endDate){
        $parseEndDate = Carbon::parse($endDate);

        $leave->dateto = $parseEndDate;
        }

        $row = $leave->save();
        if($row){
            return response()->json('success');   
            
         }

        }

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

                    $delays = '';
                    $color = '';
                    if($value->employee_id){
                        $color = 'green';
                    }

                    if($value->delay){
                        $color = '#70AFDC';
                        $delays = $value->delay." delay";
                    }else{
                        $delays ="";
                    }

                    $events[] = Calendar::event(
        
                        "present"."\n".$employee->fullname."\n".$delays,
        
                        true,
                        new \DateTime($value->checkintime),
        
                        new \DateTime($value->checkouttime.' +1 day'),
                        $value->employee_id,
                        [
                            'color' =>  $color
                        ]
                    );
        
                  }
                  foreach ($leave as $key => $value) {
                      $color = '';
                    if($value->leave_type == "Short Leave"){
                        $color = '#C24BFF';
                    }
                    if($value->leave_type === "Full Leave"){
                        $color = 'red';                        
                    }
                    if($value->leave_type === "Half Leave"){
                        $color = '#57BB8A';                        
                    }
                    if($value->leave_type == "Paid Leave"){
                        $color = '#ADFF41'; 
                    }
                    $events[] = Calendar::event(
    
                        $value->leave_type."\n".$employee->fullname,
        
                        true,
                        new \DateTime($value->datefrom),
        
                        new \DateTime($value->dateto.' +1 day'),
                        $value->employee_id,
                        [
                            'color' => $color
                        ]
                    );
        
                    }
               }
               $calendar = Calendar::addEvents($events)
               ->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
                'editable'=> true,
                'eventClick' => 'function(event) {
                    var type = event.title.split("\n")[0];                    
                    $("#update").unbind("click");     
                    $("#del").unbind("click"); 
                    console.log(event);
                    jQuery("#myModal").modal({backdrop: "static", keyboard: false}, "show");
                    $("#update").on("click",function(){                        
                        $.ajax({
                            type: "POST",                                  
                            url: "'.route('attendance.update').'", 
                            dataType : "json",   
                            data: {
                                "id" : event.id,
                                "type" : $("#leave_type").val(),
                                "datefrom":$("#datefrom").data("date"),
                                "dateto" : $("#dateto").data("date"),
                                "_token" : "'.csrf_token().'"
                            }, 
                            success: function(response){ 
                                
                                if(response == "success"){
                                    alert("Update Successfully");
                                    window.location.reload();
                                }else if(response == "present"){
                                    alert("Already Present not changeable");
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) { 
                                console.log(JSON.stringify(jqXHR));
                                console.log("AJAX error: " + textStatus + " : " + errorThrown);
                            }

                        });

                    });

                    $("#del").on("click",function(){    
                        var r = confirm("Are you sure you want to delete?");                  
                        if (r == true) {
                         $.ajax({
                            type: "POST",                                  
                            url: "'.route('attendance.destroy').'", 
                            dataType : "json",   
                            data: {
                                "id" : event.id,
                                "type" : $("#leave_type").val(),
                                "_token" : "'.csrf_token().'"
                            }, 
                            success: function(response){ 
                                if(response == "success"){
                                    alert("Delete Successfully");
                                    window.location.reload();
                                }

                            },
                            error: function(jqXHR, textStatus, errorThrown) { 
                                console.log(JSON.stringify(jqXHR));
                                console.log("AJAX error: " + textStatus + " : " + errorThrown);
                            }

                        });

                        } else {
                            jQuery("#myModal").modal("toggle");                            
                            
                        }

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
    public function destroy(Request $request)
    {
        $id = $request->id;
        $leaveType = $request->type;
        if($leaveType == "present"){
        $attendance = Attandance::where('employee_id',$id)->first();
        $attendance->delete();
        }else{
            $leave = Leave::where('employee_id',$id)->first();
            $leave->delete();
        }
        return response()->json('success');   
        
        
        
    }

}
