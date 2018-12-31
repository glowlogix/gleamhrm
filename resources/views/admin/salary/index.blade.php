@extends('layouts.admin')
@section('Heading')
	<h3 class="text-themecolor">Salary</h3>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
		<li class="breadcrumb-item active">Payments</li>
		<li class="breadcrumb-item active">Salary</li>
	</ol>
@stop
@section('content')
	<div class="card">
		<div class="card-body">
			<div class="float-right">
				<input id="month" class="form-control" value="{{$month}}" type="month">
			</div>
			<h4 class="card-title">Salaries</h4>
			<h6 class="card-subtitle">Employee Salaries</h6>
			<div class="table-responsive m-t-40">
				<table id="myTable" class="table table-bordered table-striped">
					<thead>
					@if(count($employees) > 0)
					<tr>
						<th>Employee Name</th>
						<th>Basic Salary</th>
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
						<td>{{$employee->basic_salary}}</td>
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
							<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit{{ $employee->id }}"   data-original-title="Add Bonus"> <i class="fas fa-pencil-alt text-white"></i></a>
							<div class="modal fade" id="edit{{ $employee->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<form action="{{route('salary.bonus',['id'=>$employee->id])}}" method="post">
											{{ csrf_field() }}
											<div class="modal-header">
												 Add Bonus For Employee :  {{$employee->firstname}}
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label class="control-label">Bonus Amount</label>
													<input  type="number" name="bonus" value="{{old('bonus',$employee->bonus)}}" placeholder="Enter Amount Here" class="form-control">
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
												<button  type="submit" class="btn btn-success btn-ok">Save</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</td>
						</tr>
					@endforeach
					@else
						<p style="text-align: center;">No Employees Found</p> @endif
					</tbody>
				</table>
			</div>
		</div>
	</div>
@push('scripts')
	<!-- This is data table -->
	<script src="{{asset('assets/plugins/datatables/datatables.min.js')}}"></script>
	<!-- start - This is for export functionality only -->
	<script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
	<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
	<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
	<!-- end - This is for export functionality only -->
	<script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                stateSave: true,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copyHtml5',
                        exportOptions: {
                            columns: [ 0, 1, 2,3,4,5,6,7]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [ 0, 1, 2,3,4,5,6,7]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: [ 0, 1, 2,3,4,5,6,7]
                        }
                    }, {
                        extend: 'csvHtml5',
                        exportOptions: {
                            columns: [ 0, 1, 2,3,4,5,6,7]
                        }
                    },
                ]
            });
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
	@endpush
@stop