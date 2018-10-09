@extends('layouts.admin') @section('title') HRM|{{$title}} @endsection @section('content')

<div class="panel panel-default">
	<div class="panel-heading text-center">
		<b style="text-align: center;">Employees</b>
		<span style="float: left;">
			<a href="{{route('employee.create')}}" class="btn btn-info btn-xs" align="right">
				<span class="glyphicon glyphicon-plus"></span> Add Employee
			</a>
        </span>
        <span style="float: right;">
			<a href="{{route('employee.trashed')}}" class="btn btn-info btn-xs" align="right">
				<span class="glyphicon glyphicon-plus"></span>Trashed Employees
			</a>
        </span>
		@if(Auth::user()->admin)
		@endif
	</div>
</div>
<div class="panel-body">
	<table class="table">
		<thead>
			<th>Name</th>
			<th>Email</th>
			<th>Contact </th>
			<th>Role</th>
			<th>Office</th>
			@if(Auth::user()->admin)
			<th>Manage Employees</th>
			@endif
		</thead>
		<tbody class="table-bordered table-hover table-striped">
			@if(count($employees) > 0) @foreach($employees as $employee)
			<tr>
				<td>{{$employee->firstname}} {{$employee->lastname}}</td>
				<td>{{$employee->official_email}}</td>
				<td>{{$employee->contact_no}}</td>
				<td>{{isset($roles[$employee->role]) ? $roles[$employee->role] : ''}}</td>
				<td>{{isset($employee->officeLocation) ? $employee->officeLocation->name : ''}}</td>
				<td>
					@if(Auth::user()->admin)
					@endif
					
					<button class="btn btn-default" data-toggle="modal" data-target="#confirm-delete{{ $employee->id }}">Delete</button>

					<div class="modal fade" id="confirm-delete{{ $employee->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					    <div class="modal-dialog">
					        <div class="modal-content">
								<form action="{{ route('employee.destroy' , $employee->id )}}" method="post">
									{{ csrf_field() }}
						            <div class="modal-header">
						                Are you sure you want to delete Employee {{ $employee->firstname }}?
						            </div>
						            <div class="modal-body">
                						<label>Admin Password</label>
					                    <input type="password" class="form-control" placeholder="Admin Password" name="password" required>
                						
                						<label>
					                        <input type="hidden" name="invite_to_asana" value="0" />
					                       	<input type="checkbox" class="asana" name="invite_to_asana" value="1" {{($employee->invite_to_asana == 1) ? 'checked' : ''}}/> Delete from Asana ?
					                    </label>
                						<input type="hidden" class="form-control" name="asana_email" value="{{$employee->official_email}}">
                						<br>
										<label>
					                        <input type="hidden" name="invite_to_slack" value="0" />
					                       	<input type="checkbox" class="slack" name="invite_to_slack" value="1" {{($employee->invite_to_slack == 1) ? 'checked' : ''}}/> Delete from Slack?
					                    </label>
                						<br>
					                    <label>
					                        <input type="hidden" name="invite_to_zoho" value="0" />
					                       	<input type="checkbox" id="zoho_{{$employee->id}}" class="zoho" name="invite_to_zoho" value="1" {{($employee->invite_to_zoho == 1) ? 'checked' : ''}}/> Delete from Zoho?
					                    </label>

					                    	<div id="div_zoho_{{$employee->id}}" 
					                    		@if($employee->invite_to_zoho == 0) 
					                    		style="display: none;"
					                    		@endif>
						                    	<input type="password" class="form-control" placeholder="Enter Zoho Password" name="zoho_password">
						                    </div>
                						<br>								
						            </div>
						            <div class="modal-footer">
						                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						                <button  type="submit" class="btn btn-danger btn-ok">Delete</button>
						            </div>
								</form>
					        </div>
					    </div>
					</div>
					<a class="btn btn-info btn-sm" href="{{route('employee.edit',['id'=>$employee->id])}}">Edit</a>

				</td>
			</tr>
			@endforeach @else No Applicant found. @endif

		</tbody>
	</table>
</div>

</div>


@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="{{ asset('js/bootstrap.js')}}"></script>
<script type="text/javascript">	
	$("input.zoho").click(function (event) {
        if ($(this).is(":checked")) {
            $("#div_" + event.target.id).show();
        } else {
            $("#div_" + event.target.id).hide();
        }
    });

</script>
@endpush
@stop