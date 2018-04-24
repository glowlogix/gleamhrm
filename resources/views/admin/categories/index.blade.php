@extends('layouts.admin') @section('title')  {{ config('app.name', 'HRM') }}|{{$title}} @endsection @section('content')
@section('styles')
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

@endsection
@section('scripts2')


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>


@endsection
<div class="panel panel-default">
	<div class="panel-heading text-center">
		<b>Categories</b>
	</div>
	<div class="panel-body">
		<table class="table">
			<tbody class="table-bordered table-hover table-striped">
				@if($categories->count() > 0) @foreach($categories as $category)
				<tr>
					<td>
						<a href="{{route ('singleCategoryJobs',['id' =>$category->id])}}">{{$category->name}}</a>
					</td>
					<td>
						<a href="{{route ('category.edit',['id'=>$category->id])}}"> Edit </a>
					</td>
					<td>
						<a href="{{route('category.delete',['id' => $category->id])}}"> Delete </a>
					</td>
				</tr>
				@endforeach @else
				<tr> No Category found.</tr>
				@endif
			</tbody>
		</table>
	</div>
</div>

@stop