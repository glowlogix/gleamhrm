<?php

namespace App\Http\Controllers;

use App\AttendanceSummary;
use App\Branch;
use App\Employee;
use App\EmployeeLeaveType;
use App\Leave;
use App\LeaveType;
use App\Mail\AdminApplyLeaveMail;
use App\Mail\ApplyLeaveMail;
use App\Mail\LeaveStatusMail;
use App\OrganizationHierarchy;
use App\Traits\MetaTrait;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;
use Session;

class LeaveController extends Controller
{
    use MetaTrait;

    public $leave_types = [
        'unpaid_leave' => 'Unpaid Leave',
        'half_leave'   => 'Half Leave',
        'short_leave'  => 'Short Leave',
        'paid_leave'   => 'Paid Leave',
        'sick_leave'   => 'Sick Leave',
        'casual_leave' => 'Casual Leave',
    ];

    public $statuses = [
        'pending'  => 'Pending',
        'approved' => 'Approved',
        'declined' => 'Declined',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employee = Auth::User();
        $this->meta['title'] = 'Show Leaves';
        $leaves = Leave::where('employee_id', $employee->id)->with('leaveType')->get();

        $consumed_leaves = 0;
        if ($leaves->count() > 0) {
            foreach ($leaves as $leave) {
                $datefrom = Carbon::parse($leave->datefrom);
                $dateto = Carbon::parse($leave->dateto);
                $consumed_leaves += $dateto->diffInDays($datefrom) + 1;
            }
        }

        return view('admin.leaves.showleaves', $this->metaResponse(), [
            'leaves'          => $leaves,
            'consumed_leaves' => $consumed_leaves,
            'employee'        => $employee,
        ]);
    }

    public function employeeleaves($id = '')
    {
        $this->meta['title'] = 'Show Employee Leaves';
        $user = Auth::user()->designation;
        $leaveEmployees = Employee::all();
        if ($user == 'CEO' || $user == 'Admin') {
            if ($id == 'Approved' || $id == 'Declined') {
                $leaves = Leave::leftJoin('employees', function ($join) {
                    $join->on('employees.id', '=', 'leaves.employee_id');
                    // $join->whereIn('leaves.status', ['', 'Pending']);
                })->where('leaves.status', $id);
            } else {
                $leaves = Leave::leftJoin('employees', function ($join) {
                    $join->on('employees.id', '=', 'leaves.employee_id');
                });
            }
        } else {
            $leaves = Leave::leftJoin('employees', function ($join) use ($user) {
                $join->on('employees.id', '=', 'leaves.employee_id');
                // $join->whereIn('leaves.status', ['', 'Pending']);
                $join->where(function ($q) use ($user) {
                    $q->where('leaves.line_manager', $user)
                        ->orWhere('leaves.point_of_contact', $user);
                });
            });
        }
        $leaves = $leaves->with('leaveType')->get([
            'leaves.employee_id AS employee_id',
            'leaves.id AS leave_id',
            'leaves.leave_type AS leave_type',
            'leaves.datefrom AS datefrom',
            'leaves.dateto AS dateto',
            'leaves.subject AS leave_subject',
            'leaves.line_manager AS line_manager',
            'leaves.point_of_contact AS point_of_contact',
            'leaves.status AS leave_status',
            'leaves.id AS leave_id',
        ]);

        return view('admin.leaves.employeeleaves', $this->metaResponse(), [
            'employees' => $leaves,
            'leaveEmployees' => $leaveEmployees,
        ])->with('id', $id);
    }

    public function indexEmployee($id)
    {
        $this->meta['title'] = 'Show Leaves';
        $leaves = Leave::where('employee_id', $id)->get();

        return view('admin.leaves.employeeshowleaves', $this->metaResponse(), ['leaves' => $leaves]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id = Auth::User()->id;
        $this->meta['title'] = 'Create Leave';
        $OrganizationHierarchy = OrganizationHierarchy::where('employee_id', $id)->with('lineManager')->first();
        $employees = Employee::all();
        $line_manager = isset($OrganizationHierarchy->lineManager) ? $OrganizationHierarchy->lineManager : '';

        return view('admin.leaves.create', $this->metaResponse(), [
            'employees'    => $employees,
            'line_manager' => $line_manager,
            'leave_types'  => LeaveType::where('status', '1')->get(),
        ]);
    }

    public function adminCreate($id = '')
    {
        if ($id != '') {
            $employee_id = $id;
        } else {
            $employee_id = Auth::user()->id;
        }
        $this->meta['title'] = 'Create Leave';
        $OrganizationHierarchy = OrganizationHierarchy::where('employee_id', $employee_id)->with('lineManager')->first();
        $employees = Employee::where('status', '!=', '0')->orderBy('firstname')->get();
        $selectedEmployee = Employee::where('id', $employee_id)->first();
        $line_manager = isset($OrganizationHierarchy->lineManager) ? $OrganizationHierarchy->lineManager : '';

        return view('admin.leaves.admincreateleave', $this->metaResponse(), [
            'employees'        => $employees,
            'line_manager'     => $line_manager,
            'leave_types'      => LeaveType::where('status', '1')->get(),
            'selectedEmployee' => $selectedEmployee,
        ]);
    }

    public function EmployeeCreate()
    {
        $this->meta['title'] = 'Create Leave';
        $employees = Employee::all();

        return view('admin.leaves.create', $this->metaResponse(), ['employees' => $employees]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function adminStore(Request $request)
    {
        $this->validate($request, [
            'leave_type' => 'required',
            'datefrom'   => 'required',
            'dateto'     => 'required|after_or_equal:datefrom',
        ]);

        // Remaining leave count functionality
        $currentYear = Carbon::now();
        $currentYear = $currentYear->year;
        $approvedLeaveDate = [];
        $approvedPeriods = [];
        $leaveType = LeaveType::find($request->leave_type);
        $availedLeaves = Leave::where('employee_id', $request->employee)->where('leave_type', $request->leave_type)->where('status', '!=', 'Declined')->whereRaw('YEAR(datefrom) = ?', $currentYear)->get();

        if ($availedLeaves != '[]') {
            foreach ($availedLeaves as $availedLeave) {
                $availedPeriods[] = CarbonPeriod::create($availedLeave->datefrom, $availedLeave->dateto);
            }
            foreach ($availedPeriods as $availedPeriod) {
                foreach ($availedPeriod as $availedDates) {
                    $availedLeaveDate[] = $availedDates->format('Y-m-d');
                }
            }
            foreach ($availedLeaveDate as $leaveDate) {
                $Availed[] = $leaveDate;
            }
            $employeeAvailedLeaves = count($Availed);
            $employeeRemainingLeaves = $leaveType->count - $employeeAvailedLeaves;
        } else {
            $employeeAvailedLeaves = 0;
            $employeeRemainingLeaves = $leaveType->count - $employeeAvailedLeaves;
        }

        // Requested leave count functionality
        $requestedPeriods[] = CarbonPeriod::create($request->datefrom, $request->dateto);
        foreach ($requestedPeriods as $requestedPeriod) {
            foreach ($requestedPeriod as $requestedDates) {
                $requestedLeaveDate[] = $requestedDates->format('Y-m-d');
            }
        }
        foreach ($requestedLeaveDate as $leaveDate) {
            $requested[] = $leaveDate;
        }
        $employeeRequestedLeaves = count($requested);

        // Condition for leave functionality
        if ($employeeRequestedLeaves <= $employeeRemainingLeaves) {
            $employee_id = $request->employee;
            $leave_type = $request->leave_type;

            $dateFromTime = Carbon::parse($request->datefrom);
            $dateToTime = Carbon::parse($request->dateto);

            $consumed_leaves = $dateToTime->diffInDays($dateFromTime) + 1;

            $attendance_summaries = AttendanceSummary::where(['employee_id' => $employee_id])
                ->whereDate('date', '>=', $dateFromTime->toDateString())
                ->whereDate('date', '<=', $dateToTime->toDateString())
                ->get();

            if ($attendance_summaries->count() > 0) {
                $msg = '';
                foreach ($attendance_summaries as $key => $attendance_summary) {
                    $msg .= ' '.$attendance_summary->date;
                }
                Session::flash('error', 'Employee was already present on dates: '.$msg);

                return redirect()->back();
            }

            $leave_summary = Leave::where(['employee_id' => $employee_id])
            ->whereDate('datefrom', '>=', $dateFromTime->toDateString())
            ->whereDate('dateto', '<=', $dateToTime->toDateString())
            ->get();
            if ($leave_summary->count() > 0) {
                Session::flash('error', 'Employee leave is already applied for selected dates');

                return redirect()->back();
            }

            $leave = Leave::create([
                'employee_id'      => $employee_id,
                'leave_type'       => $leave_type,
                'datefrom'         => $dateFromTime,
                'dateto'           => $dateToTime,
                'subject'          => $request->subject,
                'description'      => $request->description,
                'point_of_contact' => $request->point_of_contact,
                'line_manager'     => $request->line_manager,
                'cc_to'            => $request->cc_to,
                'status'           => $request->status,
            ]);

            // $this->sendEmail($leave);

            if ($leave) {
                $employee = Employee::find($leave->employee_id);
                try {
                    Mail::to($employee->official_email)->send(new AdminApplyLeaveMail($request, $employee, $request->email));
                } catch (\Exception $e) {
                    Session::flash('error', trans($e->getMessage()));
                }

                Session::flash('success', 'Leave for Employee is created successfully');

                return redirect()->route('employeeleaves');
            }
        } else {
            Session::flash('error', 'Leave limit exceed. Please try again.');

            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'datefrom' => 'required',
            'dateto'   => 'required|after_or_equal:datefrom',
        ]);

        // Remaining leave count functionality
        $currentYear = Carbon::now();
        $currentYear = $currentYear->year;
        $approvedLeaveDate = [];
        $approvedPeriods = [];
        $leaveType = LeaveType::find($request->leave_type);
        $availedLeaves = Leave::where('employee_id', Auth::User()->id)->where('leave_type', $request->leave_type)->where('status', '!=', 'Declined')->whereRaw('YEAR(datefrom) = ?', $currentYear)->get();

        if ($availedLeaves != '[]') {
            foreach ($availedLeaves as $availedLeave) {
                $availedPeriods[] = CarbonPeriod::create($availedLeave->datefrom, $availedLeave->dateto);
            }
            foreach ($availedPeriods as $availedPeriod) {
                foreach ($availedPeriod as $availedDates) {
                    $availedLeaveDate[] = $availedDates->format('Y-m-d');
                }
            }
            foreach ($availedLeaveDate as $leaveDate) {
                $Availed[] = $leaveDate;
            }
            $employeeAvailedLeaves = count($Availed);
            $employeeRemainingLeaves = $leaveType->count - $employeeAvailedLeaves;
        } else {
            $employeeAvailedLeaves = 0;
            $employeeRemainingLeaves = $leaveType->count - $employeeAvailedLeaves;
        }

        // Requested leave count functionality
        $requestedPeriods[] = CarbonPeriod::create($request->datefrom, $request->dateto);
        foreach ($requestedPeriods as $requestedPeriod) {
            foreach ($requestedPeriod as $requestedDates) {
                $requestedLeaveDate[] = $requestedDates->format('Y-m-d');
            }
        }
        foreach ($requestedLeaveDate as $leaveDate) {
            $requested[] = $leaveDate;
        }
        $employeeRequestedLeaves = count($requested);

        // Condition for leave functionality
        if ($employeeRequestedLeaves <= $employeeRemainingLeaves) {
            $employee_id = Auth::User()->id;
            $leave_type = $request->leave_type;

            $dateFromTime = Carbon::parse($request->datefrom);
            $dateToTime = Carbon::parse($request->dateto);

            $consumed_leaves = $dateToTime->diffInDays($dateFromTime) + 1;

            $attendance_summaries = AttendanceSummary::where(['employee_id' => $employee_id])
                ->whereDate('date', '>=', $dateFromTime->toDateString())
                ->whereDate('date', '<=', $dateToTime->toDateString())
                ->get();

            if ($attendance_summaries->count() > 0) {
                $msg = '';
                foreach ($attendance_summaries as $key => $attendance_summary) {
                    $msg .= ' '.$attendance_summary->date;
                }
                Session::flash('error', 'Employee was already present on dates: '.$msg);

                return redirect()->back();
            }

            $leave_summary = Leave::where(['employee_id' => $employee_id])
            ->whereDate('datefrom', '>=', $dateFromTime->toDateString())
            ->whereDate('dateto', '<=', $dateToTime->toDateString())
            ->get();
            if ($leave_summary->count() > 0) {
                Session::flash('error', 'Employee leave is already applied for selected dates');

                return redirect()->back();
            }

            $leave = Leave::create([
                'employee_id'      => $employee_id,
                'leave_type'       => $leave_type,
                'datefrom'         => $dateFromTime,
                'dateto'           => $dateToTime,
                'subject'          => $request->subject,
                'description'      => $request->description,
                'point_of_contact' => $request->point_of_contact,
                'line_manager'     => $request->line_manager,
                'cc_to'            => $request->cc_to,
                'status'           => 'pending',
            ]);

            if ($leave) {
                try {
                    Mail::to($request->email)->send(new ApplyLeaveMail($request, $leave, Auth::user()->official_email));
                } catch (\Exception $e) {
                    Session::flash('error', trans($e->getMessage()));
                }

                Session::flash('success', 'Leave is created succesfully');

                return redirect()->route('leave.index');
            }
        } else {
            Session::flash('error', 'Leave limit exceed. Please try again.');

            return redirect()->back();
        }
    }

    public function sendEmail($leave, Request $request)
    {
        Mail::raw($leave->description, function ($message) use ($leave) {
            $message->from('hr@glowlogix.com', 'HR GlowLogix');
            $message->to($leave->cc_to)->subject($leave->subject);
        });

        return 'mail sent to '.$request->email;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->meta['title'] = 'Leave Details';

        $leave = Leave::where(['id' => $id])->with([
            // $leave = Leave::find($id)->with([
            'employee',
            'lineManager',
            'pointOfContact',
            'leaveType',
        ])->first();

        $dateFromTime = Carbon::parse($leave->datefrom);
        $dateToTime = Carbon::parse($leave->dateto);
        $leave_days = $dateToTime->diffInDays($dateFromTime) + 1;
        $period = CarbonPeriod::create($dateFromTime, $dateToTime);

        $branch_id = $leave->employee->branch_id;
        $branch = Branch::find($branch_id);

        // Iterate over the period
        foreach ($period as $date) {
            if (strstr($branch->address, 'Islamabad')) { //if islamabad offc sat off
                if ($date->format('l') == 'Saturday') {
                    $leave_days--;
                }
            }
            if ($date->format('l') == 'Sunday') {
                $leave_days--;
            }
        }

        return view('admin.leaves.show', $this->metaResponse(), [
            'leave'      => $leave,
            'leave_days' => $leave_days,
        ]);
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

        $employee_id = Auth::User()->id;
        $OrganizationHierarchy = OrganizationHierarchy::where('employee_id', $employee_id)->with('lineManager')->first();
        $line_manager = isset($OrganizationHierarchy->lineManager) ? $OrganizationHierarchy->lineManager : '';

        $employees = Employee::all();

        $leave = Leave::find($id);
        // $this->sendEmail($leave);

        return view('admin.leaves.edit', $this->metaResponse(), [
            'employees'    => $employees,
            'line_manager' => $line_manager,
            'leave_types'  => LeaveType::all(),
            'leave'        => $leave,
        ]);
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
        $leave = Leave::find($id);

        $this->validate($request, [
            'datefrom' => 'required',
            'dateto'   => 'required|after_or_equal:datefrom',
        ]);

        // Remaining leave count functionality
        $currentYear = Carbon::now();
        $currentYear = $currentYear->year;
        $approvedLeaveDate = [];
        $approvedPeriods = [];
        $leaveType = LeaveType::find($request->leave_type);
        $availedLeaves = Leave::where('id', '!=', $id)->where('employee_id', $leave->employee_id)->where('leave_type', $request->leave_type)->where('status', '!=', 'Declined')->whereRaw('YEAR(datefrom) = ?', $currentYear)->get();

        if ($availedLeaves != '[]') {
            foreach ($availedLeaves as $availedLeave) {
                $availedPeriods[] = CarbonPeriod::create($availedLeave->datefrom, $availedLeave->dateto);
            }
            foreach ($availedPeriods as $availedPeriod) {
                foreach ($availedPeriod as $availedDates) {
                    $availedLeaveDate[] = $availedDates->format('Y-m-d');
                }
            }
            foreach ($availedLeaveDate as $leaveDate) {
                $Availed[] = $leaveDate;
            }
            $employeeAvailedLeaves = count($Availed);
            $employeeRemainingLeaves = $leaveType->count - $employeeAvailedLeaves;
        } else {
            $employeeAvailedLeaves = 0;
            $employeeRemainingLeaves = $leaveType->count - $employeeAvailedLeaves;
        }

        // Requested leave count functionality
        $requestedPeriods[] = CarbonPeriod::create($request->datefrom, $request->dateto);
        foreach ($requestedPeriods as $requestedPeriod) {
            foreach ($requestedPeriod as $requestedDates) {
                $requestedLeaveDate[] = $requestedDates->format('Y-m-d');
            }
        }
        foreach ($requestedLeaveDate as $leaveDate) {
            $requested[] = $leaveDate;
        }
        $employeeRequestedLeaves = count($requested);

        // Condition for leave functionality
        if ($employeeRequestedLeaves <= $employeeRemainingLeaves) {
            $dateFromTime = Carbon::parse($request->datefrom);
            $dateToTime = Carbon::parse($request->dateto);

            $consumed_leaves = $dateToTime->diffInDays($dateFromTime) + 1;

            $attendance_summaries = AttendanceSummary::where(['employee_id' => $leave->employee_id])
                ->whereDate('date', '>=', $dateFromTime->toDateString())
                ->whereDate('date', '<=', $dateToTime->toDateString())
                ->get();

            if ($attendance_summaries->count() > 0) {
                $msg = '';
                foreach ($attendance_summaries as $key => $attendance_summary) {
                    $msg .= ' '.$attendance_summary->date;
                }
                Session::flash('error', 'Employee was already present on dates: '.$msg);

                return redirect()->back();
            }

            $leave->leave_type = $request->leave_type;
            $leave->datefrom = $dateFromTime;
            $leave->dateto = $dateToTime;
            $leave->subject = $request->subject;
            $leave->description = $request->description;
            $leave->line_manager = $request->line_manager;
            $leave->point_of_contact = $request->point_of_contact;
            $leave->cc_to = $request->cc_to;
            $leave->status = 'Pending';

            $leave = $leave->save();
            Session::flash('success', 'Leave is created succesfully');

            return redirect()->route('leave.index');
        } else {
            Session::flash('error', 'Leave limit exceed. Please try again.');

            return redirect()->back();
        }
    }

    public function updateEmployeeLeaveType($employee_id, $leave_type_id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request)
    {
        $leave = Leave::find($request->id);
        if ($leave->status == 'Approved') { // if already approved do nothing
            Session::flash('success', 'Leave already approved');

            return redirect()->back();
        }

        if ($request->status == 'Approved') {
            $dateFromTime = Carbon::parse($leave->datefrom);
            $dateToTime = Carbon::parse($leave->dateto);

            $consumed_leaves = $dateToTime->diffInDays($dateFromTime) + 1;

            $employee_leave_type = EmployeeLeaveType::where([
                'employee_id'   => $leave->employee_id,
                'leave_type_id' => $leave->leave_type,
            ])->first();

            $cnt = $employee_leave_type->count -= $consumed_leaves;

            DB::statement("UPDATE employee_leave_type SET count = $cnt where employee_id = ".$leave->employee_id.' AND leave_type_id = '.$leave->leave_type);
        }

        $leave->status = $request->status;
        $leave->save();

        $employee = Employee::find($leave->employee_id);
        try {
            Mail::to($employee->official_email)->send(new LeaveStatusMail($leave, $employee, $request->email));
        } catch (\Exception $e) {
            Session::flash('error', trans($e->getMessage()));
        }

        Session::flash('success', 'Leave status is updated successfully');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function destroy(Leave $leave, $id)
    {
        $leave = Leave::where('employee_id', $id)->first();
        $leave->delete();
        Session::flash('success', 'Leave is deleted successfully');

        return redirect()->back();
    }

    public function leaveDelete($id)
    {
        $leave = Leave::where('id', $id)->first();
        $leave->delete();
        Session::flash('success', 'Leave is deleted successfully');

        return redirect()->back();
    }
}
