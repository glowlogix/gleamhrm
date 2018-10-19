@extends('layouts.admin')
@section('Heading')
	<h3 class="text-themecolor">Create New Job</h3>

@stop
@section('content')

<div class="row">
	<div class="col-lg-12">
		<div class="card card-outline-info">

			<div class="card-body">
				<form action="{{route('job.store')}}" method="post" enctype="multipart/form-data">
					{{csrf_field()}}
					<div class="form-body">

							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Title</label>
									<input type="text"  name="title" class="form-control" placeholder="Enter Title">
									</div>
							</div>

					</div>
					<div class="form-body">

						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">City</label>
								<input type="text"  name="city" class="form-control" placeholder="Enter City">
						</div>
						</div>

					</div>
					<div class="form-body">
						<div class="col-md-8" >
							<div class="form-group">
								<label class="control-label">Description</label>
								<textarea name="description"  rows="5" class="form-control " placeholder="Enter Description Here"></textarea>
								</div>
						</div>

					</div>

					<div class="form-actions">
						&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-success">Create Job </button>
						<button type="button" onclick="window.location.href='{{route('jobs')}}'" class="btn btn-inverse">Cancel</button>
					</div>
				</form>
			</div>
		</div>
	</div>

</div>
<!-- Row -->



@stop