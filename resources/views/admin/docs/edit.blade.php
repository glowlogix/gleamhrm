@extends('layouts.master')

@section('content')
<!-- Breadcrumbs Start -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Edit Document</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('documents') }}">Settings</a></li>
          <li class="breadcrumb-item"><a href="{{ url('documents') }}">Documents</a></li>
          <li class="breadcrumb-item active">Edit</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!-- Breadcrumbs End -->

<!-- Error Message Section Start -->
@if ($errors->any())
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        @foreach ($errors->all() as $error)
                          <li><strong>Error!</strong> {{ $error }}</li>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@if(Session::has('error'))
    <div class="content">
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
@if(Session::has('success'))
    <div class="content">
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

<!-- Main Content Start -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form id="editDocumentForm" action="{{route('documents.update',['id'=>$document->id])}}" method="post">
                            {{csrf_field()}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Name</label>
                                        <input type="text" value="{{$document->name}}"  name="document_name" class="form-control" placeholder="Enter Title">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group has-success">
                                        <label class="control-label">Status</label>
                                        {{ csrf_field() }}
                                        <select name="upload_status" class="form-control custom-select">
                                            <option value="">Select Status</option>
                                            <option value="1" @if($document->status == 1) selected @endif>Enable</option>
                                            <option value="0" @if($document->status != 1) selected @endif>Disable</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <button type="submit" class="btn btn-primary" title="Update Document"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-check-circle"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Update</span></button>
                            <button type="button" onclick="window.location.href='{{url('documents')}}'" class="btn btn-default" title="Cancel"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $('#editDocumentForm').validate({
            rules: {
                document_name: {
                    required: true
                },
                upload_status: {
                    required: true
                }
            },
            messages: {
                document_name: "Document name is required",
                upload_status: "Status is required"
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