@extends('layouts.admin') @section('title') {{ config('app.name', 'HRM') }}|{{$title}} @endsection @section('content') @include('admin.includes.errors')


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
                    <option selected value="1">Enable Account</option>
                    <option value="0">Disable Account</option>
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
                <button class="btn btn-success center-block" type="submit"> Update</button>
            </div>



        </form>
    </div>

    @stop