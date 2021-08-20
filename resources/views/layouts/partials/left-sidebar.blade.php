<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  
  <a href="/dashboard" class="brand-link pt-3 pb-1">
    <div class="d-flex">
      <img src="{{ asset('assets/images/hrm-white-logo-1.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <img src="{{asset('assets/images/hrm-white-logo-2.png')}}" class="brand-text font-weight-light" height="45px" width="120px" style="opacity: .8; margin-top: -9px;"/>
    </div>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{asset(Auth::user()->picture)}}" onerror="this.src ='{{asset('assets/images/default.png')}}';" alt="user" class="brand-image img-circle elevation-3 bg-white" height="30px" width="30px"/>
      </div>
      <div class="info">
        <a href="#" class="d-block">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</a>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <!-- <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div> -->

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="{{route('admin.dashboard')}}" @if(request()->is('dashboard')) class="nav-link active" @else  class="nav-link" @endif>
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        @if(Auth::user()->isAllowed('ApplicantController:index') && Auth::user()->isAllowed('JobsController:index'))
          <li @if(request()->is('applicants/hired') || request()->is('job') || request()->is('applicant') || request()->is('job/create') || request()->is('job/*/edit')) class="nav-item menu-open" @else class="nav-item" @endif>
            <a href="#" @if(request()->is('applicants/hired') || request()->is('job') || request()->is('applicant') || request()->is('job/create') || request()->is('job/*/edit')) class="nav-link active" @else class="nav-link" @endif>
              <i class="nav-icon fas fa-laptop"></i>
              <p>
                Hiring
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if(Auth::user()->isAllowed('ApplicantController:index'))
                <li class="nav-item">
                  <a href="{{route('applicants')}}" @if(request()->is('applicants/hired') || request()->is('applicant')) class="nav-link active" @else class="nav-link" @endif>
                    <i class="far fa-circle nav-icon"></i>
                    <p>Application</p>
                  </a>
                </li>
              @endif
              @if(Auth::user()->isAllowed('JobsController:index'))
                <li class="nav-item">
                  <a href="{{route('job.index')}}" @if(request()->is('job/create') || request()->is('job') || request()->is('job/*/edit'))  class="nav-link active" @else class="nav-link" @endif>
                    <i class="far fa-circle nav-icon"></i>
                    <p>Jobs</p>
                  </a>
                </li>
              @endif
            </ul>
          </li>
        @endif
        @if(Auth::user()->isAllowed('EmployeeController:index') || Auth::user()->isAllowed('OrganizationHierarchyController:index') || Auth::user()->isAllowed('TeamController:index') || Auth::user()->isAllowed('VendorController:index'))
          <li @if( request()->is('employees')  || request()->is('teams') || request()->is('vendors') || request()->is('vendor/create') || request()->is('vendor/edit/*')  || str_contains( Request::fullUrl(),'organization_hierarchy') || request()->is('employee/create') || request()->is('employee/edit/*') || str_contains(Request::fullUrl(),'team_member')) class="nav-item menu-open" @else class="nav-item" @endif>
            <a href="#" @if( request()->is('employees')  || request()->is('teams') || request()->is('vendors') || request()->is('vendor/create') || request()->is('vendor/edit/*')  || str_contains( Request::fullUrl(),'organization_hierarchy') || request()->is('employee/create') || request()->is('employee/edit/*') || str_contains(Request::fullUrl(),'team_member')) class="nav-link active" @else class="nav-link" @endif>
              <i class="nav-icon fas fa-user"></i>
              <p>
                People Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if(Auth::user()->isAllowed('EmployeeController:index'))
                <li class="nav-item">
                  <a href="{{route('employees')}}" @if(request()->is('employees') || request()->is('employee/create') || request()->is('employee/edit/*')) class="nav-link active" @else class="nav-link" @endif>
                    <i class="far fa-circle nav-icon"></i>
                    <p>Employees</p>
                  </a>
                </li>
              @endif
              @if(Auth::user()->isAllowed('OrganizationHierarchyController:index'))
                <li class="nav-item">
                  <a href="{{route('organization_hierarchy.index')}}" @if(str_contains(Request::fullUrl(),'organization_hierarchy'))  class="nav-link active" @else  class="nav-link" @endif>
                    <i class="far fa-circle nav-icon"></i>
                    <p>Org Chart</p>
                  </a>
                </li>
              @endif
              @if(Auth::user()->isAllowed('TeamController:index'))
                <li class="nav-item">
                  <a href="{{route('teams.index')}}" @if(request()->is('teams') || request()->is('team_member/edit/*')) class="nav-link active" @else class="nav-link" @endif>
                    <i class="far fa-circle nav-icon"></i>
                    <p>Teams</p>
                  </a>
                </li>
              @endif
              @if(Auth::user()->isAllowed('VendorController:index'))
                <li class="nav-item">
                  <a href="{{route('vendors.index')}}" @if(request()->is('vendors') || request()->is('vendor/create') || request()->is('vendor/edit/*')) class="nav-link active" @else class="nav-link" @endif>
                    <i class="far fa-circle nav-icon"></i>
                    <p>Vendors</p>
                  </a>
                </li>
              @endif
            </ul>
          </li>
        @endif
        <li @if(request()->is('attendance/today_timeline') || request()->is('attendance/create_break/*/*') || request()->is('attendance/timeline') || request()->is('attendance/create_break') || request()->is('leave/create') || request()->is('leave/admin_create') || request()->is('my_leaves') || request()->is('employee_leaves') || str_contains(Request::fullUrl(),'leave/edit')|| str_contains(Request::fullUrl(),'leave/show')) class="nav-item menu-open" @else class="nav-item" @endif>
          <a href="#" @if(request()->is('attendance/today_timeline') || request()->is('attendance/create_break/*/*') || request()->is('attendance/timeline') || request()->is('attendance/create_break') || request()->is('leave/create') || request()->is('leave/admin_create') || request()->is('my_leaves') || request()->is('employee_leaves') || str_contains(Request::fullUrl(),'leave/edit')|| str_contains(Request::fullUrl(),'leave/show')) class="nav-link active" @else class="nav-link" @endif>
            <i class="nav-icon mdi mdi-alarm-check pl-1"></i>
            <p>
              Attendance
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            @if(Auth::user()->isAllowed('AttendanceController:today_timeline'))
              <li class="nav-item">
                <a href="{{route('today_timeline')}}" @if(request()->is('attendance/today_timeline') || request()->is('attendance/create_break/*/*')) class="nav-link active" @else class="nav-link" @endif>
                  <i class="far fa-circle nav-icon"></i>
                  <p>Today</p>
                </a>
              </li>
            @endif
            <li class="nav-item">
              <a href="{{route('myAttendance')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>My Attendance</p>
              </a>
            </li>
            @if(Auth::user()->isAllowed('AttendanceController:timeline'))
              <li class="nav-item">
                <a href="{{route('timeline')}}" @if(request()->is('attendance/timeline') || request()->is('attendance/create_break')) class="nav-link active" @else class="nav-link" @endif>
                  <i class="far fa-circle nav-icon"></i>
                  <p>Timeline</p>
                </a>
              </li>
            @endif
            @if(Auth::user()->isAllowed('LeaveController:employeeleaves'))
              <li class="nav-item">
                <a href="{{route('employeeleaves')}}" @if(request()->is('leave/admin_create') || request()->is('employee_leaves')) class="nav-link active" @else class="nav-link" @endif>
                  <i class="far fa-circle nav-icon"></i>
                  <p>Leaves</p>
                </a>
              </li>
            @endif
            <li class="nav-item">
              <a href="{{route('leave.index')}}" @if(request()->is('leave/create') || request()->is('my_leaves') || str_contains(Request::fullUrl(),'leave/edit') || str_contains(Request::fullUrl(),'leave/show')) class="nav-link active" @else class="nav-link" @endif>
                <i class="far fa-circle nav-icon"></i>
                <p>My Leaves</p>
              </a>
            </li>
          </ul>
        </li>
        @if(Auth::user()->isAllowed('DocumentsController:index') || Auth::user()->isAllowed('BranchController:index') || Auth::user()->isAllowed('DepartmentController:index') || Auth::user()->isAllowed('DesignationController:index') || Auth::user()->isAllowed('VendorCategoryController:index') || Auth::user()->isAllowed('LeaveTypeController:index') || Auth::user()->isAllowed('SkillController:index'))
          <li @if(str_contains(Request::fullUrl(),'documents') || str_contains(Request::fullUrl(),'branch') || str_contains(Request::fullUrl(),'department') || str_contains(Request::fullUrl(),'designations') || request()->is('leave_types') || request()->is('skills') || request()->is('vendors/category')) class="nav-item menu-open" @else class="nav-item" @endif>
            <a href="#" @if( str_contains(Request::fullUrl(),'documents') || str_contains(Request::fullUrl(),'branch') || str_contains(Request::fullUrl(),'department') || str_contains(Request::fullUrl(),'designations') || request()->is('leave_types')  || request()->is('skills') || request()->is('vendors/category')) class="nav-link active" @else class="nav-link" @endif>
              <i class="nav-icon fas fa-cog"></i>
              <p>
                Settings
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if(Auth::user()->isAllowed('DocumentsController:index'))
                <li class="nav-item">
                  <a href="{{ route('documents') }}" @if(str_contains(Request::fullUrl(),'documents')) class="nav-link active" @else class="nav-link" @endif>
                    <i class="far fa-circle nav-icon"></i>
                    <p>Documents</p>
                  </a>
                </li>
              @endif
              @if(Auth::user()->isAllowed('BranchController:index'))
                <li class="nav-item">
                  <a href="{{ route('branch.index') }}" @if(str_contains(Request::fullUrl(),'branch')) class="nav-link active" @else class="nav-link" @endif>
                    <i class="far fa-circle nav-icon"></i>
                    <p>Branches</p>
                  </a>
                </li>
              @endif
              @if(Auth::user()->isAllowed('DepartmentController:index'))
                <li class="nav-item">
                  <a href="{{route('departments.index')}}" @if(str_contains(Request::fullUrl(),'department')) class="nav-link active" @else class="nav-link" @endif>
                    <i class="far fa-circle nav-icon"></i>
                    <p>Departments</p>
                  </a>
                </li>
              @endif
              @if(Auth::user()->isAllowed('DesignationController:index'))
                <li class="nav-item">
                  <a href="{{route('designations.index')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Designations</p>
                  </a>
                </li>
              @endif
              @if(Auth::user()->isAllowed('VendorCategoryController:index'))
                <li class="nav-item">
                  <a href="{{route('vendor_category.index')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Vendor Categories</p>
                  </a>
                </li>
              @endif
              @if(Auth::user()->isAllowed('LeaveTypeController:index'))
                <li class="nav-item">
                  <a href="{{route('leave_type.index')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Leave Management</p>
                  </a>
                </li>
              @endif
              @if(Auth::user()->isAllowed('SkillController:index'))
                <li class="nav-item">
                  <a href="{{route('skill.index')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Skills</p>
                  </a>
                </li>
              @endif
            </ul>
          </li>
        @endif
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-database"></i>
            <p>
              Payments
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('salary.show')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Salary</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Payroll Payments</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Vendor Payments</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Bill Payments</p>
              </a>
            </li>
          </ul>
        </li>
        @if(Auth::user()->isAllowed('RolePermissionsController:index'))
        <li @if(request()->is('rolespermissions') || request()->is('rolespermissions/create') || request()->is('rolespermissions/edit/*'))) class="nav-item menu-open" @else class="nav-item" @endif>
          <a href="#" @if(request()->is('rolespermissions') || request()->is('rolespermissions/create') || request()->is('rolespermissions/edit/*'))) class="nav-link active" @else class="nav-link" @endif>
            <i class="nav-icon mdi mdi-apps pl-1"></i>
            <p>
              Manage Roles
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            @if(Auth::user()->isAllowed('RolePermissionsController:index'))
              <li class="nav-item">
                <a href="{{route('roles_permissions')}}" @if(request()->is('rolespermissions') || request()->is('rolespermissions/create') || request()->is('rolespermissions/edit/*'))) class="nav-link active" @else class="nav-link" @endif>
                  <i class="far fa-circle nav-icon"></i>
                  <p>Roles And Permissions</p>
                </a>
              </li>
            @endif
          </ul>
        </li>
        @endif
        <li class="nav-item pb-3 mb-5">
          <a href="{{route('admin.help')}}" @if(request()->is('help')) class="nav-link active" @else class="nav-link" @endif>
            <i class="nav-icon fas fa-calendar-alt"></i>
            <p>
              Help
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->  
  </div>
  <!-- /.sidebar -->
    <!-- Sidebar Footer Items -->
    <hr>
    <div class="row col-12 bg-primary pb-2 pt-2" style="position: absolute; bottom: 0px; left: 0px; margin-left: 0px; padding-left: 0px;">
      <a href="#" class="link col-4 text-center text-light" data-toggle="tooltip" title="Settings">
        <i class="fas fa-cog"></i>
      </a>
      <a href="https://www.zoho.com/mail/index1.html" class="link col-4 text-center text-light" data-toggle="tooltip" title="Email">
        <i class="mdi mdi-gmail"></i>
      </a>
      <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('sidebar-logout').submit();" class="link col-4 text-center text-light" data-toggle="tooltip" title="Logout">
        <i class="fa fa-power-off"></i>
      </a>
      <form id="sidebar-logout" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
    </div>
</aside>