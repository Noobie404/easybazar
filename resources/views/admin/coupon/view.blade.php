@extends('admin.layout.master')

@section('coupon_discount','active')

@section('title') Coupon view @endsection
@section('page-name') Coupon view @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('payment.breadcrumb_title')  </a></li>
    <li class="breadcrumb-item active">View Coupon </li>
@endsection

@php
    $roles = userRolePermissionArray();
@endphp
@push('custom_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/pickers/pickadate/pickadate.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/plugins/pickers/daterange/daterange.css')}}">
@endpush
@section('content')
<section id="basic-form-layouts">
    <div class="row match-height min-height">
        <div class="col-md-12">
            <div class="card card-success">
                <div class="card-content collapse show">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group {!! $errors->has('coupon_code') ? 'error' : '' !!}">
                                    <div class="controls">
                                        <label>Enter Coupon</label>
                                        {!! Form::text('coupon_code', $row['master']->COUPON_CODE, ['class'=>'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'id' => 'coupon_code', 'required','placeholder'=>'BLACKFRIDAY10']) !!}
                                        {!! $errors->first('coupon_code', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group {!! $errors->has('discount') ? 'error' : '' !!}">
                                    <div class="controls">
                                        <label>Enter Discount (%)</label>
                                        {!! Form::number('discount', $row['master']->DISCOUNT ?? null, ['class'=>'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'id' => 'discount', 'required','placeholder'=>'EX:10']) !!}
                                        {!! $errors->first('discount', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group {!! $errors->has('order_min_value') ? 'error' : '' !!}">
                                    <div class="controls">
                                        <label>Minimum Order (TK)</label>
                                        {!! Form::number('order_min_value', $row['master']->ORDER_MIN_VALUE ?? 0, ['class'=>'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'id' => 'order_min_value', 'required','placeholder'=>'EX:100']) !!}
                                        {!! $errors->first('order_min_value', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group {!! $errors->has('validity_from') ? 'error' : '' !!}">
                                    <label>Enter Start Date</label>
                                    <div class="controls">
                                        {!! Form::text('validity_from', date('d-m-Y',strtotime($row['master']->VALIDITY_FROM)) ?? null, [ 'class' => 'form-control pickadate', 'placeholder' => 'Enter start date', 'data-validation-required-message' => 'This field is required' ]) !!}
                                        {!! $errors->first('validity_from', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group {!! $errors->has('validity_to') ? 'error' : '' !!}">
                                    <label>Enter End Date</label>
                                    <div class="controls">
                                        {!! Form::text('validity_to', date('d-m-Y',strtotime($row['master']->VALIDITY_TO)) ?? null, [ 'class' => 'form-control pickadate', 'placeholder' => 'Enter end date', 'data-validation-required-message' => 'This field is required' ]) !!}
                                        {!! $errors->first('validity_to', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="controls">
                                    <label>Is active</label>
                                    {!! Form::select('is_active', array(1=>'Active',2=>'Inactive'), $row['master']->IS_ACTIVE ?? 1, ['class'=>'form-control mb-1 select2', 'data-validation-required-message' => 'This field is required', 'id' => 'is_active', 'required']) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="controls">
                                    <label>Coupon on : </label>
                                    {!! Form::select('coupon_for', array(1=>'Product',2=>'Master'), $row['master']->COUPON_ON ?? 1, ['class'=>'form-control mb-1 select2', 'data-validation-required-message' => 'This field is required', 'id' => 'coupon_for', 'required']) !!}
                                </div>
                            </div>
                        </div>
                        @if (isset($row['child']) && !empty($row['child']))
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-striped table-bordered table-sm alt-pagination50">
                                        <thead>
                                        <tr>
                                            <th style="width: 40px;">Sl.</th>
                                            <th class="text-left" style="">Photo</th>
                                            <th class="text-left" style="">Product Name</th>
                                            <th class="text-left" style="">Visibility</th>
                                            <th class="text-left" style="">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($row['child'] as $item)
                                                <tr title="PK : {{ $item->F_PRD_VARIANT_NO }}">
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td><img src="{{ asset('') }}{{ $item->THUMB_PATH }}" style="width : 50px;"></td>
                                                    <td>{{ $item->VARIANT_NAME }}</td>
                                                    <td><div class="badge {{ $item->TO_SHOW == 1 ? "badge-success" : 'badge-danger' }}" style="font-size: 14px;">{{ $item->TO_SHOW == 1 ? "visible" : 'hidden' }}</div></td>
                                                    <td><a href="{{ route('admin.product.searchlist.view',[$item->F_PRD_MASTER_SETUP_NO,'variant_id'=>$item->PK_NO,'type'=>'variant','tab'=>2]) }}" target="_blank" class="btn btn-xs btn-info mr-1"><i class="la la-eye"></i></a></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection
@push('custom_js')
<script src="{{asset('/assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('/assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
<script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.date.js')}}"></script>
<script  type="text/javascript">
    $(document).ready(function(){
        $('.pickadate').pickadate({
            format: 'dd-mm-yyyy',
            formatSubmit: 'dd-mm-yyyy',
        });
    })
</script>
@endpush
