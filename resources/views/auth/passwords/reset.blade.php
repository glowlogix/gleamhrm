@extends('layouts.auth')
@section('content')
<!-- Session Message Section Start -->
<div class="card-body">
    @include('layouts.partials.error-message')
</div>
<!-- Session Message Section End -->

<!-- Main Content Start -->
<div class="text-center">
  <a href="#"><b>HRM</b> | @if(isset($platform->name)) {{$platform->name}} @else Company Name @endif</a>
</div>

<div class="card-body">
    <p class="login-box-msg">Please create new password.</p>

    <form id="resetForm" method="post" action="{{ route('password.updated') }}">
        {{ csrf_field() }}
        <h3 class="box-title m-b-20">Reset Password</h3>
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="input-group form-group">
            <input id="email" class="form-control" type="email" name="official_email" placeholder="E-Mail Address" value="{{ $email }}" autofocus>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
        </div>
        <div class="input-group form-group">
            <input class="form-control" type="password" name="password" placeholder="Password">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
        </div>

        <div class="input-group form-group">
            <input class="form-control" type="password" name="password_confirmation" placeholder="Password">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
        </div>
        <div class="form-group text-center m-t-20">
            <div class="col-xs-12">
                <button class="btn btn-primary btn-block" type="submit">Reset</button>
            </div>
        </div>
    </form>
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
