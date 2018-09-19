@extends('layouts.admin') @section('content')

<div class="panel panel-default">
	<div class="panel-heading text-center">
		@if(Auth::user()->admin)
		<span style="float: right;">
			<a href="{{route('user.create')}}" class="btn btn-info btn-xs" align="left">
				<span class="glyphicon glyphicon-plus"></span> Add User
			</a>
		</span>
		<b style="text-align: center;">Users</b>
		@endif
	</div>
	<div class="panel-body">
			
		<table class="table">
			<thead  style="text-align: center;">
				<th> Name</th>
				<th> Permissions </th>
				@if(Auth::user()->admin)
				@endif
				<th> Manage User </th>
			</thead>
			@if($users->count() > 0) @foreach($users as $user)
			
			<tbody class="table-bordered table-hover table-striped">

				<tr>
					<td>
						{{$user->name}}
					</td>
					<td>
						@if(Auth::user()->admin) @if($user->admin)
						<a href="{{ route('user.not_admin',['id' => $user->id])}}" class="btn btn-xs btn-danger">Remove Permissions</a>
						@else
						<a href="{{ route('user.admin',['id' => $user->id])}}" class="btn btn-xs btn-success">Make admin</a>
						@endif @else {{$user->admin}} @endif
					</td>
					<td>
						@if(Auth::user()->admin)
						<div class="col-md-2">
						<form action="{{ route('user.delete' , $user->id )}}" method="post">
							{{ csrf_field() }}
							<button class="btn btn-danger btn-sm">
								<span class="glyphicon glyphicon-trash"></span>
							</button>
						</form>
					    </div>
						<div class="col-md-2">
							<a class="btn btn-info btn-sm" href="{{route('user.edit',['id'=>$user->id])}}">
								<span class="glyphicon glyphicon-edit"></span>
							</a>
						</div>
						@else Edit/delete @endif
					</td>
				</tr>

				@endforeach
			</tbody>
			@else
			<tr>
				<th colspan="5" class="text-center">No User found.</th>
			</tr>
			@endif
		</table>
		
	</div>
</div>


@stop
