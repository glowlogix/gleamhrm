<?php

namespace App\Http\Controllers;

use App\Salaries;
use Illuminate\Http\Request;
use App\Traits\MetaTrait;
use App\Employee;
use DB;
use App\Salary;
use App\MonthlySalary;
use App\Leave;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Writer\WriterFactory;
use Box\Spout\Common\Type;

class SalariesController extends Controller
{
    use MetaTrait;
    
    public function index(){

        $this->meta['title'] = 'All Salaries';  
        $employees = Employee::all();
        foreach($employees as $employee){
            $id = $employee->id;
            $salary = Salary::where('employee_id',$id)->first();
        }
        return view('admin.salary.index',$this->metaResponse(),['employees' => $employees,'salary'=>$salary]);

    }

    public function addBonus(Request $request,$id){

    }


    public function export(Request $request){
        $this->validate($request,[
            'start_date' => 'required|before_or_equal:end_date',
            'end_date' => 'required'
        ]);

        $title = ['Name','Basic Salary','Bonus','Leave Deduction','Gross Salary'];
        $fileName = 'Salary.csv';
        $writer = WriterFactory::create(Type::CSV); 
        $writer->openToBrowser($fileName); 
        $writer->addRow($title);

        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $startDate = str_replace('/', '-', $start_date);
        $startDate = date('Y-m-d',strtotime($startDate));

        $endDate = str_replace('/', '-',$end_date);
        $endDate= date('Y-m-d',strtotime($endDate));

        $employees = Employee::all();
        foreach($employees as $employee){
            $id = $employee->id;

            $attendanceDate2 = DB::select(DB::raw("SELECT * FROM attandances WHERE DATE_FORMAT(checkintime, '%Y-%m-%d') >= '$startDate' AND  DATE_FORMAT(checkintime, '%Y-%m-%d') <= '$endDate' And employee_id= '$id'"));
            foreach( $attendanceDate2 as $data){
                $employee_id = $data->employee_id;
                $salaries = Salary::where('employee_id',$employee_id)->get();
                foreach($salaries as $salary){
                    $basic_salary = $salary->basic_salary;
                    $employees = Employee::where('id',$employee_id)->get();
                    foreach($employees as $emp){
                        $employee_name = $emp->fullname;
                        $employeeWorkingDaysId  =  DB::select(DB::raw("SELECT count(*) as data FROM attandances WHERE DATE_FORMAT(checkintime, '%Y-%m-%d') >= '$startDate' AND  DATE_FORMAT(checkintime, '%Y-%m-%d') <= '$endDate' And employee_id= '$id'"));
                        $employeeWorkingDaysId = $employeeWorkingDaysId[0]->data;

                        $leavesCount  =  DB::select(DB::raw("SELECT count(*) as data FROM leaves WHERE DATE_FORMAT(datefrom, '%Y-%m-%d') >= '$startDate' AND  DATE_FORMAT(datefrom, '%Y-%m-%d') <= '$endDate' And leave_type!='Paid Leave' And employee_id= '$id'"));
                        if($leavesCount){
                         $leavesCount = $leavesCount[0]->data;
                     }

                        $perDaySalary = ($basic_salary/$employeeWorkingDaysId); // perdaySalary
                        $leaveDeduction =$perDaySalary * $leavesCount; //Leave Deduction
                        
                        $grossSalary = abs($leaveDeduction - $basic_salary); //Gross Salary   
                    }
                }
            }
        }
        $writer->addRow([$employee_name,$basic_salary,0, $leaveDeduction, $grossSalary]); 

        $writer->close();
    }
}
