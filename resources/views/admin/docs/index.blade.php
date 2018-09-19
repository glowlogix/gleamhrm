@extends('layouts.admin') @section('content')

<div class="panel panel-default">
	<div class="panel-heading text-center">
		<b>Upload Documents</b>
	</div>
	<div class="panel-body">
		<div class="container">

			<br>

			<div class="row">

				<div class="col-md-8">

					<form action="/admin/upload/docs" method="post" enctype="multipart/form-data">

						{{ csrf_field() }}
						<label for="docs">Documents(can attach more than one):</label>
						<br />
						<input type="file" class="form-control" name="docs[]" multiple />
						<br />
						<input type="submit" class="btn btn-primary" value="Upload" />
					</form>


					<table class="table table-striped">

						@if(count($files) > 0)
						<thead>
							<tr>
								<th>FileName</th>
								<th>Status</th>
							</tr>
						</thead>
						@foreach($files as $file)
						<tbody>
							<tr>
								<td>
									<a target="_blank" href="{{asset('storage/public/'.$file->filename)}}">{{ $file->filename }}</a>
								</td>
								<td>
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

										<div class="col-md-4">
											<button type="submit" class="btn btn-xs btn-primary">Change Status</buttton>
										</div>
									</form>

								</td>
							</tr>
						</tbody>
						@endforeach @else
						<p class="text-center">No Documnets Found</p>
						@endif
					</table>

				</div>
				</form>

			</div>

		</div>
	</div>
</div>

	@stop