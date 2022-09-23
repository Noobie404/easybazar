<div class="modal fade text-left" id="UpdateMasterVariant" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-info" id="myModalLabel4">Update Master variant</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>
@push('custom_js')
<script>
    $(document).on('click','#updatemastervariant',function(){
        var master = $(this).data('master');
        var variant = $(this).data('variant');
        var pageurl = `{{ route('admin.update.masterVariant') }}`;
        $.ajax({
            type    : 'POST',
            url     : pageurl,
            async   : true,
            data    : {
                master : master,
                _token : `{{ csrf_token() }}`
            },
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (data) {
                $('.modal-body').html('').append(data.html);
                $('#variant_id').val(variant);
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    });
    $(document).on('click','#swap_variant_master',function(){
        if (confirm('Are you sure ?')) {
            var master = $(this).data('master');
            var variant = $('#variant_id').val();
            var pageurl = `{{ route('admin.update.masterVariant.swap') }}`;
            $.ajax({
                type    : 'POST',
                url     : pageurl,
                async   : true,
                data    : {
                    master : master,
                    variant : variant,
                    _token : `{{ csrf_token() }}`
                },
                beforeSend: function () {
                    $("body").css("cursor", "progress");
                },
                success: function (data) {
                    if (data.status == 1) {
                        toastr.success('Variant Master Updated Successfully !','Success');
                    }else{
                        toastr.warning('Pleasr Try Again !','Error');
                    }
                },
                complete: function (data) {
                    $("body").css("cursor", "default");
                }
            });
        }
    });
    $(document).on('submit','#search_for_master',function(e){
        e.preventDefault();
        var pageurl = `{{ route('admin.master_search') }}`;
        $.ajax({
            type    : 'POST',
            url     : pageurl,
            async   : true,
            data    : $(this).serialize(),
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (data) {
                $('#append_result').html('').append(data.html);
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    });
    /*
    $(document).on('change','#category2', function(){
        var id = $(this).val();
        var url = $(this).attr('data-url');
        if ('' != id) {
            var pageurl = url+'/'+id;
            $.ajax({
                type:'get',
                url:pageurl,
                async :true,
                beforeSend: function () {
                    $("body").css("cursor", "progress");
                },
                success: function (data) {
                    $('#sub_category2').html(data);
                },
                complete: function (data) {
                    $("body").css("cursor", "default");
                }
            });
        }
    });
    */


    /*Model by Brand*/
    /*
    $(document).on('change','#brand2', function(){
        var id      = $(this).val();
        var url     = $(this).attr('data-url');
        var pageurl = url+'/'+id;
        $.ajax({
            type:'get',
            url:pageurl,
            async :true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (data) {
                if(data != '' ){
                    $('#prod_model2').html(data);
                } else {
                    $('#prod_model2').html("<option value=''>data not found</option>");
                }
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    });
    */

</script>
@endpush
