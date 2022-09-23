<?php
$customer_address       = $data['customer_address'] ?? [];
$orders                 = $data['orders'] ?? [];
$history                = $data['history'] ?? [];
$address_type           = \Config::get('static_array.address_type');
$reseller               = $data['reseller'] ?? '';

?>
@extends('admin.layout.master')

@section('Reseller Management','open')
@section('balance','active')

@push('custom_css')
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}?v=2.1.2">
@endpush

@section('title') Balance @endsection
@section('page-name') Balance @endsection

@section('content')
<div class="content-body min-height">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-sm card-success">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="nav nav-tabs nav-top-border no-hover-bg nav-justified">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.reseller.history',['id' => $reseller->PK_NO]) }}">Account Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.reseller.reseller-details',['id' => $reseller->PK_NO]) }}">Personal Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.reseller.address-book',['id' => $reseller->PK_NO]) }}">Address Book</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.reseller.orders',['id' => $reseller->PK_NO]) }}">Orders</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.reseller.payments',['id' => $reseller->PK_NO]) }}">Payments</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="{{ route('admin.reseller.balance',['id' => $reseller->PK_NO]) }}">Balance</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card" >
                <div class="card-header border-bottom">
                    <h1 class="card-title">My Balance</h1>
                </div>

                <div class="card-body">
                    <div class="mb-md-2">
                        <span class="badge badge-success">CREDIT BALANCE - RM {{ number_format($reseller->CUM_BALANCE,2) }}</span>
                        <span class="badge badge-danger float-right">DUE BALANCE - RM {{ $data['due'] }}</span>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-sm dataTable no-footer">
                            <thead>
                                <tr class="table-head">
                                    <th class="text-center" style="width: 40px;">SL</th>
                                    <th class="text-center" style="width: 90px;">Date</th>

                                    <th class="text-center" style="width: 10px;">Description</th>
                                    <th class="text-center" style="width: 80px;">IN</th>
                                    <th class="text-center" style="width: 80px;">OUT</th>
                                    <th class="text-center" style="width: 80px;">Balance</th>

                                </tr>
                            </thead>
                            <tbody>

@php
$balance        = 0;
$html           = array();
$cum_balance    = 0;
$cum_order_due  = 0;
@endphp
@if(isset($data['history']) && count($data['history']) > 0 )
    @foreach($data['history'] as $k => $row)

    <?php
    $description = '';
    $details = '';
    $details1 = '';
    $ord_amount      = '';
    $pay_amount      = '';
    $status     = '';
    $breakdown = '';
    $payment_status = '';
    $refund_status = '';
    $unused_pay = '';
    $order_due = '';
    $order_value = 0;





    if($row->TYPE == 'Order Placed'){
    $order_value = ($row->ORDER_PRICE - $row->ORDER_DISCOUNT) ?? 0;
    $description .= '<div><a href="'.route('admin.order.view', ['id' => $row->BOOKING_PK_NO ]) .'" class="" target="_blank">ORD-'.$row->BOOKING_NO.'</a> <span class="">('. $row->TYPE.') - </span> <span class=""> '. number_format($order_value,2).'</span></div>';

    $order_value = $row->ORDER_PRICE;
    $ord_amount .= '<div>'.number_format($order_value, 2).'</div>';
    $balance -= $row->ORDER_PRICE;
    $cum_balance += $row->ORDER_PRICE;


    // if($row->IS_CANCEL == 1){
    // $status .= '<small class="badge badge-danger" title="Processing" data-oid="">Cancel</small>';
    // }else{
    // if($row->DISPATCH_STATUS == 40 ){
    //     $status .= '<small class="badge badge-success" title="Dispatched" data-oid="">Dispatched</small>';
    // }elseif($row->DISPATCH_STATUS == 35 ){
    //     $status .= '<small class="badge badge-warning" title="Partial Dispatched" data-oid="">Partial Dispatched</small>';
    // }else{
    //     $status .= '<small class="badge badge-info" title="Processing" data-oid="">Processing</small>';
    // }
    // }


    if($row->allPaymentForTheOrder && count($row->allPaymentForTheOrder) > 0 ){
    $details = '';
    foreach ($row->allPaymentForTheOrder as $item) {
    $details .= '<li><span class="f-15 fw-b"><a href="'.route('admin.payment.details',[ 'id' => $item->resellerPayment->bankTxn->PK_NO ]) .'" class="" target="_balank" title="Txn Date : '.date('d-m-Y',strtotime($item->resellerPayment->bankTxn->TXN_DATE)).'">PAY-'. $item->resellerPayment->bankTxn->CODE .'</a> - '.number_format($item->PAYMENT_AMOUNT,2).'</span></li>';
    }
    // $breakdown .= '<ul class="list-unstyled">'.$details.'</ul>';
    }
    // $order_due = number_format($row->ORDER_DUE,2);
    $cum_order_due += $row->ORDER_DUE;


    }elseif($row->TYPE == 'Order Return'){
    $order_value = $row->RETURN_PRICE;
    $ord_amount .= '<div>'.number_format($order_value, 2).'</div>';
    // $balance += $row->ORDER_PRICE;
    // $cum_balance += $row->ORDER_PRICE;

    // $order_due = number_format($row->ORDER_DUE,2);
    // $cum_order_due += $row->ORDER_DUE;
    $order_value = $row->RETURN_PRICE ?? 0;
    $description .= '<div><a href="'.route('admin.order.view', ['id' => $row->BOOKING_PK_NO ]) .'" class="" target="_blank">ORD-'.$row->BOOKING_NO.'</a> <span class="">('. $row->TYPE.') - </span> <span class=""> '. number_format($order_value,2).'</span></div>';


    }elseif($row->TYPE == 'Penalty'){
    $order_value = $row->PENALTY_FEE;
    $ord_amount .= '<div>'.number_format($order_value, 2).'</div>';
    $balance += $row->PENALTY_FEE;
    $cum_balance += $row->PENALTY_FEE;

    // $order_due = number_format($row->ORDER_DUE,2);
    // $cum_order_due += $row->ORDER_DUE;
    $order_value = $row->PENALTY_FEE ?? 0;
    $description .= '<div><a href="'.route('admin.order.view', ['id' => $row->BOOKING_PK_NO ]) .'" class="" target="_blank">ORD-'.$row->BOOKING_NO.'</a> <span class="">('. $row->TYPE.') - </span> <span class=""> '. number_format($order_value,2).'</span></div>';


    }elseif($row->TYPE == 'Payment'){
    $order_value = $row->PAY_AMOUNT;
    if($row->PAYMENT_VERIFY == 1){ $payment_status = ' text-success';$title='Payment varified'; }else{$payment_status = ' text-warning';$title='Payment unvarified';}
    $description .= '<div><a href="'.route('admin.payment.details',[ 'id' => $row->TX_PK_NO ]).'" class="'.$payment_status.'" title="'.$title.'" target="_blank">PAY-'.$row->PAYMENT_NO.'</a><span class=""> ('.$row->TYPE.') - </span><span class="">'.number_format($order_value,2).'</span></div>';

    $order_value = $row->PAY_AMOUNT;
    $pay_amount .= '<div>'.number_format($order_value, 2).'</div>';

    if($row->PAYMENT_VERIFY == 1){
    $balance += $row->PAY_AMOUNT;
    }
    $cum_balance -= $row->PAY_AMOUNT;
    // $unused_pay = number_format($row->PAYMENT_REMAINING_MR,2);

    if($row->allOrderPayments && count($row->allOrderPayments) > 0 ){
    $details = '';
    foreach ($row->allOrderPayments as $item) {
    $details .= '<li><span class="f-15 fw-b"><a href="'.route('admin.order.view', ['id' => $item->order->F_BOOKING_NO ?? '' ]) .'" class="" target="_balank" title="Order Date : '.date('d-m-Y',strtotime($item->order->booking->CONFIRM_TIME)).'">ORD-'. $item->order->booking->BOOKING_NO .'</a> '.number_format($item->PAYMENT_AMOUNT,2).'</span></li>';
    }
    // $breakdown .= '<ul class="list-unstyled">'.$details.'</ul>';
    }
    if(isset($row->allRefunds) && count($row->allRefunds) > 0 ){
    $details1 = '';
    foreach ($row->allRefunds as $refund) {
    if($refund->bankTxn->IS_MATCHED == 1){ $refund_status = ' text-success'; }else{$refund_status = ' text-warning';}

    $details1 .= '<li><div><a href="'.route('admin.payment.details',[ 'id' => 12 ]).'" class="'.$refund_status.'" target="_blank">PAY-'.$refund->bankTxn->CODE.'</a><span class=""> (Refund) </span><span class="">'.number_format($refund->MR_AMOUNT,2).'</span></div></li>';
    }
    if($details1){
    // $breakdown .= '<ul class="list-unstyled">'.$details1.'</ul>';
    }
    }

    }elseif($row->TYPE == 'AM payment'){
    $order_value = $row->PAY_AMOUNT;
    if($row->PAYMENT_VERIFY == 1){$payment_status = ' text-success'; }else{  $payment_status = ' text-warning';}
    // $description .= '<div><h6 class="'.$payment_status.'"><a href="'.route('admin.payment.details',[ 'id' => $row->TX_PK_NO ]).'" class="" target="_blank">PAY-'.$row->PAYMENT_NO.'</a><span class=""> ('.$row->TYPE.') </span><span class="">'.number_format($order_value,2).'</span></h6></div>';

    $description .= '<div><a href="'.route('admin.order.view',[ 'id' => $row->F_BOOKING_NO_FOR_PAYMENT_TYPE3 ]).'" class="'.$payment_status.'" target="_blank" title="Payment by AM for order item returned">Partial Payment ORD-'.$row->BOOKING_NO.'</a><span class=""> - </span><span class=""> - '.number_format($order_value,2).'</span></div>';

    $order_value = $row->PAY_AMOUNT;
    $pay_amount .= '<div>'.number_format($order_value, 2).'</div>';

    if($row->PAYMENT_VERIFY == 1){
    // $balance -= $row->PAY_AMOUNT;
    }
    //$cum_balance -= $row->PAY_AMOUNT;
    // $unused_pay = number_format($row->PAYMENT_REMAINING_MR,2);

    if($row->amPaymentForOrder ){
    $details = '';
    $item = $row->amPaymentForOrder;
    $details .= '<li><span class="f-15 fw-b"><a href="'.route('admin.order.view', ['id' => $item->PK_NO ?? '' ]) .'" class="" target="_balank" title="Order Date : '.date('d-m-Y',strtotime($item->CONFIRM_TIME)).'">ORD-'. $item->BOOKING_NO .'</a> '.number_format($row->PAY_AMOUNT,2).'</span></li>';

    // $breakdown .= '<ul class="list-unstyled">'.$details.'</ul>';
    }


    }elseif($row->TYPE == 'Refund'){
    $order_value = abs($row->PAY_AMOUNT);
    if($row->PAYMENT_VERIFY == 1){ $payment_status .= 'text-success'; }else{$payment_status .= 'text-warning';}
    $description .= '<div><a href="'.route('admin.payment.details',[ 'id' => $row->TX_PK_NO ]).'" class="'.$payment_status.'" target="_blank">PAY-'.$row->PAYMENT_NO.'</a><span class=""> ('.$row->TYPE.') - </span><span class="">'.number_format($order_value,2).'</span></div>';

    $pay_amount .= '<div>'.number_format($order_value, 2).'</div>';

    // if($row->PAYMENT_VERIFY == 1){
    $balance += $order_value;
    // }
    $cum_balance -= $order_value;
    //$unused_pay = number_format($row->PAYMENT_REMAINING_MR,2);
    }

    // $html[$k] = '<tr><td class="">'.($k+1).'</td><td class=""><p style="margin-bottom: 0px;">'.date('d-m-Y',strtotime($row->DATE_AT)) .'</p></td><td class=""><span class="text-upercase">'.$row->ENTRY_BY_NAME.'</span></td><td>'.$description.'</td><td class="text-right">'.$ord_amount.'</td><td class="text-right">'.$pay_amount.'</td><td class="text-right"><div>'.number_format($balance, 2).'</div></td><td>'.$unused_pay.'</td><td>'.$order_due.'</td><td class="">'.$status.'</td><td>'.$breakdown.'</td></tr>';
    $html[$k] = '<tr class="dashboard-orders-table-content"><td class="">'.($k+1).'</td><td class=""><p style="margin-bottom: 0px;">'.date('d-m-Y',strtotime($row->DATE_AT)) .'</p></td><td>'.$description.'</td><td class="text-right">'.$pay_amount.'</td><td class="text-right">'.$ord_amount.'</td><td class="text-right"><div>'.number_format($balance, 2).'</div></td></tr>';
    ?>

    @endforeach
    <?php
    // rsort($html);
    if(count($html)> 0){
        for ($i=0; $i < count($html); $i++) {
        echo $html[$i];
        }
    }
    ?>
@else
    <tr colspan="6">
        <td>You have not any transaction with your balance yet.</td>
    </tr>
@endif

                            </tbody>
                        </table>
                    </div>
                </div>


                    </div>
                </div>
            </div>

    </div>


@endsection
@push('custom_js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
@endpush
