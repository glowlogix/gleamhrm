@extends('layouts.docs') 

@section('styles')
<link href="{{ asset('css/data.css') }}" rel="stylesheet">
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('css/toastr.min.css')}}">
@endsection

@section('scripts')
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/toastr.min.js')}}"></script>
@endsection

@section('messages')
<script>
@if(Session::has('success'))
toastr.success("{{Session::get('success')}}")
@endif
@if(Session::has('info'))
toastr.info("{{Session::get('info')}}")
@endif
<script>
@endsection

@section('messages2')
@if(Session::has('success'))
<div class="alert alert-success">
    <a href="#" class="close" data-dismiss="alert">&times;</a>
    <strong>Success!</strong> {{Session::get('success')}}
</div>
@endif
@endsection