@extends('layouts.admin')  @section('content') @include('admin.includes.errors')

<div class="panel panel-default">
    <div class="panel-heading text-center">
        <div>
            <b style="text-align: center;">Update Attendance</b>
        </div>
    </div>
    <div class="panel-body">
        <form action="{{route('attendance.update',['id'=>$attendance->id])}}" method="post">
            {{csrf_field()}}
            <div class="form-group">
                    <div class="col-md-7">
                    <label for="attendance_delay">Delay</label>
                    <input type="text" name="attendance_delay" value="{{$attendance->delay}}" class="form-control">
                </div>
            </div>
            <div class="form-group">
					<div class="col-md-7">
						<label for="checkintime">CheckInTime</label>
						<div class='input-group date' id='checkindatetimepicker' name="checkindatetimepicker">
                        <input type='text' class="form-control" id="chkin" value="{{date('Y/m/d g:i A',strtotime($attendance->checkintime))}}" name="checkindatetimepicker"/>
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
						</div>
					</div>
			  </div>
			  <div class="form-group">
				<div class="col-md-7">
					<label for="checkintime">CheckOutTime</label>
					<div class="input-group date" id="checkoutdatetimepicker" name="checkoutdatetimepicker">
                    <input type='text' class="form-control" id="chkout" value="{{date('Y/m/d g:i A',strtotime($attendance->checkouttime))}}" name="checkoutdatetimepicker"/>
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
				</div>
		      </div>
              <div class="form-group">
					<div class="col-md-5">
						<button class="btn btn-success" type="submit"> Update</button>
						
					</div>
			 </div>	
        </form>
        <script type="text/javascript">
            $(document).ready(function() {
            
                $(function () {
                    $('#checkindatetimepicker').datetimepicker({
                        date: $('#chkin').val()
                    });
                    $('#checkoutdatetimepicker').datetimepicker({
                        date: $('#chkout').val()

                    });
        
                });
            });
        </script>	
    </div>

@stop