@extends('layouts.master')

@section('content')
<!-- Breadcrumbs Start -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Help</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('help') }}">Help</a></li>
          <li class="breadcrumb-item active">Create</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!-- Breadcrumbs End -->

<!-- Error Message Section Start -->
@include('layouts.partials.error-message')
<!-- Error Message Section End -->

<!-- Main Content Start -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form id="helpForm" action="{{route('contact_us')}}" method="post" novalidate>
                            {{csrf_field()}}
                            <input type="text" name="email" value="@if(isset($platform->hr_email)) {{$platform->hr_email}} @else @if(isset($platform->email)) {{$platform->email}} @else noreply@email.com @endif @endif" hidden>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="control-label">Name<span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control"  placeholder="Enter Name Here">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label">Email<span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control"  placeholder="Enter email Here">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label">Phone#<span class="text-danger">*</span></label>
                                    <input type="number" name="number" class="form-control"  pattern="[0-9]{11}" placeholder="Enter Phone Number Here">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label">Type<span class="text-danger">*</span></label>
                                    <select class="form-control custom-select" name="type">
                                        <option value="">Select Type</option>
                                        <option value="Feedback">Feedback</option>
                                        <option value="Others">Others</option>
                                    </select>
                                </div>
                                <div class="form-group col-12">
                                    <label class="control-label">Message<span class="text-danger">*</span></label>
                                    <textarea name="message" class="form-control" rows="5" placeholder="Message"></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Main Content End -->

<script>
    $(function () {
      $('#helpForm').validate({
        rules: {
            name: {
                required: true,
            },
            email: {
                required: true,
            },
            number: {
                required: true,
            },
            type: {
                required: true,
            },
            message: {
                required: true,
            }
        },
        messages: {
            name: "Name is required",
            email: "Email is required",
            number: "Phone number is required",
            type: "Type is required",
            message: "Message is required"
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
