@extends('layouts.admin')
@section('Heading')
	<button type="button" class="btn btn-info btn-rounded m-t-10 float-right" onclick="window.location.href='{{route('organization_hierarchy.create')}}'"><span class="fas fa-plus"></span> Add Org Employee</button>
	<h3 class="text-themecolor">Organization Hierarchy</h3>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="javascript:void(0)"></a>Dashboard</li>
		<li class="breadcrumb-item active">People-Management</li>
		<li class="breadcrumb-item active">Org Chart</li>
	</ol>
@stop
@section('content')
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h6 class="card-subtitle"></h6>
				<br>
				<div class="table table-responsive">
				<!-- <table id="demo-foo-addrow" class="table  m-t-30 table-hover contact-list" data-paging="true" data-paging-size="7">
					<thead>
					@if($organization_hierarchies->count() > 0)
					<tr>
						<th>Employee</th>
						<th>Line Manager</th>
						<th>Parent</th>
						<th>Action</th>
					</tr>
					</thead>
					<tbody>
					<tr>

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
						<td class="text-nowrap">
							<a class="btn btn-info btn-sm" href="{{route('organization_hierarchy.edit',['id'=>$organization_hierarchy->id])}}"> <i class="fas fa-pencil-alt text-white"></i></a>
							<a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirm-delete{{ $organization_hierarchy->id }}"> <i class="fas fa-window-close text-white"></i></a>
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
					<p class="text-center float-left" style="margin-top: 70px;">No Employees found.</p>
					@endif
					</tbody>
				</table> -->
				{{--Orgnisation chart--}}
				<div id="chart-container" class="table-responsive">
				</div>

				<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<form id="delete" action="" method="post">
								<input name="_method" type="hidden" value="DELETE">
								{{ csrf_field() }}
								<div class="modal-header">
									Are you sure you want to delete this Employee & his subordinates from Organization Hierarchy ?
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
									<button  type="submit" class="btn btn-danger btn-ok">Delete</button>
								</div>
							</form>
						</div>
					</div>
				</div>
				{{--END Orgnisation chart--}}
				</div>
			</div>
		</div>
	</div>
</div>
@stop

@push('scripts')
<script type="text/javascript" src="{{asset('OH/js/jquery.mockjax.min.js')}}"></script>
<script type="text/javascript" src="{{asset('OH/js/jquery.orgchart.js')}}"></script>
<script type="text/javascript">
function assignFormAction(id){
	$('form#delete').attr('action',  "{{route('organization_hierarchy.index')}}/" + id);
}
$(function() {
    $.mockjax({
        url: '/orgchart/initdata',
        responseTime: 1000,
        contentType: 'application/json'
        @if ($hierarchy)
        ,responseText: {!! $hierarchy !!}
        @endif
    });

    $('#chart-container').orgchart({
        'data' : '/orgchart/initdata',
        'nodeContent': 'title',
        'width': '100%',
        'createNode': function($node, data) {
            var secondMenuIcon = $('<li>', {
                'class': 'fas fa-plus-circle create-menu-icon',
            	'onclick' : "location.href='{{route('organization_hierarchy.create')}}/'"
            	// 'onclick' : "location.href='{{route('organization_hierarchy.create')}}/" + data.id+"'"
            });
            $node.append(secondMenuIcon);

            var thirdMenuIcon = $('<li>', {
                'class': 'fas fa-edit edit-menu-icon',
            	'onclick' : "location.href='{{route('organization_hierarchy.index')}}/" + data.id+"/edit'"
            });

            $node.append(thirdMenuIcon);

            var deleteIcon = $('<li>', {
                'class': 'fas fa-trash delete-menu-icon',
                'data-toggle' : 'modal',
                'data-target' : '#confirm-delete',
            	'onclick' : "assignFormAction("+data.employee_id+")",
            });

            $node.append(deleteIcon);
        }
    });
});
</script>

{{--Organisational Structure--}}
<link rel="icon" href="{{asset('OH/img/logo.png')}}">
<link rel="stylesheet" href="{{asset('OH/css/jquery.orgchart.css')}}">
{{--Add ICON--}}
<style type="text/css">
    .orgchart{ width: 100% }

    .orgchart .create-menu-icon {
        transition: opacity .5s;
        opacity: 0;
        right: 112px;
        top: -5px;
        z-index: 2;
        color: rgba(68, 157, 68, 0.5);
        font-size: 18px;
        position: absolute;
        color: black;
    }
    .orgchart .create-menu-icon:hover { color:black; }
    .orgchart .node:hover .create-menu-icon { opacity: 1; }
	
	.orgchart .edit-menu-icon {
        transition: opacity .5s;
        opacity: 0;
        right: -5px;
        top: -5px;
        z-index: 2;
        color: rgba(68, 157, 68, 0.5);
        font-size: 18px;
        position: absolute;
        color: black;
    }
    .orgchart .edit-menu-icon:hover { color:black; }
    .orgchart .node:hover .edit-menu-icon { opacity: 1; }

    .orgchart .delete-menu-icon {
        transition: opacity .5s;
        opacity: 0;
        right: -1px;
        top: 30px;
        z-index: 2;
        color: rgba(68, 157, 68, 0.5);
        font-size: 18px;
        position: absolute;
        color: black;
    }
    .orgchart .delete-menu-icon:hover { color:black; }
    .orgchart .node:hover .delete-menu-icon { opacity: 1; }
    
</style>

{{--END Organisational Structure--}}
@endpush