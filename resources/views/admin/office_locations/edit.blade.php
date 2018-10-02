@extends('layouts.admin') @section('content')

<div class="panel panel-default">
	<div class="panel-heading text-center">
		<b> Update Office Location</b>
		<span style="float: right;">
            <a href="{{route('offices')}}" class="btn btn-info btn-xs" align="right">
                <span class="glyphicon"></span> Back
            </a>
        </span>
	</div>
	<div class="panel-body">

		<form action="{{route('office_location.update',['id'=>$office_location->id])}}" method="post" enctype="multipart/form-data">
			{{csrf_field()}}
			<div class="form-group">
				<label for="name">Name</label>
				<input type="text" name="name" placeholder="Enter name here" class="form-control" value="{{$office_location->name}}">
			</div>
			<div class="form-group">
				<label for="status">Status</label>
				<select class="form-control nameselect2" name="status" id="status">
                    <option value="1"@if($office_location->status == 1) selected @endif>Active</option>
                    <option value="2"@if($office_location->status == 2) selected @endif>Inactive</option>
                </select>
            </div>
			<div class="form-group">
				<label for="timing_start">Timing Start</label>
                <div class="input-group timepicker">
                    <input class="form-control" name="timing_start" placeholder="Enter Timing Start here"  id="timing_start" value="{{Carbon\Carbon::parse($office_location->timing_start)->format('h:i A')}}" />
                    <span class="input-group-addon timepicker1">
                        <i class="fa fa-clock-o" style="font-size:16px"></i>
                    </span>
                </div>
            </div>
            <div class="form-group">
				<label for="timing_off">Timing Off</label>
                <div class="input-group timepicker">
                    <input class="form-control" name="timing_off" placeholder="Enter Timing Off here"  id="timing_off" value="{{Carbon\Carbon::parse($office_location->timing_off)->format('h:i A')}}" />
                    <span class="input-group-addon timepicker1">
                        <i class="fa fa-clock-o" style="font-size:16px"></i>
                    </span>
                </div>
            </div>
			<div class="form-group">
				<label for="address">Address</label>
				<input type="text" name="address" class="form-control" placeholder="Enter Address here" value="{{$office_location->address}}">
			</div>
			<div class="form-group">
				<label for="phone_number">Phone Number</label>
				<input type="number" name="phone_number" class="form-control" placeholder="Enter Phone Number here" value="{{$office_location->phone_number}}">
			</div>	
			<div class="form-group">
				<button class="btn btn-success center-block" type="submit"> Update</button>
			</div>
			
		</form>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function () {
    $(function () {
	    /*$('.timepicker1').click(function(){
	        $(this).parent().datetimepicker({
	            format: "LT",
	            icons: {
	                up: "fa fa-chevron-up",
	                down: "fa fa-chevron-down"
	            }
	        }).datetimepicker('show');
	    });*/
		
		$("div.timepicker").on("click", function () {
		        $(this).datetimepicker({
		            format: "LT",
		            icons: {
		                up: "fa fa-chevron-up",
		                down: "fa fa-chevron-down"
		            }
		        });
		        console.log("O.K.");
		});

    });
});
</script>
@stop
