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
<!--c3 JavaScript -->
<script src="{{asset('assets/plugins/d3/d3.min.js') }}"></script>
<script src="{{asset('assets/plugins/c3-master/c3.min.js') }}"></script>
<!-- Chart JS -->
<script src="{{asset('js/dashboard1.js') }}"></script>
<script src="{{asset('js/dashboard1.js') }}"></script>

<!-- ============================================================== -->
<!-- Style switcher -->
<!-- ============================================================== -->
<script src="{{asset('assets/plugins/styleswitcher/jQuery.style.switcher.js') }}"></script>
<script src="{{asset('assets/plugins/datatables/datatables.min.js')}}"></script>
@yield('scripts')
@stack('scripts')
<script src="{{asset('assets/plugins/html5-editor/wysihtml5-0.3.0.js')}}"></script>
<script src="{{asset('assets/plugins/html5-editor/bootstrap-wysihtml5.js')}}"></script>
<script>
    $(document).ready(function() {

        $('.textarea_editor').wysihtml5();


    });
</script>
<script src="{{asset('js/validation.js')}}"></script>
<script>
    ! function(window, document, $) {
        "use strict";
        $("input,select,textarea").not("[type=submit]").jqBootstrapValidation(),
            $(".skin-square input").iCheck({
                checkboxClass: "icheckbox_square-green",
                radioClass: "iradio_square-green"
            }),
            $(".touchspin").TouchSpin(), $(".switchBootstrap").bootstrapSwitch();
    }(window, document, jQuery);
</script>