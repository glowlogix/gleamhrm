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

class EmployeeController extends Controller
{
    use ZohoTrait;
    use SlackTrait;

    public function index()
     {
        $data = Employee::where('role','member')->get();
        return view('admin.employees.index')->with('employees',$data);
    }

   
    public function create()
    { 
         return view('admin.employees.create');
    }

   
    public function store(Request $request)
    {
        //token get from values.php in config folder 
        $token = config('values.SlackToken');      
        $when = now()->addMinutes(1);
        
    //    $params = [
    //         'emailAddress'          =>$request->org_email,
    //         "primaryEmailAddress"   => $request->org_email,
    //         "displayName"           => $request->fullname,
    //         "password"              => "password",
    //         "userExist"             => false,
    //         "country"               => "pk"
    //    ];
        if($request->zoho)
        {
    //    $response = $this->createZohoAccount( $params );
    //    if($response->original){
    //     $user = Employee::create([
    //                 'fname'         => $request->fname,
    //                 'lname'         => $request->lname,
    //                 'fullname'      => $request->fullname,
    //                 'contact'       => $request->contact,                                        
    //                 'password'      => $params['password'],   
    //                 'zuid'          => $response->original->data->zuid,
    //                 'account_id'    => $response->original->data->accountId,
    //                  'org_email'     => $request->org_email,
    //                  'email'        => $request->email,
    //                 'status'        => 1,
    //                 'role'          => 'member',
    //                 'inviteToZoho'  => $request->zoho,
    //                 'inviteToSlack' => $request->slack,
    //                 'inviteToAsana' => $request->asana
    //     ]);
    //     if($user){
             // Mail::to($request->email)->later($when,new ZohoInvitationMail($request->input()));
        
    //     }
    //    }     

        
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

        return view('admin.employees.edit')->with('employee',$employee);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'fname' => 'required',
            'lname' => 'required',
            'org_email' => 'required|email'
        ]);

        $employee = Employee::find($id);
        $employee->fname = $request->fname;
        $employee->lname = $request->lname;
        $employee->role = $request->employee_id;
        $employee->org_email = $request->org_email;
        $employee->contact = $request->contact;
        
        
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
        return view('admin.employees.trashed')->with('employees', $employee);

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
        $emp->delete();
        return redirect()->back()->with('success','Employee is trash succesfully');     
        
       //s $employee = Employee::where('id',$id);


        // $arr = [
        //     "zuid" => 665612602,
        //     "password" => 'fb1040b5'
        // ];
        // $this->deleteZohoAccount($arr);

    }
}
