@extends('layouts.admin') @section('title') {{ config('app.name', 'HRM') }}|{{$title}} @endsection @section('content') @include('admin.includes.errors')
@section('styles')
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />

@endsection
@section('scripts2')


<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>   
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

@endsection

<div class="panel panel-default">
    <div class="panel-heading text-center">
        <div>
            <b style="text-align: center;">Update Attendance</b>
        </div>
    </div>
    <div class="panel-body">

        <form action="{{route('attendance.update',['id'=>$attendance->employee_id])}}" method="post">
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
                        <input type='text' class="form-control" id="chkin" value="{{$checkinTime}}" name="checkindatetimepicker"/>
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
                    <input type='text' class="form-control" id="chkout" value="{{$checkoutTime}}" name="checkoutdatetimepicker"/>
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