@extends('layouts.master')

@section('content')
<!-- Breadcrumbs Start -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Edit Leave</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('my_leaves') }}">Attendance</a></li>
          <li class="breadcrumb-item"><a href="{{ url('my_leaves') }}">My Leaves</a></li>
          <li class="breadcrumb-item active">Edit</li>
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
                        <form id="editLeaveForm" action="{{route('leave.update', ['id'=>$leave->id])}}" method="post">
                            {{csrf_field()}}
                            <div class="form-body">
                                <h5><strong>Update Leave</strong></h5>
                                <hr class="mt-0">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Leave Type<span class="text-danger">*</span></label>
                                            <select class="form-control custom-select" name="leave_type">
                                                <option value="">Select Leave Type</option>
                                                @foreach($leave_types as $leave_type)
                                                    <option @if($leave->leave_type == $leave_type->id)selected @endif value="{{$leave_type->id}}">{{$leave_type->name}} ({{$leave_type->count}})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Line Manager<span class="text-danger">*</span></label>
                                            <input type="hidden" name="line_manager" value="{{isset($line_manager->id) ? $line_manager->id : ''}}">
                                            <input type="text" class="form-control" value="{{isset($line_manager->id) ? $line_manager->firstname. '' .$line_manager->lastname : ''}}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">From Date<span class="text-danger">*</span></label>
                                            <input type='date' class="form-control" name="datefrom" value="{{Carbon\Carbon::parse($leave->datefrom)->format('Y-m-d')}}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">To Date<span class="text-danger">*</span></label>
                                            <input type='date' class="form-control" name="dateto" value="{{Carbon\Carbon::parse($leave->dateto)->format('Y-m-d')}}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Back up/ Point of Contact<span class="text-danger">*</span></label>
                                            <select class="form-control custom-select" name="point_of_contact">
                                                <option value="">Select Backup Contact</option>
                                                @foreach($employees as $employee)
                                                    <option  @if($leave->point_of_contact == $employee->id) selected @endif value={{$employee->id}}>{{$employee->firstname}} {{$employee->lastname}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">CC To</label>
                                            <input type="text" class="form-control" name="cc_to" id="cc_to" value="{{$leave->cc_to}}" place>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                      <div class="form-group">
                                            <label class="control-label">Subject<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="subject" value="{{$leave->subject}}">
                                      </div>
                                    </div>
                                    <div class="col-md-12">
                                      <div class="form-group">
                                            <label class="control-label">Description<span class="text-danger">*</span></label>
                                            <textarea type="text" class="form-control" rows="3" name="description" placeholder="Enter Description Here">{{$leave->description}}</textarea>
                                      </div>
                                    </div>
                                </div>
                                <hr>
                                <button  type="submit" class="btn btn-primary btn-ok" title="Update Leave"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-check-circle"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Update</span></button>
                                <a href="{{route('leave.index')}}" class="btn btn-default" title="Cancel"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></a>
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
      $('#editLeaveForm').validate({
        rules: {
            leave_type: {
                required: true,
            },
            datefrom: {
                required: true,
            },
            dateto: {
                required: true,
            },
            point_of_contact: {
                required: true,
            },
            subject: {
                required: true,
            },
            description: {
                required: true,
            },
        },
        messages: {
            leave_type: "Leave type is required",
            datefrom: "Date-from is required",
            dateto: "Date-to is required",
            point_of_contact: "Backup contact is required",
            subject: "Subject is required",
            description: "Description is required",
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