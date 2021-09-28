@extends('layouts.master')

@section('content')
<!-- Breadcrumbs Start -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Branches</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('branch') }}">Settings</a></li>
          <li class="breadcrumb-item active">Branches</li>
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
                    		<button type="button" class="btn btn-info" onclick="window.location.href='{{route('branch.create')}}'" data-toggle="modal" data-target="#add-contact" title="Add Branch"><i class="fas fa-plus"></i><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Add Branch</span></button>
                        </div>

                        <hr>

						<div class="table-responsive">
	                        <table id="branches" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th> Name</th>
										<th> Address</th>
										<th> Timing Start</th>
										<th> Timing Off</th>
										<th> Contact No</th>
										<th> Actions</th>
									</tr>
								</thead>
								<tbody>
									@foreach($branches as $branch)
										<tr>
											<td>{{$branch->name}}</td>
											<td>{{$branch->address}}</td>
											<td>{{Carbon\Carbon::parse($branch->timing_start)->format('h:i a')}}</td>
											<td>{{Carbon\Carbon::parse($branch->timing_off)->format('h:i a')}}</td>
											<td>{{$branch->phone_number}}</td>
											<td class="text-nowrap">
												<a class="btn btn-warning btn-sm" href="{{route('branch.edit',[$branch->id])}}"  title="Edit Branch"> <i class="fas fa-pencil-alt text-white"></i></a>
												<a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirm-delete{{ $branch->id }}" title="Delete Branch"> <i class="fas fa-trash-alt text-white"></i> </a>
											</td>
										</tr>
										<div class="modal fade" id="confirm-delete{{ $branch->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<form action="{{ route('branch.destroy' , $branch->id )}}" method="post">
														<input name="_method" type="hidden" value="DELETE">
														{{ csrf_field() }}
														<div class="modal-header">
                                                            <h4 class="modal-title">Delete Branch</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
														<div class="modal-body">
															Are you sure you want to delete Branch "{{$branch->name}}"?
														</div>
														<div class="modal-footer justify-content-between">
															<button type="button" class="btn btn-default" data-dismiss="modal" title="Cancel"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
                                                            <button  type="submit" class="btn btn-danger btn-ok" title="Delete Team"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-trash-alt"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Delete</span></button>
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
        $('#branches').DataTable({
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