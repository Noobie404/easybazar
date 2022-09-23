<script src="{{asset('assets/vendors/js/vendors.js')}}"></script>
<script src="{{asset('assets/vendors/js/forms/icheck/icheck.min.js')}}"></script>
<script src="{{asset('assets/js/core/app-menu.js')}}"></script>
<script src="{{asset('assets/js/core/app.js')}}"></script>
<script src="{{asset('assets/vendors/js/forms/validation/jqBootstrapValidation.js')}}"></script>
<script src="{{asset('assets/js/scripts/forms/validation/form-validation.js')}}"></script>
<script src="{{asset('assets/js/scripts/forms/checkbox-radio.js')}}"></script>
{!! Toastr::message() !!}
<script src="{{asset('assets/js/common.js?v=1.1.10')}}"></script>
@stack('custom_js')
<script>
    $(':input[type=number]').on('wheel',function(e){ $(this).blur(); });

    //for child options calling
    var get_url = $('#base_url').val();
    function getChildOptions(item,table,select_key,select_val,child_id,cond_col){
        var cond_val = item.value;
        var pageurl = get_url+'/getoptions/'+table+'/'+select_key+'/'+select_val+'/'+cond_col+'/'+cond_val;
        var html_id = '#'+child_id;

        $.ajax({
            type:'get',
            url:pageurl,
            async :true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (data) {
                if(data.response == true){
                    $(html_id).html(data.html);
                } else {
                    $(html_id).html("<option value=''>data not found</option>");
                }
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    }

</script>


