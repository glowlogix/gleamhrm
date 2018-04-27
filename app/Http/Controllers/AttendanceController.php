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
        
         $getcheckinTime = $request->checkindatetimepicker;
         $parsecheckinTime= Carbon::parse($getcheckinTime);

         $getcheckoutTime = $request->checkoutdatetimepicker;
         $parsecheckoutTime = Carbon::parse($getcheckoutTime);

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

    public function showExport(Request $request){
        $this->meta['title'] = 'Export Attendance';                        
        
        return view('admin.attendance.export',$this->metaResponse());
    }
    
    public function exportAttendance(Request $request){
        // $this->validate($request,[
        //     'start_date' => 'required|before:end_date',
        //     'end_date' => 'required'
        // ]);
    
        // $title = ['Name','Basic Salary','Bonus','Leave Deduction','Gross Salary'];
        // $fileName = 'Attendance.csv';
        // $writer = WriterFactory::create(Type::CSV); 
        // $writer->openToBrowser($fileName); 
        // $writer->addRow($title);
    
        // $start_date = $request->start_date;
        // $end_date = $request->end_date;
        
        // $startDate = str_replace('/', '-', $start_date);
        // $startDate = date('Y-m-d',strtotime($startDate));
    
        // $endDate = str_replace('/', '-',$end_date);
        // $endDate= date('Y-m-d',strtotime($endDate));
    
        // $employees = Employee::all();
        // foreach($employees as $employee){
        // $id = $employee->id;
    
        // $attendanceDate2 = DB::select(DB::raw("SELECT * FROM attandances WHERE DATE_FORMAT(checkintime, '%Y-%m-%d') >= '$startDate' AND  DATE_FORMAT(checkintime, '%Y-%m-%d') <= '$endDate' And employee_id= '$id'"));
        // if( $attendanceDate2 ){
        // foreach( $attendanceDate2 as $data){
        //     $employee_id = $data->employee_id;
        //     $salaries = Salary::where('employee_id',$employee_id)->get();
        //     foreach($salaries as $salary){
        //     $basic_salary = $salary->basic_salary;
        //     $employees = Employee::where('id',$employee_id)->get();
        //     foreach($employees as $emp){
        //         $employee_name = $emp->fullname;
        //         $monthly_salary = MonthlySalary::where('employee_id',$employee_id)->get();
        //         foreach($monthly_salary as $mSalary){
        //         $bonus = $mSalary->bonus;
        //         $employeeWorkingDaysId  =  DB::select(DB::raw("SELECT count(*) as data FROM attandances WHERE DATE_FORMAT(checkintime, '%Y-%m-%d') >= '$startDate' AND  DATE_FORMAT(checkintime, '%Y-%m-%d') <= '$endDate' And employee_id= '$id'"));
        //         $employeeWorkingDaysId = $employeeWorkingDaysId[0]->data;
                
        //         $leavesCount  =  DB::select(DB::raw("SELECT count(*) as data FROM leaves WHERE DATE_FORMAT(datefrom, '%Y-%m-%d') >= '$startDate' AND  DATE_FORMAT(datefrom, '%Y-%m-%d') <= '$endDate' And leave_type!='Paid Leave' And employee_id= '$id'"));
        //         $leavesCount = $leavesCount[0]->data;
        //     }
        //     $perDaySalary = ($basic_salary/$employeeWorkingDaysId); // perdaySalary
        //     $leaveDeduction =$perDaySalary * $leavesCount; //Leave Deduction
            
        //     $grossSalary = abs($leaveDeduction - $basic_salary); //Gross Salary
        //     }
        
        // }
    
        // }
        // $writer->addRow([$employee_name,$basic_salary, $bonus, $leaveDeduction, $grossSalary]); 
        
        // }
        // else{
        //     return redirect()->back()->withErrors('No Attendance Yet');     
            
        // }
    
        // }
        // $writer->close();

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

                    $events[] = Calendar::event(
        
                        "present"."\n".$employee->fullname,
        
                        true,
                        new \DateTime($value->checkintime),
        
                        new \DateTime($value->checkouttime.' +1 day'),
                        null,
                        [
                            'color' => 'green'
                        ]
                    );
        
                  }
                  foreach ($leave as $key => $value) {
                    
                    $events[] = Calendar::event(
    
                        $value->leave_type."\n".$employee->fullname,
        
                        true,
                        new \DateTime($value->datefrom),
        
                        new \DateTime($value->dateto.' +1 day'),
                        null,
                        [
                            'color' => 'orange',
                            'url' => 'pass here url and any route'
                        ]
                    );
        
                    }
               }
               $calendar = Calendar::addEvents($events);
               
            }
            
              
        return view('admin.attendance.allattendance',$this->metaResponse(),['calendar' => $calendar]);
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
