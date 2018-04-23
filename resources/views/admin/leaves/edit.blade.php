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
                        @if($leave->leave_type == "Sick Leave")
                        
                        <option value="Vacation Leave">Vacation Leave</option>
                        <option selected value="Sick Leave">Sick Leave</option>
                        <option value="Birthday Leave">Birthday Leave</option>
                        @elseif($leave->leave_type == "Vacation Leave")
                        <option selected value="Vacation Leave">Vacation Leave</option>
                        <option  value="Sick Leave">Sick Leave</option>
                        <option value="Birthday Leave">Birthday Leave</option>
                        @else
                        <option value="Vacation Leave">Vacation Leave</option>
                        <option  value="Sick Leave">Sick Leave</option>
                        <option selected  value="Birthday Leave">Birthday Leave</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group">
					<div class="col-md-7">
						<label for="datefrom">DateFrom</label>
						<div class='input-group date' id='datefrom' name="datefrom">
                        <input type='text' value="{{$leave->datefrom}}" id="dtfrom" class="form-control" name="datefrom"/>
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
							<input type="text" value="{{$leave->dateto}}" class="form-control"  id="dtto" name="dateto"/>
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
                        <option value="pending">Pending</option>
                        <option value="approval">Approval</option>
                        <option value="declined">Declined</option>
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
            $(document).ready(function() {
            
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
        
    @stop