@extends('admin.layout.master')

@section('Payment','open')
@section('merchant_payment_list','active')

@section('title') Merchant Payment @endsection
@section('page-name') Merchant Payment @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Add Merchant Payment</li>
@endsection

@push('custom_css')

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/pickers/pickadate/pickadate.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/plugins/pickers/daterange/daterange.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/extensions/toastr.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/extensions/toastr.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
    <style>
        #scrollable-dropdown-menu .tt-menu {max-height: 260px;overflow-y: auto;width: 100%;border: 1px solid #333;border-radius: 5px;}
        .twitter-typeahead {display: block !important;}
    </style>
@endpush('custom_css')
@php

$autoslip = substr(rand(0,time()),0,7);

@endphp

@section('content')
<div class="card card-success min-height">
    <div class="card-header">
        <h4 class="card-title" id="basic-layout-colored-form-control" style="text-transform: capitalize;">{{ $data['type'] ?? 'Payment Entry' }} &nbsp;</h4>

        @if($errors->any())
        {{ implode($errors->all(':message')) }}
        @endif
        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

    </div>
    <div class="card-content collapse show">
        <div class="card-body">
            {!! Form::open([ 'route' => 'merchant.payment.store', 'method' => 'post', 'class' => 'form-horizontal paymentEntryFrm prev_duplicat_frm', 'files'
            => true , 'novalidate']) !!}

            <div class="form-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group {!! $errors->has('customer') ? 'error' : '' !!}">
                            <div class="controls">
                                <label>Merchant <span class="text-danger">*</span></label>
                                <div class="controls" id="scrollable-dropdown-menu">
                                    <select name="customer" id="customer" class="form-control">
                                        @if(isset($data['row']) && count($data['row']) > 0 ) 
                                        @foreach($data['row'] as $k =>  $row ) 
                                        <option value="{{ $row->PK_NO }}">{{ $row->NAME }}</option>
                                        @endforeach 
                                        @endif
                                    </select>
                                    {!! $errors->first('customer', '<label class="help-block text-danger">:message</label>') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group {!! $errors->has('payment_currency_no') ? 'error' : '' !!}">
                            <label>Payment Currency<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::select('payment_currency_no',  $data['currency'] ?? [], 1, [ 'class' => 'form-control mb-1
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
                            <label>Payment Amount<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::number('payment_amount', null,[ 'class' => 'form-control mb-1',
                                'data-validation-required-message' => 'This field is required','placeholder' => 'Payment amount ', 'tabindex' => 6 ,'min' => 0, 'id' => 'payment_amount', 'step' => '0.01',  request()->get('payfrom')  == 'credit' ? 'readonly' : '']) !!}
                                {!! $errors->first('payment_amount', '<label
                                    class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group {!! $errors->has('ref_number') ? 'error' : '' !!}">
                            <label>Ref. Number/Slip Number<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::text('ref_number', $autoslip,[ 'class' => 'form-control mb-1',
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
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="input-field">
                                <input type="file" name="payment_photo" class="form-control"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-actions text-center">
                            <a href="{{route('merchant.payment.list')}}" class="btn btn-warning mr-1"><i class="ft-x"></i> {{ trans('form.btn_cancle') }}</a>
                            <button type="submit" class="btn bg-primary bg-darken-1 text-white save_btn prev_duplicat">
                             <i class="la la-check-square-o"></i> {{ trans('form.btn_save') }} </button>
                         </div>
                     </div>
                </div>
            </div>
            {!! Form::close() !!}

        </div>
    </div>
</div>

@endsection


@push('custom_js')
<script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.date.js')}}"></script>
<script src="{{ asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>
<script src="{{asset('/app-assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('/app-assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
<script>
    $('.pickadate').pickadate({
        format: 'dd-mm-yyyy',
        formatSubmit: 'dd-mm-yyyy',
    });


</script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var get_url = $('#base_url').val();




</script>
@endpush('custom_js')
