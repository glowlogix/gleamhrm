@extends('layouts.master')

@section('content')
<!-- Breadcrumbs Start -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Edit Platform Settings</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('platform') }}">Settings</a></li>
          <li class="breadcrumb-item"><a href="{{ url('platform') }}">Platform Settings</a></li>
          <li class="breadcrumb-item active">Edit</li>
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
                        <button type="button" onclick="window.location.href='{{route('admin.platform.index')}}'" class="btn btn-info btn-rounded" data-toggle="tooltip" title="Back"><i class="fas fa-chevron-left"></i><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Back</span></button>
                        
                        <hr>

                        <form id="editPlatformForm" action="{{route('admin.platform.update')}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <center>
                                Click On Image to Upload Platform Logo

                                <br>

                                @if($platform != '')
                                    @if($platform->logo == null)
                                        <img src="{{asset('assets/images/company_logo.png')}}" class="mt-2" height="90" alt="Platform Logo" id="wizardPicturePreview" onclick="document.getElementById('wizard-picture').click();"/>
                                    @else
                                        <img src="{{asset($platform->logo)}}" height="90" class="mt-2" alt="Platform Logo" id="wizardPicturePreview" onclick="document.getElementById('wizard-picture').click();"/>
                                    @endif
                                @else
                                    <img src="{{asset('assets/images/company_logo.png')}}" class="mt-2" height="90" alt="Platform Logo" id="wizardPicturePreview" onclick="document.getElementById('wizard-picture').click();"/>
                                @endif

                                <br>

                                <div class="form-group">
                                    <input type="file" name="logo" id="wizard-picture" class="form-control col-1" style="position: absolute; top: 0px;z-index: -1;" accept="image/*">
                                </div>
                            </center>
                            <div class="row pt-4">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Name<span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" placeholder="Enter company name" @if($platform != '') value="{{ $platform->name }}" @endif>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Website<span class="text-danger">*</span></label>
                                        <input type="text" name="website" class="form-control" placeholder="Enter company website" @if($platform != '') value="{{ $platform->website }}" @endif>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Email<span class="text-danger">*</span></label>
                                        <input type="text" name="email" class="form-control" placeholder="Enter company email" @if($platform != '') value="{{ $platform->email }}" @endif>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">HR Email</label>
                                        <input type="text" name="hr_email" class="form-control" placeholder="Enter HR email" @if($platform != '') value="{{ $platform->hr_email }}" @endif>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Mobile#<span class="text-danger">*</span></label>
                                        <input type="text" name="mobile_no" class="form-control" placeholder="Enter mobile number" @if($platform != '') value="{{ $platform->mobile_no }}" @endif>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Phone#</label>
                                        <input type="text" name="phone_no" class="form-control" placeholder="Enter phone number" @if($platform != '') value="{{ $platform->phone_no }}" @endif>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <button type="submit" class="btn btn-primary" title="Update Platform Details"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-check-circle"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Update</span></button>
                            <button type="button" onclick="window.location.href='{{route('admin.platform.index')}}'" class="btn btn-default" title="Cancel"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('#editPlatformForm').validate({
            rules: {
                name: {
                    required: true
                },
                website: {
                    required: true
                },
                email: {
                    required: true
                },
                mobile_no: {
                    required: true
                }
            },
            messages: {
                name: "Company name is required",
                name: "Company website is required",
                email: "Company email is required",
                mobile_no: "Mobile number is required"
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

    $(document).ready(function(){
        // Prepare the preview for profile picture
        $("#wizard-picture").change(function(){
            readURL(this);
        });
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#wizardPicturePreview').attr('src', e.target.result).fadeIn('slow');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@stop