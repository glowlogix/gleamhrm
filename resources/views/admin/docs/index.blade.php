@extends('layouts.admin')
@section('Heading')
	<button type="button" class="btn btn-info btn-rounded m-t-10 float-right" onclick="window.location.href='{{route('documents.create')}}'" data-toggle="modal" data-target="#add-contact"><span class="fas fa-plus" ></span> Add New Document</button>
	<h3 class="text-themecolor">Documents</h3>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
		<li class="breadcrumb-item active">Settings</li>
		<li class="breadcrumb-item active">Documents</li>
	</ol>
@stop
@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h6 class="card-subtitle"></h6>
					<div class="table">
						<table id="demo-foo-addrow" class="table table-box m-t-20 table-hover contact-list" data-paging="true" data-paging-size="7">
							@if(count($files) > 0)
							<thead>
							<tr>
								<th>Document Name</th>
								<th>Status</th>
								@if(Auth::user()->hasRole('admin'))
								<th>Action</th>
								@endif
							</tr>
							</thead>
								@foreach($files as $file)
							<tbody>
								<td>
									<a  target="_blank" href="{{asset($file->url)}}">{{ $file->name }}</a>
								</td>
								<td>
									{{ ($file->status == 1) ? 'Active' : 'Inactive' }}
								</td>
								@if(Auth::user()->hasRole('admin'))
								<td class="row">
									<div class="col-sm-2">
										<form action="{{ route('documents.delete' , $file->id )}}" method="post">
											{{ csrf_field() }}
											<button class="btn btn-danger btn-sm">
												<span class="fas fa-window-close"></span>
											</button>
										</form>
									</div>
									<div class="col-sm-2">
										<a class="btn btn-info btn-sm" href="{{route('documents.edit',['id'=>$file->id])}}">
											<span class="fas fa-pencil-alt"></span>
										</a>
									</div>
								</td>
								@endif
							@endforeach
							@else
							<p class="text-center" style="margin-top:70px;" >No Document Found</p>
							@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop



