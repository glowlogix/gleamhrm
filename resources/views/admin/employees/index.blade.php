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
                {{--<div class="dropdown">--}}
                    {{--<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
                        {{--@if(request()->is('employees'))--}}
                       {{--Active Employees--}}
                        {{--@elseif(request()->is('all_employees'))--}}
                        {{--All Employees--}}
                        {{--@endif--}}
                    {{--</button>--}}
                    {{--<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">--}}
                        {{--<a class="dropdown-item"  href="{{url('employees')}}">Active Employees</a>--}}
                        {{--<a class="dropdown-item" href="{{url('all_employees')}}">All Employees</a>--}}
                    {{--</div>--}}
                {{--</div>--}}
                <select class="form-control" id="filter">
                    @if(request()->is('employees'))
                    <option selected>Select Employees</option>
                    @endif
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
                var url = "{{route('employees')}}/" + $(this).val();

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
    $(function () {
        $('#myTable').DataTable();
        $(function () {
            var table = $('#example').DataTable({
                "columnDefs": [{
                    "visible": false,
                    "targets": 2
                }],
                "order": [
                    [2, 'asc']
                ],
                "displayLength": 25,
                "drawCallback": function (settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;
                    api.column(2, {
                        page: 'current'
                    }).data().each(function (group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                            last = group;
                        }
                    });
                }
            });
            // Order by the grouping
            $('#example tbody').on('click', 'tr.group', function () {
                var currentOrder = table.order()[0];
                if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                    table.order([2, 'desc']).draw();
                } else {
                    table.order([2, 'asc']).draw();
                }
            });
        });
    });
</script>
<script src="{{asset('assets/plugins/moment/moment.js')}}"></script>
<script src="{{asset('assets/plugins/footable/js/footable.min.js')}}"></script>
@endpush
@stop
