@extends('layouts.admin') @section('content')

<div class="panel panel-default">
    <div class="panel-heading text-center">
        <b style="text-align: center;">All Attendance</b>
        <span style="float: right;">
            <a href="{{route('attendance.create',['id'=>0])}}" class="btn btn-info btn-xs" align="right">
                <span class="glyphicon glyphicon-plus"></span> Add Attendance
            </a>
        </span>
    </div>
    <div class="panel-body">
        <div id="calender">
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title">Manage Attendance</h4>
                        </div>
                        <div class="modal-body">
                        <div class="row">
                            <div class="col-md-7">

                                <label for="leave_type">Choose Type</label>
                                <select class="form-control" name="leave_type" id="leave_type">
                                    <option selected value="present">Present</option>                                        
                                    <option value="Full Leave">Full Leave</option>
                                    <option value="Half Leave">Half Leave</option>
                                    <option value="Short Leave">Short Leave</option>								
                                    <option value="Paid Leave">Paid Leave</option>
                                        
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="col-md-7">
                                    <label for="datefrom">StartDate</label>
                                    <div class='input-group date' id='datefrompicker' name="datefrompicker">
                                        <input type='text' id='datefrom' class="form-control" name="datefrom" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar" id="cl1"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <p id="hello"></p>
                            <div class="form-group">
                                <div class="col-md-7">
                                    <label for="dateto">EndDate</label>
                                    <div class='input-group date' id='datetopicker' name="datetopicker">
                                        <input type='text' id='dateto' class="form-control" name="dateto" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <div class="form-group">
                                    <div class="col-md-7" style="position:relative;top:10px">

                                        <button type="submit" id="update" data-dismiss="modal" class="btn btn-primary">Update</button>

                                        <button type="submit" id="del" class="btn btn-danger">Delete</button>

                                    </div>
                                </div>

                            </div>
                            <input type="hidden" id="currentStartTime">
                            <input type="hidden" id="currentEndTime">
                            <input type="hidden" id="currentStatus">
                            
                            
                        </div>
                    </div>
                    
                    </div>

                </div>


            </div>

        </div>
    </div>
    {!! $calendar->calendar() !!} {!! $calendar->script() !!}
    
        <script type="text/javascript">
            $(document).ready(function () {

                $(function () {
                    $('#datefrompicker').datetimepicker({
                    });
                    $('#datetopicker').datetimepicker({
                    });

                });
            });
        </script>

</div>
@stop