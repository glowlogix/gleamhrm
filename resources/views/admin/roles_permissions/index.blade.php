@extends('layouts.master')

@section('content')
<!-- Breadcrumbs Start -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Roles and Permissions</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('roles') }}">Manage Roles</a></li>
          <li class="breadcrumb-item active">Roles and Permissions</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!-- Breadcrumbs End -->

<!-- Session Message Section Start -->
@include('layouts.partials.error-message')
<!-- Session Message Section End -->

<!-- Main Content Start -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
						<div class="text-right">
							<button type="button" onclick="window.location.href='{{route('roles_permissions.create')}}'" class="btn btn-info btn-rounded"><i class="fas fa-plus"></i><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Add Role</span></button>
                        </div>

                        <hr>
                        
						<div class="table-responsive">
                            <table id="roles" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th>Roles</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach($roles as $role)
										<tr>
											<td>{{$role->name}}</td>
											<td class="text-nowrap">
												<a class="btn btn-warning btn-sm" href="{{route('roles_permissions.edit',['id'=>$role->id])}}" data-toggle="tooltip" data-original-title="Edit"> <i class="fas fa-pencil-alt text-white "></i></a>
												<a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirm-delete{{ $role->id }}"> <i class="fas fa-trash-alt text-white"></i> </a>
											</td>
										</tr>
										<div class="modal fade" id="confirm-delete{{ $role->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<form action="{{ route('roles_permissions.delete' , $role->id )}}" method="post">
														{{ csrf_field() }}
														<div class="modal-header">
		                                                    <h4 class="modal-title">Delete Role</h4>
		                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		                                                        <span aria-hidden="true">×</span>
		                                                    </button>
		                                                </div>
														<div class="modal-body">
															Are you sure you want to delete Role "{{$role->name}}"?
														</div>
														<div class="modal-footer justify-content-between">
															<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
															<button  type="submit" class="btn btn-danger btn-ok">Delete</button>
														</div>
													</form>
												</div>
											</div>
										</div>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Main Content End -->

<script>
    $(document).ready(function () {
        $('#roles').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>
@stop