<?php

namespace App\Http\Controllers;

use App\AttendanceSummary;
use App\Branch;
use App\Employee;
use App\Leave;
use App\Salary;
use App\Traits\MetaTrait;
use Box\Spout\Common\Type;
use Box\Spout\Writer\WriterFactory;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DB;
use Illuminate\Http\Request;
use Session;

class SalariesController extends Controller
{
    use MetaTrait;

    public function index($id = '')
    {
        if ($id == '') {
            $id = Carbon::now()->format('Y-m');
        }

        $this->meta['title'] = 'All Salaries';
        $currentMonth = Carbon::parse($id)->format('m');
        $UnApprovedCount = [];
        $approvedCount = [];
        $absentDeduction = [];
        $leavesDeduction = [];
        $netPayables = [];
        $employeeApprovedLeaves = [];
        $salaryEmployees = Employee::where('status', '!=', '0')->get();

        foreach ($salaryEmployees as $employee) {
            $weekend = Branch::where('id', $employee->branch_id)->first();
            //Present Dates
            $attendance_summaries = AttendanceSummary::where('employee_id', $employee->id)->whereRaw('MONTH(first_timestamp_in) = ?', [$currentMonth])->get();
            $presentDate = [];
            if ($attendance_summaries->count() > 0) {
                foreach ($attendance_summaries as $key => $value) {
                    $presentDate[] = $value->date;
                }
            }

            $present[$employee->id] = AttendanceSummary::where('employee_id', $employee->id)->whereRaw('MONTH(first_timestamp_in) = ?', [$currentMonth])->count();
            ///////////
            ///Un Approved Leaves
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

            /////////

            /*Approved Leaves*/
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

            /////////
            $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $currentMonth, Carbon::parse($id)->year);
            $workingDays = 0;
            $mothDays = 0;
            for ($i = 1; $i <= $numberOfDays; $i++) {
                $date = Carbon::parse($i.'-'.$currentMonth.'-'.Carbon::parse($id)->year)->toDateString();
                $mothDays += 1;
                if (in_array(Carbon::parse($date)->format('l'), json_decode($weekend->weekend)) == false) {
                    $workingDays += 1;
                }
            }

            /////Absents
            $absent = [];
            for ($i = 1; $i <= $mothDays; $i++) {
                $date = Carbon::parse($i.'-'.$currentMonth.'-'.Carbon::parse($id)->format('Y'))->toDateString();
                if (! in_array($date, $presentDate) && in_array(Carbon::parse($date)->format('l'), json_decode($weekend->weekend)) == false && in_array(Carbon::parse($date)->toDateString(), $Approved) == false && in_array(Carbon::parse($date)->toDateString(), $unApproved) == false) {
                    $absent[] = '';
                }
            }
            $AbsentCount[$employee->id] = count($absent);
            $approvedCount[$employee->id] = $employeeApprovedLeaves[$employee->id];
            $unApprovedCount[$employee->id] = $employeeUnApprovedLeaves[$employee->id];

            if ($employee->emloyment_status != 'probation') {
                if ($approvedCount[$employee->id] > 1) {
                    $approvedDeduction = (($employee->basic_salary / $workingDays) * (($approvedCount[$employee->id]) - 1));
                } else {
                    $approvedDeduction = 0;
                }
            } elseif ($employee->emloyment_status == 'probation') {
                $approvedDeduction = $approvedCount[$employee->id];
            }
            $absentDeduction[$employee->id] = ($employee->basic_salary / $workingDays) * $AbsentCount[$employee->id] * 2;
            $netPayables[$employee->id] = round(($employee->basic_salary - ($employeeUnApprovedLeaves[$employee->id] * 2) - $approvedDeduction - $absentDeduction[$employee->id]) + ($employee->bonus));

//            $unApprovedCount[$employee->id]=$employeeUnApprovedLeaves[$employee->id];
//            $approvedCount[$employee->id]=$employeeApprovedLeaves[$employee->id];
//            $leavesDeduction[$employee->id]=(($employee->basic_salary/$workingDays)* $approvedCount[$employee->id])*2;
//            $absentDeduction[$employee->id]=($employee->basic_salary/$workingDays)* $AbsentCount[$employee->id]*2;
//            $netPayables[$employee->id]=($employee->basic_salary- $leavesDeduction[$employee->id]-$absentDeduction[$employee->id])+($employee->bonus);
        }
        $employees = Employee::where('status', '!=', '0')->get();

        return view('admin.salary.index')->with('month', $id)->with('employees', $employees)->with('ApprovedCount', $approvedCount)->with('unApprovedCount', $unApprovedCount)->with('netPayables', $netPayables)->with('AbsentCounts', $AbsentCount)->with('presents', $present);
    }

    public function addBonus(Request $request, $id)
    {
        $bonus = Employee::find($id);
        $bonus->bonus = $request->bonus;
        $bonus->save();
        Session::flash('success', 'Bonus Added Successfully');

        return redirect()->route('salary.show');
    }

    public function export(Request $request)
    {
        $this->validate($request, [
            'start_date' => 'required|before_or_equal:end_date',
            'end_date'   => 'required',
        ]);

        $title = ['Name', 'Basic Salary', 'Bonus', 'Leave Deduction', 'Gross Salary'];
        $fileName = 'Salary.csv';
        $writer = WriterFactory::create(Type::CSV);
        $writer->openToBrowser($fileName);
        $writer->addRow($title);

        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $startDate = str_replace('/', '-', $start_date);
        $startDate = date('Y-m-d', strtotime($startDate));

        $endDate = str_replace('/', '-', $end_date);
        $endDate = date('Y-m-d', strtotime($endDate));

        $employees = Employee::all();
        foreach ($employees as $employee) {
            $id = $employee->id;

            $attendanceDate2 = DB::select(DB::raw("SELECT * FROM attandances WHERE DATE_FORMAT(checkintime, '%Y-%m-%d') >= '$startDate' AND  DATE_FORMAT(checkintime, '%Y-%m-%d') <= '$endDate' And employee_id= '$id'"));
            foreach ($attendanceDate2 as $data) {
                $employee_id = $data->employee_id;
                $salaries = Salary::where('employee_id', $employee_id)->get();
                foreach ($salaries as $salary) {
                    $basic_salary = $salary->basic_salary;
                    $employees = Employee::where('id', $employee_id)->get();
                    foreach ($employees as $emp) {
                        $employee_name = $emp->fullname;
                        $employeeWorkingDaysId = DB::select(DB::raw("SELECT count(*) as data FROM attandances WHERE DATE_FORMAT(checkintime, '%Y-%m-%d') >= '$startDate' AND  DATE_FORMAT(checkintime, '%Y-%m-%d') <= '$endDate' And employee_id= '$id'"));
                        $employeeWorkingDaysId = $employeeWorkingDaysId[0]->data;

                        $leavesCount = DB::select(DB::raw("SELECT count(*) as data FROM leaves WHERE DATE_FORMAT(datefrom, '%Y-%m-%d') >= '$startDate' AND  DATE_FORMAT(datefrom, '%Y-%m-%d') <= '$endDate' And leave_type!='Paid Leave' And employee_id= '$id'"));
                        if ($leavesCount) {
                            $leavesCount = $leavesCount[0]->data;
                        }

                        $perDaySalary = ($basic_salary / $employeeWorkingDaysId); // perdaySalary
                        $leaveDeduction = $perDaySalary * $leavesCount; //Leave Deduction

                        $grossSalary = abs($leaveDeduction - $basic_salary); //Gross Salary
                    }
                }
            }
        }
        $writer->addRow([$employee_name, $basic_salary, 0, $leaveDeduction, $grossSalary]);

        $writer->close();
    }
}
