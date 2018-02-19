@extends('layouts.admin')

@section('content')

	<div class="panel panel-default">
		<div class="panel-heading text-center">
			<div ><b style="text-align: center;" >Employees</b></div>
				@if(Auth::user()->admin)

       				<div style="padding-left: 85%;">	 <a href="{{route('employee.create')}}" class="btn btn-info btn-xs" align="right">
          					<span class="glyphicon glyphicon-plus"></span> Add Employee
      					 </a>
      				</div>	 
      			@endif		
		</div>
		<div class="panel-body">
			<table class="table">
				<thead>
					<th> Name</th>
					<th> Email</th>
					<th> Contact </th>
					<th>Invited to zoho</th>
					<th> invited to slack </th>
					<th>invited to asana</th>
				</thead>
				<tbody class="table-bordered table-hover table-striped">
					@if($employees->count() > 0)		
						@foreach($employees as $employee)
						<tr>		
							<td>{{$employee->fullname}}</td>
							<td>{{$employee->email}}</td>
							<td> {{$employee->contact}}</td>
							<td>{{$employee->inviteToZoho}}</td>
							<td>{{$employee->inviteToSlack}}</td>
							<td>{{$employee->inviteToZoho}}</td>
						</tr>
						@endforeach
					@else
					 No Applicant found.
					@endif

			</tbody>
			</table>
	</div>

@stop