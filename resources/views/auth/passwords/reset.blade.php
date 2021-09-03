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
        <form id="resetForm" method="post" action="{{ route('password.updated') }}">
            {{ csrf_field() }}
            <h3 class="box-title m-b-20">Reset Password</h3>
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="input-group form-group {{ $errors->has('official_email') ? ' has-error' : '' }} ">
                <input id="email" class="form-control" type="email" name="official_email" placeholder="E-Mail Address" value="{{ $email }}" autofocus>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
                @if ($errors->has('official_email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('official_email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="input-group form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                <input class="form-control" type="password" name="password" placeholder="Password">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
                @if ($errors->has('password'))
                    <span class="text-danger text-sm">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="input-group form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <input class="form-control" type="password" name="password_confirmation" placeholder="Password">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
                @if ($errors->has('password_confirmation'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group text-center m-t-20">
                <div class="col-xs-12">
                    <button class="btn btn-primary btn-block" type="submit">Reset</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Main Content End -->

<script>
    $(function () {
        $('#resetForm').validate({
            rules: {
                official_email: {
                    required: true,
                },
                password: {
                    required: true,
                },
                password_confirmation: {
                    required: true,
                }
            },
            messages: {
                official_email: "Official email is required.",
                password: "Password is required.",
                password_confirmation: "Password confirmation is required."
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
@endsection
