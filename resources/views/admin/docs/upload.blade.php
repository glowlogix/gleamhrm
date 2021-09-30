@extends('layouts.master')

@section('content')
<!-- Breadcrumbs Start -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Upload Document</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('documents') }}">Settings</a></li>
          <li class="breadcrumb-item"><a href="{{ url('documents') }}">Documents</a></li>
          <li class="breadcrumb-item active">Upload</li>
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
						<form id="uploadDocumentForm" action="{{asset('documents/upload')}}" method="post" enctype="multipart/form-data">
							{{ csrf_field() }}
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Document Name<span class="text-danger">*</span></label>
										<input type="text" name="document_name" class="form-control" placeholder="Enter Document Name" value="{{ old('document_name') }}">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
					                    <label for="document">Upload Document<span class="text-danger">*</span> (Max Size 2MB)</label>
					                    <div class="input-group">
					                      	<div class="custom-file">
					                        	<input type="file" class="custom-file-input" name="document" id="document"/>
					                        	<label class="custom-file-label" for="document" id="choose">Choose file</label>
					                      	</div>
					                    </div>
					                </div>
								</div>
							</div>

							<hr>

							<button type="submit" class="btn btn-primary" title="Upload Document"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-check-circle"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Upload</span></button>
							<button type="button" onclick="window.location.href='{{route('documents')}}'" class="btn btn-default" title="Cancel"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
						</form>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
<!-- Main Content End -->

<script>
	$("#document").on('change', function(){
	  	var file = $('#document')[0].files[0].name;
	  	var output = document.getElementById('choose');
	  	output.innerHTML = file;
	});

	$(function () {
	  	$('#uploadDocumentForm').validate({
		    rules: {
		    	document_name: {
		        	required: true
		     	},
				document: {
		        	required: true
		     	}
		    },
		    messages: {
		      	document_name: "Document name is required",
		      	document: "Document is required"
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