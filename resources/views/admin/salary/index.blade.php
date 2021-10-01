@extends('layouts.master')

@section('content')
<!-- Breadcrumbs Start -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Salary</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('salary') }}">Payments</a></li>
          <li class="breadcrumb-item active">Salary</li>
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
									<input id="month" class="form-control" value="{{$month}}" type="month">
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
										<th> Actions </th>
									</tr>
								</thead>
								<tbody>
									@foreach($employees as $employee)
										<tr>
											<td>{{$employee->firstname}} {{$employee->lastname}}</td>
											<td>{{$employee->gross_salary}}</td>
											<td>{{$employee->bonus}}</td>
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
												<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit{{ $employee->id }}" title="Add Bonus"> <i class="fas fa-plus text-white"></i></a>
											</td>
										</tr>
										<div class="modal fade" id="edit{{ $employee->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<form action="{{route('salary.bonus',['id'=>$employee->id])}}" method="post">
														{{ csrf_field() }}
														<div class="modal-header">
                                                            <h4 class="modal-title">Add Bonus For Employee "{{$employee->firstname}}"</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
														<div class="modal-body">
															<div class="form-group">
																<label class="control-label">Bonus Amount</label>
																<input  type="number" name="bonus" value="{{old('bonus',$employee->bonus)}}" placeholder="Enter Amount Here" class="form-control">
															</div>
														</div>
														<div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal" title="Cancel"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
                                                            <button  type="submit" class="btn btn-primary btn-ok" title="Add Bonus"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-check-circle"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Add</span></button>
														</div>
													</form>
												</div>
											</div>
										</div>
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
          	"responsive": true,
      		"buttons": ["copy", "csv", "excel", "pdf"]
    	}).buttons().container().appendTo('#salary_wrapper .col-md-6:eq(0)');
    });

    $(document).ready(function () {
        $("#month").change(function(e){
            var url = "{{route('salary.show')}}/" + $(this).val();

            if (url) {
                window.location = url;
            }
            return false;
        });
    });
</script>
@stop