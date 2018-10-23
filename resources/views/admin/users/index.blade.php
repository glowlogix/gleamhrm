@extends('layouts.admin')
@section('Heading')
	<button type="button" class="btn btn-info btn-rounded m-t-10 float-right" onclick="window.location.href='{{route('user.create')}}'"><span class="fas fa-plus"></span> Add User</button>
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