@extends('layouts.admin')
@section('content')

<div class="panel panel-default">
	<div class="panel-heading text-center">
		<b>All users</b> <a class="btn pull-right" href="{{route('user.create')}}">Create new User</a>
	</div>
	<div class="panel-body">
		<table class="table">
			<thead>
				<th> Name</th>
				<th> Permissions  </th>
				<th> Delete </th>
			</thead>
			<tbody class="table-bordered table-hover table-striped">

			@if($users->count() > 0)
					@foreach($users as $user)
				<tr>
					<td>
					 	{{$user->name}}	
					</td>
					<td>
						@if(Auth::user()->admin)
						 	@if($user->admin)
						 		<a href="{{ route('user.not_admin',['id' => $user->id])}}" class="btn btn-xs btn-danger">Remove Permissions</a>
						 	@else
						 		<a href="{{ route('user.admin',['id' => $user->id])}}" class="btn btn-xs btn-success">Make admin</a>
						 	@endif
						@else
							{{$user->admin}}
						@endif	
					</td>
					<td>
					 	Delete
					 </td>
				</tr>
				
					@endforeach
			@else
			 	<tr>
					<th colspan="5" class="text-center">No post found.</th>
				</tr>
					@endif
			</tbody>
		</table>
	</div>
</div>


@stop
