@extends('layouts.admin')  @section('content')
<div class="panel panel-default">
	<div class="panel-heading text-center">
		<b style="text-align: center;">Roles Permissions</b>
		<span style="float: left;">
			<a href="{{route('roles_permissions.create')}}" class="btn btn-info btn-xs" align="right">
				<span class="glyphicon glyphicon-plus"></span> Add Roles
			</a>
        </span>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-body">
		<table class="table">
			<thead>
				<th>Roles</th>
				<th>Action</th>
			</thead>
			<tbody class="table-bordered table-hover table-striped">
				@if($roles->count() > 0) 
				@foreach($roles as $role)
				<tr>
					<td>{{$role->name}}</td>
					<td>
						<a href="{{route('roles_permissions.edit',['id'=>$role->id])}}">Edit</a>
						<a href="{{route('roles_permissions.delete',['id'=>$role->id])}}">Delete</a>
					</td>
				</tr>
				@endforeach
				@else
				<tr> 
					<td>No Roles found.</td>
					<td></td>
				</tr>
				@endif
			</tbody>
		</table>
	</div>
</div>

@stop