@extends('layouts.master')
@section('content')
<!-- Breadcrumbs Start -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">User Profile</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('personal_profile') }}">User Profile</a></li>
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
                        <button type="button" onclick="window.location.href='{{route('admin.dashboard')}}'" class="btn btn-info btn-rounded" data-toggle="tooltip" title="Back"><i class="fas fa-chevron-left"></i><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Back</span></button>
                        
                        <hr>

                        <form id="imageUploadForm" action="{{route('profile_pic.update')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <!-- <center>
                                <input type="image"  src="{{asset('assets/images/default.png')}}" class="img-circle picture-container picture-src"  id="wizardPicturePreview" title="" width="90" height="90" />
                                <br>
                                <a class="btn btn-primary btn-sm" id="change">Add Image</a>
                                <div class="form-group mb-0">
                                    <input type="file" name="picture" id="wizard-picture" class="form-control" style="position: absolute; top: 0px;z-index: -1;">
                                </div>
                            </center> -->
                            <center>
                                Click On Image to Upload Picture

                                <br>

                                <img @if($employee->picture != '') src="{{asset($employee->picture)}}" @else src="{{asset('assets/images/default.png')}}" @endif class="img-circle picture-container picture-src mt-2" alt="Employee Picture"  id="wizardPicturePreview" width="90" height="90" onclick="document.getElementById('wizard-picture').click();"/>

                                <br>

                                <button type="submit" class="btn btn-primary btn-sm mt-2" title="Click To Upload Picture">
                                    Update Picture
                                </button>

                                <div class="form-group">
                                    <input type="file" name="picture" id="wizard-picture" class="form-control col-1" style="position: absolute; top: 0px;z-index: -1;">
                                </div>
                            </center>
                        </form>

                        <form id="changePasswordForm" action="{{route('password.update')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <a href="#" class="box-title show"><span class="arrow fas fa-chevron-right fa-sm"></span> Click Here To Change Password</a>

                            <hr class="mt-1">

                            <div style="display: none" id="show">
                                <div class="form-group col-md-6">
                                    <label for="new-password" class="control-label">Current Password</label>
                                    <input id="current-password" type="password" class="form-control" name="current_password">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="new-password" class="control-label">New Password</label>
                                    <input id="new-password" type="password" class="form-control" name="new_password">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="new-password-confirm" class="control-label">Confirm New Password</label>
                                    <input id="new-password-confirm" type="password" class="form-control" name="new_password_confirmation">
                                </div>

                                <hr>
                                
                                <button type="submit" class="btn btn-primary">
                                    Change Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('#imageUploadForm').validate({
            rules: {
                picture: {
                    required: true
                }
            },
            messages: {
                picture: "Picture is required"
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

        $('#changePasswordForm').validate({
            rules: {
                current_password: {
                    required: true
                },
                new_password: {
                    required: true
                },
                new_password_confirmation: {
                    required: true
                }
            },
            messages: {
                current_password: "Current password is required",
                new_password: "New password is required",
                new_password_confirmation: "Confirmation password is required"
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

    $(".form-control").keypress(function(e) {
        if (e.which === 13) {
            e.preventDefault();
            return false;
        }
    });

    $(document).ready(function() {
        $('.show').click(function() {
            $('#show').slideToggle("fast");
            $('.arrow').toggleClass('fas fa-chevron-right fa-sm fas fa-chevron-down fa-sm');
        });
    });
</script>
@stop