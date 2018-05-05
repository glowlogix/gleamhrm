@extends('layouts.admin') @section('content') 

<div class="panel panel-default">
	<div class="panel-heading text-center">
		<b>All Documents</b>
		<span style="float: right;">
			<a href="{{route('documents.docs.upload')}}" class="btn btn-info btn-xs" align="left">
				<span class="glyphicon glyphicon-plus"></span> Add Document
			</a>
		</span>
	</div>
	<div class="panel-body">
		<div class="container">
			<br>
			<div class="row">
				<div class="col-md-8">
					<table class="table">

						@if(count($files) > 0)
						<thead>
							<tr>
								<th>Document Name</th>
								{{-- <th style="padding-left:5%;">Status</th> --}}
								<th style="position:relative;left:6%">Action</th>
							</tr>
						</thead>
						@foreach($files as $file)
						<tbody>
							<tr>
								<td>
									<a target="_blank" href="{{asset('storage/public/'.$file->url)}}">{{ $file->name }}</a>
								</td>
								{{-- <td>
									<form method="POST" action="{{route('documents.status',$file->id)}}">
										{{ csrf_field() }}
										<div class="col-md-7">
											<select name="upload_status" id="upload_status" class="form-control">
												@if($file->status == 1)
												<option selected value="1">Enable</option>
												<option value="0">Disable</option>
												@else
												<option value="1">Enable</option>
												<option selected value="0">Disable</option>
												@endif
											</select>
										</div>
										<button type="submit" class="btn btn-xs btn-primary">Change Status</buttton>
								</td> --}}
								<td>
									<div class="col-sm-2">
											
										<form action="{{ route('documents.docs.delete' , $file->id )}}" method="post">
											{{ csrf_field() }}
											<button class="btn btn-danger btn-sm">
												<span class="glyphicon glyphicon-trash"></span>
											</button>
										</form>
									</div>
									<div class="col-sm-1">
											<a class="btn btn-info btn-sm" href="{{route('documents.docs.edit',['id'=>$file->id])}}">
												<span class="glyphicon glyphicon-edit"></span>
											</a>
									</div>
								</td>
							</tr>
						</tbody>
						@endforeach @else
						<p class="text-center">No Documnets Found</p>
						@endif
					</table>				
				</div>
			</div>
		</div>
	</div>
</div>

@stop