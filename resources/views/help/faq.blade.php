@extends('layouts.master')

@section('content')
<!-- Breadcrumbs Start -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">FAQ's</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('faq') }}">Help</a></li>
          <li class="breadcrumb-item active">FAQ's</li>
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
        <div class="card card-primary card-outline card-tabs">
            <div class="d-flex pt-2 pb-2 pl-3 pr-3 justify-content-between">
                @if(Auth::user()->isAllowed('FaqController:faqCategoryStore'))
                    <div>
                        <button type="button" class="btn btn-info btn-rounded" title="Add FAQ Category" data-toggle="modal" data-target="#createFaqCategory"><i class="fas fa-plus"></i><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Add FAQ Category</span></button>
                    </div>
                @endif

                @if(Auth::user()->isAllowed('FaqController:store'))
                    <div>
                        <button type="button" class="btn btn-info btn-rounded" data-toggle="modal" data-target="#createFaq" title="Add FAQ"><i class="fas fa-plus"></i><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Add FAQ</span></button>
                    </div>
                @endif
            </div>

            @if(Auth::user()->isAllowed('FaqController:faqCategoryStore') || Auth::user()->isAllowed('FaqController:store'))
                <hr class="mt-0">
            @endif

            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                    @php $count = 1; @endphp
                    @foreach($faq_categories as $faq_category)
                        @if($faq_category->faqs != '[]')
                            <li class="nav-item">
                                <a class="nav-link @if($count == 1) active @endif" id="custom-tabs-three-{{$faq_category->name}}-tab" data-toggle="pill" href="#{{$faq_category->name}}-tab" role="tab" aria-controls="{{$faq_category->name}}-tab" aria-selected="true">{{$faq_category->name}}</a>
                            </li>
                            @php $count++; @endphp
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                    @php $count = 1; @endphp
                    @foreach($faq_categories as $faq_category)
                        <div class="tab-pane fade @if($count == 1) show active @endif" id="{{$faq_category->name}}-tab" role="tabpanel" aria-labelledby="custom-tabs-three-{{$faq_category->name}}-tab">
                            @foreach($faq_category->faqs as $key => $faq)
                                <div class="row">
                                    <div class="col-12" id="accordion">
                                        <div class="card card-primary card-outline">
                                            <a class="d-block w-100" data-toggle="collapse" href="#collapse{{$key+1}}">
                                                <div class="d-flex card-header justify-content-between">
                                                    <h4 class="card-title w-100">
                                                        {{$key+1}}. {{$faq->question}}
                                                    </h4>
                                                    <div class="d-flex">
                                                        @if(Auth::user()->isAllowed('FaqController:update'))
                                                            <button type="button" class="btn btn-sm btn-warning btn-rounded ml-1 mr-1" title="Edit FAQ" data-toggle="modal" data-target="#editFaq{{$faq->id}}"><i class="fas fa-pencil-alt text-white"></i></button>
                                                        @endif

                                                        @if(Auth::user()->isAllowed('FaqController:destroy'))
                                                            <button type="button" class="btn btn-sm btn-danger btn-rounded" title="Delete FAQ" data-toggle="modal" data-target="#deleteFaq{{$faq->id}}"><i class="fas fa-trash-alt"></i></button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </a>
                                            <div id="collapse{{$key+1}}" class="collapse" data-parent="#accordion">
                                                <div class="card-body">
                                                    {{$faq->answer}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="editFaq{{$faq->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form id="editFaqForm{{$faq->id}}" action="{{route('faq.update')}}" method="post">
                                                {{ csrf_field() }}
                                                <input type="text" name="faq_id" value="{{$faq->id}}" hidden>
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Update FAQ</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label class="control-label">Question<span class="text-danger">*</span></label>
                                                        <input  type="text" name="question" placeholder="Enter question here" class="form-control" value="{{$faq->question}}" id="question{{$faq->id}}" oninput="check('question'+{!! $faq->id !!});">
                                                        <span id="question-error{{$faq->id}}" class="error invalid-feedback">Question is required</span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Answer<span class="text-danger">*</span></label>
                                                        <textarea rows="5" name="answer" placeholder="Enter answer here" class="form-control" id="answer{{$faq->id}}" oninput="check('answer'+{!! $faq->id !!});">{{$faq->answer}}</textarea>
                                                        <span id="answer-error{{$faq->id}}" class="error invalid-feedback">Answer is required</span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">FAQ Category<span class="text-danger">*</span></label>
                                                        <select name="category" class="form-control" id="category{{$faq->id}}" oninput="check('category'+{!! $faq->id !!});">
                                                            <option value="">Select Category</option>
                                                            @foreach($faq_categories as $faq_category)
                                                                <option value="{{$faq->id}}" @if($faq_category->id == $faq->category_id) selected @endif>{{$faq_category->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span id="category-error{{$faq->id}}" class="error invalid-feedback">Category is required</span>
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal" title="Cancel"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
                                                    <button type="button" class="btn btn-primary btn-ok" title="Update FAQ" onclick="validate({!! $faq->id !!});"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-check-circle"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Update</span></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="deleteFaq{{$faq->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{route('faq.destroy')}}" method="post">
                                                {{ csrf_field() }}
                                                <input type="text" name="faq_id" value="{{$faq->id}}" hidden>
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Delete FAQ</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this FAQ?
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal" title="Cancel"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
                                                    <button  type="submit" class="btn btn-danger btn-ok" title="Delete FAQ"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-trash-alt"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Delete</span></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @php $count++; @endphp
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="createFaqCategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="createFaqCategoryForm" action="{{route('faq.category.store')}}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h4 class="modal-title">Create FAQ Category</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">Name<span class="text-danger">*</span></label>
                            <input  type="text" name="category_name" placeholder="Enter Category Name" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal" title="Cancel"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
                        <button  type="submit" class="btn btn-primary btn-ok" title="Create FAQ Category"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-check-circle"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Create</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="createFaq" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="createFaqForm" action="{{route('faq.store')}}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h4 class="modal-title">Create FAQ</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">Question<span class="text-danger">*</span></label>
                            <input  type="text" name="question" placeholder="Enter question here" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Answer<span class="text-danger">*</span></label>
                            <textarea rows="5" name="answer" placeholder="Enter answer here" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label">FAQ Category<span class="text-danger">*</span></label>
                            <select  name="category" class="form-control">
                                    <option value="">Select Category</option>
                                @foreach($faq_categories as $faq_category)
                                    <option value="{{$faq_category->id}}">{{$faq_category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal" title="Cancel"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
                        <button  type="submit" class="btn btn-primary btn-ok" title="Create FAQ"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-check-circle"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Create</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Main Content End -->

<script>
    $(function () {
        $('#createFaqCategoryForm').validate({
            rules: {
                category_name: {
                    required: true
                }
            },
            messages: {
                category_name: "Category name is required"
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });

    $(function () {
        $('#createFaqForm').validate({
            rules: {
                question: {
                    required: true
                },
                answer: {
                    required: true
                },
                category: {
                    required: true
                }
            },
            messages: {
                question: "Question is required",
                answer: "Answer is required",
                category: "Category is required"
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });

    function validate(id)
    {
        if($("#question"+id).val() == '')
        {
            $('#question-error'+id).addClass('show');
            $('#question'+id).addClass('is-invalid');
        }

        if($("#answer"+id).val() == '')
        {
            $('#answer-error'+id).addClass('show');
            $('#answer'+id).addClass('is-invalid');
        }

        if($("#category"+id).val() == '')
        {
            $('#category-error'+id).addClass('show');
            $('#category'+id).addClass('is-invalid');
        }

        if($("#question"+id).val() != '' && $("#answer"+id).val() != '' && $("#category"+id).val() != '')
        {
            $('#editFaqForm'+id).submit();
        }
    }

    function check(id)
    {
        if($('#'+id).val() != '')
        {
            $('#'+id).removeClass('show');
            $('#'+id).removeClass('is-invalid');
        }
        else
        {
            $('#'+id).addClass('show');
            $('#'+id).addClass('is-invalid');
        }
    }
</script>
@stop