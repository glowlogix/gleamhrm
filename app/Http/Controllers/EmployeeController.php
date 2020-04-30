<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Department;
use App\Designation;
use App\Employee;
use App\LeaveType;
use App\Mail\CompanyPoliciesMail;
use App\Mail\EmailPasswordChange;
use App\Mail\SimSimMail;
use App\Mail\SlackInvitationMail;
use App\Mail\UpdateAccount;
use App\Mail\ZohoInvitationMail;
use App\Traits\AsanaTrait;
use App\Traits\SlackTrait;
use App\Traits\ZohoTrait;
use Carbon\Carbon;
use DB;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Mail;
use Session;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    use AsanaTrait;
    use ZohoTrait;
    use SlackTrait;

    public $designations = [
        'ceo'                         => 'CEO',
        'project_coordinator'         => 'Project Coordinator',
        'web_developer'               => 'Web Developer',
        'junior_web_developer'        => 'Junior Web Developer',
        'front_end_developer'         => 'Front-end Developer',
        'account_sales_executive'     => 'Account Sales Executive',
        'sales_officer'               => 'Sales Officer',
        'digital_marketing_executive' => 'Digital Marketing Executive',
        'content_writer'              => 'Content Writer',
        'digital_marketer'            => 'Digital Marketer',
        'web_designer_lead'           => 'Web Designer Lead',
        'junior_web_designer'         => 'Junior Web Designer',
        'hr_manager'                  => 'HR Manager',
        'hr_officer'                  => 'HR Officer',
        'admin'                       => 'Admin',
    ];

    public $employment_statuses = [
        'permanent'   => 'Permanent',
        'contractual' => 'Contractual',
        'probation'   => 'Probation',
        'intern'      => 'Intern',
        'resigned'    => 'Resigned',
        'terminated'  => 'Terminated',
        'on_leave'    => 'On Leave',
    ];
    public $filters = [
        'all'         => 'all',
        'contractual' => 'contractual',
        'intern'      => 'intern',
        'on_leave'    => 'on_Leave',
        'permanent'   => 'permanent',
        'probation'   => 'probation',
        'resigned'    => 'resigned',
        'terminated'  => 'terminated',
    ];

    public function __construct()
    {
        // $this->middleware(['role_or_permission:super-admin|edit articles']);
    }

    public function index($id = '')
    {
        if ($id == 'all') {
            $data = Employee::with('branch', 'department')->get();
        } elseif ($id == '') {
            $data = Employee::with('branch', 'department')->where('status', '!=', '0')->get();
        } else {
            $data = Employee::with('branch', 'department')
                ->where('employment_status', $id)
                ->get();
        }
        $active_employees = Employee::where('status', '1')->count();

        return view('admin.employees.index', ['title' => 'All Employees'])
            ->with('employees', $data)
            ->with('active_employees', $active_employees)
            ->with('designations', Designation::all())
            ->with('filters', $this->filters)
            ->with('selectedFilter', $id);
    }

    public function create()
    {
        /*Mail::send('emails.welcome', [], function ($m) {
            $m->from('kosar@glowlogix.com', 'test Application');

            $m->to('kosar@glowlogix.com', 'larallllll')->subject('Your test Reminder!');
        });*/

        return view('admin.employees.create', ['title' => 'Add Employee'])
            ->with('branches', Branch::all())
            ->with('departments', Department::all())
            ->with('employment_statuses', $this->employment_statuses)
            ->with('designations', Designation::all());
    }

    public function store(Request $request)
    {
        //also do js validation
        $this->validate($request, [
            'firstname'      => 'required',
            'lastname'       => 'required',
            'official_email' => 'required|email|unique:employees',
            'personal_email' => 'required|email|unique:employees',
            'contact_no'     => 'required|unique:employees|size:11',
            'gender'         => 'required',
            'picture'        => 'max:1000',

            // 'cnic' => 'size:13',
        ]);

        if (! strstr(strtolower($request->official_email), 'glowlogix.com')) {
            return redirect()->back()->with('error', 'Enter correct official email like "abc@glowlogix.com"');
            // return redirect()->back()->withInput($request)->with('error','Enter correct official email like "abc@glowlogix.com"');
        }

        //token get from values.php in config folder
        $token = config('values.SlackToken');

        $when = Carbon::now()->addMinutes(10);
        $l = 8;
        $password = bcrypt('123456');

        $arr = [
            'firstname'                      => $request->firstname,
            'lastname'                       => $request->lastname,
            'contact_no'                     => $request->contact_no,
            'emergency_contact'              => $request->emergency_contact,
            'emergency_contact_relationship' => $request->emergency_contact_relationship,
            'password'                       => $password,
            'official_email'                 => $request->official_email,
            'personal_email'                 => $request->personal_email,
            'status'                         => 1,
            'employment_status'              => $request->employment_status,
            'basic_salary'                   => $request->salary,
            'department_id'                  => $request->department_id,
            'designation'                    => strtolower($request->designation),
            'type'                           => $request->type,
            'cnic'                           => $request->cnic,
            'date_of_birth'                  => $request->date_of_birth,
            'current_address'                => $request->current_address,
            'permanent_address'              => $request->permanent_address,
            'city'                           => $request->city,
            'invite_to_zoho'                 => $request->invite_to_zoho,
            'invite_to_slack'                => $request->invite_to_slack,
            'invite_to_asana'                => $request->invite_to_asana,
            'joining_date'                   => $request->joining_date,
            'gender'                         => $request->gender,
        ];

        if (! empty($request->branch_id)) {
            $arr['branch_id'] = $request->branch_id;
        }

        if ($request->picture != '') {
            $picture = time().'_'.$request->picture->getClientOriginalName();
            $request->picture->move('storage/employees/profile/', $picture);
            $arr['picture'] = 'storage/employees/profile/'.$picture;
        }

        $employee = Employee::create($arr);
        // $this->storeEmployeeTimings($employee->id);

        $params = [
            'emailAddress'        => $request->official_email,
            'primaryEmailAddress' => $request->official_email,
            'displayName'         => $request->firstname.' '.$request->lastname,
            'password'            => $password,
            'userExist'           => false,
            'country'             => 'pk',
        ];

        if ($request->zoho) {
            $response = $this->createZohoAccount($params);

            if ($response->original) {
                $this->addUserToTeam($request->teams, $request->official_email);

                $employee->zuid = $response->original->data->zuid;
                $employee->account_id = $response->original->data->accountId;
                $employee->save();

                if ($employee) {
                    Mail::to($request->email)->later($when, new ZohoInvitationMail($request->input(), $params['password']));
                }
            }
        }

        //check if slack is checked for invitation
        if ($request->slack) {
            //call the  slack trait method in app/Traits folder
            $this->createSlackInvitation($request->official_email, $token);
            //slack mail
            Mail::to($request->official_email)->later($when, new SlackInvitationMail($request->input()));
        }
        $employee_id = $employee->id;

        $leave_types = LeaveType::get();
        $arr = [];
        foreach ($leave_types as $leave_type) {
            $arr[$leave_type->id] = ['count' => $leave_type->amount];
        }
        $employee->leaveTypes()->sync($arr);

        //send message for password information and change password.
        try {
            Mail::to($request->official_email)->later($when, new EmailPasswordChange($employee_id));
            Mail::to($request->personal_email)->later($when, new EmailPasswordChange($employee_id));

            //policies
            Mail::to($request->official_email)->later($when, new CompanyPoliciesMail());

            //simsim
            Mail::to($request->official_email)->later($when, new SimSimMail());
        } catch (\Exception $e) {
            Session::flash('error', 'Email Not Send Please Set Email Configuration In .env File');
        }

        return redirect()->route('employees')->with('success', 'Employee is created succesfully');
    }

    public function storeEmployeeTimings($employee)
    {
        $employee = [
            'employee_id'  => $employee_id,
            'timing_start' => $employee->branch->timing_start,
            'timing_off'   => $employee->branch->timing_start,
            'day'          => 'Monday',
        ];

        $employee = Employee::create($arr);
    }

    public function edit($id)
    {
        $employee = Employee::find($id);
        if (! $employee) {
            abort(404);
        }

        $employee_role_id = ''; //todo
        if ($employee->roles->count() > 0) {
            $employee_role_id = $employee->roles[0]->id; //todo
        }

        $employee_permissions = [];
        foreach ($employee->permissions as $key => $value) {
            $employee_permissions[] = $value->id;
        }

        $role = Role::find($id);
        $permissions = [];
        if ($role) {
            $permissions = $role->permissions()->get();
        }

        return view('admin.employees.edit', ['title' => 'Update Employee'])
            ->with('employee', $employee)
            ->with('branches', Branch::all())
            ->with('designations', Designation::all())
            ->with('departments', Department::all())
            ->with('employment_statuses', $this->employment_statuses)
            ->with('employee_role_id', $employee_role_id)
            ->with('permissions', $permissions)
            ->with('employee_permissions', $employee_permissions)
            ->with('roles', Role::all());
    }

    public function profile()
    {
        $employee = Auth::user();
        if (! $employee) {
            abort(404);
        }

        $employee_role_id = ''; //todo
        if ($employee->roles->count() > 0) {
            $employee_role_id = $employee->roles[0]->id; //todo
        }

        $employee_permissions = [];
        foreach ($employee->permissions as $key => $value) {
            $employee_permissions[] = $value->id;
        }

        $role = Role::find($employee->id);
        $permissions = [];
        if ($role) {
            $permissions = $role->permissions()->get();
        }

        return view('admin.employees.edit', ['title' => 'Update Employee'])
            ->with('employee', $employee)
            ->with('branches', Branch::all())
            ->with('designations', $this->designations)
            ->with('employment_statuses', Designation::all())
            ->with('employee_role_id', $employee_role_id)
            ->with('permissions', $permissions)
            ->with('employee_permissions', $employee_permissions)
            ->with('roles', Role::all());
    }

    public function update(Request $request, $id)
    {
        $adminPassword = Auth::user()->password;

        if (! Hash::check($request->old_password, $adminPassword)) {
            return redirect()->back()->with('error', 'Wrong admin password entered');
        }

        $this->validate($request, [
            'firstname'      => 'required',
            'lastname'       => 'required',
            'official_email' => 'required|email|unique:employees,official_email,'.$id,
            'personal_email' => 'required|email|unique:employees,personal_email,'.$id,
            'contact_no'     => 'required|size:11|unique:employees,contact_no,'.$id,
            'picture'        => 'image|mimes:jpg,png,jpeg,gif,svg|max:1000',
            // 'cnic' => 'size:13',
        ]);

        // rename image name or file name
        if (! strstr(strtolower($request->official_email), 'glowlogix.com')) {
            return redirect()->back()->with('error', 'Enter correct official email like "abc@glowlogix.com"');
        }

        $employee = Employee::find($id);

        $employee->firstname = $request->firstname;
        $employee->lastname = $request->lastname;
        $employee->contact_no = $request->contact_no;
        if ($request->picture != '') {
            $picture = time().'_'.$request->picture->getClientOriginalName();
            $request->picture->move('storage/employees/profile/', $picture);
            $employee->picture = 'storage/employees/profile/'.$picture;
        }
        $employee->joining_date = $request->joining_date;
        $employee->exit_date = $request->exit_date;
        $employee->emergency_contact = $request->emergency_contact;
        $employee->emergency_contact_relationship = $request->emergency_contact_relationship;
        $employee->official_email = $request->official_email;
        $employee->personal_email = $request->personal_email;
        $employee->basic_salary = $request->salary;
        $employee->designation = $request->designation;
        $employee->employment_status = $request->employment_status;
        $employee->type = $request->type;
        if (! empty($request->branch_id)) {
            $employee->branch_id = $request->branch_id;
        }
        $employee->cnic = $request->cnic;
        $employee->date_of_birth = $request->date_of_birth;
        $employee->current_address = $request->current_address;
        $employee->permanent_address = $request->permanent_address;
        $employee->city = $request->city;
        $employee->department_id = $request->department_id;
        $employee->gender = $request->gender;
        $employee->status = $request->status;

        if (! empty($request->password)) {
            $employee->password = Hash::make($request->password);
        }

        $employee->invite_to_zoho = $request->invite_to_zoho;
        $employee->invite_to_slack = $request->invite_to_slack;
        $employee->invite_to_asana = $request->invite_to_asana;

        //admin password get from model confirmation box.
        $params = [
            'mode'     => '',
            'zuid'     => $employee->zuid,
            'password' => $adminPassword,
        ];

        if ($request->employee_status === '1') {
            $params['mode'] = 'enableUser';
            $employee->status = 1;
            $this->updateZohoAccount($params, $employee->account_id);
        } elseif ($request->employee_status === '0') {
            $params['mode'] = 'disableUser';
            $employee->status = 0;
            $this->updateZohoAccount($params, $employee->account_id);
        }

        $when = Carbon::now()->addMinutes(10);

        if ($request->zoho) {
            $response = $this->updateZohoAccount($params);

            if ($response->original) {
                // $this->addUserToTeam($request->teams,$request->official_email);
                // $employee->zuid = $response->original->data->zuid;
                // $employee->account_id = $response->original->data->accountId;
                // $employee->save();

                if ($employee) {
                    Mail::to($request->email)->later($when, new ZohoInvitationMail($request->input(), $params['password']));
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

        try {
            Mail::to($request->official_email)->later($when, new UpdateAccount($employee->id, $request->password));
            Mail::to($request->personal_email)->later($when, new UpdateAccount($employee->id, $request->password));
        } catch (\Exception $e) {
            Session::flash('error', 'Email Not Send Please Set Email Configuration In .env File');
        }

        if ($employee->roles->count() > 0) {
            $old_role = $employee->roles[0];
            $employee->removeRole($old_role);
        }

        if (! empty($request->role_id)) {
            $role = Role::find($request->role_id);
            $employee->assignRole($role);
        }

        if ($request->permissions) {
            foreach ($request->permissions as $permission_id) {
                if (isset($request->permissions_checked)) {
                    if (in_array($permission_id, $request->permissions_checked)) {
                        $employee->givePermissionTo($permission_id);
                    } else {
                        $employee->revokePermissionTo($permission_id);
                    }
                }
            }
        }
        $employee->save();

        return redirect()->route('employees')->with('success', 'Employee is updated succesfully');
    }

    public function trashed()
    {
        $employee = Employee::onlyTrashed()->get();

        return view('admin.employees.trashed',
            ['title' => 'Trash Employees']
        )->with('employees', $employee);
    }

    public function kill($id)
    {
        $employee = Employee::withTrashed()->where('id', $id)->first();
        $employee->forceDelete();

        return redirect()->back()->with('success', 'Employee is deleted succesfully');
    }

    public function restore($id)
    {
        $employee = Employee::withTrashed()->where('id', $id)->first();
        $employee->restore();

        return redirect()->route('employees')->with('success', 'Employee is deleted succesfully');
    }

    public function destroy(Request $request, $id)
    {
        $this->validate($request, [
            'password' => 'required',
        ]);

        $adminPassword = Auth::user()->password;

        if (! Hash::check($request->password, $adminPassword)) {
            return redirect()->back()->with('error', 'Wrong admin password entered');
        }

        $emp = Employee::find($id);
        $account_id = $emp->account_id;
        $zuid = $emp->zuid;
        $email = $emp->official_email;
        $response = $emp->delete();

        // if($response)
        if ($request->invite_to_zoho == 1) {
            $arr = [
                'zuid'     => $zuid,
                'password' => bcrypt($request->zoho_password), /*get pass from admin model box*/
            ];

            $this->deleteZohoAccount($arr, $account_id);
        }

        if ($request->invite_to_asana == 1) {
            $arr = [
                'zuid'     => $zuid,
                'password' => $adminPassword, /*get pass from admin model box*/
            ];

            $this->removeUser($email);
        }

        if ($request->invite_to_slack == 1) {
            //run bot
        }

        return redirect()->back()->with('success', 'Employee is trash succesfully');
    }

    public function EmployeeLogin()
    {
        return view('admin.employees.login');
    }

    public function postEmployeeLogin(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required',
            'password' => 'required',
        ]);

        $email = $request->email;
        $employee = Employee::where(['official_email' => $email])->first();
        if (isset($employee->password)) {
            return redirect()->back()->with('error', 'Email not found');
        }
        if (! Hash::check($request->password, $employee->password)) {
            return redirect()->back()->with('error', 'Wrong email/password entered');
        }

        if (isset($employee->id)) {
            $request->session()->put('emp_auth', $employee->id);

            return redirect()->route('employee.profile');
        }

        $messages = 'Username/Password Incorrect';

        return redirect()->back()->with('msg', $messages);
    }

    public function EmployeeProfile(Request $request)
    {
        $employee = Employee::find($request->session()->get('emp_auth'));

        return view('admin.employees.profile', ['employee' => $employee, 'title' => 'Update Profile']);
    }

    public function UpdateEmployeeProfile(Request $request, $id)
    {
        $this->validate($request, [
            'firstname' => 'required',
            'lastname'  => 'required',
        ]);

        $employee = Employee::find($id);
        $employee->firstname = $request->firstname;
        $employee->lastname = $request->lastname;
        $employee->contact = $request->contact;
        $employee->password = $request->password;
        $employee->emergency_contact = $request->emergency_contact;

        $employee->save();

        return redirect()->route('employees')->with('success', 'Employee is updated succesfully');
    }

    public function EmployeeLogout(Request $request)
    {
        $request->session()->forget('emp_auth');

        return redirect()->route('employee.login');
    }

    public function showDocs(Request $request)
    {
        $data = DB::table('employees')->where('id', $request->session()->get('emp_auth'))->get();
        $data2 = DB::table('uploads')->where('status', '=', 1)->get();

        return view('admin.employees.showDocs', ['data' => $data, 'files' => $data2, 'title' => 'All Documents']);
    }

    public function showAttendance(Request $request)
    {
        $this->meta['title'] = 'Show Attendance';
        $data = DB::table('employees')->where('id', $request->session()->get('emp_auth'))->get();
        $attendance = DB::table('attandances')->where('employee_id', $request->session()->get('emp_auth'))->get();
        $leave = DB::table('leaves')->where('employee_id', $request->session()->get('emp_auth'))->get();
        $events = [];

        if ($data->count()) {
            foreach ($attendance as $key => $value) {
                $events[] = Calendar::event(

                    'present',

                    true,
                    new \DateTime($value->checkintime),

                    new \DateTime($value->checkouttime.' +1 day'),
                    null,
                    [
                        'color' => 'green',
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
                        'color' => 'orange',
                    ]
                );
            }
        }

        $calendar = Calendar::addEvents($events);

        return view('admin.employees.showAttendance', $this->metaResponse(), ['data' => $data, 'calendar' => $calendar]);
    }

    public function seedSlackId()
    {
        $token = config('values.SlackToken');
        $output = file_get_contents('https://slack.com/api/users.list?token='.$token.'&pretty=1');
        $output = json_decode($output, true);
        foreach ($output['members'] as $key => $member) {
            $employee = Employee::where('official_email', $member['profile']['email'])->first();
            if (isset($employee->id)) {
                $employee = Employee::where('official_email', $member['profile']['email'])->first();
                $employee->slack_id = $member['id'];
                $employee->save();
            } else {
                $employee = Employee::create([
                    'slack_id'       => $member['id'],
                    'official_email' => $member['profile']['email'],
                    'firstname'      => $member['profile']['first_name'],
                    'lastname'       => $member['profile']['last_name'],
                    'contact_no'     => $member['profile']['phone'],
                    'password'       => bcrypt('123456'),
                ]);
            }
        }
    }
}
