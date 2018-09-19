@extends('layouts.admin')  @section('content')

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