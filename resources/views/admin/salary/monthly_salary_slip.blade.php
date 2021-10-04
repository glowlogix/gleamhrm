@extends('layouts.master')

@section('content')
<!-- Breadcrumbs Start -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Show Salary Slip</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="{{ url('salary') }}">Salary Slips</a></li>
					<li class="breadcrumb-item active">Show</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<!-- Breadcrumbs End -->

<!-- Main Content Start -->
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<div class="col-12 text-center">
							<h4>
								@if(isset($platform->logo))
							        <img src="{{ asset($platform->logo) }}" alt="Logo" width="40px">
							    @else
							        <img src="{{ asset('assets/images/company_logo.png') }}" alt="Logo" class="brand-image elevation-3 bg-white" width="80px">
							    @endif

       							HRM | @if(isset($platform->name)) {{$platform->name}} @else Company Name @endif
							</h4>
						</div>

						<hr>

						@foreach($employees as $employee)
							<div class="bg-dark">
								<h6 class="pl-2 pt-1 pb-1">
									<i class="fas fa-user fa-sm"></i> Employee Details
								</h6>
							</div>
							<div class="row pt-2">
								<div class="col-sm-6">
									<div class="row">
										<h6 class="col-4"><b>Name:</b></h6>
										<h6 class="col-8">{{$employee->firstname}} {{$employee->lastname}}</h6>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="row">
										<h6 class="col-4"><b>Department:</b></h6>
										<h6 class="col-8">
											@if($employee->department_id != '')
												@foreach($departments as $department)
													@if($department->id == $employee->department_id)
														{{$department->department_name}}
													@endif
												@endforeach
											@else
												N/A
											@endif
										</h6>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="row">
										<h6 class="col-4"><b>Designation:</b></h6>
										<h6 class="col-8">@if($employee->designation != ''){{$employee->designation}} @else N/A @endif</h6>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="row">
										<h6 class="col-4"><b>Salary Month:</b></h6>
										<h6 class="col-8">{{$month}}</h6>
									</div>
								</div>
							</div>

							<div class="bg-dark mt-3">
								<h6 class="pl-2 pt-1 pb-1">
									<i class="fas fa-id-card fa-sm"></i> Contact Details
								</h6>
							</div>
							<div class="row pt-2">
								<div class="col-sm-6">
									<div class="row">
										<h6 class="col-4"><b>Contact No:</b></h6>
										<h6 class="col-8">@if($employee->contact_no != '') {{$employee->contact_no}} @else N/A @endif</h6>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="row">
										<h6 class="col-4"><b>Emergency No:</b></h6>
										<h6 class="col-8">@if($employee->emergency_contact != '') {{$employee->emergency_contact}} @else N/A @endif</h6>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="row">
										<h6 class="col-4"><b>Official Email:</b></h6>
										<h6 class="col-8">@if($employee->official_email != '') {{$employee->official_email}} @else N/A @endif</h6>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="row">
										<h6 class="col-4"><b>Personal Email:</b></h6>
										<h6 class="col-8">@if($employee->personal_email != '') {{$employee->personal_email}} @else N/A @endif</h6>
									</div>
								</div>
							</div>

							<table style="width: 100%;">
								<tr>
									<td class="col-sm-6 pl-0">
										<div class="bg-dark mt-3">
											<h6 class="pl-2 pt-1 pb-1">
												<i class="fas fa-money-bill"></i> Salary Details
											</h6>
										</div>
									</td>
									<td class="col-sm-6 pl-0">
										<div class="bg-dark mt-3">
											<h6 class="pl-2 pt-1 pb-1">
												<i class="fas fa-money-bill"></i> Deductions
											</h6>
										</div>
									</td>
								</tr>
								<tr>
									<td>
										<div class="col-sm-12 pl-0">
											<h6 class="d-flex justify-content-between pr-3"><b>Gross Salary:</b>@if(isset($employee['salary']->gross_salary)) ${{$employee['salary']->gross_salary}} @else $0 @endif</h6>
										</div>
										<div class="col-sm-12 pl-0">
											<h6 class="d-flex justify-content-between pr-3"><b>Basic Salary:</b>@if(isset($employee['salary']->basic_salary)) ${{$employee['salary']->basic_salary}} @else $0 @endif</h6>
										</div>
										@if(isset($employee['salary']->home_allowance))
											<div class="col-sm-12 pl-0">
												<h6 class="d-flex justify-content-between pr-3"><b>Home Allowance:</b>
													${{$employee['salary']->home_allowance}}
												</h6>
											</div>
										@endif
										@if(isset($employee['salary']->medical_allowance))
											<div class="col-sm-12 pl-0">
												<h6 class="d-flex justify-content-between pr-3"><b>Medical Allowance:</b>
													${{$employee['salary']->medical_allowance}}
												</h6>
											</div>
										@endif
										@if(isset($employee['salary']->special_allowance))
											<div class="col-sm-12 pl-0">
												<h6 class="d-flex justify-content-between pr-3"><b>Special Allowance:</b>${{$employee['salary']->special_allowance}}
												</h6>
											</div>
										@endif
										@if(isset($employee['salary']->meal_allowance))
											<div class="col-sm-12 pl-0">
												<h6 class="d-flex justify-content-between pr-3"><b>Meal Allowance:</b>
													${{$employee['salary']->meal_allowance}}
												</h6>
											</div>
										@endif
										@if(isset($employee['salary']->conveyance_allowance))
											<div class="col-sm-12 pl-0">
												<h6 class="d-flex justify-content-between pr-3"><b>Conveyance Allowance:</b>
													${{$employee['salary']->conveyance_allowance}}
												</h6>
											</div>
										@endif
										<div class="col-sm-12 pl-0">
											<h6 class="d-flex justify-content-between pr-3"><b>Bonus:</b>@if($employee->bonus != '') ${{$employee->bonus}} @else $0 @endif</h6>
										</div>
									</td>
									<td style="position: relative;">
										<div class="col-sm-12 pl-0" style="position: absolute; top: 0;">
											<div>
												<h6 class="d-flex justify-content-between pr-3"><b>Provident Fund:</b>@if(isset($employee['salary']->pf_deduction)) ${{$employee['salary']->pf_deduction}} @else $0 @endif</h6>
											</div>
											<div>
												@php $deduction = $employee->gross_salary - $subtotal; @endphp
												<h6 class="d-flex justify-content-between pr-3"><b>Absents Deduction:</b>
													@if($deduction <= 0)
														$0
													@else
														${{$employee->gross_salary - $subtotal}}
													@endif
												</h6>
											</div>
										</div>
									</td>
								</tr>

								@php
									if(isset($employee['salary']->pf_deduction)){
										$gross_deduction = $deduction + $employee['salary']->pf_deduction;
									} else {
										$gross_deduction = $deduction;
									}
								@endphp
								<tr>
									<td class="col-sm-6 pl-0">
										<div class=" bg-dark">
											<h6 class="d-flex justify-content-between pl-1 pr-3 pt-1 pb-1"><div>Subtotal:</div>${{$subtotal}}</h6>
										</div>
									</td>
									<td class="col-sm-6 pl-0">
										<div class="bg-dark">
											<h6 class="d-flex justify-content-between pl-1 pr-3 pt-1 pb-1"><div>Gross Deduction:</div>
												${{$gross_deduction}}
											</h6>
										</div>
									</td>
								</tr>
							</table>
							<div class="row">
							</div>
							<div class="row pt-2">
								<div class="col-sm-6"></div>
								<?php $tax = 0; $totalTax = $subtotal / 100 * $tax; ?>
								<div class="col-sm-6">
									<div>
										<h6 class="d-flex justify-content-between pr-4"><b>Tax ({{$tax}}%):</b>
											${{$totalTax}}
										</h6>
									</div>

									<hr class="mr-2">

									@php $netPayable = $subtotal - $totalTax - $gross_deduction; @endphp
									<div>
										<h6 class="d-flex justify-content-between pr-4"><b>Net Payable:</b>
											@if($netPayable > 0)
												${{$netPayable}}
											@else
												$0
											@endif
										</h6>
									</div>
									<hr class="mr-2">
								</div>
							</div>
							<div class="row no-print pt-3">
								<div class="col-12 text-right">
									<a href="{{ route('salary.slip',['generate', $month, $employee->id]) }}" rel="noopener" target="_blank" class="btn btn-primary"><i class="fas fa-print"></i> Generate PDF</a>
									<a href="{{ route('salary.slip',['print', $month, $employee->id]) }}" rel="noopener" target="_blank" class="btn btn-primary"><i class="fas fa-print"></i> Print</a>
								</div>
							</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Main Content End -->
@stop