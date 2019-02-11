<?php

namespace App\Http\Controllers;

use App\AttendanceBreak;
use App\OrganizationHierarchy;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
use Illuminate\Support\Facades\Log;
use Mail;
use App\Mail\Reminder;

class AttendanceController extends Controller
{
    use MetaTrait;

    public function index($id)
    {

        $this->meta['title'] = 'Show Attendance';
        $attendance = Attandance::where('employee_id', $id)->get();
        return view('admin.attendance.showattendance', $this->metaResponse(), ['attendances' => $attendance]);
    }

    public function sheet($id)
    {
        $datee = explode('_', $id);
        $date = $datee[1];
        if ($date == "1") {
            $name = "January";
        } elseif ($date == "2") {
            $name = "February";
        } elseif ($date == "3") {
            $name = "March";
        } elseif ($date == "4") {
            $name = "April";
        } elseif ($date == "5") {
            $name = "May";
        } elseif ($date == "6") {
            $name = "June";
        } elseif ($date == "7") {
            $name = "July";
        } elseif ($date == "8") {
            $name = "August";
        } elseif ($date == "9") {
            $name = "September";
        } elseif ($date == "10") {
            $name = "October";
        } elseif ($date == "11") {
            $name = "November";
        } else {
            $name = "December";
        }

        $employees = Employee::all();
        return view('admin.attendance.sheet')->with(['employees' => $employees, 'date' => $date, 'name' => $name]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
//Old
    public function create($emp_id = '', $date = '')
    {
        $this->meta['title'] = 'Create Attendance';
        $employees = Employee::all();

        if ($date == '') {
            $datetime = Carbon::now();
        } else {
            $datetime = Carbon::parse($date);
        }

        $date = $datetime->toDateString();

        $datetime = Carbon::now();
        $current_time = $datetime->format('h:m');

        $selected_in_out = '';
        $attendance = Attendance::where(['date' => $date, 'employee_id' => $emp_id])->orderBy('timestamp_in', 'asc')->first();

        $attendance_summary = AttendanceSummary::where(['date' => $date, 'employee_id' => $emp_id])->first();

        $attendances = Attendance::where(['date' => $date, 'employee_id' => $emp_id])->orderBy('timestamp_in', 'asc')->get();
        return view('admin.attendance.create', $this->metaResponse(), [
            'employees' => $employees,
            'attendances' => $attendances,
            'attendance_summary' => $attendance_summary,
            'current_date' => $date,
            'current_time' => $current_time,
            'selected_in_out' => $selected_in_out,
            'emp_id' => $emp_id,
        ]);
    }

//New
    public function createBreak($emp_id = '', $date = '')
    {
        $this->meta['title'] = 'Create Attendance';
        $employees = Employee::all();
        $today = Carbon::now()->toDateString();
        if ($date == '') {
            $datetime = Carbon::now();
        } else {
            $datetime = Carbon::parse($date);
        }
        $date = $datetime->toDateString();

        $datetime = Carbon::now();
        $current_time = $datetime->format('h:m');
        session(['date' => $date]);
        $selected_in_out = '';
        $attendance = AttendanceBreak::where(['date' => $date, 'employee_id' => $emp_id])->orderBy('timestamp_break_start', 'asc')->first();

        $attendance_summary = AttendanceSummary::where(['date' => $date, 'employee_id' => $emp_id])->first();

        $attendances = AttendanceBreak::where(['date' => $date, 'employee_id' => $emp_id])->orderBy('timestamp_break_end', 'asc')->get();

        return view('admin.attendance.create_break', $this->metaResponse(), [
            'employees' => $employees,
            'attendances' => $attendances,
            'attendance_summary' => $attendance_summary,
            'current_date' => $date,
            'current_time' => $current_time,
            'selected_in_out' => $selected_in_out,
            'emp_id' => $emp_id,
            'today' => $today
        ]);
    }

    public function todayTimeline($id = "")
    {
        $this->meta['title'] = 'Show Attendance';

        if ($id == "") {
            $today = Carbon::now()->toDateString();
        } else {
            $today = ($id);
        }
        $employees = Employee::with([
            'attendanceSummary' => function ($join) use ($today) {
                $join->where('date', $today);
            },
        ], 'branch', 'leaves')->where('status', '!=', '0')->where('type', '!=', 'remote')->get();

//Leaves Count
        $leaveDate = array();
        $periods = array();
        $leaves = Leave::join('employees', 'leaves.employee_id', '=', 'employees.id')->where('employees.type', 'office')->where('employees.status', '!=', '0')->where('leaves.status', 'Approved')->get();
        foreach ($leaves as $leave) {
            $periods[$leave->employee_id] = CarbonPeriod::create($leave->datefrom, $leave->dateto);
        }
        foreach ($periods as $key => $period) {
            foreach ($period as $dates) {
                $leaveDate[$key][] = $dates->format('Y-m-d');
            }
        }
        $leavesCount = 0;
        $employeeLeave = array();
        foreach ($leaveDate as $key => $leave) {
            if (in_array($today, $leave)) {
                $leavesCount = $leavesCount + 1;
                $employeeLeave[$key] = $key;
            }
        }
//leaves Count
        $present = AttendanceSummary::with('branch')->join('employees', 'employees.id', '=', 'attendance_summaries.employee_id')->where('employees.type', 'office')->where('employees.status', '!=', '0')->where('date', $today)->count();
        $employeeCount = Employee::where('type', 'office')->where('status', '!=', '0')->count();
        $absent = $employeeCount - $present - $leavesCount;
        $delays = AttendanceSummary::join('employees', 'employees.id', '=', 'attendance_summaries.employee_id')->where('employees.type', 'office')->where('employees.status', '!=', '0')->where('date', $today)->where('is_delay', 'yes')->count();

        return view('admin.attendance.today_timeline', $this->metaResponse(), [
            'employees' => $employees,
            'today' => $today,
            'branch_id' => $id,
            'today' => $today,
            'present' => $present,
            'absent' => $absent,
            'delays' => $delays,
            'leavesCount' => $leavesCount,
            'employeeLeave' => $employeeLeave
        ]);
    }

    public function createByAjax($emp_id = '', $date = '')
    {
        $this->meta['title'] = 'Create Attendance';
        $employees = Employee::all();

        if ($date == '') {
            $datetime = Carbon::now();
        } else {
            $datetime = Carbon::parse($date);
        }

        $date = $datetime->toDateString();

        $datetime = Carbon::now();
        $current_time = $datetime->toTimeString();

        $selected_in_out = '';
        $attendance = Attendance::where(['date' => $date, 'employee_id' => $emp_id])->orderBy('timestamp_in', 'asc')->first();
        /*dd($attendance);
        if (isset($attendance->time_out) && empty($attendance->time_out)) {
            $selected_in_out = 'out';
        }*/
        $attendance_summary = AttendanceSummary::where(['date' => $date, 'employee_id' => $emp_id])->first();

        $attendances = Attendance::where(['date' => $date, 'employee_id' => $emp_id])->orderBy('timestamp_in', 'asc')->get();
        // dd($attendance);

        return view('admin.attendance.createByAjax')
            ->with([
                'employees' => $employees,
                'attendances' => $attendances,
                'attendance_summary' => $attendance_summary,
                'current_date' => $date,
                'current_time' => $current_time,
                'selected_in_out' => $selected_in_out,
                'emp_id' => $emp_id,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $this->validate($request, [
            'employee_id' => 'required',
            'time_in' => 'required',
            'date' => 'required',
        ]);

        $time = Carbon::parse($request->time);

        $key = 'timestamp_in';
        if ($request->in_out == 'out') {
            $key = 'timestamp_out';
        }
        $attendance = [
            'employee_id' => $request->employee_id,
            'date' => $request->date,
            'time' => $time->toTimeString(),
            'timestamp_in' => !empty($request->time_in) ? Carbon::parse($request->time_in) : '',
        ];

        if (!empty($request->time_out)) {
            $attendance['timestamp_out'] = Carbon::parse($request->time_out);
        }
        $attendance = Attendance::create($attendance);

        $this->storeAttendaceSummary($request);

        if ($attendance) {
            return redirect()->back()->with('success', 'Attendance is created successfully');
        } else {
            return redirect()->back()->with('error', 'Error while add attendance');
        }
    }

    public function storeBreak(Request $request)
    {

        $this->validate($request, [
            'employee_id' => 'required',
            'break_start' => 'required',
            'date' => 'required',
        ]);

        $time = Carbon::parse($request->time);

        $attendance = [
            'employee_id' => $request->employee_id,
            'date' => $request->date,
            'time' => $time->toTimeString(),
            'timestamp_break_start' => !empty($request->break_start) ? Carbon::parse($request->break_start) : '',
            'comment' => $request->comment,
        ];

        if (!empty($request->break_end)) {
            $attendance['timestamp_break_end'] = Carbon::parse($request->break_end);
        }
        $attendance = AttendanceBreak::create($attendance);

//        $this->storeAttendaceSummary($request);
        $this->updateTotalTime($request);
        if ($attendance) {
            return redirect()->back()->with('success', 'Break is created successfully');
        } else {
            return redirect()->back()->with('error', 'Error while add attendance');
        }
    }

//OLD
    public function storeAttendaceSummary(Request $request)
    {
        $attendance = Attendance::where(['date' => $request->date, 'employee_id' => $request->employee_id])->orderBy('timestamp_in', 'asc')->get();
        // dump($attendance);
        $first_timestamp_in = $attendance->first()->timestamp_in;
        // dump($first_time_in);
        $last_timestamp_out = $attendance->last()->timestamp_out;
        // dump($last_time_out);
        $totaltime = 0;
        if ($last_timestamp_out != "") {
            foreach ($attendance as $i => $row) {
                $in = Carbon::parse($row->timestamp_in);
                $out = Carbon::parse($row->timestamp_out);
                $totaltime += $out->diffInMinutes($in);
            }
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
        $emp_in = Carbon::parse($first_timestamp_in);
        $delay = $emp_in->diffInMinutes($ofc_in);

        $day = Carbon::parse($request->date)->format('l');

        $is_delay = 'no';
        if ($emp_in->gt($ofc_in) && $delay > 30) {
            $is_delay = 'yes';
        }
        if (
            ($office_location->id == 1 && $day == 'Friday') ||
            ($office_location->id == 2 && $day == 'Saturday')
        ) {
            $is_delay = 'No';
        }

        if (isset($attendance_summary->id)) {
            $attendance_summary->first_timestamp_in = $first_timestamp_in;
            $attendance_summary->last_timestamp_out = $last_timestamp_out;
            $attendance_summary->total_time = $totaltime;
            $attendance_summary->date = $request->date;
            $attendance_summary->is_delay = $is_delay;
            $attendance_summary->save();
        } else {
            $arr = [
                'employee_id' => $request->employee_id,
                'first_timestamp_in' => $first_timestamp_in,
                'last_timestamp_out' => $last_timestamp_out,
                'total_time' => $totaltime,
                'is_delay' => $is_delay,
                'date' => $request->date,
            ];
            // dump($arr);
            $attendance_summary = AttendanceSummary::create($arr);
        }
    }

//NEW
    public function storeAttendanceSummaryToday(Request $request)
    {

        Carbon::parse($request->time_in);
        $attendance_summary = AttendanceSummary::where([
            'employee_id' => $request->employee_id,
            'date' => $request->date,
        ])->first();

        $employee = Employee::find($request->employee_id);
        if ($employee->branch_id == 0) {
            $employee->branch_id = 2;
        }

        $branch = Branch::find($employee->branch_id);
        if (isset($branch->timing_start)) {
            $ofc_in = Carbon::parse($request->time_in)->toDateString() . " " . Carbon::parse($branch->timing_start)->toTimeString();
        }
        $emp_in = Carbon::parse($request->time_in);
        $delay = $emp_in->diffInMinutes($ofc_in);
        $is_delay = 'no';
        if ($emp_in->gt($ofc_in) && $delay > 30) {
            $is_delay = 'yes';
        }

        $attendance = AttendanceBreak::where(['date' => $request->date, 'employee_id' => $request->employee_id])->orderBy('timestamp_break_start', 'asc')->get();
        $totalbreaktime = 0;

        foreach ($attendance as $i => $row) {
            $in = Carbon::parse($row->timestamp_break_start);
            $out = Carbon::parse($row->timestamp_break_end);
            $totalbreaktime += $out->diffInMinutes($in);
        }

        $in = Carbon::parse($request->time_in);

        if (!empty($request->time_out)) {
            $out = Carbon::parse($request->time_out);
            $totaltime = $out->diffInMinutes($in);
            $totaltime = $totaltime - $totalbreaktime;

        } else {
            $out = null;
            $totaltime = 0;
        }

        if (isset($attendance_summary->id)) {
            $attendance_summary->first_timestamp_in = $in;
            $attendance_summary->last_timestamp_out = $out;
            $attendance_summary->total_time = $totaltime;
            $attendance_summary->date = $request->date;
            $attendance_summary->is_delay = $is_delay;
            $attendance_summary->save();
        } else {
            $arr = [
                'employee_id' => $request->employee_id,
                'first_timestamp_in' => $in,
                'last_timestamp_out' => $out,
                'total_time' => $totaltime,
                'is_delay' => $is_delay,
                'date' => $request->date,
            ];
            // dump($arr);
            $attendance_summary = AttendanceSummary::create($arr);
        }
        if ($attendance_summary) {
            return redirect()->back()->with('success', 'Attendance is created successfully');
        } else {
            return redirect()->back()->with('error', 'Error while add attendance');
        }
    }

    public function updateTotalTime(Request $request)
    {
        $attendance = AttendanceBreak::where(['date' => $request->date, 'employee_id' => $request->employee_id])->orderBy('timestamp_break_start', 'asc')->get();

        $attendanceSummaryTime = AttendanceSummary::where('employee_id', $request->employee_id)->orderBy('first_timestamp_in', 'desc')->first();
        $first_timestamp_in = $attendanceSummaryTime->first_timestamp_in;

        $totalbreaktime = 0;
        if ($attendance->count() > 0) {
            foreach ($attendance as $i => $row) {
                $in = Carbon::parse($row->timestamp_break_start);
                $out = Carbon::parse($row->timestamp_break_end);
                $totalbreaktime += $out->diffInMinutes($in);
            }
        } else {
            $totalbreaktime = 0;
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
        $emp_in = Carbon::parse($first_timestamp_in);
        $ofc_in = Carbon::parse($emp_in)->toDateString() . " " . Carbon::parse($office_location->timing_start)->toTimeString();
        $delay = $emp_in->diffInMinutes($ofc_in);

        $day = Carbon::parse($request->date)->format('l');
        $is_delay = 'no';
        if ($emp_in->gt($ofc_in) && $delay > 30) {
            $is_delay = 'yes';
        }
        if (
            ($office_location->id == 1 && $day == 'Friday') ||
            ($office_location->id == 2 && $day == 'Saturday')
        ) {
            $is_delay = 'No';
        }
        if ($attendance_summary != null) {
            $in = Carbon::parse($attendance_summary->first_timestamp_in);
            if ($attendance_summary->last_timestamp_out != null) {
                $out = Carbon::parse($attendance_summary->last_timestamp_out);
                $totaltime = $out->diffInMinutes($in);
                $totaltime = $totaltime - $totalbreaktime;
            } else {
                $totaltime = 0;
            }

            if (isset($attendance_summary->id)) {
                $attendance_summary->total_time = $totaltime;
                $attendance_summary->is_delay = $is_delay;
                $attendance_summary->save();
            }
        }
    }

    public function newSlackbot(Request $request)
    {
        if (isset($request->challenge)) {
            return $request->challenge;
        }
        if ($request['event']['channel'] != config('values.SlackChannel')) {
            Log::debug('Accept from Slack Attendance Channel.');
            return;
        }
        $employee = Employee::where('slack_id', $request['event']['user'])->first();
        if (!isset($employee->id)) {
            $token = config('values.SlackToken');
            $output = file_get_contents('https://slack.com/api/users.profile.get?token=' . $token . '&user=' . $request['event']['user']);
            $output = json_decode($output, true);
            if (!$output['ok']) {
                Log::debug('no user info found.');
                return 'no user info found.';
            }

            $employee = Employee::where('official_email', $output['profile']['email'])->first();
            $employee->slack_id = $request['event']['user'];
            $employee->save();
            dd('get and save Slack Id for employee.');
            Log::debug('get and save Slack Id for employee.');
        }

        $date = Carbon::createFromTimestamp($request['event_time'])->toDateString();
        $time = Carbon::createFromTimestamp($request['event_time'])->toDateTimeString();

        $text = $request['event']['text'];

        $checkInText = array("aoa", "salam", "slaam", "slam", "assalam-o-alaikum", "assalam o alaikum", "assalamualaikum", 'asslam o alaikum', 'assalamu-alaeikum', 'morning', 'asslam o alikum', 'assalamu-aleikum', 'assalamu alaikum', 'Assalam o Alikum', 'Asslamo Alaikum');
        $checkOutText = array("ah", "allah haffiz", "allah hafiz", "allahhafiz", "allah hafiz.", "bye", "allah-hafiz", 'allah haffiz');

        if (in_array(strtolower($text), $checkInText) == true) {
            $text = 'aoa';
            $attendanceSummarycheck = AttendanceSummary::where('employee_id', $employee->id)->where('date', $date)->first();
            if ($attendanceSummarycheck == null) {
                $data = [
                    'employee_id' => $employee->id,
                    'first_timestamp_in' => $time,
                    'date' => $date,
                    'total_time' => 0,
                ];
                AttendanceSummary::create($data);
            }
        } elseif (strstr(strtolower($text), 'brb')) {
            $clean = array("_", ".", "-", "brb");
            $comment = str_replace($clean, '', $text);
            $data = [
                'employee_id' => $employee->id,
                'timestamp_break_start' => $time,
                'comment' => $comment,
                'date' => $date,
                'total_time' => 0,
            ];
            AttendanceBreak::create($data);
        } elseif (strstr(strtolower($text), 'back')) {
            $attendanceCheck = AttendanceBreak::where('employee_id', $employee->id)->orderBy('timestamp_break_start', 'desc')->first();
            if ($attendanceCheck != null) {
                $attendanceCheck->timestamp_break_end = $time;
                $attendanceCheck->save();
                $request->employee_id = $employee->id;
                $request->date = $attendanceCheck->date;
                $this->updateTotalTime($request);
            }
        } elseif (in_array(strtolower($text), $checkOutText) == true) {
            $attendanceSummary = AttendanceSummary::where('employee_id', $employee->id)->orderBy('date', 'desc')->first();
            $attendanceSummary->last_timestamp_out = $time;
            $request->employee_id = $employee->id;
            $request->date = $attendanceSummary->date;
            $attendanceSummary->save();
            $this->updateTotalTime($request);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Leave $leave
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Leave $leave
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->meta['title'] = 'Update Attendance';

        $attendance = Attandance::where('id', $id)->first();

        return view('admin.attendance.edit', compact('attendance'), $this->metaResponse());

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Leave $leave
     * @return \Illuminate\Http\Response
     */
    public function updateSummary(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'datefrom' => 'required|before_or_equal:dateto',
            'dateto' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        if ($request->currentStatus == "present" && $request->type == "Full Leave") {
            return response()->json('already-present');
        }
        $currentStartDate = str_replace('/', '-', $request->currentStartDate);
        $currentStartDate = date('Y-m-d H:i:s', strtotime($currentStartDate));

        $currentEndDate = str_replace('/', '-', $request->currentEndDate);
        $currentEndDate = date('Y-m-d H:i:s', strtotime($currentEndDate));

        if ($request->datefrom) {
            $start_date = $request->datefrom;
            $parseStart_date = Carbon::parse($start_date);
        }

        if ($request->dateto) {

            $end_date = $request->dateto;
            $parseEnd_date = Carbon::parse($end_date);

        }
        $parsecheckinTime = Carbon::parse($currentStartDate);
        $parsecheckoutTime = Carbon::parse($currentEndDate);
        $hoursLogged = $parsecheckinTime->diffInHours($parsecheckoutTime);
        $id = $request->id;
        $status = $request->type;

        $row = DB::update(DB::raw("Update attandances set checkintime = '$parseStart_date', hourslogged='$hoursLogged' , checkouttime = '$parseEnd_date',status = '$status' where employee_id= '$id' And checkintime ='$currentStartDate'"));
        if ($row == 1) {
            return response()->json('success');
        } else {
            $row = DB::update(DB::raw("Update leaves set datefrom = '$parseStart_date', dateto = '$parseEnd_date' , leave_type = '$status' where employee_id= '$id' And datefrom ='$currentStartDate'"));
            if ($row == 1) {
                return response()->json('success');

            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Leave $leave
     * @return \Illuminate\Http\Response
     */
////OLD
    public function update(Request $request)
    {
        $this->validate($request, [
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
            $attendance->timestamp_in = Carbon::parse($request->time_in);
            $attendance->timestamp_out = Carbon::parse($request->time_out);
            // dd($attendance);
            $attendance->save();
        }

        $this->storeAttendaceSummary($request);

        return redirect()->back()->with('success', 'Attendance is updated successfully');
    }

///NEW
    public function updateBreak(Request $request)
    {
        $this->validate($request, [
            'break_start' => 'required',
            'break_end' => 'required|after:time_in',
            'date' => 'required',
        ]);

        $attendance = AttendanceBreak::where([
            'id' => $request->query('id'),
        ])->first();

        $request->employee_id = $attendance->employee_id;

        if (isset($attendance->id) != '') {
            $attendance->date = Carbon::parse($request->date);
            $attendance->timestamp_break_start = Carbon::parse($request->break_start);
            $attendance->timestamp_break_end = Carbon::parse($request->break_end);
            $attendance->comment = $request->comment;
            // dd($attendance);
            $attendance->save();
        }

        $this->updateTotalTime($request);

        return redirect()->back()->with('success', 'Attendance Break is updated successfully');
    }

////
    public function getbyAjax(Request $request)
    {

        $date = Carbon::parse($request->date);

        $employeeID = $request->id;
        $attendance = AttendanceSummary::where([
            'employee_id' => $employeeID,
            'date' => $date,
        ])->first();

        if ($attendance) {
            $attendance->first_timestamp_in = date('g:i A', strtotime($attendance->first_timestamp_in));
            $attendance->last_timestamp_out = date('g:i A', strtotime($attendance->last_timestamp_out));
            return response()->json([$attendance, 'successAttendance']);
        } else {
            $leave = Leave::where([
                'employee_id' => $employeeID,
                'datefrom' => $date,
            ])->first();

            $dateFrom = $leave->datefrom;
            $leave->datefrom = date('Y/m/d g:i A', strtotime($dateFrom));
            $dateTo = $leave->dateto;
            $leave->dateto = date('Y/m/d g:i A', strtotime($dateTo));
            return response()->json($leave);
        }

    }


    public function showAttendance(Request $request, $id = 0)
    {
        $this->meta['title'] = 'Show Attendance';

        if ($id == 0) {
            $data = Employee::where('status', '!=', '0')->get();
        } else {
            $data = Employee::where(['branch_id' => $id])->where('status', '!=', '0')->get();
        }
        $events = [];

        if ($data->count() > 0) {
            foreach ($data as $employee) {
                $employee_id = $employee->id;
                $now = Carbon::now();
                $now->year;

                $dob = Carbon::parse($employee->date_of_birth);
                $date_of_birth = $now->format('Y') . '-' . $dob->format('m') . '-' . $dob->format('d');

                $events[] = [
                    "resourceId" => $employee->id,
                    "title" => "Birthday of \n" . $employee->firstname . ' ' . $employee->lastname,
                    "date" => $date_of_birth,
                    "start" => $date_of_birth,
                    "end" => $date_of_birth,
                    "color" => 'pink',
                ];

                $attendance_summaries = AttendanceSummary::where('employee_id', $employee_id)->get();

                foreach ($attendance_summaries as $key => $value) {
                    $delays = '';
                    $color = '';
                    if ($value->status == "Short Leave") {
                        $color = '#C24BFF';
                    }
                    if ($value->status === "Full Leave") {
                        $color = 'red';
                    }
                    if ($value->status === "Half Leave") {
                        $color = '#57BB8A';
                    }
                    if ($value->status == "Paid Leave") {
                        $color = '#ADFF41';
                    }
                    if ($value->status == "present") {
                        $color = '#00a560';
                    }

                    if ($value->is_delay && $value->status == "present") {
                        $color = '#43474a';
                        $delays = $value->is_delay . " delay";
                    } else {
                        $delays = "";
                    }
                    $time = date("g:i A", strtotime($value->first_timestamp_in));
                    // $time2= date("g:i A",strtotime($value->checkouttime));
                    $total_time = number_format(($value->total_time / 60), 2, '.', '');
                    $events[] = [
                        "resourceId" => $value->employee_id,
                        "title" => $value->status . "\n" . $employee->firstname . ' ' . $employee->lastname . "\n" . $time . "\n" . $total_time . " hrs" . "\n",
                        "date" => $value->date,
                        "start" => $value->date . ' ' . Carbon::parse($value->first_timestemp_in)->toTimeString(),
                        "end" => Carbon::parse($value->last_timestemp_out)->toTimeString(),
                        "color" => 'blue',
                    ];
                }

                $leave = Leave::where('employee_id', $employee_id)->get();

                foreach ($leave as $key => $value) {
                    $color = '';
                    if ($value->leave_type == "Short Leave") {
                        $color = '#C24BFF';
                    }
                    if ($value->leave_type === "Full Leave") {
                        $color = 'red';
                    }
                    if ($value->leave_type === "Half Leave") {
                        $color = '#57BB8A';
                    }
                    if ($value->leave_type == "Paid Leave") {
                        $color = '#ADFF41';
                    }

                    $events[] = [
                        "resourceId" => $value->employee_id,
                        "title" => $value->leave_type . "\n" . $employee->firstname . ' ' . $employee->lastname . "\n" . "Reason:" . $value->reason . "\n" . "Status:" . $value->status,
                        "date" => $value->datefrom,
                        "start" => $value->datefrom,
                        "end" => $value->dateto,
                        'color' => $color,
                    ];
                }
            }
        }
        $office_locations = Branch::all();

        return view('admin.attendance.allattendance', $this->metaResponse(), [
            'branch_id' => $id,
            'office_locations' => $office_locations,
            'events' => json_encode($events),
        ]);
    }

    public function showTimeline($id = 0)
    {
        $this->meta['title'] = 'Show Attendance';

        if ($id == 0) {
            $employees = Employee::where('type', '!=', 'remote')->where('status', '!=', '0')->get()->toJson();
        } else {
            $employees = Employee::where(['branch_id' => $id])->where('type', '!=', 'remote')->where('status', '!=', '0')->get()->toJson();
        }
        $attendance_summaries = AttendanceSummary::where('date', '!=', '')->get();
        $events = array();
        foreach ($attendance_summaries as $key => $value) {
            $delays = '';
            $color = '';
            if ($value->status == "Short Leave") {
                $color = '#C24BFF';
            }
            if ($value->status === "Full Leave") {
                $color = 'red';
            }
            if ($value->status === "Half Leave") {
                $color = '#57BB8A';
            }
            if ($value->status == "Paid Leave") {
                $color = '#ADFF41';
            }
            if ($value->status == "present") {
                $color = '#00a560';
            }
            if ($value->is_delay && $value->status == "present") {
                $color = '#43474a';
                $delays = $value->is_delay . " delay";
            } else {
                $delays = "";
            }
            $timeIn = Carbon::parse($value->first_timestamp_in)->format('g:i A');

            if ($value->last_timestamp_out != '') {
                $timeOut = Carbon::parse($value->last_timestamp_out)->format('g:i A');
            } else {
                $timeOut = 0;
            }
            $total_time = gmdate('H:i', floor(number_format(($value->total_time / 60), 2, '.', '') * 3600));
            $events[] = [
                "resourceId" => $value->employee_id,
                "title" => $value->status . "\n" . $timeIn . " - " . $timeOut . "\n" . $total_time . " hrs" . "\n",
                "date" => $value->date,
                "color" => $color,
            ];
        }
        $leave = Leave::with('leaveType')->get();
        foreach ($leave as $key => $value) {
            $color = '';
            if ($value->leave_type == "Short Leave") {
                $color = '#C24BFF';
            }
            if ($value->leave_type === "Full Leave") {
                $color = 'red';
            }
            if ($value->leave_type === "Half Leave") {
                $color = '#57BB8A';
            }
            if ($value->leave_type == "Paid Leave") {
                $color = '#ADFF41';
            }
            $events[] = [
                "resourceId" => $value->employee_id,
                "title" => $value->leaveType->name . "\n" . "Reason:" . $value->reason . "\n" . "Status:" . $value->status,
                "date" => $value->datefrom,
                "start" => Carbon::parse($value->datefrom)->toDateString(),
                "end" => date('Y-m-d', strtotime($value->dateto . ' +1 day')),
                "color" => $color,
            ];
        }

        $events = json_encode($events);
        $office_locations = Branch::all();
        return view('admin.attendance.timeline', $this->metaResponse(), [
            'employees' => $employees,
            'branch_id' => $id,
            'office_locations' => $office_locations,
            'events' => $events
        ]);
    }


///OLD
    public function deleteChecktime(Request $request)
    {
        $id = $request->id;

        $attendance = Attendance::where([
            'id' => $id,
        ])->first();

        if ($attendance) {

            $attendanceCount = Attendance::where([
                'employee_id' => $attendance->employee_id,
                'date' => $attendance->date,
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

        return redirect()->back()->with('success', 'Attendance Break is deleted successfully');
    }

///NEW
    public function deleteBreakChecktime(Request $request)
    {
        $id = $request->id;

        $attendance = AttendanceBreak::where([
            'id' => $id,
        ])->first();

        if ($attendance) {

            $attendanceCount = AttendanceBreak::where([
                'employee_id' => $attendance->employee_id,
                'date' => $attendance->date,
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

        return redirect()->back()->with('success', 'Attendance Break is deleted successfully');
    }
///

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Leave $leave
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $leaveType = $request->type;
        $date = Carbon::parse($request->date);
        $attendance = Attandance::where([
            'employee_id' => $id,
            'checkintime' => $date
        ])->first();
        if ($attendance) {
            $attendance->delete();
        } else {
            $leave = Leave::where([
                'employee_id' => $id,
                'datefrom' => $date

            ])->first();
            $leave->delete();
        }
        return response()->json('success');
    }


    public function mybot()
    {

        /* DriverManager::loadDriver(\BotMan\Drivers\Slack\SlackDriver::class);

         // Create BotMan instance
         $config = [
             'slack' => [
                 // 'token' => 'xoxp-8188862598-8188819876-462791872723-de4f3d8c55f00dc1d46827fbae51d864'
                 'token' => 'xoxp-8188862598-433759455604-469796436497-af16f66263dfa5b7d260dd41faa0103f'
             ]
         ];
         $botMan = BotManFactory::create($config);
         $botman->on('event', function($payload, $bot) {
             dump($payload);
             dd($payload);
         });


         $botman->hears('brb', function (SlackBot $bot, $message) {
           $bot->reply("You have already did aoa today!");
           $bot->reply("What do you want to do please reply below!");
         });
         $botman->hears('aoa', function (SlackBot $bot, $message) {
           $bot->reply("You have already did aoa today!");
           $bot->reply("What do you want to do please reply below!");
         });
         $botman->hears('aoa', function (SlackBot $bot, $message) {
           $bot->reply("You have already did aoa today!");
           $bot->reply("What do you want to do please reply below!");
         });
         $loop->run();*/
    }

    public function authUserTimeline($id = "")
    {

        $employees = Employee::where('status', '!=', '0')->where('type', '!=', 'remote')->orderBy('firstname')->get();
        $days = [
            'Sunday' => 0,
            'Monday' => 1,
            'Tuesday' => 2,
            'Wednesday' => 3,
            'Thursday' => 4,
            'Friday' => 5,
            'Saturday' => 6
        ];
        if ($id != "") {
            $employeeId = $id;
            $employee = Employee::where(['id' => $id])->first();
            $attendance_summaries = AttendanceSummary::where('employee_id', $id)->get();
        } else {
            $employeeId = Auth::user()->id;
            $employee = Employee::where(['id' => Auth::user()->id])->first();
            $attendance_summaries = AttendanceSummary::where('employee_id', Auth::user()->id)->get();
        }
        $currentMonth = date('m');
        $events = array();
        $presentDate = array();
        $branchWeekend = json_decode(Branch::find($employee->branch_id)->weekend);
        //For Dow
        if ($attendance_summaries->count() > 0) {
            foreach ($attendance_summaries as $key => $value) {
                if ($value->first_timestamp_in != "") {
                    $delays = '';
                    $color = '';
                    if ($value->status == "Short Leave") {
                        $color = '#C24BFF';
                    }
                    if ($value->status === "Full Leave") {
                        $color = 'red';
                    }
                    if ($value->status === "Half Leave") {
                        $color = '#57BB8A';
                    }
                    if ($value->status == "Paid Leave") {
                        $color = '#ADFF41';
                    }
                    if ($value->status == "present") {
                        $color = '#00a560';
                    }

                    if ($value->is_delay && $value->status == "present") {
                        $color = '#43474a';
                        $delays = $value->is_delay . " delay";
                    } else {
                        $delays = "";
                    }
                    $timeIn = Carbon::parse($value->first_timestamp_in)->format('g:i A');
                    if ($value->last_timestamp_out != "") {

                        $timeOut = Carbon::parse($value->last_timestamp_out)->format('g:i A');
                    } else {
                        $timeOut = 0;
                    }
                    $total_time = round((Carbon::parse($value->last_timestamp_out)->diffInMinutes(Carbon::parse($value->first_timestamp_in))) / 60, '2');
                    $events[] = [
                        "resourceId" => $value->employee_id,
                        "title" => $value->status . "\n" . $timeIn . " - " . $timeOut . "\n" . $total_time . " hrs" . "\n",
                        "date" => Carbon::parse($value->date)->toDateString(),
                        "start" => Carbon::parse($value->date)->toDateString(),
                        "end" => Carbon::parse($value->date)->toDateString(),
                        "color" => $color,
                    ];
                    $presentDate[] = $value->date;
                }

            }
        }

//Leave Days
        $leaveDate = array();
        $periods = array();
        $leaves = Leave::where('employee_id', $employee->id)->get();
        foreach ($leaves as $leave) {
            $periods[] = CarbonPeriod::create($leave->datefrom, $leave->dateto);
        }
        foreach ($periods as $period) {
            foreach ($period as $dates) {
                $leaveDate[] = $dates->format('Y-m-d');
            }
        }

//Leave DaysEnd
        $dow = [0, 1, 2, 3, 4, 5, 6];
        foreach ($branchWeekend as $day) {
            unset($dow[$days[$day]]);
        };
        $dow = implode(',', $dow);

        $leaveCount = array();
        foreach ($leaveDate as $leavecnt) {
            if (date('m', strtotime($leavecnt)) == $currentMonth && in_array(Carbon::parse($leavecnt)->format('l'), $branchWeekend) == false) {
                $leaveCount[] = $leavecnt;
            }
        }
        $JoiningDate = Employee::where('id', $employeeId)->first();
        $periods[] = CarbonPeriod::create($JoiningDate->joining_date, Carbon::now()->toDateString());
        $absentDates = array();
        foreach ($periods as $period) {
            foreach ($period as $dates) {
                $absentDates[] = $dates->format('Y-m-d');
            }
        }
        foreach ($absentDates as $date) {
            if (!in_array($date, $presentDate) && in_array(Carbon::parse($date)->format('l'), $branchWeekend) == false && in_array(Carbon::parse($date)->toDateString(), $leaveDate) == false) {
                $events[] = [
                    "title" => "Absent   ",
                    "date" => Carbon::parse($date)->toDateString(),
                    "color" => "red",
                ];
            }
        }
//For Absent Event
        $till_date = new DateTime();
        $absent = array();
        for ($i = 1; $i <= $till_date->format('d'); $i++) {
            $now = Carbon::now();
            $date = Carbon::parse($i . "-" . $now->month . "-" . $now->year)->toDateString();
            if (!in_array($date, $presentDate) && in_array(Carbon::parse($date)->format('l'), $branchWeekend) == false && in_array(Carbon::parse($date)->toDateString(), $leaveDate) == false) {
                $absent[] = "";
            }
        }
        $AbsentCount = count($absent);
        $leave = Leave::with('leaveType')->where('employee_id', $employee->id)->get();
        foreach ($leave as $key => $value) {
            $color = '';
            if ($value->leave_type == "Short Leave") {
                $color = '#C24BFF';
            }
            if ($value->leave_type === "Full Leave") {
                $color = 'red';
            }
            if ($value->leave_type === "Half Leave") {
                $color = '#57BB8A';
            }
            if ($value->leave_type == "Paid Leave") {
                $color = '#ADFF41';
            }
            $events[] = [
                "title" => $value->leaveType->name . "\n" . "Status:" . $value->status,
                "date" => $value->datefrom,
                "start" => Carbon::parse($value->datefrom)->toIso8601String(),
                "end" => date('Y-m-d', strtotime($value->dateto . ' +1 day')),
                "color" => $color
            ];
        }
        //Average Arrivals
        $averageArrivals = round(AttendanceSummary::where('employee_id', '=', $employee->id)->whereRaw('MONTH(date) = ?', [$currentMonth])->select(DB::raw('first_timestamp_in'))->avg('first_timestamp_in'));
        if ($averageArrivals == null) {
            $avgarival = '00:00';
        } else {
            $avgarival = Carbon::createFromTimestampUTC($averageArrivals)->format('g:i a');
        }

        //Average Attendance
        $absent = $AbsentCount;
        $present = AttendanceSummary::where('employee_id', $employee->id)->where('status', 'present')->whereRaw('MONTH(first_timestamp_in) = ?', [$currentMonth])->count();
        $totalAttendance = AttendanceSummary::where('employee_id', $employee->id)->whereRaw('MONTH(date) = ?', [$currentMonth])->count() + $absent;
        if ($totalAttendance != 0) {
            $averageAttendance = round(($present / $totalAttendance) * 100, 2);
        } else {
            $averageAttendance = 0;
        }
        //Average Hours
        $averageHours = AttendanceSummary::where('employee_id', '=', $employee->id)->whereRaw('MONTH(first_timestamp_in) = ?', [$currentMonth])->avg('total_time') / 60;

        //Line Manager
        $linemanagers = OrganizationHierarchy::with('lineManager')->where('employee_id', $employee->id)->get();
        $events = json_encode($events);
        return view('admin.attendance.myattendance', $this->metaResponse(), [
            'events' => $events
        ])->with('employeeId', $employeeId)
            ->with('employees', $employees)
            ->with('dow', $dow)
            ->with('averageHours', floor($averageHours))
            ->with('averageArrival', $avgarival)
            ->with('averageAttendance', $averageAttendance)
            ->with('linemanagers', $linemanagers)
            ->with('present', $present)
            ->with('absent', $absent)
            ->with('leaveCount', count($leaveCount));
    }

    public function correctionEmail(Request $request)
    {
        $data = array('name' => Auth::user()->firstname, 'messages' => "$request->message", 'email' => Auth::user()->official_email, 'date' => "$request->date");
        try {
            Mail::send('emails.attendance_correction_email', $data, function ($message) use ($request) {
                $message->to('awaid.anjum@gmail.com')->subject('Attendance Correction Request For Date ' . $request->date);
                if ($request->line_manager_email != "") {
                    $message->cc($request->line_manager_email);
                }
                $message->from('noreply@glowlogix.com', Auth::user()->official_email);
            });
        } catch (\Exception $e) {
            Session::flash('error', 'Email Not Send Please Set Email Configuration In .env File');
        }
        Session::flash('success', 'Correction Email Sent To the HR');
        return redirect()->back();
    }

    public function Attendance_Summary_Delete($id)
    {
        $attendance_summary_delete = AttendanceSummary::find($id);
        $attendance_summary_delete->delete();
        Session::flash('success', 'Attendance Deleted Successfully.');
        return redirect()->route("today_timeline");
    }

}
