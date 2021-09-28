@extends('layouts.master')

@section('content')
<!-- Breadcrumbs Start -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Applicants</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('applicant') }}">Hiring</a></li>
          <li class="breadcrumb-item active">Application</li>
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
							<button type="button" class="btn btn-info btn-rounded" onclick="window.location.href='{{route('applicants.hired')}}'" title="Show Hired Applicants"><i class="mdi mdi-briefcase-check"></i><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Hired Applicants</span></button>
						</div>
			      		
			      <hr>

						<div class="table-responsive">
							<table id="applicants" class="table table-bordered table-striped table-hover">
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
											<td><img src="{{ asset($applicant->avatar) }}" alt="user-image" width="40" class="img-circle" /></td>
											<td>
												<a>{{$applicant->name}}</a>
											</td>
											<td>{{$applicant->city}}</td>
											<td>{{$applicant->job_status}}</td>
											<td>{{$applicant->job->title}}</td>
											<td>
												<a target="_blank" href="{{asset($applicant->cv)}}" class="fas fa-file-alt text-inverse font-bold" data-toggle="tooltip"  data-original-title="Click To Open CV" style="font-size: 30px">
												</a>
											</td>
											<td class="text-nowrap">
												<a href="{{route('applicant.hire',['id'=>$applicant->id])}}" data-toggle="tooltip" title="Hire Applicant" class="btn btn-sm btn-success"> <i class="mdi mdi-briefcase-check"></i></a>
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
    $('#applicants').DataTable({
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