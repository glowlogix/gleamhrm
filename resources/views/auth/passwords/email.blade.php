@extends('layouts.app')
@section('content')
    <div class="login-box card">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="card-body">
            <form class="form-horizontal form-material" id="loginform" method="post"  action="{{ route('password.email') }}">
                {{ csrf_field() }}
                <h3 class="box-title m-b-20">Recover Password</h3>
                <div class="form-group {{ $errors->has('official_email') ? ' has-error' : '' }}">
                    <div class="col-xs-12">
                        <input class="form-control" type="text" name="official_email" value="{{ old('official_email') }}" required="" placeholder="Enter Official Email">
                        @if ($errors->has('official_email'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('official_email') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="form-group text-center m-t-20">
                    <div class="col-xs-12">
                        <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Send Password Reset Link</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

