@extends('layouts.admin')  @section('content')
<div class="panel panel-default">
	<div class="panel-heading text-center">
		<b style="text-align: center;">Roles Permissions</b>
		<span style="float: left;">
			<a href="{{route('roles_permissions.create')}}" class="btn btn-info btn-xs" align="right">
				<span class="glyphicon glyphicon-plus"></span> Add Roles
			</a>
        </span>
        <span style="float: right;">
            <a href="{{route('roles_permissions.applyrole')}}" class="btn btn-info btn-xs" align="right">
                <span class="glyphicon"></span> Apply Role
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
						<button class="btn btn-default" data-toggle="modal" data-target="#confirm-delete{{ $role->id }}">Delete</button>

					<div class="modal fade" id="confirm-delete{{ $role->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					    <div class="modal-dialog">
					        <div class="modal-content">
								<form action="{{ route('roles_permissions.delete' , $role->id )}}" method="post">
									{{ csrf_field() }}
						            <div class="modal-header">
						                Are you sure you want to delete this Role {{$role->name}}?
						            </div>
						            <div class="modal-footer">
						                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						                <button  type="submit" class="btn btn-danger btn-ok">Delete</button>
						            </div>
								</form>
					        </div>
					    </div>
					</div>
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