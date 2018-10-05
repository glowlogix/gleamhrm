@extends('layouts.admin') @section('content')

@if (Session::has('error'))
<div class="alert alert-warning" align="left">
    <a href="#" class="close" data-dismiss="alert">&times;</a>
    <strong>!</strong> {{Session::get('error')}}
</div>
@endif

<div class="panel panel-default">
    <div class="panel-heading text-center">
        <b>Create new employee</b>
        <span style="float: right;">
            <a href="{{route('employees')}}" class="btn btn-info btn-xs" align="right">
                <span class="glyphicon"></span> Back
            </a>
        </span>
    </div>
    <div class="panel-body">
        <form class="form-inline" action="{{route('employee.store')}}" method="post">
            {{csrf_field()}}
            <div class="form-group col-sm-4">
                <label for="firstname">First Name:</label>
                <input style="width: 250px;" type="text" class="form-control" id="firstname" placeholder="Enter First Name" name="firstname" value="{{ old('firstname') }}" required>
            </div>
            <div class="form-group col-sm-4">
                <label for="lastname">Last Name:</label>
                <input style="width: 250px;" type="text" class="form-control" id="lastname" placeholder="Enter Last Name" name="lastname" value="{{ old('lastname') }}" required>
            </div>
            <div class="form-group col-sm-4">
                <label for="personal_email">Personal Email Address:</label>
                <input style="width: 250px;" type="email" class="form-control" id="personal_email" placeholder="Enter Email Address" name="personal_email" value="{{ old('personal_email') }}" required>
            </div>
            <div class="form-group col-sm-4">
                <br>
                <label for="official_email">Official Email Address:</label>
                <input style="width: 250px;" type="email" class="form-control" id="official_email" placeholder="Enter Email Address" name="official_email" value="{{ old('official_email') }}" required>
            </div>
            <div class="form-group col-sm-4">
                <br>
                <label for="role">Designation:</label>

                <select style="width: 250px;" class="form-control" name="role">
                @foreach($roles as $k => $role)
                    <option value="{{$k}}" @if(old("role") == "$k") selected @endif>{{$role}}</option>
                @endforeach
                </select>
            </div>
            <div class="form-group col-sm-4">
                <br>
                <label for="type">Type:</label>
                <select style="width: 250px;" class="form-control" name="type">
                    <option value="office" @if(old('type') == "office") selected @endif>Work from Office</option>
                    <option value="remote" @if(old("type") == "remote") selected @endif>Work Remotely</option>
                </select>
            </div>
            <div class="form-group col-sm-4">
                <br>
                <label for="office_location_id">Office Location:</label>
                <select style="width: 250px;" class="form-control" name="office_location_id">
                    @foreach($office_locations as $office_location)
                    <option value="{{$office_location->id}}" @if(old("office_location_id") == "remote") selected @endif>{{$office_location->name}} ({{$office_location->address}})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-4">
                <br>
                <label for="text">Salary:</label>
                <input style="width: 250px;" type="text" class="form-control" id="salary" placeholder="Enter Salary" name="salary" value="{{ old('salary') }}" >
            </div>
            <div class="form-group col-sm-4">
                <br>
                <label for="contact_no">Contact#:</label>
                <input style="width: 250px;" type="Number" class="form-control" id="contact_no" placeholder="Enter Contact Number" name="contact_no" value="{{ old('contact_no') }}" required>
            </div>
            <div class="form-group col-sm-4">
                <br>
                <label for="emergency_contact">Emergency Contact#:</label>
                <input style="width: 250px;" type="Number" class="form-control" id="emergency_contact" placeholder="Enter Emergency Contact Number" name="emergency_contact" value="{{ old('emergency_contact') }}" required>
            </div>
            <div class="form-group col-sm-4">
                <br>
                <label for="emergency_contact_rel">Emergency Contact Relationship:</label>
                <select style="width: 250px;" class="form-control" name="emergency_contact_relationship">
                    <option value="father" @if(old("emergency_contact_relationship") == "father") selected @endif>Father</option>
                    <option value="brother" @if(old('emergency_contact_relationship') == "brother") selected @endif>Brother</option>
                    <option value="mother" @if(old('emergency_contact_relationship') == "mother") selected @endif>Mother</option>
                </select>
            </div>
            <div class="form-group col-sm-4">
                <br>
                <label for="cnic">CNIC:</label>
                <input style="width: 250px;" type="text" class="form-control" id="cnic" placeholder="Enter Emergency Contact Relationship" name="cnic" value="{{ old('cnic') }}" required>
            </div>
            <div class="form-group col-sm-4">
                <br>
                <label for="date_of_birth">Date of Birth:</label>
                <input style="width: 250px;" type="text" class="form-control" id="date_of_birth" placeholder="1988-12-23" name="date_of_birth" value="{{Carbon\Carbon::now()->subYears(20)->format('Y-m-d') }}" required>
            </div>            <div class="form-group col-sm-4">
                <br>
                <label for="current_address">Current Address:</label>
                <input style="width: 250px;" type="text" class="form-control" id="current_address" placeholder="Enter Current Address" name="current_address" value="{{ old('current_address') }}" required>
            </div>
            <div class="form-group col-sm-4">
                <br>
                <label for="permanent_address">Permanent Address:</label>
                <input style="width: 250px;" type="text" class="form-control" id="permanent_address" placeholder="Enter Permanent Address" name="permanent_address" value="{{ old('permanent_address') }}" required>
            </div>
            <div class="form-group col-sm-4">
                <br>
                <label for="city">City:</label>
                <input style="width: 250px;" type="text" class="form-control" id="city" placeholder="Enter City" name="city" value="{{ old('city') }}" required>
            </div>

            <div class="row">
            <div class="form-group  col-sm-4">
                <br>
                <label>
                    <input type="hidden" name="invite_to_asana" value="0" />
                    <input type="checkbox" class="asana" name="invite_to_asana" value="1" /> Invite to Asana
                </label>
            </div>
            <div class="form-group  col-sm-4">
                <br>
                <label>
                    <input type="hidden" name="invite_to_slack" value="0" />
                    <input type="checkbox" name="invite_to_slack" value="1" /> Invite to Slack
                </label>
            </div>
            <div class="form-group  col-sm-4">
                <br>
                <label>
                    <input type="hidden" name="invite_to_zoho" value="0" />
                    <input type="checkbox" name="invite_to_zoho" id="invite_to_zoho" value="1" /> Invite to Zoho
                </label>
            </div>

            <div style="margin-bottom: 19px;">
                <br>
                <button type="submit" id="sub" class="btn  btn-primary center-block">Add Employee</button>
                <div class="col-md-5">
                    <ul id="asana_teams">
                    </ul>
                </div>
            </div>
        </form>
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
    </div>
</div>

@stop