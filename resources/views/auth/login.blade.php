@extends('layouts.auth')
@section('content')
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
                @if ($errors->has('official_email'))
                    <span class="help-block">
                        <strong style="color: red;" >{{ $errors->first('official_email') }}</strong>
                    </span>
                @endif
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
        
        {{-- <form class="form-horizontal" id="recoverform" action=""> --}}
        {{--     <div class="form-group "> --}}
        {{--         <div class="col-xs-12"> --}}
        {{--             <h3>Recover Password</h3> --}}
        {{--             <p class="text-muted">Enter your Email and instructions will be sent to you! </p> --}}
        {{--         </div> --}}
        {{--     </div> --}}
        {{--     <div class="form-group "> --}}
        {{--         <div class="col-xs-12"> --}}
        {{--             <input class="form-control" type="text" required="" placeholder="Email"> --}}
        {{--         </div> --}}
        {{--     </div> --}}
        {{--     <div class="form-group text-center m-t-20"> --}}
        {{--         <div class="col-xs-12"> --}}
        {{--             <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset</button> --}}
        {{--         </div> --}}
        {{--     </div> --}}
        {{-- </form> --}}
    </div>
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