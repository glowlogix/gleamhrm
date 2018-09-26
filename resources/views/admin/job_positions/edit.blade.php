@extends('layouts.admin')
@section('content')
	
	<div class="panel panel-default">
		<div class="panel-heading text-center">
			<b>	Update JobPosition <b>
		</div>
	
		<div class="panel-body">
			<form action="{{route('job_position.update',['id'=>$job_position->id])}}" method="Post">
				{{csrf_field()}}
				<div class="form-group">
					<label for="name" value="{{$job_position->name}}" >Name</label>
					<input type="text" name="name" value="{{$job_position->name}}" class="form-control">
				</div>
				<div class="form-group">
					<label for="name" value="{{$job_position->name}}" >Address</label>
					<input type="text" name="address" value="{{$job_position->address}}" class="form-control">
				</div>
				<div class="form-group">
					<label for="name" value="{{$job_position->name}}" >City</label>
					<input type="text" name="city" value="{{$job_position->city}}" class="form-control">
				</div>
				<div class="form-group">
					<button class="btn btn-success center-block" type="submit"> Update JobPosition</button>
				</div>
			</form>
		</div>
	</div>

@stop
