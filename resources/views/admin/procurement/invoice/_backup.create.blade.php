@extends('admin.layout.master')

@section('Procurement','open')
@section('invoice','active')

@section('title') @lang('invoice.new_page_title') @endsection
@section('page-name') @lang('invoice.list_page_sub_title') @endsection


@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a>
</li>
<li class="breadcrumb-item"><a href="{{ route('admin.invoice') }}"> Invoice </a>
</li>
<li class="breadcrumb-item active">Create invoice
</li>
@endsection
<?php 
$parent_vendor = $parentInvoice->F_VENDOR_NO ?? null;
$parent_invoice_currency = $parentInvoice->F_SS_CURRENCY_NO ?? null;
// dd($parent_invoice_currency);

?>

<!--push from page-->
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/forms/selects/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/file_upload/image-uploader.min.css')}}">
<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/pickers/pickadate/pickadate.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/plugins/pickers/daterange/daterange.css')}}">
<style type="text/css">
  .notForGBP{display: none;}
</style>
@endpush('custom_css')


@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title" id="basic-layout-colored-form-control"><i class="ft-plus text-primary"></i> New
        Invoice</h4>
        @if($errors->any())
        {{ implode($errors->all(':message')) }}
        @endif
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
            {!! Form::open([ 'route' => 'admin.invoice.store', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
            @csrf
            <input type="hidden" name="parent_invoice" value="{{ request()->get('parent') ?? '' }}">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group {!! $errors->has('vendor') ? 'error' : '' !!}">
                            <label>Vendor<span class="text-danger">*</span></label>
                            <div class="controls">
                                <select class="form-control mb-1 select2"  data-validation-required-message="This field is required" tabindex="1" id="vendor" name="vendor">
                                    <option> Please select vendor </option>
                                    @if($vendors && count($vendors) > 0 )
                                    @foreach($vendors as $key => $vendor)
                                    <option value="{{$vendor->PK_NO}}" data-loyality="{{$vendor->HAS_LOYALITY}}" {{ $parent_vendor == $vendor->PK_NO ? 'selected' : '' }}>{{$vendor->NAME}}</option>
                                    @endforeach
                                    @endif
                                </select>

                                {!! $errors->first('vendor', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {!! $errors->has('invoice_no') ? 'error' : '' !!}">
                            <label>Invoice Number<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::text('invoice_no', null,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Please scan or enter', 'tabindex' => 2 ]) !!}
                                {!! $errors->first('invoice_no', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {!! $errors->has('invoice_date') ? 'error' : '' !!}">
                            <label>Invoice Date<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <span class="la la-calendar-o"></span>
                                    </span>
                                </div>
                                <input type='text' class="form-control pickadate" placeholder="Invoice Date" value="{{date('d-m-Y')}}" name="invoice_date" />
                            </div>

                        </div>
                        {{-- <div class="form-group {!! $errors->has('invoice_date') ? 'error' : '' !!}">
                            <label>Invoice Date<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::date('invoice_date', null,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter invoice date', 'id' => 'date', 'tabindex' => 3,'id' => 'invoice_date' ]) !!}
                                {!! $errors->first('invoice_date', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div> --}}
                    </div>

                    <div class="col-md-4">
                        <div class="form-group {!! $errors->has('payment_source') ? 'error' : '' !!}">
                            <label>Account Source<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::select('payment_source', $accSource, null, [ 'class' => 'form-control mb-1 select2', 'placeholder' => 'Please select', 'data-validation-required-message' => 'This field is required', 'tabindex' => 4, 'id' => 'acc_source', 'data-url' => URL::to('bank_acc') ]) !!}
                                {!! $errors->first('payment_source', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {!! $errors->has('acc_bank') ? 'error' : '' !!}">
                            <label>Account Name<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::select('acc_bank', $bankAcc, null, [ 'class' => 'form-control mb-1 select2', 'placeholder' => 'Please select', 'data-validation-required-message' => 'This field is required', 'tabindex' => 4, 'id' => 'bank_acc']) !!}
                                {!! $errors->first('acc_bank', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {!! $errors->has('payment_methods') ? 'error' : '' !!}">
                            <label>Payment Method<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::select('payment_methods', $paymentMethod, null, [ 'class' => 'form-control mb-1 select2', 'placeholder' => 'Please select', 'data-validation-required-message' => 'This field is required', 'tabindex' => 4, 'id' => 'payment_method']) !!}
                                {!! $errors->first('payment_methods', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {!! $errors->has('discount_percentage') ? 'error' : '' !!}">
                            <label>Primary Discount Percentage</label>
                            <div class="controls">
                                {!! Form::number('discount_percentage', null,[ 'class' => 'form-control mb-1', 'placeholder' => 'Enter primary discount percentage', 'tabindex' => 14, 'step' => '0.01','min' => 0, 'data-validation-number-message' => 'Please enter max 2 decimal point']) !!}
                                {!! $errors->first('discount_percentage', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>

                    {{--<div class="col-md-4">
                        <div class="form-group {!! $errors->has('discount_amount') ? 'error' : '' !!}">
                            <label>Discount Amount</label>
                            <div class="controls">
                                {!! Form::number('discount_amount', null,[ 'class' => 'form-control mb-1', 'placeholder' => 'Enter discount amount', 'tabindex' => 15, 'step' => '0.001', 'min' => 0, 'data-validation-number-message' => 'Please enter max 2 decimal point']) !!}
                                {!! $errors->first('discount_amount', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div> --}}

                    <div class="col-md-4">
                        <div class="form-group {!! $errors->has('discount_percentage') ? 'error' : '' !!}">
                            <label>Secondary Discount Percentage</label>
                            <div class="controls">
                                {!! Form::number('discount_percentage2', null,[ 'class' => 'form-control mb-1', 'placeholder' => 'Enter secondary discount percentage', 'tabindex' => 14, 'step' => '0.01','min' => 0, 'data-validation-number-message' => 'Please enter max 2 decimal point']) !!}
                                {!! $errors->first('discount_percentage', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    {{--<div class="col-md-4">
                        <div class="form-group {!! $errors->has('discount_amount') ? 'error' : '' !!}">
                            <label>Discount Amount 2</label>
                            <div class="controls">
                                {!! Form::number('discount_amount2', null,[ 'class' => 'form-control mb-1', 'placeholder' => 'Enter discount amount', 'tabindex' => 15, 'step' => '0.001', 'min' => 0, 'data-validation-number-message' => 'Please enter max 2 decimal point' ]) !!}
                                {!! $errors->first('discount_amount', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div> --}}
                    {{-- <div class="col-md-4">
                        <div class="form-group {!! $errors->has('invoice_exact_value') ? 'error' : '' !!}">
                            <label>Invoice Exact Value<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::number('invoice_exact_value', null, [ 'class' => 'form-control', 'placeholder' => 'Enter invoice exact value', 'data-validation-required-message' => 'This field is required', 'tabindex' => 5, 'step' => '0.01', 'data-validation-number-message' => 'Please enter max 2 decimal point', 'min' => 0]) !!}
                                {!! $errors->first('invoice_exact_value', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div> --}}

                    <div class="col-md-4">
                        <div class="form-group {!! $errors->has('invoice_exact_value') ? 'error' : '' !!}">
                            <label>Invoice Exact Value<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::text('invoice_exact_value', null, [ 'class' => 'form-control', 'placeholder' => 'Enter invoice exact value', 'data-validation-required-message' => 'This field is required', 'tabindex' => 5]) !!}
                                {!! $errors->first('invoice_exact_value', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>




                    <div class="col-md-4">
                        <div class="form-group {!! $errors->has('purchaser') ? 'error' : '' !!}">
                            <label>Purchaser<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::select('purchaser', $user, null, [ 'class' => 'form-control mb-1 select2', 'placeholder' => 'Please select purchaser', 'data-validation-required-message' => 'This field is required', 'tabindex' => 5]) !!}
                                {!! $errors->first('purchaser', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {!! $errors->has('currency') ? 'error' : '' !!}">
                            <label>Purchase Currency<span class="text-danger">*</span></label>
                            <div class="controls">
                                <select class="form-control mb-1" data-validation-required-message="This field is required" tabindex="6" name="currency" id="purchase_currency">
                                    @if($currency)
                                    @foreach($currency as $key => $val)
                                    <option value="{{$val->PK_NO}}" data-rate="{{$val->EXCHANGE_RATE_GB}}" data-code="{{$val->CODE}}" >{{$val->NAME}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                {!! $errors->first('currency', '<label class="help-block text-danger">:message</label>') !!}



                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {!! $errors->has('has_loyality') ? 'error' : '' !!}">
                            <label>Has Loyality Scheme<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::select('has_loyality', ['1' => 'Yes', '0' => 'No'], null, [ 'class' => 'form-control mb-1 ', 'placeholder' => 'Please select', 'tabindex' => 17, 'id' => 'has_loyality', 'disabled' => 'disabled' ]) !!}
                                {!! $errors->first('has_loyality', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>

                    {{--<div class="col-md-4">
                        <div class="form-group {!! $errors->has('total_qty') ? 'error' : '' !!}">
                            <label>Total Quantity</label>
                            <div class="controls">
                                {!! Form::number('total_qty', null,[ 'class' => 'form-control mb-1', 'placeholder' => 'Enter total quantity', 'data-validation-required-message' => 'This field is required', 'tabindex' => 9, 'min' => 0 ]) !!}
                                {!! $errors->first('total_qty', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div> --}}
                    {{--<div class="col-md-4">
                        <div class="form-group {!! $errors->has('recieved_qty') ? 'error' : '' !!}">
                            <label>Recieved Quantity</label>
                            <div class="controls">
                                {!! Form::number('recieved_qty', null,[ 'class' => 'form-control mb-1', 'placeholder' => 'Enter recieved quantity', 'data-validation-required-message' => 'This field is required', 'tabindex' => 10, 'min' => 0 ]) !!}
                                {!! $errors->first('recieved_qty', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div> --}}
                    {{--<div class="col-md-4">
                        <div class="form-group {!! $errors->has('total_amount') ? 'error' : '' !!}">
                            <label>Total Amount<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::number('total_amount', null,[ 'class' => 'form-control mb-1', 'placeholder' => 'Enter total amount', 'data-validation-required-message' => 'This field is required', 'tabindex' => 11, 'step' => '0.001', 'min' => 0, 'data-validation-number-message' => 'Please enter max 2 decimal point']) !!}
                                {!! $errors->first('total_amount', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div> --}}
                    {{--<div class="col-md-4">
                        <div class="form-group {!! $errors->has('total_vat') ? 'error' : '' !!}">
                            <label>Total Vat</label>
                            <div class="controls">
                                {!! Form::number('total_vat', null,[ 'class' => 'form-control mb-1', 'placeholder' => 'Enter total vat', 'tabindex' => 12,'step' => '0.001', 'min' => 0, 'data-validation-number-message' => 'Please enter max 2 decimal point']) !!}
                                {!! $errors->first('total_vat', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>--}}
                    {{--<div class="col-md-4">
                        <div class="form-group {!! $errors->has('discount_percentage') ? 'error' : '' !!}">
                            <label>Total Except Vat</label>
                            <div class="controls">
                                {!! Form::number('total_accept_vat', null,[ 'class' => 'form-control mb-1', 'placeholder' => 'Enter discount amount', 'tabindex' => 13, 'step' => '0.001', 'min' => 0, 'data-validation-number-message' => 'Please enter max 2 decimal point']) !!}
                                {!! $errors->first('discount_percentage', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>--}}

                    {{-- <div class="col-md-4">
                        <div class="form-group {!! $errors->has('has_vat_refund') ? 'error' : '' !!}">
                            <label>Has Vat Refund<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::select('has_vat_refund', ['1' => 'Yes', '0' => 'No'], null, [ 'class' => 'form-control mb-1 select2', 'placeholder' => 'Please select', 'data-validation-required-message' => 'This field is required', 'tabindex' => 16,'min' => 0]) !!}
                                {!! $errors->first('has_vat_refund', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div> --}}

                    {{-- <div class="col-md-4">
                        <div class="form-group {!! $errors->has('loyality_claimed') ? 'error' : '' !!}">
                            <label>Loyality Claimed</label>
                            <div class="controls">
                                {!! Form::text('loyality_claimed', null, [ 'class' => 'form-control mb-1', 'placeholder' => 'Please enter', 'tabindex' => 18]) !!}
                                {!! $errors->first('loyality_claimed', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div> --}}

                    {{-- <div class="col-md-4">
                        <div class="form-group {!! $errors->has('settlement_amt') ? 'error' : '' !!}">
                            <label>Settlement Amount</label>
                            <div class="controls">
                                {!! Form::number('settlement_amt', null, [ 'class' => 'form-control mb-1', 'placeholder' => 'Please enter', 'tabindex' => 18, 'minlength' => 0, 'min' => 0]) !!}
                                {!! $errors->first('settlement_amt', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-md-4">
                        <div class="form-group {!! $errors->has('gbp_to_mr') ? 'error' : '' !!}">
                            <label>GBP To MR Rate<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::number('gbp_to_mr', $gbpToMrRate->EXCHANGE_RATE_GB, [ 'class' => 'form-control mb-1','data-validation-required-message' => 'This field is required', 'step' => '0.001', 'placeholder' => 'Please enter rate', 'tabindex' => 7, 'min' => 0, 'data-validation-number-message' => 'Please enter max 3 decimal point', 'readonly' => true]) !!}
                                {!! $errors->first('gbp_to_mr', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 notForGBP">
                        <div class="form-group {!! $errors->has('gbp_to_ac') ? 'error' : '' !!}">
                            <label> GBP To <span id="alian_currency">GBP</span> Rate</label>
                            <div class="controls">
                                {!! Form::number('gbp_to_ac', null, [ 'class' => 'form-control mb-1', 'placeholder' => 'Please enter rate', 'tabindex' => 8, 'step' => '0.001', 'min' => 0, 'data-validation-number-message' => 'Please enter max 3 decimal point','id' => 'gbp_to_ac', 'readonly' => true ]) !!}
                                {!! $errors->first('gbp_to_ac', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>


                </div>
               


                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="input-field">
                                <label class="active">Image<span class="text-danger">*</span></label>
                                <div class="file_upload" style="padding-top: .5rem;" title="Click for photo upload">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions mt-10 text-center">
                <a href="{{ route('admin.invoice')}}">
                    <button type="button" class="btn btn-warning mr-1">
                        <i class="ft-x"></i> Cancel
                    </button>
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="la la-check-square-o"></i> Save
                </button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection

<!--push from page-->
@push('custom_js')
<script src="{{ asset('assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{ asset('assets/js/scripts/forms/select/form-select2.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/file_upload/image-uploader.min.js')}}"></script>
<script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.date.js')}}"></script>

<script type="text/javascript" src="{{ asset('assets/pages/invoice.js')}}"></script>
<script>

function setLoyality(loyality){
    if (loyality == 1) {
        $("#has_loyality").select2().val(1).trigger("change");

   }else{
        $("#has_loyality").select2().val(0).trigger("change");
    }
}

function setPurchaseCurrency(invoice_currency)
{
    $('#purchase_currency').val(invoice_currency);
}

function showHideConversionRate(currency){
    if (currency == 1 || currency == 2) {
        $('.notForGBP').hide();
    }else{
        $('.notForGBP').show();
    }
}

$(document).on('change','#purchase_currency', function(e){
    var currency = $(this).val();
    showHideConversionRate(currency);
})

$(document).ready(function() {
    var loyality = $(this).select2().find(":selected").data("loyality");
    setLoyality(loyality);

})


$(document).on('change', '#vendor', function(e){
    var loyality = $(this).select2().find(":selected").data("loyality");
    setLoyality(loyality);
})


$(document).ready(function () {

    var loyality = $('#vendor').select2().find(":selected").data("loyality");
    setLoyality(loyality);

    var parent_invoice_currency = `{{$parent_invoice_currency}}`;
    setPurchaseCurrency(parent_invoice_currency);
    showHideConversionRate(parent_invoice_currency);

    var yesterday = new Date((new Date()).valueOf()-1000*60*60*24);
    $('.pickadate').pickadate({
        format: 'dd-mm-yyyy',
        formatSubmit: 'dd-mm-yyyy',
        max:!0,
    });
})


    $(function () {
        $('.file_upload').imageUploader({
            extensions:[".jpg",".jpeg",".png",".gif",".svg", ".pdf", ".PNG"],
            mimes:["image/jpeg","image/png","image/gif","image/svg+xml","application/pdf"]
        });
    });

</script>
@endpush('custom_js')
