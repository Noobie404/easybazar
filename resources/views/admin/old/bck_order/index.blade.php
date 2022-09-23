@extends('admin.layout.master')

@section('Order Management','open')
@section('list_order','active')

@section('title')@lang('order.list_page_title')@endsection
@section('page-name') @lang('order.list_page_sub_title') @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('order.breadcrumb_title')</a></li>
    <li class="breadcrumb-item active">@lang('order.breadcrumb_sub_title')</li>
@endsection

@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/extensions/toastr.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
<style>
    .f12{font-size: 12px;}
    .w100{width: 100px;}
    #process_data_table td{vertical-align: middle;}
    .order-type{display: inline-block; margin-right: 10px;}
    .order-type label {cursor: pointer;}
    .badge-default{ background-color: #fff; color: blue;}
    .pulse-green {animation: pulsered 2s infinite;background: #90ee90;box-shadow: 0 0 0 #e00e3f;}
    table.order-due-table tr > td {text-transform: uppercase;}
    table.order-due-table {width: 100%;font-size: 14px;border-collapse: collapse;}
    table.order-due-table th,table.order-due-table td {padding: 0.5em;}
    .form-inline{display: inline-flex;}
</style>
@endpush


@php
    $roles = userRolePermissionArray();
    $order_type = 'all';
    $branch_id =  request()->get('branch_id');
    $branch = $data['branch'];
    $tab_index = 0;

@endphp
@section('content')
<div class="card card-success min-height">
    <div class="card-content collapse show">
        <div class="card-body" style="padding: 15px 5px;">
            <div class="row mb-2">
                <div class="col-12">

                    @if(hasAccessAbility('new_customer', $roles))

                    <a href="{{ route('admin.booking.search_create') }}" class="btn btn-primary open-modal" title="Add new customer">
                        <i class="ft-plus text-white"></i> Create new
                    </a>
                    @endif

                {!! Form::open([ 'route' => 'admin.customer.list', 'method' => 'get', 'class' => 'form-inline', 'files' => true , 'novalidate']) !!}
                    <div class="form-group {!! $errors->has('branch_id') ? 'error' : '' !!}">
                        <div class="controls">
                            {!! Form::select('branch_id',$branch,$branch_id,['id'=>'branch_id','class'=>'form-control','placeholder'=>'Select branch','tabindex'=>$tab_index++]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="controls">
                            <button type="submit" class="text-white btn btn-round  btn-primary" title="Search">Search</button>
                        </div>
                    </div>
                {!! Form::close() !!}

                    {{-- <form class="form-inline" action="#" method="get">
                        <div class="form-group mb-2">
                            <a href="{{ route('admin.order.list') }}" class="btn btn-success {{ request()->get('order_from') == '' ? 'active' : '' }}" style="padding: 8px 15px;">All</a>&nbsp;
                            <a href="{{ route('admin.order.list') }}?order_from=admin" class="btn btn-success {{ request()->get('order_from') == 'admin' ? 'active' : '' }}" style="padding: 8px 15px;">Admin Order</a>&nbsp;
                            <a href="{{ route('admin.order.list') }}?order_from=web" class="btn btn-success {{ request()->get('order_from') == 'web' ? 'active' : '' }}" style="padding: 8px 15px;">Web Order</a>
                        </div>

                      </form> --}}
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-sm" id="process_data_table">
                    <thead>
                    <tr>
                        <th>SL.</th>
                        <th style="width:100px;">Created</th>
                        <th>Banch</th>
                        <th>Date</th>
                        <th>Order No</th>
                        <th>Customer</th>

                        <th style="width:50px;">Variations</th>
                        <th style="width:50px;" class=" text-right">Order value</th>
                        <th style="width:50px;">Payment</th>
                        <th style="width:50px;">Location</th>
                        <th class=" text-center">Status</th>
                        <th class=" text-center" title="IS HOLD BY ADMIN">Hold</th>
                        <th class=" text-center" title="SELF PICKUP/ COD or RTC">SP</th>
                        <th class=" text-center" style="width:122px;">Action</th>

                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
            <a href="{{ url()->previous() }}" class="btn btn-sm btn-success btn-min-width mr-1 mb-1"><i class="la la-backward" ></i> Back</a>
        </div>

    </div>



</div>
{{-- @dd($data['payment_acc_no']) --}}
<!--Edit Product Subcategory  html-->
<div class="modal fade text-left" id="self_pick_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">COD/RTC Transfer</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                {!! Form::open(['route' => 'admin.order.rtc_transfer', 'method' => 'post','id'=>'self-pickup-form', 'class' => 'form-horizontal', 'files' => false , 'novalidate' ]) !!}
                    @csrf

                {!! Form::hidden('booking_id', null, [ 'class' => 'form-control mb-1', 'id' => 'f_booking_no' , 'data-validation-required-message' => 'This field is required' ]) !!}

                <div class="modal-body">
                    @if(Auth::user()->F_AGENT_NO > 0 )
                    <div class="form-group {!! $errors->has('payment_acc_no') ? 'error' : '' !!}">
                        <label>COD/RTC User<span class="text-danger">*</span></label>
                        <div class="controls">
                            <select class="form-control" name="payment_acc_no" id="payment_acc_no" data-validation-required-message="This field is required" tabindex="1" >
                                <option value="">--select bank--</option>
                                    @if(isset($data['payment_acc_no']) && count($data['payment_acc_no']) > 0 )
                                        @foreach($data['payment_acc_no'] as $k => $bank)
                                            @if( $bank->IS_COD == 1)
                                                @if( Auth::user()->F_AGENT_NO > 0)
                                                    <option value="{{ $bank->PK_NO }}" selected="selected">Request COD-RTC</option>

                                                @endif
                                            @endif
                                        @endforeach
                                    @endif
                                <option value="0">Unassign COD-RTC </option>
                            </select>
                            {!! $errors->first('payment_acc_no', '<label class="help-block text-danger">:message</label>') !!}
                        </div>
                    </div>
                    @else
                    {!! Form::hidden('approval', 1, [ 'class' => 'form-control mb-1' , 'data-validation-required-message' => 'This field is required' ]) !!}

                    <div class="form-group {!! $errors->has('payment_acc_no') ? 'error' : '' !!}">
                        <label>COD/RTC User<span class="text-danger">*</span></label>
                        <div class="controls">
                            <select class="form-control" name="payment_acc_no" id="payment_acc_no" data-validation-required-message="This field is required" tabindex="4">
                                <option value="">--select bank--</option>
                                @if(isset($data['payment_acc_no']) && count($data['payment_acc_no']) > 0 )
                                    @foreach($data['payment_acc_no'] as $k => $bank)
                                        @if( $bank->IS_COD == 1)
                                            <option value="{{ $bank->PK_NO }}" >{{ $bank->BANK_NAME .' ('.$bank->BANK_ACC_NAME.') ('.$bank->BANK_ACC_NO.')' }}</option>
                                        @endif
                                    @endforeach
                                @endif
                                <option value="0">Unassigned RTC </option>

                            </select>

                            {!! $errors->first('payment_acc_no', '<label class="help-block text-danger">:message</label>') !!}
                        </div>
                    </div>

                    @endif

                </div>

                <div class="modal-footer">
                    <input type="reset" class="btn btn-secondary btn-sm" data-dismiss="modal" value="Close">
                    <input type="submit" class="btn btn-info btn-sm submit-btn" value="Send">
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<!--VIEW BILLPLZ PAYMENT URL html-->
<div class="modal fade text-center" id="show_billplz_url" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">BillPlz Payment Url</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>URL</strong> : <span title="CLICK TO COPY THE URL" style="cursor: pointer" id="url2"></span></p>
                <p><strong>AMOUNT</strong> : <span id="amount"></span></p>
            </div>
            <div class="modal-footer">
                <input type="reset" class="btn btn-secondary btn-sm" data-dismiss="modal" value="Close">
            </div>
        </div>
    </div>
</div>
<!--Order Payment modal-->
<div class="modal fade text-left" id="CustomerOrderPayment" tabindex="-1" role="dialog"
    aria-labelledby="CustomerOrderPayment" aria-hidden="true" style="z-index: 9999999;">
    <div class="quickView-modal modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title pay-order-pay" id="source_name">Pay Order Payment</h3>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="payment_html"></div>
            <div class="modal-footer">
                <input type="reset" class="btn btn-secondary btn-sm" data-dismiss="modal" value="Close">
            </div>
        </div>
    </div>
</div>
<!--End Order Payment modal html-->
@endsection

@push('custom_js')
<!-- BEGIN: Data Table-->
<script src="{{asset('assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
<!-- END: Data Table-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
<script src="https://pixinvent.com/modern-admin-clean-bootstrap-4-dashboard-html-template/app-assets/js/scripts/forms/checkbox-radio.min.js"></script>
<script src="{{ asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>


<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
var get_url = $('#base_url').val();
$(document).on('click','[id=url]', function(){
    var copyText = $(this).html();
    var textarea = document.createElement("textarea");
    textarea.textContent = copyText;
    textarea.style.width = "1px";
    textarea.setAttribute('id','textarea');
    $('#url').append(textarea);
    textarea.select();
    document.execCommand("copy");
    $('#textarea').remove();
    toastr.success('URL Copyied ',{timeOut: 5000})
})
$(document).on('click','#generate_billplz_url',function(){
    var order_group_id = $(this).data('order_group_id');
    $.ajax({
        type:'post',
        url:get_url+'/generate-billplz-url',
        data:{ order_group_id:order_group_id,generate_url:0},
        async :true,
        beforeSend: function () {
            $("body").css("cursor", "progress");
            $("#loader").fadeIn(300);
        },
        success: function (res) {
            if(res.msg != ''){
                toastr.warning(res.msg,'Warning');
            }else if (res.payment_type == 'azuramart-180' || res.payment_type == 'azuramart-90' || res.payment_type == 'billplz') {
                $('#CustomerOrderPayment').modal('show');
                $('#payment_html').html('');
                $('#payment_html').html(res.html);
                if (res.payment_type == 'azuramart-180') {
                    var pay_amount = Number($('#azuramart180').find('.quantity.max_val_check.min_val_check').val());
                    $('#payment').text(pay_amount);
                }else if(res.payment_type == 'azuramart-90'){
                    var pay_amount = Number($('#azuramart90').find('.quantity.max_val_check.min_val_check').val());
                    $('#payment').text(pay_amount);
                }else if(res.payment_type == 'billplz'){
                    var pay_amount = Number($('#billplz').val());
                    $('#payment').text(pay_amount);
                }
            }
            $('#order_group').val(order_group_id);
        },
        complete: function (data) {
            $("body").css("cursor", "default");
            $("#loader").fadeOut(300);
        }
    });
});
$(document).on('click','#get_billplz_url',function(){
    var amount = Number($('.quantity.max_val_check').val());
    var order_group_id = Number($('#order_group').val());
    // $('#CustomerOrderPayment').modal('hide');
    $.ajax({
        type:'post',
        url:get_url+'/generate-billplz-url',
        data:{ amount:amount,order_group_id:order_group_id,generate_url:1},
        beforeSend: function () {
            $("body").css("cursor", "progress");
            $("#loader").fadeIn(300);
        },
        success: function (res) {
            if(res.msg != ''){
                alert(res.msg);
            }else if(res.bil_pay == 1 && res.url != ''){
                // window.open(res.url, '_self');
                $('#show_url').css('display','block');
                $('#url').html('');
                $('#url').html(res.url);
                console.log(res.url);
            }
        },
        complete: function (data) {
            $("body").css("cursor", "default");
            $("#loader").fadeOut(300);
        }
    });
});
$(document).on('click','.self_pick', function(){
    var booking_id = $(this).data('booking_id');
    var rtc_no = $(this).data('rtc_no');
    if(rtc_no){
        $('#payment_acc_no').val(rtc_no).change();
        // $("#payment_acc_no").trigger('change');
    }else{
        $("#payment_acc_no").val("").change();
    }
    $("#f_booking_no").val(booking_id);
})

$("#process_data_table").on("change", ".is_admin_hold", function () {
    var id = $(this).data("booking_id");
    var type = null;

    if ($(this).is(':checked')) {
        var type = 'checked';
    }else{
        var type = 'unchecked';
    }
    var is_admin_hold = get_url + '/order_admin_hold';

    if(confirm('Are you sure you want to HOLD the order?')) {
    $.ajax({
        type: "post",
        data:{ type:type, id:id},
        url: is_admin_hold,
        beforeSend:function(){},
        success: function (data) {

            if (data == 'true') {
                if( type == 'unchecked'){
                    toastr.success('Unhold the order successfully','Success');
                }else{
                    toastr.success('Successfully hold the order','Success');
                    }
            }else{
                toastr.info('Order status not change successfully', 'Error');
            }
        },
        complete: function (data){}
    });
    }else{
        if( type == 'unchecked'){
            $(this).prop('checked', true);

        }else{
            $(this).prop('checked', false);
        }


    }

});
$(document).on('submit','#self-pickup-form',function(e){
    e.preventDefault();
    $.ajax({
        type:'POST',
        url:get_url+'/order/rtc-transfer-ajax',
        data : $('#self-pickup-form').serialize(),
        beforeSend: function () {
            $("body").css("cursor", "progress");
        },
        success: function (data) {
            if (data['status'] == 1) {
                if (data['approval'] == 1) {
                    $('[data-self_pickup_booking='+data['booking_id']+']').html(data['username']);
                    $('[data-self_pickup_booking='+data['booking_id']+']').removeClass('btn-warning');
                    $('[data-self_pickup_booking='+data['booking_id']+']').addClass('btn-success');
                }else if(data['approval'] == 0){
                    if (data['user_assigned'] == 1) {
                        $('[data-self_pickup_booking='+data['booking_id']+']').html('COD/RTC');
                        $('[data-self_pickup_booking='+data['booking_id']+']').removeClass('btn-success');
                        $('[data-self_pickup_booking='+data['booking_id']+']').addClass('btn-warning');
                    }else{
                        $('[data-self_pickup_booking='+data['booking_id']+']').html(data['username']);
                        $('[data-self_pickup_booking='+data['booking_id']+']').removeClass('btn-warning');
                        $('[data-self_pickup_booking='+data['booking_id']+']').addClass('btn-success');
                    }
                }
                $('[data-self_pickup_booking='+data['booking_id']+']').data('rtc_no',data['rtc_no']);
                $('#self_pick_modal').modal('hide');
            }
            else{
                alert('Please try again !');
            }
        },
        complete: function (data) {
            $("body").css("cursor", "default");
        }
    });
});

$("#process_data_table").on("change", "#branch_id", function () {
    var branch_id = $(this).val();
    alert(branch_id);

})


$(document).ready(function() {
    var id      =  `{{ request()->get('id') }}`;
    var type    =  `{{ request()->get('type') }}`;
    var dispatch    =  `{{ request()->get('dispatch') }}`;
    var order_from    =  `{{ request()->get('order_from') }}`;
    var table   =
        $('#process_data_table').DataTable({
            processing: false,
            serverSide: true,
            paging: true,
            pageLength: 25,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            ajax: {
                url: get_url+'/order/all_order',
                type: 'POST',
                data: function(d) {
                    d._token        = "{{ csrf_token() }}";
                    d.id            = id;
                    d.type          = type;
                    d.dispatch      = dispatch;
                    d.order_from     = order_from;
                }
            },

            columns: [
                {
                    data: 'PK_NO',
                    name: 'PK_NO',
                    searchable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    searchable: false,
                    className:'w100'
                },
                {
                    data: 'SHOP_NAME',
                    name: 'SLS_BOOKING.SHOP_NAME',
                    searchable: true,
                },
                {
                    data: 'order_date',
                    name: 'order_date',
                    searchable: true
                },
                {
                    data: 'order_id',
                    name: 'SLS_BOOKING.BOOKING_NO',
                    searchable: true,

                },
                {
                    data: 'customer_name',
                    name: 'SLS_BOOKING.CUSTOMER_NAME',
                    searchable: true,
                    className:'text-uppercase'
                },

                {
                    data: 'variantion',
                    name: 'variantion',
                    searchable: false,
                    className: 'text-center'
                },
                {
                    data: 'price_after_dis',
                    name: 'price_after_dis',
                    searchable: false,
                    className: 'text-right'

                },
                {
                    data: 'payment',
                    name: 'payment',
                    searchable: false
                },
                {
                    data: 'avaiable',
                    name: 'avaiable',
                    searchable: false
                },
                {
                    data: 'status',
                    name: 'status',
                    className: 'text-center',
                    searchable: true
                },
                {
                    data: 'admin_hold',
                    name: 'admin_hold',
                    className: 'text-center',
                    searchable: false
                },
                {
                    data: 'self_pickup',
                    name: 'self_pickup',
                    className: 'text-center',
                    searchable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    searchable: false,
                    className: 'text-center'
                },

            ],

        });
});


$(document).on('click', '.note', function(e){
    var booking_no = $(this).data('booking_no');
    // alert(booking_no);
    $('#historyNote').modal('show');
})
$(document).on('change keypress paste keyup input','.quantity.max_val_check.min_val_check',function(){
    if ($(this).attr('name') == 'downpayment_180') {
        var type = 'downpayment_180_';
        var installments = 6;
    }else{
        var type = 'downpayment_90_';
        var installments = 3;
    }
    var new_val = Number($('.quantity.max_val_check.min_val_check').val());         //994
    var init_value = Number($('.quantity.max_val_check.min_val_check').attr('min'));//344
    var p_difference = new_val-init_value; //680

    var total_price = Number($('#order_value').val());
    var total_paid = Number($('#total_paid').val());

    $('#due').text(total_price-total_paid-new_val);

    for (var i = 0; i < installments+1; i++) {
        if ($('#'+type+i).hasClass('paid') || $('#'+type+i).hasClass('max_val_check')) {
            console.log('continue');
            continue;
        }else{
            var input_val = Number($('#'+type+i).data('value'));
            if (new_val <= init_value) {
                console.log('218 '+input_val+' '+new_val+' '+init_value);
                $('#'+type+i).val(input_val+(init_value-new_val));
            }else if(new_val > init_value ){
                if (p_difference >= input_val) {
                    $('#'+type+i).val(0);
                    p_difference -= input_val;
                    console.log('224 '+input_val+' '+p_difference);
                }else{
                    $('#'+type+i).val(input_val-p_difference);
                    console.log('228 '+input_val+' '+p_difference);
                    p_difference = 0;
                }
            }
        }
    }
    $('#payment').text($(this).val());
});
$(document).on('input change keyup keypress', '.max_val_check',function(e){
    var val = Number($(this).val());
    var max = Number($(this).attr('max'));
    if (val > max) {
        $(this).val(max);
        $(this).change();
        // console.log(max);
    }
});
$(document).on('change', '.min_val_check',function(e){
    var val = Number($(this).val());
    var min = Number($(this).attr('min'));
    if (val < min) {
        $(this).val(min);
        $(this).change();
    }
});
$(document).on("keyup paste change keypress",".quantity", function (evt) {
    var self = $(this);
    self.val(self.val().replace(/[^0-9\.]/g, ''));
    if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57))
    {
        evt.preventDefault();
    }
});
$(document).on('input', '.remove_first_zero', function(e) {
    if((this.value+'').match(/^0/)) {
        this.value = (this.value+'').replace(/^0+/g, '');
    }
});
</script>

@endpush

