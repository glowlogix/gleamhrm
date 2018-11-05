@extends('layouts.admin')
@section('Heading')
	<button type="button" class="btn btn-info btn-rounded m-t-10 float-right" onclick="window.location.href='{{route('leaves')}}'"><span class="fas fa-plus" ></span> Add Leave</button>
	<h3 class="text-themecolor">Update Attendance</h3>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
		<li class="breadcrumb-item active">Attendance</li>
		<li class="breadcrumb-item active">Update</li>
	</ol>
@endsection
@section('content')	@include('admin.includes.errors')
	<div class="row">
		<div class="col-lg-12">
			<div class="card card-outline-info">
				<div style="margin-top: 10px;margin-right: 10px">
					<button type="button" class="btn  btn-info float-right" onclick="window.location.href='{{route('attendance')}}'">Back</button>
				</div>
				<div class="card-body">
					<form   class="form-horizontal" action="{{route('attendance.update',['id'=>$attendance->id])}}" method="post">
						{{csrf_field()}}
						<div class="form-body">
							<h3 class="box-title">Update Attendance</h3>
							<hr class="m-t-0 m-b-40">
							<div class="row">
								<!--/span-->
								<div class="col-md-6">
									<div class="form-group row">
										<label class="control-label text-right col-md-3">Delay</label>
										<div class="col-md-9 date1" >
											<input  type="text" class="form-control" name="attendance_delay" value="{{$attendance->delay}}">
											<span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group row">
										<label class="control-label text-right col-md-3">Check In</label>
										<div class="col-md-9 timepicker">
											<input type="time" class="form-control" value="{{date('Y/m/d g:i A',strtotime($attendance->checkintime))}}" name="checkindatetimepicker"/>
										</div>
									</div>
								</div>
								<!--/span-->
							</div>
							<!--/row-->
							<div class="row">

								<!--/span-->
								<div class="col-md-6">
									<div class="form-group row ">
										<label class="control-label text-right col-md-3">Check Out</label>
										<div class="col-md-9 timepicker">
											<input type="time" class="form-control" value="{{date('Y/m/d g:i A',strtotime($attendance->checkouttime))}}" name="checkoutdatetimepicker">
										</div>
									</div>
								</div>
								<!--/span-->
							</div>
						</div>
						<div class="form-actions">
							<hr>
							<div class="col-md-12">
								<div class="row">

									<div class="col-md-offset-3 col-md-12">
										<button type="submit" class="btn btn-info float-right">Update</button>
									</div>
								</div>
							</div>
							<div class="col-md-6"> </div>
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>
<script type="text/javascript">
    $(document).ready(function() {

   });
</script>
@stop
