@extends('layouts.master')

@section('content')
<!-- Breadcrumbs Start -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Show Employee Leave</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('employee_leaves') }}">Attendance</a></li>
          <li class="breadcrumb-item"><a href="{{ url('employee_leaves') }}">My Leaves</a></li>
          <li class="breadcrumb-item active">Show</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!-- Breadcrumbs End -->

<!-- Main Content Start -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="box-title">Leave Details</h3>
                        <hr class="m-t-0 m-b-40">
                        <!--/row-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Leave Type</label>
                                    <div class="col-md-9">
                                        @if(isset($leave->leaveType))
                                            {{$leave->leaveType->name}}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Leave Days</label>
                                    <div class="col-md-9">
                                        {{$leave_days}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">From Date</label>
                                    <div class="col-md-9">
                                        {{Carbon\Carbon::parse($leave->datefrom)->format('Y-m-d')}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">To Date</label>
                                    <div class="col-md-9">
                                        {{Carbon\Carbon::parse($leave->dateto)->format('Y-m-d')}}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Line Manager</label>
                                    <div class="col-md-9">
                                        @if(isset($leave->lineManager))
                                            {{$leave->lineManager->firstname}}
                                            {{$leave->lineManager->lastname}}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">CC To</label>
                                    <div class="col-md-9">
                                        {{$leave->cc_to}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Back up/ Point of Contact:</label>
                                    <div class="col-md-9">
                                         @if(isset($leave->pointOfContact))
                                            {{$leave->pointOfContact->firstname}}
                                            {{$leave->pointOfContact->lastname}}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Subject</label>
                                    <div class="col-md-9">
                                        {{$leave->subject}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                              <div class="form-group row">
                                  <label class="control-label text-right col-md-3">Description</label>
                                  <div class="col-md-9">
                                    {{$leave->description}}
                                  </div>
                              </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <script type="text/javascript">
        $(document).ready(function() {
            $(function () {
                $('#datefrom').datetimepicker({
                    format: "YYYY-MM-DD"
                });
                $('#dateto').datetimepicker({
                    format: "YYYY-MM-DD"
                });
            });
        });
    </script>
@stop