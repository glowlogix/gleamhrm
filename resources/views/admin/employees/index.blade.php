@extends('layouts.admin')

@section('content')

<div class="panel panel-default">
	<div class="panel-heading text-center">
		<span style="float: right;">
			<a href="{{route('employee.create')}}" class="btn btn-info btn-xs" align="left">
				<span class="glyphicon glyphicon-plus"></span> Add Employee
			</a>
		</span>
		<b style="text-align: center;">Employees</b>
		<span style="float: left;">
			<a href="{{route('employee.trashed')}}" class="btn btn-info btn-xs" align="right">
				<span class="glyphicon glyphicon-trash"></span> Trashed Employees
			</a>
		</span>
	</div>
</div>
<div class="panel-body">
	@if(count($employees) > 0)

	<table class="table" class="col-md-8" >
		<thead style="font-size:12px; text-align:center;">
			<th>Name</th>
			<th>Email</th>
			<th>Contact </th>
			<th>Role</th>
			<th>Invited to zoho</th>
			<th>invited to slack </th>
			<th>invited to asana </th>
			@if(Auth::user()->admin)
			<th>Manage Employees</th>
			@endif
		</thead>
		@foreach($employees as $employee)
		<tbody class="table-bordered table-hover table-striped">
			<tr>
				<td>{{$employee->fullname}}</td>
				<td>{{$employee->org_email}}</td>
				@if($employee->contact)
				<td>{{$employee->contact}}</td>
				@else
				<td>###</td>
				@endif
				<td>{{$employee->role}}</td>
				<td>
					@if($employee->inviteToZoho)
					<span class="glyphicon glyphicon-ok">
						@else
						<span class="glyphicon glyphicon-remove"></span>
						@endif
				</td>
				<td>
					@if($employee->inviteToSlack)
					<span class="glyphicon glyphicon-ok">
						@else
						<span class="glyphicon glyphicon-remove"></span>
						@endif
				</td>
				<td>
					@if($employee->inviteToAsana)
					<span class="glyphicon glyphicon-ok">
						@else
						<span class="glyphicon glyphicon-remove"></span>
						@endif
				</td>
				<td>
					<div class="col-sm-2">

						@if(Auth::user()->admin)
						<form action="{{ route('employee.destroy' , $employee->id )}}" method="post">
							{{ csrf_field() }}
							<button class="btn btn-danger btn-sm">
								<span class="glyphicon glyphicon-trash"></span>
							</button>
						</form>
					</div>
					<div class="col-sm-2 col-sm-offset-1">
						<a class="btn btn-info btn-sm" href="{{route('employee.edit',['id'=>$employee->id])}}">
							<span class="glyphicon glyphicon-edit"></span>
						</a>
					</div>
					{{--
					<div class="col-sm-2 col-sm-offset-1">
						<a class="btn btn-success btn-sm" href="{{route('attendance.show',['id'=>$employee->id])}}">
							<span class="glyphicon glyphicon-calendar"></span>
						</a>
					</div>
					<div class="col-sm-2 col-sm-offset-1">
						<a class="btn btn-success btn-sm" href="{{route('leave.show',['id'=>$employee->id])}}">
							<span class="glyphicon glyphicon-tasks"></span>
						</a>
					</div> --}} @endif
				</td>
			</tr>
		</tbody>
		@endforeach


	</table>
	@else No Employee found.. @endif

	<div class="col-md-7">
		{{$employees->links()}}
	</div>
</div>
@stop