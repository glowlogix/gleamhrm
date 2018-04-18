@extends('layouts.admin')
@section('content')

<div class="panel panel-default">
	<div class="panel-heading text-center">
		<b>Upload Documents</b>
	</div>
	<div class="panel-body">
    <div class="container">

<br>

<div class="row">

<div class="col-md-6">

<form action="/admin/upload/docs" method="post" enctype="multipart/form-data">

{{ csrf_field() }}

<label for="docs">Documents(can attach more than one):</label>

<br />

<input type="file" class="form-control" name="docs[]" multiple />

<br /><br />

<input type="submit" class="btn btn-primary" value="Upload" />

</form>

</div>

</div>

    </div>
</div>

@stop