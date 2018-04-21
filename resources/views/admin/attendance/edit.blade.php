@extends('layouts.admin') @section('title') {{ config('app.name', 'HRM') }}|{{$title}} @endsection @section('content') @include('admin.includes.errors')


<div class="panel panel-default">
    <div class="panel-heading text-center">
        <div>
            <b style="text-align: center;">Update Attendance</b>
        </div>
    </div>
    <div class="panel-body">

        <form action="{{route('attendance.update',['id'=>$attendance->id])}}" method="post">
            {{csrf_field()}}
            <div class="form-group">
                <label for="attendance_delay">Delay</label>
                <input type="text" name="attendance_delay" value="{{$attendance->delay}}" class="form-control">
            </div>
            <div class="form-group">
                <label for="checkintime">CheckInTime</label>
                <input type="text" name="checkintime" value="{{$attendance->checkintime}}" class="form-control">
            </div>
            <div class="form-group">
                <label for="checkouttime">CheckOutTime</label>
                <input type="text" name="checkouttime" value="{{$attendance->checkouttime}}" class="form-control">
            </div>
            <div class="form-group">
                <label for="hourslogged">HoursLogged</label>
                <input type="text" name="hourslogged" value="{{$attendance->checkouttime}}" class="form-control">
            </div>
            <div class="form-group">
                <button class="btn btn-success center-block" type="submit"> Update</button>
            </div>



        </form>
    </div>

    @stop