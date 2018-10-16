@extends('layouts.admin')
@section('Heading')
    <h3 class="text-themecolor">Edit Employee</h3>
@stop
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div style="margin-top:10px; margin-right: 10px;">
                <button type="button" onclick="window.location.href='{{route('employees')}}'" class="btn btn-info float-right">Back</button>
            </div>
            <div class="card-body">
                <form action="{{route('employee.update',['id'=>$employee->id])}}" method="post" class="form-horizontal">
                    {{csrf_field()}}
                    <div class="form-body">
                        <h3 class="box-title">Employee Information</h3>
                        <hr class="m-t-0 m-b-40">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">First Name</label>
                                    <div class="col-md-9">
                                        <input type="text"  name="firstname" value="{{$employee->firstname}}" class="form-control" placeholder="Enter First Name" required>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Last Name</label>
                                    <div class="col-md-9">
                                        <input type="text" name="lastname" value="{{$employee->lastname}}" class="form-control " placeholder="Enter Last Name" required>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Personal Email</label>
                                    <div class="col-md-9">
                                        <input type="email" name="personal_email" value="{{$employee->personal_email}}"  class="form-control " placeholder="Enter Personal Email" required>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">officia Email</label>
                                    <div class="col-md-9">
                                        <input type="email" name="official_email" value="{{$employee->official_email}}" class="form-control " placeholder="Enter Official Email" required>
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
                                        <select class="form-control custom-select" name="role">
                                            @foreach($roles as $k => $role)
                                                <option value="{{$k}}" @if($employee->role == $k) selected @endif>{{$role}}</option>
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
                        </div>
                        <!--/row-->

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Office Location</label>
                                    <div class="col-md-9">
                                        <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" name="office_location_id">
                                            @foreach($office_locations as $office_location)
                                                <option value="{{$office_location->id}}" @if($office_location->id == $employee->office_location_id) selected @endif>{{$office_location->name}} ({{$office_location->address}})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Salary</label>
                                    <div class="col-md-9">
                                        <input type="text" name="salary" value="{{$employee->basic_salary}}"  class="form-control " placeholder="Enter Salary" required>
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
                                        <input type="text"  class="form-control" placeholder="Enter Contac#" name="contact_no" value="{{$employee->contact_no}}" pattern="[0-9]{11}" required>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Emergency Contact</label>
                                    <div class="col-md-9">
                                        <input type="text"  class="form-control " placeholder="Enter Emergency Contact#" name="emergency_contact" value="{{$employee->emergency_contact}}" required>
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
                                            <option value="father" @if($employee->emergency_contact_relationship == "father") selected @endif>Father</option>
                                            <option value="brother" @if($employee->emergency_contact_relationship == "brother") selected @endif>Brother</option>
                                            <option value="mother" @if($employee->emergency_contact_relationship == "mother") selected @endif>Mother</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">CNIC#</label>
                                    <div class="col-md-9">
                                        <input type="text"  class="form-control " placeholder="Enter CNIC#" name="cnic" value="{{$employee->cnic}}" pattern="[0-9]{13}">
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
                                        <input type="text"  class="form-control " id="date_of_birth" placeholder="1988-12-23" name="date_of_birth"  value="{{$employee->date_of_birth}}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Current Address</label>
                                    <div class="col-md-9">
                                        <input type="text"  class="form-control " placeholder="Enter Current Address" name="current_address" value="{{$employee->current_address}}" required>
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
                                    <input type="text"  class="form-control "  placeholder="Enter Permanent Address" name="permanent_address" value="{{$employee->permanent_address}}" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">City</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control " placeholder="Enter City" name="city" value="{{$employee->city}}" required>
                                </div>
                            </div>
                        </div>
                        <!--/span-->


                    </div>

                    <div class="col-md-6">
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
                    </div>
                    <hr>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn btn-success"  data-toggle="modal" data-target="#confirm">Update Employee</button>
                                        <button type="button" onclick="window.location.href='{{route('employees')}}'" class="btn btn-inverse">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    Are you sure you want to update Employee : {{ $employee->firstname }}?
                                </div>
                                <div class="modal-body">
                                    <input type="password" id="confirm_pass" class="form-control" placeholder="Admin Password" name="password" required>
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
<script type="text/javascript">

    $(document).ready(function () {

        var teams = $('#asana_teams');
        var count = 0;
        var orgId = '{{config('values.asanaWorkspaceId')}}';
        var token = '{{config('values.asanaToken')}}';

        $('#zoho').bind('click', function () {
            if ($(this).is(':checked')) {
                alert("No data added in zoho, because of API problem.")
                this.checked= null;
            }
        });

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
        });

        $(".nameselect2").select2();
        $(function () {
            $('#date_of_birth').datetimepicker({
                format: 'YYYY-MM-DD',
            });
        });

    });
</script>
<!-- Row -->
 @stop