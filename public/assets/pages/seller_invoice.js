/*Subcategory by Category*/
$(document).on('change','#acc_source', function(){
    var id = $(this).val();
    var url = $(this).attr('data-url');
    $('#bank_acc').html('');
    $('#payment_method').html('');
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
                $('#bank_acc').html(data.bank_acc);
                $('#payment_method').html(data.payment_method);
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    }
});

$('#gbp_to_ac').val(1);
$('#alian_currency').text('GBP');

$(document).on('change', '#purchase_currency', function(e){

    var val     = $(this).val();
        var rate    = $(this).find(':selected').data('rate');
    var code    = $(this).find(':selected').data('code');

    $('#gbp_to_ac').val(rate);
    $('#alian_currency').text(code);

})
$(document).on('click', '.stockGenerate', function(e){
    e.preventDefault();
    if (confirm('Are you sure ?')) {
        var invoice_id   = $(this).data('invoice_id');
        var pk_no   = $(this).data('pk_no');
        $('#invoice_pk_no').val(pk_no);
        $.ajax({
            type:'post',
            url:'/seller/invoice-processing/store',
            data: {
                invoice_pk_no: pk_no
            },
            async :true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (data) {
                if (data.status == true) {
                    var asd = $('#process_data_table tr').find('.invoice-no-'+invoice_id);
                    asd.html('<button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">YES</button>');
                    toastr.success('Stock generated successfully','Success');
                }else{
                    toastr.warning('Something went wrong !','Warning');
                }
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        })
    }
});
// })
function setCookie(invoice,pageNum) {
    var today = new Date();
    var name = invoice;
    var elementValue = pageNum;
    var expiry = new Date(today.getTime() + 30 * 24 * 3600 * 1000); // plus 30 days
    document.cookie = name + "=" + elementValue + "; path=/; expires=" + expiry.toGMTString();
}
function getCookie(name) {
    var re = new RegExp(name + "=([^;]+)");
    var value = re.exec(document.cookie);
    return (value != null) ? unescape(value[1]) : null;
}
