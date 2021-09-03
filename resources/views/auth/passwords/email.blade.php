@extends('layouts.auth')
@section('content')
<!-- Main Content Start -->
<div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="#"><b>HRM</b> | GlowLogix</a>
    </div>

    <!-- Error Message Section Start -->
    @if (Session::has('error'))
    <div class="content pt-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-danger" align="left">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Error!</strong> {{Session::get('error')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if (Session::has('success'))
    <div class="content pt-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-success" align="left">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Success!</strong> {{Session::get('success')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- Error Message Section End -->

    <div class="card-body">
        <form id="forgetPasswordForm" method="post" action="{{ route('password.email') }}">
            {{ csrf_field() }}
            <p class="login-box-msg">Please enter your email address and we'll send you password reset instructions.</p>
            <div class="input-group form-group {{ $errors->has('official_email') ? ' has-error' : '' }}">
                <input class="form-control" type="text" name="official_email" value="{{ old('official_email') }}" placeholder="Enter Official Email">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
                @if ($errors->has('official_email'))
                    <span class="help-block">
                        <strong style="color: red;" >{{ $errors->first('official_email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group text-center m-t-20">
                <div class="col-xs-12">
                    <button class="btn btn-primary btn-block" type="submit">Send Password Reset Link</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Main Content End -->

<script>
    $(function () {
        $('#forgetPasswordForm').validate({
            rules: {
                official_email: {
                    required: true,
                }
            },
            messages: {
                official_email: "Official email is required."
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

