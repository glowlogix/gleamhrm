@extends('layouts.admin')
@section('title')
{{ config('app.name', 'HRM') }}|{{$title}}
@endsection
@section('content')

<div class="panel panel-default">
		<div class="panel-heading text-center">
			<div ><b style="text-align: center;" >Create Attendance</b></div>	
		</div>
		<div class="panel-body">
			<form action="{{route('employee.store')}}" method="post">
			   {{csrf_field()}}
			  <div class="form-group">
				<div class="col-md-7">
					<label for="name">Name:</label>
					@foreach($employees as $employee)
					<select class="form-control" name="employee">
					<option value={{$employee->id}}>{{$employee->fullname}}</option>
					</select>
					@endforeach
				</div>
			  </div>
			  <div class="form-group">
					<div class="col-md-7">
						<label for="leave_type">Leave Type</label>
						<input type="number" class="form-control" name="leave_type">
					</div>
			  </div>
			  <div class="form-group">
					<div class="col-md-7">
						<label for="datefrom">Date From</label>
						<input type="text" class="form-control" name="datefrom">
					</div>
			  </div>
              <div class="form-group">
					<div class="col-md-7">
						<label for="dateto">Date to</label>
						<input type="text" class="form-control" name="dateto">
					</div>
			  </div>
					
			  <div class="form-group">
					<div class="col-md-7">
						<label for="reason">Reason</label>
						<input type="text" class="form-control" name="reason">
					</div>
			  </div>
			  <div class="form-group">
					<div class="col-md-7">
						<label for="checkouttime">Status</label>
						<select name="status" class="form-control">
                            <option value="pending">Pending</option>
                            <option value="approval">Approval</option>
                            <option value="declined">Declined</option>
                        </select>
					</div>
			  </div>
			  <div class="form-group">
					<div class="col-md-5">
						<button class="btn btn-success" type="submit"> Create</button>
						
					</div>
			 </div>	

		
		</div>
		

</div>



@stop