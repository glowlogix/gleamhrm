@extends('layouts.admin') @section('title') HRM|{{$title}} @endsection @section('content')

<div class="panel panel-default">
	<div class="panel-heading text-center">
		<div>
			<b style="text-align: center;">Employees</b>
		</div>
		@if(Auth::user()->admin)

		<div style="padding-left: 85%;">
			<a href="{{route('employee.create')}}" class="btn btn-info btn-xs" align="right">
				<span class="glyphicon glyphicon-plus"></span> Add Employee
			</a>
		</div>
		<br>
		<div style="padding-left: 85%;">
			<a href="{{route('employee.trashed')}}" class="btn btn-info btn-xs" align="right">
				<span class="glyphicon glyphicon-plus">

				</span>Trashed Employees
			</a>
		</div>
		@endif
	</div>
</div>
<div class="panel-body">
	<table class="table">
		<thead>
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
		<tbody class="table-bordered table-hover table-striped">
			@if(count($employees) > 0) @foreach($employees as $employee)
			<tr>
				<td>{{$employee->fullname}}</td>
				<td>{{$employee->org_email}}</td>
				@if($employee->contact)
				<td>{{$employee->contact}}</td>
				@else
				<td>###</td>
				@endif
				<td>{{$employee->role}}</td>
				<td>{{$employee->inviteToZoho}}</td>
				<td>{{$employee->inviteToSlack}}</td>
				<td>{{$employee->inviteToAsana}}</td>
				<td>
					@if(Auth::user()->admin)
					<button class="btn btn-default" data-toggle="modal" data-target="#confirm-delete{{ $employee->id }}">Delete</button>

					<div class="modal fade" id="confirm-delete{{ $employee->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					    <div class="modal-dialog">
					        <div class="modal-content">
								<form action="{{ route('employee.destroy' , $employee->id )}}" method="post">
									{{ csrf_field() }}
						            <div class="modal-header">
						                Are you sure you want to delete Employee {{ $employee->firstname }}?
						            </div>
						            <div class="modal-body">
                						<input type="password" class="form-control" placeholder="Admin Password" name="password" required>
						            </div>
						            <div class="modal-footer">
						                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						                <button  type="submit" class="btn btn-danger btn-ok">Delete</button>
						            </div>
								</form>
					        </div>
					    </div>
					</div>
					<a class="btn btn-info btn-sm" href="{{route('employee.edit',['id'=>$employee->id])}}">Edit</a>

					@endif
				</td>
			</tr>
			@endforeach @else No Applicant found. @endif

		</tbody>
	</table>
</div>

</div>

@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="{{ asset('js/bootstrap.js')}}"></script>
@endpush
@stop