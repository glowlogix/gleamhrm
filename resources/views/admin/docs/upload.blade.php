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
					<form action="{{route('documents.upload')}}" method="post" enctype="multipart/form-data">
						{{ csrf_field() }}
						<br />
						<label for="document_name">Enter Document Name:</label>
						<input type="text" class="form-control" placeholder="Enter Document Name" name="document_name">
						<br>
						<label for="documents">Document:</label>

						<input type="file" class="form-control" name="document" />

						<br />
						
						<a href="{{route('documents')}}" class="btn btn-default">Cancel</a>

						<input type="submit" class="btn btn-primary" value="Upload" />
					</form>		
				</div>
			</div>
		</div>
	</div>
</div>

@stop