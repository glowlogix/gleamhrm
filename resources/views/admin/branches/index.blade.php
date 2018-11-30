@extends('layouts.admin')
@section('Heading')
	<button type="button" class="btn btn-info btn-rounded m-t-10 float-right" onclick="window.location.href='{{route('branch.create')}}'"><span class="fas fa-plus" ></span> Add Branch</button>
	<h3 class="text-themecolor">Branches</h3>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
		<li class="breadcrumb-item active">Settings</li>
		<li class="breadcrumb-item active">Branches</li>
	</ol>
@stop
@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h6 class="card-subtitle"></h6>
					<div class="table">
						<table id="demo-foo-addrow" class="table  m-t-30 table-hover contact-list" data-paging="true" data-paging-size="7">
							<thead>
							@if($branches->count() > 0)
							<tr>
								<th> Name</th>
								<th> Address</th>
								<th> Timing Start</th>
								<th> Timing Off</th>
								<th> Contact No</th>
								<th> Actions</th>
							</tr>
							</thead>
							<tbody>
								@foreach($branches as $branch)
									<tr>
										<td>{{$branch->name}}</td>
										<td>{{$branch->address}}</td>
										<td>{{Carbon\Carbon::parse($branch->timing_start)->format('h:i a')}}</td>
										<td>{{Carbon\Carbon::parse($branch->timing_off)->format('h:i a')}}</td>
										<td>{{$branch->phone_number}}</td>
										<td class="text-nowrap">
											<a class="btn btn-info btn-sm" href="{{route('branch.edit',['id'=>$branch->id])}}"  data-original-title="Edit"> <i class="fas fa-pencil-alt text-white"></i></a>
											
											<a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirm-delete{{ $branch->id }}"> <i class="fas fa-window-close text-white  "></i> </a>
											<div class="modal fade" id="confirm-delete{{ $branch->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
														<form action="{{ route('branch.destroy' , $branch->id )}}" method="post">
															<input name="_method" type="hidden" value="DELETE">
															{{ csrf_field() }}
															<div class="modal-header">
																Are you sure you want to delete this Branch?
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
																<button  type="submit" class="btn btn-danger btn-ok">Delete</button>
															</div>
														</form>
													</div>
												</div>
											</div>
										</td>

									</tr>
								@endforeach @else
								<tr> No Branch Found</tr>
							@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop