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
    <p class="login-box-msg">Please enter your email address and we'll send you password reset instructions.</p>

    <form id="forgetPasswordForm" method="post" action="{{ route('password.email') }}">
        {{ csrf_field() }}
        <div class="input-group form-group">
            <input class="form-control" type="text" name="official_email" value="{{ old('official_email') }}" placeholder="Enter Official Email">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
        </div>
        <div class="form-group text-center m-t-20">
            <div class="col-xs-12">
                <button class="btn btn-primary btn-block" type="submit">Send Password Reset Link</button>
            </div>
        </div>
    </form>
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

