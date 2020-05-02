<script src="{{ mix('/js/app.js') }}"></script>
@yield('scripts')
@stack('scripts')
{{--<script src="{{asset('assets/plugins/html5-editor/wysihtml5-0.3.0.js')}}"></script>--}}
<script src="{{asset('js/bootstrap-wysihtml5.js')}}"></script>
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