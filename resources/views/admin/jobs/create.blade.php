@extends('layouts.master')

@section('content')
<!-- Breadcrumbs Start -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Create Job</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('job') }}">Hiring</a></li>
          <li class="breadcrumb-item"><a href="{{ url('job') }}">Jobs</a></li>
          <li class="breadcrumb-item active">Create</li>
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
						<button type="button" onclick="window.location.href='{{route('job.index')}}'" class="btn btn-info btn-rounded" data-toggle="tooltip" title="Back"><i class="fas fa-chevron-left"></i><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Back</span></button>
			      		
			      		<hr>

						<form id="createJobForm" action="{{route('job.store')}}" method="post" enctype="multipart/form-data">
							{{csrf_field()}}
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="form-group">
										<label class="control-label">Job Title<span class="text-danger">*</span></label>
										<input type="text" name="title" class="form-control" placeholder="Enter Job Title">
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="form-group">
										<label class="control-label">Designation<span class="text-danger">*</span></label>
										<select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" name="designation_id">
											<option value="">Select Designation</option>
											@foreach($designations as $designation)
												<option value="{{$designation->id}}">{{$designation->designation_name}}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="form-group">
										<label class="control-label">Branch<span class="text-danger">*</span></label>
										<select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" name="branch_id">
											<option value="">Select Branch</option>
											@foreach($branches as $branch)
												<option value="{{$branch->id}}" @if(old("branch_id") == "remote") selected @endif>{{$branch->name}} ({{$branch->address}})</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="form-group">
										<label class="control-label">Department<span class="text-danger">*</span></label>
										<select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" name="department_id">
											<option value="">Select Department</option>
											@foreach($departments as $department)
												<option value="{{$department->id}}">{{$department->department_name}}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-lg-12 col-md-12 col-sm-12">
									<div class="form-group">
										<label class="control-label">Skills</label>
										<select multiple class="form-control custom-select" data-placeholder="Choose Skills" tabindex="1" name="skills[]">
											@foreach($skills as $skill)
												<option value="{{$skill->id}}">{{$skill->skill_name}}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-lg-12 col-md-12 col-sm-12">
									<div class="form-group">
										<label class="control-label">Description<span class="text-danger">*</span></label>
										<textarea class="textarea_editor form-control" name="description" rows="10" placeholder="Enter Description"></textarea>
									</div>
								</div>
							</div>

							<hr>

							<button type="submit" class="btn btn-primary" data-toggle="tooltip" title="Create Job"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-check-circle"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Create</span></button>
							<button type="button" onclick="window.location.href='{{route('job.index')}}'" class="btn btn-default" data-toggle="tooltip" title="Cancel"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Main Content End -->

<script>
	$(function () {
	  $('#createJobForm').validate({
	    rules: {
	      title: {
	        required: true,
	      },
	      designation_id: {
	        required: true
	      },
	      branch_id: {
	        required: true
	      },
	      department_id: {
	        required: true
	      },
	      description: {
	        required: true
	      }
	    },
	    messages: {
	      title: "Job title is required",
	      designation_id: "Designation is required",
	      branch_id: "Branch is required",
	      department_id: "Department is required",
	      description: "Description is required"
	    },
	    errorElement: 'span',
	    errorPlacement: function (error, element) {
	      error.addClass('invalid-feedback');
	      element.closest('.form-group').append(error);
	    },
	    highlight: function (element, errorClass, validClass) {
	      $(element).addClass('is-invalid');
	    },
	    unhighlight: function (element, errorClass, validClass) {
	      $(element).removeClass('is-invalid');
	    }
	  });
	});
</script>
@stop