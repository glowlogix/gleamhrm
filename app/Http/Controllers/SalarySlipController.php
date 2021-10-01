<?php

namespace App\Http\Controllers;

use App\AttendanceSummary;
use App\Branch;
use App\Department;
use App\Employee;
use App\Leave;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;

class SalarySlipController extends Controller
{
    public function index($month = '')
    {
        if ($month == '') {
            $month = Carbon::now()->format('Y-m');
        }

        $currentMonth = Carbon::parse($month)->format('m');
        $UnApprovedCount = [];
        $approvedCount = [];
        $absentDeduction = [];
        $leavesDeduction = [];
        $netPayables = [];
        $employeeApprovedLeaves = [];
        if (Auth::user()->isAllowed('SalaryController')) {
            $salaryEmployees = Employee::all();
        } else {
            $salaryEmployees = Employee::where('id', Auth::user()->id)->with('salary')->get();
        }

        foreach ($salaryEmployees as $employee) {
            $weekend = Branch::where('id', $employee->branch_id)->first();

            /* Present Dates */
            $attendance_summaries = AttendanceSummary::where('employee_id', $employee->id)->whereRaw('MONTH(first_timestamp_in) = ?', [$currentMonth])->get();
            $presentDate = [];
            if ($attendance_summaries->count() > 0) {
                foreach ($attendance_summaries as $key => $value) {
                    $presentDate[] = $value->date;
                }
            }

            $present[$employee->id] = AttendanceSummary::where('employee_id', $employee->id)->whereRaw('MONTH(first_timestamp_in) = ?', [$currentMonth])->count();

            /* Un-Approved Leaves */
            $unApprovedLeaveDate = [];
            $unApprovedPeriods = [];
            $unAapprovedLeaves = Leave::where('employee_id', $employee->id)->where('status', 'Declined')->whereRaw('MONTH(datefrom) = ?', $currentMonth)->get();

            foreach ($unAapprovedLeaves as $unApprovedLeave) {
                $approvedPeriods[] = CarbonPeriod::create($unApprovedLeave->datefrom, $unApprovedLeave->dateto);
            }
            foreach ($unApprovedPeriods as $unApprovedPeriod) {
                foreach ($unApprovedPeriod as $unApprovedDates) {
                    $unApprovedLeaveDate[] = $unApprovedDates->format('Y-m-d');
                }
            }

            $unApproved = [];
            foreach ($unApprovedLeaveDate as $unLeaveDate) {
                if (date('m', strtotime($unLeaveDate)) == $currentMonth && in_array(Carbon::parse($unLeaveDate)->format('l'), json_decode($weekend->weekend)) == false) {
                    $unApproved[] = $unLeaveDate;
                }
            }
            $employeeUnApprovedLeaves[$employee->id] = count($unApproved);

            /* Approved Leaves */
            $approvedLeaveDate = [];
            $approvedPeriods = [];
            $approvedLeaves = Leave::where('employee_id', $employee->id)->where('status', 'Approved')->whereRaw('MONTH(datefrom) = ?', $currentMonth)->get();

            foreach ($approvedLeaves as $approvedLeave) {
                $approvedPeriods[] = CarbonPeriod::create($approvedLeave->datefrom, $approvedLeave->dateto);
            }
            foreach ($approvedPeriods as $approvedPeriod) {
                foreach ($approvedPeriod as $approvedDates) {
                    $approvedLeaveDate[] = $approvedDates->format('Y-m-d');
                }
            }

            $Approved = [];
            foreach ($approvedLeaveDate as $leaveDate) {
                if (date('m', strtotime($leaveDate)) == $currentMonth && in_array(Carbon::parse($leaveDate)->format('l'), json_decode($weekend->weekend)) == false) {
                    $Approved[] = $leaveDate;
                }
            }
            $employeeApprovedLeaves[$employee->id] = count($Approved);

            $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $currentMonth, Carbon::parse($month)->year);
            $workingDays = 0;
            $mothDays = 0;
            for ($i = 1; $i <= $numberOfDays; $i++) {
                $date = Carbon::parse($i.'-'.$currentMonth.'-'.Carbon::parse($month)->year)->toDateString();
                $mothDays += 1;
                if (in_array(Carbon::parse($date)->format('l'), json_decode($weekend->weekend)) == false) {
                    $workingDays += 1;
                }
            }

            /* Absents */
            $absent = [];
            for ($i = 1; $i <= $mothDays; $i++) {
                $date = Carbon::parse($i.'-'.$currentMonth.'-'.Carbon::parse($month)->format('Y'))->toDateString();
                if (! in_array($date, $presentDate) && in_array(Carbon::parse($date)->format('l'), json_decode($weekend->weekend)) == false && in_array(Carbon::parse($date)->toDateString(), $Approved) == false && in_array(Carbon::parse($date)->toDateString(), $unApproved) == false) {
                    $absent[] = '';
                }
            }
            $AbsentCount[$employee->id] = count($absent);
            $approvedCount[$employee->id] = $employeeApprovedLeaves[$employee->id];
            $unApprovedCount[$employee->id] = $employeeUnApprovedLeaves[$employee->id];

            if ($employee->emloyment_status != 'probation') {
                if ($approvedCount[$employee->id] > 1) {
                    $approvedDeduction = (($employee->gross_salary / $workingDays) * (($approvedCount[$employee->id]) - 1));
                } else {
                    $approvedDeduction = 0;
                }
            } elseif ($employee->emloyment_status == 'probation') {
                $approvedDeduction = $approvedCount[$employee->id];
            }
            $absentDeduction[$employee->id] = ($employee->gross_salary / $workingDays) * $AbsentCount[$employee->id];
            $netPayables[$employee->id] = round(($employee->gross_salary - ($employeeUnApprovedLeaves[$employee->id] * 2) - $approvedDeduction - $absentDeduction[$employee->id]) + ($employee->bonus));
            if (isset($employee['salary'])) {
                $netPayables[$employee->id] = $netPayables[$employee->id] - $employee['salary']->pf_deduction;
            }
        }

        if (Auth::user()->isAllowed('SalaryController')) {
            $employees = Employee::all();
        } else {
            $employees = Employee::where('id', Auth::user()->id)->with('salary')->get();
        }

        return view('admin.salary.salary_slips')
        ->with('month', $month)
        ->with('employees', $employees)
        ->with('ApprovedCount', $approvedCount)
        ->with('unApprovedCount', $unApprovedCount)
        ->with('netPayables', $netPayables)
        ->with('AbsentCounts', $AbsentCount)
        ->with('presents', $present);
    }

    public function showSalarySlip($data, $month = '', $user_id)
    {
        if ($month == '') {
            $month = Carbon::now()->format('Y-m');
        }

        $currentMonth = Carbon::parse($month)->format('m');
        $UnApprovedCount = [];
        $approvedCount = [];
        $absentDeduction = [];
        $leavesDeduction = [];
        $subtotal = [];
        $employeeApprovedLeaves = [];
        $salaryEmployee = Employee::where('id', $user_id)->with('salary')->get();

        foreach ($salaryEmployee as $employee) {
            $weekend = Branch::where('id', $employee->branch_id)->first();

            /* Present Dates */
            $attendance_summaries = AttendanceSummary::where('employee_id', $employee->id)->whereRaw('MONTH(first_timestamp_in) = ?', [$currentMonth])->get();
            $presentDate = [];
            if ($attendance_summaries->count() > 0) {
                foreach ($attendance_summaries as $key => $value) {
                    $presentDate[] = $value->date;
                }
            }

            $present[$employee->id] = AttendanceSummary::where('employee_id', $employee->id)->whereRaw('MONTH(first_timestamp_in) = ?', [$currentMonth])->count();

            /* Un-Approved Leaves */
            $unApprovedLeaveDate = [];
            $unApprovedPeriods = [];
            $unAapprovedLeaves = Leave::where('employee_id', $employee->id)->where('status', 'Declined')->whereRaw('MONTH(datefrom) = ?', $currentMonth)->get();

            foreach ($unAapprovedLeaves as $unApprovedLeave) {
                $approvedPeriods[] = CarbonPeriod::create($unApprovedLeave->datefrom, $unApprovedLeave->dateto);
            }
            foreach ($unApprovedPeriods as $unApprovedPeriod) {
                foreach ($unApprovedPeriod as $unApprovedDates) {
                    $unApprovedLeaveDate[] = $unApprovedDates->format('Y-m-d');
                }
            }

            $unApproved = [];
            foreach ($unApprovedLeaveDate as $unLeaveDate) {
                if (date('m', strtotime($unLeaveDate)) == $currentMonth && in_array(Carbon::parse($unLeaveDate)->format('l'), json_decode($weekend->weekend)) == false) {
                    $unApproved[] = $unLeaveDate;
                }
            }
            $employeeUnApprovedLeaves[$employee->id] = count($unApproved);

            /* Approved Leaves */
            $approvedLeaveDate = [];
            $approvedPeriods = [];
            $approvedLeaves = Leave::where('employee_id', $employee->id)->where('status', 'Approved')->whereRaw('MONTH(datefrom) = ?', $currentMonth)->get();

            foreach ($approvedLeaves as $approvedLeave) {
                $approvedPeriods[] = CarbonPeriod::create($approvedLeave->datefrom, $approvedLeave->dateto);
            }
            foreach ($approvedPeriods as $approvedPeriod) {
                foreach ($approvedPeriod as $approvedDates) {
                    $approvedLeaveDate[] = $approvedDates->format('Y-m-d');
                }
            }

            $Approved = [];
            foreach ($approvedLeaveDate as $leaveDate) {
                if (date('m', strtotime($leaveDate)) == $currentMonth && in_array(Carbon::parse($leaveDate)->format('l'), json_decode($weekend->weekend)) == false) {
                    $Approved[] = $leaveDate;
                }
            }
            $employeeApprovedLeaves[$employee->id] = count($Approved);

            $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $currentMonth, Carbon::parse($month)->year);
            $workingDays = 0;
            $mothDays = 0;
            for ($i = 1; $i <= $numberOfDays; $i++) {
                $date = Carbon::parse($i.'-'.$currentMonth.'-'.Carbon::parse($month)->year)->toDateString();
                $mothDays += 1;
                if (in_array(Carbon::parse($date)->format('l'), json_decode($weekend->weekend)) == false) {
                    $workingDays += 1;
                }
            }

            /* Absents */
            $absent = [];
            for ($i = 1; $i <= $mothDays; $i++) {
                $date = Carbon::parse($i.'-'.$currentMonth.'-'.Carbon::parse($month)->format('Y'))->toDateString();
                if (! in_array($date, $presentDate) && in_array(Carbon::parse($date)->format('l'), json_decode($weekend->weekend)) == false && in_array(Carbon::parse($date)->toDateString(), $Approved) == false && in_array(Carbon::parse($date)->toDateString(), $unApproved) == false) {
                    $absent[] = '';
                }
            }
            $AbsentCount[$employee->id] = count($absent);
            $approvedCount[$employee->id] = $employeeApprovedLeaves[$employee->id];
            $unApprovedCount[$employee->id] = $employeeUnApprovedLeaves[$employee->id];

            if ($employee->emloyment_status != 'probation') {
                if ($approvedCount[$employee->id] > 1) {
                    $approvedDeduction = (($employee->gross_salary / $workingDays) * (($approvedCount[$employee->id]) - 1));
                } else {
                    $approvedDeduction = 0;
                }
            } elseif ($employee->emloyment_status == 'probation') {
                $approvedDeduction = $approvedCount[$employee->id];
            }
            $absentDeduction[$employee->id] = ($employee->gross_salary / $workingDays) * $AbsentCount[$employee->id];
            $subtotal[$employee->id] = round(($employee->gross_salary - ($employeeUnApprovedLeaves[$employee->id] * 2) - $approvedDeduction - $absentDeduction[$employee->id]) + ($employee->bonus));
        }

        $employees = Employee::where('id', $user_id)->with('salary')->get();
        $departments = Department::all();

        $month = Carbon::parse($month)->format('M-Y');

        if ($data == 'print') {
            return view('admin.salary.print_salary_slip')
            ->with('month', $month)
            ->with('employees', $employees)
            ->with('subtotal', $subtotal[$employee->id])
            ->with('departments', $departments);
        }

        if ($data == 'show') {
            return view('admin.salary.monthly_salary_slip')
            ->with('month', $month)
            ->with('employees', $employees)
            ->with('subtotal', $subtotal[$employee->id])
            ->with('departments', $departments);
        }

        if ($data == 'generate') {
            $pdf = \PDF::loadView('admin.salary.generate_salary_slip', [
                'month'       => $month,
                'employees'   => $employees,
                'subtotal'    => $subtotal[$employee->id],
                'month'       => $month,
                'departments' => $departments,
            ]);

            return $pdf->stream();
        }
    }
}
