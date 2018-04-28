@extends('layouts.admin') @section('title') {{ config('app.name', 'HRM') }}|{{$title}} @endsection @section('content')

<div class="panel panel-default">
    <div class="panel-heading text-center">
        <div>
            <b style="text-align: center;">All Attendance</b>
        </div>
        <div style="padding-left: 85%;">
                <a href="{{route('attendance.create')}}" class="btn btn-info btn-xs" align="right">
                    <span class="glyphicon glyphicon-plus"></span> Add Attendance
                </a>
        </div>
    </div>
    <div class="panel-body">
        <div id="calender">
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <h4 class="modal-title">Manage Attendance</h4>
                            </div>
                            <div class="modal-body">
                                <label>Enter value:</label>
                              <input type="text" id="attendance">
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="button" id="update" class="btn btn-primary">Save changes</button>
                              <button type="button" id="del" class="btn btn-danger">Delete</button>
                              
                            </div>
                          </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                </div>

            {!! $calendar->calendar() !!}
            
            {!! $calendar->script() !!}

    </div>
</div>

</div>



@stop