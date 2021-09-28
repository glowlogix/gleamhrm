@extends('layouts.master')

@section('content')
<!-- Breadcrumbs Start -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Documents</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('documents') }}">Settings</a></li>
          <li class="breadcrumb-item active">Documents</li>
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
                    		<button type="button" class="btn btn-info btn-rounded" onclick="window.location.href='{{route('documents.create')}}'" data-toggle="modal" data-target="#add-contact" title="Add New Document"><i class="fas fa-plus"></i><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Add New Document</span></button>
                        </div>

                        <hr>

						<div class="table-responsive">
                            <table id="documents" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th>Document Name</th>
										<th class="text-center">Status</th>
										@if(Auth::user()->hasRole('admin'))
											<th>Action</th>
										@endif
									</tr>
								</thead>
								<tbody>
									@foreach($files as $file)
										<tr>
											<td>
												<a target="_blank" href="{{asset($file->url)}}">{{ $file->name }}</a>
											</td>
											<td class="text-center">
												@if($file->status == 1)
                                                    <div class="text-white badge badge-success font-weight-bold">Active</div>
                                                @else
                                                    <div class="text-white badge badge-danger font-weight-bold">Inactive</div>
                                                @endif
											</td>
											@if(Auth::user()->hasRole('admin'))
												<td class="row">
													<a class="btn btn-warning btn-sm ml-1" href="{{route('documents.edit',['id'=>$file->id])}}" title="Edit Document">
														<span class="fas fa-pencil-alt text-white"></span>
													</a>
													<form action="{{ route('documents.delete' , $file->id )}}" method="post">
														{{ csrf_field() }}
														<button class="btn btn-danger btn-sm ml-1" title="Delete Document">
															<span class="fas fa-trash-alt"></span>
														</button>
													</form>
												</td>
											@endif
										</tr>
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
        $('#documents').DataTable({
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



