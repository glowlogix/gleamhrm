@extends('layouts.master')

@section('content')
<!-- Breadcrumbs Start -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Create Vendor</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('vendors') }}">People Management</a></li>
          <li class="breadcrumb-item"><a href="{{ url('vendors') }}">Vendors</a></li>
          <li class="breadcrumb-item active">Create</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!-- Breadcrumbs End -->

<!-- Session Message Section Start -->
@include('layouts.partials.error-message')
<!-- Session Message Section End -->

<!-- Main Content Start -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <button type="button" onclick="window.location.href='{{route('vendors.index')}}'" class="btn btn-info btn-rounded" title="Back"><i class="fas fa-chevron-left"></i><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Back</span></button>
                        
                        <hr>
                        
                        <form id="createVendorForm" action="{{route('vendor.store')}}" method="post" enctype="multipart/form-data" novalidate>
                            {{csrf_field()}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Company Name</label>
                                        <input  type="text" name="name" placeholder="Enter name here" class="form-control" value="{{old('name')}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Email<span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control" placeholder="Enter Address here" value="{{old('email')}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Contact Title<span class="text-danger">*</span></label>
                                        <select class="form-control custom-select" name="contact_title">
                                            <option value="">Choose Title</option>
                                            <option value="Mr">Mr</option>
                                            <option value="Mam">Mrs.</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Contact Name<span class="text-danger">*</span></label>
                                        <input  type="text" name="contact_name" placeholder="Enter name here" class="form-control" value="{{old('contact_name')}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Vendor Category<span class="text-danger">*</span></label>
                                        <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" name="vendor_category_id">
                                            <option value="">Select Vendor Category<span class="text-danger">*</span></option>
                                            @if($vendor_categories->count() > 0 )
                                                @foreach($vendor_categories as $category)
                                                    <option value="{{$category->id}}">{{$category->category_name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Vendor Type<span class="text-danger">*</span></label>
                                        <select class="form-control custom-select" tabindex="1" name="vendor_type">
                                            <option value="">Select Vendor Type</option>
                                                <option value="individual" @if(old('vendor_type') == 'individual') selected @endif>Individual</option>
                                                <option value="business" @if(old('vendor_type') == 'business') selected @endif>Business</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Tax Payer<span class="text-danger">*</span></label>
                                        <select class="form-control custom-select" tabindex="1" name="tax_payer" id="tax_payer">
                                            <option value="">Select an Option</option>
                                                <option value="1" @if(old('tax_payer') == '1') selected @endif>Yes</option>
                                                <option value="0" @if(old('tax_payer') == '0') selected @endif>No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Branch<span class="text-danger">*</span></label>
                                        <select class="form-control custom-select" tabindex="1" name="branch">
                                            <option value="">Select Branch</option>
                                            @foreach($branches as $branch)
                                                <option value="{{$branch->id}}" @if(old('barnch') == $branch->id) selected @endif>{{ $branch->name }} ({{ $branch->address }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6" id="tax" style="display: none;">
                                    <div class="form-group">
                                        <label class="control-label">Tax#<span class="text-danger">*</span></label>
                                        <input  type="number" name="tax_no" placeholder="Enter Tax Number here" class="form-control" value="{{old('tax_no')}}">
                                    </div>
                                </div>
                            </div>
                            <h5 class="pt-3"><strong>Contact Details</strong></h5>
                            <hr class="mt-0">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Mobile</label>
                                        <input type="number" name="mobile" class="form-control" placeholder="Enter Phone Number here" value="{{old('mobile')}}">
                                    </div>
                                </div>
                                <!--/span-->

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Fax</label>
                                        <input type="number" name="fax" class="form-control" placeholder="Enter fax Number here" value="{{old('fax')}}">
                                    </div>
                                </div>
                            </div>
                            <h5 class="pt-3"><strong>Address</strong></h5>
                            <hr class="mt-0">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Country</label>
                                        <select  name="country" class="form-control">
                                        @foreach($countries as $country)
                                            <option value="{{$country->name}}">{{$country->name}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">City</label>
                                        <input type="text" name="city" class="form-control" placeholder="Enter City here" value="{{old('city')}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Postal Code</label>
                                        <input type="number" name="postal" class="form-control" placeholder="Enter Postal Code here" value="{{old('postal')}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Address</label>
                                        <input type="text" name="address" class="form-control" placeholder="Enter Address here" value="{{old('address')}}"/>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <button type="submit" class="btn btn-primary" title="Create Vendor"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-check-circle"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Create</span></button>
                            <button type="button" onclick="window.location.href='{{route('vendors.index')}}'" class="btn btn-default" title="Cancel"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>

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
        $('#createVendorForm').validate({
            rules: {
                email: {
                    required: true
                },
                contact_title: {
                    required: true
                },
                contact_name: {
                    required: true
                },
                vendor_category_id: {
                    required: true
                },
                vendor_type: {
                    required: true
                },
                tax_payer: {
                    required: true
                },
                tax_no: {
                    required: true
                },
                branch: {
                    required: true
                }
            },
            messages: {
                email: "Email is required",
                contact_title: "Contact title is required",
                contact_name: "Contact name is required",
                vendor_category_id: "Vendor category is required",
                vendor_type: "Vendor Type is required",
                tax_payer: "Tax Payer information is required",
                tax_no: "Tax number is required",
                branch: "Branch is required"
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

    $("#tax_payer").on('change', function(){
        if(this.value == 1)
        {
            document.getElementById('tax').style.display = 'block';
        }
        else
        {
            document.getElementById('tax').style.display = 'none';
        }
    });
</script>
@stop