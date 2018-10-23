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
        <!-- Accordian -->
        <div class="accordion" id="accordionTable">
            <div class="card-header" id="heading1">
                <h5 class="mb-0 text-blue">{{$active_employees}} Active / {{$employees->count()}} Employees</h5>
            </div>
            <div id="col1" class="collapse show" aria-labelledby="heading1" data-parent="#accordionTable">
                <div class="card-body">
                    <div class="table">
                        <table id="demo-foo-accordion" class="table table-bordered m-b-0 table-hover toggle-arrow-tiny" data-filtering="true" data-paging="true" data-sorting="true" data-paging-size="7">
                            <thead>
                            <tr class="footable-filtering">
                                <th>Name</th>
                                <th>City</th>
                                <th>Branch</th>
                                <th>Time in</th>
                                <th>Time Out</th>
                                <th>Total Time</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($employees) > 0) @foreach($employees as $employee)
                                <tr>
                                    <td>{{$employee['firstname']}} {{$employee['lastname']}}</td>
                                    <td>{{$employee['city']}}</td>
                                    <td>{{isset($employee['branch']) ? $employee['branch']['name'] : ''}}</td>
                                    <td>{{isset($employee['attendanceSummary'][0]) ? Carbon\Carbon::parse($employee['attendanceSummary'][0]['first_time_in'])->format('h:i a') : ''}}</td>
                                    <td>{{isset($employee['attendanceSummary'][0]) ? Carbon\Carbon::parse($employee['attendanceSummary'][0]['last_time_out'])->format('h:i a') : ''}}</td>
                                    <td>{{isset($employee['attendanceSummary'][0]) ? number_format(($employee['attendanceSummary'][0]['total_time'] / 60), 2, '.', '') : ''}}</td>
                                    <td class="text-nowrap">

                                        <a class="btn btn-info btn-sm" data-toggle="modal" data-target="#popup{{ $employee['id'] }}" data-original-title="Edit"> <i class="fas fa-pencil-alt text-white"></i></a>
                                        

                                        {{--///Dialog Box/// --}}
                                        <div class="modal fade" id="popup{{ $employee['id'] }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{route('attendance.storeAttendanceSummaryToday')}}" method='POST'>
                                                        {{ csrf_field() }}
                                                        <div class="modal-header">
                                                            Adding attendance for Employee {{$employee['firstname']}} {{$employee['lastname']}}
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="container-fluid">
                                                                <div class="col-md-6">
                                                                    <label for="date">Select Date</label></br>
                                                                    <div class="input-group date1">
                                                                        <input type="hidden" name="employee_id" value="{{$employee['id']}}" />
                                                                        <input class="form-control" name="date" value="{{isset($employee['attendanceSummary'][0]) ? Carbon\Carbon::parse($employee['attendanceSummary'][0]['date'])->format('Y-m-d') : Carbon\Carbon::now()->format('Y-m-d')}}" />
                                                                        <span class="input-group-addon">
                                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="time_in">Time In</label>
                                                                    <div class="input-group timepicker">
                                                                        <input class="form-control" name="time_in" value="{{isset($employee['attendanceSummary'][0]) ? Carbon\Carbon::parse($employee['attendanceSummary'][0]['first_time_in'])->format('h:i a') : Carbon\Carbon::now()->format('h:i a')}}" />
                                                                        <span class="input-group-addon">
                                                                            <i class="fa fa-clock-o" style="font-size:16px"></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="time_out">Time Out</label>
                                                                    <div class="input-group timepicker">
                                                                        <input class="form-control" name="time_out" value="{{isset($employee['attendanceSummary'][0]) ? Carbon\Carbon::parse($employee['attendanceSummary'][0]['last_time_out'])->format('h:i a') : Carbon\Carbon::now()->format('h:i a')}}" />
                                                                        <span class="input-group-addon">
                                                                            <i class="fa fa-clock-o" style="font-size:16px"></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-success create-btn" id="add-btn" >Present</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>  
                                        </div>
                                        {{--///End Dialog Box///--}}
                                    </td>
                                </tr>
                            @endforeach @else
                                <tr> No Employee Found.</tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
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

    $(window).on('load', function() {
        // Row Toggler
        // -----------------------------------------------------------------
        $('#demo-foo-row-toggler').footable();

        // Accordion
        // -----------------------------------------------------------------
        $('#demo-foo-accordion').footable().on('footable_row_expanded', function(e) {
            $('#demo-foo-accordion tbody tr.footable-detail-show').not(e.row).each(function() {
                $('#demo-foo-accordion').data('footable').toggleDetail(this);
            });
        });

        // Accordion
        // -----------------------------------------------------------------
        $('#demo-foo-accordion2').footable().on('footable_row_expanded', function(e) {
            $('#demo-foo-accordion2 tbody tr.footable-detail-show').not(e.row).each(function() {
                $('#demo-foo-accordion').data('footable').toggleDetail(this);
            });
        });

        // Pagination & Filtering
        // -----------------------------------------------------------------
        $('[data-page-size]').on('click', function(e){
            e.preventDefault();
            var newSize = $(this).data('pageSize');
            FooTable.get('#demo-foo-pagination').pageSize(newSize);
        });
        $('#demo-foo-pagination').footable();

        $('#demo-foo-addrow').footable();

        var addrow = $('#demo-foo-addrow2');
        addrow.footable().on('click', '.delete-row-btn', function() {

            //get the footable object
            var footable = addrow.data('footable');

            //get the row we are wanting to delete
            var row = $(this).parents('tr:first');

            //delete the row
            footable.removeRow(row);
        });

    });

</script>
<script src="{{asset('assets/plugins/moment/moment.js')}}"></script>
<script src="{{asset('assets/plugins/footable/js/footable.min.js')}}"></script>
@endpush
@stop
