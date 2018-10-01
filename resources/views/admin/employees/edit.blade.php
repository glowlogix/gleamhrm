@extends('layouts.admin')  @section('content')


<div class="panel panel-default">
    <div class="panel-heading text-center">
        <b style="text-align: center;">Update Employee</b>
        <span style="float: right;">
            <a href="{{route('employees')}}" class="btn btn-info btn-xs" align="right">
                <span class="glyphicon"></span> Back
            </a>
        </span>
    </div>
    <div class="panel-body">
        <form action="{{route('employee.update',['id'=>$employee->id])}}" method="post">
            {{csrf_field()}}
            <div class="form-group col-sm-4">
                <label for="firstname">First Name:</label>
                <input style="width: 250px;" type="text" class="form-control" id="firstname" placeholder="Enter First Name" name="firstname" value="{{$employee->firstname}}" required>
            </div>
            <div class="form-group col-sm-4">
                <label for="lastname">Last Name:</label>
                <input style="width: 250px;" type="text" class="form-control" id="lastname" placeholder="Enter Last Name" name="lastname" value="{{$employee->lastname}}" required>
            </div>
            <div class="form-group col-sm-4">
                <label for="personal_email">Personal Email Address:</label>
                <input style="width: 250px;" type="email" class="form-control" id="personal_email" placeholder="Enter Email Address" name="personal_email" value="{{$employee->personal_email}}" required>
            </div>
            <div class="form-group col-sm-4">
                <br>
                <label for="official_email">Official Email Address:</label>
                <input style="width: 250px;" type="email" class="form-control" id="official_email" placeholder="Enter Email Address" name="official_email" value="{{$employee->official_email}}" required>
            </div>
            <div class="form-group col-sm-4">
                <br>
                <label for="role">Role:</label>
                <select style="width: 250px;" class="form-control" name="role">
                    <option value="member" @if($employee->role == "member") selected @endif>Member</option>
                    <option value="senior_developer" @if($employee->role == "senior_developer") selected @endif>Senior Developer</option>
                </select>
            </div>
            <div class="form-group col-sm-4">
                <br>
                <label for="type">Type:</label>
                <select style="width: 250px;" class="form-control" name="type">
                    <option value="remote" @if($employee->type == "remote") selected @endif>Work Remotely</option>
                    <option value="office" @if($employee->type == "office") selected @endif>Work from Office</option>
                </select>
            </div>
             <div class="form-group col-sm-4">
                <br>
                <label for="office_location_id">Office Location:</label>
                <select style="width: 250px;" class="form-control" name="office_location_id">
                    @foreach($office_locations as $office_location)
                    <option value="{{$office_location->id}}" @if($office_location->id == $employee->office_location_id) selected @endif>{{$office_location->name}} ({{$office_location->address}})</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-sm-4">
                <br>
                <label for="text">Salary:</label>
                <input style="width: 250px;" type="text" class="form-control" id="salary" placeholder="Enter Salary" name="salary">
            </div>
            <div class="form-group col-sm-4">
                <br>
                <label for="contact_no">Contact#:</label>
                <input style="width: 250px;" type="Number" class="form-control" id="contact_no" placeholder="Enter Contact Number" name="contact_no" value="{{$employee->contact_no}}" required>
            </div>
            <div class="form-group col-sm-4">
                <br>
                <label for="emergency_contact">Emergency Contact#:</label>
                <input style="width: 250px;" type="Number" class="form-control" id="emergency_contact" placeholder="Enter Emergency Contact Number" name="emergency_contact" value="{{$employee->emergency_contact}}" required>
            </div>
            <div class="form-group col-sm-4">
                <br>
                <label for="emergency_contact_rel">Emergency Contact Relationship:</label>
                <div >
                <select style="width: 250px;" class="form-control" name="emergency_contact_relationship">
                    <option value="father" @if($employee->emergency_contact_relationship == "father") selected @endif>Father</option>
                    <option value="brother" @if($employee->emergency_contact_relationship == "brother") selected @endif>Brother</option>
                    <option value="mother" @if($employee->emergency_contact_relationship == "mother") selected @endif>Mother</option>
                </select>
                    
                </div>
            </div>
            <div class="form-group col-sm-4">
                <br>
                <label for="cnic">CNIC:</label>
                <input style="width: 250px;" type="text" class="form-control" id="cnic" placeholder="Enter Emergency Contact Relationship" name="cnic" value="{{$employee->cnic}}">
            </div>
            <div class="form-group col-sm-4">
                <br>
                <label for="date_of_birth">Date of Birth:</label>
                <input style="width: 250px;" type="text" class="form-control" id="date_of_birth" placeholder="Enter Date of Birth" name="date_of_birth" value="{{$employee->date_of_birth}}">
            </div>
            <div class="form-group col-sm-4">
                <br>
                <label for="current_address">Current Address:</label>
                <input style="width: 250px;" type="text" class="form-control" id="current_address" placeholder="Enter Current Address" name="current_address" value="{{$employee->current_address}}">
            </div>
            <div class="form-group col-sm-4">
                <br>
                <label for="permanent_address">Permanent Address:</label>
                <input style="width: 250px;" type="text" class="form-control" id="permanent_address" placeholder="Enter Permanent Address" name="permanent_address" value="{{$employee->permanent_address}}">
            </div>
            <div class="form-group col-sm-4">
                <br>
                <label for="city">City:</label>
                <input style="width: 250px;" type="text" class="form-control" id="city" placeholder="Enter City" name="city" value="{{$employee->city}}">
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

            <div class="form-group">
                <a href="{{route('employees')}}" class="btn btn-success" align="right">Back</a>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#confirm">Update</button>
            </div>

            <div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            Are you sure you want to update Employee : {{ $employee->firstname }}?
                        </div>
                        <div class="modal-body">
                            <input type="password" class="form-control" placeholder="Admin Password" name="password" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button class="btn btn-success " type="submit"> Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <script type="text/javascript">
            $(document).ready(function () {
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