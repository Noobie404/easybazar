@extends('admin.layout.master')

@section('Payment','open')
@section('payment_list','active')

@section('title') Add Payment @endsection
@section('page-name')Add Payment @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Add Payment</li>
@endsection

@push('custom_css')

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/pickers/pickadate/pickadate.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/plugins/pickers/daterange/daterange.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/extensions/toastr.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/extensions/toastr.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
    <style>
        #scrollable-dropdown-menu .tt-menu {max-height: 260px;overflow-y: auto;width: 100%;border: 1px solid #333;border-radius: 5px;}
        .twitter-typeahead {display: block !important;}
    </style>
@endpush('custom_css')

@section('content')
@php
    $roles = userRolePermissionArray();
@endphp
<div class="card card-success min-height">
    <div class="card-header">
        <h4 class="card-title" id="basic-layout-colored-form-control" style="text-transform: capitalize;">{{ $data['type'] ?? 'Payment Entry' }} &nbsp;</h4>

        @if($errors->any())
        {{ implode($errors->all(':message')) }}
        @endif
        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
            @if( request()->get('payfrom') == 'credit' )
                <a href="{{ route('admin.payment.create',[ 'id' => $data['customer']->PK_NO ?? '', 'type' => $data['type'] ?? '', 'payfrom' => 'new' ]) }}">New payment entry</a>

            @else
                <a href="{{ route('admin.payment.create',[ 'id' => $data['customer']->PK_NO ?? '', 'type' => $data['type'] ?? '', 'payfrom' => 'credit' ]) }}" title="Click for payment from customer balance">Payment from customer balance</a>
            @endif
        </div>
        <a href="javascript:void(0)" id="" data-toggle="modal" data-target="#CustomerPayment" class="btn btn-xs btn-azura c-btn mt-1" style="min-width:90px;float: right;" title="GENERATE BILLPLZ URL WITHOUT ORDER">Generate Billplz Url Without Order</a>
    </div>
    <div class="card-content collapse show">
        <div class="card-body">
            {!! Form::open([ 'route' => 'admin.payment.store', 'method' => 'post', 'class' => 'form-horizontal paymentEntryFrm prev_duplicat_frm', 'files'
            => true , 'novalidate']) !!}
            <input type="hidden" name="customer_id" value="{{ $data['customer']->PK_NO ?? '' }}" />
            <input type="hidden" name="type" value="{{ $data['type'] ?? '' }}" />
            <input type="hidden" name="payfrom" value="{{ request()->get('payfrom') ?? '' }}" />

            <div class="form-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group {!! $errors->has('customer') ? 'error' : '' !!}">
                            <div class="controls">
                                <label>
                                    @if ($data['type'] == 'customer')
                                    @lang('order.customer')
                                    @else
                                    @lang('order.reseller')
                                    @endif
                                    <span class="text-danger">*</span></label>
                                <div class="controls" id="scrollable-dropdown-menu">
                                    <input type="search" name="customer" id="customer" class="form-control"
                                        placeholder="Enter customer name" autocomplete="off" value="{{ $data['customer']->NAME ?? '' }}" readonly>
                                    {!! $errors->first('customer', '<label class="help-block text-danger">:message</label>') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group {!! $errors->has('payment_currency_no') ? 'error' : '' !!}">
                            <label>Payment Currency<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::select('payment_currency_no',  $data['currency'] ?? [], 2, [ 'class' => 'form-control mb-1
                                ', 'placeholder' => 'Please select', 'data-validation-required-message' => 'This field is required', 'tabindex' => 2, 'id' => 'payment_currency_no' ]) !!}

                                {!! $errors->first('payment_currency_no', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        @if( request()->get('payfrom')  == 'credit' )
                        <div class="form-group {!! $errors->has('payment_acc_no') ? 'error' : '' !!}">
                            <label>Paymet From<span class="text-danger">*</span></label>
                            <div class="controls">
                                <select class="form-control mb-1" name="pay_pk_no" required id="pay_pk_no">
                                    <option value="">- select one -</option>
                                    @if(isset($data['remaining_balance']) && count($data['remaining_balance']) > 0 )
                                        @foreach($data['remaining_balance'] as $key => $balance )
                                            <option value="{{ $balance->PK_NO }}"
                                                data-currency="{{ $balance->F_PAYMENT_CURRENCY_NO }}"
                                                data-paydate="{{ date('d-m-Y',strtotime($balance->PAYMENT_DATE)) }}"
                                                data-slipno="{{ $balance->SLIP_NUMBER }}"
                                                data-paidby="{{ $balance->PAID_BY }}"
                                                data-paynote="{{ $balance->PAYMENT_NOTE }}"
                                                data-amount="{{ $balance->PAYMENT_REMAINING_MR }}"
                                                > {{ 'PID-'.$balance->TXN_CODE ?? '' }} (RM {{ number_format($balance->PAYMENT_REMAINING_MR,2) }} )
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                {!! $errors->first('payment_acc_no', '<label class="help-block text-danger">:message</label>') !!}

                            </div>
                        </div>
                        @else
                        <div class="form-group {!! $errors->has('payment_acc_no') ? 'error' : '' !!}">
                            <label>Payment Account<span class="text-danger">*</span></label>
                            <div class="controls">
                                <select class="form-control" name="payment_acc_no" id="payment_acc_no" data-validation-required-message="This field is required" tabindex="4">
                                    <option value="">--select bank--</option>
                                    @if(isset($data['payment_acc_no']) && count($data['payment_acc_no']) > 0 )
                                        @foreach($data['payment_acc_no'] as $k => $bank)
                                            @if( $bank->IS_COD == 0)
                                                <option value="{{ $bank->PK_NO }}" >{{ $bank->BANK_NAME .' ('.$bank->BANK_ACC_NAME.') ('.$bank->BANK_ACC_NO.')' }}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                                {!! $errors->first('payment_acc_no', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-3">
                        <div class="form-group {!! $errors->has('payment_date') ? 'error' : '' !!}">
                            <label>Payment Date<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <span class="la la-calendar-o"></span>
                                    </span>
                                </div>
                                <input type='text' class="form-control pickadate datepicker" placeholder="Invoice Date"
                                    value="{{date('d-m-Y')}}" name="payment_date" id="payment_date" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group {!! $errors->has('payment_amount') ? 'error' : '' !!}">
                            <label>Payment Amount (RM)<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::number('payment_amount', null,[ 'class' => 'form-control mb-1',
                                'data-validation-required-message' => 'This field is required','placeholder' => 'Payment amount (RM)', 'tabindex' => 6 ,'min' => 0, 'id' => 'payment_amount', 'step' => '0.01',  request()->get('payfrom')  == 'credit' ? 'readonly' : '']) !!}
                                {!! $errors->first('payment_amount', '<label
                                    class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group {!! $errors->has('ref_number') ? 'error' : '' !!}">
                            <label>Ref. Number/Slip Number<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::text('ref_number', null,[ 'class' => 'form-control mb-1',
                                'data-validation-required-message' => 'This field is required','placeholder' => 'Ref. number/slip number', 'tabindex' => 7 , 'id' => 'ref_number']) !!}
                                {!! $errors->first('ref_number', '<label
                                    class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group {!! $errors->has('paid_by') ? 'error' : '' !!}">
                            <label>Paid By</label>
                            <div class="controls">
                                {!! Form::text('paid_by', null,[ 'class' => 'form-control mb-1', 'placeholder' => 'Paid by', 'tabindex' => 8, 'id' => 'paid_by' ]) !!}
                                {!! $errors->first('paid_by', '<label class="help-block text-danger">:message</label>')
                                !!}
                            </div>
                        </div>
                    </div>



                    <div class="col-md-3">
                        <div class="form-group {!! $errors->has('payment_note') ? 'error' : '' !!}">
                            <label>Paymet Note</label>
                            <div class="controls">
                                {!! Form::text('payment_note', null,[ 'class' => 'form-control mb-1', 'placeholder' =>
                                'Paymet note', 'tabindex' => 9, 'payment_note', 'id' => 'payment_note']) !!}
                                {!! $errors->first('payment_note', '<label
                                    class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>


                </div>

                @if( request()->get('payfrom')  != 'credit' )
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="input-field">
                                <input type="file" name="payment_photo" class="form-control"/>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if (isset($data['due_bills']) && $data['due_bills']->count() > 0)
                <hr>
                <h3>Due Bills</h3>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered table-sm" id="due_bill_table">
                            <thead>
                                <tr>
                                    <th style="width: 50px; " class="text-center">SL#</th>
                                    <th style="width: 100px; ">Order ID</th>
                                    <th style="width: 150px; ">Order Date</th>
                                    <th style="width: 150px; ">Bill Issue Date</th>
                                    <th style="width: 80px; ">Amount (RM)</th>
                                    <th style="width: 80px; ">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($data['due_bills'] as $item)
                                @if (isset($item->booking->BOOKING_NO) || $item->IS_PAYMENT_TO_BALANCE == 1)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>
                                            @if (isset($item->F_BOOKING_NO))
                                            <a href="{{ route('admin.order.view',['id' => $item->F_BOOKING_NO]) }}" class="link" target="_blank">ORD-{{ $item->booking->BOOKING_NO ?? '' }}</a>
                                            @else
                                            ----------
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($item->booking->CONFIRM_TIME))
                                            <span title="Confirm time">{{ date('Y-m-d',strtotime($item->booking->CONFIRM_TIME)) }}</span>
                                            @elseif(isset($item->booking->BOOKING_TIME))
                                            <span title="Booking time">{{ date('Y-m-d',strtotime($item->booking->BOOKING_TIME)) }}</span>
                                            @else
                                            ----------
                                            @endif
                                        </td>
                                        <td>
                                            {{ date('Y-m-d H:i:s',strtotime($item->SS_CREATED_ON)) }}
                                        </td>
                                        <td>{{ number_format($item->PAYMENT_AMOUNT,2) }}</td>
                                        <td>
                                            <a href="{{ route('admin.billplz.bill.delete',$item->PK_NO) }}" onclick="return confirm('Are You Sure?')" title="DELETE BILL"><button type="button" class="btn btn-xs btn-danger"><i class="la la-trash"></i></button></a>
                                            <a href="https://www.billplz.com/bills/{{ $item->BILL_ID }}" target="_blank" title="VIEW BILL"><button type="button" class="btn btn-xs btn-primary"><i class="la la-eye"></i></button></a>
                                        </td>
                                    </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered  table-sm" >
                            <thead>
                                <tr>
                                    <th style="width: 50px; " class="text-center">SL#</th>
                                    <th style="width: 100px; ">Order ID</th>
                                    <th>Product Name</th>
                                    <th style="width: 150px; ">Order Date</th>
                                    <th style="width: 150px; ">Original amount (RM)</th>
                                    <th style="width: 126px; ">Due Amount (RM)</th>
                                    <th style="width: 80px; ">Payment (RM)</th>
                                    <th style="width: 80px; ">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if(isset($data['due_orders']) && count($data['due_orders']) > 0 )
                                @foreach($data['due_orders'] as $key =>  $order )
                                <?php
                                if($order->BOOKING_PK_NO){
                                     $variants  = getVariantName($order->BOOKING_PK_NO);
                                }else{
                                    $variants = [];
                                }
                                ?>
                                <tr class="row_class">
                                    <td class="text-center">
                                        {{ $key+1 }}
                                        <input type="hidden" name="order_id[]" value="{{ $order->ORDER_PK_NO }}" />
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.booking_to_order.book-order',['id' => $order->BOOKING_PK_NO]) }}?type=view" class="link" target="_blank">ORD-{{ $order->BOOKING_NO }}</a>
                                    </td>

                                    <td class="text-left">
                                        <ul class="pl-0 list-unstyled">
                                            @if( (!empty($variants) ) && (count($variants) > 0 ) )
                                                @foreach($variants as $row)
                                                    <li>{{ $row->PRD_VARINAT_NAME }} ({{ $row->ORD_QTY }})</li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </td>
                                    <td class="text-center">

                                        @if($order->CONFIRM_TIME)
                                        <span title="Confirm time">{{ date('Y-m-d',strtotime($order->CONFIRM_TIME)) }}</span>
                                        @else
                                        <span title="Booking time">{{ date('Y-m-d',strtotime($order->BOOKING_TIME)) }}</span>
                                        @endif
                                    </td>
                                    <td class="text-right"><span>{{ number_format($order->TOTAL_PRICE,2) }}</span></td>

                                    <td class="text-right">
                                        <span>{{ number_format($order->TOTAL_PRICE - $order->ORDER_BUFFER_TOPUP - $order->DISCOUNT,2)  }}</span>
                                    </td>
                                    <td style="width:80px;">
                                        <input type="number" class="form-control  text-right number-only due_amt max_limit" value="" name="split_pay[]" data-max_amount="{{ $order->TOTAL_PRICE - $order->ORDER_BUFFER_TOPUP - $order->DISCOUNT }}" style="width:80px; display: inline; float: right;{{ isset(request()->payfrom) && request()->payfrom == 'credit' ? '' : (isset($order->innstallmentPayment) ? 'cursor:not-allowed;background:#EEEEEE;pointer-events:none;' : '') }}" min="{{ isset($order->onlinePayment->PAYMENT_POSITION) && isset($order->onlinePayment->installmentPayment) ? $order->onlinePayment->installmentPayment->CALCULATED_INSTALLMENT_AMOUNT : 0 }}">
                                    </td>
                                    <td style="width: 80px">
                                        @if(hasAccessAbility('get_billplz_url', $roles))
                                            <a href="javascript:void(0)" data-order_group_id="{{ $order->ORDER_GROUP_ID }}" id="generate_billplz_url" class="btn btn-xs btn-azura mb-05 mr-05" title="GET BILLPLZ LINK"><i class="ft-share-2"></i></a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td class="text-center text-warning" colspan="7">No order for payment </td>
                                </tr>
                                @endif
                            </tbody>

                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-actions text-center">
                            <a href="{{route('admin.customer.list')}}" class="btn btn-warning mr-1"><i class="ft-x"></i> {{ trans('form.btn_cancle') }}</a>
                            <button type="submit" class="btn bg-primary bg-darken-1 text-white save_btn prev_duplicat">
                             <i class="la la-check-square-o"></i> {{ trans('form.btn_save') }} </button>
                         </div>
                     </div>
                </div>
            </div>
            {!! Form::close() !!}
            <a href="{{ url()->previous() }}" class="btn btn-sm btn-success btn-min-width mr-1 mb-1"><i class="la la-backward" ></i> Back</a>
        </div>
    </div>
</div>
<!-- Payment modal-->
<div class="modal fade text-left" id="CustomerPayment" tabindex="-1" role="dialog"
    aria-labelledby="CustomerPayment" aria-hidden="true" style="z-index: 9999999;">
    <div class="quickView-modal modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title pay--pay" id="source_name">Pay Payment</h3>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row ml-1 mb-1" id="">
                    <div class="col-md-3 m-auto">
                        <div class="form-group">
                        <label class="due-label" for="">Insert Amount</label>
                        <input type="number" id="billplz" class="form-control quantity" value="" min="1" data-min_amount="" name="billplz" required="">
                        </div>
                    </div>
                </div>
                <div class="row mt-2" id="show_url2" style="display: none">
                    <div class="col-8 col-md-8 m-auto">
                        <p><strong>URL</strong> : <span title="CLICK TO COPY THE URL" style="cursor: pointer" id="url2"></span></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2 col-md-2 m-auto">
                        <button class="btn btn-primary mt-2" id="get_billplz_url_without_order">Get URL</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="reset" class="btn btn-secondary btn-sm" data-dismiss="modal" value="Close">
            </div>
        </div>
    </div>
</div>
<!--End  Payment modal html-->
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
<script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.date.js')}}"></script>
<script src="{{ asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('app-assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
<script>
    $('.pickadate').pickadate({
        format: 'dd-mm-yyyy',
        formatSubmit: 'dd-mm-yyyy',
    });

    $('.paymentEntryFrm').submit(function(event){
        var sum_due_amt = 0;
        var flag = 1;
        $('.due_amt').each(function() {
            sum_due_amt += Number($(this).val());
            if (Number($(this).val()) != '' && (Number($(this).val()) < Number($(this).attr('min')))) {
                $(this).addClass('border border-danger');
                $(this).parent('td').append('<p class ="text-danger">minimum value is '+Number($(this).attr('min'))+'</p>');
                event.preventDefault();
                flag = 0;
            }
        });
        var payment_amount  = Number($('#payment_amount').val());
            if(payment_amount != sum_due_amt && flag == 1){
                if(!confirm("Are you sure you want to submit the payment without assigning it to order ?")){
                    event.preventDefault();
                }

            }
        if (flag == 0) {
            event.preventDefault();
        }
    });
</script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var get_url = $('#base_url').val();
    $(document).on('change','#pay_pk_no', function(e){
        var pay_pk_no   = $(this).val();
        var currency    = $(this).find("option:selected").attr('data-currency');
        var paydate     = $(this).find("option:selected").attr('data-paydate');
        var slipno      = $(this).find("option:selected").attr('data-slipno');
        var paidby      = $(this).find("option:selected").attr('data-paidby');
        var paynote     = $(this).find("option:selected").attr('data-paynote');
        var amount      = $(this).find("option:selected").attr('data-amount');

        $('#payment_currency_no').val(currency);
        $('#payment_date').val(paydate);
        $('#ref_number').val(slipno);
        $('#paid_by').val(paidby);
        $('#payment_note').val(paynote);
        $('#payment_amount').val(amount);
    })

    $(document).on('input','.due_amt',function(){
        var payment_amount  = Number($('#payment_amount').val());
        var split_amt       = $(this).val();
        var max_amt         = $(this).data('max_amount');
        var row_sum         = 0;

        $(".due_amt").each(function(){
            row_sum += Number($(this).val());
        });

        if(payment_amount < row_sum ) {
            $(this).val('');
        }
    })

    $(document).on('input','.max_limit',function(){
        var max_val   = Number($(this).data('max_amount'));
        var this_val  = Number($(this).val());
        if(this_val > max_val){
            $(this).val(max_val);
        }
    })
    $(document).on('click','#get_billplz_url_without_order',function(){
    var amount = Number($('.quantity').val());
    var customer_id = `{{ $data['customer']->PK_NO }}`;
    var type = `{{ $data['type'] }}`;
    // $('#CustomerOrderPayment').modal('hide');
    $.ajax({
        type:'post',
        url:get_url+'/generate-billplz-url',
        data:{ amount:amount,generate_url:1,customer_id:customer_id,type:type},
        beforeSend: function () {
            $("body").css("cursor", "progress");
            $("#loader").fadeIn(300);
        },
        success: function (res) {
            if(res.msg != ''){
                alert(res.msg);
            }else if(res.bil_pay == 1 && res.url != ''){
                // window.open(res.url, '_self');
                $('#show_url2').css('display','block');
                $('#url2').html('');
                $('#url2').html(res.url);
            }
        },
        complete: function (data) {
            $("body").css("cursor", "default");
            $("#loader").fadeOut(300);
        }
    });
});
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
$(document).on('click','[id=url2]', function(){
    var copyText = $(this).html();
    var textarea = document.createElement("textarea");
    textarea.textContent = copyText;
    textarea.style.width = "1px";
    textarea.setAttribute('id','textarea');
    $('#url2').append(textarea);
    textarea.select();
    document.execCommand("copy");
    $('#textarea').remove();
    toastr.success('URL Copyied ',{timeOut: 5000})
})
$('#due_bill_table').DataTable({
    pageLength: 5,
    "lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "All"]],
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
</script>
@endpush('custom_js')
