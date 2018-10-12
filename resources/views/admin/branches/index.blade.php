@extends('layouts.admin')  @section('content')
<div class="panel panel-default">
	<div class="panel-heading text-center">
		<b style="text-align: center;">Branches</b>
			<span style="float: right;">
			<a href="{{route('branch.create')}}" class="btn btn-info btn-xs" align="right">
				<span class="glyphicon glyphicon-plus"></span> Add Branch
			</a>
        </span>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-body">

		<table class="table">
			<thead>
				<th> Name</th>
				<th> Address</th>
				<th> Timing Start</th>
				<th> Timing Off</th>
				<th> Contact No</th>
				<th> Editing </th>
				<th> Deleting </th>
			</thead>
			<tbody class="table-bordered table-hover table-striped">
				@if($branches->count() > 0) 
				@foreach($branches as $branch)
				<tr>
					<td>{{$branch->name}}</td>
					<td>{{$branch->address}}</td>
					<td>{{Carbon\Carbon::parse($branch->timing_start)->format('h:i a')}}</td>
					<td>{{Carbon\Carbon::parse($branch->timing_off)->format('h:i a')}}</td>
					<td>{{$branch->phone_number}}</td>
					<td>
						<a href="{{route('branch.edit',['id'=>$branch->id])}}">Edit</a>
					</td>
					<td>
						<button class="btn btn-default" data-toggle="modal" data-target="#confirm-delete{{ $branch->id }}">Delete</button>

						<div class="modal fade" id="confirm-delete{{ $branch->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						    <div class="modal-dialog">
						        <div class="modal-content">
									<form action="{{ route('branch.destroy' , $branch->id )}}" method="post">
										<input name="_method" type="hidden" value="DELETE">
										{{ csrf_field() }}
							            <div class="modal-header">
							                Are you sure you want to delete this Branch?
							            </div>
							            <div class="modal-footer">
							                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							                <button  type="submit" class="btn btn-danger btn-ok">Delete</button>
							            </div>
									</form>
						        </div>
						    </div>
						</div>

					</td>
				</tr>
				@endforeach @else
				<tr> No Branch found.</tr>
				@endif
			</tbody>
		</table>
	</div>
</div>

@stop