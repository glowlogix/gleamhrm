@extends('layouts.admin')
@section('Heading')
	<h3 class="text-themecolor">Trashed Employees</h3>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
		<li class="breadcrumb-item active">Employees</li>
		<li class="breadcrumb-item active">Trashed</li>
	</ol>
@stop
@section('content')
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h6 class="card-subtitle"></h6>
				<button type="button"  onclick="window.location.href='{{route('employees')}}'" class="btn btn-info btn-rounded m-t-10 float-right">Back</button>
				<div class="table">
					<table id="demo-foo-addrow" class="table  table-hover contact-list" data-paging="true" data-paging-size="7">
						<thead>
						<tr>
							<th> Firstname</th>
							<th> Lastname</th>
							<th> Role</th>
							<th> Organization Email</th>
							<th>Actions</th>
						</tr>
						</thead>
						<tbody>
						@if($employees->count() > 0) @foreach($employees as $employee)
							<tr>

								<td>{{$employee->firstname}}</td>
								<td>{{$employee->lastname}}</td>
								<td> {{$employee->role}}</td>
								<td>{{$employee->org_email}}</td>
								<td class="text-nowrap">
									<a class="btn btn-info btn-sm" href="{{route('employee.restore',['id'=>$employee->id])}}" data-toggle="tooltip" data-original-title="Restore"> <i class="text-white">Restore</i></a>
									<a class="btn btn-danger btn-sm" href="{{route ('employee.kill',['id' =>$employee->id])}}" data-toggle="tooltip" data-original-title="Close"> <i class="text-white">Delete</i> </a>
								</td>

							</tr>
						@endforeach @else
							<tr> No job found.</tr>
						@endif

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

@stop



{{--<div class="panel panel-default">--}}
	{{--<div class="panel-heading text-center">--}}
		{{--<b> Trash Employees </b>--}}
		{{--<span style="float: right;">--}}
            {{--<a href="{{route('employees')}}" class="btn btn-info btn-xs" align="right">--}}
                {{--<span class="glyphicon"></span> Back--}}
            {{--</a>--}}
        {{--</span>--}}
	{{--</div>--}}
	{{--<div class="panel-body">--}}
		{{--<table class="table">--}}
			{{--@if($employees->count() > 0) @foreach($employees as $employee)--}}

			{{--<thead>--}}
				{{--<th> Firstname</th>--}}
				{{--<th> Lastname</th>--}}
				{{--<th> Role</th>--}}
				{{--<th> Organization Email</th>--}}
				{{--<th>Actions</th>--}}
			{{--</thead>--}}
			{{--<tbody class="table-bordered table-hover table-striped">--}}
				{{--<tr>--}}
					{{--<td>{{$employee->firstname}}</td>--}}
					{{--<td>{{$employee->lastname}}</td>--}}
					{{--<td> {{$employee->role}}</td>--}}
					{{--<td>{{$employee->org_email}}</td>--}}
					{{--<td>--}}
						{{--<div class="btn-group">--}}
							{{--<button type="button" class="btn btn-primary">Actions</button>--}}
							{{--<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">--}}
								{{--<span class="caret"></span>--}}
							{{--</button>--}}
							{{--<ul class="dropdown-menu" role="menu">--}}
								{{--<li>--}}
									{{--<a href="{{route('employee.restore',['id'=>$employee->id])}}">Restore</a>--}}
								{{--</li>--}}
								{{--<li>--}}
									{{--<a href="{{route ('employee.kill',['id' =>$employee->id])}}">Delete</a>--}}
								{{--</li>--}}
							{{--</ul>--}}
						{{--</div>--}}
					{{--</td>--}}
				{{--</tr>--}}

			{{--</tbody>--}}
			{{--@endforeach @else--}}
			{{--<tr> No Employee found.</tr>--}}
			{{--@endif--}}

		{{--</table>--}}
	{{--</div>--}}
{{--</div>--}}

