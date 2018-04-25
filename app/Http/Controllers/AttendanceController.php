<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Traits\MetaTrait;
use App\Attandance;
use App\Employee;
use Carbon\Carbon;
use Session;
use App\Salary;
use App\MonthlySalary;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Writer\WriterFactory;
use Box\Spout\Common\Type;
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
        
         $getcheckinTime = $request->checkindatetimepicker;
         $parsecheckinTime= Carbon::parse($getcheckinTime);
         //$checkinTime = $parsecheckinTime->format('Y-m-d H:i:s');

         $getcheckoutTime = $request->checkoutdatetimepicker;
         $parsecheckoutTime = Carbon::parse($getcheckoutTime);
        // $checkoutTime = $parsecheckoutTime->format('Y-m-d H:i:s');

         $delay = $request->delay;
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
    public function update(Request $request,$id)
    {
        $attendance = Attandance::where('id',$id)->first();
        $getcheckinTime = $request->checkindatetimepicker;
        $parsecheckinTime= Carbon::parse($getcheckinTime);

        $attendance->checkintime = $parsecheckinTime;

        $getcheckoutTime = $request->checkoutdatetimepicker;
        $parsecheckoutTime = Carbon::parse($getcheckoutTime);

        $attendance->checkouttime = $parsecheckoutTime;

        $attendance->delay = $request->attendance_delay;

        $hoursLogged = $parsecheckinTime->diffInHours($parsecheckoutTime); 
        $attendance->hoursLogged = $hoursLogged;
        $attendance->hoursLogged = $hoursLogged;
        $row = $attendance->save();
        if($row){
            return redirect()->route('attendance.show',['id' => $attendance->employee_id])->with('success','Attendance is updated succesfully');     
            
         }

    }
    
    public function exportattendance(Request $request){
        $title = ['Name','Basic Salary','Bonus','Leave Deduction','Gross Salary'];
        $fileName = 'Attendance.csv';
        $writer = WriterFactory::create(Type::CSV); 
        $writer->openToBrowser($fileName); 
        $writer->addRow($title);
        
        $salaries = Salary::all();
        foreach($salaries as $salary){
            $basic_salary = $salary->basic_salary;
            $employee_id = $salary->employee_id;
            $employees = Employee::where('id',$employee_id)->get();
            foreach($employees as $employee){
            $employee_name = $employee->fullname;
            $monthly_salary = MonthlySalary::where('employee_id',$employee->id)->get();
            foreach($monthly_salary as $mSalary){
            $bonus = $mSalary->bonus;
            $grossSalary = $mSalary->gross_salary;
            $leaveDeduction = $mSalary->leave_deduction;
            
            }
  
        }
        $writer->addRow([$employee_name,$basic_salary, $bonus, $leaveDeduction, $grossSalary]); 
        
          
        }
        
        
        
        $writer->close();

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $attendance = Attandance::where('id',$id)->first();
        $attendance->delete();
        return redirect()->back()->with('success','Attendance is deleted succesfully');     
        
        
    }

}
