@extends('layouts.master')

@section('content')
<!-- Breadcrumbs Start -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Platform Settings</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('platform') }}">Settings</a></li>
          <li class="breadcrumb-item active">Platform Settings</li>
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
                        <center>
                            @if($platform != '')
                                @if($platform->logo == null)
                                    <img src="{{ asset('assets/images/company_logo.png') }}" class="mt-2" height="90"/>
                                @else
                                    <img src="{{ asset($platform->logo) }}" class=" mt-2" height="90"/>
                                @endif
                            @else
                                <img src="{{ asset('assets/images/company_logo.png') }}" class="mt-2" height="90"/>
                            @endif
                            <br>
                        </center>

                        <div class="row mt-5">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label col-4">Company Name:</label>
                                    <div class="col-8">
                                        @if($platform != '')
                                            @if($platform->name == null)
                                                N/A 
                                            @else
                                                {{$platform->name}}
                                            @endif
                                        @else
                                            N/A
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label col-4">Company Website:</label>
                                    <div class="col-8">
                                        @if($platform != '')
                                            @if($platform->website == null)
                                                N/A
                                            @else
                                                {{$platform->website}}
                                            @endif
                                        @else
                                            N/A
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label col-4">Company Email:</label>
                                    <div class="col-8">
                                        @if($platform != '')
                                            @if($platform->email == null)
                                                N/A
                                            @else
                                                {{$platform->email}}
                                            @endif
                                        @else
                                            N/A
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label col-4">HR Email:</label>
                                    <div class="col-8">
                                        @if($platform != '')
                                            @if($platform->hr_email == null)
                                                N/A
                                            @else
                                                {{$platform->hr_email}}
                                            @endif
                                        @else
                                            N/A
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label col-4">Mobile#:</label>
                                    <div class="col-8">
                                        @if($platform != '')
                                            @if($platform->mobile_no == null)
                                                N/A
                                            @else
                                                {{$platform->mobile_no}}
                                            @endif
                                        @else
                                            N/A
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label col-4">Phone#:</label>
                                    <div class="col-8">
                                        @if($platform != '')
                                            @if($platform->phone_no == null)
                                                N/A
                                            @else
                                                {{$platform->phone_no}}
                                            @endif
                                        @else
                                            N/A
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(Auth::user()->isAllowed('PlatformController:edit'))
                            <hr>
                            
                            <a href="{{ route('admin.platform.edit') }}" class="btn btn-primary">Edit</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop