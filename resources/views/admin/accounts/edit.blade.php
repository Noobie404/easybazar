@extends('admin.layout.master')
@section('title') Edit account @endsection
@section('page-name') Edit account @endsection

@section('Accounts','open')
@section('payment_bank','active')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('payment.breadcrumb_title')  </a></li>
    <li class="breadcrumb-item active">@lang('payment.breadcrumb_sub_title')    </li>
@endsection
<?php

$tabindex = 1;
$status = [ 1 => 'Active', 0 => 'Inactive'];
if($row->IS_COD == 1){
    $is_cod = [ 1 => 'YES'];
}else{
    $is_cod = [0 => 'NO'];
}

?>
@push('custom_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/pickers/pickadate/pickadate.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/plugins/pickers/daterange/daterange.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/extensions/toastr.css')}}">
    <style>
        #scrollable-dropdown-menu .tt-menu {max-height: 260px;overflow-y: auto;width: 100%;border: 1px solid #333;border-radius: 5px;}
        .twitter-typeahead {display: block !important;}
    </style>
@endpush('custom_css')

@section('content')
<section id="basic-form-layouts">
    <div class="row match-height min-height">
        <div class="col-md-12">
            <div class="card card-success">
                <div class="card-content collapse show">
                    <div class="card-body">
                        {!! Form::open([ 'route' => ['admin.accounts.update',$row->PK_NO], 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group {!! $errors->has('bank_name') ? 'error' : '' !!}">
                                        <label>Bank Name<span class="text-danger">*</span></label>
                                        <div class="controls">
                                            {!! Form::text('bank_name', $row->BANK_NAME, [ 'class' => 'form-control mb-1', 'placeholder' => 'Enter bank name', 'data-validation-required-message' => 'This field is required', 'tabindex' => $tabindex++ ]) !!}
                                            {!! $errors->first('bank_name', '<label class="help-block text-danger">:message</label>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group {!! $errors->has('branch_name') ? 'error' : '' !!}">
                                        <label>Branch Name<span class="text-danger">*</span></label>
                                        <div class="controls">
                                            {!! Form::text('branch_name', $row->BRANCH_NAME, [ 'class' => 'form-control mb-1', 'placeholder' => 'Enter branch name', 'data-validation-required-message' => 'This field is required', 'tabindex' => $tabindex++ ]) !!}
                                            {!! $errors->first('branch_name', '<label class="help-block text-danger">:message</label>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group {!! $errors->has('bank_acc_name') ? 'error' : '' !!}">
                                        <label>Bank Account Name<span class="text-danger">*</span></label>
                                        <div class="controls">
                                            {!! Form::text('bank_acc_name', $row->BANK_ACC_NAME, [ 'class' => 'form-control mb-1', 'placeholder' => 'Enter bank account name', 'data-validation-required-message' => 'This field is required', 'tabindex' => $tabindex++ ]) !!}
                                            {!! $errors->first('bank_acc_name', '<label class="help-block text-danger">:message</label>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group {!! $errors->has('bank_acc_no') ? 'error' : '' !!}">
                                        <label>Account Number<span class="text-danger">*</span></label>
                                        <div class="controls">
                                            {!! Form::number('bank_acc_no', $row->BANK_ACC_NO, [ 'class' => 'form-control mb-1', 'placeholder' => 'Enter account number', 'data-validation-required-message' => 'This field is required', 'tabindex' => $tabindex++ ]) !!}
                                            {!! $errors->first('bank_acc_no', '<label class="help-block text-danger">:message</label>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group {!! $errors->has('status') ? 'error' : '' !!}">
                                        <label>Status<span class="text-danger">*</span></label>
                                        <div class="controls">
                                            {!! Form::select('status', $status, 1, [ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'tabindex' => $tabindex++ ]) !!}
                                            {!! $errors->first('status', '<label class="help-block text-danger">:message</label>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group {!! $errors->has('date') ? 'error' : '' !!}">
                                        <label>Date<span class="text-danger">*</span></label>
                                        <div class="controls">
                                            {!! Form::text('date', $row->START_DATE, [ 'class' => 'form-control mb-1 pickadate datepicker', 'data-validation-required-message' => 'This field is required', 'tabindex' => $tabindex++ ]) !!}
                                            {!! $errors->first('date', '<label class="help-block text-danger">:message</label>') !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group {!! $errors->has('is_cod') ? 'error' : '' !!}">
                                        <label>Is COD<span class="text-danger">*</span></label>
                                        <div class="controls">
                                            {!! Form::select('is_cod', $is_cod, $row->IS_COD, [ 'class' => 'form-control mb-1 is_cod', 'data-validation-required-message' => 'This field is required', 'tabindex' => $tabindex++ ]) !!}
                                            {!! $errors->first('is_cod', '<label class="help-block text-danger">:message</label>') !!}
                                        </div>
                                    </div>
                                </div>
                                @if($row->IS_COD == 1)
                                    <div class="col-md-4 cod_user_div ">
                                        <div class="form-group {!! $errors->has('cod_user') ? 'error' : '' !!}">
                                            <label>COD User<span class="text-danger">*</span></label>
                                            <div class="controls">
                                                <select class="form-control mb-1" name="cod_user" tabindex="{{ $tabindex++  }}">
                                                    @if(isset($codUser) && count($codUser)>0)
                                                        @foreach($codUser as $key => $val)
                                                            <option value="{{ $val->PK_NO }}">{{ $val->NAME . '-' . $val->EMAIL }}-{{ $val->USER_TYPE ==0 ? 'Admin' : 'Deliveryboy'  }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                {!! $errors->first('cod_user', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-actions text-center mt-3">
                                        <a href="{{ route('admin.accounts.list') }}" title="Cancel" class="btn btn-warning mr-1"><i class="ft-x"></i>@lang('form.btn_cancle') </a>
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
</section>
@endsection



@push('custom_js')
<script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.date.js')}}"></script>
<script src="{{ asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>
<script>
    $('.pickadate').pickadate({
        format: 'yyyy-mm-dd',
        formatSubmit: 'yyyy-mm-dd',
    });

</script>
@endpush
