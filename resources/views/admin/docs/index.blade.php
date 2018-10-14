@extends('layouts.admin')
@section('Heading')
	<h3 class="text-themecolor">Documents</h3>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
		<li class="breadcrumb-item active">Document</li>
	</ol>
@stop
@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h6 class="card-subtitle"></h6>
					<button type="button" class="btn btn-info btn-rounded m-t-10 float-right" onclick="window.location.href='{{route('documents.docs.upload')}}'" data-toggle="modal" data-target="#add-contact">Add New Document</button>

					<div class="table">
						<table id="demo-foo-addrow" class="table table-box m-t-20 table-hover contact-list" data-paging="true" data-paging-size="7">
							@if(count($files) > 0)
							<thead>
							<tr>
								<th>Document Name</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
							</thead>
								@foreach($files as $file)
							<tbody>
								<td>
									<a  target="_blank" href="{{asset('storage/public/'.$file->url)}}">{{ $file->name }}</a>
								</td>
								<td>
									@if($file->status?:'1')
									<p >Active</p>
										@else
										<p>Non Active<P>
									@endif
								</td>
							<td class="row">
							<div class="col-sm-2">

								<form action="{{ route('documents.docs.delete' , $file->id )}}" method="post">
									{{ csrf_field() }}
									<button class="btn btn-danger btn-sm">
										<span class="fas fa-window-close"></span>
									</button>
								</form>
							</div>
							<div class="col-sm-2">
								<a class="btn btn-info btn-sm" href="{{route('documents.docs.edit',['id'=>$file->id])}}">
									<span class="fas fa-pencil-alt"></span>
								</a>
							</div>
							</td>
							@endforeach @else
								<p class="text-center">No Documnets Found</p>
							@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>



@stop






















{{--<div class="panel panel-default">--}}
	{{--<div class="panel-heading text-center">--}}
		{{--<b>All Documents</b>--}}
		{{--<span style="float: right;">--}}
			{{--<a href="{{route('documents.docs.upload')}}" class="btn btn-info btn-xs" align="left">--}}
				{{--<span class="glyphicon glyphicon-plus"></span> Add Document--}}
			{{--</a>--}}
		{{--</span>--}}
	{{--</div>--}}
	{{--<div class="panel-body">--}}
		{{--<div class="container">--}}
			{{--<br>--}}
			{{--<div class="row">--}}
				{{--<div class="col-md-8">--}}
					{{--<form action="{{asset('admin/upload/docs')}}" method="post" enctype="multipart/form-data">--}}

						{{--{{ csrf_field() }}--}}
						{{--<label for="docs">Documents(can attach more than one):</label>--}}
						{{--<br />--}}
						{{--<input type="file" class="form-control" name="docs[]" multiple />--}}
						{{--<br />--}}
						{{--<input type="submit" class="btn btn-primary" value="Upload" />--}}
					{{--</form>--}}

					{{--<table class="table table-striped">--}}

						{{--@if(count($files) > 0)--}}
						{{--<thead>--}}
							{{--<tr>--}}
								{{--<th>Document Name</th>--}}
								{{--<th>Status</th>--}}
								{{--<th style="position:relative;left:6%">Action</th>--}}
							{{--</tr>--}}
						{{--</thead>--}}
						{{--@foreach($files as $file)--}}
						{{--<tbody>--}}
							{{--<tr>--}}
								{{--<td>--}}
									{{--<a target="_blank" href="{{asset('storage/public/'.$file->url)}}">{{ $file->name }}</a>--}}
								{{--</td>--}}
								{{--<td>--}}
									{{--<div class="col-sm-2">--}}
											{{----}}
										{{--<form action="{{ route('documents.docs.delete' , $file->id )}}" method="post">--}}
											{{--{{ csrf_field() }}--}}
											{{--<button class="btn btn-danger btn-sm">--}}
												{{--<span class="glyphicon glyphicon-trash"></span>--}}
											{{--</button>--}}
										{{--</form>--}}
									{{--</div>--}}
									{{--<div class="col-sm-1">--}}
											{{--<a class="btn btn-info btn-sm" href="{{route('documents.docs.edit',['id'=>$file->id])}}">--}}
												{{--<span class="glyphicon glyphicon-edit"></span>--}}
											{{--</a>--}}
									{{--</div>--}}
								{{--</td>--}}
							{{--</tr>--}}
						{{--</tbody>--}}
						{{--@endforeach @else--}}
						{{--<p class="text-center">No Documnets Found</p>--}}
						{{--@endif--}}
					{{--</table>				--}}
				{{--</div>--}}
			{{--</div>--}}
		{{--</div>--}}
	{{--</div>--}}
{{--</div>--}}

{{--@stop--}}