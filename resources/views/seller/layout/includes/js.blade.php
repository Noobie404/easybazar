<script src="{{asset('assets/vendors/js/vendors.js')}}"></script>
<script src="{{asset('assets/vendors/js/forms/icheck/icheck.min.js')}}"></script>
<script src="{{asset('assets/js/core/app-menu.js')}}"></script>
<script src="{{asset('assets/js/core/app.js')}}"></script>
<script src="{{asset('assets/vendors/js/forms/validation/jqBootstrapValidation.js')}}"></script>
<script src="{{asset('assets/js/scripts/forms/validation/form-validation.js')}}"></script>
<script src="{{asset('assets/js/scripts/forms/checkbox-radio.js')}}"></script>
{{-- <script src="{{asset('assets/js/infoBox.js')}}"></script> --}}
{!! Toastr::message() !!}
<script src="{{asset('assets/js/common.js?v=1.1.10')}}"></script>
@stack('custom_js')
<script>
    $(':input[type=number]').on('wheel',function(e){ $(this).blur(); });



</script>


