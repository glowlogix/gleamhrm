@extends('layouts.admin') @section('title') {{ config('app.name', 'HRM') }}|{{$title}} @endsection @section('content')

<div class="panel panel-default">
	<div class="panel-heading text-center">
		<b> Trash Employees </b>
	</div>
	<div class="panel-body">
		<table class="table">
			@if($employees->count() > 0) @foreach($employees as $employee)

			<thead>
				<th> Firstname</th>
				<th> Lastname</th>
				<th> Role</th>
				<th> Organization Email</th>
				<th>Actions</th>
			</thead>
			<tbody class="table-bordered table-hover table-striped">
				<tr>
					<td>{{$employee->firstname}}</td>
					<td>{{$employee->lastname}}</td>
					<td> {{$employee->role}}</td>
					<td>{{$employee->org_email}}</td>
					<td>
						<div class="btn-group">
							<button type="button" class="btn btn-primary">Actions</button>
							<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li>
									<a href="{{route('employee.restore',['id'=>$employee->id])}}">Restore</a>
								</li>
								<li>
									<a href="{{route ('employee.kill',['id' =>$employee->id])}}">Delete</a>
								</li>
							</ul>
						</div>
					</td>
				</tr>

			</tbody>
			@endforeach @else
			<tr> No Employee found.</tr>
			@endif

		</table>
	</div>
</div>

@stop