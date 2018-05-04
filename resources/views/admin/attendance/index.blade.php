@extends('layouts.admin')

@section('content')

    <div class="panel panel-default">

        <div class="panel-heading text-center">
            <div><b style="text-align: center;">Create Attendance</b></div>
        </div>
        <div class="row">
            <div class="panel-body">
                <form action="{{route('attendance.store')}}" method="post">
                    {{csrf_field()}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <select class="form-control" name="employee_id">
                                @foreach($employees as $employee)
                                    <option value={{$employee->id}}>{{$employee->fullname}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="delay">Delay</label>
                            <input type="number" placeholder="0" class="form-control" name="delay">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="checkintime">CheckInTime</label>
                            <div class='input-group date' id='checkindatetimepicker' name="checkindatetimepicker">
                                <input type='text' class="form-control" name="checkindatetimepicker"/>
                                <span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="checkintime">CheckOutTime</label>
                            <div class="input-group date" id="checkoutdatetimepicker" name="checkoutdatetimepicker">
                                <input type='text' class="form-control" name="checkoutdatetimepicker"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <button class="btn btn-success" type="submit"> Create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                $(function () {
                    $('#attendance_year_month').datetimepicker({
                        viewMode: 'years',
                        format: 'YYYY/MM'
                    });
                    $('#checkindatetimepicker').datetimepicker();
                    $('#checkoutdatetimepicker').datetimepicker();
                });
            });
        </script>
    </div>
@stop