@extends('admin.layout.master')

@section('list_order','active')

@section('title') Order | Edit @endsection
@section('page-name') Order | Edit @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('order.breadcrumb_dashboard_title') </a></li>
    <li class="breadcrumb-item active">Order list </li>
@endsection
@push('custom_css')
<!-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/file_upload/image-uploader.min.css')}}"> -->
<!-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/editors/summernote.css')}}"> -->
<!-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/forms/selects/select2.min.css') }}"> -->
<!-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/pickers/pickadate/pickadate.css')}}"> -->
<!-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/pickers/daterange/daterange.css')}}"> -->
<!-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/lightgallery/css/lightgallery.min.css') }}"> -->
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/core/colors/palette-callout.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/extensions/toastr.css')}}">
<style>
    #scrollable-dropdown-menu .tt-menu {max-height: 260px;Overflow-y: auto;width: 100%;border: 1px solid #333;border-radius: 5px;}
    #scrollable-dropdown-menu2 .tt-menu {max-height: 260px;overflow-y: auto;width: 100%;Border: 1px solid #333;border-radius: 5px;}
    .twitter-typeahead{display: block !important;}
    #warehouse th, #availble_qty th {border: none;border-bottom: 1px solid #333;font-size: 12px;font-weight: normal;Padding-bottom: 7px;height: 39px;}
    #book_qty th {border: none;font-size: 12px;font-weight: normal;Padding-bottom: 5px;padding-top: 0;}
    .tt-hint {color: #999 !important;}
    .d-none{display: none;}
    .bg-bundle{ background-color: #f9f0f2 !important;}
    .bg-bundle-item{ background-color: #f5edee !important;}
    .bundle-summary{ border-bottom: 2px solid red !important;}
    /* .form-actions a, button {min-width: 175px;margin-bottom: 7px;margin-right: 2px} */
    .input-sm{max-width: 120px; margin: 0 auto;}
    .min-100{display: inline-block; min-width: 100px;}
    #total_product_price{text-align: right;}
    input.product-search {
    height: 45px!important;
    }
    .input-group.qty-counter {
    display: inline-block;
    }
input.form-control.input-sm.booking_qty {
    width: 25px;
    text-align: center;
    height: 13px!important;
    border: none;
}
.qty-counter {
    width: 40px;
}
a.img_popup {
    float: left;
    margin-right: 8px;
}
td#th_book_qty {
    width: 59px;
}
.fs-18 {
    font-size: 1.125rem !important;
}
.fw-600 {
    font-weight: 600 !important;
}
a.qty-btn {
    color: #696969;
}

.soldout-box {

    position: absolute;
    width: 61px;
    height: 14px;
    background-color: red;
    transform: rotate(312deg);
    left: -7px;
    top: 20px;
    text-align: center;
    font-size: 9px;
    line-height: 12px;
    color: #fff;
}
</style>
@endpush('custom_css')
<?php
    $roles = userRolePermissionArray();
    use Carbon\Carbon;
    $tabindex = 1;
    $booking_status =  Config::get('static_array.booking_status') ?? array();
    $return_reason =  Config::get('static_array.return_reason') ?? array();
    $booking_details        = $data['booking_details'];
    $booking                = $data['booking'];
    $shop_state             = $data['shop_state'];
    $shop_city              = $data['shop_city'];
    $shop_area              = $data['shop_area'];
    $shop_sub_area          = $data['shop_sub_area'];
    $delivery_boy           = $data['delivery_boy'];
    $delivery_booking       = $data['delivery_booking'];
    $customer               = $booking->getCustomer;
    $branch                 = $booking->getBranch;
    $created_by = $booking->CUSTOMER_NAME;
    if($booking->REQUEST_FOR == 'ADMIN'){
        $created_by = $booking->createdBy->NAME;
    }
?>
@section('content')

    <div class="card">
        {!! Form::open([ 'route' => ['admin.booking.update', $booking->PK_NO], 'id'=>'booktoorderform', 'method' => 'post','id'=>'bookingUpdate', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
        <div class="card-content">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div>
                            <h6><strong>Branch : </strong> <a href="{{ route('admin.agent.edit',$booking->F_SHOP_NO) }}" target="_blank">{{ $booking->SHOP_NAME }}
                            </a></h6>
                            <h6><strong>Created By : </strong> <a href="javascript:void(0)">{{ $created_by }} ({{ $booking->REQUEST_FOR }})</a> </h6>
                            <h6><strong>Payment Method : </strong> <a href="javascript:void(0)" style="text-transform: uppercase;">{{ $booking->PAYMENT_METHOD }}</a> </h6>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="customer_info">
                            <h6><a href="{{ route('admin.customer.view',$customer->PK_NO) }}" target="_blank">{{ $customer->NAME }}({{ $customer->CUSTOMER_NO }})</a></h6>
                            <h6>
                                <a href="{{ route('admin.customer.view',$customer->PK_NO) }}" target="_blank">Mob : {{ $customer->MOBILE_NO }}
                            </a>
                            </h6>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="heading-elements" >
                            <div style="display: inline-block" class="mr-1">
                                <h6 style="">ORDER NO: <a href="javascript:void(0)">ORD-{{ $booking->BOOKING_NO }} ({{ $booking_status[$booking->BOOKING_STATUS] }})</a></h6>
                                <h6 style="display: inline-block;">DATE:</h6> {{ date('d-m-Y',strtotime($booking->BOOKING_TIME)) }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                       <div class="card card-body pb-0">
                           <h5>Delivery Address
                                @if($booking->BOOKING_STATUS != 30)
                                    <a href="#" data-toggle="modal" data-target="#deliveryAddressUpdate" class="btn btn-sm float-right pull-right" data-backdrop="static" data-keyboard="false"><i class="la la-edit"></i> Edit</a>
                                @endif
                            </h5>
                        <address>
                             <span id="del_name">{{ $booking->DELIVERY_NAME }}</span><br>
                            @if($booking->DELIVERY_MOBILE)
                                <span id="del_mobile">{{ $booking->DELIVERY_MOBILE }}</span> <br>
                            @endif
                            @if($booking->DELIVERY_ADDRESS_LINE_1)
                                <span id="del_adds">{{ $booking->DELIVERY_ADDRESS_LINE_1 }}</span>
                            <br>
                            @endif
                            @if($booking->DELIVERY_SUB_AREA_NAME)
                                <span id="del_subarea">{{ $booking->DELIVERY_SUB_AREA_NAME }}</span> <br>
                            @endif
                            @if($booking->DELIVERY_AREA_NAME)
                                <span id="del_area">{{ $booking->DELIVERY_AREA_NAME }}</span> <br>
                            @endif
                            @if($booking->DELIVERY_CITY)
                                <span id="del_city"> {{ $booking->DELIVERY_CITY }}</span>
                            @endif
                            @if($booking->DELIVERY_POSTCODE),
                                <span id="del_pocod">{{ $booking->DELIVERY_POSTCODE }}</span>
                            @endif<br>
                            @if($booking->DELIVERY_STATE)
                                <span id="del_sate">{{ $booking->DELIVERY_STATE }}</span> <br>
                            @endif
                        </address>
                       </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12 mb-2">
                                <div class="bs-callout-danger callout-border-left mt-1 p-1">
                                    <strong>Order Value</strong>
                                    ৳ <p class="mt-1" id="order_value">{{ $booking->TOTAL_PRICE }}</p>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12 mb-2">
                                <div class="bs-callout-success callout-border-left mt-1 p-1">
                                    <strong>Paid Amount</strong>
                                    ৳ <p class="mt-1" id="order_paid">{{ $booking->ORDER_ACTUAL_TOPUP }}</p>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12 mb-2">
                                <div class="bs-callout-success callout-border-left mt-1 p-1">
                                    <strong>Due Amount</strong>
                                    ৳ <p class="mt-1" id="order_due">{{ $booking->TOTAL_PRICE-$booking->ORDER_ACTUAL_TOPUP }}</p>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group {!! $errors->has('booking_note') ? 'error' : '' !!}">
                                    <label>Special Note</label>
                                    <div class="controls">
                                        {!! Form::textarea('booking_note', $booking->BOOKING_NOTES, [ 'class' => 'form-control mb-1 summernote', 'placeholder' => 'Enter special note', 'tabindex' => $tabindex++, 'rows' => 3 ]) !!}
                                        {!! $errors->first('booking_note', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">

                            <span class="badge badge-light">Delivery Schedule :</span>

                            {{ date('d M Y',strtotime($booking->DELIVERY_DATE)) }}

                            ({{$booking->DELIVERY_SLOT}})


                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-12">
                        <div class="form-group {!! $errors->has('ig_code') ? 'error' : '' !!}">
                            <label class="mb-1" for="product">Product Keyword<span class="text-danger">*</span></label>
                            <div class="controls" id="scrollable-dropdown-menu">
                                <input type="search" name="q" id="product" class="form-control search-input product-search" placeholder="Search by product name/Barcode" autocomplete="off">
                                {!! $errors->first('ig_code', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                </div>

                    <div class="row">
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table table-striped table-borde table-sm" id="invoicetable">
                                    <thead>
                                        <tr>
                                            <th>Qty</th>
                                            <th>Description</th>
                                            <th class="text-right" >Unit price</th>
                                            <th class="text-right" >Line Price</th>
                                            <th class="text-center" >@lang('tablehead.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody id="append_tr">
                                        @if(isset($booking_details) && count($booking_details))
                                        @foreach($booking_details as $k => $item )
                                            @include('admin.booking._variant_tr',['mode'=>'edit'])
                                        @endforeach
                                        @endif
                                    </tbody>

                                    <tfoot id="append_tfoot">
                                        <tr style="text-align: center">
                                            <td colspan="2">Sub Total</td>
                                            <td colspan="2" class="text-right">
                                            ৳ <span id="_total_product_price">{{ number_format($booking->SUB_TOTAL,2) }}</span>
                                                <input type="number" readonly  name="total_product_price" id="total_product_price" class="form-control input-sm text-right float-right" value="{{ $booking->SUB_TOTAL }}" />
                                            </td>
                                        </tr>

                                        <tr style="text-align: center" class="" id="delivery_cost_tr">
                                            <td colspan="2">Delivery Cost</td>
                                            <td colspan="2" class="text-right">
                                            ৳ <span id="_total_delivery_cost">{{ number_format($booking->POSTAGE_COST,2) }}</span>
                                                <input type="number" readonly  name="total_delivery_cost" value="{{ $booking->POSTAGE_COST }}" id="total_delivery_cost" class="form-control input-sm float-right text-right" />
                                            </td>
                                        </tr>
                                        <!-- <tr style="text-align: center" id="total_discount_tr">
                                            <td colspan="2">Discount</td>
                                            <td colspan="2" class="text-right">
                                            <span id="_total_discount">{{ number_format($booking->DISCOUNT,2) }}</span>
                                                <input type="number"  name="total_discount" value="{{ $booking->DISCOUNT }}" id="total_discount" class="form-control input-sm float-right text-right" />
                                            </td>
                                        </tr> -->

                                        @if($booking->COUPON_EXPIRED == true)
                                            <tr id="coupon_discount_tr" style="background-color:rgba(0,0,0,.1);text-align:center;">
                                                <td colspan="2">Coupon Discount (coupon expired)</td>
                                                <td colspan="2" class="text-right">
                                                @if($booking->COUPON_CODE || session('coupon_code'))
                                                <span id="_coupon_code">({{$booking->COUPON_CODE}})</span>
                                                @endif
                                                ৳ <span id="_coupon_discount">{{ number_format($booking->COUPON_DISCOUNT,2) ?? session('coupon_discount') }}</span>
                                                </td>
                                                <td style="width: 10%" class="text-center">
                                                @if(($booking->COUPON_CODE) && ($booking->COUPON_DISCOUNT > 0))
                                                    <a href="javascript:void(0)" class="text-right text-danger" id="remove_coupon"><i class="la la-close"></i></a>
                                                @endif
                                                </td>
                                            </tr>
                                        @else
                                            <tr id="coupon_discount_tr">
                                                <td colspan="2">Coupon Discount</td>
                                                <td colspan="2" class="text-right">
                                                @if($booking->COUPON_CODE || session('coupon_code'))
                                                <input type="text"  name="_coupon_code" value="{{$booking->COUPON_CODE}}" id="_coupon_code" class="form-control input-sm" />
                                                <span id="_coupon_code">({{$booking->COUPON_CODE}})</span>
                                                @endif
                                                ৳ <span id="_coupon_discount">{{ number_format($booking->COUPON_DISCOUNT,2) ?? session('coupon_discount') }}</span>
                                                    <input type="number"  name="coupon_discount" value="{{ $booking->COUPON_DISCOUNT }}" id="coupon_discount" class="form-control input-sm float-right text-right" />
                                                </td>
                                                <td style="width: 10%" class="text-center">
                                                <a href="javascript:void(0)" class="text-info" id="update_coupon"><i class="la la-save"></i></a>

                                                @if(($booking->COUPON_CODE) && ($booking->COUPON_DISCOUNT > 0))
                                                    <a href="javascript:void(0)" class="text-right text-danger" id="remove_coupon"><i class="la la-close"></i></a>
                                                @endif
                                                </td>
                                            </tr>
                                        @endif
                                        <tr class="" id="grand_total_tr">
                                            <th style="text-align: center" colspan="2">Grand Total</th>
                                            <th colspan="2" class="text-right">
                                            ৳ <span id="_grand_total">{{ number_format($booking->TOTAL_PRICE,2) }}</span>
                                                <input type="number" readonly  name="grand_total" value="{{ $booking->TOTAL_PRICE }}" id="grand_total" class="form-control input-sm float-right text-right" />
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            @if(empty($booking->COUPON_CODE) && ($booking->COUPON_DISCOUNT <= 0))
                            <div class="input-group">
                                <input type="text" placeholder="Coupon code" name="coupon_code" id="coupon_code" class="form-control" value="{{ $booking->COUPON_CODE }}" required>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-light border" id="coupon-submit-btn">Apply Coupon</button>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                                 <div class="col-6 col-md-6">
                                    <div class="form-group {!! $errors->has('delivery_date') ? 'error' : '' !!}">
                                       <label class="mb-1">Delivery date<span class="text-danger">*</span></label>
                                       <div class="controls">
                                          <select class="form-control" name="delivery_date" required>
                                             <option value="{{ date('Y-m-d') }}">{{ date('M d, Y') }}</option>
                                             <option value="{{ date('Y-m-d', strtotime('+1 days')) }}">{{ date('M d, Y', strtotime('+1 days')) }}</option>
                                             <option value="{{ date('Y-m-d', strtotime('+2 days')) }}">{{ date('M d, Y', strtotime('+2 days')) }}</option>
                                             <option value="{{ date('Y-m-d', strtotime('+3 days')) }}">{{ date('M d, Y', strtotime('+3 days')) }}</option>
                                             <option value="{{ date('Y-m-d', strtotime('+4 days')) }}">{{ date('M d, Y', strtotime('+4 days')) }}</option>
                                             <option value="{{ date('Y-m-d', strtotime('+5 days')) }}">{{ date('M d, Y', strtotime('+5 days')) }}</option>
                                             <option value="{{ date('Y-m-d', strtotime('+6 days')) }}">{{ date('M d, Y', strtotime('+6 days')) }}</option>
                                             <option value="{{ date('Y-m-d', strtotime('+7 days')) }}">{{ date('M d, Y', strtotime('+7 days')) }}</option>
                                             <option value="{{ date('Y-m-d', strtotime('+8 days')) }}">{{ date('M d, Y', strtotime('+8 days')) }}</option>
                                             <option value="{{ date('Y-m-d', strtotime('+9 days')) }}">{{ date('M d, Y', strtotime('+9 days')) }}</option>
                                             <option value="{{ date('Y-m-d', strtotime('+10 days')) }}">{{ date('M d, Y', strtotime('+10 days')) }}</option>
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-6 col-md-6">
                                    <div class="form-group {!! $errors->has('delivery_time') ? 'error' : '' !!}">
                                       <label class="mb-1">Delivery time<span class="text-danger">*</span></label>
                                       <div class="controls">
                                          <select class="form-control" name="delivery_time" required>
                                             @if(!empty($delivery_schedules))
                                             @foreach($delivery_schedules as $schedule)
                                             <option value="{{$schedule->PK_NO}}">{{$schedule->SLOT_TITLE}}</option>
                                             @endforeach
                                             @endif
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                              </div>

                    <div class="row">
                    <div class="col-md-6">
                            <div class="form-group {!! $errors->has('branch_id') ? 'error' : '' !!}">
                                <label>Branch</label>
                                <div class="controls">
                                <input type="text"  name="branch_id" value="{{ $booking->F_SHOP_NO }}" id="branch_id" class="form-control" />
                                    {!! $errors->first('branch_id', '<label class="help-block text-danger">:message</label>') !!}
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-md-6">
                            <div class="form-group {!! $errors->has('booking_status') ? 'error' : '' !!}">
                                <label>Order status</label>
                                <div class="controls">
                                    {!! Form::select('booking_status',booking_status_edit($booking->BOOKING_STATUS), $booking->BOOKING_STATUS, [ 'class' => 'form-control mb-1 summernote', 'tabindex' => $tabindex++, 'rows' => 3 ]) !!}
                                    {!! $errors->first('booking_status', '<label class="help-block text-danger">:message</label>') !!}
                                </div>
                            </div>
                        </div> --}}
                        {{-- <div class="col-md-6">
                            <div class="form-group {!! $errors->has('delivery_boy_id') ? 'error' : '' !!}">
                                <label>Deliveryboy</label>
                                <div class="controls">
                                    {!! Form::select('delivery_boy_id',$delivery_boy, $data['delivery_booking'], [ 'class' => 'form-control mb-1 summernote', 'tabindex' => $tabindex++, 'rows' => 3, 'placeholder' => 'Select deliveryboy' ]) !!}
                                    {!! $errors->first('delivery_boy_id', '<label class="help-block text-danger">:message</label>') !!}
                                </div>
                            </div>
                        </div> --}}
                    </div>
            </div>
        </div>
        <div class="form-actions mt-10 text-center">
            <a href="{{ url()->previous() }}" class="btn btn-success btn-min-width"><i class="la la-backward" ></i> Back</a>
            @if($booking->BOOKING_STATUS != 30 && $booking->BOOKING_STATUS < 90)
            <button type="submit" class="btn btn-primary "  value="book"><i class="la la-check-square-o"></i>Update Order </button>
            @endif
        </div>
        {!! Form::close() !!}
    </div>


    <div class="modal fade" id="deliveryAddressUpdate" tabindex="-1" role="dialog" aria-labelledby="deliveryAddressUpdate" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                {!! Form::open([ 'route' => ['admin.deliveryaddress.update', $booking->PK_NO], 'id'=>'deliveryaddform', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                @csrf
                <div class="modal-header">
                    <h3 class="modal-title">Delivery Address</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                    <div class="col-md-6">
                        <div class="form-group {!! $errors->has('delivery_name') ? 'error' : '' !!}">
                                <label>Name</label>
                                <div class="controls">
                                {!! Form::text('delivery_name', $booking->DELIVERY_NAME, ['class'=>'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'id' => 'delivery_name']) !!}
                                {!! $errors->first('delivery_name', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group {!! $errors->has('delivery_mobile') ? 'error' : '' !!}">
                                <label>Mobile</label>
                                <div class="controls">
                                {!! Form::text('delivery_mobile', $booking->DELIVERY_MOBILE, ['class'=>'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'id' => 'delivery_mobile']) !!}
                                {!! $errors->first('delivery_mobile', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group {!! $errors->has('delivery_address_line_1') ? 'error' : '' !!}">
                                <label>Address</label>
                                <div class="controls">
                                {!! Form::textarea('delivery_address_line_1', $booking->DELIVERY_ADDRESS_LINE_1, ['class'=>'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'id' => 'delivery_address_line_1','rows'=>'3']) !!}
                                {!! $errors->first('delivery_address_line_1', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                    <div class="col-md-6">
                            <div class="form-group {!! $errors->has('state_id') ? 'error' : '' !!}">
                                <label>State</label>
                                <div class="controls">
                                {!! Form::select('state_id', $shop_state,$booking->DELIVERY_STATE, ['class'=>'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'id' => 'state_id']) !!}
                                {!! $errors->first('state_id', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group {!! $errors->has('city_id') ? 'error' : '' !!}">
                                <label>City</label>
                                <div class="controls">
                                {!! Form::select('city_id', $shop_city,$booking->DELIVERY_CITY, ['class'=>'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'id' => 'city_id']) !!}
                                {!! $errors->first('city_id', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group {!! $errors->has('area_id') ? 'error' : '' !!}">
                                <label>Area</label>
                                <div class="controls">
                                {!! Form::select('area_id', $shop_area,$booking->DELIVERY_AREA_NAME, ['class'=>'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'id' => 'area_id']) !!}
                                {!! $errors->first('area_id', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group {!! $errors->has('sub_area_id') ? 'error' : '' !!}">
                                <label>Sub area</label>
                                <div class="controls">
                                {!! Form::select('sub_area_id', $shop_sub_area,$booking->DELIVERY_SUB_AREA_NAME, ['class'=>'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'id' => 'sub_area_id']) !!}
                                {!! $errors->first('sub_area_id', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group {!! $errors->has('delivery_postcode') ? 'error' : '' !!}">
                                <label>Post code</label>
                                <div class="controls">
                                {!! Form::text('delivery_postcode', $booking->DELIVERY_POSTCODE, ['class'=>'form-control mb-1','id' => 'delivery_postcode']) !!}
                                {!! $errors->first('delivery_postcode', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn btn-secondary btn-sm" data-dismiss="modal" value="Close">
                    <button type="submit" class="btn btn-primary">Update </button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>


<div class="modal fade" id="returnModal" tabindex="-1" aria-labelledby="defaultLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="title"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            {!! Form::open([ 'route' => ['admin.order.return'], 'id'=>'returnForm', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
             @csrf
            <div class="modal-body" id="modalBody">
                <input type="text" class="form-control" name="booking_details_id" id="booking_details_id">
                <input type="text" class="form-control" name="booking_id" id="booking_id">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group {!! $errors->has('reason') ? 'error' : '' !!}">
                            <label>Return Reason</label>
                            <div class="controls">
                                {!! Form::select('reason', $return_reason,NULL, ['class'=>'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'id' => 'city_id']) !!}
                                {!! $errors->first('reason', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group {!! $errors->has('return_note') ? 'error' : '' !!}">
                            <label>Return Note</label>
                            <div class="controls">
                                {!! Form::textarea('return_note', NULL, ['class'=>'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'id' => 'return_note','rows'=>'3']) !!}
                                {!! $errors->first('return_note', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection
@push('custom_js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
<script src="{{ asset('assets/js/common.js?v-1.04')}}"></script>
<!-- <script src="{{ asset('assets/vendors/js/forms/select/select2.full.min.js')}}"></script> -->
<!-- <script src="{{ asset('assets/js/scripts/forms/select/form-select2.js')}}"></script> -->
<!-- <script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.js')}}"></script> -->
<!-- <script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.date.js')}}"></script> -->
<!-- <script src="{{ asset('assets/lightgallery/js/lightgallery.min.js')}}"></script> -->
<script src="{{ asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>
<script src="{{ asset('assets/pages/cus_pro_search.js?v-1.57')}}"></script>
<script>
function incrementValue(e) {
        e.preventDefault();
        var parent = $(e.target).closest('div');
        var qty_field = parent.find('.booking_qty');
        var val = parseInt(qty_field.val());
        var max = parseInt(parent.find('.booking_qty').attr('max'));
        if (val >= max) {
            parseInt(qty_field).val(max);
            $(qty_field).change();
        }
        if (!isNaN(val)) {
            parent.find('.booking_qty').val(val + 1);
        } else {
            parent.find('.booking_qty').val(1);
        }
    }
    function decrementValue(e) {
        var fieldName = $(e.target).data('field');
        e.preventDefault();
        var parent = $(e.target).closest('div');
        var qty_field = parent.find('.booking_qty');
        var val = parseInt(qty_field.val());
        // var val = parseInt(parent.find('.booking_qty').val(), 10);
        var min = parseInt(parent.find('.booking_qty').attr('min'));
        if (val <= min) {
            $(this).val(min);
            $(qty_field).change();
        }
        if (!isNaN(val) && val > 1) {
            parent.find('.booking_qty').val(val - 1);
        } else {
            parent.find('.booking_qty').val(1);
        }
    }

    $('.qtySelector').on('click', '.increaseQty', function(e) {
        incrementValue(e);
        getTotal();
    });

    $('.qtySelector').on('click', '.decreaseQty', function(e) {
        decrementValue(e);
        getTotal();
    });

    $(document).on('click', '#return_prd', function () {
        var booking_details_id = $(this).data('id');
        var booking_id = $(this).attr("order-id");
        var data_title = $(this).attr("data-title");
        $('#booking_details_id').val(booking_details_id);
        $('#booking_id').val(booking_id);
        $('#title').text(data_title);
        $('#returnModal').modal('show');
    })
    $(document).on('submit',"#cancelOrderFrm",function(e){
    return confirm('Are you sure?');
    });
    // $(".lightgallery").lightGallery();
    // $('#order_date_').pickadate({
    //     format: 'dd-mm-yyyy',
    //     formatSubmit: 'dd-mm-yyyy',
    //     max:"<?php echo date('d-m-Y'); ?>",
    // });
    // $('.pickadate_grace').pickadate({
    //     format: 'dd-mm-yyyy',
    //     formatSubmit: 'dd-mm-yyyy',
    //     min:"<?php echo date('d-m-Y'); ?>",
    // });
    // $(document).ready(function() {
    //     getTotal();
    // })

    $(document).on('submit', "#returnForm", function (e) {
        e.preventDefault();
        var form = $("#returnForm");
        $.ajax({
            type: 'post',
            data: form.serialize(),
            url: form.attr('action'),
            async: true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (response) {
                console.log(response);
                if (response.status == 1) {
                    toastr.success(response.message);
                    $('#returnForm')[0].reset();
                    $('#returnModal').modal('hide');
                } else {
                    toastr.error(response.message);
                }
            },
            error: function (jqXHR, exception) {
                toastr.error('something wrong');
            },
            complete: function (response) {
                $("body").css("cursor", "default");
            }
        });
    });

    var frm = $('#deliveryaddform');
    frm.submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
            success: function (data) {
                if(data.status){
                    $('#del_name').text(data.data.delivery_name);
                    $('#del_mobile').text(data.data.delivery_mobile);
                    $('#del_adds').text(data.data.delivery_address_line_1);
                    $('#del_sate').text(data.data.state_id);
                    $('#del_area').text(data.data.area_id);
                    $('#del_subarea').text(data.data.sub_area_id);
                    $('#del_city').text(data.data.city_id);
                    $('#del_pocod').text(data.data.delivery_postcode);
                    $('#deliveryAddressUpdate').modal('toggle');
                    console.log(data.data);
                }else{
                }
                },
            error: function (data) {
                toastr.error('something wrong');
            },
        });
    });

    $(document).on('click', '#coupon-submit-btn', function () {
        var coupon_code   = $('#coupon_code').val();
        var customer_id     = <?php echo $booking->F_CUSTOMER_NO ?>;
        var branch_id       = <?php echo $booking->F_SHOP_NO ?>;
        $.ajax({
            type: 'POST',
            url: get_url + '/ajax/coupon-discount/',
            async: true,
            data:{
                coupon_code:coupon_code,
                customer_id:customer_id,
                branch_id:branch_id,
            },
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (response) {
                if (response.status == 1) {
                    toastr.success(response.message);
                }
                else{
                    toastr.error(response.message);
                }
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    })

    $(document).on('click', '#remove_coupon', function () {
        var coupon_code   = $('#coupon_code').val();
        var customer_id     = <?php echo $booking->F_CUSTOMER_NO ?>;
        var branch_id       = <?php echo $booking->F_SHOP_NO ?>;
        var booking_id       = <?php echo $booking->PK_NO ?>;
        $.ajax({
            type: 'POST',
            url: get_url + '/ajax/remove-coupon',
            async: true,
            data:{
                coupon_code:coupon_code,
                customer_id:customer_id,
                branch_id:branch_id,
                booking_id:booking_id,
            },
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (response) {
                if (response.status == 1) {
                    toastr.success(response.message);
                    $('#coupon_discount_tr').remove();
                    getTotal();
                }
                else{
                    toastr.error(response.message);
                }
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    })
    var branch_id = <?php echo $booking->F_SHOP_NO ?>;
      productSearh(branch_id);
      $(document).on('submit', "#bookingUpdate", function (e) {
        e.preventDefault();
        var form = $("#bookingUpdate");
        $.ajax({
            type: 'post',
            data: form.serialize(),
            url: form.attr('action'),
            async: true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (response) {
                console.log(response.data);
                if (response.status == 1) {
                    toastr.success(response.message);
                    location.reload();
                    // $('#bookingUpdate')[0].reset();
                }
                else {
                    toastr.error(response.message);
                }
            },
            error: function (jqXHR, exception) {
                toastr.error('something wrong');
            },
            complete: function (response) {
                $("body").css("cursor", "default");
            }
        });
    });

    $(document).on('click', '#update_coupon', function () {
        var coupon_code   = $('#_coupon_code').val();
        var grand_total   = $('#total_product_price').val();
        var customer_id     = <?php echo $booking->F_CUSTOMER_NO ?>;
        var branch_id       = <?php echo $booking->F_SHOP_NO ?>;
        var booking_id       = <?php echo $booking->PK_NO ?>;
        $.ajax({
            type: 'POST',
            url: get_url + '/ajax/update-apply-coupon',
            async: true,
            data:{
                coupon_code:coupon_code,
                customer_id:customer_id,
                branch_id:branch_id,
                booking_id:booking_id,
                grand_total:grand_total,
            },
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (response) {
                if (response.status == 1) {
                    toastr.success(response.message);
                    var coupon_code =response.data.coupon_code;
                    var coupon_discount =response.data.coupon_discount;
                    $('#_coupon_code').val(coupon_code);
                    $('#_coupon_discount').text(coupon_discount);
                    $('#coupon_discount').val(coupon_discount);
                    getTotal();
                }else{
                    toastr.error(response.message);
                }
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    })
</script>
@endpush('custom_js')
