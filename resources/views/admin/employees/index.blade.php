@extends('layouts.admin') @section('title') HRM|{{$title}} @endsection
@section('Heading')
    <button type="button"  onclick="window.location.href='{{route('employee.create')}}'" class="btn btn-info btn-rounded m-t-10 float-right"><span class="fas fa-plus" ></span> Add Employee</button>
    <h3 class="text-themecolor">Employees</h3>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
		<li class="breadcrumb-item active">People Management</li>
		<li class="breadcrumb-item active">Employees</li>
	</ol>
@stop
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="float-right">
                <select class="form-control" id="filter">
                    <option value="select">Select Employees</option>
                    @foreach($filters as $filter)
                    <option value="{{$filter}}" @if($filter==$selectedFilter) selected @endif>{{ucfirst(trans($filter))}}</option>
                    @endforeach
                </select>
            </div>
            <h4 class="card-title"> {{$active_employees}}  Active / {{$employees->count()}} Employees</h4>
            <div class="table-responsive m-t-40">
                <table id="myTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        @if(count($employees) > 0)
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile </th>
                        <th>Designation</th>
                        <th>Branch</th>
                        <th>Department</th>
                        <th>Joining Date</th>
                        <th>Employment Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($employees as $employee)
                    <tr>
                        <td>{{$employee->firstname}} {{$employee->lastname}}</td>
                        <td>{{$employee->official_email}}</td>
                        <td>{{$employee->contact_no}}</td>
                        <td>{{ ucfirst(trans($employee->designation))}}</td>
                        {{--<td>{{isset($designations[$employee->designation]) ? $designations[$employee->designation] : ''}}</td>--}}
                        <td>{{isset($employee->branch) ? $employee->branch->name : ''}}</td>
                        <td>{{isset($employee->department) ? $employee->department->department_name : ''}}</td>
                        <td>{{$employee->joining_date}}</td>
                        <td>{{$employee->employment_status}}</td>
                        <td class="text-nowrap">
                            <a class="btn btn-info btn-sm" href="{{route('employee.edit',['id'=>$employee->id])}}" data-toggle="tooltip" data-original-title="Edit"> <i class="fas fa-pencil-alt text-white "></i></a>
                        </td>
                    </tr>
                    @endforeach @else
                        <tr> No Employee Found</tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $("#filter").change(function(e){
                if ($(this).val()=== "select" ){

                    var url = "{{route('employees')}}/"
                }
                else{
                    var url = "{{route('employees')}}/" + $(this).val();
                }

                if (url) {
                    window.location = url;
                }
                return false;
            });
        });
    </script>
<script type="text/javascript">
$("input.zoho").click(function (event) {
    if ($(this).is(":checked")) {
        $("#div_" + event.target.id).show();
    } 
    else {
        $("#div_" + event.target.id).hide();
    }
});
</script>

<script type="text/javascript">
    $("input.zoho").click(function (event) {
        if ($(this).is(":checked")) {
            $("#div_" + event.target.id).show();
        } else {
            $("#div_" + event.target.id).hide();
        }
    });
</script>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            stateSave: true,
        });
    });
</script>
<script src="{{asset('assets/plugins/moment/moment.js')}}"></script>
<script src="{{asset('assets/plugins/footable/js/footable.min.js')}}"></script>
@endpush
@stop
