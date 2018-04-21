@extends('layouts.admin') @section('title') {{ config('app.name', 'HRM') }}|{{$title}} @endsection @section('content') @include('admin.includes.errors')


<div class="panel panel-default">
    <div class="panel-heading text-center">
        <div>
            <b style="text-align: center;">Update Leave</b>
        </div>
    </div>
    <div class="panel-body">

        <form action="{{route('leave.update',['id'=>$leave->id])}}" method="post">
            {{csrf_field()}}
            <div class="form-group">
                   <label for="leave_type">Leave Type</label>
                   <input type="text" name="leave_type" value="{{$leave->leave_type}}" class="form-control">
                   
            </div>
            <div class="form-group">
                <label for="datefrom">Date From</label>
                <input type="text" name="datefrom" value="{{$leave->datefrom}}" class="form-control">
            </div>
            <div class="form-group">
                <label for="dateto">Date To </label>
                <input type="text" name="dateto" value="{{$leave->dateto}}" class="form-control">
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control">
                        <option value="pending">Pending</option>
                        <option value="approval">Approval</option>
                        <option value="declined">Declined</option>
                </select>
            </div>
            <div class="form-group">
                    <label for="reason">REason</label>
                    <input type="text" name="reason" value="{{$leave->reason}}" class="form-control">
                </div>
            <div class="form-group">
                <button class="btn btn-success center-block" type="submit"> Update</button>
            </div>



        </form>
    </div>

    @stop