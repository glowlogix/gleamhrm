@extends('layouts.admin') @section('content')

<div class="panel panel-default">

	<div class="panel-heading text-center">
		<div>
			<b style="text-align: center;">Export Salary</b>
		</div>
	</div>
	<div class="row">

		<div class="col-md-6" style="padding-top:20px;">

			<form action="{{route('salary.export')}}" method="post">
				{{csrf_field()}}
				<div class="form-group">
					<div class="col-md-6">
						<label for="start_date">Start Date</label>
						<div class='input-group date' id='start_date' name="start_date">
							<input type='text' class="form-control" name="start_date" />
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
						</div>
						<br>
					</div>
					<div class="col-md-6">
						<label for="end_date">End Date</label>
						<div class='input-group date' id='end_date' name="end_date">
							<input type='text' class="form-control" name="end_date" />
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
						</div>
						<br>
						<button class="btn btn-info" type="submit">Export Salary</button>

					</div>

				</div>


			</form>
		</div>
		<div class="panel-body">

		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function () {

			$(function () {
				$('#start_date').datetimepicker({
					viewMode: 'years',
					format: 'YYYY/MM/DD'
				});
				$('#end_date').datetimepicker({
					viewMode: 'years',
					format: 'YYYY/MM/DD'
				});
			});
		});
	</script>
</div>

@stop