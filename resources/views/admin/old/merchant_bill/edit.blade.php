@extends('admin.layout.master')

@section('merchant_bill','active')
@section('Payment','open')

@section('title') Merchant Bill | Edit @endsection
@section('page-name') Merchant Bill | Edit @endsection


@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item"><a href="{{ route('admin.invoice') }}">Edit Invoice </a></li>
<li class="breadcrumb-item active">Edit invoice</li>

@endsection

@push('custom_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/pickers/pickadate/pickadate.css')}}">
    <style type="text/css">
        .notForGBP{display: none;}
        .w-100{width: 100px !important; float: right; text-align: right;}
    </style>
@endpush('custom_css')

<?php
    $roles = userRolePermissionArray();
    $tab_index = 0;
?>

@section('content')
<div class="card card-success min-height">
    <div class="card-header">
        <h4 class="card-title" id="basic-layout-colored-form-control"><i class="ft-plus text-primary"></i> Edit Merchant Bill</h4>
        {{-- @if($errors->any())
        {{ implode($errors->all(':message')) }}
        @endif --}}
        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
            <ul class="list-inline mb-0">
                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                <li><a data-action="close"><i class="ft-x"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="card-content collapse show">
        <div class="card-body">
            {!! Form::open([ 'route' => ['admin.mer_bill.update', $data['row']->PK_NO ], 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
            <div class="row">
                <div class="col-md-6">
                    <h4>Bill From</h4>
                    <p>{{ $data['from_address']->NAME ?? '' }}</p>
                    <p>{{ $data['from_address']->ADDRESS_LINE_1 ?? '' }}</p>
                    <p>{{ $data['from_address']->CITY ?? '' }} {{ $data['from_address']->POST_CODE ?? '' }}</p>
                    <p>{{ $data['from_address']->STATE ?? '' }}, {{ $data['from_address']->COUNTRY ?? '' }}</p>
                    <p>{{ $data['from_address']->TEL_NO ?? '' }}</p>
                </div>
                <div class="col-md-6">
                    <h4>Bill To</h4>
                    @if($data['to_address'])
                    <p>{{ $data['to_address']->NAME ?? '' }}</p>
                    <p>{{ $data['to_address']->ADDRESS_LINE_1 ?? '' }}</p>
                    <p>{{ $data['to_address']->ADDRESS_LINE_2 ?? '' }}</p>
                    <p>{{ $data['to_address']->CITY ?? '' }}, {{ $data['to_address']->POST_CODE ?? '' }}</p>
                    <p>{{ $data['to_address']->STATE ?? '' }}, {{ $data['to_address']->COUNTRY ?? '' }}</p>
                    <p>{{ $data['to_address']->TEL_NO ?? '' }}</p>
                    @else
                    <p>Not set yet</p>
                    @endif
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <p>Bill No : <b>{{ $data['row']->SHIPMENT_NO }}</b></p>
                    <div class="form-group {!! $errors->has('invoice_date') ? 'error' : '' !!}">
                        <label>Invoice Date<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <span class="la la-calendar-o"></span>
                                </span>
                            </div>
                            @php $bill_date = $data['row']->BILL_DATE ?? $data['row']->GENERATE_DATE; @endphp
                            <input type='text' class="form-control pickadate" placeholder="Invoice Date" value="{{date('d-m-Y', strtotime($bill_date))}}" name="invoice_date" tabindex="{{ $tab_index++ }}" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered" >
                        <thead>
                        <tr>
                            <th class="text-center">SL.</th>
                            <th class="text-center" style="width: 80px;">Date</th>
                            <th>Vendor</th>
                            <th>Invoice For</th>
                            <th>Reciept No</th>
                            <th>Currency</th>
                            <th class="text-center">Qty</th>
                            <th class="text-right">Invoice Value</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(isset($data['invoices']) && count($data['invoices']) > 0 )
                            @php $invoice_exact_value = 0; $recieved_qty = 0; @endphp
                            @foreach($data['invoices'] as $key => $row )
                            @php
                                $invoice_exact_value += $row->MER_INVOICE_TOTAL_ACTUAL_GBP;
                                $recieved_qty += $row->RECIEVED_QTY;
                            @endphp
                            <tr class="tr_{{ $row->PK_NO }}">
                                <td class="text-center">
                                    {{ $key+1 }}
                                </td>
                                <td>{{ date('d-m-Y',strtotime($row->INVOICE_DATE)) }}</td>
                                <td>{{ $row->VENDOR_NAME }}</td>
                                <td>{{ $data['merchant']->NAME }}</td>
                                <td>{{ $row->INVOICE_NO }}</td>
                                <td>{{ $row->INVOICE_CURRENCY }}</td>
                                <td class="text-center">{{ $row->RECIEVED_QTY }}</td>
                                <td class="text-right">
                                    {{ number_format($row->MER_INVOICE_TOTAL_ACTUAL_GBP,2) }}
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="6"><b>Total</b></td>
                                <td class="text-center">
                                    <b>{{ $recieved_qty }}</b>
                                </td>
                                <td class="text-right">
                                    <b> {{  number_format($invoice_exact_value,2) }}</b>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7" class="text-right"><b>Bill Discount</b></td>
                                <td>
                                    <div class="form-group {!! $errors->has('discount') ? 'error' : '' !!}">
                                        <div class="controls">
                                            {!! Form::text('discount', $data['row']->DISCOUNT,[ 'class' => 'form-control mb-0 w-100', 'tabindex' =>$tab_index++ ]) !!}
                                            {!! $errors->first('discount', '<label class="help-block text-danger">:message</label>') !!}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7" class="text-right"><b>Net Amount</b></td>
                                <td>
                                    <div class="form-group {!! $errors->has('net_amount') ? 'error' : '' !!}">
                                        <div class="controls">
                                            {!! Form::text('net_amount', $data['row']->NET_AMOUNT,[ 'class' => 'form-control mb-0 w-100', 'tabindex' =>$tab_index++, 'readonly' ]) !!}
                                            {!! $errors->first('net_amount', '<label class="help-block text-danger">:message</label>') !!}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7" class="text-right"><b>Paid Amount</b></td>
                                <td>
                                    <div class="form-group {!! $errors->has('paid_amount') ? 'error' : '' !!}">
                                        <div class="controls">
                                            {!! Form::text('paid_amount', $data['row']->PAID_AMOUNT ?? 0,[ 'class' => 'form-control mb-0 w-100', 'tabindex' =>$tab_index++, 'readonly' ]) !!}
                                            {!! $errors->first('paid_amount', '<label class="help-block text-danger">:message</label>') !!}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7" class="text-right"><b>Due Amount</b></td>
                                <td>
                                    <div class="form-group {!! $errors->has('due_amount') ? 'error' : '' !!}">
                                        <div class="controls">
                                            {!! Form::text('due_amount', $data['row']->DUE_AMOUNT ?? 0,[ 'class' => 'form-control mb-0 w-100', 'tabindex' =>$tab_index++, 'readonly' ]) !!}
                                            {!! $errors->first('due_amount', '<label class="help-block text-danger">:message</label>') !!}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @if($data['row']->DUE_AMOUNT > 0 )
                            @php
                                $cradit_bal = $data['merchant']->CUM_BALANCE - $data['merchant']->CUM_BALANCE_USED;
                                $max_amount = $data['row']->DUE_AMOUNT;
                                if($cradit_bal < $max_amount){
                                    $max_amount = $cradit_bal;
                                }
                            @endphp
                            <tr>
                                <td colspan="7" class="text-right"><b>Payment assign from merchant credit balance</b></td>
                                <td>
                                    <div class="form-group {!! $errors->has('pay_amount') ? 'error' : '' !!}">
                                        <div class="controls">
                                            {!! Form::text('pay_amount', $max_amount,[ 'class' => 'form-control mb-0 w-100', 'tabindex' => $tab_index++, 'max'=>$max_amount ]) !!}
                                            {!! $errors->first('pay_amount', '<label class="help-block text-danger">:message</label>') !!}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endif

                            @else
                            <tr>
                                <td colspan="10" class="text-center">Data not found</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-actions text-center mt-3">
                        <a href="{{ route('admin.mer_bill.list') }}">
                            <button type="button" class="btn btn-warning mr-1">
                            <i class="ft-x"></i>@lang('form.btn_cancle')
                            </button>
                        </a>
                        <button type="submit" class="btn btn-primary" name="submit" value="update"><i class="la la-check-square-o"></i>Update</button>

                    </div>
                </div>
            </div>



            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection

<!--push from page-->
@push('custom_js')

<script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.date.js')}}"></script>

<script>
       $('.pickadate').pickadate({
        format: 'dd-mm-yyyy',
        formatSubmit: 'dd-mm-yyyy',

    });
</script>

@endpush('custom_js')
