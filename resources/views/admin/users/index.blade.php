@extends('layouts.admin')
@section('Heading')
	<h3 class="text-themecolor">Users</h3>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
		<li class="breadcrumb-item active">Users</li>
	</ol>
@stop
@section('content')
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<button type="button" class="btn btn-info btn-rounded m-t-10 float-right" onclick="window.location.href='{{route('user.create')}}'">Add User</button>
				<div class="table">
					<table class="table">
						<thead>
						<tr>
							<th> Name</th>
							<th> Permissions </th>
							@if(Auth::user()->admin)
							@endif
							<th> Manage User </th>
						</tr>
						</thead>
						@if($users->count() > 0) @foreach($users as $user)
						<tbody>
						<td>{{$user->name}}</td>
						<td>
							@if(Auth::user()->admin)
								@if($user->admin)
								<a href="{{ route('user.not_admin',['id' => $user->id])}}" class="btn btn-danger">Remove Permissions</a>
							@else
								<a href="{{ route('user.admin',['id' => $user->id])}}" class="btn btn-success">Make admin</a>
							@endif @else {{$user->admin}} @endif
						</td>
						<td class="row">
								<div class="col-sm-1">
									<form action="{{route('user.edit',['id'=>$user->id])}}">
										<button class="btn btn-info btn-sm">
											<span class="fas fa-pencil-alt"></span>
										</button>
									</form>
								</div>
							@if(Auth::user()->admin)
								<div class="col-sm-1">
									<form action="{{ route('user.delete' , $user->id )}}" method="post">
										{{ csrf_field() }}
										<button class="btn btn-danger btn-sm">
											<span class="fas fa-window-close"></span>
										</button>
									</form>
								</div>
							@else Edit/delete @endif
						</td>

						@endforeach
						@else
							<tr>
								<th colspan="5" class="text-center">No User found.</th>
							</tr>
							@endif

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	@stop





{{--<div class="panel panel-default">--}}
	{{--<div class="panel-heading text-center">--}}
		{{--@if(Auth::user()->admin)--}}
		{{--<span style="float: right;">--}}
			{{--<a href="{{route('user.create')}}" class="btn btn-info btn-xs" align="left">--}}
				{{--<span class="glyphicon glyphicon-plus"></span> Add User--}}
			{{--</a>--}}
		{{--</span>--}}
		{{--<b style="text-align: center;">Users</b>--}}
		{{--@endif--}}
	{{--</div>--}}
	{{--<div class="panel-body">--}}
			{{----}}
		{{--<table class="table">--}}
			{{--<thead  style="text-align: center;">--}}
				{{--<th> Name</th>--}}
				{{--<th> Permissions </th>--}}
				{{--@if(Auth::user()->admin)--}}
				{{--@endif--}}
				{{--<th> Manage User </th>--}}
			{{--</thead>--}}
			{{--@if($users->count() > 0) @foreach($users as $user)--}}
			{{----}}
			{{--<tbody class="table-bordered table-hover table-striped">--}}

				{{--<tr>--}}
					{{--<td>--}}
						{{--{{$user->name}}--}}
					{{--</td>--}}
					{{--<td>--}}
						{{--@if(Auth::user()->admin) @if($user->admin)--}}
						{{--<a href="{{ route('user.not_admin',['id' => $user->id])}}" class="btn btn-xs btn-danger">Remove Permissions</a>--}}
						{{--@else--}}
						{{--<a href="{{ route('user.admin',['id' => $user->id])}}" class="btn btn-xs btn-success">Make admin</a>--}}
						{{--@endif @else {{$user->admin}} @endif--}}
					{{--</td>--}}
					{{--<td>--}}
						{{--@if(Auth::user()->admin)--}}
						{{--<div class="col-md-2">--}}
						{{--<form action="{{ route('user.delete' , $user->id )}}" method="post">--}}
							{{--{{ csrf_field() }}--}}
							{{--<button class="btn btn-danger btn-sm">--}}
								{{--<span class="glyphicon glyphicon-trash"></span>--}}
							{{--</button>--}}
						{{--</form>--}}
					    {{--</div>--}}
						{{--<div class="col-md-2">--}}
							{{--<a class="btn btn-info btn-sm" href="{{route('user.edit',['id'=>$user->id])}}">--}}
								{{--<span class="glyphicon glyphicon-edit"></span>--}}
							{{--</a>--}}
						{{--</div>--}}
						{{--@else Edit/delete @endif--}}
					{{--</td>--}}
				{{--</tr>--}}

				{{--@endforeach--}}
			{{--</tbody>--}}
			{{--@else--}}
			{{--<tr>--}}
				{{--<th colspan="5" class="text-center">No User found.</th>--}}
			{{--</tr>--}}
			{{--@endif--}}
		{{--</table>--}}
		{{----}}
	{{--</div>--}}
{{--</div>--}}


{{--@stop--}}
