@extends('layouts.admin') @section('title') {{ config('app.name', 'HRM') }}|{{$title}} @endsection @section('content') 

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
                        @if($leave->leave_type == "Full Leave")
                        
                        <option selected value="Full Leave">Full Leave</option>
                        <option value="Half Leave">Half Leave</option>
                        <option value="Paid Leave">Paid Leave</option>
                        
                        @elseif($leave->leave_type == "Half Leave")
                        
                        <option  value="Full Leave">Full Leave</option>
                        <option selected value="Half Leave">Half Leave</option>
                        <option value="Paid Leave">Paid Leave</option>
                        @else
 
                        <option  value="Full Leave">Full Leave</option>
                        <option value="Half Leave">Half Leave</option>
                        <option selected  value="Paid Leave">Paid Leave</option>
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