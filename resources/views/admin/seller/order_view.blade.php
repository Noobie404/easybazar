<?php
use Carbon\Carbon;
$booking            = $data['order']['booking'] ?? [];
$booking_child      = $data['order']['book_childs'] ?? [];
$booking_refund     = $data['order']['refunded'] ?? [];
$dispatched         = $data['order']['dispatched'] ?? [];
$deleted            = $data['order']['deleted_items'] ?? [];
$returned_items     = $data['order']['returned_items'] ?? [];
$payments           = $data['order']['payments'] ?? [];
$order              = $booking->getOrder ?? [];
$shipping_address_list = $data['shipping_address'];
$billing_address    = $data['billing_address'] ?? [];
$penalty            = $booking->PENALTY_FEE ?? 0;
$penalty            = $penalty - $data['order']['penalty_amount'];
$cancel_fee         = $booking->CANCEL_FEE ?? 0;
$discount           = $booking->DISCOUNT ?? 0;
?>
@extends('admin.layout.master')
@section('Customer Management','open')
@section('reseller_list','active')
@push('custom_css')
<link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}?v=2.1.2">
<style>
    .table th, .table thead th, .table td {
    white-space: normal;
}
</style>
@endpush
@section('title')
My Account
@endsection
@section('content')
<div class="content-body min-height">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-sm card-success" >
                @if (isset($booking) && !empty($booking))
                {!! Form::hidden('', $booking->PK_NO, ['id'=>'booking_no']) !!}
                    <div class="account-order-details-heading card-header border-bottom">
                    <h4 class="card-title ">
                            Order #ORD-{{ $booking->BOOKING_NO }}
                                <a class="account-order-track-btn btn btn-default float-right"  href="#!"
                                target="_blank">My Order Current Position</a>
                    </h4>

                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="account-order-data">
                                    <div class="account-order-date">{{ date('d M Y',strtotime($booking->CONFIRM_TIME)) }}</div>
                                    <div class="account-order-source">Source : {{ $booking->SHOP_NAME }} </div>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="actions-toolbar account-order-info-toolbar">
                                    <div class="actions">
                                <a class="action account-order-back-link float-right" href="">Back to all orders</a>
                                    </div>
                                </div>
                            </div>



                        </div>

                    </div>
                    <div class="card nav-card">
                        <ul class="nav nav-tabs nav-top-border no-hover-bg nav-justified" role="tablist">
                            <li role="presentation" class="active nav-item " id="nav-li">
                                <a href="#itemOrders" aria-controls="itemOrders" role="tab"
                                    data-toggle="tab" id="itemOrders_trg" class="otab nav-link active"
                                    aria-expanded="true"><strong>Items Ordered</strong>
                                </a>
                            </li>
                            <li role="presentation" class="nav-item" id="nav-li">
                                <a  href="#Invoices" aria-controls="Invoices" role="tab" data-toggle="tab"
                                    id="Invoices_trg" class="otab nav-link" aria-expanded="false"><strong>Invoices</strong></a>
                            </li>
                            <li role="presentation" class="nav-item {{ isset($booking_refund) && count($booking_refund)>0 ? '' : '' }}" id="nav-li">
                                <a href="#Deliveries" aria-controls="Deliveries" role="tab"
                                    data-toggle="tab" style=" margin-right: 0px;  " id="Deliveries_tgr"
                                    class="otab nav-link" aria-expanded="false"><strong>Deliveries</strong></a>
                            </li>
                            @if (isset($booking_refund) && count($booking_refund)>0)
                            <li role="presentation" class="nav-item" id="nav-li">
                                <a href="#Refunds" aria-controls="Refunds" role="tab"
                                data-toggle="tab" style=" margin-right: 0px;" id="Refunds_tgr"
                                class="otab nav-link" aria-expanded="false"><strong>Refunds</strong></a>
                            </li>
                            @endif
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active table-responsive" id="itemOrders">
                                <table class="table" id="order_view_table">
                                    <thead>
                                        <tr class="tabtr">
                                            <th style="width: 100px;">Product</th>
                                            <th style="width: 124px;">Product code</th>
                                            <th style="width: 370px;">Product Name</th>
                                            <th style="width: 110px;">Unit Price</th>
                                            <th style="width: 120px;">Qty</th>
                                            <th class="text-right">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $subtotal = 0;
                                        $total_postage = 0;
                                        $grand_total = 0;
                                        $due = 0;
                                        ?>
                                        @if (isset($booking_child) && !empty($booking_child))
                                        @foreach ($booking_child as $child)
                                        <?php
                                        $line_total     = 0;
                                        if ($child->CURRENT_IS_REGULAR == 1) {
                                            $unit_price = $child->CURRENT_REGULAR_PRICE;
                                        }else{
                                            $unit_price = $child->CURRENT_INSTALLMENT_PRICE;
                                        }
                                        if ($child->CURRENT_IS_SM == 1) {
                                            $unit_postage = $child->CURRENT_SM_COST;
                                        }else{
                                            $unit_postage = $child->CURRENT_SS_COST;
                                        }
                                        $total_qty = $child->qty+$child->delete_qty+$child->refund_qty;
                                        $line_total     = $unit_price*($total_qty);
                                        $subtotal += $line_total;
                                        $total_postage += $unit_postage*($total_qty);
                                        $shipped_qty = $child->shipped_qty;
                                        ?>
                                        <tr style="border-bottom: .1rem solid #ebebeb">
                                            <td class="">
                                                <div class="account-order-table-item-data">
                                                    <a class="" href="" target="_blank">
                                                        <img src="{{ $child->PRD_VARIANT_IMAGE_PATH }}"
                                                            alt="IMAGE"
                                                            class="img-fluid" style="width: 80px;">
                                                    </a>
                                                </div>
                                            </td>
                                            <td>{{ $child->IG_CODE }}</td>
                                            <td>
                                                <a href="" target="_blank"
                                                    title="{{ $child->PRD_VARINAT_NAME }}">
                                                    {{ $child->PRD_VARINAT_NAME }}
                                                </a>
                                            </td>
                                            <td>
                                                <span class="price">RM {{ number_format($unit_price,2) }}</span>
                                            </td>
                                            <td class="account-order-table-item-qty">
                                                <p style="color:#212529;">Ordered: {{ $total_qty }}</p>
                                                @if ($shipped_qty > 0)
                                                <p style="color:#212529;">Shipped: {{ $shipped_qty }}</p>
                                                @else
                                                <?php
                                                $status = \Config::get('static_array.shipping_status_short');
                                                $sea_shipment_option1 = Carbon::parse(Carbon::now())->diffInDays($child->SCH_ARRIVAL_DATE,false);
                                                ?>
                                                @if($child->stock->F_INV_WAREHOUSE_NO==1)
                                                    <p style="color:#212529;">
                                                     {{ isset($child->stock->shippment->SHIPMENT_STATUS) && $child->stock->shippment->SHIPMENT_STATUS >= 20 ? $status[$child->stock->shippment->SHIPMENT_STATUS] : $child->stock->INV_WAREHOUSE_NAME }}
                                                    <span class="text-danger text-bold-600" style="cursor: pointer;" title="@lang('website.eta')">ETA*</span> @if($sea_shipment_option1 > 0) {{ $sea_shipment_option1 }} @else 7 @endif</span> days </p>
                                                @else
                                                <p style="color:#212529;">Ready Stock</p>
                                                @endif
                                                @endif
                                                @if ($child->delete_qty > 0)
                                                <p style="color:#212529;">Deleted: {{ $child->delete_qty }}</p>
                                                @endif
                                                @if ($child->refund_qty > 0)
                                                <p style="color:#212529;">Refunded: {{ $child->refund_qty }}</p>
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                RM <span class="price"> {{ number_format($line_total,2) }}</span>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                        @if (isset($deleted) && !empty($deleted))
                                        @foreach ($deleted as $child)
                                        <?php
                                        $line_total     = 0;
                                        if ($child->CURRENT_IS_REGULAR == 1) {
                                            $unit_price = $child->CURRENT_REGULAR_PRICE;
                                        }else{
                                            $unit_price = $child->CURRENT_INSTALLMENT_PRICE;
                                        }
                                        if ($child->CURRENT_IS_SM == 1) {
                                            $unit_postage = $child->CURRENT_SM_COST;
                                        }else{
                                            $unit_postage = $child->CURRENT_SS_COST;
                                        }
                                        $line_total     = $unit_price*($child->delete_qty);
                                        $subtotal += $line_total;
                                        $total_postage += $unit_postage*($child->delete_qty);
                                        ?>
                                        <tr style="border-bottom: .1rem solid #ebebeb">
                                            <td class="">
                                                <div class="account-order-table-item-data">
                                                    <a class="" href="" target="_blank">
                                                        <img src="{{ $child->PRD_VARIANT_IMAGE_PATH }}" alt="IMAGE" class="img-fluid" style="width: 80px;">
                                                    </a>
                                                </div>
                                            </td>
                                            <td>{{ $child->IG_CODE }}</td>
                                            <td>
                                                <a href="" target="_blank"
                                                    title="{{ $child->PRD_VARINAT_NAME }}">
                                                    {{ $child->PRD_VARINAT_NAME }}
                                                </a>
                                            </td>
                                            <td>
                                                <span class="price">RM {{ number_format($unit_price,2) }}</span>
                                            </td>
                                            <td class="account-order-table-item-qty">
                                                @if ($child->delete_qty > 0)
                                                <p style="color:#212529;">Deleted: {{ $child->delete_qty }}</p>
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                RM <span class="price"> {{ number_format($line_total,2) }}</span>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                        @if (isset($returned_items) && !empty($returned_items))
                                        @foreach ($returned_items as $child)
                                        <?php
                                        $line_total     = 0;
                                        if ($child->CURRENT_IS_REGULAR == 1) {
                                            $unit_price = $child->CURRENT_REGULAR_PRICE;
                                        }else{
                                            $unit_price = $child->CURRENT_INSTALLMENT_PRICE;
                                        }
                                        if ($child->CURRENT_IS_SM == 1) {
                                            $unit_postage = $child->CURRENT_SM_COST;
                                        }else{
                                            $unit_postage = $child->CURRENT_SS_COST;
                                        }
                                        $line_total     = $unit_price*($child->return_qty);
                                        $subtotal += $line_total;
                                        $total_postage += $unit_postage*($child->return_qty);
                                        ?>
                                        <tr style="border-bottom: .1rem solid #ebebeb">
                                            <td class="">
                                                <div class="account-order-table-item-data">
                                                    <a class="" href="" target="_blank">
                                                        <img src="{{ $child->PRD_VARIANT_IMAGE_PATH }}" alt="IMAGE"
                                                            class="img-fluid" style="width: 80px;">
                                                    </a>
                                                </div>
                                            </td>
                                            <td>{{ $child->IG_CODE }}</td>
                                            <td>
                                                <a href="" target="_blank"
                                                    title="{{ $child->PRD_VARINAT_NAME }}">
                                                    {{ $child->PRD_VARINAT_NAME }}
                                                </a>
                                            </td>
                                            <td>
                                                <span class="price">RM {{ number_format($unit_price,2) }}</span>
                                            </td>
                                            <td class="account-order-table-item-qty">
                                                @if ($child->return_qty > 0)
                                                <p style="color:#212529;">Returned: {{ $child->return_qty }}</p>
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                RM <span class="price"> {{ number_format($line_total,2) }}</span>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                <div class="account-order-total-table ord_summary" style="display: block;">
                                    <table class="table no-border tb1 thead-light bigf">
                                        <thead>
                                            <tr style="border-bottom:2px solid #0000000d">
                                                <td style="width: 70%; text-align: right;"><strong>Summary</strong></td>
                                                <td style="width: 30%; text-align: right;"></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="border-bottom:2px solid #0000000d">
                                                <td style="width: 70%; text-align: right;">
                                                    <span>Product Subtotal </span>
                                                </td>
                                                <td style="width: 30%; text-align: right;"><span
                                                        class="price">{{ number_format($subtotal,2) }}</span></td>
                                            </tr>
                                            <tr style="border-bottom:2px solid #0000000d">
                                                <td style="width: 70%; text-align: right;">
                                                    <span>Postage </span>
                                                </td>
                                                <td style="width: 30%; text-align: right;"><span
                                                        class="price">{{ number_format($total_postage,2) }}</span></td>
                                            </tr>
                                            @if ($penalty > 0)
                                            <tr style="border-bottom:2px solid #0000000d">
                                                <td style="width: 70%; text-align: right;">
                                                    <strong class="text-danger">Penalty </strong>
                                                </td>
                                                <td style="width: 30%; text-align: right;"><span
                                                    class="price text-danger">{{ number_format($penalty,2) }}</span></td>
                                            </tr>
                                            @endif
                                            @if ($cancel_fee > 0)
                                            <tr style="border-bottom:2px solid #0000000d">
                                                <td style="width: 70%; text-align: right;">
                                                    <strong class="text-danger">Cancel Fee </strong>
                                                </td>
                                                <td style="width: 30%; text-align: right;"><span
                                                    class="price text-danger">{{ number_format($cancel_fee,2) }}</span></td>
                                            </tr>
                                            @endif
                                            @if ($discount > 0)
                                            <tr style="border-bottom:2px solid #0000000d">
                                                <td style="width: 70%; text-align: right;">
                                                    <strong class="text-success">Discount </strong>
                                                </td>
                                                <td style="width: 30%; text-align: right;"><span
                                                    class="price text-danger">{{ number_format($discount,2) }}</span></td>
                                            </tr>
                                            @endif
                                            <?php
                                            $grand_total = ($subtotal+$total_postage+$penalty+$cancel_fee)-$discount;
                                            $due = $grand_total;
                                            ?>
                                            <tr style="border-bottom:2px solid #0000000d">
                                                <td style="width: 70%; text-align: right;"><strong>Total </strong></td>
                                                <td style="width: 30%; text-align: right;">
                                                    <strong class="price">{{ number_format($grand_total,2) }}</strong></td>
                                            </tr>
                                            @if (isset($payments) && !empty($payments))
                                            @foreach ($payments as $value)
                                            <?php
                                                $due -= $value->PAYMENT_AMOUNT;
                                            ?>
                                            <tr style="border-bottom:2px solid #0000000d">
                                                <td style="width: 70%; text-align: right;">
                                                    <strong class="paysl mr-4">Payment </strong>
                                                    <span class="pays mr-4" title="Payment Date">{{ date('d-m-Y',strtotime($value->TXN_DATE)) }}</span>
                                                    <span class="pays mr-4" title="Payment ID">
                                                    <a href="" title="Click For Payment Detils">PAY-{{ $value->CODE }}</a>
                                                    </span>
                                                    <span class="pays" title="Payment Amout For The Order">
                                                        {{ number_format($value->PAYMENT_AMOUNT,2) }}</span>
                                                </td>
                                                <td style="width: 30%; text-align: right;"><strong>{{ number_format($value->PAYMENT_AMOUNT,2) }}</strong></td>
                                            </tr>
                                            @endforeach
                                            @endif
                                            <tr style="border-bottom:2px solid #0000000d">
                                                <td style="width: 70%; text-align: right;"><strong
                                                        class="text-danger">DUE </strong></td>
                                                <td style="width: 30%; text-align: right;"><strong
                                                        class="text-danger">{{ number_format($due,2) }}</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane table-responsive" id="Invoices">
                                <legend style="border-bottom: none;">
                                    <div class="account-order-items-actions-top">
                                      <a href="" id="print_order_invoice"><i class="la la-print" aria-hidden="true"></i> Print to PDF </a>
                                    </div>
                                </legend>
                                <table class="table" id="order_view_table">
                                    <thead>
                                        <tr class="tabtr">
                                            <th style="width: 100px;">Product</th>
                                            <th style="width: 124px;">Product code</th>
                                            <th style="width: 370px;">Product Name</th>
                                            <th style="width: 110px;">Unit Price</th>
                                            <th style="width: 120px;">Qty</th>
                                            <th class="text-right">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $subtotal = 0;
                                        $total_postage = 0;
                                        $grand_total = 0;
                                        $due = 0;
                                        ?>
                                        @if (isset($booking_child) && !empty($booking_child))
                                        @foreach ($booking_child as $child)
                                        <?php
                                        $line_total     = 0;
                                        if ($child->CURRENT_IS_REGULAR == 1) {
                                            $unit_price = $child->CURRENT_REGULAR_PRICE;
                                        }else{
                                            $unit_price = $child->CURRENT_INSTALLMENT_PRICE;
                                        }
                                        if ($child->CURRENT_IS_SM == 1) {
                                            $unit_postage = $child->CURRENT_SM_COST;
                                        }else{
                                            $unit_postage = $child->CURRENT_SS_COST;
                                        }
                                        $total_qty = $child->qty+$child->delete_qty+$child->refund_qty;
                                        $line_total     = $unit_price*($total_qty);
                                        $subtotal += $line_total;
                                        $total_postage += $unit_postage*($total_qty);
                                        $shipped_qty = $child->shipped_qty;
                                        ?>
                                        <tr style="border-bottom: .1rem solid #ebebeb">
                                            <td class="">
                                                <div class="account-order-table-item-data">
                                                    <a class="" href="" target="_blank">
                                                        <img src="{{ $child->PRD_VARIANT_IMAGE_PATH }}"
                                                            alt="IMAGE"
                                                            class="img-fluid" style="width: 80px;">
                                                    </a>
                                                </div>
                                            </td>
                                            <td>{{ $child->IG_CODE }}</td>
                                            <td>
                                                <a href="" target="_blank"
                                                    title="{{ $child->PRD_VARINAT_NAME }}">
                                                    {{ $child->PRD_VARINAT_NAME }}
                                                </a>
                                            </td>
                                            <td>
                                                <span class="price">RM {{ number_format($unit_price,2) }}</span>
                                            </td>
                                            <td class="account-order-table-item-qty">
                                                <p style="color:#212529;">Ordered: {{ $total_qty }}</p>
                                                @if ($shipped_qty > 0)
                                                <p style="color:#212529;">Shipped: {{ $shipped_qty }}</p>
                                                @else
                                                <?php
                                                $status = \Config::get('static_array.shipping_status_short');
                                                $sea_shipment_option1 = Carbon::parse(Carbon::now())->diffInDays($child->SCH_ARRIVAL_DATE,false);
                                                ?>
                                                @if($child->stock->F_INV_WAREHOUSE_NO==1)
                                                    <p style="color:#212529;">
                                                     {{ isset($child->stock->shippment->SHIPMENT_STATUS) && $child->stock->shippment->SHIPMENT_STATUS >= 20 ? $status[$child->stock->shippment->SHIPMENT_STATUS] : $child->stock->INV_WAREHOUSE_NAME }}
                                                    <span class="text-danger text-bold-600" style="cursor: pointer;" title="@lang('website.eta')">ETA*</span> @if($sea_shipment_option1 > 0) {{ $sea_shipment_option1 }} @else 7 @endif</span> days </p>
                                                @else
                                                <p style="color:#212529;">Ready Stock</p>
                                                @endif
                                                @endif
                                                @if ($child->delete_qty > 0)
                                                <p style="color:#212529;">Deleted: {{ $child->delete_qty }}</p>
                                                @endif
                                                @if ($child->refund_qty > 0)
                                                <p style="color:#212529;">Refunded: {{ $child->refund_qty }}</p>
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                RM <span class="price"> {{ number_format($line_total,2) }}</span>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                        @if (isset($deleted) && !empty($deleted))
                                        @foreach ($deleted as $child)
                                        <?php
                                        $line_total     = 0;
                                        if ($child->CURRENT_IS_REGULAR == 1) {
                                            $unit_price = $child->CURRENT_REGULAR_PRICE;
                                        }else{
                                            $unit_price = $child->CURRENT_INSTALLMENT_PRICE;
                                        }
                                        if ($child->CURRENT_IS_SM == 1) {
                                            $unit_postage = $child->CURRENT_SM_COST;
                                        }else{
                                            $unit_postage = $child->CURRENT_SS_COST;
                                        }
                                        $line_total     = $unit_price*($child->delete_qty);
                                        $subtotal += $line_total;
                                        $total_postage += $unit_postage*($child->delete_qty);
                                        ?>
                                        <tr style="border-bottom: .1rem solid #ebebeb">
                                            <td class="">
                                                <div class="account-order-table-item-data">
                                                    <a class="" href="" target="_blank">
                                                        <img src="{{ $child->PRD_VARIANT_IMAGE_PATH }}" alt="IMAGE" class="img-fluid" style="width: 80px;">
                                                    </a>
                                                </div>
                                            </td>
                                            <td>{{ $child->IG_CODE }}</td>
                                            <td>
                                                <a href="" target="_blank"
                                                    title="{{ $child->PRD_VARINAT_NAME }}">
                                                    {{ $child->PRD_VARINAT_NAME }}
                                                </a>
                                            </td>
                                            <td>
                                                <span class="price">RM {{ number_format($unit_price,2) }}</span>
                                            </td>
                                            <td class="account-order-table-item-qty">
                                                @if ($child->delete_qty > 0)
                                                <p style="color:#212529;">Deleted: {{ $child->delete_qty }}</p>
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                RM <span class="price"> {{ number_format($line_total,2) }}</span>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                        @if (isset($returned_items) && !empty($returned_items))
                                        @foreach ($returned_items as $child)
                                        <?php
                                        $line_total     = 0;
                                        if ($child->CURRENT_IS_REGULAR == 1) {
                                            $unit_price = $child->CURRENT_REGULAR_PRICE;
                                        }else{
                                            $unit_price = $child->CURRENT_INSTALLMENT_PRICE;
                                        }
                                        if ($child->CURRENT_IS_SM == 1) {
                                            $unit_postage = $child->CURRENT_SM_COST;
                                        }else{
                                            $unit_postage = $child->CURRENT_SS_COST;
                                        }
                                        $line_total     = $unit_price*($child->return_qty);
                                        $subtotal += $line_total;
                                        $total_postage += $unit_postage*($child->return_qty);
                                        ?>
                                        <tr style="border-bottom: .1rem solid #ebebeb">
                                            <td class="">
                                                <div class="account-order-table-item-data">
                                                    <a class="" href="" target="_blank">
                                                        <img src="{{ $child->PRD_VARIANT_IMAGE_PATH }}"
                                                            alt="IMAGE"
                                                            class="img-fluid" style="width: 80px;">
                                                    </a>
                                                </div>
                                            </td>
                                            <td>{{ $child->IG_CODE }}</td>
                                            <td>
                                                <a href="" target="_blank" title="{{ $child->PRD_VARINAT_NAME }}">
                                                    {{ $child->PRD_VARINAT_NAME }}
                                                </a>
                                            </td>
                                            <td>
                                                <span class="price">RM {{ number_format($unit_price,2) }}</span>
                                            </td>
                                            <td class="account-order-table-item-qty">
                                                @if ($child->return_qty > 0)
                                                <p style="color:#212529;">Returned: {{ $child->return_qty }}</p>
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                RM <span class="price"> {{ number_format($line_total,2) }}</span>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                <div class="account-order-total-table ord_summary" style="display: block;">
                                    <table class="table no-border tb1 thead-light bigf">
                                        <thead>
                                            <tr style="border-bottom:2px solid #0000000d">
                                                <td style="width: 70%; text-align: right;"><strong>Summary</strong></td>
                                                <td style="width: 30%; text-align: right;"></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="border-bottom:2px solid #0000000d">
                                                <td style="width: 70%; text-align: right;">
                                                    <span>Product Subtotal </span>
                                                </td>
                                                <td style="width: 30%; text-align: right;"><span
                                                        class="price">{{ number_format($subtotal,2) }}</span></td>
                                            </tr>
                                            <tr style="border-bottom:2px solid #0000000d">
                                                <td style="width: 70%; text-align: right;">
                                                    <span>Postage </span>
                                                </td>
                                                <td style="width: 30%; text-align: right;"><span
                                                        class="price">{{ number_format($total_postage,2) }}</span></td>
                                            </tr>
                                            @if ($penalty > 0)
                                            <tr style="border-bottom:2px solid #0000000d">
                                                <td style="width: 70%; text-align: right;">
                                                    <strong class="text-danger">Penalty </strong>
                                                </td>
                                                <td style="width: 30%; text-align: right;"><span
                                                    class="price text-danger">{{ number_format($penalty,2) }}</span></td>
                                                </tr>
                                            @endif
                                            @if ($discount > 0)
                                            <tr style="border-bottom:2px solid #0000000d">
                                                <td style="width: 70%; text-align: right;">
                                                    <strong class="text-danger">Penalty </strong>
                                                </td>
                                                <td style="width: 30%; text-align: right;"><span
                                                    class="price text-danger">{{ number_format($discount,2) }}</span></td>
                                                </tr>
                                            @endif
                                            @if ($cancel_fee > 0)
                                            <tr style="border-bottom:2px solid #0000000d">
                                                <td style="width: 70%; text-align: right;">
                                                    <strong class="text-danger">Cancel Fee </strong>
                                                </td>
                                                <td style="width: 30%; text-align: right;"><span
                                                    class="price text-danger">{{ number_format($cancel_fee,2) }}</span></td>
                                            </tr>
                                            @endif
                                            <?php
                                            $grand_total = ($subtotal+$total_postage+$penalty+$cancel_fee)-$discount;
                                            $due = $grand_total;
                                            ?>
                                            <tr style="border-bottom:2px solid #0000000d">
                                                <td style="width: 70%; text-align: right;"><strong>Total </strong></td>
                                                <td style="width: 30%; text-align: right;">
                                                    <strong class="price">{{ number_format($grand_total,2) }}</strong></td>
                                            </tr>
                                            @if (isset($payments) && !empty($payments))
                                            @foreach ($payments as $value)
                                            <?php
                                                $due -= $value->PAYMENT_AMOUNT;
                                            ?>
                                            <tr style="border-bottom:2px solid #0000000d">
                                                <td style="width: 70%; text-align: right;">
                                                    <strong class="paysl mr-4">Payment </strong>
                                                    <span class="pays mr-4" title="Payment Date">{{ date('d-m-Y',strtotime($value->TXN_DATE)) }}</span>
                                                    <span class="pays mr-4" title="Payment ID">
                                                        <a href=""
                                                            title="Click For Payment Detils">PAY-{{ $value->CODE }}</a>
                                                    </span>
                                                    <span class="pays" title="Payment Amout For The Order">
                                                        {{ number_format($value->PAYMENT_AMOUNT,2) }}</span>
                                                </td>
                                                <td style="width: 30%; text-align: right;"><strong>{{ number_format($value->PAYMENT_AMOUNT,2) }}</strong></td>
                                            </tr>
                                            @endforeach
                                            @endif
                                            <tr style="border-bottom:2px solid #0000000d">
                                                <td style="width: 70%; text-align: right;"><strong
                                                        class="text-danger">DUE </strong></td>
                                                <td style="width: 30%; text-align: right;"><strong
                                                        class="text-danger">{{ number_format($due,2) }}</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                {{-- <iframe src="https://www.robertdyas.co.uk/sales/order/printInvoice/invoice_id/437984/#toolbar=0" width="100%" height="750px" frameborder="0"></iframe> --}}
                            </div>
                            <div role="tabpanel" class="tab-pane" id="Deliveries">
                                <table class="table" id="order_view_table">
                                    <thead>
                                        <tr class="tabtr">
                                            <th style="width: 100px;">Product</th>
                                            <th style="width: 340px;">Product Name</th>
                                            <th style="width: 200px;">Consignment</th>
                                            <th style="width: 110px;">Unit Price</th>
                                            <th style="width: 115px;">Qty</th>
                                            <th class="text-right">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $subtotal = 0;
                                        $total_postage = 0;
                                        $grand_total = 0;
                                        ?>
                                        @if (isset($dispatched) && !empty($dispatched))
                                        @foreach ($dispatched as $child)
                                        <?php
                                        // echo '<pre>';
                                        // echo '======================<br>';
                                        // print_r($child);
                                        // echo '<br>======================<br>';
                                        // exit();
                                        $line_postage   = 0;
                                        $line_total     = 0;
                                        if ($child->CURRENT_IS_REGULAR == 1) {
                                            $unit_price = $child->CURRENT_REGULAR_PRICE;
                                        }else{
                                            $unit_price = $child->CURRENT_INSTALLMENT_PRICE;
                                        }
                                        if ($child->CURRENT_IS_SM == 1) {
                                            $unit_postage = $child->CURRENT_SM_COST;
                                        }else{
                                            $unit_postage = $child->CURRENT_SS_COST;
                                        }
                                        $line_total     = $unit_price*$child->qty;
                                        $line_postage   = $unit_postage*$child->qty;
                                        $subtotal += $line_total;
                                        $total_postage += $line_postage;
                                        ?>
                                        <tr style="border-bottom: .1rem solid #ebebeb">
                                            <td class="">
                                                <div class="account-order-table-item-data">
                                                    <a class="" href="" target="_blank">
                                                        <img src="{{ $child->PRD_VARIANT_IMAGE_PATH }}" alt="IMAGE"
                                                            class="img-fluid" style="width: 80px;">
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="" target="_blank"
                                                    title="{{ $child->PRD_VARINAT_NAME }}">
                                                    {{ $child->PRD_VARINAT_NAME }}
                                                </a>
                                            </td>
                                            <td class="">
                                                <p style="color:#212529">{{ $child->COURIER_TRACKING_NO }}</p>
                                                <p style="color:#212529">{{ $child->dispatch_details->order_consignment->courier->COURIER_NAME ?? NULL }}</p>
                                            </td>
                                            <td>
                                                <span class="price">RM {{ number_format($unit_price,2) }}</span>
                                            </td>
                                            <td class="account-order-table-item-qty">
                                                @if ($child->qty > 0)
                                                <p style="color:#212529">Shipped: {{ $child->qty }}</p>
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                RM <span class="price"> {{ number_format($line_total,2) }}</span>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                @if ($subtotal > 0)
                                <div class="account-order-total-table ord_summary" style="display: block;">
                                    <table class="table no-border tb1 thead-light bigf">
                                        <thead>
                                            <tr style="border-bottom:2px solid #0000000d">
                                                <td style="width: 70%; text-align: right;"><strong>Summary</strong></td>
                                                <td style="width: 30%; text-align: right;"></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="border-bottom:2px solid #0000000d">
                                                <td style="width: 70%; text-align: right;">
                                                    <span>Product Subtotal </span>
                                                </td>
                                                <td style="width: 30%; text-align: right;"><span
                                                        class="price">{{ number_format($subtotal,2) }}</span></td>
                                            </tr>
                                            @if ($total_postage > 0)
                                            <tr style="border-bottom:2px solid #0000000d">
                                                <td style="width: 70%; text-align: right;">
                                                    <span>Postage </span>
                                                </td>
                                                <td style="width: 30%; text-align: right;"><span
                                                        class="price">{{ number_format($total_postage,2) }}</span></td>
                                            </tr>
                                            @endif
                                            @if ($penalty > 0)
                                            <tr style="border-bottom:2px solid #0000000d">
                                                <td style="width: 70%; text-align: right;">
                                                    <strong class="text-danger">Penalty </strong>
                                                </td>
                                                <td style="width: 30%; text-align: right;"><span
                                                    class="price text-danger">{{ number_format($penalty,2) }}</span></td>
                                                </tr>
                                            @endif
                                            @if ($discount > 0)
                                            <tr style="border-bottom:2px solid #0000000d">
                                                <td style="width: 70%; text-align: right;">
                                                    <strong class="text-danger">Penalty </strong>
                                                </td>
                                                <td style="width: 30%; text-align: right;"><span
                                                    class="price text-danger">{{ number_format($discount,2) }}</span></td>
                                                </tr>
                                            @endif
                                            @if ($cancel_fee > 0)
                                            <tr style="border-bottom:2px solid #0000000d">
                                                <td style="width: 70%; text-align: right;">
                                                    <strong class="text-danger">Cancel Fee </strong>
                                                </td>
                                                <td style="width: 30%; text-align: right;"><span
                                                    class="price text-danger">{{ number_format($cancel_fee,2) }}</span></td>
                                            </tr>
                                            @endif
                                            <tr style="border-bottom:2px solid #0000000d">
                                                <td style="width: 70%; text-align: right;"><strong>Total </strong></td>
                                                <td style="width: 30%; text-align: right;">
                                                    <strong class="price">{{ number_format((($subtotal+$total_postage+$penalty+$cancel_fee)-$discount),2) }}</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                @else
                                <p>You have not delivery product yet.</p>
                                @endif
                            </div>
                            @if (isset($booking_refund) && !empty($booking_refund))
                            <div role="tabpanel" class="tab-pane" id="Refunds">

                                @if (isset($booking_refund) && !empty($booking_refund))
                                <?php
                                ?>
                                @foreach ($booking_refund as $child)
                                <?php
                                // $subtotal = 0;
                                // $total_postage = 0;
                                // $grand_total = 0;
                                // $customer_postage = 0;
                                // $line_postage   = 0;
                                // $line_total     = 0;
                                if ($child->CURRENT_IS_REGULAR == 1) {
                                    $unit_price = $child->CURRENT_REGULAR_PRICE;
                                }else{
                                    $unit_price = $child->CURRENT_INSTALLMENT_PRICE;
                                }
                                if ($child->CURRENT_IS_SM == 1) {
                                    $unit_postage = $child->CURRENT_SM_COST;
                                }else{
                                    $unit_postage = $child->CURRENT_SS_COST;
                                }
                                // $line_total     = $unit_price*$child->qty;
                                // $line_postage   = $unit_postage*$child->qty;
                                // $subtotal += $line_total;
                                // $total_postage += $line_postage;
                                $customer_postage   = $child->CUSTOMER_POSTAGE ?? 0;
                                $refund_amount      = $child->REFUND_AMOUNT ?? 0;
                                ?>
                                <legend style="border-bottom: none;">
                                    <div class="account-order-items-actions-top">
                                      <a href="{{ route('profile.get-refund-invoice',['booking_pk'=>$booking->PK_NO,'aud_pk'=>$child->ID]) }}" id="print_refund_invoice"><i class="fa fa-print" aria-hidden="true"></i> Print to PDF </a>
                                    </div>
                                </legend>
                                <table class="table" id="order_view_table">
                                    <thead>
                                        <tr class="tabtr">
                                            <th style="width: 100px;">Product</th>
                                            <th style="width: 124px;">Product code</th>
                                            <th style="width: 370px;">Product Name</th>
                                            <th style="width: 110px;">Unit Price</th>
                                            <th style="width: 110px;">Postage</th>
                                            <th style="width: 10px;">Qty</th>
                                            <th class="text-right">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="border-bottom: .1rem solid #ebebeb">
                                            <td class="">
                                                <div class="account-order-table-item-data">
                                                    <a class="" href="" target="_blank">
                                                        <img src="{{ $child->PRD_VARIANT_IMAGE_PATH }}"
                                                            alt="IMAGE"
                                                            class="img-fluid" style="width: 80px;">
                                                    </a>
                                                </div>
                                            </td>
                                            <td>{{ $child->IG_CODE }}</td>
                                            <td>
                                                <a href="" target="_blank"
                                                    title="{{ $child->PRD_VARINAT_NAME }}">
                                                    {{ $child->PRD_VARINAT_NAME }}
                                                </a>
                                            </td>
                                            <td>
                                                <span class="price">RM {{ number_format($unit_price,2) }}</span>
                                            </td>
                                            <td>
                                                <span class="price">RM {{ number_format($unit_postage,2) }}</span>
                                            </td>
                                            <td class="account-order-table-item-qty">
                                                <p style="color:#212529">1</p>
                                            </td>
                                            <td class="text-right">
                                                RM <span class="price"> {{ number_format($unit_price+$unit_postage,2) }}</span>
                                                @if ($child->return_note != '')
                                                <a href="#retuen-note-modal" id="retuen_note" data-toggle="modal" data-note="{{ $child->return_note }}" class="" title="VIEW RETURN NOTE" style="padding: .5px 3px;border: 1px solid #f78902;"><i class="fa fa-sticky-note"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="account-order-total-table ord_summary mb-4" style="display: block;">
                                    <table class="table no-border tb1 thead-light bigf">
                                        <thead>
                                            <tr style="border-bottom:2px solid #0000000d">
                                                <td style="width: 70%; text-align: right;"><strong>Summary</strong></td>
                                                <td style="width: 30%; text-align: right;"></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($child->RETURN_TYPE == 4)
                                                <?php $credit_amount = $child->LINE_PRICE - $refund_amount; ?>
                                                <tr style="border-bottom:2px solid #0000000d">
                                                    <td style="width: 70%; text-align: right;">
                                                        <span>Penalty </span>
                                                    </td>
                                                    <td style="width: 30%; text-align: right;"><span
                                                            class="price">{{ number_format($refund_amount,2) }}</span></td>
                                                </tr>
                                                <tr style="border-bottom:2px solid #0000000d">
                                                    <td style="width: 70%; text-align: right;"><strong>Total </strong></td>
                                                    <td style="width: 30%; text-align: right;">
                                                        <strong class="price">{{ number_format(($credit_amount),2) }}</strong></td>
                                                </tr>
                                            @else
                                                @if ($customer_postage > 0)
                                                <tr style="border-bottom:2px solid #0000000d">
                                                    <td style="width: 70%; text-align: right;">
                                                        <span>Customer Postage </span>
                                                    </td>
                                                    <td style="width: 30%; text-align: right;"><span
                                                            class="price">{{ number_format($customer_postage,2) }}</span></td>
                                                </tr>
                                                @endif
                                                @if ($refund_amount > 0)
                                                <tr style="border-bottom:2px solid #0000000d">
                                                    <td style="width: 70%; text-align: right;">
                                                        <span>Refund </span>
                                                    </td>
                                                    <td style="width: 30%; text-align: right;"><span
                                                            class="price">{{ number_format($refund_amount,2) }}</span></td>
                                                </tr>
                                                @endif
                                                <tr style="border-bottom:2px solid #0000000d">
                                                    <td style="width: 70%; text-align: right;"><strong>Total </strong></td>
                                                    <td style="width: 30%; text-align: right;">
                                                        <strong class="price">{{ number_format(($customer_postage+$refund_amount),2) }}</strong></td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                @endforeach
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="account-order-details-view mt-8 px-2">
                        <h2 class="account-order-details-title">Order Information</h2>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="cart scart card">
                                    <div class="card-header border-bottom">
                                        <h4 class="pl-0 card-title">Delivery Address</h4>
                                    </div>
                                    <div class="card-body">
                                        <p>{{ $order->DELIVERY_NAME }} {{ $order->DELIVERY_LAST_NAME }}</p>
                                    <p>{{ $order->DELIVERY_ADDRESS_LINE_1 }}</p>
                                    <p>{{ $order->DELIVERY_ADDRESS_LINE_2 }}</p>
                                    <p>{{ $order->DELIVERY_CITY }} , {{ $order->DELIVERY_POSTCODE }}</p>
                                    <p>{{ $order->DELIVERY_STATE }} , {{ $order->DELIVERY_COUNTRY }}</p>
                                      <span>T : <a href="tel:{{ $order->to_country->DIAL_CODE }} {{ $order->DELIVERY_MOBILE }}" class="tn">
                                            {{ $order->to_country->DIAL_CODE }} {{ $order->DELIVERY_MOBILE }}</a></span>
                                    </address>
                                    <a href="javascript:void(0)" style="float: right" id="edit-order-address-popup" data-toggle="modal" data-target="#EditOrderAddress" data-address_id="2" data-type="billing">Edit <i class="icon-edit"></i></a>
                                    </div>
                                    <address>

                                </div>
                            </div>
                            @if(!empty($billing_address))
                            <div class="col-sm-3">
                                <div class="cart scart card">
                                    <div class="card-header border-bottom">
                                        <h4 class="card-title pl-0">Billing Address</h4>
                                    </div>
                                    <div class="card-body">
                                        <address>
                                            <p>{{ $billing_address->NAME }} {{ $billing_address->LAST_NAME }}</p>
                                            <p>{{ $billing_address->ADDRESS_LINE_1 }}</p>
                                        <p>{{ $billing_address->ADDRESS_LINE_2 }}</p>
                                        <p>{{ $billing_address->city->CITY_NAME }} , {{ $billing_address->POST_CODE }}</p>
                                        <p>{{ $billing_address->state->STATE_NAME ?? NULL }} , {{ $billing_address->country->NAME ?? NULL }}</p>
                                        <p><span>T : <a href="tel:{{ $billing_address->TEL_NO ?? $billing_address->MOBILE_NO }}" class="tn">
                                                {{ $billing_address->country->DIAL_CODE ?? NULL }} {{ $billing_address->TEL_NO ?? $billing_address->MOBILE_NO }}</a></span>
                                        </p>
                                        </address>
                                    </div>
                                </div>
                            </div>
                            @endif

                        </div>
                    </div>
                @else
                <span class="danger">Order Not Found !</span>
                @endif
            </div>
    </div>
</div>
</div>

@if (isset($booking) && !empty($booking))
<!--Update Order Address modal-->
<div class="modal fade text-left" id="EditOrderAddress" tabindex="-1" role="dialog"
    aria-labelledby="EditOrderAddress" aria-hidden="true" style="z-index: 9999999;">
    <div class="quickView-modal modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="source_name">Update Order Delivery Address</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="cus_add_modal">
            </div>
            <div class="modal-footer">
                <input type="reset" class="btn btn-secondary btn-sm" data-dismiss="modal" value="Close">
            </div>
        </div>
    </div>
</div>
<!--End Update Order Address modal html-->

<!--Start Return Note modal html-->
<div class="modal fade text-left" id="retuen-note-modal" tabindex="-1" role="dialog"
    aria-labelledby="retuen-note-modal" aria-hidden="true" style="z-index: 9999999;">
    <div class="quickView-modal modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="source_name">Return Note</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="p-4" id="note_body">

                </div>
            </div>
            <div class="modal-footer">
                <input type="reset" class="btn btn-secondary btn-sm" data-dismiss="modal" value="Close">
            </div>
        </div>
    </div>
</div>

@endif
@endsection
@push('custom_js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/pages/country.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/pages/order_view.js') }}"></script>
@endpush
