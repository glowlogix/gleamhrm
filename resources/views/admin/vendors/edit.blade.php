@extends('layouts.admin')
@section('Heading')
    <h3 class="text-themecolor">Edit Vendor</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
        <li class="breadcrumb-item active">People Management</li>
        <li class="breadcrumb-item active">vendors</li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-body">
                    <form  action="{{route('vendor.update',['id'=>$vendor->id])}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-body">
                            <h3 class="box-title">Vendor Information</h3>
                            <hr class="m-t-0 m-b-40">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Company Name</label>
                                        <div class="col-md-9">
                                            <input  type="text" name="name" placeholder="Enter name here" class="form-control" value="{{old('name',$vendor->company_name)}}">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Email</label>
                                        <div class="col-md-9">
                                            <input type="email" name="email" class="form-control" placeholder="Enter Address here" value="{{old('email',$vendor->email)}}">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Contact Title</label>
                                        <div class="col-md-9">
                                            <select class="form-control custom-select" name="contact_title">
                                                <option value="Mr"  @if($vendor->contact_title == 'Mr') selected @endif>Mr</option>
                                                <option value="Mam" @if($vendor->contact_title == 'Mam') selected @endif>Mam</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Contact Name</label>
                                        <div class="col-md-9">
                                            <input  type="text" name="contact_name" placeholder="Enter name here" class="form-control" value="{{old('contact_name',$vendor->contact_name)}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Vendor Category</label>
                                        <div class="col-md-9">
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
                                </div>
                            </div>
                        </div>
                        <div class="form-body">
                            <h3 class="box-title">Contact Details</h3>
                            <hr class="m-t-0 m-b-40">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Mobile</label>
                                        <div class="col-md-9">
                                            <input type="number" name="mobile" class="form-control" placeholder="Enter Phone Number here" value="{{old('mobile',$vendor->mobile)}}">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Fax</label>
                                        <div class="col-md-9">
                                            <input type="number" name="fax" class="form-control" placeholder="Enter fax Number here" value="{{old('fax',$vendor->fax)}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-body">
                            <h3 class="box-title">Address</h3>
                            <hr class="m-t-0 m-b-40">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Country</label>
                                        <div class="col-md-9">
                                            <input type="text" name="country" class="form-control" placeholder="Enter Country here" value="{{old('country',$vendor->country)}}">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">City</label>
                                        <div class="col-md-9">
                                            <input type="text" name="city" class="form-control" placeholder="Enter City here" value="{{old('city',$vendor->city)}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Postal Code</label>
                                        <div class="col-md-9">
                                            <input type="number" name="postal" class="form-control" placeholder="Enter Postal Code here" value="{{old('postal',$vendor->postal_code)}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Address</label>
                                        <div class="col-md-9">
                                            <textarea rows="2" name="address" class="form-control" placeholder="Enter Address here" value="{{old('address',$vendor->address)}}">{{old('address',$vendor->address)}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-actions">
                            &nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-success">Update Vendor</button>
                            <button type="button" onclick="window.location.href='{{route('vendors.index')}}'" class="btn btn-inverse">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop