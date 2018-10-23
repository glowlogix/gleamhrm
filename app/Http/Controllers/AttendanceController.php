<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Traits\MetaTrait;
use App\Attendance;
use App\AttendanceSummary;
use App\Employee;
use App\Branch;
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

    public function createByAjax($emp_id='', $date= '')
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
        // dd($attendance);
        
        return view('admin.attendance.createByAjax')
        ->with([
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
            'time_out' => 'required|after:time_in',
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
        // dump($attendance);
        $first_time_in = $attendance->first()->time_in;
        // dump($first_time_in);
        $last_time_out = $attendance->last()->time_out;
        // dump($last_time_out);

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

        $employee = Employee::find($request->employee_id);
        if ($employee->branch_id == 0) {
            $employee->branch_id = 2;
        }
        
        $office_location = Branch::find($employee->branch_id);
        $ofc_in = Carbon::parse($office_location->timing_start);
        $emp_in = Carbon::parse($first_time_in);
        $delay = $emp_in->diffInMinutes($ofc_in);
     
        $is_delay = 'no';
        if ($emp_in->gt($ofc_in) && $delay > 30) {
            $is_delay = 'yes';
        }

        if (isset($attendance_summary->id)) {
            $attendance_summary->first_time_in = $first_time_in;
            $attendance_summary->last_time_out = $last_time_out;
            $attendance_summary->total_time = $totaltime;
            $attendance_summary->date = $request->date;
            $attendance_summary->is_delay = $is_delay;
            $attendance_summary->save();
        }
        else{
            $arr= [
                'employee_id' => $request->employee_id,
                'first_time_in' => $first_time_in,
                'last_time_out' => $last_time_out,
                'total_time' => $totaltime,
                'is_delay' => $is_delay,
                'date' => $request->date,
            ];
            // dump($arr);
            $attendance_summary = AttendanceSummary::create($arr);
        }
    }

    public function storeAttendanceSummaryToday(Request $request)
    {
        $attendance_summary = AttendanceSummary::where([
            'employee_id' => $request->employee_id,
            'date' => $request->date,
        ])->first();

        $employee = Employee::find($request->employee_id);
        if ($employee->branch_id == 0) {
            $employee->branch_id = 2;
        }
        
        $branch = Branch::find($employee->branch_id);
        $ofc_in = Carbon::parse('9:00 PM');
        if(isset($branch->timing_start)){
            $ofc_in = Carbon::parse($branch->timing_start);
        }
        $emp_in = Carbon::parse($request->time_in);
        $delay = $emp_in->diffInMinutes($ofc_in);
     
        $is_delay = 'no';
        if ($emp_in->gt($ofc_in) && $delay > 30) {
            $is_delay = 'yes';
        }

        $in = Carbon::parse($request->time_in);
        $out = Carbon::parse($request->time_out);
        $totaltime = $out->diffInMinutes($in);

        if (isset($attendance_summary->id)) {
            $attendance_summary->first_time_in  = $in;
            $attendance_summary->last_time_out  = $out;
            $attendance_summary->total_time     = $totaltime;
            $attendance_summary->date           = $request->date;
            $attendance_summary->is_delay       = $is_delay;
            $attendance_summary->save();
        }
        else{
            $arr= [
                'employee_id'   => $request->employee_id,
                'first_time_in' => $in,
                'last_time_out' => $out,
                'total_time'    => $totaltime,
                'is_delay'      => $is_delay,
                'date'          => $request->date,
            ];
            // dump($arr);
            $attendance_summary = AttendanceSummary::create($arr);
        }
        if($attendance_summary){
            return redirect()->back()->with('success','Attendance is created succesfully');
        }
        else{
            return redirect()->back()->with('error','Error while add attendance');
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
        $this->validate($request,[
            'time_in' => 'required',
            'time_out' => 'required|after:time_in',
            'date' => 'required',
        ]);
        
        $attendance = Attendance::where([
            'id' => $request->query('id'),
        ])->first();

        $request->employee_id = $attendance->employee_id;

        if (isset($attendance->id) != '') {
            $attendance->date = Carbon::parse($request->date);
            $attendance->time_in = Carbon::parse($request->time_in);
            $attendance->time_out = Carbon::parse($request->time_out);
            // dd($attendance);
            $attendance->save();
        }

        $this->storeAttendaceSummary($request);
        
        return redirect()->back()->with('success','Attendance is updated succesfully');
    }


    public function getbyAjax(Request $request){

        $date = Carbon::parse($request->date);
        
        $employeeID = $request->id;
        $attendance = AttendanceSummary::where([
            'employee_id' => $employeeID,
            'date' => $date,
        ])->first();

        if($attendance){
            $attendance->first_time_in = date('g:i A',strtotime($attendance->first_time_in));
            $attendance->last_time_out = date('g:i A',strtotime($attendance->last_time_out));
            return response()->json([$attendance,'successAttendance']);   
        }
        else{
            $leave = Leave::where([
                'employee_id'=>$employeeID,
                'datefrom'=> $date,
            ])->first();

            $dateFrom =  $leave->datefrom;
            $leave->datefrom = date('Y/m/d g:i A',strtotime($dateFrom));
            $dateTo =  $leave->dateto;
            $leave->dateto = date('Y/m/d g:i A',strtotime($dateTo));
            return response()->json($leave);  
        }
        
    }


    public function showAttendance(Request $request, $id=0){

        $this->meta['title'] = 'Show Attendance';

        if ($id == 0) {
            $data = Employee::get();
        }
        else{
            $data = Employee::where(['branch_id' => $id])->get();
        }
        $events = [];
        
        if ($data->count() > 0) {
            foreach($data as $employee){
                $employee_id = $employee->id;
                $now = Carbon::now();
                $now->year;

                $dob = Carbon::parse($employee->date_of_birth);
                $date_of_birth = $now->format('Y') .'-' . $dob->format('m').'-'.$dob->format('d');
                
                $events[] = [
                    "resourceId" => $employee->id,
                    "title" => "Birthday of \n".$employee->firstname.' '. $employee->lastname,
                    "date" => $date_of_birth,
                    "start" => $date_of_birth,
                    "end" => $date_of_birth,
                    "color"=> 'pink',
                ];

                $attendance_summaries = AttendanceSummary::where('employee_id', $employee_id)->get();
     
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
                    }
                    else{
                        $delays ="";
                    }
                    $time = date("g:i A",strtotime($value->first_time_in));
                    // $time2= date("g:i A",strtotime($value->checkouttime));
                    $total_time = number_format(($value->total_time / 60), 2, '.', ''); 
                    $events[] = [
                        "resourceId" => $value->employee_id,
                        "title" => $value->status."\n".$employee->firstname.' '. $employee->lastname."\n".$time."\n". $total_time." hrs"."\n",
                        "date" => $value->date,
                        "start" => $value->date .' '. $value->first_time_in,
                        "end" => $value->date .' '.$value->first_time_in,
                        "color" => 'blue',
                    ];
                }

                $leave = Leave::where('employee_id', $employee_id)->get(); 
                
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

                    $events[] = [
                        "resourceId" => $value->employee_id,
                        "title" => $value->leave_type."\n".$employee->firstname.' '. $employee->lastname."\n"."Reason:".$value->reason."\n"."Status:".$value->status,
                        "date" => $value->datefrom,
                        "start" => $value->datefrom,
                        "end" => $value->dateto,
                        'color' => $color,
                    ];
                }
            }
        }
        $office_locations = Branch::all();
        
        return view('admin.attendance.allattendance',$this->metaResponse(),[
            'branch_id' => $id,
            'office_locations' => $office_locations,
            'events' => json_encode($events),
        ]);
    }

    public function showTimeline($id=0){
        $this->meta['title'] = 'Show Attendance';
        
        if ($id == 0) {
            $employees = Employee::all()->toJson();
        }
        else{
            $employees = Employee::where(['branch_id' => $id])->get()->toJson();
        }
        
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
            $time = Carbon::parse($value->first_time_in);
            $total_time = number_format(($value->total_time / 60), 2, '.', ''); 
    
            $events[] = [
                "resourceId" => $value->employee_id,
                "title" => $value->status."\n".$time."\n". $total_time." hrs"."\n",
                "date" => $value->date,
                "start" => $value->date .' '. $value->first_time_in,
                "end" => $value->date .' '.$value->last_time_out,
                "color" => $color,
            ];
        }
        $leave = Leave::all();
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

            $events[] = [
                "resourceId" => $value->employee_id,
                "title" => $value->leave_type."\n"."Reason:".$value->reason."\n"."Status:".$value->status,
                "date" => $value->datefrom,
                "start" => Carbon::parse($value->datefrom)->toDateString(),
                "end" => Carbon::parse($value->dateto)->toDateString(),
                "color" => $color,
            ];
        }

        $events = json_encode($events);
        $office_locations = Branch::all();
        
        return view('admin.attendance.timeline',$this->metaResponse(), [
            'employees' => $employees,
            'branch_id' => $id,
            'office_locations' => $office_locations,
            'events' => $events
        ]);
    }

    public function todayTimeline($id=0){
        $this->meta['title'] = 'Show Attendance';
        
        $today = Carbon::now()->toDateString();

        $employees = AttendanceSummary::leftJoin('employees', function($join) {
            $join->on('employees.id', '=', 'attendance_summaries.employee_id');
        })
        ->where('attendance_summaries.date', $today)
        ->get([
            'employees.*',
            'attendance_summaries.date',
            'attendance_summaries.first_time_in',
            'attendance_summaries.last_time_out',
            'attendance_summaries.total_time',
        ]);
        
        $active_employees = Employee::where('status','1')->get()->count(); 

        // $employees = Employee::with('attendance_summaries', 'branch')->where('attendance_summaries.date', '2018-10-23')->get();
        // if ($id == 0) {
        //     $employees = Employee::with('attendanceSummary', 'branch')->get();
        // }
        // else{
        //     $employees = Employee::where(['branch_id' => $id])->with('attendanceSummary', 'branch')->get();
        // }

        return view('admin.attendance.today_timeline',$this->metaResponse(), [
            'active_employees' => $active_employees,
            'employees' => $employees,
            'today' => $today,
            'branch_id' => $id,
        ]);
    }

    public function deleteChecktime(Request $request)
    {
        $id = $request->id;

        $attendance = Attendance::where([
            'id'=>$id,
        ])->first();

        if($attendance){
            
            $attendanceCount = Attendance::where([
                'employee_id'=>$attendance->employee_id,
                'date'=>$attendance->date,
            ])->count();

            if ($attendanceCount == 1) {
                $attendance_summary = AttendanceSummary::where([
                    'employee_id' => $attendance->employee_id,
                    'date' => $attendance->date,
                ])->first();

                $attendance_summary->delete();
            }

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
