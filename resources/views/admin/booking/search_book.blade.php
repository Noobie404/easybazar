@extends('admin.layout.master')
@section('Order Management','open')
@section('new_booking','active')
@section('title') Search & Book @endsection
@section('page-name') Search & Book @endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('admin_role.breadcrumb_title') </a></li>
<li class="breadcrumb-item active">Search & Book </li>
@endsection
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/forms/selects/select2.min.css') }}">
<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/pickers/pickadate/pickadate.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/pickers/daterange/daterange.css')}}">
<link rel="stylesheet" href="{{ asset('assets/lightgallery/css/lightgallery.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/extensions/toastr.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/core/colors/palette-callout.css')}}">
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
    .form-actions a, button {min-width: 175px;margin-bottom: 7px;margin-right: 2px}
    .input-sm{max-width: 120px; margin: 0 auto;}
    .min-100{display: inline-block; min-width: 100px;}
    #total_product_price{text-align: right;}
    input.product-search {
    height: 45px!important;
    }
    .input-group.qty-counter {
    display: inline-block;
    }
input.form-control.input-sm.max_val_check.remove_first_zero.min_val_check.booking_qty {
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
</style>
@endpush('custom_css')
<?php
    $roles = userRolePermissionArray();
    $booking_validity = Config::get('static_array.booking_validity') ?? array();
    $branch_id = request()->get('branch_id');
    $tab_index = 0;
    $delivery_schedules = $data['delivery_schedules'] ?? [];
    $categories     = $data['categories'] ?? [];
    $brand          = request()->get('brand') ?? '';
    $vat_class      = request()->get('vat_class') ?? '';
    $sku_id         = request()->get('sku_id') ?? '';
    $barcode        = request()->get('barcode') ?? '';
    $brand_combo    = getBrandCombo() ?? [];
?>
@section('content')
<div class="card card-success min-height">
    <div class="card-content ">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="branch_id">Branch</label>
                        <div class="controls">
                            <select class="form-control" tabindex="{{ $tab_index++ }}" id="branch_id">
                                <option value="">Select branch</option>
                                    @if(isset($branch) && count($branch) > 0 )
                                    @foreach($branch as $key => $val)
                                <option
                                    value="{{ $val->SHOP_ID }}"
                                    data-min_order_amount="{{ $val->MIN_ORDER_AMOUNT }}"
                                    data-max_order_amount="{{ $val->MAX_ORDER_AMOUNT }}"
                                    {{ $val->SHOP_ID == $branch_id ? 'selected' : '' }}
                                    >{{ $val->SHOP_NAME }}</option>
                                    @endforeach
                                    @endif
                            </select>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-12 col-md-4">
                    <div class="form-group {!! $errors->has('category') ? 'error' : '' !!}">
                        <label for="category">{{trans('form.category')}}<span class="text-danger">*</span></label>
                        <div class="controls">
                            <select class="form-control select2" name="category" id="category">
                                <option>Select category</option>
                                 @if(!empty($categories))
                                @foreach($categories as $category)
                                <option value="{{$category->PK_NO}}">{{$category->NAME}}</option>
                                @if(!empty($category->subcategories))
                                @foreach($category->subcategories as $subcategory)
                                <option value="{{$subcategory->PK_NO}}">{{$category->NAME}} > {{$subcategory->NAME}}</option>
                                @if(!empty($subcategory->subsubcategories))
                                @foreach($subcategory->subsubcategories as $subsubcategory)
                                <option value="{{$subsubcategory->PK_NO}}">{{$subcategory->NAME}} >{{$subsubcategory->NAME}}</option>
                                @endforeach
                                @endif
                                @endforeach
                                @endif
                                @endforeach
                                @endif
                            </select>
                            {!! $errors->first('category', '<label class="help-block text-danger">:message</label>') !!}
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group {!! $errors->has('brand') ? 'error' : '' !!}">
                        <label for="brand">{{trans('form.brand')}}</label>
                        <div class="controls">
                            {!! Form::select('brand', $brand_combo, $brand, ['class'=>'form-control mb-1 select2', 'id' => 'brand', 'placeholder' => 'Select brand', 'tabindex' => $tab_index++, 'data-url' => URL::to('prod_model')]) !!}
                            {!! $errors->first('brand', '<label class="help-block text-danger">:message</label>') !!}
                        </div>
                    </div>
                </div> -->
            </div>
              <div class="row" >
                @if(request()->get('branch_id'))
                <div class="col-md-12" id="search_and_book">
                    {!! Form::open([ 'route' => ['admin.booking.store'], 'method' => 'post', 'id' => 'post_form', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                    {!! Form::hidden('shop_id',$branch_id,[]) !!}
                    {!! Form::hidden('customer_id',null,['id'=>'customer_id']) !!}
                    <div class="form-body">
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
                            <div class="col-md-6" >
                            </div>
                            <div class="col-md-6">

                                <!-- <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <select name="user_id" class="form-control form-control-sm pos-customer select2" data-live-search="true" onchange="getShippingAddress()">
                                                    <option value="">Select Customer</option>
                                                    @if(!empty($customers))
                                                    @foreach ($customers as $key => $customer)
                                                            <option value="{{ $customer->PK_NO }}">{{ $customer->NAME }} - {{ $customer->MOBILE_NO }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <button type="button" class="btn btn-icon btn-soft-dark" data-target="#new-customer" data-toggle="modal">
                                                <i class="la la-truck"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>   -->

                                <div class="">
                                    <table class="table table-border" id="invoicetable">
                                        <thead>
                                            <tr>
                                                <th>Qty</th>
                                                <th>@lang('tablehead.product_name')</th>
                                                <th class="text-right" >Unit price</th>
                                                <th class="text-right" >Line Price</th>
                                                <th class="text-center" >@lang('tablehead.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody id="append_tr">
                                        </tbody>
                                        <tfoot id="append_tfoot">
                                            <tr style="text-align: center">
                                                <td colspan="2">Sub Total</td>
                                                <td >
                                                    <input type="number" readonly name="total_booking_qty" value="" id="total_booking_qty" class="form-control input-sm"/>
                                                </td>
                                                <td colspan="2">
                                                    <input type="number" readonly  name="total_product_price" value="" id="total_product_price" class="form-control input-sm float-right" />
                                                </td>
                                            </tr>
                                            <tr style="text-align: center" id="total_discount_tr">
                                                <td colspan="2">Discount</td>
                                                <td colspan="2">
                                                    <input type="number"  name="total_discount" value="" id="total_discount" class="form-control input-sm float-right text-right" />
                                                </td>
                                            </tr>
                                            <!-- <tr style="text-align: center" id="total_discount_tr">
                                                <td colspan="2">Coupon</td>
                                                <td></td>
                                                 <td colspan="2">
                                                    <input type="number"  name="total_discount" value="" id="total_discount" class="form-control input-sm float-right text-right" />
                                                </td>
                                            </tr> -->
                                            <tr style="text-align: center" class="d-none" id="delivery_cost_tr">
                                             
                                                <td colspan="2">Delivery Cost</td>
                                                <td colspan="2">
                                                    <input type="number" readonly  name="total_delivery_cost" value="" id="total_delivery_cost" class="form-control input-sm float-right text-right" />
                                                </td>
                                            </tr>
                                            <!-- <tr style="text-align: center" id="grand_total_tr">
                                                <th colspan="2">Grand Total</th>
                                                <th></th>
                                                <th colspan="2">
                                                    <input type="number" readonly  name="grand_total" value="" id="grand_total" class="form-control input-sm float-right text-right" />
                                                </th>
                                            </tr> -->
                                        </tfoot>
                                    </table>

                                    <!-- <div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Sub Total</span>
                                            <span id="total_booking_qty">৳ 1,608.000</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Tax</span>
                                            <span>৳ 0.000</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Shipping</span>
                                            <span id="total_delivery_cost">৳ 0.000</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Discount</span>
                                            <span>৳ 0.000</span>
                                        </div>
                                        <div class="d-flex justify-content-between fw-600 fs-18 border-top pt-2">
                                            <span>Total</span>
                                            <span id="grand_total">৳ 0.000</span>
                                        </div>
                                    </div> -->
                                    <!-- <div class="pos-footer mar-btm">
                                        <div class="d-flex justify-content-between">
                                            <div class="d-flex">
                                                <div class="dropdown mr-3 dropup">
                                                    <button class="btn btn-outline-dark btn-styled dropdown-toggle" type="button" data-toggle="dropdown">
                                                        Shipping
                                                    </button>
                                                    <div class="dropdown-menu p-3 dropdown-menu-lg">
                                                        <div class="radio radio-inline">
                                                            <input type="radio" name="shipping" id="radioExample_2a" value="0" checked onchange="setShipping()">
                                                            <label for="radioExample_2a">Without Shipping Charge</label>
                                                        </div>

                                                        <div class="radio radio-inline">
                                                            <input type="radio" name="shipping" id="radioExample_2b" value="1" onchange="setShipping()">
                                                            <label for="radioExample_2b">With Shipping Charge</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="dropdown dropup">
                                                    <button class="btn btn-outline-dark btn-styled dropdown-toggle" type="button" data-toggle="dropdown">
                                                        Discount
                                                    </button>
                                                    <div class="dropdown-menu p-3 dropdown-menu-lg">
                                                        <div class="input-group">
                                                            <input type="number" min="0" placeholder="Amount" name="discount" class="form-control" value="{{ Session::get('pos_discount', 0) }}" required onchange="setDiscount()">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">Flat</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="">
                                                <button type="button" class="btn btn-primary" data-target="#order-confirm" data-toggle="modal">Pay With Cash</button>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <div class="d-none" id="customer_info">
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
                            <div class="col-12">
                                <div class="form-group {!! $errors->has('book_customer') ? 'error' : '' !!}">
                                    <label class="mb-1">Customer Search<span class="text-danger">*</span></label>
                                    <div class="controls" id="scrollable-dropdown-menu">
                                        <input type="search" name="q" id="book_customer" class="form-control search-input2" placeholder="Enter Customer Name/Mobile number" autocomplete="off" value="{{ $info->NAME ?? '' }}" required name="book_customer">
                                    </div>
                                </div>
                            </div>
                        </div>



                            <div class="row">
                            <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('full_name') ? 'error' : '' !!}">
                                            <label class="mb-1">Full name<span class="text-danger">*</span></label>
                                            <div class="controls">
                                                <input type="text" class="form-control" name="full_name" id="full_name"  required/>
                                            </div>
                                            <input type="hidden" value="" id="f_delivery_address" name="f_delivery_address" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('mobile_no') ? 'error' : '' !!}">
                                            <label class="mb-1">Phone number<span class="text-danger">*</span></label>
                                            <div class="controls">
                                                <input type="text" class="form-control" name="mobile_no" id="mobile_no"  required/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('address') ? 'error' : '' !!}">
                                            <label class="mb-1">Address<span class="text-danger">*</span></label>
                                            <div class="controls">
                                                <textarea class="form-control" name="address" id="address" required></textarea>
                                            </div>
                                        </div>
                                    </div>

                            </div>

                            <div class="row">
                            <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('city') ? 'error' : '' !!}">
                                            <label class="mb-1">City<span class="text-danger">*</span></label>
                                            <div class="controls">
                                                <select class="form-control" name="city_id" id="city_id" required>
                                                    @if(isset($city) && count($city)>0)
                                                    @foreach($city as $key => $c)
                                                    <option value="{{ $c->F_CITY_NO }}">{{ $c->CITY_NAME }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('area') ? 'error' : '' !!}">
                                            <label class="mb-1">Area<span class="text-danger">*</span></label>
                                            <div class="controls">
                                                <select class="form-control" name="area_id" id="area_id" required>
                                                    @if(isset($area) && count($area)>0)
                                                    @foreach($area as $key => $c)
                                                    <option value="{{ $c->F_AREA_NO }}">{{ $c->AREA_NAME }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('sub_area') ? 'error' : '' !!}">
                                            <label class="mb-1">Sub area<span class="text-danger">*</span></label>
                                            <div class="controls">
                                                <select class="form-control" name="sub_area" required>
                                                    @if(isset($subarea) && count($subarea)>0)
                                                    @foreach($subarea as $key => $c)
                                                    <option value="{{ $c->F_SUB_AREA_NO }}">{{ $c->SUB_AREA_NAME }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions mt-10 text-center">
                        <a href="{{ url()->previous() }}" class="btn btn-success btn-min-width"><i class="la la-backward" ></i> Back</a>
                        <button type="button" class="btn btn-primary save-inv-details searh_and_book_submit_btn"  value="book"><i class="la la-check-square-o"></i> Proceed to Order </button>
                        <button type="submit" class="btn btn-warning searh_and_book_save_submit_btn d-none"><i class="la la-check-square-o"></i> Save </button>
                    </div>
                    {!! Form::close() !!}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
{{-- @include('admin.booking._modal_html') --}}
@endsection
@push('custom_js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
<script src="{{ asset('assets/pages/country.js?v-1.01')}}"></script>
<script src="{{ asset('assets/pages/cus_pro_search.js?v-1.57')}}"></script>
{{-- <script src="{{ asset('assets/pages/book_order.js?v-1.68')}}"></script> --}}
<script src="{{ asset('assets/js/common.js?v-1.04')}}"></script>
<script src="{{ asset('assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{ asset('assets/js/scripts/forms/select/form-select2.js')}}"></script>
<script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.date.js')}}"></script>
<script src="{{ asset('assets/lightgallery/js/lightgallery.min.js')}}"></script>
<script src="{{ asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>
<!-- 
<script>
      $(".lightgallery").lightGallery();
var minVal = 1, maxVal = 20; // Set Max and Min values
// Increase product quantity on cart page
$(".increaseQty").on('click', function(){
    alert(1);
		var $parentElm = $(this).parents(".qtySelector");
		$(this).addClass("clicked");
		setTimeout(function(){
			$(".clicked").removeClass("clicked");
		},100);
		var value = $parentElm.find(".qtyValue").val();
		if (value < maxVal) {
			value++;
		}
		$parentElm.find(".qtyValue").val(value);
});
// Decrease product quantity on cart page
$(".decreaseQty").on('click', function(){
		var $parentElm = $(this).parents(".qtySelector");
		$(this).addClass("clicked");
		setTimeout(function(){
			$(".clicked").removeClass("clicked");
		},100);
		var value = $parentElm.find(".qtyValue").val();
		if (value > 1) {
			value--;
		}
		$parentElm.find(".qtyValue").val(value);
	});
</script> -->
@if(request()->get('branch_id'))
<script>
     var branch_id = $('#branch_id').val();
      productSearh(branch_id);
</script>
@endif
@endpush('custom_js')


