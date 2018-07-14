@extends('layouts.admin')

@section('content')

<div class="panel panel-default">
		<div class="panel-heading text-center">
				<div ><b style="text-align: center;" >Create Leave</b></div>	
		</div>
		<div class="panel-body">
			<form action="{{route('leaves.store')}}" method="post">
			   {{csrf_field()}}
			  <div class="form-group">
				<div class="col-md-6">
					<label for="name">Name:</label>
					<select class="form-control" name="employee_id">
					 @foreach($employees as $employee)
					   <option value={{$employee->id}}>{{$employee->fullname}}</option>
					 @endforeach
					
					</select>
				</div>
			  </div>
			  <div class="form-group">
					<div class="col-md-6">
						<label for="leave_type">Leave Type</label>
						<select class="form-control" name="leave_type">
								<option selected value="Full Leave">Full Leave</option>
								<option value="Half Leave">Half Leave</option>
								<option value="Short Leave">Short Leave</option>								
								<option value="Paid Leave">Paid Leave</option>
								
						</select>
					</div>
			  </div>
			  <div class="form-group" >
					<div class="col-md-6" style="padding-top:15px;">
						<label for="datefrom">FromDate</label>
						<div class='input-group date' id='datefrom' name="datefrom">
							<input type='text' class="form-control" name="datefrom"/>
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
						</div>
					</div>
			  </div>
					
              <div class="form-group" >
					<div class="col-md-6" style="padding-top:15px;">
						<label for="dateto">ToDate</label>
						<div class='input-group date' id='dateto' name="dateto">
							<input type='text' class="form-control" name="dateto"/>
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
						</div>
					</div>
			  </div>
					
			  <div class="form-group">
					<div class="col-md-6">
						<label for="reason">Reason</label>
						<input type="text" class="form-control" name="reason">
					</div>
			  </div>
			  <div class="form-group">
					<div class="col-md-6">
						<label for="checkouttime">Status</label>
						<select name="status" class="form-control">
                            <option value="Pending">Pending</option>
                            <option value="Approval">Approval</option>
                            <option value="Declined">Declined</option>
                        </select>
					</div>
			  </div>
			  <div class="form-group">
					<div class="col-md-8" style="padding-top:23px;">
						<button class="btn btn-success" type="submit" style="margin-left: 360px;"> Create</button>
						
					</div>
			 </div>	

		
		</div>

	
	<script type="text/javascript">
		$(document).ready(function() {
		
			$(function () {
				$('#datefrom').datetimepicker({
					format: 'L'
				});
				$('#dateto').datetimepicker({
					format: 'L'
				});
	
			});
		});
	</script>	
</div>



@stop