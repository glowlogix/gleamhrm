@extends('layouts.admin')
@section('Heading')
    <h3 class="text-themecolor">Edit Employee</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
        <li class="breadcrumb-item active">Employees</li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body wizard-content">
                <a href="{{route('employees')}}" class="btn btn-sm btn-danger float-right">Cancel</a>
                <form  class="tab-wizard wizard-circle form" action="{{route('employee.update',['id'=>$employee->id])}}" method="post"  enctype="multipart/form-data">
                {{csrf_field()}}
                <!-- Step 1 -->
                    <h6>Personal Information</h6>
                    <section>
                        <center >
                            @if($employee->picture != '')
                                <input type="image"  src="{{asset($employee->picture)}}" class="img-circle picture-container picture-src"  id="wizardPicturePreview" title="" width="150" onclick="document.getElementById('wizard-picture').click();"  width="150"/>
                                <input  type="file" name="picture" id="wizard-picture" class="" hidden>
                            @else
                                <input type="image" src="{{asset('assets/images/default.png')}}" class="img-circle picture-container picture-src" id="wizardPicturePreview" title="" width="150" height="150" />
                            @endif
                            <h6 class="card-title m-t-10">Click On Image to Update  Picture</h6>
                        </center>
                        <hr class="m-t-0 m-b-40">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">First Name</label>
                                    <div class="col-md-9">
                                        <input type="text"  name="firstname" value="{{old('firstname', $employee->firstname)}}" class="form-control" placeholder="Enter First Name" required>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Last Name</label>
                                    <div class="col-md-9">
                                        <input type="text" name="lastname" value="{{old('lastname',$employee->lastname)}}" class="form-control " placeholder="Enter Last Name" required>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Personal Email</label>
                                    <div class="col-md-9">
                                        <input type="email" name="personal_email" value="{{old('personal_email',$employee->personal_email)}}"  class="form-control " placeholder="Enter Personal Email" required>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Official Email</label>
                                    <div class="col-md-9">
                                        <input type="email" name="official_email" value="{{old('official_email',$employee->official_email)}}" class="form-control " placeholder="Enter Official Email" required>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                        <!--/row-->
                        <div class="row">
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Designation</label>
                                    <div class="col-md-9">
                                        <select class="form-control custom-select" name="designation">
                                            @foreach($designations as $k => $designation)
                                                <option value="{{$k}}" @if($employee->designation == $k) selected @endif>{{$designation}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Employment Status</label>
                                    <div class="col-md-9">
                                        <select class="form-control custom-select" name="employment_status">
                                            @foreach($employment_statuses as $k => $employment_status)
                                                <option value="{{$k}}" @if($employee->employment_status == $k) selected @endif>{{$employment_status}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Type</label>
                                    <div class="col-md-9">
                                        <select class="form-control custom-select" name="type">
                                            <option value="office" @if($employee->type == "office") selected @endif>Work from Office</option>
                                            <option value="remote" @if($employee->type == "remote") selected @endif>Work Remotely</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Salary</label>
                                    <div class="col-md-9">
                                        <input type="text" name="salary" value="{{old('basic_salary',$employee->basic_salary)}}"  class="form-control " placeholder="Enter Salary" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/row-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Branch</label>
                                    <div class="col-md-9">
                                        <select class="form-control custom-select" data-placeholder="Choose a Category" name="branch_id">
                                            @foreach($branches as $branch)
                                                <option value="{{$branch->id}}" @if($branch->id == $employee->branch_id) selected @endif>{{$branch->name}} ({{$branch->address}})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Date OF Birth</label>
                                    <div class="col-md-9">
                                        <input type="date" class="form-control " id="date_of_birth" placeholder="1988-12-23" name="date_of_birth"  value="{{old('date_of_birth',$employee->date_of_birth)}}">
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                    </section>
                    <!-- Step 2 -->
                    <h6>Contact Inofrmation</h6>

                    <section>
                        <hr class="m-t-0 m-b-40">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Contact#</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" placeholder="Enter Contac#" name="contact_no" value="{{old('contact_no',$employee->contact_no)}}">
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">CNIC#</label>
                                    <div class="col-md-9">
                                        <input type="text"  class="form-control " placeholder="Enter CNIC#" name="cnic" value="{{old('cnic',$employee->cnic)}}" pattern="[0-9]{13}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/row-->
                        <br>
                        <br>
                        <h4>Emergency Contact</h4>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Contact#</label>
                                    <div class="col-md-9">
                                        <input type="text"  class="form-control " placeholder="Enter Emergency Contact#" name="emergency_contact" value="{{old('emergency_contact',$employee->emergency_contact)}}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3"> Contact Relationship</label>
                                    <div class="col-md-9">
                                        <select class="form-control custom-select" name="emergency_contact_relationship">
                                            <option value="father" @if($employee->emergency_contact_relationship == "father") selected @endif>Father</option>
                                            <option value="brother" @if($employee->emergency_contact_relationship == "brother") selected @endif>Brother</option>
                                            <option value="mother" @if($employee->emergency_contact_relationship == "mother") selected @endif>Mother</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/row-->
                        <br>
                        <br>
                        <h4>Address  Details</h4>
                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Current Address</label>
                                    <div class="col-md-9">
                                        <textarea rows="4" class="form-control " placeholder="Enter Current Address" name="current_address" value="{{old('current_address',$employee->current_address)}}"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Permanent Address</label>
                                    <div class="col-md-9">
                                        <textarea rows="4"  class="form-control "  placeholder="Enter Permanent Address" name="permanent_address" value="{{old('permanent_address',$employee->permanent_address)}}" ></textarea>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">City</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control " placeholder="Enter City" name="city" value="{{old('city',$employee->city)}}" required>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>

                    </section>
                    <br>
                    <br>
                    <!-- Step 3 -->
                    <h6>Additional</h6>
                    <section>
                        <h4>Joining / Exit</h4>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Joining Date</label>
                                    <div class="col-md-9">
                                        <input type="date" id="joining_date" class="form-control" placeholder="Enter Joining Date" name="joining_date" value="{{old('joining_date',$employee->joining_date)}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Exit Date</label>
                                    <div class="col-md-9">
                                        <input type="date" id="exit_date" class="form-control" placeholder="Enter Exit Date" name="exit_date" value="{{old('exit_date',$employee->exit_date)}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="col-md-8">
                            <div class="form-group row">
                                <div class="card-body">
                                    <div class="demo-checkbox">
                                        <input type="hidden" name="invite_to_asana" value="0" />
                                        &nbsp;&nbsp;&nbsp;&nbsp; <input type="checkbox" id="basic_checkbox_1"  type="checkbox" class="asana" name="invite_to_asana" value="1" @if($employee->invite_to_asana) checked @endif/>
                                        <label for="basic_checkbox_1">Asaana</label>
                                        <input type="hidden" name="invite_to_slack" value="0" />
                                        <input type="checkbox" id="basic_checkbox_2"  type="checkbox" class="zoho" name="invite_to_slack" value="1" @if($employee->invite_to_slack) checked @endif/>
                                        <label for="basic_checkbox_2">Slack</label>
                                        <input type="hidden" name="invite_to_zoho" value="0" />
                                        <input type="checkbox" id="basic_checkbox_3"  type="checkbox" class="zoho" name="invite_to_zoho" value="1" @if($employee->invite_to_zoho) checked @endif/>
                                        <label for="basic_checkbox_3">zoho</label>
                                    </div>
                                </div>
                            </div>
                            <div id="asana_teams" class=""></div>
                        </div>

                        <hr>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Roles</label>
                                <div class="col-md-9">
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
                        </div>
                        <div class="col-md-12" id="permissions">
                            
                        </div>
                        <button  class="btn btn-success" id="button"  data-toggle="modal" data-target="#confirm" hidden>Update Employee</button>
                        
                    </section>
                    {{--Section 4--}}
                    <h6>Change Password</h6>
                    <section>
                        <div class="form-body">
                            <hr class="m-t-0 m-b-40">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">New Password</label>
                                        <div class="col-md-9">
                                            <input type="text" id="password"  class="form-control" type="text" name="password" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    Are you sure you want to update Employee : {{ $employee->firstname }}?
                                </div>
                                <div class="modal-body">
                                    <input onkeypress="if (event.keyCode == 13) {return false;}" type="password" id="confirm_pass" class="form-control" placeholder="Admin Password" name="old_password" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button class="btn btn-success" id="submit_update" type="submit"> Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
            $(function () {
                $('#permissions').load("{{route('roles_permissions')}}/getPermissionsFromRole/{{$employee_role_id}}/{{$employee->id}}");
                $("#role").on("change",function() {
                    var role_id = this.value;

                    if (role_id != '') {
                        $('#permissions').load("{{route('roles_permissions')}}/getPermissionsFromRole/" + role_id + "/{{$employee->id}}");
                    }
                    else{
                        $('#permissions').html("");
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
                                    teams.append("<input name='teams[]' value='" +
                                        item.id + "' type='checkbox'>"+"" +
                                        "<lable class='teams row'>" + item.name +
                                    " </lable>"
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
                $("#check_all").bind('click', function () {
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
    
    $(".form-control").keypress(function(e) {
        if (e.which == 13) {
            e.preventDefault();
            return false;
        }
    });
</script>

<script src="{{asset('assets/plugins/wizard/jquery.steps.min.js')}}"></script>
<script>
    //Custom design form example
    $(".tab-wizard").steps({
        headerTag: "h6",
        bodyTag: "section",
        enableAllSteps: true,
        transitionEffect: "fade",
        titleTemplate: '<span class="step">#index#</span> #title#',
        labels: {
            finish: "Update Employee"
        },
        onFinished: function (event, currentIndex) {
            $("#button").click();
        }
    });
</script>
@endpush
@stop