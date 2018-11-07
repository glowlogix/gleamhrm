@extends('layouts.app')
@section('content')
    <div class="login-box card ">
        <div class="card-body">
            <form class="form-horizontal form-material" id="loginform" method="post" action="{{ route('password.request') }}">
                {{ csrf_field() }}
                <h3 class="box-title m-b-20">Reset Password</h3>
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group {{ $errors->has('official_email') ? ' has-error' : '' }} ">
                    <div class="col-xs-12">
                        <input id="email" class="form-control" type="email" name="official_email" required="" placeholder="E-Mail Address" value="{{ $official_email or old('official_email') }}" autofocus>
                        @if ($errors->has('official_email'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('official_email') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                    <div class="col-xs-12">
                        <input class="form-control" type="password" required="" name="password" placeholder="Password">
                        @if ($errors->has('password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <div class="col-xs-12">
                        <input class="form-control" type="password" required="" name="password_confirmation" placeholder="Password">
                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group text-center m-t-20">
                    <div class="col-xs-12">
                        <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
