<?php

namespace App\Http\Controllers;

use App\Leave;
use App\Employee;
use App\AttendanceSummary;
use Illuminate\Http\Request;
use App\Traits\MetaTrait;
use Carbon\Carbon;
use Session;

class LeaveController extends Controller
{
    use MetaTrait;
    
    public $leave_types = [
        "unpaid_leave" => "Unpaid Leave",
        "half_leave" => "Half Leave",
        "short_leave" => "Short Leave",
        "paid_leave" => "Paid Leave",
        "sick_leave" => "Sick Leave",
        "casual_leave" => "Casual Leave",
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        // dd(Auth::user());
        $this->meta['title'] = 'Show Leaves';  
        $leaves = Leave::where('employee_id', $id)->get();
        
        return view('admin.leaves.showleaves',$this->metaResponse(),['leaves' => $leaves]);
    }

    public function indexEmployee($id)
    {
        $this->meta['title'] = 'Show Leaves';  
        $leaves = Leave::where('employee_id', $id)->get();
        
        return view('admin.leaves.employeeshowleaves',$this->metaResponse(),['leaves' => $leaves]);
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
        return view('admin.leaves.create',$this->metaResponse(),['employees' => $employees]);
    }

    public function EmployeeCreate()
    {
        $this->meta['title'] = 'Create Leave';    
        $employees = Employee::all();
        return view('admin.leaves.create',$this->metaResponse(),['employees' => $employees]);
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
            'employee_id' => 'required',
            'datefrom' => 'required',
            'dateto' => 'required|after_or_equal:datefrom',
        ]);

        $employee_id = $request->employee_id;
        $leave_type = $request->leave_type;
        $dateFrom = $request->datefrom;
        $dateFromTime = Carbon::parse($dateFrom);

        $dateTo = $request->dateto;
        $dateToTime = Carbon::parse($dateTo);
        
        $attendance_summaries = AttendanceSummary::where(['employee_id' => $employee_id])
            ->whereDate('date', '>=', $dateFromTime->toDateString())
            ->whereDate('date', '<=', $dateToTime->toDateString())
            ->get();

        if($attendance_summaries->count() > 0){
            $msg = '';
            foreach ($attendance_summaries as $key => $attendance_summary) {
                $msg .= ' '. $attendance_summary->date;
            }
            return redirect()->back()->with('error','Employee was already present on dates: '. $msg);
        }
        
        $leave = Leave::create([
            'employee_id' => $employee_id,
            'leave_type' => $leave_type,
            'datefrom' => $dateFromTime,
            'dateto' => $dateToTime,
            'subject' => $request->subject,
            'description' => $request->description,
            'point_of_contact' => $request->point_of_contact,
            'cc_to' => $request->cc_to,
            'status' => $request->status,
        ]);

        if($leave){
           return redirect()->route('leave.show', $employee_id)->with('success','Leave is created succesfully');
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
        $employees = Employee::all(); 
        $leave = Leave::find($id);        

        return view('admin.leaves.edit',['leave' => $leave, 'employees' => $employees],$this->metaResponse());
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
        $this->validate($request,[
            'datefrom' => 'required',
            'dateto' => 'required|after_or_equal:datefrom',
        ]);

        $dateFromTime = Carbon::parse($request->datefrom);
        $dateToTime = Carbon::parse($request->dateto);
        
        $attendance_summaries = AttendanceSummary::where(['employee_id' => $request->employee_id])
            ->whereDate('date', '>=', $dateFromTime->toDateString())
            ->whereDate('date', '<=', $dateToTime->toDateString())
            ->get();

        if($attendance_summaries->count() > 0){
            $msg = '';
            foreach ($attendance_summaries as $key => $attendance_summary) {
                $msg .= ' '. $attendance_summary->date;
            }
            return redirect()->back()->with('error','Employee was already present on dates: '. $msg);
        }

        $leave = Leave::find($id);
        $leave->employee_id =  $request->employee_id;
        $leave->leave_type =  $request->leave_type;
        $leave->datefrom =  $dateFromTime;
        $leave->dateto =  $dateToTime;
        $leave->subject =  $request->subject;
        $leave->description =  $request->description;
        $leave->line_manager =  $request->line_manager;
        $leave->point_of_contact =  $request->point_of_contact;
        $leave->cc_to =  $request->cc_to;
        $leave->status = $request->status;

        $leave = $leave->save();
        return redirect()->route('leave.show', $request->employee_id)->with('success','Leave is created succesfully');

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
