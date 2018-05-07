<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Employee;
use Session;
use App\Traits\AsanaTrait;
use App\Traits\SlackTrait;
use App\Traits\ZohoTrait;
use Mail;
use File;
use App\Mail\SlackInvitationMail;
use App\Mail\ZohoInvitationMail;
use App\Mail\CompanyPoliciesMail;
use App\Mail\SimSimMail;
use DB;
use Response;
use Illuminate\Support\Facades\Storage;
use App\Traits\MetaTrait;
use Calendar;
use App\Salary;

class EmployeeController extends Controller
{
    use AsanaTrait;    
    use ZohoTrait;
    use SlackTrait;
    use MetaTrait;
    
    public function index() 
     {
        $this->meta['title'] = 'All Employees';                
        $data = Employee::where('role','member')->paginate(10);
        return view('admin.employees.index',$this->metaResponse())->with('employees',$data);
    }

   
    public function create()
    {  
        $this->meta['title'] = 'Add Employee';                        
        return view('admin.employees.create',$this->metaResponse());
    }

   
    public function store(Request $request)
    {
        $this->validate($request,[
            'firstname' => 'required',
            'lastname' => 'required',
            'org_email' => 'required|email',
            'email' => 'required|email',
            'emergency_contact' => 'required',
            'emergency_contact_relationship' => 'required'
        ]);

        //token get from values.php in config folder 
        $token = config('values.SlackToken');      
        $when = now()->addMinutes(1);
        $l=8;
        $password = substr(md5(uniqid(mt_rand(), true)), 0, $l);
        
       $params = [
            'emailAddress'          =>$request->org_email,
            "primaryEmailAddress"   => $request->org_email,
            "displayName"           => $request->fullname,
            "password"              => $password,
            "userExist"             => false,
            "country"               => "pk"
       ];
        if($request->zoho)
       {         
           
         /*--- This code is Comment Because Zoho Add Employee not Work  ----*/

        // $response = $this->createZohoAccount( $params );
        // dd($response);
        // if(!$response->original){
        //     echo "Data not added in Zoho";
        // }
        echo "No Data Added in Zoho because of api problem";

       }
       if($request->teams){
        $response = $this->addUserToOrganization($request->org_email); 
        if($response){
        $this->addUserToTeam($request->teams,$request->org_email);    
        }

       }
        $user = Employee::create([
                    'firstname'     => $request->firstname,
                    'lastname'      => $request->lastname,
                    'fullname'      => $request->fullname,
                    'contact'       => $request->contact,
                    'emergency_contact' => $request->emergency_contact,     
                    'emergency_contact_relationship' => $request->emergency_contact_relationship,                                                            
                    'password'      => $params['password'],   
                    'zuid'          => '123',//$response->original->data->zuid,
                    'account_id'    => '434',//$response->original->data->accountId,
                    'org_email'     => $request->org_email,
                    'email'        => $request->email,
                    'status'        => 1,
                    'role'          => 'member',
                    'inviteToZoho'  => $request->zoho,
                    'inviteToSlack' => $request->slack,
                    'inviteToAsana' => $request->asana
        ]);
     
        if($user){
            Salary::create([
                'employee_id' => $user->id,
                'basic_salary' => $request->salary
            ]);
            Mail::to($request->email)->later($when,new ZohoInvitationMail($request->input(),$params['password']));            
        }
           

        
       //check if slack is checked for invitation
       if($request->slack){
        //call the  slack trait method in app/Traits folder
        $this->createSlackInvitation($request->org_email,$token);

        //slack mail
        Mail::to($request->org_email)->later($when, new SlackInvitationMail($request->input()));
        
      }
        //policies    
        Mail::to($request->org_email)->later($when, new CompanyPoliciesMail());
        //simsim
        Mail::to($request->org_email)->later($when, new SimSimMail());
    
       return redirect()->back()->with('success','Employee is created succesfully');      
    
} 
    
    public function edit($id)
    {
        $this->meta['title'] = 'Update Employee';                        
        $employee = Employee::find($id);
        $salary = Salary::where('employee_id',$id)->first();
        if(!$employee){
            abort(404);
        }

        return view('admin.employees.edit',$this->metaResponse())->with(['employee'=>$employee,'salary'=>$salary]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'firstname' => 'required',
            'lastname' => 'required',
            'org_email' => 'required|email',
            'emergency_contact' => 'required',
            'emergency_contact_relationship' => 'required'
        ]);

        $employee = Employee::find($id);
        $employee->firstname = $request->firstname;
        $employee->lastname = $request->lastname;
        $employee->role = $request->employee_id;
        $employee->org_email = $request->org_email;
        $employee->contact = $request->contact;
        $employee->emergency_contact = $request->emergency_contact;
        $employee->emergency_contact_relationship = $request->emergency_contact_relationship;
        $result = $employee->save();
        if( $result ){
        $salary = Salary::where('employee_id',$id)->first();
        $salary->basic_salary = $request->salary;
        $salary->save();
        }

        //admin password get
        $adminPassword = config('values.adminPassword');
        $params = [
            "mode" => '',
            "zuid" => $employee->zuid,
            "password" => $adminPassword

        ];
        if ($request->employee_status === '1'){
            $params['mode'] = 'enableUser';
            $employee->status = 1;
            $this->updateZohoAccount($params,$employee->account_id);
            $employee->save();
            
        }else if($request->employee_status === '0'){
            $params['mode']  = 'disableUser';
            $employee->status  = 0;
            $this->updateZohoAccount($params,$employee->account_id);    
            $employee->save();        
        }

        return redirect()->back()->with('success','Employee is updated succesfully');     
        

    }

    public function trashed()
    {

        $this->meta['title'] = 'Trash Employees';                                
        $employee=Employee::onlyTrashed()->get();
        return view('admin.employees.trashed',$this->metaResponse())->with('employees', $employee);

    }

    public function kill($id)
    {
        $employee=Employee::withTrashed()->where('id', $id)->first();
        $salary=Salary::withTrashed()->where('employee_id', $id)->first();
        
        $employee->forceDelete();
        $salary->forceDelete();
        
        return redirect()->back()->with('success','Employee is deleted succesfully');     
    }

    public function restore($id)
    {
        $employee=Employee::withTrashed()->where('id', $id)->first();
        $salary=Salary::withTrashed()->where('employee_id', $id)->first();
        
        $employee->restore();
        $salary->restore();
        
        return redirect()->back()->with('success','Employee is Restore succesfully');     
    }

    public function destroy($id)
    {
        $emp = Employee::find($id);
        $zuid = $emp->zuid;
        $adminPassword = config('values.adminPassword');
        
        if($emp->inviteToAsana){
            $this->removeUser($emp->org_email);       
        }
        // $arr = [
        //     "zuid" => $zuid ,
        //     "password" => $adminPassword
        // ];
        
        if($emp->inviteToZoho){
            $this->deleteZohoAccount($arr);   
        }

        // $salary = Salary::where('employee_id',$id)->first();
        // $salary->delete();
        // $response = $emp->delete();
            
    
        return redirect()->back()->with('success','Employee is trash succesfully');     
        
    }
    public function EmployeeLogin(){
        $this->meta['title'] = 'Employee Login';    
        
        return view('admin.employees.login',$this->metaResponse());
    }

    public function postEmployeeLogin(Request $request){
        $this->validate($request,[
            'email' => 'required',
            'password' => 'required'
        ]);
        $email = $request->email;
        $password = $request->password;
         $row = DB::table('employees')->where(['org_email' => $email , 'password' => $password , 'role' => 'member'])
         ->get();

         if(count($row)>0){
            foreach($row as $data){                
                $request->session()->put('emp_auth', $data->id);
                return redirect()->route('employee.profile');
            }
        }       
       
         $messages = 'Username/Password Incorrect';
         return redirect()->back()->with('msg',$messages);    
         

    }
    public function EmployeeProfile(Request $request){

        $this->meta['title'] = 'Update Profile';                                        
        $data = DB::table('employees')->where('id', $request->session()->get('emp_auth'))->get();
        return view('admin.employees.profile',['data' => $data],$this->metaResponse());
        
    }

    public function UpdateEmployeeProfile(Request $request,$id){
    
        $this->validate($request,[
            'firstname' => 'required',
            'lastname' => 'required',
            'contact' => 'required',
            'emergency_contact' => 'required',
            'emergency_contact_relationship' => 'required'
        ]);
        
        $employee = Employee::find($id);
        $employee->firstname = $request->firstname;
        $employee->lastname = $request->lastname;
        $employee->contact = $request->contact;
        $employee->password = $request->password;
        $employee->emergency_contact = $request->emergency_contact;
        $employee->emergency_contact_relationship = $request->emergency_contact_relationship;

        $employee->save();
        
        return redirect()->back()->with('success','Employee is updated succesfully');      

        
    }

    public function EmployeeLogout(Request $request){
        $request->session()->forget('emp_auth');
        return redirect()->route('employee.login');
        
        
    }

    public function showDocs(Request $request){

        $this->meta['title'] = 'Show Documents';                                                
        $data = DB::table('employees')->where('id', $request->session()->get('emp_auth'))->get();
        $data2 = DB::table('documents')->where('status','=',1)->get();
        return view('admin.employees.showDocs',['data' => $data,'files' => $data2],$this->metaResponse());
    }

    public function showAttendance(Request $request){
        $this->meta['title'] = 'Show Attendance';        
        $data = DB::table('employees')->where('id', $request->session()->get('emp_auth'))->get();  
        $attendance = DB::table('attandances')->where('employee_id', $request->session()->get('emp_auth'))->get(); 
        $leave = DB::table('leaves')->where('employee_id', $request->session()->get('emp_auth'))->get(); 
        
        $events = [];
        
               if($data->count()){
        
                  foreach ($attendance as $key => $value) {

                    $events[] = Calendar::event(
        
                         "present",
        
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
        
                        $value->leave_type,
        
                        true,
                        new \DateTime($value->datefrom),
        
                        new \DateTime($value->dateto.' +1 day'),
                        null,
                        [
                            'color' => 'orange'
                        ]
                    );
        
                    }
               }
        
              $calendar = Calendar::addEvents($events);
              
        return view('admin.employees.showAttendance',$this->metaResponse(),['data' => $data,'calendar' => $calendar]);
        
        
    }
    
  
        
}