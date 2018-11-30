@extends('layouts.admin')
@section('Heading')
	<h3 class="text-themecolor">Leaves</h3>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
		<li class="breadcrumb-item active">Attendance</li>
		<li class="breadcrumb-item active">Leaves</li>
	</ol>
@stop
@section('content')
<div class="panel panel-default">
	<div class="panel-heading text-center">
		<b style="text-align: center;">Create Leave</b>
        <span style="float: left;">
            <a href="{{route('attendance.create')}}" class="btn btn-info btn-xs" align="right">
                <span class="glyphicon glyphicon-plus"></span> Add Attendance
            </a>
        </span>
        <span style="float: right;">
            <a href="{{route('attendance')}}" class="btn btn-info btn-xs" align="right">
                <span class="glyphicon"></span> Back
            </a>
        </span>
	</div>
	<div class="panel-body">
		<form action="{{route('leaves.store')}}" method="post">
		   {{csrf_field()}}
		  <div class="form-group">
			<div class="col-md-6">
				<label for="name">Name:</label>
				<select class="form-control" name="employee_id">
				 @foreach($employees as $employee)
				   <option  @if(old('employee_id') == $employee->id) selected @endif value={{$employee->id}}>{{$employee->firstname}} {{$employee->lastname}}</option>
				 @endforeach
				</select>
			</div>
		  </div>
		  <div class="form-group">
				<div class="col-md-6">
					<label for="leave_type">Leave Type</label>
					<select class="form-control" name="leave_type">
						<option @if(old('leave_type') == 'unpaid_leave')selected @endif value="unpaid_leave">Unpaid Leave</option>
						<option @if(old('leave_type') == 'half_leave')selected @endif value="half_leave">Half Leave</option>
						<option @if(old('leave_type') == 'short_leave')selected @endif value="short_leave">Short Leave</option>								
						<option @if(old('leave_type') == 'paid_leave')selected @endif value="paid_leave">Paid Leave</option>
					</select>
				</div>
		  </div>
		  <div class="form-group" >
				<div class="col-md-6" style="padding-top:15px;">
					<label for="datefrom">FromDate</label>
					<div class='input-group date' id='datefrom' name="datefrom">
						<input type='text' class="form-control" name="datefrom" value="{{old('datefrom')}}" />
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
						<input type='text' class="form-control" name="dateto" value="{{old('dateto')}}"/>
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
				</div>
		  </div>
				
		  <div class="form-group">
				<div class="col-md-6">
					<label for="reason">Reason</label>
					<input type="text" class="form-control" name="reason" value="{{old('reason')}}">
				</div>
		  </div>
		  <div class="form-group">
				<div class="col-md-6">
					<label for="checkouttime">Status</label>
					<select name="status" class="form-control">
				        <option @if(old('status') == 'Pending') selected @endif value="Pending">Pending</option>
                        <option @if(old('status') == 'Approval') selected @endif value="Approval">Approval</option>
                        <option @if(old('status') == 'Declined') selected @endif value="Declined">Declined</option>
                    </select>
				</div>
		  </div>
		  <div class="form-group">
				<div class="col-md-8" style="padding-top:23px;">
					<button class="btn btn-success" type="submit" style="margin-left: 360px;"> Create</button>
				</div>
		 </div>	
		</form>
	</div>

	<script type="text/javascript">
		$(document).ready(function() {
			$(function () {
				$('#datefrom').datetimepicker({
					format: 'L'
				});
				$('#dateto').datetimepicker({
					format: 'L'
				});
	
			});
		});
	</script>	
</div>
@stop