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
<!-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/pickers/pickadate/pickadate.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/plugins/pickers/daterange/daterange.css')}}"> -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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
    .ranges ul li.active {
    background-color: #41cac0!important;
}

.daterangepicker td.active, .daterangepicker td.active:hover {
    background-color: #41cac0!important;
    /* border-color: transparent;
    color: #fff; */
}
.daterangepicker td.in-range {
    background-color: rgba(65, 202, 192,.4)!important;
}
</style>
@endpush
@php
    $roles = userRolePermissionArray();
    $booking_status = Config::get('static_array.booking_status') ?? array();
    $booking_status_ =[
        '50'=>'Confirmed'
];
    $order_type = 'all';
    $branch = $data['branch'];
    $tab_index = 0;
    $branch_id =  request()->get('branch_id');
    if(Auth::user()->USER_TYPE == 10){
        $branch_id = Auth::user()->SHOP_ID;
    }
    $_booking_status  = request()->get('booking_status') ?? '';
    $order_id   = request()->get('order_id') ?? '';
    $order_date_ = request()->get('order_date') ?? '';
@endphp
@section('content')
<div class="card card-success min-height">
    <div class="card-content collapse show">
        <div class="card-body" style="padding: 15px 5px;">
            <div class="row mb-2">
                <div class="col-12">
                    @if(hasAccessAbility('new_booking', $roles))
                    <a href="{{ route('admin.booking.create',['branch_id' => $branch_id]) }}" class="btn btn-primary open-modal" title="Add new customer">
                        <i class="ft-plus text-white"></i> Create new
                    </a>
                    @endif
                {!! Form::open([ 'route' => 'admin.booking.list', 'method' => 'get', 'class' => 'form-inline', 'files' => true , 'novalidate']) !!}
                    <div class="form-group {!! $errors->has('branch_id') ? 'error' : '' !!}">
                        <div class="controls">
                            {!! Form::select('branch_id',$branch,$branch_id,['id'=>'branch_id','class'=>'form-control','placeholder'=>'Select branch','tabindex'=>$tab_index++]) !!}
                        </div>
                    </div>
                    <div class="form-group {!! $errors->has('booking_status') ? 'error' : '' !!}">
                        <div class="controls">
                            {!! Form::select('booking_status', $booking_status,$_booking_status, ['class'=>'form-control mb-1', 'id' => 'booking_status', 'placeholder' => 'Select status', 'tabindex' => $tab_index++, 'data-url' => URL::to('prod_model')]) !!}
                            {!! $errors->first('booking_status', '<label class="help-block text-danger">:message</label>') !!}
                        </div>
                    </div>
                    <div class="form-group {!! $errors->has('order_id') ? 'error' : '' !!}">
                        <div class="controls">
                            {!! Form::text('order_id',$order_id,['class'=>'form-control', 'id' => 'order_id','placeholder' =>'Enter order id', 'tabindex' => $tab_index++]) !!}
                            {!! $errors->first('order_id', '<label class="help-block text-danger">:message</label>') !!}
                        </div>
                    </div>
                    <div class="form-group {!! $errors->has('order_date') ? 'error' : '' !!}">
                        <div class="controls">
                         {!! Form::text('order_date',$order_date_, ['class'=>'form-control', 'id' => 'order_date_', 'placeholder' => 'Filter by date', 'tabindex' => $tab_index++]) !!}
                         {!! $errors->first('order_id', '<label class="help-block text-danger">:message</label>') !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="controls">
                            <button type="submit" class="text-white btn btn-round  btn-primary" title="Search">Search</button>
                        </div>
                    </div>
                {!! Form::close() !!}
                </div>
            </div>

            {!! Form::open([ 'route' => 'admin.booking.bulk_update', 'method' => 'POST','id'=>'bulkUpdateForm', 'novalidate']) !!}
            {{-- <div class="bulk-update-form p-2">
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-3">
                        {!! Form::select('booking_status',$booking_status_,$booking_status_[50],['id'=>'booking_status','class'=>'custom-select','placeholder'=>'Select Status','tabindex'=>$tab_index++,'data-validation-required-message' => 'This filed is required','required']) !!}
                            <div class="input-group-append">
                                <button type="submit" class="input-group-text" for="inputGroupSelect02">Update Status</button>
                            </div>
                        </div>
                        {!! $errors->first('booking_status', '<label class="help-block text-danger">:message</label>') !!}
                    </div>
                </div>
            </div> --}}

            <div class="table-responsive">
                <table class="table table-striped table-bordered table-sm" id="process_data_table">
                    <thead>
                    <tr>
                        <th>SL.</th>
                        <th style="width:100px;">Created</th>
                        <th>Branch</th>
                        <th>Date</th>
                        <th>Order No</th>
                        <th>Customer</th>
                        <th style="width:50px;">Variations</th>
                        <th style="width:50px;" class=" text-right">Order value</th>
                        <th style="width:50px;">Payment</th>
                        <th style="width:50px;">Source</th>
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
            {!! Form::close() !!}
            <a href="{{ url()->previous() }}" class="btn btn-sm btn-success btn-min-width mr-1 mb-1"><i class="la la-backward" ></i> Back</a>
        </div>
    </div>
</div>
@endsection

@push('custom_js')
<!-- BEGIN: Data Table-->
<script src="{{asset('assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
<!-- END: Data Table-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
<script src="https://pixinvent.com/modern-admin-clean-bootstrap-4-dashboard-html-template/app-assets/js/scripts/forms/checkbox-radio.min.js"></script>
<script src="{{ asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript">
$('#order_date_').daterangepicker({
    autoUpdateInput: false,
    ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }

}, (from_date, to_date) => {
  console.log(from_date.toDate(), to_date.toDate());
  $('#order_date_').val(from_date.format('MM/DD/YYYY') + '-' + to_date.format('MM/MM/DD'));
});


// $(function() {
//     var start = moment().subtract(29, 'days');
//     var end = moment();
//     function cb(start, end) {
//         $('#order_date_ span').html(start.format('MMMM D, YYYY') + '-' + end.format('MMMM D, YYYY'));
//     }
//     $('#order_date_').daterangepicker({
//         startDate: start,
//         endDate: end,
//         // autoUpdateInput: false,
//         ranges: {
//            'Today': [moment(), moment()],
//            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
//            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
//            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
//            'This Month': [moment().startOf('month'), moment().endOf('month')],
//            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
//         }
//     }, cb);
//     cb(start, end);
// });
// 07/02/2022 - 07/31/2022

// $('#order_date_').pickadate({
//         format: 'dd-mm-yyyy',
//         formatSubmit: 'dd-mm-yyyy',

//     });
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


$("#process_data_table").on("change", ".is_self_pickup", function () {
    var id = $(this).data("booking_id");
    var type = null;
    if ($(this).is(':checked')) {
        var type = 'checked';
    }else{
        var type = 'unchecked';
    }
    var is_self_pickup = get_url + '/order_self_pickup';
    if(confirm('Are you sure you want to HOLD the order?')) {
    $.ajax({
        type: "post",
        data:{ type:type, id:id},
        url: is_self_pickup,
        beforeSend:function(){},
        success: function (data) {
            if (data == 'true') {
                if( type == 'unchecked'){
                    toastr.success('General delivery system setup successfully','Success');
                }else{
                    toastr.success('Self pickup system setup successfully','Success');
                    }
            }else{
                toastr.info('Delivery system not change successfully', 'Error');
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


/*
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
*/


$(document).ready(function() {
    var id      =  `{{ request()->get('id') }}`;
    var type    =  `{{ request()->get('type') }}`;
    var dispatch    =  `{{ request()->get('dispatch') }}`;
    var order_from    =  `{{ request()->get('order_from') }}`;
    var branch_id    =  `{{ request()->get('branch_id') }}`;
    var booking_status    =  `{{ request()->get('booking_status') }}`;
    var order_id    =  `{{ request()->get('order_id') }}`;
    var order_date    =  `{{ request()->get('order_date') }}`;
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
                url: get_url+'/booking/all_booking',
                type: 'POST',
                data: function(d) {
                    d._token        = "{{ csrf_token() }}";
                    d.id            = id;
                    d.type          = type;
                    d.dispatch      = dispatch;
                    d.order_from    = order_from;
                    d.branch_id     = branch_id;
                    d.booking_status= booking_status;
                    d.order_id      = order_id;
                    d.order_date    = order_date;
                }
            },

            columns: [
                {
                    data: 'SL',
                    name: 'SL',
                    className:'text-center mx-auto'
                    // searchable: false,
                    // render: function(data, type, row, meta) {
                    //     return meta.row + meta.settings._iDisplayStart + 1;
                    // }
                    // data: 'PK_NO',
                    // name: 'PK_NO',
                    // searchable: false,
                    // render: function(data, type, row, meta) {
                    //     return meta.row + meta.settings._iDisplayStart + 1;
                    // }
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
                    name: 'SLS_BOOKING.TOTAL_PRICE',
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

