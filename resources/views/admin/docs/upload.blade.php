@extends('layouts.admin')
@section('Heading')
	<h3 class="text-themecolor">Upload Document</h3>
@stop
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card card-outline-info">

			<div class="card-body">
				<form action="{{asset('admin/upload/docs')}}" method="post" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="form-body">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Document Names</label>
								<input type="text" name="document_name" class="form-control" placeholder="Enter Document Name">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6 col-md-6">
								<div class="card-body">
									<h4 class="card-title">File Upload</h4>
									<label for="input-file-now">You Can Attatch More Than File </label>
									<input type="file" id="input-file-now" class="dropify"  name="documents[]" multiple/>
								</div>
						</div>
					</div>
				<br>
					<div class="form-actions">
						&nbsp;&nbsp;&nbsp;<button type="submit" value="Upload" class="btn btn-success">Upload</button>
						<button type="button" onclick="window.location.href='{{route('documents.upload')}}'" class="btn btn-inverse">Cancel</button>
					</div>
				</form>
			</div>
		</div>
    </div>
</div>
@stop




{{--<div class="panel panel-default">--}}
	{{--<div class="panel-heading text-center">--}}
		{{--<b>Upload Documents</b>--}}
	{{--</div>--}}
	{{--<div class="panel-body">--}}
		{{--<div class="container">--}}
			{{--<br>--}}
			{{--<div class="row">--}}
				{{--<div class="col-md-8">--}}
					{{--<form action="../../admin/upload/docs" method="post" enctype="multipart/form-data">--}}
						{{--{{ csrf_field() }}--}}
						{{--<br />--}}
						{{--<label for="document_name">Enter Document Name:</label>--}}
						{{--<input type="text" class="form-control" placeholder="Enter Document Name" name="document_name">--}}
						{{--<br>--}}
						{{--<label for="documents">Documents(can attach more than one):</label>--}}
						{{--<input type="file" class="form-control" name="documents[]" multiple />--}}

						{{--<br />--}}
						{{--<input type="submit" class="btn btn-primary" value="Upload" />--}}
					{{--</form>		--}}
				{{--</div>--}}
			{{--</div>--}}
		{{--</div>--}}
	{{--</div>--}}
{{--</div>--}}
{{--@stop--}}