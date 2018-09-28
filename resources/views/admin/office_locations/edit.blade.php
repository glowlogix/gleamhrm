@extends('layouts.admin') @section('content')

<div class="panel panel-default">
	<div class="panel-heading text-center">
		<b> Update Office Location</b>
		<span style="float: right;">
            <a href="{{route('offices')}}" class="btn btn-info btn-xs" align="right">
                <span class="glyphicon"></span> Back
            </a>
        </span>
	</div>
	<div class="panel-body">

		<form action="{{route('office_location.update',['id'=>$office_location->id])}}" method="post" enctype="multipart/form-data">
			{{csrf_field()}}
			<div class="form-group">
				<label for="name">Name</label>
				<input type="text" name="name" placeholder="Enter name here" class="form-control" value="{{$office_location->name}}">
			</div>
			<div class="form-group">
				<label for="status">Status</label>
				<input type="text" name="status" class="form-control" placeholder="Enter Status here" value="{{$office_location->status}}">
			</div>
			<div class="form-group">
				<label for="timing_start">Timing Start</label>
				<input type="text" name="timing_start" class="form-control" placeholder="Enter Timing Start here" value="{{Carbon\Carbon::parse($office_location->timing_start)->format('h:i a')}}">
			</div>
			<div class="form-group">
				<label for="timing_off">Timing Off</label>
				<input type="text" name="timing_off" class="form-control" placeholder="Enter Timing Off here" value="{{Carbon\Carbon::parse($office_location->timing_off)->format('h:i a')}}">
			</div>
			<div class="form-group">
				<label for="address">Address</label>
				<input type="text" name="address" class="form-control" placeholder="Enter Address here" value="{{$office_location->address}}">
			</div>
			<div class="form-group">
				<label for="phone_number">Phone Number</label>
				<input type="number" name="phone_number" class="form-control" placeholder="Enter Phone Number here" value="{{$office_location->phone_number}}">
			</div>	
			<div class="form-group">
				<button class="btn btn-success center-block" type="submit"> Update</button>
			</div>
			
		</form>
	</div>
</div>
@stop
