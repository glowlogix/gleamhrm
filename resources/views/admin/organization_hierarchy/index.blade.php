@extends('layouts.admin')  @section('content')
<div class="panel panel-default">
	<div class="panel-heading text-center">
		<b style="text-align: center;">Organization Hierarchy</b>
		<span style="float: left;">
			<a href="{{route('organization_hierarchy.create')}}" class="btn btn-info btn-xs" align="right">
				<span class="glyphicon glyphicon-plus"></span> Add Employee To Organization
			</a>
        </span>
        
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-body">
		<table class="table">
			<thead>
				<th>Employee</th>
				<th>Line Manager</th>
				<th>Parent</th>
				<th>Action</th>
			</thead>
			<tbody class="table-bordered table-hover table-striped">
				@if($organization_hierarchies->count() > 0) 
				@foreach($organization_hierarchies as $organization_hierarchy)
				<tr>
					<td>
						@if($organization_hierarchy->employee)
						{{$organization_hierarchy->employee->firstname}}
						{{$organization_hierarchy->employee->lastname}}
						@endif
					</td>
					<td>
						@if($organization_hierarchy->lineManager)
							{{$organization_hierarchy->lineManager->firstname}}
							{{$organization_hierarchy->lineManager->lastname}}
						@endif
					</td>
					<td>
						@if($organization_hierarchy->parentEmployee)
						{{$organization_hierarchy->parentEmployee->firstname}}
						{{$organization_hierarchy->parentEmployee->lastname}}
						@endif
					</td>
					<td>
						<a href="{{route('organization_hierarchy.edit',['id'=>$organization_hierarchy->id])}}">Edit</a>
						<button class="btn btn-default" data-toggle="modal" data-target="#confirm-delete{{ $organization_hierarchy->id }}">Delete</button>

					<div class="modal fade" id="confirm-delete{{ $organization_hierarchy->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					    <div class="modal-dialog">
					        <div class="modal-content">
								<form action="{{ route('organization_hierarchy.destroy' , $organization_hierarchy->id )}}" method="post">
									{{ csrf_field() }}
						            <div class="modal-header">
						                Are you sure you want to delete this Organization Hierarchy?
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
					<td>No Employees found.</td>
					<td></td>
				</tr>
				@endif
			</tbody>
		</table>
	</div>
</div>

@stop