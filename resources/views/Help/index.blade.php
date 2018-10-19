@extends('layouts.admin')
@section('Heading')
    <h3 class="text-themecolor">Help</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
        <li class="breadcrumb-item">Help</li>
    </ol>
@stop
@section('content')
    <div class="col-md-10 " >
        <div class="card card-body" style="margin-left:200px;">
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <form>
                        <div class="form-group">

                            <input type="text" class="form-control"  placeholder="Enter Name Here" required>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control"  placeholder="Enter email Here" required>
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control"  pattern="[0-9]{11}" placeholder="Enter Phone Number Here">
                        </div>
                        <div class="form-group">
                            <select class="form-control custom-select" required>
                                <option>Feedback</option>
                                <option>Others</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" rows="5" placeholder="Message"  required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Send</button>
                        <button onclick="window.location.href='{{route('admin.help')}}'" class="btn btn-inverse waves-effect waves-light">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
