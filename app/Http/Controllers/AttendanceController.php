<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Traits\MetaTrait;
use App\Attendance;
use App\AttendanceSummary;
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
use DateTime;


class AttendanceController extends Controller
{
    use MetaTrait;
    
    public function index($id)
    {
        $this->meta['title'] = 'Show Attendance';  
        $attendance = Attandance::where('employee_id',$id)->get();
        return view('admin.attendance.showattendance',$this->metaResponse(),['attendances' => $attendance]);
     
    }
    public function sheet($id)
    {
        $datee= explode('_',$id);
        $date=$datee[1];
        if($date=="1"){$name="January";}elseif($date=="2"){$name="February";}elseif($date=="3"){$name="March";}elseif($date=="4"){$name="April";}elseif($date=="5"){$name="May";}elseif($date=="6"){$name="June";}elseif($date=="7"){$name="July";}
        elseif($date=="8"){$name="August";}elseif($date=="9"){$name="September";}elseif($date=="10"){$name="October";}elseif($date=="11"){$name="November";}else{$name="December";}
        $employees= Employee::all();
        return view('admin.attendance.sheet')->with(['employees'=> $employees, 'date'=>$date, 'name'=>$name]);

    }


/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($emp_id='', $date= '')
    {
        $this->meta['title'] = 'Create Attendance';    
        $employees = Employee::all(); 

        if ($date == '') {
            $datetime = Carbon::now();
        }
        else{
            $datetime = Carbon::parse($date);
        }
        
        $date = $datetime->toDateString();
        
        $datetime = Carbon::now();
        $current_time = $datetime->toTimeString();

        $selected_in_out = '';
        $attendance = Attendance::where(['date' => $date, 'employee_id' => $emp_id])->orderBy('time_in', 'asc')->first();
        /*dd($attendance);
        if (isset($attendance->time_out) && empty($attendance->time_out)) {
            $selected_in_out = 'out';
        }*/

        $attendance_summary = AttendanceSummary::where(['date' => $date, 'employee_id' => $emp_id])->first();
        $attendances = Attendance::where(['date' => $date, 'employee_id' => $emp_id])->orderBy('time_in', 'asc')->get();
        
        return view('admin.attendance.create',$this->metaResponse(),[
            'employees'         => $employees, 
            'attendances'       => $attendances, 
            'attendance_summary'=> $attendance_summary, 
            'current_date'      => $date, 
            'current_time'      => $current_time, 
            'selected_in_out'   => $selected_in_out, 
            'emp_id'            => $emp_id,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $this->validate($request,[
            'employee_id' => 'required',
            'time_in' => 'required',
            'date' => 'required',
        ]);

        $time = Carbon::parse($request->time);                           
        
        $key = 'time_in';
        if ($request->in_out == 'out') {
            $key = 'time_out';
        }
        $attendance = [
            'employee_id' => $request->employee_id,
            'date' => $request->date,
            'time' => $time->toTimeString(),
            'time_in' => !empty($request->time_in) ? Carbon::parse($request->time_in) : '',
        ];
        if (!empty($request->time_out)) {
            $attendance['time_out'] = Carbon::parse($request->time_out);
        }
        $attendance = Attendance::create($attendance);

        $this->storeAttendaceSummary($request);

        if($attendance){
            return redirect()->back()->with('success','Attendance is created succesfully');
        }
        else{
            return redirect()->back()->with('error','Error while add attendance');
        }
    }

    public function storeAttendaceSummary(Request $request)
    {
        $attendance = Attendance::where(['date' => $request->date, 'employee_id' => $request->employee_id])->orderBy('time_in', 'asc')->get();
        $first_time_in = $attendance->first()->time_in;
        $last_time_out = $attendance->last()->time_out;

        $totaltime = 0;
        foreach ($attendance as $i => $row) {
            $in = Carbon::parse($row->time_in);
            $out = Carbon::parse($row->time_out);
            $totaltime += $out->diffInMinutes($in);
        }

        $attendance_summary = AttendanceSummary::where([
            'employee_id' => $request->employee_id,
            'date' => $request->date,
        ])->first();

        if (isset($attendance_summary->id) != '') {
            $attendance_summary->first_time_in = $first_time_in;
            $attendance_summary->last_time_out = $last_time_out;
            $attendance_summary->total_time = $totaltime;
            $attendance_summary->save();
        }
        else{
            $attendance_summary = AttendanceSummary::create([
                'employee_id' => $request->employee_id,
                'first_time_in' => $first_time_in,
                'last_time_out' => $last_time_out,
                'total_time' => $totaltime,
                'date' => $request->date,
            ]);
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
    public function updateSummary(Request $request){
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
            $parsecheckinTime= Carbon::parse($currentStartDate);
            $parsecheckoutTime= Carbon::parse($currentEndDate);            
            $hoursLogged = $parsecheckinTime->diffInHours($parsecheckoutTime);
            $id = $request->id;
            $status = $request->type;

            $row =  DB::update(DB::raw("Update attandances set checkintime = '$parseStart_date', hourslogged='$hoursLogged' , checkouttime = '$parseEnd_date',status = '$status' where employee_id= '$id' And checkintime ='$currentStartDate'"));
            if($row == 1){
                return response()->json('success');
            }else{
                $row =  DB::update(DB::raw("Update leaves set datefrom = '$parseStart_date', dateto = '$parseEnd_date' , leave_type = '$status' where employee_id= '$id' And datefrom ='$currentStartDate'"));
                if($row == 1){
                    return response()->json('success');
                    
                }
            }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Leave  $leave
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request){

        $attendance = Attendance::where([
            'id' => $request->query('id'),
        ])->first();

        $request->employee_id = $attendance->employee_id;
        $request->date = $attendance->date;

        if (isset($attendance->id) != '') {
            $attendance->date = $request->date;
            $attendance->time_in = Carbon::parse($request->time_in);
            $attendance->time_out = Carbon::parse($request->time_out);
            $attendance->save();
        }

        $this->storeAttendaceSummary($request);
        
        return redirect()->back()->with('success','Attendance is updated succesfully');
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
            // $attendance = DB::table('attandances')->where('employee_id', $employee_id)->get(); 
            $attendance_summaries = DB::table('attendance_summaries')->where('employee_id', $employee_id)->get();
            // dd($attendance);
            $leave = DB::table('leaves')->where('employee_id', $employee_id)->get(); 
            $events = [];
        
            if($data->count()){
        
                foreach ($attendance_summaries as $key => $value) {
                    // $row = DB::table('attendances')->where('employee_id', $employee_id)->first();
                    // $timein = $row->time;
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

                    if($value->is_delay && $value->status=="present"){
                        $color = '#70AFDC';
                        $delays = $value->is_delay." delay";
                    }else{
                        $delays ="";
                    }
                    $time = date("g:i A",strtotime($value->first_time_in));
                    // $time2= date("g:i A",strtotime($value->checkouttime));
                    
                    $events[] = Calendar::event(
        
                        // $value->status."\n".$employee->fullname."\n".$time."\n". $value->hourslogged." hrs"."\n",
                        $value->status."\n".$employee->fullname."\n".$time."\n". ($value->total_time / 60)." hrs"."\n",
                        true,
                        new \DateTime($value->date),
                        // new \DateTime($value->date .' '. $value->first_time_in),
                        new \DateTime($value->date.' +1 day'),
                        // new \DateTime($value->date .' '. $value->last_time_out.' +1 day'),
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

               $calendar = Calendar::addEvents($events)->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
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

    public function showTimeline(){
        $this->meta['title'] = 'Show Attendance';        
        
        $employees = Employee::all()->toJson();
        $attendance_summaries = AttendanceSummary::all();
        $events = array();
        foreach ($attendance_summaries as $key => $value) {
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

            if($value->is_delay && $value->status=="present"){
                $color = '#70AFDC';
                $delays = $value->is_delay." delay";
            }else{
                $delays ="";
            }
            $time = date("g:i A",strtotime($value->first_time_in));
                // $time2= date("g:i A",strtotime($value->checkouttime));

            $events[] = [
                "resourceId" => $value->employee_id,
                "title" => $value->status."\n".$time."\n". ($value->total_time / 60)." hrs"."\n",
                "start" => $value->date .' '. $value->first_time_in,
                "end" => $value->date .' '.$value->first_time_in,
            ];
        }
        $events = json_encode($events);

        return view('admin.attendance.timeline',$this->metaResponse(), ['employees' => $employees, 'events' => $events]);
    }

    public function deleteChecktime(Request $request)
    {
        $id = $request->id;

        $attendance = Attendance::where([
            'id'=>$id
        ])->first();
        if($attendance){
          $attendance->delete();
        }
    
        return redirect()->back()->with('success','Attendance is deleted succesfully');
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
