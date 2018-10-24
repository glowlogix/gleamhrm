@extends('layouts.admin')
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
              <a href="{{route('leave.show')}}" class="btn btn-info btn-xs" align="right">
                  <span class="glyphicon"></span> Back
              </a>
          </span>
	</div>
	<div class="panel-body">
		<form action="{{route('leaves.store')}}" method="post">
		   {{csrf_field()}}
		  <div class="form-group">
				<div class="col-md-6">
					<label for="leave_type">Leave Type</label>
					<select class="form-control" name="leave_type">
						@foreach($leave_types as $leave_type)
						<option @if(old('leave_type') == $leave_type->id)selected @endif value="{{$leave_type->id}}">{{$leave_type->name}} ({{$leave_type->amount}})</option>
						@endforeach
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
					<label for="subject">Subject</label>
					<input type="text" class="form-control" name="subject" value="{{old('subject')}}">
				</div>
		  </div>
		  <div class="form-group">
				<div class="col-md-6">
					<label for="name">Line Manager</label>
					<input type="hidden" name="line_manager" value="{{isset($line_manager->id) ? $line_manager->id : ''}}">
					<input type="text" class="form-control" value="{{isset($line_manager->id) ? $line_manager->firstname.'  '. $line_manager->lastname : ''}}" disabled>
				</div>
		  </div>
		  <div class="form-group">
				<div class="col-md-6">
					<label for="description">Description</label>
					<input type="text" class="form-control" name="description" value="{{old('description')}}">
				</div>
		  </div>
		  <div class="form-group">
			<div class="col-md-6">
				<label for="point_of_contact">Back up/ Point of Contact:</label>
				<select class="form-control" name="point_of_contact">
				 @foreach($employees as $employee)
				   <option  @if(old('employee_id') == $employee->id) selected @endif value={{$employee->id}}>{{$employee->firstname}} {{$employee->lastname}}</option>
				 @endforeach
				</select>
			</div>
		  </div>
		  <div class="form-group">
				<div class="col-md-6">
					<label for="cc_to">CC To</label>
					<input type="email"  multiple="multiple" class="form-control" name="cc_to" id="cc_to" value="{{old('cc_to')}}">
				</div>
		  </div>
		  <div class="form-group">
			<div class="col-md-6">
				<label for="status">Status:</label>
				<select class="form-control" name="status">
				   <option value="pending" @if(old('status') == 'pending') selected @endif>Pending</option>
				   <option value="approved" @if(old('status') == 'approved') selected @endif>Approved</option>
				</select>
			</div>
		  </div>
		  <div class="form-group">
				<div class="col-md-8" style="padding-top:23px;">
					<button class="btn btn-success" type="submit" style="margin-left: 360px;"> Apply Leave</button>
				</div>
		 </div>	
		</form>
	</div>

	<script type="text/javascript">
		$(document).ready(function() {
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
@stop