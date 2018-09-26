@extends('layouts.admin')
@section('content')
	<div class="panel panel-default">
		<div class="panel-heading text-center">
			<b>	Create new JobPosition <b>
		</div>
	
		<div class="panel-body">
			<form action="{{route('job_position.store')}}" method="Post">
				{{csrf_field()}}
				<div class="form-group">
					<label for="name">Name</label>
					<input type="text" name="name" placeholder="Enter Name here" class="form-control">
				</div>
				<div class="form-group">
					<label for="address">Address</label>
					<input type="text" name="address" placeholder="Enter Address here" class="form-control">
				</div>
				<div class="form-group">
					<label for="city">City</label>
					<input type="text" name="city" placeholder="Enter City here" class="form-control">
				</div>
				<div class="form-group">
					<button class="btn btn-success center-block" type="submit"> Create JobPosition</button>
				</div>
			</form>
		</div>
	</div>
@stop
