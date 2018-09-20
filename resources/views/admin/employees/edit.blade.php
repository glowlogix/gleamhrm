@extends('layouts.admin')  @section('content')


<div class="panel panel-default">
    <div class="panel-heading text-center">
        <div>
            <b style="text-align: center;">Update Employee</b>
        </div>
    </div>
    <div class="panel-body">
        <form action="{{route('employee.update',['id'=>$employee->id])}}" method="post">
            {{csrf_field()}}
            <div class="form-group">
                <label for="firstname">Firstname</label>
                <input type="text" name="firstname" value="{{$employee->firstname}}" class="form-control">
            </div>
            <div class="form-group">
                <label for="lastname">Lastname</label>
                <input type="text" name="lastname" value="{{$employee->lastname}}" class="form-control">
            </div>
            <div class="form-group">
                <label for="lastname">Fullname</label>
                <input type="text" name="fullname" value="{{$employee->fullname}}" class="form-control">
            </div>
            <div class="form-group">
                <label for="employee">Select Role</label>
                <select name="employee_id" id="employee" class="form-control">
                    <option selected value="{{$employee->role}}">member</option>
                    <option value="admin">admin</option>
                    <option value="super_admin">super admin</option>
                </select>
            </div>
            <div class="form-group">
                <label for="employee_status">Account Status</label>
                <select name="employee_status" id="employee_status" class="form-control">
                    @if($employee->status == 1)
                    <option selected value="1">Enable Account</option>
                    <option value="0">Disable Account</option>
                    @else
                    <option value="1">Enable Account</option>
                    <option selected value="0">Disable Account</option>
                    @endif
                </select>
            </div>
            <div class="form-group">
                <label for="org_email">Organization Email</label>
                <input type="text" name="org_email" value="{{$employee->org_email}}" class="form-control">
            </div>
            <div class="form-group">
                <label for="contact">Contact</label>
                @if($employee->contact)
                <input type="text" name="contact" value="{{$employee->contact}}" class="form-control"> @else
                <input type="text" name="contact" placeholder="Please enter contact" class="form-control"> @endif
            </div>
            <div class="form-group">
                <label for="emergency_contact">Emergency Contact</label>
                @if($employee->emergency_contact)
                <input type="text" name="emergency_contact" value="{{$employee->emergency_contact}}" class="form-control"> @else
                <input type="text" name="emergency_contact" placeholder="Please enter emergency contact" class="form-control"> @endif
            </div>
            <div class="form-group">
                <label for="emergency_contact_relationship">Emergency Contact Relationship</label>
                <input type="text" value="{{$employee->emergency_contact_relationship}}" name="emergency_contact_relationship" placeholder="Please enter emergency contact relationship"
                    class="form-control">
            </div>

            <div class="form-group  col-sm-4" style="padding-left: 80px;">
                <br>
                <label>
                    <input type="hidden" name="asana" value="0" />
                    @if($employee->inviteToAsana == "1")
                    <input type="checkbox" class="asana" name="asana" value="1" checked /> Invite to Asana
                    @else
                    <input type="checkbox" class="asana" name="asana" value="1" /> Invite to Asana
                    @endif
                </label>
            </div>
            <div class="form-group  col-sm-4" style="padding-left: 80px;">
                <br>
                <label>
                    <input type="hidden" name="slack" value="0" />
                    @if($employee->inviteToSlack == "1")
                    <input type="checkbox" name="slack" value="1" checked/>
                    @else
                    <input type="checkbox" name="slack" value="1"/>
                    @endif
                    Invite to Slack
                </label>
            </div>
            <div class="form-group  col-sm-4" style="margin-bottom: 20px;padding-left: 80px;">
                <br>
                <label>
                    <input type="hidden" name="zoho" value="0" />
                    @if($employee->inviteToZoho == "1")
                    <input type="checkbox" name="zoho" id="zoho" value="1" checked="" /> Invite to Zoho
                    @else
                    <input type="checkbox" name="zoho" id="zoho" value="1" /> Invite to Zoho
                    @endif
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
    </div>
</div>
 @stop