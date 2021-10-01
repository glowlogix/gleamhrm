<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Department;
use App\Designation;
use App\Employee;
use App\LeaveType;
use App\Mail\CompanyPoliciesMail;
use App\Mail\EmailPasswordChange;
use App\Mail\UpdateAccount;
use App\OrganizationHierarchy;
use App\Salary;
use App\Team;
use App\TeamMember;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Mail;
use Session;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
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
        return view('admin.employees.create', ['title' => 'Add Employee'])
            ->with('branches', Branch::all())
            ->with('departments', Department::all())
            ->with('employment_statuses', $this->employment_statuses)
            ->with('designations', Designation::all())
            ->with('managers', Employee::where('status', '!=', '0')->get())
            ->with('teams', Team::where('status', '!=', '0')->get());
    }

    public function store(Request $request)
    {
        //also do js validation
        $request->validate([
            'official_email' => 'required|email|unique:employees',
            'personal_email' => 'required|email|unique:employees',
            'contact_no'     => 'required|size:11|unique:employees,contact_no',
            'picture'        => 'image|mimes:jpg,png,jpeg,gif,svg|max:1000',
        ]);

        $when = Carbon::now()->addMinutes(10);
        $l = 8;
        $password = bcrypt('123456');

        $arr = [
            'firstname'                      => $request->firstname,
            'lastname'                       => $request->lastname,
            'contact_no'                     => $request->contact_no,
            'emergency_contact'              => $request->emergency_contact,
            'emergency_contact_relationship' => $request->emergency_contact_relationship,
            'emergency_contact_address'      => $request->emergency_contact_address,
            'password'                       => $password,
            'official_email'                 => $request->official_email,
            'personal_email'                 => $request->personal_email,
            'status'                         => 1,
            'employment_status'              => $request->employment_status,
            'gross_salary'                   => $request->gross_salary,
            'department_id'                  => $request->department_id,
            'designation'                    => strtolower($request->designation),
            'type'                           => $request->type,
            'identity_no'                    => $request->identity_no,
            'date_of_birth'                  => $request->date_of_birth,
            'current_address'                => $request->current_address,
            'permanent_address'              => $request->permanent_address,
            'city'                           => $request->city,
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

        $employee_id = $employee->id;

        // salary create
        $salary = new Salary();
        $salary->gross_salary = $request->gross_salary;
        $salary->employee_id = $employee_id;
        $salary->save();

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

            Session::flash('success', 'Employee is created succesfully');
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
        }

        //send policies email
        try {
            Mail::to($request->official_email)->later($when, new CompanyPoliciesMail());
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
        }

        if ($request->manager) {
            $org_chart = new OrganizationHierarchy();
            $org_chart->employee_id = $employee->id;
            $org_chart->line_manager_id = $request->manager;
            $org_chart->save();
        }

        if ($request->team) {
            $team = new TeamMember();
            $team->team_id = $request->team;
            $team->employee_id = $employee->id;
            $team->save();
        }

        return redirect()->route('employees');
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
        $employees = Employee::where('id', $id)->with('salary')->get();
        foreach ($employees as $employee) {
            if (! $employee) {
                abort(404);
            }

            $employee_role_id = 0; //todo
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
        }

        return view('admin.employees.edit', ['title' => 'Update Employee'])
            ->with('employees', $employees)
            ->with('branches', Branch::all())
            ->with('designations', Designation::all())
            ->with('departments', Department::all())
            ->with('employment_statuses', $this->employment_statuses)
            ->with('employee_role_id', $employee_role_id)
            ->with('permissions', $permissions)
            ->with('employee_permissions', $employee_permissions)
            ->with('roles', Role::all())
            ->with('managers', Employee::where('status', '!=', '0')->get())
            ->with('teams', Team::where('status', '!=', '0')->get())
            ->with('team_member', TeamMember::where('employee_id', $employee->id)->latest('created_at')->first())
            ->with('employee_manager', OrganizationHierarchy::where('employee_id', $employee->id)->latest('created_at')->first());
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
            'lastname'       => 'required',
            'official_email' => 'required|email|unique:employees,official_email,'.$id,
            'personal_email' => 'required|email|unique:employees,personal_email,'.$id,
            'contact_no'     => 'required|size:11|unique:employees,contact_no,'.$id,
            'picture'        => 'image|mimes:jpg,png,jpeg,gif,svg|max:1000',
        ]);

        $employeeWithSalary = Employee::where('id', $id)->with('salary')->get();

        foreach ($employeeWithSalary as $employee) {
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
            $employee->emergency_contact_address = $request->emergency_contact_address;
            $employee->official_email = $request->official_email;
            $employee->personal_email = $request->personal_email;
            $employee->gross_salary = $request->gross_salary;
            $employee->designation = $request->designation;
            $employee->employment_status = $request->employment_status;
            $employee->type = $request->type;
            if (! empty($request->branch_id)) {
                $employee->branch_id = $request->branch_id;
            }
            $employee->identity_no = $request->identity_no;
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

            if ($request->employee_status === '1') {
                $employee->status = 1;
            } elseif ($request->employee_status === '0') {
                $employee->status = 0;
            }

            $when = Carbon::now()->addMinutes(10);

            try {
                Mail::to($request->official_email)->later($when, new UpdateAccount($employee->id, $request->password));
            } catch (\Exception $e) {
                Session::flash('error', $e->getMessage());
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

            if ($request->manager) {
                $manager = OrganizationHierarchy::where('employee_id', $employee->id)->first();
                if ($manager == '') {
                    $org_chart = new OrganizationHierarchy();
                    $org_chart->employee_id = $employee->id;
                    $org_chart->line_manager_id = $request->manager;
                    $org_chart->save();
                } else {
                    $manager->line_manager_id = $request->manager;
                    $manager->save();
                }
            }

            if ($request->team) {
                $team_member = TeamMember::where('employee_id', $employee->id)->where('team_id', $request->team)->first();
                if ($team_member == '') {
                    $team = new TeamMember();
                    $team->team_id = $request->team;
                    $team->employee_id = $employee->id;
                    $team->save();
                }
            }

            $sum = $request->basic_salary + $request->home_allowance + $request->medical_allowance + $request->special_allowance + $request->meal_allowance + $request->conveyance_allowance;
            if ($sum == $request->gross_salary) {
                if ($employee['salary'] != '') {
                    $employee['salary']->gross_salary = $request->gross_salary;
                    $employee['salary']->basic_salary = $request->basic_salary;
                    $employee['salary']->home_allowance = $request->home_allowance;
                    $employee['salary']->medical_allowance = $request->medical_allowance;
                    $employee['salary']->special_allowance = $request->special_allowance;
                    $employee['salary']->meal_allowance = $request->meal_allowance;
                    $employee['salary']->conveyance_allowance = $request->conveyance_allowance;
                    $employee['salary']->pf_deduction = $request->pf_deduction;
                    $employee['salary']->save();
                } else {
                    $salary = new Salary();
                    $salary->gross_salary = $request->gross_salary;
                    $salary->basic_salary = $request->basic_salary;
                    $salary->home_allowance = $request->home_allowance;
                    $salary->medical_allowance = $request->medical_allowance;
                    $salary->special_allowance = $request->special_allowance;
                    $salary->meal_allowance = $request->meal_allowance;
                    $salary->conveyance_allowance = $request->conveyance_allowance;
                    $salary->pf_deduction = $request->pf_deduction;
                    $salary->employee_id = $employee->id;
                    $salary->save();
                }
            } else {
                Session::flash('error', 'Sum of salary details are not equal to gross salary. Please update salary details in section 4.');

                return redirect()->back();
            }
        }

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
        $response = $emp->delete();

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
}
