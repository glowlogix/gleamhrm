<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- User profile -->
        <div class="user-profile" style="background: url({{asset('assets/images/background/user-info.jpg') }}) no-repeat;">
            <!-- User profile image -->
            <div class="profile-img"> <img src="{{asset(Auth::user()->picture)}}" onerror="this.src ='{{asset('assets/images/default.png')}}';" alt="user" height="50" width="50%" /> </div>
            <!-- User profile text-->
            <div class="profile-text"> <a href="#" class="dropdown-toggle u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">{{Auth::user()->firstname}}</a>
            <div class="dropdown-menu animated flipInY"> <a href="{{route('profile.index')}}" class="dropdown-item"><i class="ti-user"></i> My Profile</a> <a href="#" class="dropdown-item"><i class="ti-email"></i> Inbox</a>
            <div class="dropdown-divider"></div> <a href="#" class="dropdown-item"><i class="ti-settings"></i> Account Setting</a>
            <div class="dropdown-divider"></div> <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a> </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
            </div>
        </div>
        <!-- End User profile text-->
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                {{--/////Second Start--}}
                <li @if(request()->is('dashboard')) class="active" @endif ><a class="waves-effect waves-dark" href="{{route('admin.dashboard')}}" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard </span></a>
                </li>
                @if (
                    Auth::user()->isAllowed('ApplicantController:index') &&
                    Auth::user()->isAllowed('JobsController:index')
                )
                <li @if(request()->is('applicants/hired') || request()->is('job') || request()->is('applicant') || request()->is('job/create')) class = "active" @endif ><a class="has-arrow waves-effect waves-dark"  aria-expanded="false"><i class="mdi mdi-laptop-windows"></i><span class="hide-menu">Hiring</span></a>
                    <ul aria-expanded="false" class="collapse">
                        @if(
                        Auth::user()->isAllowed('ApplicantController:index')
                        )
                        <li><a href="{{route('applicants')}}" @if(request()->is('applicants/hired')) class="active" @endif>Application</a></li>
                        @endif
                        @if (
                        Auth::user()->isAllowed('JobsController:index')
                        )
                        <li><a href="{{route('job.index')}}" @if(request()->is('job/create')) class="active" @endif>Jobs</a></li>
                        @endif
                    </ul>
                </li>
                @endif
                {{--<li> <a class="" href="{{route('users')}}" aria-expanded="false"><i class="mdi mdi-account-circle"></i><span class="hide-menu">Users</span></a>--}}
                {{--</li>--}}
                @if (Auth::user()->isAllowed('EmployeeController:index') || Auth::user()->isAllowed('OrganizationHierarchyController:index') || Auth::user()->isAllowed('TeamController:index') || Auth::user()->isAllowed('VendorController:index'))
                <li @if( request()->is('employees')  || request()->is('teams') || request()->is('vendors') || request()->is('vendor/create')  || str_contains( Request::fullUrl(),'organization_hierarchy') || request()->is('employee/create') || str_contains(Request::fullUrl(),'employee/edit') || str_contains(Request::fullUrl(),'team_member')) class = "active" @endif > <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-account"></i><span class="hide-menu">People Mgmt</span></a>
                    <ul aria-expanded="false" class="collapse">
                        @if (
                        Auth::user()->isAllowed('EmployeeController:index')
                        )
                        <li><a href="{{route('employees')}}" @if(request()->is('employee/create') || str_contains(Request::fullUrl(),'employee/edit')) class="active" @endif>Employees</a></li>
                        @endif
                        @if (
                        Auth::user()->isAllowed('OrganizationHierarchyController:index')
                        )
                        <li><a href="{{route('organization_hierarchy.index')}}" @if(str_contains(Request::fullUrl(),'organization_hierarchy')) class="active" @endif>Org Chart</a></li>
                        @endif
                            @if (
                       Auth::user()->isAllowed('TeamController:index')
                       )
                        <li><a href="{{route('teams.index')}}">Teams</a></li>
                        @endif
                            @if (
                       Auth::user()->isAllowed('VendorController:index')
                       )
                        <li><a href="{{route('vendors.index')}}" @if(request()->is('vendor/create')) class="active" @endif> Vendors</a></li>
                            @endif
                    </ul>

                </li>
                @endif
                <li  @if(str_contains(Request::fullUrl(),'attendance') || request()->is('leave/create') || request()->is('leave/admin_create') || request()->is('my_leaves') || request()->is('employee_leaves') || str_contains(Request::fullUrl(),'leave/edit')|| str_contains(Request::fullUrl(),'leave/show')) class = "active" @endif ><a class="has-arrow waves-effect waves-dark" href="{{route('attendance')}}"><i class="mdi mdi-alarm-check"></i><span class="hide-menu">Attendance</span></a>
                    <ul aria-expanded="false" class="collapse">
                        @if (
                                Auth::user()->isAllowed('AttendanceController:today_timeline')
                        )
                        <li><a href="{{route('today_timeline')}}" @if( str_contains(Request::fullUrl(),'attendance/create')) class="active" @endif>Today</a></li>
                        @endif
                        <li><a href="{{route('myAttendance')}}">My Attendance</a></li>
                        @if (
                        Auth::user()->isAllowed('AttendanceController:timeline')
                        )
                        <li><a href="{{route('timeline')}}">Timeline</a></li>
                        @endif
                       {{-- <li><a href="#">History</a></li>
                        <li><a href="#">Incomplete</a></li>--}}
                        @if (
                        Auth::user()->isAllowed('LeaveController:employeeleaves')
                        )
                        <li><a href="{{route('employeeleaves')}}" >Leaves</a></li>
                        @endif
                        <li><a href="{{route('leave.index')}}" @if(request()->is('leave/create') || str_contains(Request::fullUrl(),'leave/edit') || str_contains(Request::fullUrl(),'leave/show')) class="active" @endif >My Leaves</a></li>
                    </ul>
                </li>
                @if (
               Auth::user()->isAllowed('DocumentsController:index') || Auth::user()->isAllowed('BranchController:index') || Auth::user()->isAllowed('DepartmentController:index') || Auth::user()->isAllowed('DesignationController:index') || Auth::user()->isAllowed('VendorCategoryController:index') || Auth::user()->isAllowed('LeaveTypeController:index') || Auth::user()->isAllowed('SkillController:index')
               )
                <li  @if( str_contains(Request::fullUrl(),'documents') || str_contains(Request::fullUrl(),'branch') || str_contains(Request::fullUrl(),'department') || str_contains(Request::fullUrl(),'designations') || request()->is('leave_types')  || request()->is('skills') || request()->is('vendors/category') ) class="active" @endif><a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-settings"></i><span class="hide-menu">Settings</span></a>
                    <ul aria-expanded="false" class="collapse">
                        @if (
                        Auth::user()->isAllowed('DocumentsController:index')
                        )
                        <li><a href="{{ route('documents') }}" @if(str_contains(Request::fullUrl(),'documents')) class="active" @endif >Documents</a></li>
                        @endif
                        @if (
                        Auth::user()->isAllowed('BranchController:index')
                        )
                        <li><a href="{{ route('branch.index') }}" @if(str_contains(Request::fullUrl(),'branch')) class="active" @endif >Branches</a></li>
                        @endif
                            @if (
                      Auth::user()->isAllowed('DepartmentController:index')
                      )
                        <li><a href="{{route('departments.index')}}">Departments</a></li>
                        @endif
                            @if (
                          Auth::user()->isAllowed('DesignationController:index')
                          )
                        <li><a href="{{route('designations.index')}}">Designations</a></li>
                            @endif
                            @if (
                         Auth::user()->isAllowed('VendorCategoryController:index')
                         )
                        <li><a href="{{route('vendor_category.index')}}">Vendor Categories</a></li>
                            @endif
                            @if (
                       Auth::user()->isAllowed('LeaveTypeController:index')
                       )
                        <li><a href="{{route('leave_type.index')}}">Leave Management</a></li>
                            @endif
                            @if (
                           Auth::user()->isAllowed('SkillController:index')
                           )
                        <li><a href="{{route('skill.index')}}">Skills</a></li>
                            @endif

                        {{--<li><a href="{{route('sub_skill.index')}}">Sub Skill</a></li>--}}
                        {{--<li><a href="#">Provident Fund</a></li>--}}
                    </ul>
                </li>
                @endif
                <li> <a class="has-arrow" href="#" aria-expanded="false"><i class="mdi mdi-database"></i><span class="hide-menu">Payments</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('salary.show')}}">Salary</a></li>
                        <li><a href="#">Payroll Payments</a></li>
                        <li><a href="#">Vendor Payments</a></li>
                        <li><a href="#">Bill Payments</a></li>
                    </ul>
                </li>
                @if (
                    Auth::user()->isAllowed('RolePermissionsController:index')
                )
                <li @if(request()->is('rolespermissions/create') ||request()->is('rolespermissions')) class="active" @endif > <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-apps"></i><span class="hide-menu">Manage Roles</span></a>
                    <ul aria-expanded="false" class="collapse">
                        @if (
                        Auth::user()->isAllowed('RolePermissionsController:index')
                        )
                        <li><a href="{{route('roles_permissions')}}" @if(request()->is('rolespermissions/create')) class="active" @endif  >Roles And Permissions</a></li>
                        @endif
                    </ul>
                </li>
                @endif

                <li @if(request()->is('help')) class="active" @endif> <a class="waves-effect waves-dark" href="{{route('admin.help')}}" aria-expanded="false"><i class="mdi mdi-help-circle"></i><span class="hide-menu">Help</span></a>
                </li>
                {{--///////// Second End--}}
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
    <!-- Bottom points-->
    <div class="sidebar-footer">
        <!-- item--><a href="" class="link" data-toggle="tooltip" title="Settings"><i class="ti-settings"></i></a>
        <!-- item--><a href="https://www.zoho.com/mail/index1.html" class="link" data-toggle="tooltip" title="Email"><i class="mdi mdi-gmail"></i></a>
        <!-- item--><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="link" data-toggle="tooltip" title="Logout"><i class="mdi mdi-power"></i></a></div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
    <!-- End Bottom points-->
</aside>