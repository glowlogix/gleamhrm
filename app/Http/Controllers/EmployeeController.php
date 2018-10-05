<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Employee;
use App\Salary;
use App\Document;
use App\OfficeLocation;
use Session;
use App\Traits\AsanaTrait;
use App\Traits\SlackTrait;
use App\Traits\ZohoTrait;
use Mail;
use File;
use App\Mail\EmailPasswordChange;
use App\Mail\SlackInvitationMail;
use App\Mail\ZohoInvitationMail;
use App\Mail\CompanyPoliciesMail;
use App\Mail\SimSimMail;
use DB;
use Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
	use AsanaTrait;    
	use ZohoTrait;
	use SlackTrait;

	public $roles = [
		"project_coordinator" 			=> "Project Coordinator",
		"web_developer" 				=> "Web Developer",
		"junior_web_developer" 			=> "Junior Web Developer",
		"front_end_developer" 			=> "Front-end Developer",
		"account_sales_executive" 		=> "Account Sales Executive",
		"sales_officer" 				=> "Sales Officer",
		"digital_marketing_executive" 	=> "Digital Marketing Executive",
		"content_writer" 				=> "Content Writer",
		"digital_marketer" 				=> "Digital Marketer",
		"web_designer_lead" 			=> "Web Designer Lead",
		"junior_web_designer" 			=> "Junior Web Designer",
		"hr_manager" 					=> "HR Manager",
		"hr_officer" 					=> "HR Officer",
		"admin" 						=> "Admin",
	];

	public function index()
	{
		$data = Employee::with('officeLocation')->get();
		return view('admin.employees.index',['title' => 'All Employees'])
		->with('employees', $data)	
		->with('roles',$this->roles);
	}


	public function create()
	{
		/*Mail::send('emails.welcome', [], function ($m) {
            $m->from('kosar@glowlogix.com', 'test Application');

            $m->to('kosar@glowlogix.com', 'larallllll')->subject('Your test Reminder!');
        });*/
 
		return view('admin.employees.create',['title' => 'Add Employee'])
		->with('office_locations',OfficeLocation::all())
		->with('roles', $this->roles);
	}


	public function store(Request $request)
	{
		//also do js validation
		$this->validate($request,[
			'firstname' => 'required',
			'lastname' => 'required',
			'official_email' => 'required|email|unique:employees',
			'personal_email' => 'required|email|unique:employees',
			'contact_no' => 'required|unique:employees|size:11',
			// 'cnic' => 'size:13',
		]);

		if(!strstr(strtolower($request->official_email), 'glowlogix.com')) {
			return redirect()->back()->with('error','Enter correct official email like "abc@glowlogix.com"');
		}
		
		//token get from values.php in config folder 
		$token = config('values.SlackToken');      
		$when = now()->addMinutes(1);
		$l=8;
		$password = substr(md5(uniqid(mt_rand(), true)), 0, $l);
		
		$employee = Employee::create([
			'firstname'     	=> $request->firstname,
			'lastname'      	=> $request->lastname,
			'contact_no'       	=> $request->contact_no,
			'emergency_contact' => $request->emergency_contact,
			'emergency_contact_relationship' => $request->emergency_contact_relationship,
			'password'      	=> $password,   
			'official_email'    => $request->official_email,
			'personal_email'    => $request->personal_email,
			'status'        	=> 1,
			'basic_salary'     	=> $request->salary,
			'role'          	=> $request->role,
            'type' 				=> $request->type,
            'cnic' 				=> $request->cnic,
            'date_of_birth' 	=> $request->date_of_birth,
            'current_address' 	=> $request->current_address,
            'permanent_address' => $request->permanent_address,
            'city' 				=> $request->city,
            'office_location_id' => $request->office_location_id,  
			'invite_to_zoho'  	=> $request->invite_to_zoho,
			'invite_to_slack' 	=> $request->invite_to_slack,
			'invite_to_asana' 	=> $request->invite_to_asana,
		]);

		$params = [
			'emailAddress'          => $request->official_email,
			"primaryEmailAddress"   => $request->official_email,
			"displayName"           => $request->firstname. ' ' .$request->lastname,
			"password"              => $password,
			"userExist"             => false,
			"country"               => "pk"
		];

		if($request->zoho){
			$response = $this->createZohoAccount( $params );

			if($response->original){
				$this->addUserToTeam($request->teams,$request->official_email);

				$employee->zuid = $response->original->data->zuid;
				$employee->account_id = $response->original->data->accountId;
				$employee->save();

				if($employee){
					Mail::to($request->email)->later($when,new ZohoInvitationMail($request->input(),$params['password']));            
				}
			}
		}

		//check if slack is checked for invitation
		if($request->slack){
			//call the  slack trait method in app/Traits folder
			$this->createSlackInvitation($request->official_email,$token);
			//slack mail
			Mail::to($request->official_email)->later($when, new SlackInvitationMail($request->input()));
		}
		$employee_id = $employee->id;
		
		//send message for password information and change password.
		Mail::to($request->official_email)->later($when, new EmailPasswordChange($employee_id));
		Mail::to($request->personal_email)->later($when, new EmailPasswordChange($employee_id));
		
		//policies
		Mail::to($request->official_email)->later($when, new CompanyPoliciesMail());

		//simsim
		Mail::to($request->official_email)->later($when, new SimSimMail());

		return redirect()->route('employees')->with('success','Employee is created succesfully');      
	} 

	public function edit($id)
	{
		$employee = Employee::find($id);
		if(!$employee){
			abort(404);
		}

		return view('admin.employees.edit',['title' => 'Update Employee'])
		->with('employee',$employee)
		->with('office_locations', OfficeLocation::all())
		->with('roles', $this->roles);
	}

	public function update(Request $request, $id)
	{
		$adminPassword = Auth::user()->password;
		
		if(!Hash::check($request->password, $adminPassword)){
			return redirect()->back()->with('error','Wrong admin password entered');
		}

		$this->validate($request,[
			'firstname' => 'required',
			'lastname' => 'required',
			'official_email' => 'required|email|unique:employees,official_email,'.$id,
			'personal_email' => 'required|email|unique:employees,personal_email,'.$id,
			'contact_no' 	 => 'required|size:11|unique:employees,contact_no,'.$id,
			// 'cnic' => 'size:13',
		]);

		if(!strstr(strtolower($request->official_email), 'glowlogix.com')) {
			return redirect()->back()->with('error','Enter correct official email like "abc@glowlogix.com"');
		}

		$employee 					= Employee::find($id);

		$employee->firstname 		= $request->firstname;
		$employee->lastname 		= $request->lastname;
		$employee->contact_no 		= $request->contact_no;
		$employee->emergency_contact= $request->emergency_contact;
		$employee->emergency_contact_relationship= $request->emergency_contact_relationship;
		$employee->official_email 	= $request->official_email;
		$employee->personal_email 	= $request->personal_email;
		$employee->basic_salary 	= $request->salary;
		$employee->role 			= $request->role;
		$employee->type 			= $request->type;
		$employee->office_location_id= $request->office_location_id;
		$employee->cnic 			= $request->cnic;
		$employee->date_of_birth 	= $request->date_of_birth;
		$employee->current_address 	= $request->current_address;
		$employee->permanent_address= $request->permanent_address;
		$employee->city 			= $request->city;
		$employee->invite_to_zoho 	= $request->invite_to_zoho;
		$employee->invite_to_slack 	= $request->invite_to_slack;
		$employee->invite_to_asana 	= $request->invite_to_asana;
		// dd($employee);
		//admin password get from model confirmation box.
		$params = [
			"mode" => '',
			"zuid" => $employee->zuid,
			"password" => $adminPassword
		];

		if ($request->employee_status === '1'){
			$params['mode'] = 'enableUser';
			$employee->status = 1;
			$this->updateZohoAccount($params,$employee->account_id);

		}
		else if($request->employee_status === '0'){
			$params['mode']  = 'disableUser';
			$employee->status  = 0;
			$this->updateZohoAccount($params,$employee->account_id);    
		}

		$when = now()->addMinutes(1);

		if($request->zoho){
			$response = $this->updateZohoAccount( $params );

			if($response->original){
				// $this->addUserToTeam($request->teams,$request->official_email);

				// $employee->zuid = $response->original->data->zuid;
				// $employee->account_id = $response->original->data->accountId;
				// $employee->save();

				if($employee){
					Mail::to($request->email)->later($when,new ZohoInvitationMail($request->input(),$params['password']));            
				}
			}
		}

		//check if slack is checked for invitation
		/*if($request->slack){
			//call the  slack trait method in app/Traits folder
			$this->updateSlackInvitation($request->official_email,$token);
			//slack mail
			Mail::to($request->official_email)->later($when, new SlackInvitationMail($request->input()));
		}*/

		Mail::to($request->official_email)->later($when, new EmailPasswordChange($employee->id));
		Mail::to($request->personal_email)->later($when, new EmailPasswordChange($employee->id));
		$employee->save();        

		return redirect()->route('employees')->with('success','Employee is updated succesfully');      
	}

	public function trashed()
	{
		$employee=Employee::onlyTrashed()->get();
		return view('admin.employees.trashed',
			['title' => 'Trash Employees']
		)->with('employees', $employee);
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
		
		return redirect()->route('employees')->with('success','Employee is deleted succesfully');     

	}

	public function destroy(Request $request, $id)
	{
		$this->validate($request,[
			'password' => 'required'
		]);

		$adminPassword = Auth::user()->password;
		
		if(!Hash::check($request->password, $adminPassword)){
			return redirect()->back()->with('error','Wrong admin password entered');
		}
		
		$emp = Employee::find($id);
		$account_id = $emp->account_id;
		$zuid = $emp->zuid;
		$email = $emp->official_email;
		// $response = $emp->delete();

		// if($response)
		if($request->invite_to_zoho == 1){
			$arr = [
				"zuid" => $zuid,
				"password" => bcrypt($request->zoho_password), /*get pass from admin model box*/
			];

			$this->deleteZohoAccount($arr, $account_id);
		}

		if($request->invite_to_asana == 1){
			$arr = [
				"zuid" => $zuid,
				"password" => $adminPassword, /*get pass from admin model box*/
			];

			$this->removeUser($email);
		}

		if($request->invite_to_slack == 1){
			//run bot
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
		$row = DB::table('employees')->where(['official_email' => $email , 'password' => $password , 'role' => 'member'])
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

		return redirect()->route('employees')->with('success','Employee is updated succesfully');      
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