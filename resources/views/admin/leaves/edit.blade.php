@extends('layouts.admin')
@section('Heading')
    <h3 class="text-themecolor">Edit Leave</h3>
@stop
@section('content')
<div class="panel panel-default">
    <div class="panel-heading text-center">
          <b style="text-align: center;">Update Leave</b>
          <span style="float: left;">
            <a href="{{route('leaves')}}" class="btn btn-info btn-xs" align="right">
                <span class="glyphicon glyphicon-plus"></span> Add Leave
            </a>
          </span>
          <span style="float: right;">
              <a href="{{route('leave.show',Auth::user()->id)}}" class="btn btn-info btn-xs" align="right">
                  <span class="glyphicon"></span> Back
              </a>
          </span>
    </div>
    <div class="panel-body">
        <form action="{{route('leave.update', ['id'=>$leave->id])}}" method="post">
           {{csrf_field()}}
          <div class="form-group">
            <div class="col-md-6">
                <label for="name">Name:</label>
                <select class="form-control" name="employee_id">
                 @foreach($employees as $employee)
                   <option  @if($leave->employee_id == $employee->id) selected @endif value={{$employee->id}}>{{$employee->firstname}} {{$employee->lastname}}</option>
                 @endforeach
                </select>
            </div>
          </div>
          <div class="form-group">
                <div class="col-md-6">
                    <label for="leave_type">Leave Type</label>
                    <select class="form-control" name="leave_type">
                        <option @if($leave->leave_type == 'unpaid_leave')selected @endif value="unpaid_leave">Unpaid Leave</option>
                        <option @if($leave->leave_type == 'half_leave')selected @endif value="half_leave">Half Leave</option>
                        <option @if($leave->leave_type == 'short_leave')selected @endif value="short_leave">Short Leave</option>                             
                        <option @if($leave->leave_type == 'paid_leave')selected @endif value="paid_leave">Paid Leave</option>
                    </select>
                </div>
          </div>
          <div class="form-group" >
                <div class="col-md-6" style="padding-top:15px;">
                    <label for="datefrom">FromDate</label>
                    <div class='input-group date' id='datefrom' name="datefrom">
                        <input type='text' class="form-control" name="datefrom" value="{{Carbon\Carbon::parse($leave->datefrom)->format('Y-m-d')}}" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
          </div>
                
          <div class="form-group" >
                <div class="col-md-6" style="padding-top:15px;">
                    <label for="dateto">ToDate</label>
                    <div class='input-group date' id='dateto' name="dateto">
                        <input type='text' class="form-control" name="dateto" value="{{Carbon\Carbon::parse($leave->dateto)->format('Y-m-d')}}"/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
          </div>
                
          <div class="form-group">
                <div class="col-md-6">
                    <label for="subject">Subject</label>
                    <input type="text" class="form-control" name="subject" value="{{$leave->subject}}">
                </div>
          </div>
          <div class="form-group">
            <div class="col-md-6">
              <label for="name">Line Manager</label>
              <select name="line_manager" class="form-control">
                @foreach ($employees as $employee)
                <option value="{{$employee->id}}" @if($employee->id == old('line_manager')) selected @endif>{{$employee->firstname}} {{$employee->lastname}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
                <div class="col-md-6">
                    <label for="description">Description</label>
                    <input type="text" class="form-control" name="description" value="{{$leave->description}}">
                </div>
          </div>
          <div class="form-group">
            <div class="col-md-6">
                <label for="point_of_contact">Back up/ Point of Contact:</label>
                <select class="form-control" name="point_of_contact">
                 @foreach($employees as $employee)
                   <option  @if($leave->employee_id == $employee->id) selected @endif value={{$employee->id}}>{{$employee->firstname}} {{$employee->lastname}}</option>
                 @endforeach
                </select>
            </div>
          </div>
          <div class="form-group">
                <div class="col-md-6">
                    <label for="cc_to">CC To</label>
                    <input type="text" class="form-control" name="cc_to" id="cc_to" value="{{$leave->cc_to}}">
                </div>
          </div>
          <div class="form-group">
            <div class="col-md-6">
              <label for="status">Status:</label>
              <select class="form-control" name="status">
                 <option value="pending" @if($leave->status == 'pending') selected @endif>Pending</option>
                 <option value="approved" @if($leave->status == 'approved') selected @endif>Approved</option>
              </select>
            </div>
            </div>
          <div class="form-group">
                <div class="col-md-8" style="padding-top:23px;">
                    <button class="btn btn-success" type="submit" style="margin-left: 360px;"> Update Leave</button>
                </div>
         </div> 
        </form>

        <script type="text/javascript">
            $(document).ready(function () {
                $(function () {
                    $('#datefrom').datetimepicker({
                        format: "YYYY-MM-DD"
                    });
                    $('#dateto').datetimepicker({
                        format: "YYYY-MM-DD"
                    });
                });
            });
        </script>
    </div>
</div>

@stop