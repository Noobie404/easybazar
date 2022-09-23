@extends('admin.layout.master')
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/core/colors/palette-tooltip.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endpush

@section('Accounts','open')
@section('payments_purchase','active')

@section('title') Create Payment @endsection
@section('page-name') Create Payment @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('payment.breadcrumb_title')</a></li>
    <li class="breadcrumb-item active"> Create Payment</li>
@endsection
@php
    $roles = userRolePermissionArray();
    $accounts = [];
    $tabindex = 0;
    $status = [ 1 => 'Active', 0 => 'Inactive'];
    $supplier = [];
    $invoice = [];
@endphp

@section('content')
    <!-- Alternative pagination table -->
    <div class="content-body">
        <section>
            <div class="row">
                <div class="col-12">
                    <div class="card card-success">
                        <div class="card-header">
                            Create purchase payment
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
                        <div class="card-content">
                            <div class="card-body">

                                <div class="card-body">
                                    {!! Form::open([ 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group {!! $errors->has('supplier') ? 'error' : '' !!}">
                                                    <label>Supplier<span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        {!! Form::select('supplier', $supplier, null, [ 'class' => 'form-control mb-1', 'placeholder' => 'Select supplier','data-validation-required-message' => 'This field is required', 'tabindex' => $tabindex++]) !!}
                                                        {!! $errors->first('supplier', '<label class="help-block text-danger">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group {!! $errors->has('balance') ? 'error' : '' !!}">
                                                    <label>Purchase Total<span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        {!! Form::number('balance', null, [ 'class' => 'form-control mb-1', 'placeholder' => 'Purchase Total', 'data-validation-required-message' => 'This field is required', 'tabindex' => $tabindex++, 'readonly' => true, ]) !!}
                                                        {!! $errors->first('balance', '<label class="help-block text-danger">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group {!! $errors->has('balance') ? 'error' : '' !!}">
                                                    <label>Total Paid<span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        {!! Form::number('balance', null, [ 'class' => 'form-control mb-1', 'placeholder' => 'Total Paid', 'data-validation-required-message' => 'This field is required', 'tabindex' => $tabindex++, 'readonly' => true, ]) !!}
                                                        {!! $errors->first('balance', '<label class="help-block text-danger">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group {!! $errors->has('balance') ? 'error' : '' !!}">
                                                    <label>Total Due<span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        {!! Form::number('balance', null, [ 'class' => 'form-control mb-1', 'placeholder' => 'Total Due', 'data-validation-required-message' => 'This field is required', 'tabindex' => $tabindex++, 'readonly' => true, ]) !!}
                                                        {!! $errors->first('balance', '<label class="help-block text-danger">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group {!! $errors->has('account') ? 'error' : '' !!}">
                                                    <label>Select Invoice<span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        {!! Form::select('account',$invoice,null,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'tabindex' => $tabindex++,  'placeholder' => 'Select account', ]) !!}
                                                        {!! $errors->first('account', '<label class="help-block text-danger">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="3">
                                                                INVOCIE-101 Purchase Details
                                                            </th>
                                                            <th>
                                                                <button type="button" class="btn btn-danger float-right"><i class="fas fa-times"></i></button>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <p>Purchase No</p>
                                                                <input type="text" readonly value="INVOCIE-101" name="invoice_no" class="form-control" />
                                                            </td>
                                                            <td>
                                                                <p>Total</p>
                                                                <input type="text" readonly value="1200.00" name="invoice_total" class="form-control" />
                                                            </td>
                                                            <td>
                                                                <p>Due</p>
                                                                <input type="text" readonly value="INVOCIE-101" name="invoice_total_due" class="form-control" />
                                                            </td>
                                                            <td>
                                                                <p>Paid Amount</p>
                                                                <div class="controls">
                                                                    {!! Form::number('amount', null, [ 'class' => 'form-control mb-1', 'placeholder' => 'Enter amount', 'data-validation-required-message' => 'This field is required', 'tabindex' => $tabindex++ ]) !!}
                                                                    {!! $errors->first('amount', '<label class="help-block text-danger">:message</label>') !!}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group {!! $errors->has('account') ? 'error' : '' !!}">
                                                    <label>Total Payment<span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        {!! Form::text('account',null,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'tabindex' => $tabindex++,  'placeholder' => 'Select account', 'readonly' => true,]) !!}
                                                        {!! $errors->first('account', '<label class="help-block text-danger">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group {!! $errors->has('account') ? 'error' : '' !!}">
                                                    <label>Account<span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        {!! Form::select('account',$accounts,null,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'tabindex' => $tabindex++,  'placeholder' => 'Select account', ]) !!}
                                                        {!! $errors->first('account', '<label class="help-block text-danger">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>

                                             <div class="col-md-4">
                                                <div class="form-group {!! $errors->has('balance') ? 'error' : '' !!}">
                                                    <label>Available Balance<span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        {!! Form::number('balance', null, [ 'class' => 'form-control mb-1', 'placeholder' => 'Available Balance', 'data-validation-required-message' => 'This field is required', 'tabindex' => $tabindex++, 'readonly' => true, ]) !!}
                                                        {!! $errors->first('balance', '<label class="help-block text-danger">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group {!! $errors->has('cheque_no') ? 'error' : '' !!}">
                                                    <label>Cheque No<span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        {!! Form::number('cheque_no', null, [ 'class' => 'form-control mb-1', 'placeholder' => 'Enter cheque no', 'data-validation-required-message' => 'This field is required', 'tabindex' => $tabindex++ ]) !!}
                                                        {!! $errors->first('cheque_no', '<label class="help-block text-danger">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group {!! $errors->has('receipt_no') ? 'error' : '' !!}">
                                                    <label>Receipt No<span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        {!! Form::number('receipt_no', null, [ 'class' => 'form-control mb-1', 'placeholder' => 'Enter receipt no', 'data-validation-required-message' => 'This field is required', 'tabindex' => $tabindex++ ]) !!}
                                                        {!! $errors->first('receipt_no', '<label class="help-block text-danger">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-3">
                                                <div class="form-group {!! $errors->has('date') ? 'error' : '' !!}">
                                                    <label>Date<span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        {!! Form::text('date', null, [ 'class' => 'form-control mb-1 pickadate datepicker', 'data-validation-required-message' => 'This field is required', 'tabindex' => $tabindex++ ]) !!}
                                                        {!! $errors->first('date', '<label class="help-block text-danger">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group {!! $errors->has('status') ? 'error' : '' !!}">
                                                    <label>Status<span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        {!! Form::select('status', $status, 1, [ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'tabindex' => $tabindex++ ]) !!}
                                                        {!! $errors->first('status', '<label class="help-block text-danger">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group {!! $errors->has('note') ? 'error' : '' !!}">
                                                    <label>Note<span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        {!! Form::textarea('note', null, [ 'class' => 'form-control mb-1', 'placeholder' => 'Write your note here..', 'data-validation-required-message' => 'This field is required', 'tabindex' => $tabindex++, 'rows' => 3 ]) !!}
                                                        {!! $errors->first('note', '<label class="help-block text-danger">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-actions text-center mt-3">
                                                    <a href="" title="Cancel" class="btn btn-warning mr-1"><i class="ft-x"></i>@lang('form.btn_cancle') </a>
                                                    <button type="submit" class="btn btn-primary" title="Save" title="Save"><i class="la la-check-square-o"></i>@lang('form.btn_save') </button>
                                                </div>
                                            </div>
                                        </div>
                                    {!! Form::close() !!}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('custom_js')
<script type="text/javascript" src="{{ asset('assets/pages/account.js')}}"></script>
<script src="{{asset('/assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('/assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
@endpush('custom_js')
