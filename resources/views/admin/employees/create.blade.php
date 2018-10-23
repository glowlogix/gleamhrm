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
                                        <label class="control-label text-right col-md-3">officia Email</label>
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
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Salary</label>
                                        <div class="col-md-9">
                                            <input type="text" name="salary" value="{{ old('salary') }}"  class="form-control " placeholder="Enter Salary" required>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            {{--//////Picture/////--}}
                            <div class="row">
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Picture Upload</label>
                                        <div class="col-md-9">
                                            <input type="file" class="form-control" id="exampleInputFile" name="picture" >
                                        </div>
                                    </div>
                                </div>
                                {{--<div class="col-md-6">--}}
                                    {{--<div class="form-group row">--}}
                                        {{--<label class="control-label text-right col-md-3">Exit Date</label>--}}
                                        {{--<div class="col-md-9">--}}
                                            {{--<input type="date" class="form-control" id="exit_date" placeholder="Enter Exit Date" name="exit_date" value="{{old('exit_date')}}" required>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                <!--/span-->
                            </div>
                            {{--//////End Picture/////--}}
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
                                        <label class="control-label text-right col-md-3">Emergency Contact</label>
                                        <div class="col-md-9">
                                            <input type="text"  class="form-control " placeholder="Enter Emergency Contact#" name="emergency_contact" value="{{ old('emergency_contact') }}" required>
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
                                        <label class="control-label text-right col-md-3">CNIC#</label>
                                        <div class="col-md-9">
                                            <input type="text"  class="form-control " placeholder="Enter CNIC#" name="cnic" value="{{ old('cnic') }}" pattern="[0-9]{13}">
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
                                            <input type="text"  class="form-control " id="date_of_birth" placeholder="1988-12-23" name="date_of_birth"  value="{{Carbon\Carbon::now()->subYears(20)->format('Y-m-d') }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Current Address</label>
                                        <div class="col-md-9">
                                            <input type="text"  class="form-control " placeholder="Enter Current Address" name="current_address" value="{{ old('current_address') }}" required>
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
                                        <input type="text"  class="form-control "  placeholder="Enter Permanent Address" name="permanent_address" value="{{ old('permanent_address') }}" required>
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
                        <div class="col-md-8">
                            <div class="form-group row">
                                <div class="card-body">
                                    <div class="demo-checkbox">
                           &nbsp;&nbsp; <input type="hidden" name="invite_to_asana" value="0" />
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
    <script type="text/javascript">
        $(document).ready(function () {
            $(".nameselect2").select2();
            $(function () {
                $('#date_of_birth').datetimepicker({
                    format: 'YYYY-MM-DD',
                });
                $('#exit_date').datetimepicker({
                    format: 'YYYY-MM-DD',
                });

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
                                    teams.append("<li class='teams'>" + item.name +
                                        " <input name='teams[]' value='" +
                                        item.id + "' type='checkbox'></li>"
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

        $(".nameselect2").select2();
        $(function () {
            $('#date_of_birth').datetimepicker({
                format: 'YYYY-MM-DD',
            });

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
@stop