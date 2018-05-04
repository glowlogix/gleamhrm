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
						<br />
						<label for="document_name">Enter Document Name:</label>
						<input type="text" class="form-control" placeholder="Enter Document Name" name="document_name">
						<br>
						<label for="documents">Documents(can attach more than one):</label>

						<input type="file" class="form-control" name="documents[]" multiple />

						<br />
						<input type="submit" class="btn btn-primary" value="Upload" />
					</form>		
				</div>
			</div>
		</div>
	</div>
</div>

@stop