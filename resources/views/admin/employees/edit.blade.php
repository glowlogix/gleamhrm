@extends('layouts.master')

@section('content')
<!-- Breadcrumbs Start -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Edit Employee</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('employees') }}">People Management</a></li>
          <li class="breadcrumb-item"><a href="{{ url('employees') }}">Employees</a></li>
          <li class="breadcrumb-item active">Edit</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!-- Breadcrumbs End -->

<!-- Session Message Section Start -->
@include('layouts.partials.session-message')
<!-- Session Message Section End -->

<!-- Main Content Start -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form id="editEmployeeForm" action="{{route('employee.update',['id'=>$employee->id])}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                            <div class="bs-stepper">
                                <div class="row justify-content-between">
                                    <div class="bs-stepper-header" role="tablist">
                                        <!-- your steps here -->
                                        <div class="step" data-target="#personal-part">
                                          <button type="button" class="step-trigger p-0" role="tab" aria-controls="personal-part" id="personal-part-trigger">
                                            <span class="bs-stepper-circle">1</span>
                                          </button>
                                        </div>
                                    </div>
                                    <div class="line"></div>
                                    <div class="bs-stepper-header" role="tablist">
                                        <div class="step" data-target="#contact-part">
                                          <button type="button" class="step-trigger p-0" role="tab" aria-controls="contact-part" id="contact-part-trigger">
                                            <span class="bs-stepper-circle">2</span>
                                          </button>
                                        </div>
                                    </div>
                                    <div class="line"></div>
                                    <div class="bs-stepper-header" role="tablist">
                                        <div class="step" data-target="#additional-part">
                                          <button type="button" class="step-trigger p-0" role="tab" aria-controls="additional-part" id="additional-part-trigger">
                                            <span class="bs-stepper-circle">3</span>
                                          </button>
                                        </div>
                                    </div>
                                    <div class="line"></div>
                                    <div class="bs-stepper-header" role="tablist">
                                        <div class="step" data-target="#role-part">
                                          <button type="button" class="step-trigger p-0" role="tab" aria-controls="role-part" id="role-part-trigger">
                                            <span class="bs-stepper-circle">4</span>
                                          </button>
                                        </div>
                                    </div>
                                    <div class="line"></div>
                                    <div class="bs-stepper-header" role="tablist">
                                        <div class="step" data-target="#password-part">
                                          <button type="button" class="step-trigger p-0" role="tab" aria-controls="password-part" id="password-part-trigger">
                                            <span class="bs-stepper-circle">5</span>
                                          </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="bs-stepper-content pr-0 pl-0">
                                    <div id="personal-part" class="content" role="tabpanel" aria-labelledby="personal-part-trigger">
                                        <h5 class="pt-3"><strong>Personal Information</strong></h5>
                                        <hr class="mt-0">
                                        <center>
                                            <input type="image" @if($employee->picture != '') src="{{asset($employee->picture)}}" @else src="{{asset('assets/images/default.png')}}" @endif class="img-circle picture-container picture-src" alt="Employee Picture" id="wizardPicturePreview" title="" width="90" height="90" />
                                            <br>
                                            <a class="btn btn-primary btn-sm mt-1" onclick="document.getElementById('wizard-picture').click();">Add Image</a>
                                            <div class="form-group mb-0">
                                                <input type="file" name="picture" id="wizard-picture" class="form-control col-2" style="position: absolute; top: 0px;z-index: -1;">
                                            </div>
                                        </center>

                                        <hr>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">First Name</label>
                                                    <input type="text"  name="firstname" value="{{old('firstname', $employee->firstname)}}" class="form-control" placeholder="Enter First Name"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Last Name</label>
                                                    <input type="text" name="lastname" value="{{old('lastname',$employee->lastname)}}" class="form-control" placeholder="Enter Last Name"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Personal Email</label>
                                                    <input type="email" name="personal_email" value="{{old('personal_email',$employee->personal_email)}}"  class="form-control" placeholder="Enter Personal Email"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Official Email</label>
                                                    <input type="email" name="official_email" value="{{old('official_email',$employee->official_email)}}" class="form-control" placeholder="Enter Official Email"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Gender</label>
                                                    <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" name="gender">
                                                        <option value="">Select Gender</option>
                                                        <option value="Male" @if($employee->gender=="Male") selected @endif >Male</option>
                                                        <option value="Female"  @if($employee->gender=="Female") selected @endif>Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Date OF Birth</label>
                                                    <input type="date" class="form-control " id="date_of_birth" placeholder="1988-12-23" name="date_of_birth"  value="{{old('date_of_birth',$employee->date_of_birth)}}">
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <h5 class="pt-3"><strong>Job Information</strong></h5>
                                        <hr class="mt-0">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Employment Type</label>
                                                    <select class="form-control custom-select" name="type">
                                                        <option value="office" @if($employee->type == "office") selected @endif>Work from Office</option>
                                                        <option value="remote" @if($employee->type == "remote") selected @endif>Work Remotely</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Employment Status</label>
                                                    <select class="form-control custom-select" name="employment_status">
                                                        @foreach($employment_statuses as $k => $employment_status)
                                                            <option value="{{$k}}" @if($employee->employment_status == $k) selected @endif>{{$employment_status}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Designation</label>
                                                    <select class="form-control custom-select" name="designation">
                                                        @foreach($designations as  $designation)
                                                            <option value="{{$designation->designation_name}}" @if($employee->designation ==$designation->designation_name) selected @endif>{{$designation->designation_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Department</label>
                                                    <select class="form-control custom-select" data-placeholder="Choose a Category" name="department_id">
                                                        <option value="">Select Department</option>
                                                        @if($departments->count()>0)
                                                            @foreach($departments as $department)
                                                                <option value="{{$department->id}}" @if($department->id == $employee->department_id) selected @endif>{{$department->department_name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Branch</label>
                                                    <select class="form-control custom-select" data-placeholder="Choose a Category" name="branch_id">
                                                        @foreach($branches as $branch)
                                                            <option value="{{$branch->id}}" @if($branch->id == $employee->branch_id) selected @endif>{{$branch->name}} ({{$branch->address}})</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="control-label">Manager</label>
                                                    <select class="form-control custom-select" name="manager">
                                                        <option value="">Select Manager</option>
                                                        @foreach($managers as $manager)
                                                            <option value="{{$manager->id}}" @if($employee_manager) @if($manager->id == $employee_manager->line_manager_id) selected @endif @endif>{{$manager->firstname}} {{$manager->lastname}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="control-label">Team</label>
                                                    <select class="form-control custom-select" name="team">
                                                        <option value="">Select Team</option>
                                                        @foreach($teams as $team)
                                                            <option value="{{$team->id}}" @if($team_member) @if($team->id == $team_member->team_id) selected @endif @endif>{{$team->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Salary</label>
                                                    <input type="text" name="salary" value="{{old('basic_salary',$employee->basic_salary)}}"  class="form-control " placeholder="Enter Salary"/>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div>
                                            <button type="button" onclick="window.location.href='{{route('employees')}}'" class="btn btn-default" data-toggle="tooltip" title="Cancel"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class=" fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
                                            <button class="btn btn-primary float-right ml-1 update" data-toggle="tooltip" title="Update Employee"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-check-circle"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Update</span></button>
                                            <a class="btn btn-info float-right ml-1" onclick="stepper.next()" data-toggle="tooltip" title="Next Step"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-chevron-right"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Next</span></a>
                                        </div>
                                    </div>
                                    <div id="contact-part" class="content" role="tabpanel" aria-labelledby="contact-part-trigger">
                                        <h5 class="pt-3"><strong>Contact Information</strong></h5>
                                        <hr class="mt-0">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Contact#</label>
                                                    <input type="text" class="form-control" placeholder="Enter Contact Number" name="contact_no" value="{{old('contact_no',$employee->contact_no)}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Identity#</label>
                                                    <input type="text"  class="form-control " placeholder="Enter Identity Number" name="identity_no" value="{{old('identity_no',$employee->identity_no)}}" maxlength="13" />
                                                </div>
                                            </div>
                                        </div>
                                        <h5 class="pt-3"><strong>Emergency Contact</strong></h5>
                                        <hr class="mt-0">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Emergency Contact#</label>
                                                    <input type="text"  class="form-control " placeholder="Enter Emergency Contact Number" name="emergency_contact" value="{{old('emergency_contact',$employee->emergency_contact)}}"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Emergency Contact Relationship</label>
                                                    <select class="form-control custom-select" name="emergency_contact_relationship">
                                                        <option value="father" @if($employee->emergency_contact_relationship == "father") selected @endif>Father</option>
                                                        <option value="brother" @if($employee->emergency_contact_relationship == "brother") selected @endif>Brother</option>
                                                        <option value="mother" @if($employee->emergency_contact_relationship == "mother") selected @endif>Mother</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="control-label">Emergency Contact Address</label>
                                                    <textarea rows="4" class="form-control" placeholder="Enter Emergency Contact Address" name="emergency_contact_address">{{ $employee->emergency_contact_address }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <h5 class="pt-3"><strong>Address Details</strong></h5>
                                        <hr class="mt-0">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Current Address</label>
                                                    <textarea rows="4" class="form-control " placeholder="Enter Current Address" name="current_address" value="{{old('current_address',$employee->current_address)}}">{{$employee->current_address}}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Permanent Address</label>
                                                    <textarea rows="4"  class="form-control "  placeholder="Enter Permanent Address" name="permanent_address" value="{{old('permanent_address',$employee->permanent_address)}}" >{{$employee->permanent_address}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">City</label>
                                                    <input type="text" class="form-control" placeholder="Enter City" name="city" value="{{old('city',$employee->city)}}" required />
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div>
                                            <button type="button" onclick="window.location.href='{{route('employees')}}'" class="btn btn-default" data-toggle="tooltip" title="Cancel"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class=" fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
                                            <button class="btn btn-primary float-right ml-1 update" data-toggle="tooltip" title="Update Employee"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-check-circle"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Update</span></button>
                                            <a class="btn btn-info float-right ml-1" onclick="stepper.next()" data-toggle="tooltip" title="Next Step"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-chevron-right"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Next</span></a>
                                            <a class="btn btn-secondary float-right ml-1" onclick="stepper.previous()" data-toggle="tooltip" title="Previous Step"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-chevron-left"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Previous</span></a>
                                        </div>
                                    </div>
                                    <div id="additional-part" class="content" role="tabpanel" aria-labelledby="additional-part-trigger">
                                        <h5 class="pt-3"><strong>Joining / Exit</strong></h5>
                                        <hr class="mt-0">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Joining Date</label>
                                                    <input type="date" id="joining_date" class="form-control" placeholder="Enter Joining Date" name="joining_date" value="{{old('joining_date',$employee->joining_date)}}"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Exit Date</label>
                                                    <input type="date" id="exit_date" class="form-control" placeholder="Enter Exit Date" name="exit_date" value="{{old('exit_date',$employee->exit_date)}}"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Status</label>
                                                    <select class="form-control custom-select" name="status">
                                                        <option value="0" @if($employee->status0 == "0") selected @endif>InActive</option>
                                                        <option value="1" @if($employee->status == "1") selected @endif>Active</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <div class="demo-checkbox justify-content-between row col-lg-6 col-md-6 col-sm-12">
                                                <div>
                                                    <input type="hidden" name="invite_to_asana" value="0" />
                                                    <input type="checkbox" id="basic_checkbox_1"  type="checkbox" class="asana" name="invite_to_asana" value="1" @if($employee->invite_to_asana) checked @endif/>
                                                    <label for="basic_checkbox_1">Asana</label>
                                                </div>
                                                <div>
                                                    <input type="hidden" name="invite_to_slack" value="0" />
                                                    <input type="checkbox" id="basic_checkbox_2"  type="checkbox" class="zoho" name="invite_to_slack" value="1" @if($employee->invite_to_slack) checked @endif/>
                                                    <label for="basic_checkbox_2">Slack</label>
                                                </div>
                                                <div>
                                                    <input type="hidden" name="invite_to_zoho" value="0" />
                                                    <input type="checkbox" id="basic_checkbox_3"  type="checkbox" class="zoho " name="invite_to_zoho" value="1" @if($employee->invite_to_zoho) checked @endif/>
                                                    <label for="basic_checkbox_3">zoho</label>
                                                </div>
                                            </div>
                                            <div id="asana_teams" class=""></div>
                                        </div>
                                        <hr>
                                        <div>
                                            <button type="button" onclick="window.location.href='{{route('employees')}}'" class="btn btn-default" data-toggle="tooltip" title="Cancel"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class=" fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
                                            <button class="btn btn-primary float-right ml-1 update" data-toggle="tooltip" title="Update Employee"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-check-circle"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Update</span></button>
                                            <a class="btn btn-info float-right ml-1" onclick="stepper.next()" data-toggle="tooltip" title="Next Step"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-chevron-right"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Next</span></a>
                                            <a class="btn btn-secondary float-right ml-1" onclick="stepper.previous()" data-toggle="tooltip" title="Previous Step"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-chevron-left"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Previous</span></a>
                                        </div>
                                    </div>
                                    <div id="role-part" class="content" role="tabpanel" aria-labelledby="role-part-trigger">
                                        <h5 class="pt-3"><strong>Roles</strong></h5>
                                        <hr class="mt-0">
                                        <div class="row justify-content-between">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="control-label">Roles</label>
                                                    <select class="form-control custom-select" name="role_id" id="role">
                                                        <option value="">Select Role</option>
                                                        @if($roles->count() >0)
                                                            @foreach($roles as $role)
                                                                <option value="{{$role->id}}" @if($role->id == $employee_role_id)) selected @endif>{{$role->name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6 mt-5 text-right" id="select_all_checkbox" style="display: none;">
                                                <label for="check_all"><input type="checkbox" class="mr-1" id="check_all"/>Select All</label>
                                            </div>
                                        </div>

                                        <hr class="mt-0" id="hr_line" style="display: none;">

                                        <div class="demo-checkbox" id="permissions">
                                            
                                        </div>
                                        <hr>
                                        <div>
                                            <button type="button" onclick="window.location.href='{{route('employees')}}'" class="btn btn-default" data-toggle="tooltip" title="Cancel"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class=" fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
                                            <button class="btn btn-primary float-right ml-1 update" data-toggle="tooltip" title="Update Employee"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-check-circle"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Update</span></button>
                                            <a class="btn btn-info float-right ml-1" onclick="stepper.next()" data-toggle="tooltip" title="Next Step"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-chevron-right"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Next</span></a>
                                            <a class="btn btn-secondary float-right ml-1" onclick="stepper.previous()" data-toggle="tooltip" title="Previous Step"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-chevron-left"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Previous</span></a>
                                        </div>
                                    </div>
                                    <div id="password-part" class="content" role="tabpanel" aria-labelledby="password-part-trigger">
                                        <h5 class="pt-3"><strong>Change Password</strong></h5>
                                        <hr class="mt-0">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">New Password</label>
                                                    <input type="text" id="password"  class="form-control" type="text" name="password" autocomplete="new-password"/>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div>
                                            <button type="button" onclick="window.location.href='{{route('employees')}}'" class="btn btn-default" data-toggle="tooltip" title="Cancel"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class=" fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
                                            <button class="btn btn-primary float-right ml-1 update" data-toggle="tooltip" title="Update Employee"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-check-circle"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Update</span></button>
                                            <a class="btn btn-secondary float-right ml-1" onclick="stepper.previous()" data-toggle="tooltip" title="Previous Step"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-chevron-left"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Previous</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                          <h4 class="modal-title">Update Employee</h4>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to update Employee "{{ $employee->firstname }}"?
                                            <div class="form-group mt-3">
                                                <label class="control-label">Password</label>
                                                <input onkeypress="if (event.keyCode == 13) {return false;}" type="password" id="confirm_pass" class="form-control" placeholder="Enter admin password" name="old_password" required />
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
                                            <button  type="submit" class="btn btn-primary btn-ok"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-check-circle"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Update</span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Main Content End -->

<!-- BS Stepper StyleSheet -->
<link rel="stylesheet" href="{{ asset('assets/backend/plugins/bs-stepper/css/bs-stepper.min.css') }}">
<!-- BS-Stepper Script -->
<script src="{{ asset('assets/backend/plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
<script>
    $(function () {
        $('#editEmployeeForm').validate({
            rules: {
                firstname: {
                    required: true
                },
                lastname: {
                    required: true
                },
                personal_email: {
                    required: true
                },
                official_email: {
                    required: true
                },
                salary: {
                    required: true
                },
                emergency_contact: {
                    required: true
                },
                date_of_birth: {
                    required: true
                },
                city: {
                    required: true
                },
                permanent_address: {
                    required: true
                },
                current_address: {
                    required: true
                },
                old_password: {
                    required: true
                }
            },
            messages: {
                firstname: "First name is required",
                lastname: "Last name is required",
                personal_email: "Personal email is required",
                official_email: "Official email is required",
                salary: "Salary is required",
                emergency_contact: "Emergency contact number is required",
                date_of_birth: "Date of birth is required",
                city: "City is required",
                permanent_address: "Permanent address is required",
                current_address: "Current address is required",
                old_password: "Admin password is required"
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
              error.addClass('invalid-feedback');
              element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
              $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
              $(element).removeClass('is-invalid');
            }
        });
    });

    $(".update").on('click', function(){
        if($("#editEmployeeForm").valid() == true)
        {
            event.preventDefault();
            $("#confirm").modal('show');
        }
        console.log(this);
      });

    // BS-Stepper Init
    document.addEventListener('DOMContentLoaded', function () {
        window.stepper = new Stepper(document.querySelector('.bs-stepper'))
    });

    $(document).ready(function () {
        $(function () {
            $("#role").on("change",function() {
                var role_id = this.value;

                if (role_id != '') {
                    $('#permissions').load("{{route('roles_permissions')}}/getPermissionsFromRole/" + role_id + "/{{$employee->id}}");
                    jQuery.ajax({
                        type: "GET",
                        url: "/rolespermissions/checkPermissions/" + role_id + "/{{$employee->id}}",
                        data: {
                            role_id: role_id,
                            employee_id: {!! $employee->id !!},
                        },
                        success: function (data) {
                            if(data == 1)
                            {
                                document.getElementById('select_all_checkbox').style.display = 'block';
                                document.getElementById('hr_line').style.display = 'block';
                            }
                            else
                            {
                                document.getElementById('select_all_checkbox').style.display = 'none';
                                document.getElementById('hr_line').style.display = 'none';
                            }
                        }
                    });
                }
                else{
                    $('#permissions').html("");
                    document.getElementById('select_all_checkbox').style.display = 'none';
                    document.getElementById('hr_line').style.display = 'none';
                }
            });
        });

        var pass_flag = 0;

        $("#submit_update").click(function(){
            pass_flag = 1;
        });

        // console.log(pass_flag); here
        $("#employee_form").submit(function(event){
            $('#confirm').modal('show');
            if (pass_flag != 1){
                event.preventDefault();
            }
        });
        var teams = $('#asana_teams');
        var count = 0;
        var orgId = '{{config('values.asanaWorkspaceId')}}';
        var token = '{{config('values.asanaToken')}}';
        $('.asana').bind('click', function () {
            if ($(this).is(':checked')) {

                $.ajax({
                    url: "https://app.asana.com/api/1.0/organizations/"+orgId+"/teams",
                    type: 'GET',
                    cache: false,
                    dataType: 'json',
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                    },
                    success: function (res) {
                        count++;
                        if (count == 1) {
                            teams.append("<h3 class='head row'>Teams in Asana</h3>");
                            res.data.forEach(function (item, index) {
                                teams.append("<div class='row'><lable class='teams'><input style='position:unset;opacity:5' name='teams[]' value='" +item.id + "' type='checkbox' id='"+item.id+"'>"+item.name+"</lable><div>"
                                );
                            });
                        }
                        teams.show();
                        $('#asana_teams input').each(function () {
                            var $checkbox = $(this);
                            $checkbox.checkbox();
                        });
                    },
                    error:function(err){
                        console.log(err);
                    }
                })
            } else {
                teams.hide();
            }
        })
    });

    $(function () {
        $(document).ready(function () {
            $(function () {
                $("#check_all").on('click', function () {
                    $('input:checkbox').not(this).prop('checked', this.checked);
                });
                $(".check_all_sub").click(function () {
                    $('div.' + this.id + ' input:checkbox').prop('checked', this.checked);
                });
            });
        });
    });

    $(document).ready(function(){
        $("#wizard-picture").change(function(){
            readURL(this);
        });
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#wizardPicturePreview').attr('src', e.target.result).fadeIn('slow');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    //Custom design form example
    $(".form-control").keypress(function(e) {
        if (e.which === 13) {
            e.preventDefault();
            return false;
        }
    });

    $("input").attr('autocomplete', 'off');
    var $input = $('<button id="save" class="btn text-white" style="margin:0px 0 0 5px;padding:8.2px 12px;background-color:#009efb">Update Employee</button>');
    $input.appendTo($('ul[aria-label=Pagination]'));
    $('#save').click(function(){
        $(".button").click();
    })
</script>
@stop