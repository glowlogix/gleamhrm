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
    
    <form id="registerForm" method="POST" action="{{ route('register') }}">
        {{ csrf_field() }}
        <div class="input-group form-group">
            <input id="firstname" type="text" class="form-control" name="firstname" value="{{ old('firstname') }}" placeholder="Enter first name" required autofocus>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-user"></span>
                </div>
            </div>
        </div>

        <div class="input-group form-group">
            <input id="lastname" type="text" class="form-control" name="lastname" value="{{ old('lastname') }}" placeholder="Enter last name" required autofocus>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-user"></span>
                </div>
            </div>
        </div>

        <div class="input-group form-group">
            <input id="official_email" type="email" class="form-control" name="official_email" value="{{ old('official_email') }}" placeholder="Enter official email" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
        </div>

        <div class="input-group form-group">
            <input id="personal_email" type="email" class="form-control" name="personal_email" value="{{ old('personal_email') }}" placeholder="Enter personal email address" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
        </div>

        <div class="input-group form-group">
            <input id="password" type="password" class="form-control" name="password" placeholder="Enter password" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
        </div>

        <div class="input-group form-group">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Enter confirmation password" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    Register
                </button>
            </div>
        </div>
    </form>
</div>
<!-- Main Content End -->

<script>
    $(function () {
        $('#registerForm').validate({
            rules: {
                firstname: {
                    required: true,
                },
                lastname: {
                    required: true,
                },
                official_email: {
                    required: true,
                },
                personal_email: {
                    required: true,
                },
                password: {
                    required: true
                },
                password_confirmation: {
                    required: true
                }
            },
            messages: {
                firstname: "First name is required.",
                lastname: "Last name is required.",
                official_email: "Official email is required.",
                personal_email: "Personal email is required.",
                password: "Password is required.",
                password_confirmation: "Confirmation password is required."
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
<<<<<<< HEAD
@endsection
=======
@endsection
>>>>>>> e501cd3 (Implementation of design changes for auth pages)
