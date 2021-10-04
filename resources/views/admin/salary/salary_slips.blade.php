@extends('layouts.master')

@section('content')
<!-- Breadcrumbs Start -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Salary Slips</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('salary/slips') }}">Payments</a></li>
          <li class="breadcrumb-item active">Salary Slips</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!-- Breadcrumbs End -->

<!-- Session Message Section Start -->
@include('layouts.partials.error-message')
<!-- Session Message Section End -->

<!-- Main Content Start -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                    	<div class="d-flex justify-content-between col-12 pl-0">
	                    	<h4 class="card-title pt-2 font-weight-bold">Employee Salaries</h4>
	                        <div class="text-right row">
	                        	<div class="form-group">
									<input id="month" class="form-control" value="{{$month}}" type="month" name="month">
								</div>
	                        </div>
	                    </div>

						<hr class="mt-0">

						<div class="table-responsive">
                            <table id="salary" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th>Employee Name</th>
										<th>Gross Salary</th>
										<th>Bonus</th>
										<th>Approved Leaves</th>
										<th>UnApproved Leaves</th>
										<th>Absent</th>
										<th>Present</th>
										<th>Net Payable</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									@foreach($employees as $employee)
										@if($employee->designation != 'admin' && $employee->designation != 'Admin')
											<tr>
												<td>{{$employee->firstname}} {{$employee->lastname}}</td>
												<td>{{$employee->gross_salary}}</td>
												<td>@if($employee->bonus != '') {{$employee->bonus}} @else 0 @endif</td>
												@foreach($ApprovedCount as $key=>$cnt)
													@if($key==$employee->id)
														<td>{{$cnt}}</td>
													@endif
												@endforeach
												@foreach($unApprovedCount as $key=>$cnt)
													@if($key==$employee->id)
														<td>{{$cnt}}</td>
													@endif
												@endforeach
												@foreach($AbsentCounts as $key=>$AbsentCount)
													@if($key==$employee->id)
														<td>{{$AbsentCount}}</td>
													@endif
												@endforeach
												@foreach($presents as $key=>$present)
													@if($key==$employee->id)
														<td>{{$present}}</td>
													@endif
												@endforeach
												@foreach($netPayables as $key=>$netPayable)
													@if($key==$employee->id)
														@if($netPayable < 1)
															<td>0</td>
														@else
															<td>{{$netPayable}}</td>
														@endif
													@endif
												@endforeach
												<td>
													<a class="btn btn-info btn-sm" href="{{ route('salary.slip',['show', $month, $employee->id]) }}" title="View Salary Slip"> <i class="fas fa-eye text-white"></i></a>
												</td>
											</tr>
										@endif
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Main Content End -->

<script>
    $(document).ready(function () {
        $('#salary').DataTable({
          	"paging": true,
          	"lengthChange": true,
          	"searching": true,
          	"ordering": true,
          	"info": true,
          	"autoWidth": false,
          	"responsive": true
    	});
    });
    $(document).ready(function () {
        $("#month").change(function(e){
            var url = "{{route('salary.slips')}}/" + $(this).val();
            if (url) {
                window.location = url;
            }
            return false;
        });
    });
</script>
@stop