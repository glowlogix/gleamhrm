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
class EmployeeController extends Controller
{
    use AsanaTrait;    
    use ZohoTrait;
    use SlackTrait;

    public function index()
     {
        $data = Employee::where('role','member')->get();
        return view('admin.employees.index',['title' => 'All Employees'])->with('employees',$data);
    }

   
    public function create()
    {  
        
         return view('admin.employees.create',['title' => 'Add Employee']);
    }

   
    public function store(Request $request)
    {
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
       $response = $this->createZohoAccount( $params );
       if($response->original){
        $this->addUserToTeam($request->teams,$request->org_email);
        
        $user = Employee::create([
                    'firstname'     => $request->firstname,
                    'lastname'      => $request->lastname,
                    'fullname'      => $request->fullname,
                    'contact'       => $request->contact,
                    'emergency_contact' => $request->emergency_contact,                                        
                    'password'      => $params['password'],   
                    'zuid'          => $response->original->data->zuid,
                    'account_id'    => $response->original->data->accountId,
                     'org_email'     => $request->org_email,
                     'email'        => $request->email,
                    'status'        => 1,
                    'role'          => 'member',
                    'inviteToZoho'  => $request->zoho,
                    'inviteToSlack' => $request->slack,
                    'inviteToAsana' => $request->asana
        ]);
        if($user){
            Mail::to($request->email)->later($when,new ZohoInvitationMail($request->input(),$params['password']));            
        }
       }     

        
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
    
  return redirect()->back()->with('success','Employee is updated succesfully');      
    
} 
    
    public function edit($id)
    {
        $employee = Employee::find($id);
        if(!$employee){
            abort(404);
        }

        return view('admin.employees.edit',['title' => 'Update Employee'])->with('employee',$employee);
    }

    public function update(Request $request, $id)
    {
        // $this->validate($request,[
        //     'firstname' => 'required',
        //     'lastname' => 'required',
        //     'org_email' => 'required|email'
        // ]);

        $employee = Employee::find($id);
        $employee->firstname = $request->firstname;
        $employee->lastname = $request->lastname;
        $employee->role = $request->employee_id;
        $employee->org_email = $request->org_email;
        $employee->contact = $request->contact;
        $employee->emergency_contact = $request->emergency_contact;
        
        
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
        $employee=Employee::onlyTrashed()->get();
        return view('admin.employees.trashed',['title' => 'Trash Employees'])->with('employees', $employee);

    }

    public function kill($id)
    {
        $employee=Employee::withTrashed()->where('id', $id)->first();
        $employee->forceDelete();

        return redirect()->back()->with('success','Employee is deleted succesfully');     
    }

    public function restore($id)
    {
        $employee=Employee::withTrashed()->where('id', $id)->first();
        $employee->restore();
        return redirect()->back()->with('success','Employee is Restore succesfully');     
    }

    public function destroy($id)
    {
        $emp = Employee::find($id);
        $account_id = $emp->account_id;
        $zuid = $emp->zuid;
        $response = $emp->delete();
        $adminPassword = config('values.adminPassword');
        if($response){

        $arr = [
            "zuid" => $zuid ,
            "password" => $adminPassword
        ];

          $this->deleteZohoAccount($arr,$account_id);
        }
        return redirect()->back()->with('success','Employee is trash succesfully');     
        
    }
    public function EmployeeLogin(){
        return view('admin.employees.login');
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
        $data = DB::table('employees')->where('id', $request->session()->get('emp_auth'))->get();
        return view('admin.employees.profile',['data' => $data,'title' => 'Update Profile']);
        
    }

    public function UpdateEmployeeProfile(Request $request,$id){
    
        $this->validate($request,[
            'firstname' => 'required',
            'lastname' => 'required'
        ]);
        
        $employee = Employee::find($id);
        $employee->firstname = $request->firstname;
        $employee->lastname = $request->lastname;
        $employee->contact = $request->contact;
        $employee->password = $request->password;
        $employee->emergency_contact = $request->emergency_contact;
        
        $employee->save();
        
        return redirect()->back()->with('success','Employee is updated succesfully');      

        
    }

    public function EmployeeLogout(Request $request){
        $request->session()->forget('emp_auth');
        return redirect()->route('employee.login');
        
        
    }

    public function showDocs(Request $request){
        $data = DB::table('employees')->where('id', $request->session()->get('emp_auth'))->get();
        $data2 = DB::table('uploads')->where('status','=',1)->get();
        return view('admin.employees.showDocs',['data' => $data,'files' => $data2,'title' => 'All Documents']);
    }

        
    
  
        
}