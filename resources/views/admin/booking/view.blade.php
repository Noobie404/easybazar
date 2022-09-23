@extends('admin.layout.master')

@section('list_order','active')

@section('title') Order | View @endsection
@section('page-name') Order | View @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('order.breadcrumb_dashboard_title') </a></li>
    <li class="breadcrumb-item active">Order list </li>
@endsection

@push('custom_css')

<!-- <link rel="stylesheet" href="{{ asset('assets/file_upload/image-uploader.min.css')}}"> -->
<!-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/editors/summernote.css')}}"> -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/forms/selects/select2.min.css') }}">
<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/pickers/pickadate/pickadate.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/pickers/daterange/daterange.css')}}">
<!-- <link rel="stylesheet" href="{{ asset('assets/lightgallery/css/lightgallery.min.css') }}"> -->
<link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/extensions/toastr.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/core/colors/palette-callout.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/pages/invoice.css')}}">


<style>
/* td {
    padding-left: 10px!important;
    padding-right: 10px!important;
} */
</style>
@endpush('custom_css')
<?php
    use Carbon\Carbon;
    $tabindex = 1;
    $booking_status =  Config::get('static_array.booking_status') ?? array();
    $booking_details        = $data['booking_details'];
    $booking                = $data['booking'];
    // $shop_state             = $data['shop_state'];
    // $shop_city              = $data['shop_city'];
    // $shop_area              = $data['shop_area'];
    // $shop_sub_area          = $data['shop_sub_area'];
    $delivery_boy           = $data['delivery_boy'];
    $delivery_booking       = $data['delivery_booking'];
    $customer               = $booking->getCustomer;
    $branch                 = $booking->getBranch;
    $created_by = $booking->CUSTOMER_NAME;
    if($booking->REQUEST_FOR == 'ADMIN'){
        $created_by = $booking->createdBy->NAME;
    }
    $setting = getWebSettings();
?>
@section('content')          
    <div class="content-header">
        <div class="p-4 bg-white">
            <div class="row">
                <!-- <div class="col-md-6">
                    <div class="form-group {!! $errors->has('booking_status') ? 'error' : '' !!}">
                        <label>Order status</label>
                        <div class="controls">
                            {!! Form::select('booking_status',booking_status_edit($booking->BOOKING_STATUS), $booking->BOOKING_STATUS, [ 'class' => 'form-control mb-1 summernote', 'tabindex' => $tabindex++, 'rows' => 3 ]) !!}
                            {!! $errors->first('booking_status', '<label class="help-block text-danger">:message</label>') !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group {!! $errors->has('delivery_boy_id') ? 'error' : '' !!}">
                        <label>Deliveryboy</label>
                            <div class="controls">
                                {!! Form::select('delivery_boy_id',$delivery_boy, $data['delivery_booking'], [ 'class' => 'form-control mb-1 select2', 'tabindex' => $tabindex++, 'rows' => 3, 'placeholder' => 'Select deliveryboy' ]) !!}
                                {!! $errors->first('delivery_boy_id', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                    </div>
                </div> -->
                <div class="col-md-6">
                    <div>
                        <h6><strong>Branch : </strong> <a href="{{ route('admin.agent.edit',$booking->F_SHOP_NO) }}" target="_blank">{{ $booking->SHOP_NAME }}
                            </a></h6>
                        <h6><strong>Created By : </strong> <a href="javascript:void(0)">{{ $created_by }} ({{ $booking->REQUEST_FOR }})</a> </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
                <!-- <div class="row">
                    <div class="col-md-4">
                        <div class="customer_info">
                            <h6><a href="{{ route('admin.customer.view',$customer->PK_NO) }}" target="_blank">{{ $customer->NAME }}({{ $customer->CUSTOMER_NO }})</a></h6>
                            <h6><a href="{{ route('admin.customer.view',$customer->PK_NO) }}" target="_blank">Mob : {{ $customer->MOBILE_NO }}
                            </a>
                        </h6>
                       </div>
                    </div>
                    <div class="col-md-6">
                    <div class="row">
                            <div class="col mb-2">
                                <div class="bs-callout-danger callout-border-left mt-1 p-1">
                                    <strong>Order Value</strong>
                                    <p class="mt-1" id="order_value">৳ {{ number_format($booking->TOTAL_PRICE, 2) }}</p>
                                </div>
                            </div>
                            <div class="col mb-2">
                                <div class="bs-callout-success callout-border-left mt-1 p-1">
                                    <strong>Paid Amount</strong>
                                    <p class="mt-1" id="order_paid">৳ {{ number_format($booking->ORDER_ACTUAL_TOPUP, 2) }}</p>
                                </div>
                            </div>
                            <div class="col mb-2">
                                <div class="bs-callout-success callout-border-left mt-1 p-1">
                                    <strong>Due Amount</strong>
                                    <p class="mt-1" id="order_due">৳ {{ number_format($booking->TOTAL_PRICE-$booking->ORDER_ACTUAL_TOPUP, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
            </div> -->
    <div class="content-body">
                <section class="card">
                    <div id="invoice-template" class="card-body p-4">
                   <!-- Invoice Company Details -->
                    <div id="invoice-company-details" class="row">
                            <div class="col-sm-6 col-12 text-center text-sm-left">
                                <div class="media row">
                                    <div class="col-12 col-sm-3 col-xl-2">
                                        <img src="{{fileExit($setting->EMAIL_HEADER_LOGO)}}" width="100px" alt="{{ $setting->TITLE  }}" class="mb-1 mb-sm-0" />
                                    </div>
                                    <div class="col-12 col-sm-9 col-xl-10">
                                        <div class="media-body">
                                            <ul class="ml-2 px-0 list-unstyled">
                                                <!-- <li class="text-bold-800">{{$setting->TITLE}}</li> -->
                                                <li>{{$setting->HQ_ADDRESS}}</li>
                                                <li>{{$setting->EMAIL_1}}</li>
                                                <li>{{$setting->PHONE_1}}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-12 text-center text-sm-right">
                                <!-- <h2>INVOICE</h2>
                                <p class="pb-sm-3"># INV-001001</p>
                                <ul class="px-0 list-unstyled">
                                    <li>Balance Due</li>
                                    <li class="lead text-bold-800">$12,000.00</li>
                                </ul> -->
                            </div>
                        </div>
                        <!-- Invoice Company Details -->
                <!-- Invoice Customer Details -->
                    <div id="invoice-customer-details" class="row pt-2">
                            <div class="col-12 text-center text-sm-left">
                                <p class="text-muted">Bill To</p>
                            </div>
                            <div class="col-sm-6 col-12 text-center text-sm-left">
                                <ul class="px-0 list-unstyled">

                                <li id="del_name" class="text-bold-800">{{ $booking->DELIVERY_NAME }}</li>
                                @if($booking->DELIVERY_MOBILE)
                                <li id="del_mobile">{{ $booking->DELIVERY_MOBILE }}</li>
                                @endif
                                @if($booking->DELIVERY_ADDRESS_LINE_1)
                                <li id="del_adds">{{ $booking->DELIVERY_ADDRESS_LINE_1 }}</li>
                                @endif
                                @if($booking->DELIVERY_SUB_AREA_NAME)
                                <li id="del_subarea">{{ $booking->DELIVERY_SUB_AREA_NAME }}</li>
                                @endif
                                @if($booking->DELIVERY_AREA_NAME)
                                <li id="del_area">{{ $booking->DELIVERY_AREA_NAME }}</li>
                                @endif
                                @if($booking->DELIVERY_CITY)
                                <li id="del_city"> {{ $booking->DELIVERY_CITY }}</li> 
                                @endif
                                @if($booking->DELIVERY_POSTCODE),
                                <li id="del_pocod">{{ $booking->DELIVERY_POSTCODE }}</li>
                                @endif
                                @if($booking->DELIVERY_STATE)
                                <li id="del_sate">{{ $booking->DELIVERY_STATE }}</li>
                                @endif    
                                </ul>
                            </div>
                            <div class="col-sm-6 col-12 text-center text-sm-right">
                                <p><span class="text-muted">Order no:</span> ORD-{{ $booking->BOOKING_NO }}</p>
                                <p><span class="text-muted">Order Date :</span> {{ date('d M Y H:i:s A',strtotime($booking->BOOKING_TIME)) }}</p>
                                <p><span class="text-muted">Order Status:</span> {{ $booking_status[$booking->BOOKING_STATUS] }}</p>
                                <p><span class="text-muted">Total amount:</span> ৳ {{ number_format($booking->TOTAL_PRICE, 2) }}</p>
                                <p><span class="text-muted">Payment method: :</span> {{ $booking->PAYMENT_METHOD =='cod' ? 'Cash on delivery': $booking->PAYMENT_METHOD }} </p>
                            </div>
                        </div>
                        <!-- Invoice Customer Details -->               
                <div id="invoice-items-details" class="pt-2">
                    <div class="row">
                        <div class="table-responsive col-12">
                            <table class="table" id="invoicetable">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <!-- <th width="10%">Image</th> -->
                                        <th width="40%">Item & Description</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-right">Line price</th>
                                    </tr>
                                </thead>
                                <tbody id="append_tr">
                                    @if(isset($booking_details) && count($booking_details))
                                    @foreach($booking_details as $k => $item )
                                    <?php
                                    $price_used = Config::get('static_array.price_used') ?? array();
                                    $unit_price = 0;
                                    $line_qty = $item->LINE_QTY ?? 1;
                                    if($item->PRICE_USED == 'REGULAR_PRICE'){$unit_price = $item->REGULAR_PRICE; }
                                    elseif($item->PRICE_USED == 'SPECIAL_PRICE'){$unit_price = $item->SPECIAL_PRICE; }
                                    elseif($item->PRICE_USED == 'WHOLESALE_PRICE'){$unit_price = $item->WHOLESALE_PRICE; }
                                    else{
                                    $unit_price = $item->REGULAR_PRICE;
                                    }
                                    ?>
                                    <tr id="prod_{{ $item->MRK_ID_COMPOSITE_CODE }}">
                                        {!! Form::hidden('products[]', $item->VARIANT_PK_NO ?? '' ) !!}
                                        <td scope="row">{{$k+1}}</td>
                                        <!-- <td>
                                            <img style="width: 80px !important; height: 80px;" alt="" src="{{'https://admin.easybazar.com'.$item->THUMB_PATH}}">
                                        </td> -->
                                        <td>
                                            <p class="product-title">
                                                {{ $item->VARIANT_NAME ?? '' }}
                                            </p>
                                            <p>
                                                <small>৳ {{ $unit_price }} / {{ $item->F_SIZE_PARENT_NAME }}: {{ $item->SIZE_NAME }}</small>
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <span>{{ $item->LINE_QTY }}</span>
                                        </td>
                                        <td class="text-center"><span>৳ {{ $unit_price }}</span></td>
                                        <td style="width: 10%" class="text-right">
                                            <span>৳ {{ number_format($item->LINE_PRICE,2) }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                    </tbody>
                                </table>                               
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-7 col-12 text-center text-sm-left"></div>
                            <div class="col-sm-5 col-12">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <strong class="text-muted">Sub Total :</strong>
                                                </td>
                                                <td class="text-right">
                                                    ৳ {{ number_format($booking->SUB_TOTAL,2) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong class="text-muted">Tax :</strong>
                                                </td>
                                                <td class="text-right">
                                                    ৳ {{ number_format(0,2) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong class="text-muted">Shipping :</strong>
                                                </td>
                                                <td class="text-right">
                                                    ৳ {{ number_format($booking->POSTAGE_COST,2) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong class="text-muted">Coupon :</strong>
                                                </td>
                                                <td class="text-right">
                                                     ৳  {{ number_format($booking->COUPON_DISCOUNT,2) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                        <strong class="text-muted">Discount :</strong>
                                                </td>
                                                <td class="text-right">
                                                    ৳ {{ number_format($booking->DISCOUNT,2) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong class="text-muted">Total :</strong>
                                                </td>
                                                <td class="text-muted h5 text-right">
                                                    ৳ {{ number_format($booking->TOTAL_PRICE,2) }}
                                                </td>
                                            </tr>
                                            <!-- <tr>
                                                <td>Payment Made</td>
                                                <td class="pink text-right">(-) $4,688.00</td>
                                            </tr>
                                            <tr class="bg-grey bg-lighten-4">
                                                <td class="text-bold-800">Balance Due</td>
                                                <td class="text-bold-800 text-right">$12,000.00</td>
                                            </tr> -->
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                         </div>
                    </div>
                <!-- Invoice Footer -->
                <div id="invoice-footer">
                    <div class="row">
                        <div class="col-sm-7 col-12 text-center text-sm-left">
                        </div>
                        <div class="col-sm-5 col-12 text-center">
                            <button type="button" class="btn btn-info btn-print btn-lg my-1">
                                <i class="la la-paper-plane-o mr-50"></i> Print
                            </button>
                        </div>
                    </div>
                </div>
             <!-- Invoice Footer -->
             </section>
            </div>
        
        <!-- <div class="form-actions mt-10 text-center">
            <a href="{{ url()->previous() }}" class="btn btn-success btn-min-width"><i class="la la-backward" ></i> Back</a>
        </div> -->
@endsection
<!--push from page-->
@push('custom_js')
<!-- Typeahead.js Bundle -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script> -->
<script type="text/javascript" src="{{ asset('assets/js/common.js?v-1.04')}}"></script>
<script src="{{ asset('assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{ asset('assets/js/scripts/forms/select/form-select2.js')}}"></script>
<!-- <script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.js')}}"></script> -->
<!-- <script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.date.js')}}"></script> -->
<!-- <script src="{{ asset('assets/lightgallery/js/lightgallery.min.js')}}"></script> -->
<script src="{{ asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>
<script src="{{ asset('assets/js/scripts/pages/invoice-template.js')}}"></script>
<!-- <script type="text/javascript" src="{{ asset('assets/pages/cus_pro_search.js?v-1.57')}}"></script> -->
<script>
//     $(document).on('submit',"#cancelOrderFrm",function(e){
//    // e.preventDefault();
//     return confirm('Are you sure?');
//     });
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
</script>

<script type="text/javascript">
    // var frm = $('#deliveryaddform');
    // frm.submit(function (e) {
    //     e.preventDefault();
    //     $.ajax({
    //         type: frm.attr('method'),
    //         url: frm.attr('action'),
    //         data: frm.serialize(),
    //         success: function (data) {
    //             if(data.status){
    //                 $('#del_name').text(data.data.delivery_name);
    //                 $('#del_mobile').text(data.data.delivery_mobile);
    //                 $('#del_adds').text(data.data.delivery_address_line_1);
    //                 $('#del_sate').text(data.data.state_id);
    //                 $('#del_area').text(data.data.area_id);
    //                 $('#del_subarea').text(data.data.sub_area_id);
    //                 $('#del_city').text(data.data.city_id);
    //                 $('#del_pocod').text(data.data.delivery_postcode);
    //                 $('#deliveryAddressUpdate').modal('toggle');
    //                 console.log(data.data);
    //             }else{
    //             }
    //                         },
    //         error: function (data) {
    //             alert('something wrong');
    //         },
    //     });
    // });
// $(document).ready(function () {
//   // print invoice with button
//   $(".btn-print").click(function () {
//     window.print();
//   });
// });
</script>
@endpush('custom_js')
