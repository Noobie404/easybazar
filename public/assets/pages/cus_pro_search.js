$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
/*booking customer radio button events*/
var get_url = $('#base_url').val();
customerSearch();
function customerSearch(type) {
    var get_url = $('#base_url').val();
    var engine1 = new Bloodhound({
        remote: {
            url: get_url+'/get-customer-info?q=%QUERY%',
            wildcard: '%QUERY%'
        },
        datumTokenizer: Bloodhound.tokenizers.whitespace('q'),
        queryTokenizer: Bloodhound.tokenizers.whitespace
    });
    $('.search-input2').on('typeahead:selected', function (e, datum) {
        $.ajax({
            type:'get',
            url: get_url+'/get-customer-details',
            data:{
              customer: datum.pk_no1,
            },
            dataType: 'json',
            async :true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (data) {
                $("body").css("cursor", "default");
                console.log(data);

                $('#full_name').val(data['info'].NAME);
                $('#mobile_no').val(data['info'].MOBILE_NO);
                $('#customer_id').val(data['info'].PK_NO);
                if (data['delivery_address'] !== null) {
                    $('#address').val(data['delivery_address'].ADDRESS_LINE_1);
                    $('#f_delivery_address').val(data['delivery_address'].PK_NO);
                }
                getTotal();
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    });
    $(".search-input2").typeahead({
        hint: true,
        highlight: true,
        minLength: 1,
    }, {
        source: engine1.ttAdapter(),
        // This will be appended to "tt-dataset-" to form the class name of the suggestion menu.
        display: 'NAME',
        limit: 100,

        // the key from the array we want to display (name,id,email,etc...)
        templates: {
            empty: function(context){
                $(".tt-dataset").html('<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>');
                var IfChecked = $('input[id="radio_btn"]:checked').length;
                if (IfChecked>0) {
                    $('#cus_mobile').fadeIn();
                    $('#cus_no_section').fadeIn();
                    $('#cus_country').fadeIn();
                    $('#cus_email').fadeIn();
                }
                $('#customer_id').val(0);
                $('#cus_details').fadeOut();
            },
            header: [
                '<div class="list-group search-results-dropdown">'
            ],
            suggestion: function (data) {
                if(data.POST_CODE){
                    var post_code = '('+data.POST_CODE+')';
                }else{
                    var post_code = '';
                }
                var res = '';
                 res += '<span class="list-group-item" style="cursor: pointer;" data-id="'+data.pk_no1+'" >' + data.NAME;
                    if(data.CUSTOMER_NO){
                        res += ' - ('+data.CUSTOMER_NO+')';
                    }
                    if(data.MOBILE_NO){
                        res += ' - ('+data.MOBILE_NO+')';
                    }
                    if(post_code){
                        res += ' - ('+post_code+')';
                    }
                    res +='</span>';
                return res;


            }
        }
    });
}

function productSearh(branch_id){
    var engine2 = new Bloodhound({
        remote: {
            url: get_url+'/'+branch_id+'/get-variant-info?q=%QUERY%',
            wildcard: '%QUERY%'
        },
        datumTokenizer: Bloodhound.tokenizers.whitespace('x'),
        queryTokenizer: Bloodhound.tokenizers.whitespace
    });

$('.search-input').on('typeahead:selected', function (e, datum) {
        var product = $('#product').val();
        var branch_id = $('#branch_id').val();

        var flag = 0;
        flag = check_if_product_exists(product);
        if (flag == 0) {
            if (product != '') {
                $.ajax({
                    type:'get',
                    url: get_url+'/get-prd-details',
                    data:{
                        product: product,
                        branch_id: branch_id,
                    },
                    async :true,
                    beforeSend: function () {
                        $("body").css("cursor", "progress");
                    },
                    success: function (data) {
                        $("body").css("cursor", "default");
                        $('.search-input').typeahead('val', '');
                        if (data.is_stock_out == 1) {
                            alert('Product Stock not found !');
                        }else if(data.length != undefined) {
                                $('#append_tr').prepend(data);
                                $('#product_append').prepend(data);
                                getTotal();
                        }else{
                            alert('Product not found !');
                        }
                    },
                    complete: function (data) {
                        $("body").css("cursor", "default");
                    }
                });
            }else{
                alert('Product not found !')
            }
        }else{
            alert('You can not add same product twice !')
            flag = 0;
        }
    });

    $(".search-input").typeahead({
        hint: true,
        highlight: true,
        minLength: 1,
        autoFocus: true
    }, {
        source: engine2.ttAdapter(),
        // This will be appended to "tt-dataset-" to form the class name of the suggestion menu.
        display: 'IG_CODE',
        limit: 100,
        // the key from the array we want to display (name,id,email,etc...)
        templates: {
            empty: [
                '<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>'
                // $('#cus_mobile').fadeIn()
            ],
            header: [
                '<div class="list-group search-results-dropdown">'
            ],
            suggestion: function (data) {
                return '<span class="list-group-item" style="cursor: pointer;"><img style="width:50px;" class="mr-1" src="'+data.PRD_VARIANT_IMAGE_PATH+'" alt=" ">' + data.PRD_VARINAT_NAME + '</span>'
                // $('#cus_mobile').fadeOut()
      }
        }
    });

}

$(document).on('change', '.price_used',function(){
    var price_used = $(this).val();
    var $row = $(this).closest('tr');
    var price = $row.find('.'+price_used).val();
    $row.find('.unit_price').val(price);
    getTotal();

})


function check_if_product_exists(product) {
    var flag = 0;
    if ( $('#prod_'+product).length > 0 ) {
        flag = 1;
    }
    return flag;
}


/*delete product row method*/
$(document).on('click','#delete_prd', function(){
    if(confirm('Are you sure your want to delete?')){
        var row = $(this).closest("tr");
        $(row).fadeOut();
        $(row).remove();
        getTotal();
      }
});
$(document).on('input','.booking_qty',function(e){
    getTotal();
})

function getTotal(){
    var total_booking_qty = total_product_price = 0;
    $('#append_tr tr').each(function() {
        var row = $(this);
        var booking_qty = Number(row.find('.booking_qty').val());
        var unit_price = parseFloat(row.find('.unit_price').val());
        var line_price = unit_price*booking_qty;
        row.find('.product_price').val(line_price);
        row.find('._line_price').text(parseFloat(line_price).toFixed(2));
        total_booking_qty += booking_qty;
        total_product_price += line_price;

    });
    $('#total_booking_qty').val(total_booking_qty);
    $('#total_product_price').val(total_product_price);
    
   var _coupon_code =  $('#_coupon_code').val();
   var coupon_discount =  parseFloat($('#coupon_discount').val());
    var total_product_price = parseFloat($('#total_product_price').val());
    parseFloat($('#_total_product_price').text(total_product_price)).toFixed(2);
    var total_delivery_cost = parseFloat($('#total_delivery_cost').val());
    parseFloat($('#_total_delivery_cost').text());
    var total_discount = parseFloat($('#total_discount').val());
    parseFloat($('#_total_discount').text());
    var grand_total =parseFloat( total_delivery_cost+total_product_price-coupon_discount).toFixed(2);
    $('#grand_total').val(grand_total);
    $('#_grand_total').text(grand_total);
    return true;
}


$(document).on('change','#branch_id',function(e){
    var branch_id = $(this).val();
    var url = get_url+'/search-&-book?branch_id='+branch_id;
    window.location = url;

})



$(document).on('click','.searh_and_book_submit_btn',function(e){
    var flag = 1;
    var min_order_amount = parseFloat($('#branch_id').find('option:selected').attr('data-min_order_amount'));
    var max_order_amount = parseFloat($('#branch_id').find('option:selected').attr('data-max_order_amount'));
    var total_product_price = parseFloat($('#total_product_price').val());
    if(isNaN(total_product_price)){
        total_product_price = 0;
    }

    var branch_id = $('#branch_id').val();
    if(total_product_price < min_order_amount){
        flag = 0;
        alert('Minimum order value is '+min_order_amount + ' for this branch');
    }

    if(total_product_price > max_order_amount){
        flag = 0;
        alert('Maximum order value is '+min_order_amount + ' for this branch');
    }
    if(flag == 1){
        //ajax for calculating delivery cost
        $.ajax({
            type: 'get',
            url: get_url+'/get-delivery-cost',
            data:{
                total_order_price:total_product_price,
                branch_id:branch_id,
            },
            async :true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (data) {
                $("body").css("cursor", "default");
                $('#delivery_cost_tr').removeClass('d-none');
                $('#grand_total_tr').removeClass('d-none');
                $('#total_delivery_cost').val(data);
                getTotal();
                $('.searh_and_book_save_submit_btn').removeClass('d-none');
                $('#customer_info').removeClass('d-none');
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    }

})
