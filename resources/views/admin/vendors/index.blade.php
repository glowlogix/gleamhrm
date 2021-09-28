@extends('layouts.master')

@section('content')
<!-- Breadcrumbs Start -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Vendors</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('vendors') }}">People Management</a></li>
          <li class="breadcrumb-item active">Vendors</li>
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
                        <div class="text-right">
                            <button type="button" class="btn btn-info btn-rounded" onclick="window.location.href='{{route('vendor.create')}}'"  title="Add Vendor"><i class="fas fa-plus"></i><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Add Vendor</span></button>
                        </div>

                        <hr>
                        <div class="table-responsive">
                            <table id="vendors" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Company Name</th>
                                        <th>Contact Name</th>
                                        <th>Email</th>
                                        <th>Vendor Type</th>
                                        <th>Tax Payer</th>
                                        <th>Tax#</th>
                                        <th>Branch</th>
                                        <th>Address</th>
                                        <th>City</th>
                                        <th>Postal Code</th>
                                        <th>Country</th>
                                        <th>Mobile</th>
                                        <th>Fax</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($vendors as $vendor)
                                        <tr>
                                            @if($vendor->company_name)
                                                <td>{{$vendor->company_name}}</td>
                                            @else
                                                <td class="text-center">N/A</td>
                                            @endif

                                            <td>{{$vendor->contact_title}}. {{$vendor->contact_name}}</td>
                                            <td>{{$vendor->email}}</td>
                                            <td>{{$vendor->vendor_type}}</td>

                                            @if($vendor->tax_payer == '1')
                                            <td>Yes</td>
                                            <td>{{$vendor->tax_no}}</td>
                                            @else
                                            <td>No</td>
                                            <td class="text-center">N/A</td>
                                            @endif

                                            @foreach($branches as $branch)
                                                @if($branch->id == $vendor->branch_id)
                                                    <td>{{$branch->name}} ({{$branch->address}})</td>
                                                @endif
                                            @endforeach
                                            <td>{{$vendor->address}}</td>
                                            <td>{{$vendor->city}}</td>
                                            <td>{{$vendor->postal_code}}</td>
                                            <td>{{$vendor->country}}</td>
                                            <td>{{$vendor->mobile}}</td>
                                            <td>{{$vendor->fax}}</td>
                                            <td class="text-nowrap">
                                                <a class="btn btn-warning btn-sm" href="{{route('vendor.edit',['id'=>$vendor->id])}}" title="Edit Vendor"> <i class="fas fa-pencil-alt text-white"></i></a>
                                                <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirm-delete{{ $vendor->id }}"  title="Delete Vendor"> <i class="fas fa-trash-alt"></i> </a>
                                                
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="confirm-delete{{ $vendor->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('vendor.delete' , $vendor->id )}}" method="post">
                                                        {{ csrf_field() }}
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Delete Vendor</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete Vendor "{{ $vendor->company_name }}"?
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal" title="Cancel"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
                                                            <button  type="submit" class="btn btn-danger btn-ok" title="Delete Vendor"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-trash-alt"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Delete</span></button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Main Content End -->

<script>
  $(document).ready(function () {
    $('#vendors').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
@stop