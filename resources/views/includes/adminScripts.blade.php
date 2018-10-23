<!-- All Jquery -->
<!-- ============================================================== -->
<script src="{{asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="{{asset('assets/plugins/popper/popper.min.js') }}"></script>
<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="{{asset('js/jquery.slimscroll.js') }}"></script>
<!--Wave Effects -->
<script src="{{asset('js/waves.js') }}"></script>
<!--Menu sidebar -->
<script src="{{asset('js/sidebarmenu.js') }}"></script>
<!--stickey kit -->
<script src="{{asset('assets/plugins/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
<script src="{{asset('assets/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
<!--Custom JavaScript -->
<script src="{{asset('js/custom.min.js') }}"></script>
<!-- ============================================================== -->
<!-- This page plugins -->
<!-- ============================================================== -->
<!-- chartist chart -->
<script src="{{asset('assets/plugins/chartist-js/dist/chartist.min.js') }}"></script>
<script src="{{asset('assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js') }}../"></script>
<!--c3 JavaScript -->
<script src="{{asset('assets/plugins/d3/d3.min.js') }}"></script>
<script src="{{asset('assets/plugins/c3-master/c3.min.js') }}"></script>
<!-- Chart JS -->
<script src="{{asset('js/dashboard1.js') }}"></script>
<!-- ============================================================== -->
<!-- Style switcher -->
<!-- ============================================================== -->

<script src="{{asset('assets/plugins/styleswitcher/jQuery.style.switcher.js') }}"></script>

<script src="{{asset('bootstrap/bootstrap-datetimepicker.min.js')}}"></script>

@yield('scripts')
@stack('scripts')