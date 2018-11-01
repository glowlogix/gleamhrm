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
            <h4 class="card-title"><?php  use App\Employee; $count=Employee::where('status','1')->get(); echo count($count)-1;?> Active / {{count($employees)}} Employees</h4>
            <div class="table-responsive m-t-40">
                <table id="myTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile </th>
                        <th>Designation</th>
                        <th>Office</th>
                        <th>Joining Date</th>
                        <th>Employment Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($employees) > 0) @foreach($employees as $employee)
                    <tr>
                        <td>{{$employee->firstname}} {{$employee->lastname}}</td>
                        <td>{{$employee->official_email}}</td>
                        <td>{{$employee->contact_no}}</td>
                        <td>{{isset($designations[$employee->designation]) ? $designations[$employee->designation] : ''}}</td>
                        <td>{{isset($employee->branch) ? $employee->branch->name : ''}}</td>
                        <td>{{$employee->joining_date}}</td>
                        <td>{{$employee->employment_status}}</td>
                        <td class="text-nowrap">
                            {{--<a class="btn btn-danger btn-sm"  data-toggle="modal" data-target="#confirm-delete{{ $employee->id }}"> <i class="fas fa-window-close text-white"></i></a>--}}

                            {{--///End Dialog Box///--}}
                            <a class="btn btn-info btn-sm" href="{{route('employee.edit',['id'=>$employee->id])}}" data-toggle="tooltip" data-original-title="Edit"> <i class="fas fa-pencil-alt text-white "></i></a>
                        </td>
                    </tr>
                    @endforeach @else
                        <tr> No Employee Found.</tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="confirm-delete{{ $employee->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('employee.destroy' , $employee->id )}}" method="post">
                        {{ csrf_field() }}
                        <div class="modal-header">
                            Are you sure you want to delete Employee {{ $employee->firstname }}?
                        </div>
                        <div class="modal-body">
                            <label>Admin Password</label>
                            <div class="col-md-12 m-b-20">
                                <input type="text" class="form-control" placeholder="Admin Password" name="password" required> </div>
                            <div class="card-body">
                                <div class="demo-checkbox">
                                    <input type="hidden" name="invite_to_asana" value="0" />
                                    <input type="checkbox" id="basic_checkbox_1"  type="checkbox" class="asana" name="invite_to_asana" value="1" {{($employee->invite_to_asana == 1) ? 'checked' : ''}}/>
                                    <label for="basic_checkbox_1">Asaana</label>
                                    <input type="hidden" class="form-control" name="asana_email" value="{{$employee->official_email}}">
                                    <input type="hidden" name="invite_to_slack" value="0" />
                                    <input type="checkbox" id="basic_checkbox_2"  type="checkbox" class="zoho" name="invite_to_slack" value="1" {{($employee->invite_to_slack == 1) ? 'checked' : ''}}/>
                                    <label for="basic_checkbox_2">Slack</label>
                                    <br>
                                    <input type="hidden" name="invite_to_zoho" value="0" />
                                    <input type="checkbox" id="basic_checkbox_3"  type="checkbox" class="zoho" name="invite_to_zoho" value="1" {{($employee->invite_to_zoho == 1) ? 'checked' : ''}} />
                                    <label for="basic_checkbox_3">zoho</label>
                                    <div id="div_zoho_{{$employee->id}}"
                                         @if($employee->invite_to_zoho == 0)
                                         style="display: none;"
                                            @endif>
                                        <input type="password" class="form-control" placeholder="Enter Zoho Password" name="zoho_password">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button  type="submit" class="btn btn-danger btn-ok">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@push('scripts')
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
