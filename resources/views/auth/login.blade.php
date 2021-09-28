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
    <p class="login-box-msg">Sign in to start your session</p>

    <form id="loginForm" method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}
        <div class="input-group form-group">
            <input class="form-control" type="email" name="official_email" placeholder="E-Mail Address" id="email" value="{{ old('official_email') }}" autofocus>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
        </div>
        <div class="input-group form-group mb-0">
            <input class="form-control" name="password" id="password" type="password" placeholder="Password">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
        </div>

        <div class="text-right text-sm">
            <a href="{{ route('password.request') }}">Forget password?</a>
        </div>

        <div class="icheck-primary">
            <input type="checkbox" id="remember">
            <label for="remember">
                Remember Me
            </label>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </div>
    </form>
</div>
<!-- Main Content End -->

<script>
    $(function () {
        $('#loginForm').validate({
            rules: {
                official_email: {
                    required: true,
                },
                password: {
                    required: true
                }
            },
            messages: {
                official_email: "Official email is required.",
                password: "Password is required."
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
