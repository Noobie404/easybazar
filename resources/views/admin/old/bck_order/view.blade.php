@extends('admin.layout.master')
@section('list_order','active')

@section('title') Order | view @endsection
@section('page-name') Order | view @endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('order.breadcrumb_dashboard_title') </a></li>
<li class="breadcrumb-item active">Order view </li>
@endsection

@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/forms/selects/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/file_upload/image-uploader.min.css')}}">
<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/editors/summernote.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('/assets/css/core/colors/palette-callout.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('/assets/vendors/css/extensions/toastr.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/pickers/pickadate/pickadate.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/plugins/pickers/daterange/daterange.css')}}">
<link rel="stylesheet" href="{{ asset('assets/lightgallery/dist/css/lightgallery.min.css') }}">

<style>
    #scrollable-dropdown-menu .tt-menu { max-height: 260px;overflow-y: auto;width: 100%;border: 1px solid #333;border-radius: 5px;}
    #scrollable-dropdown-menu2 .tt-menu {max-height: 260px;overflow-y: auto; width: 100%;border: 1px solid #333;border-radius: 5px;}
    .twitter-typeahead{display: block !important;}
    #warehouse th, #availble_qty th {border: none;border-bottom: 1px solid #333;font-size: 12px;font-weight: normal;
        padding-bottom: 7px;padding-bottom: 11px;}
    #book_qty th {border: none;font-size: 12px;font-weight: normal;padding-bottom: 5px;padding-top: 0;}
    .tt-hint {color: #999 !important;}
    #append_cus td{padding: 2px 5px;}
    #append_cus tr{width: 70%;}
    .bg-return-item{ background-color: #f5edee !important;}
</style>

@endpush('custom_css')

<?php
    use Carbon\Carbon;
    $booking_validity   = Config::get('static_array.booking_validity') ?? array();
    $booking_details    = $data['booking_details'];
    $booking_details_aud    = $data['booking_details_aud'] ?? '';
    $order              = $data['order'];
    $order_full_arrive  = $data['full_order_arrive'] ?? '';
    $data               = $data['booking'];
    $type               = request()->get('type') ?? '';
    $customer_id        = $data->getCustomer->PK_NO ?? $data->getReseller->PK_NO;
?>

@section('content')

@if( isset($order->DISPATCH_STATUS) && (($order->DISPATCH_STATUS == 40) || ($order->DISPATCH_STATUS == 35) || ($order->IS_ADMIN_HOLD == 1)))
<div class="card card-success">
    <div class="card-header pb-0">
        <div class="row">
            <div class="col-md-12">
                @if($order->DISPATCH_STATUS >= 35)
                    <div class="alert bg-danger mb-2 text-center" role="alert" style="background: linear-gradient(to right, #2193b0 0%, #6dd5ed 100%);">
                        <div class="row" style="">
                        <div class="col-md-12" style="">
                        <h4 style="color:#fff;"><i class="icon la la-ban"></i> Alert!</h4>
                        @if (isset($order->dispatch[0]) && $order->dispatch[0]->IS_DISPATHED == 0)
                        <span style="font-size: 16px;">This order has been scheduled for App <strong>Dispatch @if( $order->DISPATCH_STATUS == 35) (Partial) @endif </strong>.</span>
                        @elseif($order->PICKUP_ID > 0)
                        <span style="font-size: 16px;">This order has been <strong>Dispatched (App)</strong>.</span>
                        @else
                        <span style="font-size: 16px;">This order has <strong>Dispatched @if( $order->DISPATCH_STATUS == 35) (Partial) @endif @if (isset($order->dispatch[0]) && $order->dispatch[0]->IS_DISPATHED == 2) (Partial) @endif</strong>.</span>
                        @endif
                        <hr style="margin-bottom: 5px; border-top:2px soild #f2dade;">
                        </div>
                        </div>
                            <div class="row" style="">
                                @if($order->dispatch && count($order->dispatch) > 0 )
                                @foreach($order->dispatch as $k => $dispatch)
                                <div class="col-md-6" style="text-align: left;">
                                    <p style="margin-bottom: 2px;">Dispatch By : <strong class="text-uppercase">{{ $dispatch->DISPATCH_USER_NAME }}</strong></p>
                                    <p style="margin-bottom: 2px;">Dispatch Qty : <strong>{{ $dispatch->allChild->count() ?? 0 }}</strong></p>
                                    <p style="margin-bottom: 2px;">Dispatch At : <strong>{{ date('M d,Y',strtotime($dispatch->DISPATCH_DATE)) }}</strong></p>
                                    <p style="margin-bottom: 2px;">Tracking No./Collect By : <strong>{{ $dispatch->COURIER_TRACKING_NO }}</strong></p>
                                    <p style="margin-bottom: 2px; ">Carrier : <a href="{{ $dispatch->courier->URLS ?? '' }}" target="_blank" class="link" style="color: #ebf21e;">{{ $dispatch->COURIER_NAME }}</a></p>

                                </div>
                                @endforeach
                                @endif
                            </div>
                    </div>
                @endif
                @if($order->IS_ADMIN_HOLD == 1)
                    <div class="alert bg-danger alert-dismissible mb-2 text-center" role="alert">
                        <strong>Hold! </strong> Order has been hold by admin.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endif
@if( isset($order->IS_DEFAULT) && ($order->IS_DEFAULT == 1) )
<div class="card card-success">
    <div class="card-header pb-0">
        <div class="row">
            <div class="col-md-12">
                <div class="alert bg-danger mb-2 text-center" role="alert" style="background: #e91e63 ">
                    <div class="row" style="">
                        <div class="col-md-12" style="">
                            <h4 style="color:#fff;"><i class="icon la la-ban"></i> Alert!</h4>
                            <span style="font-size: 16px;">This order has been <strong>Default</strong>.
                            @if ($order->DEFAULT_TYPE == 1)
                                (Air / option 1)
                            @elseif($order->DEFAULT_TYPE == 2)
                                (Air / option 2)
                            @elseif($order->DEFAULT_TYPE == 3)
                                (Sea / option 1)
                            @elseif($order->DEFAULT_TYPE == 4)
                                (Sea / option 2)
                            @elseif($order->DEFAULT_TYPE == 5)
                                (Ready / option 1)
                            @elseif($order->DEFAULT_TYPE == 6)
                                (Ready / option 2)
                            @endif
                            </span>
                            <hr style="margin-bottom: 5px; border-top:2px soild #f2dade;">
                        </div>
                    </div>
                    <?php
                    $default_diff     = Carbon::parse($data->CONFIRM_TIME)->diffInDays($order->DEFAULT_AT,false);
                    ?>
                    <div class="row" style="">
                        <div class="col-md-6" style="text-align: left;">
                            <p style="margin-bottom: 2px;"><span style="width: 267px;display: inline-block;">ORDER DATE </span>: <strong>{{ date('M d,Y',strtotime($data->CONFIRM_TIME)) }}</strong></p>
                            @if (isset($order_full_arrive->SEND_AT))
                            <?php
                            $arrive_diff     = Carbon::parse($data->CONFIRM_TIME)->diffInDays($order_full_arrive->SEND_AT,false);
                            ?>
                            <p style="margin-bottom: 2px;">FULL ORDER ARRIVED AT : <strong>{{ date('M d,Y',strtotime($order_full_arrive->SEND_AT)) }} ({{ $arrive_diff }} Days)</strong></p>
                            @endif
                            <p style="margin-bottom: 2px;"><span style="width: 261px;display: inline-block;">DEFAULT AT </span> : <strong>{{ date('M d,Y',strtotime($order->DEFAULT_AT)) }} ({{ $default_diff }} Days)</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<div class="card">
    {!! Form::open([ 'route' => ['admin.bookingtoorder.update', $data->PK_NO], 'id'=>'booktoorderform', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
    <div class="card-header pb-0">
        <h4 class="card-title" id="basic-layout-colored-form-control"><i class="ft-plus text-primary"></i> Order Details</h4>
        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

        <div class="customer_info" style="text-align:center;margin-top:-24px;z-index:1;position:relative;">
            <h3 style="">
                <strong>{{ isset($data->getCustomer->PK_NO) ? 'Customer' : 'Reseller' }} Info</strong>
            </h3>
                <?php
                if ($data->IS_RESELLER == 0) {
                    $address2 = $data->getCustomerAddress($customer_id,2);
                }else{
                    $address2 = $data->getResellerAddress($customer_id);
                }
                ?>
            <h2>
                <strong><a href="{{ isset($data->getCustomer->PK_NO) ? route('admin.customer.view',$data->getCustomer->PK_NO) : route('admin.reseller.edit',$data->getReseller->PK_NO) }}" target="_blank"><span id="book_customer">{{ $data->getCustomer->NAME ?? $data->getReseller->NAME }}</span> ({{ $data->getCustomer->CUSTOMER_NO ?? $data->getReseller->RESELLER_NO }})</a>
            </strong>
            </h2>
            <h5>
                <strong><a href="{{ isset($data->getCustomer->PK_NO) ? route('admin.customer.view',$data->getCustomer->PK_NO) : route('admin.reseller.edit',$data->getReseller->PK_NO) }}" target="_blank">Mob : {{ $data->getCustomer->country->DIAL_CODE ?? $data->getReseller->country->DIAL_CODE ?? '' }} <span id="mobile_no_">
                    <?php
                    $mob1 = '';
                    $mob2 = '';
                    $mob3 = '';
                    if (isset($data->getCustomer->MOBILE_NO)) {
                        $mob1 = substr($data->getCustomer->MOBILE_NO, 0, 2);
                        $mob2 = substr($data->getCustomer->MOBILE_NO, 2, 3);
                        $mob3 = substr($data->getCustomer->MOBILE_NO, 5, 4);
                    }else if(isset($data->getReseller->MOBILE_NO)){
                        $mob1 = substr($data->getReseller->MOBILE_NO, 0, 2) ;
                        $mob2 = substr($data->getReseller->MOBILE_NO, 2, 3) ;
                        $mob3 = substr($data->getReseller->MOBILE_NO, 5, 4) ;
                    }
                    ?>
                    {{ $mob1.' '.$mob2.' '.$mob3 }}
                </span></a></strong>
            </h5>
        </div>
        <div class="heading-elements" style="z-index: 2;">
            <div style="display: inline-block" class="mr-1">
                <h4 style="">ORDER NO: <a href="javascript:void(0)">ORD-{{ $data->BOOKING_NO }}</a></h4>
                <h4 style="display: inline-block;width: 125px;">ORDER DATE:</h4> <input type='text' style="display: inline-block;width: 200px;" class="form-control pickadate" placeholder="Order Date" value="{{isset($data->CONFIRM_TIME) ? date('d-m-Y',strtotime($data->CONFIRM_TIME)) : date('d-m-Y')}}" name="order_date_" disabled />
            </div>
        </div>
    </div>
    <div class="card-content collapse show">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div style="margin-top: -80px;width: 30%;z-index: 1;position: relative;">
                        <h4 style="width: 120px;display: inline-block"><strong>Sales Agent : </strong></h4><h5 style="display: inline-block"><a href="{{ route('admin.agent.edit',$data->F_SHOP_NO) }}" target="_blank">{{ $data->SHOP_NAME }}</h5></a><br>
                        <h4 style="width: 120px;display: inline-block"><strong>Created By : </strong></h4><h5 style="display: inline-block"><a href="javascript:void(0)" class="text-uppercase">{{ $data->bookingCreatedBy->NAME }}</h5></a>
                    </div>
                    <div style="">
                    </div>
                    <?php
                        $customer_postcode = $data->getCustomerPostCode($data->F_CUSTOMER_NO,$data->F_RESELLER_NO,$data->IS_RESELLER);
                        ?>
                    {!! Form::hidden('booking_id',$data->PK_NO ?? null, ['id'=>'booking_id']) !!}
                    {!! Form::hidden('',$order->PK_NO ?? null, ['id'=>'order_id']) !!}
                    {!! Form::hidden('customer_id',$customer_id ?? null, ['id'=>'customer_id']) !!}
                    {!! Form::hidden('post_code',$customer_postcode->POST_CODE ?? 0, ['id'=>'post_code']) !!}
                    {!! Form::hidden('is_reseller',$data->IS_RESELLER ?? 0, ['id'=>'is_reseller']) !!}
                    {!! Form::hidden('',$type == 'view' ? 0 : 1,['id'=>'page_is_view']) !!}

                    <div class="form-body" id="order_form">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div id="cus_details" style="border: 1px solid #c4c4c4;border-radius: 5px;margin-top: 30px;">
                                    <div class="form-group {!! $errors->has('book_customer') ? 'error' : '' !!} mb-0">
                                        <div class="table-responsive">
                                            <table class="table mb-0" id="from_address_noneditable">
                                                <thead>
                                                    <tr>
                                                        <th colspan="4" style="background: aliceblue;">Sender
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td id="sender_td_inline">
                                                            {!! !empty($order->FROM_NAME) ? $order->FROM_NAME."<br>" : '' !!}
                                                            {!! !empty($order->FROM_ADDRESS_LINE_1) ? $order->FROM_ADDRESS_LINE_1."<br>" : '' !!}
                                                            {!! !empty($order->FROM_ADDRESS_LINE_2) ? $order->FROM_ADDRESS_LINE_2."<br>" : '' !!}
                                                            {!! !empty($order->FROM_ADDRESS_LINE_3) ? $order->FROM_ADDRESS_LINE_3."<br>" : '' !!}
                                                            {!! !empty($order->FROM_ADDRESS_LINE_4) ? $order->FROM_ADDRESS_LINE_4."<br>" : '' !!}
                                                            {!! !empty($order->FROM_CITY) ? $order->FROM_CITY." " : '' !!}
                                                            {!! !empty($order->FROM_POSTCODE) ? $order->FROM_POSTCODE."<br>" : '' !!}
                                                            {!! !empty($order->FROM_STATE) ? $order->FROM_STATE : '' !!}{!! !empty($order->FROM_COUNTRY) ? ', '.$order->FROM_COUNTRY."<br>" : '' !!}
                                                            <?php
                                                            if (!empty($order->FROM_MOBILE)) {
                                                                $from_mob1 = substr($order->FROM_MOBILE, 0, 2);
                                                                $from_mob2 = substr($order->FROM_MOBILE, 2, 3);
                                                                $from_mob3 = substr($order->FROM_MOBILE, 5,4);
                                                            }
                                                            ?>
                                                            {{ !empty($order->FROM_MOBILE) ? ($order->from_country->DIAL_CODE ?? '').' '.$from_mob1.' '.$from_mob2.' '.$from_mob3 : '' }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table class="table mb-0" id="from_address_editable" style="display: none">
                                                <thead>
                                                    <tr>
                                                        <th colspan="4" style="background: aliceblue;">Sender</th>
                                                        {!! Form::hidden('sender_f_country',$order->FROM_F_COUNTRY_NO ?? '' , ['id'=>'sender_f_country']) !!}
                                                    </tr>
                                                </thead>
                                                <tbody id="append_cus">
                                                        <tr id="from_name">

                                                            <td><input style="width: 100%" class="form-control input-sm" name="from_name" type="text" value="{{ $order->FROM_NAME ?? '' }}"></td>

                                                        </tr>
                                                        <tr id="from_add_1">

                                                            <td><input style="width: 100%" class="form-control input-sm" name="from_add_1" type="text" value="{{ $order->FROM_ADDRESS_LINE_1 ?? '' }}"></td>
                                                        </tr>
                                                        <tr>

                                                            <td><input style="width: 100%" class="form-control input-sm" name="from_add_2" type="text" value="{{ $order->FROM_ADDRESS_LINE_2 ?? '' }}"></td>
                                                        </tr>
                                                        <tr>

                                                            <td><input style="width: 100%" class="form-control input-sm" name="from_add_3" type="text" value="{{ $order->FROM_ADDRESS_LINE_3 ?? '' }}"></td>
                                                        </tr>
                                                        <tr>

                                                            <td><input style="width: 100%" class="form-control input-sm" name="from_add_4" type="text" value="{{ $order->FROM_ADDRESS_LINE_4 ?? '' }}"></td>
                                                        </tr>
                                                        <tr>

                                                            <td><input style="width: 100%" class="form-control input-sm" name="from_city" type="text" value="{{ $order->FROM_CITY ?? '' }}" readonly></td>

                                                            <td style="border-top: 1px solid #e3ebf3;"><input style="width: 100%" class="form-control input-sm" name="from_post_code" type="text" value="{{ $order->FROM_POSTCODE ?? '' }}" readonly></td>
                                                        </tr>
                                                        <tr>

                                                            <td><input style="width: 100%" class="form-control input-sm" name="from_state" type="text" value="{{ $order->FROM_STATE ?? '' }}" readonly></td>

                                                            <td style="border-top: 1px solid #e3ebf3"><input style="width: 100%" class="form-control input-sm" name="from_country" type="text" value="{{ $order->FROM_COUNTRY ?? '' }}" readonly></td>
                                                        </tr>
                                                        <tr>

                                                            {!! Form::hidden('', $order->from_country->DIAL_CODE ?? '', ['id'=>'sender_dial_code']) !!}
                                                            <td><input style="width: 100%" class="form-control input-sm" name="from_mobile" type="text" value="{{ $order->FROM_MOBILE ?? '' }}"></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan=2 style="border-top: 1px solid #e3ebf3">
                                                                <a href="javascript:void(0)" id="address_done_sender" class="btn btn-xs btn-info mr-2" style="font-size: 12px;float:right;">Done Editing</a>
                                                            </td>
                                                        </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div id="cus_details" style="border: 1px solid #c4c4c4;border-radius: 5px;margin-top: 30px;">
                                    <div class="form-group {!! $errors->has('book_customer') ? 'error' : '' !!} mb-0">
                                        <div class="table-responsive">
                                            <table class="table mb-0" id="delivery_address_noneditable">
                                                <thead>
                                                    <tr>
                                                        <th colspan="4" style="background: aliceblue;">Receiver
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td id="receiver_td_inline">
                                                            {!! !empty($order->DELIVERY_NAME) ? $order->DELIVERY_NAME."<br>" : '' !!}
                                                            {!! !empty($order->DELIVERY_ADDRESS_LINE_1) ? $order->DELIVERY_ADDRESS_LINE_1."<br>" : '' !!}
                                                            {!! !empty($order->DELIVERY_ADDRESS_LINE_2) ? $order->DELIVERY_ADDRESS_LINE_2."<br>" : '' !!}
                                                            {!! !empty($order->DELIVERY_ADDRESS_LINE_3) ? $order->DELIVERY_ADDRESS_LINE_3."<br>" : '' !!}
                                                            {!! !empty($order->DELIVERY_ADDRESS_LINE_4) ? $order->DELIVERY_ADDRESS_LINE_4."<br>" : '' !!}
                                                            {!! !empty($order->DELIVERY_CITY) ? $order->DELIVERY_CITY." " : '' !!}
                                                            {!! !empty($order->DELIVERY_POSTCODE) ? $order->DELIVERY_POSTCODE."<br>" : '' !!}
                                                            {!! !empty($order->DELIVERY_STATE) ? $order->DELIVERY_STATE : '' !!}{!! !empty($order->DELIVERY_COUNTRY) ? ', '.$order->DELIVERY_COUNTRY."<br>" : '' !!}
                                                            <?php
                                                            if (!empty($order->DELIVERY_MOBILE)) {
                                                                $delivery_mob1 = substr($order->DELIVERY_MOBILE, 0, 2);
                                                                $delivery_mob2 = substr($order->DELIVERY_MOBILE, 2, 3);
                                                                $delivery_mob3 = substr($order->DELIVERY_MOBILE, 5,4);
                                                            }
                                                            ?>
                                                            {{ !empty($order->DELIVERY_MOBILE) ? ($order->to_country->DIAL_CODE ?? '').' '.$delivery_mob1.' '.$delivery_mob2.' '.$delivery_mob3 : '' }}

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table class="table mb-0" id="delivery_address_editable" style="display: none">
                                                <thead>
                                                    <tr>
                                                        <th colspan="4" style="background: aliceblue;">Receiver</th>
                                                        {!! Form::hidden('receiver_f_country',$order->DELIVERY_F_COUNTRY_NO ?? '' , ['id'=>'receiver_f_country']) !!}
                                                    </tr>
                                                </thead>
                                                <tbody id="append_cus">
                                                        <tr>

                                                            <td><input style="width: 100%" class="form-control input-sm" name="delivery_name" type="text" value="{{ $order->DELIVERY_NAME ?? '' }}"></td>

                                                        </tr>
                                                        <tr>

                                                            <td><input style="width: 100%" class="form-control input-sm" name="delivery_add_1" type="text" value="{{ $order->DELIVERY_ADDRESS_LINE_1 ?? '' }}"></td>
                                                        </tr>
                                                        <tr>

                                                            <td><input style="width: 100%" class="form-control input-sm" name="delivery_add_2" type="text" value="{{ $order->DELIVERY_ADDRESS_LINE_2 ?? '' }}"></td>
                                                        </tr>
                                                        <tr>

                                                            <td><input style="width: 100%" class="form-control input-sm" name="delivery_add_3" type="text" value="{{ $order->DELIVERY_ADDRESS_LINE_3 ?? '' }}"></td>
                                                        </tr>
                                                        <tr>

                                                            <td><input style="width: 100%" class="form-control input-sm" name="delivery_add_4" type="text" value="{{ $order->DELIVERY_ADDRESS_LINE_4 ?? '' }}"></td>
                                                        </tr>
                                                        <tr>

                                                            <td><input style="width: 100%" class="form-control input-sm" name="delivery_city" type="text" value="{{ $order->DELIVERY_CITY ?? '' }}" readonly></td>

                                                            <td style="border-top: 1px solid #e3ebf3;"><input style="width: 100%" class="form-control input-sm" name="delivery_post_code" type="text" value="{{ $order->DELIVERY_POSTCODE ?? '' }}" readonly></td>
                                                        </tr>
                                                        <tr>

                                                            <td><input style="width: 100%" class="form-control input-sm" name="delivery_state" type="text" value="{{ $order->DELIVERY_STATE ?? '' }}" readonly></td>

                                                            <td style="border-top: 1px solid #e3ebf3;"><input style="width: 100%" class="form-control input-sm" name="delivery_country" type="text" value="{{ $order->DELIVERY_COUNTRY ?? '' }}" readonly></td>
                                                        </tr>
                                                        <tr>
                                                            {!! Form::hidden('', $order->to_country->DIAL_CODE ?? '', ['id'=>'receiver_dial_code']) !!}

                                                            <td><input style="width: 100%" class="form-control input-sm" name="delivery_mobile" type="text" value="{{ $order->DELIVERY_MOBILE ?? '' }}"></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan=2 style="border-top: 1px solid #e3ebf3">
                                                                <a href="javascript:void(0)" id="address_done_receiver" class="btn btn-xs btn-info mr-2" style="font-size: 12px;float:right;">Done Editing</a>
                                                            </td>
                                                        </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md col1">
                                <div class="bs-callout-danger callout-border-left mt-1 p-1">
                                    <strong>Order Value</strong>
                                    @if ($data->IS_RETURN == 0)
                                    <p class="mt-1" id="order_value">{{ isset($data->TOTAL_PRICE) ? number_format($data->TOTAL_PRICE,2) : 0.00 }}</p>
                                    @else
                                    <p class="mt-1" id="after_return" style="text-decoration: line-through;"></p>
                                    <p class="mt-1" id="order_value">{{ isset($data->TOTAL_PRICE) ? number_format($data->TOTAL_PRICE,2) : 0.00 }}</p>
                                    @endif
                                </div>
                            </div>
                            @if($data->PENALTY_FEE > 0 )
                            <div class="col-md col1">
                                <div class="bs-callout-danger callout-border-left mt-1 p-1">
                                    <strong>Penalty</strong>
                                    <p class="mt-1" id="order_value">{{ number_format($data->PENALTY_FEE,2) }}</p>

                                </div>
                            </div>
                            @endif

                            <div class="col-md col1 col-half-offset">
                                <div class="bs-callout-success callout-border-left mt-1 p-1">
                                    <strong>Amount Paid</strong>
                                    <p class="mt-1">
                                        <?php
                                            $amount_paid = ($order->ORDER_ACTUAL_TOPUP ?? 0) - ($order->ORDER_BALANCE_RETURN ?? 0);
                                        ?>
                                        <span title="ACTUAL AMOUNNT" id="order_balance">
                                            @if ($amount_paid > 0)
                                            <a href="javascript:void(0)" style="text-decoration: underline;" id="payidbookorder" data-toggle="modal" data-target="#PayIdModalBooktoorder" data-order_id="{{ $order->PK_NO }}" data-is_reseller="{{ $data->IS_RESELLER }}" data-type="dispatched">
                                                {{ number_format($amount_paid,2) }}
                                            </a>
                                            @else
                                            {{ number_format($amount_paid,2) }}
                                            @endif
                                        <span>
                                        @if ($amount_paid != ($order->ORDER_BUFFER_TOPUP ?? 0))
                                        /
                                        <a href="javascript:void(0)" style="text-decoration: underline;" id="payidbookorder" data-toggle="modal" data-target="#PayIdModalBooktoorder" data-order_id="{{ $order->PK_NO }}" data-is_reseller="{{ $data->IS_RESELLER }}" data-type="dispatched">
                                            <span style="color: #f00;" title="BUFFER AMOUNT">{{ isset($order->ORDER_BUFFER_TOPUP) ? number_format($order->ORDER_BUFFER_TOPUP,2) : 0 }}</span>
                                        </a>
                                        @endif
                                        {!! Form::hidden('', $order->ORDER_BUFFER_TOPUP ?? 0, ['id'=>'buffer_amount']) !!}
                                        {!! Form::hidden('', $order->ORDER_BALANCE_RETURN ?? 0, ['id'=>'balance_return']) !!}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md col1 col-half-offset">
                                <div class="bs-callout-info callout-border-left mt-1 p-1">
                                    <strong>Used Amount</strong>
                                    {!! Form::hidden('balance_used', $order->ORDER_BALANCE_USED ?? 0, ['id'=>'balance_used']) !!}
                                    <p class="mt-1" id="order_balance_used">
                                        {{ isset($order->ORDER_BALANCE_USED) ? number_format($order->ORDER_BALANCE_USED,2) : 0 }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md col1 col-half-offset">
                                <div class="bs-callout-primary callout-border-left mt-1 p-1">
                                    <strong>Available Amount</strong>
                                    <?php
                                        $available_amount = ($order->ORDER_ACTUAL_TOPUP ?? 0) - ($order->ORDER_BALANCE_RETURN ?? 0) - ($order->ORDER_BALANCE_USED ?? 0);
                                    ?>
                                    {!! Form::hidden('', $available_amount ?? 0, ['id'=>'order_outstanding_hidden']) !!}
                                    <p class="mt-1" id="order_outstanding">
                                        {{ number_format($available_amount,2) }}</p>
                                </div>
                            </div>
                            <div class="col-md col1 col-half-offset">
                                <div class="bs-callout-pink callout-border-left mt-1 p-1">
                                    <strong>Due Amount</strong>
                                        <?php
                                            $due_amount = ($data->TOTAL_PRICE ?? 0) - ($data->DISCOUNT ?? 0) - (($order->ORDER_BUFFER_TOPUP ?? 0) - ($order->ORDER_BALANCE_RETURN ?? 0))
                                        ?>
                                    <p class="mt-1" id="due_amount">
                                        {{ number_format($due_amount,2) }}
                                    </p>
                                </div>
                            </div>
                        </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-borde table-sm" id="invoicetable">
                                <thead>
                                    <tr>
                                        <th style="width: 200px">@lang('tablehead.image')</th>
                                        <th style="width: 200px">@lang('tablehead.product_name')</th>
                                        <th class="" style="width: 70px;">@lang('tablehead.warehouse')</th>
                                        <th class="">Qty</th>
                                        <th class="" style="width: 70px;">Postage</th>
                                        <th class="" style="width: 30px;text-align: center">Freight</th>
                                        <th class="" style="width: 10px;">Unit Price</th>
                                        <th class="" style="width: 10px;">Line Total</th>
                                        <th class="checkBox" style="width: 10px;" title="PAY FOR THIS ITEM">Paid?</th>
                                        <th class="checkBox" style="width: 10px;" title="SELF PICKUP COD/RTC">Self?</th>
                                    </tr>
                                </thead>
                                <tbody id="append_tr">
                                    @if($booking_details && count($booking_details) > 0 )
                                    @foreach($booking_details as $key => $val)

                                        <?= $val->book_info?>

                                    @endforeach
                                    @endif
                                    @if($booking_details_aud && count($booking_details_aud) > 0 )
                                    @foreach($booking_details_aud as $key => $val)

                                        <?= $val->book_info2 ?>

                                    @endforeach
                                    @endif
                                </tbody>
                                <tfoot id="append_tfoot">
                                    <tr style="text-align: center">
                                        <td></td>
                                        <td></td>
                                        <td>Sub Total</td>
                                        <td id="final_qty"></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td id="ss_amount_final"></td>
                                        @if ($type == 'view')
                                        @else
                                        <td colspan="3"></td>
                                        @endif
                                    </tr>
                                    <tr style="text-align: center">
                                        <td></td>
                                        <td></td>
                                        <td>Total Freight Cost</td>
                                        <td></td>
                                        <td colspan="3"><span id="given_freight_td">Given Freight: <span id="given_freight">{{ number_format($data->FREIGHT_COST,2, '.', '') }}</span></span></td>
                                        <td id="freight_cost_total"></td>
                                        @if ($type == 'view')
                                        @else
                                        <td colspan="3"></td>
                                        @endif
                                    </tr>
                                    <tr style="text-align: center">
                                        <td></td>
                                        <td></td>
                                        <td>Postage Cost</td>
                                        <td></td>
                                        <td colspan="3">
                                        </td>
                                        <td id="postage_cost_final"></td>
                                        @if ($type == 'view')
                                        @else
                                        <td colspan="3"></td>
                                        @endif
                                    </tr>
                                    <tr style="text-align: center">
                                        <td></td>
                                        <td></td>
                                        <th>Total</th>
                                        <td id="final_qty"></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        {!! Form::hidden('grand_total', 0, ['id' => 'grand_total']) !!}
                                        <th id="total_with_extra_costs"></th>
                                        @if ($type == 'view')
                                        @else
                                        <td colspan="3"></td>
                                        @endif
                                    </tr>
                                    <tr style="text-align: center">
                                        <td></td>
                                        <td></td>
                                        <td>Discount</td>
                                        <td colspan="4"></td>
                                        <td><input type="number" name="discount_amount" style="width: 60px;text-align: center;" class="form-control input-sm ml-1" id="discount_amount" value="{{ number_format($data->DISCOUNT,2, '.', '') }}" disabled></td>
                                        @if ($type == 'view')
                                        @else
                                        <td colspan="3"></td>
                                        @endif
                                    </tr>
                                    <tr style="text-align: center;color: red" id='penalty_fee_tr'>
                                        <td></td>
                                        <td></td>
                                        <th>Penalty Fee</th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <th id="penalty_fee">{{ number_format($data->PENALTY_FEE,2) }}</th>
                                        @if ($type == 'view')
                                        @else
                                        <td colspan="3"></td>
                                        @endif
                                    </tr>
                                    <tr style="text-align: center">
                                        <th></th>
                                        <th></th>
                                        <th>Grand Total</th>
                                        <th id="grand_final_qty"></th>
                                        <th></th>
                                        <th></th>
                                        {!! Form::hidden('final_qty_', 0, ['id' => 'final_qty_']) !!}
                                        <th></th>
                                        <th id="grand_total_ss"></th>
                                        @if ($type == 'view')
                                        @else
                                        <td colspan="3"></td>
                                        @endif
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group {!! $errors->has('booking_note') ? 'error' : '' !!}">
                            <label>Special Note</label>
                            <div class="controls">

                                {!! Form::textarea('booking_note', $data->BOOKING_NOTES, [ 'class' => 'form-control mb-1 summernote', 'tabindex' => 16, 'rows' => 3, 'disabled' ]) !!}
                                {!! $errors->first('booking_note', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    {!! Form::hidden('', number_format($data->PENALTY_FEE,2) ?? "0.00", ['id'=>'penalty_amount']) !!}
                    @if ($order->IS_DEFAULT == 1)
                    <div class="card card-success">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert bg-danger mb-2 text-center" role="alert" style="background: linear-gradient(to right, #2193b0 0%, #6dd5ed 100%);">
                                        <div class="row" style="">
                                            <div class="col-md-12" style="">
                                                <h4 style="color:#fff;"><i class="icon la la-ban"></i> Alert!</h4>
                                                <span style="font-size: 16px;">ORDER PENALTY AMOUNT IS {{ number_format($data->PENALTY_FEE,2) ?? "0.00" }}
                                                </span>
                                                <hr style="margin-bottom: 5px; border-top:2px soild #f2dade;">
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                                <div class="offset-md-4 col-md-4 mb-1">
                                                    <div class="controls">
                                                        <select id="change_option" class="select2" disabled>
                                                            <option value="1">OPTION 1</option>
                                                            <option value="0">OPTION 2</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="offset-md-4 col-md-4">
                                                    <div class="form-group {!! $errors->has('penalty_note') ? 'error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::textarea('penalty_note', $data->PENALTY_NOTE, [ 'class' => 'form-control mb-1 summernote', 'placeholder' => 'Enter Penalty note', 'tabindex' => 16, 'rows' => 3, "disabled" ]) !!}
                                                            {!! $errors->first('penalty_note', '<label class="help-block text-danger">:message</label>') !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- <div class="offset-md-7 col-md-1">
                                                    <button name="panelty_btn" style="float: left;padding: 0.37rem 1rem; width: 100%" type="submit" onclick="return confirm('Are you sure ?')" class="btn btn-dark" value="" title="SUBMIT PENALTY"><i class="la la-check-square-o"></i> Submit</button>
                                                </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
    <a href="{{ url()->previous() }}" class="btn btn-sm btn-success btn-min-width mr-1 mb-1" title="Back"><i class="la la-backward" ></i> Back</a>
</div>
</div>
</div>
@include('admin.order._modal_html')
@endsection
<!--push from page-->
@push('custom_js')

<!-- Typeahead.js Bundle -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/js/common.js')}}"></script>
<script src="{{ asset('assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{ asset('assets/js/scripts/forms/select/form-select2.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/pages/order_booking.js?v=1.7')}}"></script>
<script src="{{ asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/pages/country.js') }}"></script>
<script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.date.js')}}"></script>
<script src="{{ asset('assets/lightgallery/dist/js/lightgallery.min.js')}}"></script>
<script>
    $(".lightgallery").lightGallery();
    $('.pickadate').pickadate({
        format: 'dd-mm-yyyy',
        formatSubmit: 'dd-mm-yyyy',
        max:"<?php echo date('d-m-Y'); ?>",
    });
</script>
@if ($data->IS_RESELLER == 1)
    <script>
        $('[id*=address_btn]').remove();
    </script>
@endif
    <script>
        $("[id*=checkbox_of_order]").prop('disabled',true);
    </script>
@endpush('custom_js')
