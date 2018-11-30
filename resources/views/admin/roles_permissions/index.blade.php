@extends('layouts.admin')
@section('Heading')
	<button type="button"  onclick="window.location.href='{{route('roles_permissions.create')}}'" class="btn btn-info btn-rounded m-t-10 float-right"><span class="fas fa-plus" ></span> Add Role</button>
	<h3 class="text-themecolor">Permission And Roles</h3>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
		<li class="breadcrumb-item active">Roles Permission</li>
		<li class="breadcrumb-item active">Roles</li>
	</ol>
@stop
@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h6 class="card-subtitle"></h6>
					{{--<button type="button"  onclick="window.location.href='{{route('roles_permissions.applyrole')}}'" class="btn btn-info btn-rounded m-t-10 float-right">Apply Role</button>--}}
					<br>
					<div class="table">
						<table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list" data-paging="true" data-paging-size="7">
							<thead>
							<tr>
								<th>Roles</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody>
							@if($roles->count() > 0)
								@foreach($roles as $role)
								<tr>

									<td>{{$role->name}}</td>
									<td class="text-nowrap">
										<a class="btn btn-info btn-sm" href="{{route('roles_permissions.edit',['id'=>$role->id])}}" data-toggle="tooltip" data-original-title="Edit"> <i class="fas fa-pencil-alt text-white "></i></a>
										<a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirm-delete{{ $role->id }}"> <i class="fas fa-window-close text-white"></i> </a>
										{{--//Model//--}}
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
							@endforeach @else
								<tr> No Permission Found</tr>
							@endif

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	@stop