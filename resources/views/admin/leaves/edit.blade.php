@extends('layouts.admin') @section('content')

<div class="panel panel-default">
    <div class="panel-heading text-center">
        <div>
            <b style="text-align: center;">Update Leave</b>
        </div>
    </div>
    <div class="panel-body">
        <form action="{{route('leave.update',['id'=>$leave->employee_id])}}" method="post">
            {{csrf_field()}}
            <div class="form-group">
                <div class="col-md-7">

                    <label for="leave_type">Leave Type</label>
                    <select class="form-control" name="leave_type">
                        <option @if($leave->leave_type == 'unpaid_leave')selected @endif value="unpaid_leave">Full Leave(Unpaid)</option>
                        <option @if($leave->leave_type == 'half_leave')selected @endif value="half_leave">Half Leave</option>
                        <option @if($leave->leave_type == 'short_leave')selected @endif value="short_leave">Short Leave</option>                             
                        <option @if($leave->leave_type == 'paid_leave')selected @endif value="paid_leave">Paid Leave</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-7">
                    <label for="datefrom">DateFrom</label>
                    <div class='input-group date' id='datefrom' name="datefrom">
                        <input type='text' value="{{$leave->datefrom}}" id="dtfrom" class="form-control" name="datefrom" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-7">
                    <label for="dateto">DateTo</label>
                    <div class='input-group date' id='dateto' name="dateto">
                        <input type="text" value="{{$leave->dateto}}" class="form-control" id="dtto" name="dateto" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-7">

                    <label for="status">Status</label>
                    <select name="status" class="form-control">
                        <option @if($leave->status == 'Pending') selected @endif value="Pending">Pending</option>
                        <option @if($leave->status == 'Approval') selected @endif value="Approval">Approval</option>
                        <option @if($leave->status == 'Declined') selected @endif value="Declined">Declined</option>
                    </select>

                </div>
            </div>
            <div class="form-group">
                <div class="col-md-7">
                    <label for="reason">Reason</label>
                    <input type="text" value="{{$leave->reason}}" class="form-control" name="reason">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-5">
                    <button class="btn btn-success center-block" type="submit"> Update</button>
                </div>
            </div>
        </form>

        <script type="text/javascript">
            $(document).ready(function () {

                $(function () {
                    $('#datefrom').datetimepicker({
                        format: 'L',
                        date: $('#dtfrom').val()
                    });
                    $('#dateto').datetimepicker({
                        format: 'L',
                        date: $('#dtto').val()
                    });

                });
            });
        </script>
    </div>
</div>

@stop