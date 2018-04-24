@extends('layouts.admin') @section('title') {{ config('app.name', 'HRM') }}|{{$title}} @endsection @section('content')
@section('styles')
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

@endsection
@section('scripts2')


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>


@endsection
<div class="panel panel-default">
	<div class="panel-heading text-center">
		<b> Trash Employees </b>
	</div>
	<div class="panel-body">

		<table class="table">
			<thead>
				<th> Firstname</th>
				<th> Lastname</th>
				<th> Role</th>
				<th> Organization Email</th>
				<th>Actions</th>
			</thead>
			<tbody class="table-bordered table-hover table-striped">
				@if($employees->count() > 0) @foreach($employees as $employee)
				<tr>
					<td>{{$employee->fname}}</td>
					<td>{{$employee->lname}}</td>
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
				@endforeach @else
				<tr> No Employee found.</tr>
				@endif

			</tbody>
		</table>
	</div>




	@stop