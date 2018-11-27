@extends('layouts.admin')
@section('Heading')
	<h3 class="text-themecolor">Create New Job</h3>
@stop
@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="card card-outline-info">
				<div style="margin-top:10px; margin-right: 10px;">
					<button type="button" onclick="window.location.href='{{route('job.index')}}'" class="btn btn-info float-right">Back</button>
				</div>
				<div class="card-body">
					<form action="{{route('job.store')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
						{{csrf_field()}}
						<div class="form-body">
							<hr class="m-t-0 m-b-40">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group row">
										<label class="control-label text-right col-md-3">Job Title</label>
										<div class="col-md-9">
											<input type="text"  name="title" class="form-control" placeholder="Enter Title">
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group row">
										<label class="control-label text-right col-md-3">Designation</label>
										<div class="col-md-9">
											<select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" name="designation_id">
												<option value="">Select Designation</option>
												@foreach($designations as $designation)
													<option value="{{$designation->id}}">{{$designation->designation_name}}</option>
												@endforeach
											</select>
										</div>
									</div>
								</div>
							</div>
							<!--/row-->
							<!--/row-->
							<div class="row">
								<div class="col-md-6">
									<div class="form-group row">
										<label class="control-label text-right col-md-3">Branch</label>
										<div class="col-md-9">
											<select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" name="branch_id">
												@foreach($branches as $branch)
													<option value="{{$branch->id}}" @if(old("branch_id") == "remote") selected @endif>{{$branch->name}} ({{$branch->address}})</option>
												@endforeach
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group row">
										<label class="control-label text-right col-md-3">Department</label>
										<div class="col-md-9">
											<select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" name="department_id">
												<option value="">Select Department</option>
													@foreach($departments as $department)
														<option value="{{$department->id}}">{{$department->department_name}}</option>
													@endforeach
											</select>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group row">
										<label class="control-label text-right col-md-3">Description</label>
										<div class="col-md-9">
											<textarea name="description"  rows="5" class="form-control " placeholder="Enter Description Here"></textarea>
										</div>
									</div>
								</div>
							</div>
						</div>
						<hr>
						<div class="form-actions">
							<div class="row">
								<div class="col-md-6">
									<div class="row">
										<div class="col-md-offset-3 col-md-9">
											<button type="submit" class="btn btn-success">Add Job</button>
											<button type="button" onclick="window.location.href='{{route('job.index')}}'" class="btn btn-inverse">Cancel</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

@stop