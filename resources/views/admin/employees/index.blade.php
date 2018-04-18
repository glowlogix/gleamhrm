@extends('layouts.admin')
@section('title')
HRM|All Employees
@endsection
@section('content')

	<div class="panel panel-default">
		<div class="panel-heading text-center">
			<div ><b style="text-align: center;" >Employees</b></div>
				@if(Auth::user()->admin)

       				<div style="padding-left: 85%;">	 <a href="{{route('employee.create')}}" class="btn btn-info btn-xs" align="right">
          					<span class="glyphicon glyphicon-plus"></span> Add Employee
      					 </a>
      				</div>	 
					  <br>
					  <div style="padding-left: 85%;">	 <a href="{{route('employee.trashed')}}"class="btn btn-info btn-xs" align="right">
          					<span class="glyphicon glyphicon-plus">
							  </span>Trashed Employees
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
					<th>Role</th>
					<th>Invited to zoho</th>
					<th> invited to slack </th>
					<th> invited to asana </th>
					@if(Auth::user()->admin)
					<th>Manage Employees</th>					
					@endif
				</thead>
				<tbody class="table-bordered table-hover table-striped">
					@if(count($employees) > 0) 		
						@foreach($employees as $employee)
						<tr>		
							<td>{{$employee->fullname}}</td>
							<td>{{$employee->org_email}}</td>
							@if($employee->contact)
						    <td>{{$employee->contact}}</td>
							@else
							<td>###</td>
							@endif
							<td>{{$employee->role}}</td>
							<td></td>						
							<td>{{$employee->inviteToZoho}}</td>
							<td>{{$employee->inviteToSlack}}</td>
							<td>{{$employee->inviteToAsana}}</td>	
							<td>					
							@if(Auth::user()->admin)
							<form action="{{ route('employee.destroy' , $employee->id ) }}" method="POST">
								{{ csrf_field() }}
								<button class="btn btn-danger ">Delete</button>									
							</form>
							<br>
							<a class="btn btn-info" href="{{route('employee.edit',['id'=>$employee->id])}}">Edit</a>
							
							@endif
							</td>
						</tr>
						@endforeach
					@else
					 No Applicant found.
					@endif

			</tbody>
			</table>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	
	

@stop