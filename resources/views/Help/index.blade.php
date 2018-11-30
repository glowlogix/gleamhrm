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
                    <form action="{{route('contact_us')}}" method="post" novalidate>
                        {{csrf_field()}}
                        <div class="form-group ">
                            <div class="controls">
                            <input type="text" name="name" class="form-control"  placeholder="Enter Name Here" required data-validation-required-message="This field is required">
                            </div>
                            </div>
                        <div class="form-group ">
                            <div class="controls">
                            <input type="email" name="email" class="form-control"  placeholder="Enter email Here" required data-validation-required-message="This field is required">
                            </div>
                            </div>
                        <div class="form-group ">
                            <div class="controls">
                            <input type="number" name="number" class="form-control"  pattern="[0-9]{11}" placeholder="Enter Phone Number Here" required data-validation-required-message="This field is required">
                            </div>
                            </div>
                        <div class="form-group ">
                            <div class="controls">
                            <select class="form-control custom-select" name="type" required data-validation-required-message="This field is required">
                                <option value="Feedback">Feedback</option>
                                <option value="Others">Others</option>
                            </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="controls">
                            <textarea name="message" class="form-control" rows="5" placeholder="Message"  required data-validation-required-message="This field is required"></textarea>
                            </div>
                            </div>
                        <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
