@extends('layouts.admin')
@section('title')
{{ config('app.name', 'HRM') }}|{{$title}}
@endsection
@section('styles')
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />

@endsection
@section('scripts2')


<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>   
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

@endsection
@section('content')

<div class="panel panel-default">
		<div class="panel-heading text-center">
			<div ><b style="text-align: center;" >Create Attendance</b></div>	
		</div>
		<div class="panel-body">
			<form action="{{route('attendance.store')}}" method="post">
			   {{csrf_field()}}
			  <div class="form-group">
				<div class="col-md-7">
					<label for="name">Name:</label>
					<select class="form-control" name="employee_id">
						@foreach($employees as $employee)		
						<option value={{$employee->id}}>{{$employee->fullname}}</option>
						@endforeach
					
					</select>
				</div>
			  </div>
			  <div class="form-group">
					<div class="col-md-7">
						<label for="delay">Delay</label>
						<input type="number" value="0" class="form-control" name="delay">
					</div>
			  </div>
			  <div class="form-group">
					<div class="col-md-7">
						<label for="checkintime">CheckInTime</label>
						<div class='input-group date' id='checkindatetimepicker' name="checkindatetimepicker">
							<input type='text' class="form-control" name="checkindatetimepicker"/>
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
						</div>
					</div>
			  </div>
					
			  <div class="form-group">
				<div class="col-md-7">
					<label for="checkintime">CheckOutTime</label>
					<div class="input-group date" id="checkoutdatetimepicker" name="checkoutdatetimepicker">
						<input type='text' class="form-control" name="checkoutdatetimepicker"/>
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
				</div>
		      </div>
			  <div class="form-group">
					<div class="col-md-5">
						<button class="btn btn-success" type="submit"> Create</button>
						
					</div>
			 </div>	
		</div>
	
<script type="text/javascript">
	$(document).ready(function() {
	
		$(function () {
			$('#checkindatetimepicker').datetimepicker();
			$('#checkoutdatetimepicker').datetimepicker();

		});
	});
	</script>	
</div>


@stop