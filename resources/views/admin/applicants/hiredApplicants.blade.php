@extends('layouts.master')

@section('content')
<!-- Breadcrumbs Start -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Hired Applicants</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('applicant') }}">Hiring</a></li>
          <li class="breadcrumb-item"><a href="{{ url('applicant') }}">Application</a></li>
          <li class="breadcrumb-item active">Hired Applicants</li>
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
							<button type="button" class="btn btn-info btn-rounded" onclick="window.location.href='{{route('applicants')}}'" title="Show Applicants"><i class="mdi mdi-briefcase-remove"></i><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Applicants</span></button>
						</div>
			      		
			      <hr>
			      		
						<div class="table-responsive">
							<table id="hiredApplicants" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th>Avatar</th>
										<th>Name</th>
										<th>City</th>
										<th>Job Status</th>
										<th>Applied For</th>
										<th>CV</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									@foreach($applicants as $applicant)
										<tr>
											<td><img src="{{asset($applicant->avatar)}}" alt="user-image" width="40" class="img-circle" /></td>
											<td>
												<a href="javascript:void(0)">{{$applicant->name}}</a>
											</td>
											<td>{{$applicant->city}}</td>
											<td>{{$applicant->job_status}}</td>
											<td>{{$applicant->job->title}}</td>
											<td><a target="_blank" href="{{asset($applicant->cv)}}" class="fas fa-file-alt text-inverse font-bold" style="font-size: 30px;">
												</a>
											</td>
											<td class="text-nowrap">
												<a href="{{route('applicant.retire',['id'=>$applicant->id])}}" data-toggle="tooltip" title="Retire Applicant" class="btn btn-sm btn-warning"> <i class="mdi mdi-briefcase-remove"></i></a>
												<a href="{{route ('applicant.delete',['id' =>$applicant->id])}}" data-toggle="tooltip" title="Delete Applicant" class="btn btn-sm btn-danger"> <i class="fas fa-trash-alt"></i></a>
											</td>
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
    $('#hiredApplicants').DataTable({
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