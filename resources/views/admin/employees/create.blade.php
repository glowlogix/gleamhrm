@extends('layouts.master')

@section('content')
<!-- Breadcrumbs Start -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Create Employee</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('employees') }}">People Management</a></li>
          <li class="breadcrumb-item"><a href="{{ url('employees') }}">Employees</a></li>
          <li class="breadcrumb-item active">Create</li>
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
                        <button type="button" onclick="window.location.href='{{route('employees')}}'" class="btn btn-info" data-toggle="tooltip" title="Back"><i class="fas fa-chevron-left"></i><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Back</span></button>

                        <hr>

                        <form id="createEmployeeForm" action="{{route('employee.store')}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <center>
                                <input type="image" src="{{asset('assets/images/default.png')}}" class="img-circle picture-container picture-src" id="wizardPicturePreview" title="" width="90" height="90" />
                                <br>
                                <a class="btn btn-primary btn-sm" id="change">Add Image</a>
                                <div class="form-group mb-0">
                                    <input type="file" name="picture" id="wizard-picture" class="form-control" style="position: absolute; top: 0px;z-index: -1;">
                                </div>
                            </center>
                            <h5 class="pt-3"><strong>Employee Information</strong></h5>
                            <hr class="mt-0">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">First Name</label>
                                        <input type="text" name="firstname" aria-describedby="firstname" value="{{ old('firstname') }}" class="form-control" placeholder="Enter First Name">
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Last Name</label>
                                        <input type="text" name="lastname" aria-describedby="lastname" value="{{ old('lastname') }}" class="form-control " placeholder="Enter Last Name">
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Personal Email</label>
                                        <input type="email" name="personal_email" aria-describedby="personal_email" value="{{ old('personal_email') }}"   class="form-control " placeholder="Enter Personal Email">
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Official Email</label>
                                        <input type="email" name="official_email" aria-describedby="official_email" value="{{ old('official_email') }}" class="form-control " placeholder="Enter Official Email">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Gender</label>
                                        <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" name="gender">
                                            <option value="">Select Gender</option>
                                            <option value="Male" @if(old('gender') == 'Male') selected @endif>Male</option>
                                            <option value="Female" @if(old('gender') == 'Female') selected @endif>Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Date OF Birth</label>
                                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"  value="{{Carbon\Carbon::now()->subYears(20)->format('Y-m-d') }}">
                                    </div>
                                </div>
                            </div>

                            <h5 class="pt-3"><strong>Job Information</strong></h5>
                            <hr class="mt-0">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Employment Type</label>
                                        <select class="form-control custom-select" name="type">
                                            <option value="office" @if(old('type') == 'office') selected @endif>Work from Office</option>
                                            <option value="remote" @if(old('type') == 'remote') selected @endif>Work Remotely</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Employment Status</label>
                                        <select class="form-control custom-select" name="employment_status">
                                            @foreach($employment_statuses as $k => $employment_status)
                                                <option value="{{$k}}" @if(old('employment_status') == $k) selected @endif>{{$employment_status}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Designation</label>
                                        <select class="form-control custom-select" name="designation">
                                            @foreach($designations as $designation)
                                                <option value="{{$designation->designation_name}}" @if(old('designation') == $designation->designation_name) selected @endif>{{$designation->designation_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Department</label>
                                        <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" name="department_id">
                                            <option value="">Select Department</option>
                                            @if($departments->count() > 0)
                                                @foreach($departments as $department)
                                                    <option value="{{$department->id}}" @if(old('department_id') == $department->id) selected @endif>{{$department->department_name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Branch</label>
                                        <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" name="branch_id">
                                            @foreach($branches as $branch)
                                                <option value="{{$branch->id}}" @if(old('branch_id') == $branch->id) selected @endif>{{$branch->name}} ({{$branch->address}})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Joining Date</label>
                                        <input type="date" id="joining_date" class="form-control" placeholder="Enter Joining Date" name="joining_date" value="{{old('joining_date')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Manager</label>
                                        <select class="form-control custom-select" name="manager">
                                            <option value="">Select Manager</option>
                                            @foreach($managers as $manager)
                                                <option value="{{$manager->id}}" @if(old('manager') == $manager->id) selected @endif>{{$manager->firstname}} {{$manager->lastname}}</option>
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
                                                <option value="{{$team->id}}" @if(old('team') == $team->id) selected @endif>{{$team->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Salary</label>
                                        <input type="text" name="salary" aria-describedby="salary" value="{{ old('salary') }}"  class="form-control " placeholder="Enter Salary">
                                    </div>
                                </div>
                            </div>

                            <h5 class="pt-3"><strong>Contact Information</strong></h5>
                            <hr class="mt-0">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Contact#</label>
                                        <input type="text"  class="form-control" placeholder="Enter Contact Number" name="contact_no" value="{{ old('contact_no') }}" pattern="[0-9]{11}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Identity#</label>
                                        <input type="text" class="form-control " placeholder="Enter Identity Number" name="identity_no" value="{{ old('identity_no') }}" maxlength="13">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Permanent Address</label>
                                        <textarea rows="4" class="form-control"  placeholder="Enter Permanent Address" name="permanent_address">{{ old('permanent_address') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Current Address</label>
                                        <textarea rows="4" class="form-control" placeholder="Enter Current Address" name="current_address">{{ old('current_address') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">City</label>
                                        <input type="text" class="form-control" placeholder="Enter City" name="city" value="{{ old('city') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="demo-checkbox justify-content-between row col-lg-6 col-md-6 col-sm-12">
                                    <div>
                                        <input type="hidden" name="invite_to_asana" value="0" />
                                        <input type="checkbox" id="basic_checkbox_1"  class="asana" name="invite_to_asana" value="1"/>
                                        <label for="basic_checkbox_1">Asana</label>
                                    </div>

                                    <div>
                                        <input type="hidden" name="invite_to_slack" value="0" />
                                        <input type="checkbox" id="basic_checkbox_2"  class="zoho" name="invite_to_slack" value="1"/>
                                        <label for="basic_checkbox_2">Slack</label>
                                    </div>

                                    <div>
                                        <input type="hidden" name="invite_to_zoho" value="0" />
                                        <input type="checkbox" id="basic_checkbox_3" class="zoho" name="invite_to_zoho" value="1"/>
                                        <label for="basic_checkbox_3">Zoho</label>
                                    </div>
                                </div>
                            </div>
                            <div id="asana_teams" class=""></div>

                            <h5 class="pt-3"><strong>Emergency Contact</strong></h5>
                            <hr class="mt-0">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Emergency Contact#</label>
                                        <input type="text"  class="form-control" placeholder="Enter Emergency Contact Number" name="emergency_contact" value="{{ old('emergency_contact') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Emergency Contact Relationship</label>
                                        <select class="form-control custom-select" name="emergency_contact_relationship">
                                            <option value="father" @if(old("emergency_contact_relationship") == "father") selected @endif>Father</option>
                                            <option value="brother" @if(old('emergency_contact_relationship') == "brother") selected @endif>Brother</option>
                                            <option value="mother" @if(old('emergency_contact_relationship') == "mother") selected @endif>Mother</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Emergency Contact Address</label>
                                        <textarea rows="4" class="form-control" placeholder="Enter Emergency Contact Address" name="emergency_contact_address">{{ old('emergency_contact_address') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <button type="submit" class="btn btn-primary" data-toggle="tooltip" title="Create Employee"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-check-circle"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Create</span></button>
                            <button type="button" onclick="window.location.href='{{route('employees')}}'" class="btn btn-default" data-toggle="tooltip" title="Cancel"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Main Content End -->

<script>     
    $(function () {
        $('#createEmployeeForm').validate({
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
                contact_no: {
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
                picture: {
                    required: true
                }
            },
            messages: {
                firstname: "First name is required",
                lastname: "Last name is required",
                personal_email: "Personal email is required",
                official_email: "Official email is required",
                salary: "Salary is required",
                contact_no: "Contact number is required",
                emergency_contact: "Emergency contact number is required",
                date_of_birth: "Date of birth is required",
                city: "City is required",
                permanent_address: "Permanent address is required",
                current_address: "Current address is required",
                picture: "Picture is required"
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

    $(document).ready(function () {
        $(function () {
            $("#role").on("change",function() {
                var role_id = this.value;
                $('#permissions').load("{{route('roles_permissions')}}/getPermissionsFromRole/" + role_id);
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
                            teams.append("<h3 class='head'>Teams in Asana</h3>");
                            res.data.forEach(function (item, index) {
                                teams.append("<div class='row'><lable class='teams'><input name='teams[]' value='" + item.id + "' style='position:unset;opacity:5' type='checkbox' id='"+ item.name +"' >"+ item.name +"</lable></div>"
                                );
                            });
                        }
                        teams.show();
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
        // Prepare the preview for profile picture
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

    $("#change").click(function() {
        $("input[id='wizard-picture']").click();
    });

    $(".form-control").keypress(function(e) {
        if (e.which == 13) {
            e.preventDefault();
            return false;
        }
    });

    $('#asana_teams input[type="checkbox"]').each(function () {
        var $checkbox = $(this);
        $checkbox.checkbox();
    });
</script>
@stop