@extends('layouts.admin')
@section('Heading')
    <button type="button" class="btn btn-info btn-rounded m-t-10 float-right" onclick="window.location.href='{{route('vendor.create')}}'"><span class="fas fa-plus"></span> Add Vendor</button>
    <h3 class="text-themecolor">Vendors</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
        <li class="breadcrumb-item active">People Management</li>
        <li class="breadcrumb-item active">vendors</li>
    </ol>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-subtitle"></h6>
                    <div class="table">
                        <table id="demo-foo-addrow" class="table-responsive " data-paging="true" data-paging-size="7">
                            <thead>
                            @if($vendors->count() > 0)
                            <tr>
                                <th>Company Name</th>
                                <th>Contact Name</th>
                                <th>Email</th>
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
                                        <td>{{$vendor->company_name}}</td>
                                        <td>{{$vendor->contact_title}}.&nbsp {{$vendor->contact_name}}</td>
                                        <td>{{$vendor->email}}</td>
                                        <td>{{$vendor->address}}</td>
                                        <td>{{$vendor->city}}</td>
                                        <td>{{$vendor->postal_code}}</td>
                                        <td>{{$vendor->country}}</td>
                                        <td>{{$vendor->mobile}}</td>
                                        <td>{{$vendor->fax}}</td>
                                        <td class="text-nowrap">
                                            <a class="btn btn-info btn-sm" href="{{route('vendor.edit',['id'=>$vendor->id])}}"  data-original-title="Edit"> <i class="fas fa-pencil-alt text-white"></i></a>
                                            <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirm-delete{{ $vendor->id }}"  data-original-title="Close"> <i class="fas fa-window-close text-white  "></i> </a>
                                            <div class="modal fade" id="confirm-delete{{ $vendor->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form action="{{ route('vendor.delete' , $vendor->id )}}" method="post">
                                                            {{ csrf_field() }}
                                                            <div class="modal-header">
                                                                Are you sure you want to delete this Vendor?
                                                            </div>
                                                            <div class="modal-header">
                                                                <h4>{{ $vendor->company_name }}</h4>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                                <button  type="submit" class="btn btn-danger btn-ok">Delete</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach @else
                                <tr> No Vendor Found</tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop