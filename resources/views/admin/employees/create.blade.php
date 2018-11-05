@extends('layouts.admin')
@section('Heading')
    <h3 class="text-themecolor">Create Employee</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
        <li class="breadcrumb-item active">Employees</li>
        <li class="breadcrumb-item active">Create</li>
    </ol>
@stop
@section('content')
    @if (Session::has('error'))
        <div class="alert alert-warning" align="left">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong>!</strong> {{Session::get('error')}}
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-outline-info">
                <div style="margin-top:10px; margin-right: 10px;">
                    <button type="button" onclick="window.location.href='{{route('employees')}}'" class="btn btn-info float-right">Back</button>
                </div>
                <div class="card-body">
                    <form action="{{route('employee.store')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-body">
                            <center >
                                <input type="image"  src="{{asset('assets/images/default.png')}}" class="img-circle picture-container picture-src"  id="wizardPicturePreview" title="" width="150" />
                                <input type="file"  name="picture" id="wizard-picture" class="" hidden>
                                <h6 class="card-title m-t-10">Click On Image to Add Picture</h6>
                            </center>
                            <h3 class="box-title">Employee Information</h3>
                            <hr class="m-t-0 m-b-40">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">First Name</label>
                                        <div class="col-md-9">
                                            <input type="text"  name="firstname" value="{{ old('firstname') }}" class="form-control" placeholder="Enter First Name" required>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Last Name</label>
                                        <div class="col-md-9">
                                            <input type="text" name="lastname" value="{{ old('lastname') }}" class="form-control " placeholder="Enter Last Name" required>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Personal Email</label>
                                        <div class="col-md-9">
                                            <input type="email" name="personal_email" value="{{ old('personal_email') }}"   class="form-control " placeholder="Enter Personal Email" required>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Official Email</label>
                                        <div class="col-md-9">
                                            <input type="email" name="official_email" value="{{ old('official_email') }}" class="form-control " placeholder="Enter Official Email" required>
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
                                                    <option value="{{$k}}" @if(old("designation") == "$k") selected @endif>{{$designation}}</option>
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
                                                    <option value="{{$k}}" @if(old("employment_status") == "$k") selected @endif>{{$employment_status}}</option>
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
                                                <option value="office" @if(old('type') == "office") selected @endif>Work from Office</option>
                                                <option value="remote" @if(old("type") == "remote") selected @endif>Work Remotely</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Salary</label>
                                        <div class="col-md-9">
                                            <input type="text" name="salary" value="{{ old('salary') }}"  class="form-control " placeholder="Enter Salary" required>
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
                                            <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" name="branch_id">
                                                @foreach($branches as $branch)
                                                    <option value="{{$branch->id}}" @if(old("branch_id") == "remote") selected @endif>{{$branch->name}} ({{$branch->address}})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!--/span-->
                            </div>
                        </div>
                        <br>
                        {{--///Contact Info///--}}
                        <div class="form-body">
                            <h3 class="box-title">Contact Information</h3>
                            <hr class="m-t-0 m-b-40">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Contact#</label>
                                        <div class="col-md-9">
                                            <input type="text"  class="form-control" placeholder="Enter Contac#" name="contact_no" value="{{ old('contact_no') }}" pattern="[0-9]{11}" required>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">CNIC#</label>
                                        <div class="col-md-9">
                                            <input type="text"  class="form-control " placeholder="Enter CNIC#" name="cnic" value="{{ old('cnic') }}" pattern="[0-9]{13}">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!--/row-->
                            <div class="row">
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Emergency Contact Relationship</label>
                                        <div class="col-md-9">
                                            <select class="form-control custom-select" name="emergency_contact_relationship">
                                                <option value="father" @if(old("emergency_contact_relationship") == "father") selected @endif>Father</option>
                                                <option value="brother" @if(old('emergency_contact_relationship') == "brother") selected @endif>Brother</option>
                                                <option value="mother" @if(old('emergency_contact_relationship') == "mother") selected @endif>Mother</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Emergency Contact#</label>
                                        <div class="col-md-9">
                                            <input type="text"  class="form-control " placeholder="Enter Emergency Contact#" name="emergency_contact" value="{{ old('emergency_contact') }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/row-->

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Date OF Birth</label>
                                        <div class="col-md-9">
                                            <input type="date" class="form-control " id="date_of_birth" name="date_of_birth"  value="{{Carbon\Carbon::now()->subYears(20)->format('Y-m-d') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">City</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control " placeholder="Enter City" name="city" value="{{ old('city') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Permanent Address</label>
                                    <div class="col-md-9">
                                        <textarea rows="4"  class="form-control "  placeholder="Enter Permanent Address" name="permanent_address" value="{{ old('permanent_address') }}" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Current Address</label>
                                    <div class="col-md-9">
                                        <textarea  rows="4"  class="form-control " placeholder="Enter Current Address" name="current_address" value="{{ old('current_address') }}" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Joining Date</label>
                                    <div class="col-md-9">
                                        <input type="date" id="joining_date" class="form-control" placeholder="Enter Joining Date" name="joining_date" value="{{old('joining_date')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group row">
                                <div class="card-body">
                                    <div class="demo-checkbox">
                                        &nbsp;&nbsp;
                                        <input type="hidden" name="invite_to_asana" value="0" />
                                        <input type="checkbox" id="basic_checkbox_1"  class="asana" name="invite_to_asana" value="1"/>
                                        <label for="basic_checkbox_1">Asana</label>

                                        <input type="hidden" name="invite_to_slack" value="0" />
                                        <input type="checkbox" id="basic_checkbox_2"  class="zoho" name="invite_to_slack" value="1"/>
                                        <label for="basic_checkbox_2">Slack</label>

                                        <input type="hidden" name="invite_to_zoho" value="0" />
                                        <input type="checkbox" id="basic_checkbox_3" class="zoho" name="invite_to_zoho" value="1"/>
                                        <label for="basic_checkbox_3">zoho</label>
                                    </div>
                                </div>
                            </div>
                            <div id="asana_teams" class="">
                            </div>
                        </div>
                        <hr>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit" class="btn btn-success">Add Employee</button>
                                            <button type="button" onclick="window.location.href='{{route('employees')}}'" class="btn btn-inverse">Cancel</button>
                                        </div>
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
                    /*$('#date_of_birth').datetimepicker({
                        format: 'YYYY-MM-DD',
                    });
                    $('#exit_date').datetimepicker({
                        format: 'YYYY-MM-DD',
                    });*/

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
                                        teams.append("<div class='row'><input name='teams[]' value='" + item.id + "' type='checkbox' id='"+ item.name +"' >" +
                                            "<lable class='teams' for='"+ item.name +"'>" + item.name +"</lable></div>"
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
                /*$('#date_of_birth').datetimepicker({
                    format: 'YYYY-MM-DD',
                });*/
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
        </script>
        <script>
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
                }           }
            $("input[type='image']").click(function() {
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
    @endpush
@stop