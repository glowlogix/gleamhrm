@extends('layouts.admin')
@section('Heading')
	<h3 class="text-themecolor">Organization Hierarchy</h3>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="javascript:void(0)"></a>Dashboard</li>
		<li class="breadcrumb-item active">People-Management</li>
		<li class="breadcrumb-item active">Org Chart</li>
		<li class="breadcrumb-item active">index</li>
	</ol>
@stop
@section('content')
		<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h6 class="card-subtitle"></h6>
					<button type="button" class="btn btn-info btn-rounded m-t-10 float-right" onclick="window.location.href='{{route('organization_hierarchy.create')}}'">Add Employee To Organization</button>
					<br>
					<div class="table">
						<table id="demo-foo-addrow" class="table  m-t-30 table-hover contact-list" data-paging="true" data-paging-size="7">
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
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	@stop
















{{--<div class="panel panel-default">--}}
	{{--<div class="panel-heading text-center">--}}
		{{--<b style="text-align: center;">Organization Hierarchy</b>--}}
		{{--<span style="float: left;">--}}
			{{--<a href="{{route('organization_hierarchy.create')}}" class="btn btn-info btn-xs" align="right">--}}
				{{--<span class="glyphicon glyphicon-plus"></span> Add Employee To Organization--}}
			{{--</a>--}}
        {{--</span>--}}

	{{--</div>--}}
{{--</div>--}}
{{--<div class="panel panel-default">--}}
	{{--<div class="panel-body">--}}
		{{--<table class="table">--}}
			{{--<thead>--}}
				{{--<th>Employee</th>--}}
				{{--<th>Line Manager</th>--}}
				{{--<th>Parent</th>--}}
				{{--<th>Action</th>--}}
			{{--</thead>--}}
			{{--<tbody class="table-bordered table-hover table-striped">--}}
				{{--@if($organization_hierarchies->count() > 0)--}}
				{{--@foreach($organization_hierarchies as $organization_hierarchy)--}}
				{{--<tr>--}}
					{{--<td>--}}
						{{--@if($organization_hierarchy->employee)--}}
						{{--{{$organization_hierarchy->employee->firstname}}--}}
						{{--{{$organization_hierarchy->employee->lastname}}--}}
						{{--@endif--}}
					{{--</td>--}}
					{{--<td>--}}
						{{--@if($organization_hierarchy->lineManager)--}}
							{{--{{$organization_hierarchy->lineManager->firstname}}--}}
							{{--{{$organization_hierarchy->lineManager->lastname}}--}}
						{{--@endif--}}
					{{--</td>--}}
					{{--<td>--}}
						{{--@if($organization_hierarchy->parentEmployee)--}}
						{{--{{$organization_hierarchy->parentEmployee->firstname}}--}}
						{{--{{$organization_hierarchy->parentEmployee->lastname}}--}}
						{{--@endif--}}
					{{--</td>--}}
					{{--<td>--}}
						{{--<a href="{{route('organization_hierarchy.edit',['id'=>$organization_hierarchy->id])}}">Edit</a>--}}
						{{--<button class="btn btn-default" data-toggle="modal" data-target="#confirm-delete{{ $organization_hierarchy->id }}">Delete</button>--}}

					{{--<div class="modal fade" id="confirm-delete{{ $organization_hierarchy->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">--}}
					    {{--<div class="modal-dialog">--}}
					        {{--<div class="modal-content">--}}
								{{--<form action="{{ route('organization_hierarchy.destroy' , $organization_hierarchy->id )}}" method="post">--}}
									{{--{{ csrf_field() }}--}}
						            {{--<div class="modal-header">--}}
						                {{--Are you sure you want to delete this Organization Hierarchy?--}}
						            {{--</div>--}}
						            {{--<div class="modal-footer">--}}
						                {{--<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>--}}
						                {{--<button  type="submit" class="btn btn-danger btn-ok">Delete</button>--}}
						            {{--</div>--}}
								{{--</form>--}}
					        {{--</div>--}}
					    {{--</div>--}}
					{{--</div>--}}
					{{--</td>--}}
				{{--</tr>--}}
				{{--@endforeach--}}
				{{--@else--}}
				{{--<tr>--}}
					{{--<td>No Employees found.</td>--}}
					{{--<td></td>--}}
				{{--</tr>--}}
				{{--@endif--}}
			{{--</tbody>--}}
		{{--</table>--}}
	{{--</div>--}}
{{--</div>--}}

{{--@stop--}}