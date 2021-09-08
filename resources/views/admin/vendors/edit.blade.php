@extends('layouts.master')

@section('content')
<!-- Breadcrumbs Start -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Edit Vendor</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('vendors') }}">People Management</a></li>
          <li class="breadcrumb-item"><a href="{{ url('vendors') }}">Vendors</a></li>
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

@if (Session::has('error'))
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
<!-- Error Message Section End -->

<!-- Main Content Start -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <button type="button" onclick="window.location.href='{{route('vendors.index')}}'" class="btn btn-info btn-rounded" title="Back"><i class="fas fa-chevron-left"></i><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Back</span></button>
                        
                        <hr>
                        
                        <form id="editVendorForm" action="{{route('vendor.update',['id'=>$vendor->id])}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Company Name</label>
                                        <input  type="text" name="name" placeholder="Enter name here" class="form-control" value="{{old('name',$vendor->company_name)}}">
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Email</label>
                                        <input type="email" name="email" class="form-control" placeholder="Enter Address here" value="{{old('email',$vendor->email)}}">
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Contact Title</label>
                                        <select class="form-control custom-select" name="contact_title">
                                            <option value="">Select Title</option>
                                            <option value="Mr"  @if($vendor->contact_title == 'Mr') selected @endif>Mr</option>
                                            <option value="Mam" @if($vendor->contact_title == 'Mam') selected @endif>Mam</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Contact Name</label>
                                        <input  type="text" name="contact_name" placeholder="Enter name here" class="form-control" value="{{old('contact_name',$vendor->contact_name)}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Vendor Category</label>
                                        <select class="form-control custom-select" data-placeholder="Choose a Category" name="vendor_category_id">
                                            <option value="">Select Vendor Category</option>
                                            @if($vendor_categories->count() > 0)
                                            @foreach($vendor_categories as $category)
                                                <option value="{{$category->id}}" @if($category->id == $vendor->vendor_category_id) selected @endif>{{$category->category_name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Vendor Type</label>
                                        <select class="form-control custom-select" tabindex="1" name="vendor_type">
                                            <option value="">Select Vendor Type</option>
                                                <option value="individual" @if($vendor->vendor_type == 'individual') selected @endif>Individual</option>
                                                <option value="business" @if($vendor->vendor_type == 'business') selected @endif>Business</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Tax Payer</label>
                                        <select class="form-control custom-select" tabindex="1" name="tax_payer" id="tax_payer">
                                            <option value="">Select an Option</option>
                                                <option value="1" @if($vendor->tax_payer == '1') selected @endif>Yes</option>
                                                <option value="0" @if($vendor->tax_payer == '0') selected @endif>No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Branch</label>
                                        <select class="form-control custom-select" tabindex="1" name="branch">
                                            <option value="">Select Branch</option>
                                            @foreach($branches as $branch)
                                                <option value="{{$branch->id}}" @if($branch->id == $vendor->branch_id) selected @endif>{{ $branch->name }} ({{ $branch->address }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6" id="tax" @if($vendor->tax_payer != 1) style="display: none;" @endif>
                                    <div class="form-group">
                                        <label class="control-label">Tax#</label>
                                        <input  type="number" name="tax_no" placeholder="Enter Tax Number here" class="form-control" value="{{ $vendor->tax_no }}">
                                    </div>
                                </div>
                            </div>
                            <h5 class="pt-3"><strong>Contact Details</strong></h5>
                            <hr class="mt-0">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Mobile</label>
                                        <input type="number" name="mobile" class="form-control" placeholder="Enter Phone Number here" value="{{old('mobile',$vendor->mobile)}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Fax</label>
                                        <input type="number" name="fax" class="form-control" placeholder="Enter fax Number here" value="{{old('fax',$vendor->fax)}}">
                                    </div>
                                </div>
                            </div>
                            <h5 class="pt-3"><strong>Address</strong></h5>
                            <hr class="mt-0">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Country</label>
                                        <input type="text" name="country" class="form-control" placeholder="Enter Country here" value="{{old('country',$vendor->country)}}">
                                    </div>
                                </div>
                                <!--/span-->

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">City</label>
                                        <input type="text" name="city" class="form-control" placeholder="Enter City here" value="{{old('city',$vendor->city)}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Postal Code</label>
                                        <input type="number" name="postal" class="form-control" placeholder="Enter Postal Code here" value="{{old('postal',$vendor->postal_code)}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Address</label>
                                        <textarea rows="1" name="address" class="form-control" placeholder="Enter Address here" value="{{old('address',$vendor->address)}}">{{old('address',$vendor->address)}}</textarea>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            
                            <button type="submit" class="btn btn-primary" title="Update Vendor"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-check-circle"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Update</span></button>
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
        $('#editVendorForm').validate({
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
                filer: {
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
                filer: "Filer information is required",
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