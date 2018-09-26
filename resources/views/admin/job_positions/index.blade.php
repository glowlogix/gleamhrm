@extends('layouts.admin')  @section('content')
<div class="panel panel-default">
	<div class="panel-heading text-center">
		<div>
			<b style="text-align: center;">Job Positions</b>
		</div>
		<div style="padding-left: 85%;">
			<a href="{{route('job_position.create')}}" class="btn btn-info btn-xs" align="right">
				<span class="glyphicon glyphicon-plus"></span> Add Job Position
			</a>
		</div>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-body">
		<table class="table">
			<thead>
				<th>Name</th>
				<th>Address</th>
				<th>City </th>
				<th></th>
			</thead>
			<tbody class="table-bordered table-hover table-striped">
				@if($job_positions->count() > 0) @foreach($job_positions as $job_position)
				<tr>
					<td>
						<a href="{{route ('singleCategoryJobs',['id' =>$job_position->id])}}">{{$job_position->name}}</a>
					</td>
					<td>
						{{$job_position->address}}
					</td>
					<td>
						{{$job_position->city}}
					</td>
					<td>
						<div class="col-md-2">
							<a class="btn btn-danger btn-sm" href="{{route('job_position.delete',['id' => $job_position->id])}}"> 
								<span class="glyphicon glyphicon-trash"></span>
							 </a>
					    </div>
						<div class="col-md-2">
							<a class="btn btn-info btn-sm" href="{{route ('job_position.edit',['id'=>$job_position->id])}}">
								<span class="glyphicon glyphicon-edit"></span>
							</a>
						</div>
					</td>
				</tr>
				@endforeach @else
				<tr> No Job Postion found.</tr>
				@endif
			</tbody>
		</table>
	</div>
</div>

@stop