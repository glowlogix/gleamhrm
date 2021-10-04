@extends('layouts.print')

@section('content')
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
											@if($employee->department != '')
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

							<div class="row pt-2">
								<div class="col-sm-6">
									<div class="bg-dark mt-3">
										<h6 class="pl-2 pt-1 pb-1">
											<i class="fas fa-money-bill"></i> Salary Details
										</h6>
									</div>
									<div class="col-sm-12">
										<h6 class="d-flex justify-content-between pr-5"><b>Gross Salary:</b>@if(isset($employee['salary']->gross_salary)) ${{$employee['salary']->gross_salary}} @else $0 @endif</h6>
									</div>
									<div class="col-sm-12">
										<h6 class="d-flex justify-content-between pr-5"><b>Basic Salary:</b>@if(isset($employee['salary']->basic_salary)) ${{$employee['salary']->basic_salary}} @else $0 @endif</h6>
									</div>
									<div class="col-sm-12">
										<h6 class="d-flex justify-content-between pr-5"><b>Home Allowance:</b>@if(isset($employee['salary']->home_allowance)) ${{$employee['salary']->home_allowance}} @else $0 @endif</h6>
									</div>
									<div class="col-sm-12">
										<h6 class="d-flex justify-content-between pr-5"><b>Medical Allowance:</b>@if(isset($employee['salary']->medical_allowance)) ${{$employee['salary']->medical_allowance}} @else $0 @endif</h6>
									</div>
									<div class="col-sm-12">
										<h6 class="d-flex justify-content-between pr-5"><b>Special Allowance:</b>@if(isset($employee['salary']->special_allowance)) ${{$employee['salary']->special_allowance}} @else $0 @endif</h6>
									</div>
									<div class="col-sm-12">
										<h6 class="d-flex justify-content-between pr-5"><b>Meal Allowance:</b>@if(isset($employee['salary']->meal_allowance)) ${{$employee['salary']->meal_allowance}} @else $0 @endif</h6>
									</div>
									<div class="col-sm-12">
										<h6 class="d-flex justify-content-between pr-5"><b>Conveyance Allowance:</b>@if(isset($employee['salary']->conveyance_allowance)) ${{$employee['salary']->conveyance_allowance}} @else $0 @endif</h6>
									</div>
									<div class="col-sm-12">
										<h6 class="d-flex justify-content-between pr-5"><b>Bonus:</b>@if($employee->bonus != '') ${{$employee->bonus}} @else $0 @endif</h6>
									</div>

									<div class="col-sm-12 bg-dark">
										<h6 class="d-flex justify-content-between pr-5 pt-1 pb-1"><div>Subtotal:</div>${{$subtotal}}</h6>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="bg-dark mt-3">
										<h6 class="pl-2 pt-1 pb-1">
											<i class="fas fa-money-bill"></i> Deductions
										</h6>
									</div>
									<div class="col-sm-12">
										<h6 class="d-flex justify-content-between pr-5"><b>Provident Fund:</b>@if(isset($employee['salary']->pf_deduction)) ${{$employee['salary']->pf_deduction}} @else $0 @endif</h6>
									</div>
									<div class="col-sm-12">
										@php $deduction = $employee->gross_salary - $subtotal; @endphp
										<h6 class="d-flex justify-content-between pr-5"><b>Absents Deduction:</b>
											@if($deduction <= 0)
												$0
											@else
												${{$employee->gross_salary - $subtotal}}
											@endif
										</h6>
									</div>

									@php
										if(isset($employee['salary']->pf_deduction)){
											$gross_deduction = $deduction + $employee['salary']->pf_deduction;
										} else {
											$gross_deduction = $deduction;
										}
									@endphp
									<div class="col-sm-12 bg-dark d-none d-lg-block d-md-block d-sm-block d-xs-none" style="margin-top: 170px;">
										<h6 class="d-flex justify-content-between pr-5 pt-1 pb-1"><div>Gross Deduction:</div>
											${{$gross_deduction}}
										</h6>
									</div>

									<div class="col-sm-12 bg-dark d-lg-none d-md-none d-sm-none d-xs-block">
										<h6 class="d-flex justify-content-between pr-5 pt-1 pb-1"><div>Gross Deduction:</div>
											${{$gross_deduction}}
										</h6>
									</div>
								</div>
							</div>
							<div class="row">
							</div>
							<div class="row pt-2">
								<div class="col-sm-6"></div>
								<?php $tax = 0; $totalTax = $subtotal / 100 * $tax; ?>
								<div class="col-sm-6">
									<div class="col-sm-12">
										<h6 class="d-flex justify-content-between pr-5"><b>Tax ({{$tax}}%):</b>
											${{$totalTax}}
										</h6>
									</div>

									<hr class="mr-2 ml-2">

									@php $netPayable = $subtotal - $totalTax - $gross_deduction; @endphp
									<div class="col-sm-12">
										<h6 class="d-flex justify-content-between pr-5"><b>Net Payable:</b>
											@if($netPayable > 0)
												${{$netPayable}}
											@else
												$0
											@endif
										</h6>
									</div>
									<hr class="mr-2 ml-2">
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

<script>
  window.addEventListener("load", window.print());
</script>
@stop