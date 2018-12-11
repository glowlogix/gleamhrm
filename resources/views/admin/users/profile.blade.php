@extends('layouts.admin')
@section('Heading')
    <button type="button" onclick="window.location.href='{{route('admin.dashboard')}}'" class="btn btn-info float-right">Back</button>
    <h3 class="text-themecolor">Dashboard</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
        <li class="breadcrumb-item active">Update Profile</li>
    </ol>
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-outline-info">
                <div style="margin-top:10px; margin-right: 10px;">
                </div>
                <div class="card-body">
                    <form action="{{route('profile_pic.update')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <center >
                            @if($employee->picture != '')
                                <img   src="{{asset($employee->picture)}}" class="img-circle picture-container picture-src" alt="Employee Picture"  id="wizardPicturePreview" title="" width="150" onclick="document.getElementById('wizard-picture').click();"  width="150"/>
                                <input  type="file" name="picture" id="wizard-picture" class="" required hidden>
                            @else
                                <img src="{{asset('assets/images/default.png')}}" class="img-circle picture-container picture-src" id="wizardPicturePreview" title="" width="150" height="150" onclick="document.getElementById('wizard-picture').click();" />
                                <input  type="file" name="picture" id="wizard-picture" class="" required hidden>
                            @endif
                            <h6 class="card-title m-t-10">Click On Image to Upload  Picture</h6>
                        </center>
                        <center>
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Update Image
                                </button>
                            </div>
                        </center>
                    </form>
                    <form action="{{route('password.update')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-body">
                            <a class="box-title show "><span class="arrow fa fa-angle-right"></span> Click Here To Change Password</a>
                            <hr class="m-t-0 m-b-40">
                            <div style="display: none" id="show">
                            <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                                <label for="new-password" class="col-md-4 control-label">Current Password</label>

                                <div class="col-md-6">
                                    <input id="current-password" type="password" class="form-control" name="current-password" required>

                                    @if ($errors->has('current-password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('current-password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                                <label for="new-password" class="col-md-4 control-label">New Password</label>

                                <div class="col-md-6">
                                    <input id="new-password" type="password" class="form-control" name="new-password" required>

                                    @if ($errors->has('new-password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('new-password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="new-password-confirm" class="col-md-4 control-label">Confirm New Password</label>

                                <div class="col-md-6">
                                    <input id="new-password-confirm" type="password" class="form-control" name="new-password_confirmation" required>
                                </div>
                            </div>
                            <!--/row-->
                        <hr>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Change Password
                                    </button>
                                </div>
                            </div>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
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
            }           }

        $(".form-control").keypress(function(e) {
            if (e.which === 13) {
                e.preventDefault();
                return false;
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.show').click(function() {
                $('#show').slideToggle("fast");
                $('.arrow').toggleClass('fa fa-angle-right fa fa-angle-down');
            });
        });
    </script>
@endpush