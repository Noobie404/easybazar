@extends('seller.layout.master')

@section('Procurement','open')
@section('invoice','active')

@section('title') @lang('invoice.new_page_title') @endsection
@section('page-name') {{ request()->get('invoice_for') == 'merchant' ? 'Merchant' : '' }} @lang('invoice.list_page_sub_title') @endsection


@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('seller.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item"><a href="{{ route('seller.invoice') }}"> Invoice </a></li>
<li class="breadcrumb-item active">Create invoice</li>
@endsection
<?php
$parent_vendor              = $parentInvoice->F_VENDOR_NO ?? null;
$parent_invoice_currency    = $parentInvoice->F_SS_CURRENCY_NO ?? 1;
$tab_index                  = 1;

?>

<!--push from page-->
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/forms/selects/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/file_upload/image-uploader.min.css')}}">
<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/pickers/pickadate/pickadate.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/pickers/daterange/daterange.css')}}">
@endpush('custom_css')


@section('content')
<div class="card card-success min-height">
    <div class="card-header">
        <h4 class="card-title" id="basic-layout-colored-form-control"><i class="ft-plus text-primary"></i>New Invoice
        {{ implode($errors->all(':message')) }}
        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
        {{-- <div class="heading-elements">
            @if(request()->get('invoice_for') == 'merchant')
            <a href="{{ route('seller.invoice.new') }}?invoice_for=azuramart">Click for Azuramart Invoice Entry</a>
            @else
            <a href="{{ route('seller.invoice.new') }}?invoice_for=merchant">Click for Merchant Invoice Entry</a>
            @endif
        </div> --}}
    </div>
    <div class="card-content collapse show">
        <div class="card-body">
            {!! Form::open([ 'route' => 'seller.invoice.store', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate', 'id' => 'invoiceMasterFrm']) !!}
            <input type="hidden" name="parent_invoice" value="{{ request()->get('parent') ?? '' }}">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group {!! $errors->has('vendor') ? 'error' : '' !!}">
                            <label>Vendor<span class="text-danger">*</span></label>
                            <div class="controls">
                                <select class="form-control mb-1 select2"  data-validation-required-message="This field is required" tabindex="{{ $tab_index++ }}" id="vendor" name="vendor">
                                    <option value=""> Please select vendor </option>
                                    @if($vendors && count($vendors) > 0 )
                                    @foreach($vendors as $key => $vendor)
                                    <option value="{{$vendor->PK_NO}}" data-loyality="{{$vendor->HAS_LOYALITY}}" {{ $parent_vendor == $vendor->PK_NO ? 'selected' : '' }} data-country_id="{{ $vendor->F_COUNTRY  }}">{{$vendor->NAME}}</option>
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
                                {!! Form::text('invoice_no', null,[ 'class' => 'form-control mb-1 invoice_no', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Please scan or enter', 'tabindex' =>$tab_index++ ]) !!}
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
                                <input type='text' class="form-control pickadate" placeholder="Invoice Date" value="{{date('d-m-Y')}}" name="invoice_date" tabindex="{{ $tab_index++ }}" />
                            </div>

                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group {!! $errors->has('payment_source') ? 'error' : '' !!}">
                            <label>Account Source<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::select('payment_source', $accSource, null, [ 'class' => 'form-control mb-1 select2', 'placeholder' => 'Please select', 'data-validation-required-message' => 'This field is required', 'tabindex' =>$tab_index++, 'id' => 'acc_source', 'data-url' => URL::to('seller/bank_acc') ]) !!}
                                {!! $errors->first('payment_source', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {!! $errors->has('acc_bank') ? 'error' : '' !!}">
                            <label>Account Name<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::select('acc_bank', $bankAcc, null, [ 'class' => 'form-control mb-1 select2', 'placeholder' => 'Please select', 'data-validation-required-message' => 'This field is required', 'tabindex' =>$tab_index++, 'id' => 'bank_acc']) !!}
                                {!! $errors->first('acc_bank', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {!! $errors->has('payment_methods') ? 'error' : '' !!}">
                            <label>Payment Method<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::select('payment_methods', $paymentMethod, null, [ 'class' => 'form-control mb-1 select2', 'placeholder' => 'Please select', 'data-validation-required-message' => 'This field is required', 'tabindex' =>$tab_index++, 'id' => 'payment_method']) !!}
                                {!! $errors->first('payment_methods', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {!! $errors->has('store_no') ? 'error' : '' !!}">
                            <label>Select Store<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::select('store_no', $stores, null, [ 'class' => 'form-control mb-1 select2', 'placeholder' => 'Please select', 'data-validation-required-message' => 'This field is required', 'tabindex' =>$tab_index++, 'id' => 'store_no']) !!}
                                {!! $errors->first('store_no', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {!! $errors->has('discount_percentage') ? 'error' : '' !!}">
                            <label>Primary Discount Percentage</label>
                            <div class="controls">
                                {!! Form::number('discount_percentage', null,[ 'class' => 'form-control mb-1', 'placeholder' => 'Enter primary discount percentage', 'tabindex' =>$tab_index++, 'step' => '0.01','min' => 0, 'data-validation-number-message' => 'Please enter max 2 decimal point']) !!}
                                {!! $errors->first('discount_percentage', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group {!! $errors->has('discount_percentage') ? 'error' : '' !!}">
                            <label>Secondary Discount Percentage</label>
                            <div class="controls">
                                {!! Form::number('discount_percentage2', null,[ 'class' => 'form-control mb-1', 'placeholder' => 'Enter secondary discount percentage', 'tabindex' =>$tab_index++, 'step' => '0.01','min' => 0, 'data-validation-number-message' => 'Please enter max 2 decimal point']) !!}
                                {!! $errors->first('discount_percentage', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {!! $errors->has('invoice_exact_value') ? 'error' : '' !!}">
                            <label>Invoice Exact Value<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::text('invoice_exact_value', null, [ 'class' => 'form-control', 'placeholder' => 'Enter invoice exact value', 'data-validation-required-message' => 'This field is required', 'tabindex' =>$tab_index++]) !!}
                                {!! $errors->first('invoice_exact_value', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {!! $errors->has('exact_vat') ? 'error' : '' !!}">
                            <label>Exact Vat</label>
                            <div class="controls">
                                {!! Form::number('exact_vat', null, [ 'class' => 'form-control mb-1 ', 'placeholder' => 'Enter exact vat amount', 'tabindex' => $tab_index++, 'id' => 'exact_vat', 'step' => '0.01' ]) !!}
                                {!! $errors->first('exact_vat', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {!! $errors->has('postage') ? 'error' : '' !!}">
                            <label>Local Postage</label>
                            <div class="controls">
                                {!! Form::number('postage', null, [ 'class' => 'form-control mb-1 ', 'placeholder' => 'Enter local postage', 'tabindex' => $tab_index++, 'id' => 'postage', 'step' => '0.01' ]) !!}
                                {!! $errors->first('postage', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {!! $errors->has('purchaser') ? 'error' : '' !!}">
                            <label>Purchaser<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::select('purchaser', $user, null, [ 'class' => 'form-control mb-1 select2', 'placeholder' => 'Please select purchaser', 'data-validation-required-message' => 'This field is required', 'tabindex' => $tab_index++]) !!}
                                {!! $errors->first('purchaser', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {!! $errors->has('currency') ? 'error' : '' !!}">
                            <label>Purchase Currency<span class="text-danger">*</span></label>
                            <div class="controls">
                                <select class="form-control mb-1 select2" data-validation-required-message="This field is required" tabindex="13" name="currency" id="purchase_currency" required>
                                    <option value="">Select currency</option>
                                    @if($currency)
                                    <option value="{{$currency->PK_NO}}" data-rate="{{$currency->EXCHANGE_RATE_GB}}" data-code="{{$currency->CODE}}">{{$currency->NAME}}</option>
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
                                {!! Form::select('has_loyality', ['1' => 'Yes', '0' => 'No'], null, [ 'class' => 'form-control mb-1 ', 'placeholder' => 'Please select', 'tabindex' => $tab_index++, 'id' => 'has_loyality', 'disabled' => 'disabled' ]) !!}
                                {!! $errors->first('has_loyality', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group {!! $errors->has('description') ? 'error' : '' !!}">
                            <label>{{trans('form.notes')}}</label>
                            <div class="controls">

                                {!! Form::textarea('description', old('description'), [ 'class' => 'form-control mb-1 summernote', 'placeholder' => 'Enter short notes or parent invoice reference', 'tabindex' => $tab_index++, 'rows' => 3 ]) !!}
                                {!! $errors->first('description', '<label class="help-block text-danger">:message</label>') !!}
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
                <a href="{{ route('seller.invoice')}}" class="btn btn-warning mr-1" title="Cancel"><i class="ft-x"></i> Cancel </a>
                <button type="submit" class="btn btn-primary" title="Save"><i class="la la-check-square-o"></i> Save </button>
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

<script type="text/javascript" src="{{ asset('assets/pages/seller_invoice.js')}}"></script>
<script>

$('#invoiceMasterFrm').bind('keypress keydown keyup', function(e){
   if(e.keyCode == 13) { e.preventDefault(); }
});

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

// $(document).on('change','#purchase_currency', function(e){
//     var currency = $(this).val();
//     showHideConversionRate(currency);
// })




$(document).on('change', '#vendor', function(e){
    var loyality = $(this).select2().find(":selected").data("loyality");
    var country = $(this).select2().find(":selected").data("country_id");
    setLoyality(loyality);
    // $('#purchase_currency').val(country);
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
            extensions:[".jpg",".jpeg",".png",".gif",".svg", ".pdf",".JPG",".JPEG",".PNG",".GIF",".SVG", ".PDF"],
            mimes:["image/jpeg","image/png","image/gif","image/svg+xml","application/pdf"]
        });
    });

</script>
@endpush('custom_js')
