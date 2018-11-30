@extends('layouts.admin')
@section('Heading')
    <h3 class="text-themecolor">Edit Leave</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
        <li class="breadcrumb-item active">Attendance</li>
        <li class="breadcrumb-item active">Leaves</li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-body">
                        <div class="form-body">
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
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Leave Days</label>
                                        <div class="col-md-9">
                                            {{$leave_days}}
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->

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
                                <!--/span-->
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
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Subject</label>
                                        <div class="col-md-9">
                                            {{$leave->subject}}
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row">

                              <!--/span-->
                              <div class="col-md-6">
                                  <div class="form-group row">
                                      <label class="control-label text-right col-md-3">Description</label>
                                      <div class="col-md-9">
                                        {{$leave->description}}
                                      </div>
                                  </div>
                              </div>
                              <!--/span-->
                            </div>
                            <hr>
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