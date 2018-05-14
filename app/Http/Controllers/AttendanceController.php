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
             'hourslogged' => $hoursLogged,
             'status' => 'present'
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
            $validator =\Validator::make($request->all(),[
                'datefrom' => 'required|before_or_equal:dateto',
                'dateto' => 'required'
            ]);  
            if ($validator->fails())
            {
                return response()->json(['errors'=>$validator->errors()->all()]);
            }

            if($request->currentStatus == "present" && $request->type == "Full Leave"){
                return response()->json('already-present');                
            }
            $currentStartDate = str_replace('/', '-',  $request->currentStartDate);
            $currentStartDate = date('Y-m-d H:i:s',strtotime( $currentStartDate));  

            $currentEndDate = str_replace('/', '-', $request->currentEndDate);
            $currentEndDate = date('Y-m-d H:i:s',strtotime( $currentEndDate));  

            if($request->datefrom){
                $start_date = $request->datefrom;
                $parseStart_date= Carbon::parse($start_date);                                
            }
            
            if($request->dateto){
               
                $end_date = $request->dateto;
                $parseEnd_date= Carbon::parse($end_date);                                
                
            }
            
            $id = $request->id;
            $status = $request->type;

            $row =  DB::update(DB::raw("Update attandances set checkintime = '$parseStart_date', checkouttime = '$parseEnd_date',status = '$status' where employee_id= '$id' And checkintime ='$currentStartDate'"));
            if($row == 1){
                return response()->json('success');
            }else{
                $row =  DB::update(DB::raw("Update leaves set datefrom = '$parseStart_date', dateto = '$parseEnd_date' , leave_type = '$status' where employee_id= '$id' And datefrom ='$currentStartDate'"));
                if($row == 1){
                    return response()->json('success');
                    
                }
            }
       
    }


    public function getbyAjax(Request $request){

            $date = Carbon::parse($request->date);
  
            $employeeID = $request->id;
            $attendance = Attandance::where([
                'employee_id' => $employeeID,
                'checkintime' => $date
            
            ])->first();
            if($attendance){
                $checkintime =  $attendance->checkintime;
                $attendance->checkintime = date('Y/m/d g:i A',strtotime($checkintime));
                $checkouttime =  $attendance->checkouttime;
                $attendance->checkouttime = date('Y/m/d g:i A',strtotime($checkouttime));
                return response()->json([$attendance,'successAttendance']);   
            }else{
                $leave = Leave::where([
                    'employee_id'=>$employeeID,
                    'datefrom'=> $date
                    
                ])->first();
                $dateFrom =  $leave->datefrom;
                $leave->datefrom = date('Y/m/d g:i A',strtotime($dateFrom));
                $dateTo =  $leave->dateto;
                $leave->dateto = date('Y/m/d g:i A',strtotime($dateTo));
                return response()->json($leave);  
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
                    if($value->status == "Short Leave"){
                        $color = '#C24BFF';
                    }
                    if($value->status === "Full Leave"){
                        $color = 'red';                        
                    }
                    if($value->status === "Half Leave"){
                        $color = '#57BB8A';                        
                    }
                    if($value->status == "Paid Leave"){
                        $color = '#ADFF41'; 
                    }
                    if($value->status == "present"){
                        $color = 'green';
                    }

                    if($value->delay){
                        $color = '#70AFDC';
                        $delays = $value->delay." delay";
                    }else{
                        $delays ="";
                    }

                    $events[] = Calendar::event(
        
                        $value->status."\n".$employee->fullname."\n".$delays,
        
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
    
                        $value->leave_type."\n".$employee->fullname."\n"."Reason:".$value->reason."\n"."Status:".$value->status,
        
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
                    var type = $("#leave_type").val(type);
                    jQuery("#myModal").modal({backdrop: "static", keyboard: false}, "show");
                    
                    if(type){
                        $.ajax({
                            type: "GET",                                  
                            url: "'.route('attendance.showByAjax').'", 
                            dataType : "json",   
                            data: {
                                "id" : event.id,
                                "type" : type.val(),
                                 "date" : event.start._i
                            }, 
                            success: function(response){    
                                if(response[1]=="successAttendance"){                    
                                var checkin = $("#datefrom").val(response[0].checkintime);
                                var checkout = $("#dateto").val(response[0].checkouttime);
                                $("#currentStartTime").val(checkin.val());
                                $("#currentEndTime").val(checkout.val());
                                $("#currentStatus").val(response[0].status);

                                }else{
                                    var checkin = $("#datefrom").val(response.datefrom);
                                    var checkout = $("#dateto").val(response.dateto);
                                    $("#currentStartTime").val(checkin.val());
                                    $("#currentEndTime").val(checkout.val());
                                    $("#currentStatus").val(response.status);
                                    
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) { 
                                console.log(JSON.stringify(jqXHR));
                                console.log("AJAX error: " + textStatus + " : " + errorThrown);
                            }

                        });

                    }

                    $("#update").on("click",function(){
                        
                        $.ajax({
                            type: "POST",                                  
                            url: "'.route('attendance.update').'", 
                            dataType : "json",   
                            data: {
                                "id" : event.id,
                                "type" : $("#leave_type").val(),
                                "datefrom":$("#datefrom").val(),
                                "dateto" : $("#dateto").val(),
                                "currentStartDate" :  $("#currentStartTime").val(),
                                "currentEndDate" :  $("#currentEndTime").val(),  
                                "currentStatus" : $("#currentStatus").val(),
                                
                                "_token" : "'.csrf_token().'"
                            }, 
                            success: function(response){ 
                                if(response.errors){
                                    alert(response.errors[0]);                                    
                                }
                                if(response == "success"){
                                    alert("Update Successfully");
                                    window.location.reload();
                                }else if(response == "already-present"){
                                    alert("Already Present First Remove that employee to make Full Leave");                                    
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
                                "date" : event.start._i,
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
            $date = Carbon::parse($request->date);
            $attendance = Attandance::where([
                'employee_id'=>$id,
                'checkintime' => $date
            ])->first();
            if($attendance){
              $attendance->delete();
            }else{
                $leave = Leave::where([
                    'employee_id'=>$id,
                    'datefrom' => $date
                    
                ])->first();
                $leave->delete();
            }
            return response()->json('success');   
        
        
        
    }

}
