@extends('layouts.master')

@section('content')
<!-- Breadcrumbs Start -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Organization Hierarchy</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('organization_hierarchy') }}">People Management</a></li>
          <li class="breadcrumb-item active">Organization Hierarchy</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!-- Breadcrumbs End -->

<!-- Session Message Section Start -->
@include('layouts.partials.error-message')
<!-- Session Message Section End -->

<!-- Main Content Start -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                    	<div class="text-right">
                    		<button type="button" class="btn btn-info btn-rounded" onclick="window.location.href='{{route('organization_hierarchy.create')}}'" title="Add Organization Hierarchy"><i class="fas fa-plus"></i><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Add Organization Hierarchy</span></button>
                    	</div>

                    	<hr>
						
						<div class="table table-responsive">
							{{--Orgnisation chart--}}
							<div id="chart-container" class="table-responsive">
							</div>

							<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<form id="delete" action="" method="post">
											<input name="_method" type="hidden" value="DELETE">
											{{ csrf_field() }}
											<div class="modal-header">
	                                          	<h4 class="modal-title">Delete Organization Hierarchy</h4>
	                                          	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                                            	<span aria-hidden="true">×</span>
	                                          	</button>
	                                        </div>
											<div class="modal-body">
												Are you sure you want to delete Employee with it's Subordinates from Organization Hierarchy ?
											</div>
											<div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default" data-dismiss="modal" title="Cancel"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
                                                <button  type="submit" class="btn btn-danger btn-ok" title="Delete Organization Hierarchy"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-trash-alt"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Delete</span></button>
											</div>
										</form>
									</div>
								</div>
							</div>
							{{--END Orgnisation chart--}}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Main Content End -->

<script type="text/javascript" src="{{asset('OH/js/jquery.mockjax.min.js')}}"></script>
<script type="text/javascript" src="{{asset('OH/js/jquery.orgchart.js')}}"></script>
<script>
    function assignFormAction(id){
    	$('form#delete').attr('action',  "{{route('organization_hierarchy.index')}}/" + id);
    }
    $(function() {
        $.mockjax({
            url: '/orgchart/initdata',
            responseTime: 1000,
            contentType: 'application/json'
            @if ($hierarchy)
            ,responseText: {!! $hierarchy !!}
            @endif
        });

        $('#chart-container').orgchart({
            'data' : '/orgchart/initdata',
            'nodeContent': 'title',
            'width': '100%',
            'createNode': function($node, data) {
                var secondMenuIcon = $('<li>', {
                    'class': 'fas fa-plus-circle create-menu-icon',
                	'onclick' : "location.href='{{route('organization_hierarchy.create')}}/'",
                    'title' : "Add Organization Hierarchy"
                	// 'onclick' : "location.href='{{route('organization_hierarchy.create')}}/" + data.id+"'"
                });
                $node.append(secondMenuIcon);

                var thirdMenuIcon = $('<li>', {
                    'class': 'fas fa-pencil-alt edit-menu-icon',
                	'onclick' : "location.href='{{route('organization_hierarchy.index')}}/" + data.id+"/edit'",
                    'title' : "Edit Organization Hierarchy"
                });

                $node.append(thirdMenuIcon);

                var deleteIcon = $('<li>', {
                    'class': 'fas fa-trash-alt delete-menu-icon',
                    'data-toggle' : 'modal',
                    'data-target' : '#confirm-delete',
                	'onclick' : "assignFormAction("+data.employee_id+")",
                    'title' : "Delete Organization Hierarchy"
                });

                $node.append(deleteIcon);
            }
        });
    });
</script>


<link rel="icon" href="{{asset('OH/img/logo.png')}}">
<link rel="stylesheet" href="{{asset('OH/css/jquery.orgchart.css')}}">
<style>
    .orgchart{ width: 100% }

    .orgchart .create-menu-icon {
        transition: opacity .5s;
        opacity: 0;
        right: 112px;
        top: -5px;
        z-index: 2;
        color: rgba(68, 157, 68, 0.5);
        font-size: 18px;
        position: absolute;
        color: black;
    }
    .orgchart .create-menu-icon:hover { color:black; }
    .orgchart .node:hover .create-menu-icon { opacity: 1; }
	
	.orgchart .edit-menu-icon {
        transition: opacity .5s;
        opacity: 0;
        right: -5px;
        top: -5px;
        z-index: 2;
        color: rgba(68, 157, 68, 0.5);
        font-size: 18px;
        position: absolute;
        color: black;
    }
    .orgchart .edit-menu-icon:hover { color:black; }
    .orgchart .node:hover .edit-menu-icon { opacity: 1; }

    .orgchart .delete-menu-icon {
        transition: opacity .5s;
        opacity: 0;
        right: -1px;
        top: 30px;
        z-index: 2;
        color: rgba(68, 157, 68, 0.5);
        font-size: 18px;
        position: absolute;
        color: black;
    }
    .orgchart .delete-menu-icon:hover { color:black; }
    .orgchart .node:hover .delete-menu-icon { opacity: 1; }
</style>
@stop