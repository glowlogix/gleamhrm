@extends('layouts.profile') @section('content') 

<div class="panel panel-default">
    <div class="panel-heading text-center">
        <div>
            <b style="text-align: center;">Update Profile</b>
        </div>
    </div>
    <div class="panel-body">

        <form class="form-inline" action="{{route('employee.profile.update',['id'=>$employee->id])}}" method="post">
            {{csrf_field()}}
            <div class="form-group col-sm-4">
                <label for="fname">Firstname</label>
                <input style="width: 250px;" type="text" placeholder="Please enter firstname" name="firstname" value="{{$employee->firstname}}"
                    class="form-control">
            </div>
            <div class="form-group col-sm-4">
                <label for="lname">Lastname</label>
                <input style="width: 250px;" type="text" placeholder="Please enter lastname" name="lastname" value="{{$employee->lastname}}" class="form-control">
            </div>
            <div class="form-group col-sm-4">
                <label for="contact">Contact</label>
                @if($employee->contact)
                <input style="width: 250px;" type="text" name="contact" placeholder="Please enter contact" value="{{$employee->contact}}" class="form-control"> @else
                <input style="width: 250px;" type="text" name="contact" placeholder="Please enter contact" class="form-control"> @endif
            </div>
            <div class="form-group col-sm-4">
                <label for="contact">Emergency Contact</label>
                @if($employee->emergency_contact)
                <input style="width: 250px;" type="text" placeholder="Please enter Emergency Contact" name="emergency_contact" value="{{$employee->emergency_contact}}"
                    class="form-control"> @else
                <input style="width: 250px;" type="text" name="emergency_contact" placeholder="Please enter Emergency Contact" class="form-control"> @endif
            </div>
            <div class="form-group col-sm-4">
                <label for="contact">Emergency Contact Relationship</label>
                <input style="width: 250px;" type="text" placeholder="Please enter Emergency Relationship" name="emergency_contact_relationship"
                    value="{{$employee->emergency_contact_relationship}}" class="form-control">
            </div>
            <div class="form-group col-sm-4">
                <label for="password">Password</label>
                <input style="width: 250px;" type="password" name="password" placeholder="Enter Your New Password" value="{{$employee->password}}"
                    class="form-control">
            </div>
            
            <div class="form-group col-md-6" style="margin-top: 20px;">
                <button class="btn btn-success " type="submit"> Update</button>
                <button type="reset" class="btn btn-success "> Cancel</button>
            </div>
        </form>
    </div>
</div>

@stop