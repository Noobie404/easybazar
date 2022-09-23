<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Your Order in easybazar</title>
</head>
<body>
    @php
        $settings   = getWebSettings();
        $image_path = getImagePath();
    @endphp
    <div style="height:100%;margin:0;padding:0;width:100%">
        <center>
            <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" style="border-collapse:collapse;height:100%;margin:0;padding:0;width:100%">
                <tbody>
                    <tr>
                        <td align="center" valign="top" style="height:100%;margin:0;padding:0;width:100%">
                            <table cellpadding="0" cellspacing="0" border="0" height="210" width="100%" style="border-collapse:collapse">
                                <tbody>
                                    <tr>
                                        <td bgcolor="#212121" valign="bottom">
                                            <div>
                                                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;max-width:1500px">
                                                    <tbody>
                                                        <tr>
                                                            <td valign="top" style="background-color:#transparent;background-image:none;background-repeat:no-repeat;background-position:center;background-size:cover;border-top:0;border-bottom:0;padding-top:0;padding-bottom:0">
                                                                <table border="0" cellpadding="0" cellspacing="0"
                                                                    width="100%"
                                                                    style="min-width:100%;border-collapse:collapse">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td valign="top" style="padding:9px">
                                                                                <table align="left" width="100%"
                                                                                    border="0" cellpadding="0" cellspacing="0" style="min-width:100%;border-collapse:collapse">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td valign="top" style="padding-right:9px;padding-left:9px;padding-top:0;padding-bottom:0;text-align:center">
                                                                                                <a href="https://easybazar.com" title="{{ $settings->TITLE ?? 'easybazar' }}" target="_blank">
                                                                                                @if(!empty($settings->EMAIL_HEADER_LOGO))
                                                                                                <img align="center" alt="{{ $settings->TITLE }}" src="{{ $image_path.$settings->EMAIL_HEADER_LOGO }}" width="248" style="max-width:112px;padding-bottom:0;display:inline!important;vertical-align:bottom;border:0;height:auto;outline:none;text-decoration:none">
                                                                                                @else
                                                                                                <img align="center" alt="easybazar" src="{{ $image_path }}/{{ 'app-assets/images/logo/easybazar-white.png' }}" width="248" style="max-width:112px;padding-bottom:0;display:inline!important;vertical-align:bottom;border:0;height:auto;outline:none;text-decoration:none">
                                                                                                @endif
                                                                                                </a>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;border-collapse:collapse">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td valign="top" style="padding:9px">
                                                                            <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" style="min-width:100%;border-collapse:collapse"></table>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>

                                                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%; border-collapse:collapse">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td valign="top" style="padding-top:30px">
                                                                                <table align="left" border="0"
                                                                                    cellpadding="0" cellspacing="0"
                                                                                    style="max-width:100%;min-width:100%;border-collapse:collapse"
                                                                                    width="100%">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td valign="top"
                                                                                                style="height:30px;background-color:#ffffff;border-top:1px solid #e3e9ed;border-left:1px solid #e3e9ed;border-right:1px solid #e3e9ed">
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse">
                                <tbody>
                                    <tr>
                                        <td align="center" valign="top" style="background-color:#f8fafb;background-image:none;background-repeat:no-repeat;background-position:center;background-size:cover;border-top:0;border-bottom:0;padding-top:0px;padding-bottom:20px">

                                            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#fff;border-left:1px solid #e3e9ed;border-right:1px solid #e3e9ed;border-bottom:1px solid #e3e9ed;border-collapse:collapse;max-width:1500px">
                                                <tbody>
                                                    <tr>
                                                        <td valign="top"
                                                            style="background-color:transparent;background-image:none;background-repeat:no-repeat;background-position:center;background-size:cover;border-top:0;border-bottom:0;padding-top:0;padding-bottom:0">
                                                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;border-collapse:collapse">
                                                                <tbody>
                                                                    <tr>
                                                                        <td valign="top">
                                                                            <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%;min-width:100%;border-collapse:collapse" width="100%">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td valign="top" style="padding-top:0;padding-right:30px;padding-bottom:30px;padding-left:10px;word-break:break-word;color:#5f7d95;font-family:Helvetica;font-size:16px;text-align:left">
                                                                                            {{-- <p style="font-size:26px;color:#374957;margin:0;font-weight:600;padding:0;font-family:Helvetica,Arial;line-height:150%;text-align:left">Thank you for shopping with us!</p> --}}
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <div style="padding: 10px;font-family: Helvetica,Arial;">
                                                                                                <table style="margin:0;width:100%" cellspacing="0" cellpadding="0" border="0">
                                                                                                    <tbody>
                                                                                                        <?php
                                                                                                        $data['order'] = $data['order_info']->getOrder;
                                                                                                        ?>
                                                                                                        <tr style="width:100%">
                                                                                                            <td style="width:50%;text-align:left">
                                                                                                                <h2>YOUR ORDER INFORMATION</h2>
                                                                                                            </td>
                                                                                                            <td style="width:50%;text-align:right">
                                                                                                                <h2>DELIVERY INFO</h2>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr style="width:100%">
                                                                                                            <td style="width:50%;text-align:left">
                                                                                                                <p style="margin-top:1px;margin-bottom:1px">Order Number : ORD-{{ $data['order_info']->BOOKING_NO }}</p>
                                                                                                            </td>
                                                                                                            <td style="width:50%;text-align:right">
                                                                                                                <p style="margin-top:1px;margin-bottom:1px">{{ $data['order']->DELIVERY_NAME}}</p>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr style="width:100%">
                                                                                                            <?php
                                                                                                            $date=date_create($data['order_info']->RECONFIRM_TIME);
                                                                                                            ?>
                                                                                                            <td style="width:50%;text-align:left">
                                                                                                                <p style="margin-top:1px;margin-bottom:1px">Order Placed : {{ $date->format('d F Y') }}</p>
                                                                                                            </td>
                                                                                                            @if ($data['order']->DELIVERY_ADDRESS_LINE_1)
                                                                                                            <td style="width:50%;text-align:right">
                                                                                                                <p style="margin-top:1px;margin-bottom:1px">Address 1 : {{ $data['order']->DELIVERY_ADDRESS_LINE_1 }}</p>
                                                                                                            </td>
                                                                                                            @endif
                                                                                                        </tr>
                                                                                                        <tr style="width:100%">
                                                                                                            <td style="width:50%;text-align:left">
                                                                                                                <p style="margin-top:1px;margin-bottom:1px">You served by : {{ $data['order_info']->BOOKING_SALES_AGENT_NAME }}</p>
                                                                                                            </td>
                                                                                                            @if ($data['order']->DELIVERY_ADDRESS_LINE_2)
                                                                                                            <td style="width:50%;text-align:right">
                                                                                                                <p style="margin-top:1px;margin-bottom:1px">Address 2 : {{ $data['order']->DELIVERY_ADDRESS_LINE_2 }}</p>
                                                                                                            </td>
                                                                                                            @endif
                                                                                                        </tr>
                                                                                                        <tr style="width:100%">
                                                                                                            <td style="width:50%;text-align:left">
                                                                                                                <p style="margin-top:1px;margin-bottom:1px">
                                                                                                                    @if ($data['order_info']->F_CUSTOMER_NO > 0)
                                                                                                                    Customer
                                                                                                                    @else
                                                                                                                    Reseller
                                                                                                                    @endif
                                                                                                                        No : {{ $data['order_info']->getCustomer->CUSTOMER_NO ?? $data['order_info']->getReseller->CUSTOMER_NO }}</p>
                                                                                                            </td>
                                                                                                            @if ($data['order']->DELIVERY_ADDRESS_LINE_3)
                                                                                                            <td style="width:50%;text-align:right">
                                                                                                                <p style="margin-top:1px;margin-bottom:1px">Address 3 : {{ $data['order']->DELIVERY_ADDRESS_LINE_3 }}</p>
                                                                                                            </td>
                                                                                                            @endif
                                                                                                        </tr>
                                                                                                        <tr style="width:100%">
                                                                                                            <td style="width:50%;text-align:left">
                                                                                                                <p style="margin-top:1px;margin-bottom:1px"> Your items may arrive separately.</p>
                                                                                                            </td>
                                                                                                            <td style="width:50%;text-align:right">
                                                                                                                <p style="margin-top:1px;margin-bottom:1px">
                                                                                                                    {!! !empty($data['order']->DELIVERY_CITY) ? $data['order']->DELIVERY_CITY." " : '' !!}
                                                                                                                    {!! !empty($data['order']->DELIVERY_POSTCODE) ? $data['order']->DELIVERY_POSTCODE."<br>" : '' !!}
                                                                                                                    {!! !empty($data['order']->DELIVERY_STATE) ? $data['order']->DELIVERY_STATE : '' !!}{!! !empty($data['order']->DELIVERY_COUNTRY) ? ', '.$data['order']->DELIVERY_COUNTRY."<br>" : '' !!}
                                                                                                                        <?php
                                                                                                                        if (!empty($data['order']->DELIVERY_MOBILE)) {
                                                                                                                            $delivery_mob1 = substr($data['order']->DELIVERY_MOBILE, 0, 2);
                                                                                                                            $delivery_mob2 = substr($data['order']->DELIVERY_MOBILE, 2, 3);
                                                                                                                            $delivery_mob3 = substr($data['order']->DELIVERY_MOBILE, 5,4);
                                                                                                                        }
                                                                                                                        ?>
                                                                                                                        {{ !empty($data['order']->DELIVERY_MOBILE) ? ($data['order']->getOrder->to_country->DIAL_CODE ?? '').' '.$delivery_mob1.' '.$delivery_mob2.' '.$delivery_mob3 : '' }}
                                                                                                                </p>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        {{-- <tr style="width:100%">
                                                                                                            <td style="width:50%;text-align:left">
                                                                                                                <p style="margin-top:1px;margin-bottom:1px">Estimated Delivery Date : 09 December
                                                                                                                    2020 </p>
                                                                                                            </td>
                                                                                                            <td style="width:50%;text-align:right">
                                                                                                                <p style="margin-top:1px;margin-bottom:1px">+6001128802559</p>
                                                                                                            </td>
                                                                                                        </tr> --}}
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>

                                                                                    <tr>
                                                                                        <td>
                                                                                            <div style="padding: 10px;font-family: Helvetica,Arial;">
                                                                                            <table style="margin:0;padding:0;width:100%" cellspacing="0" cellpadding="0" border="0">
                                                                                                <thead style="width:100%">
                                                                                                    <tr style="width:100%;background-color:#212121;color:#fff">
                                                                                                        <th style="width:15%;padding:10px">Image</th>
                                                                                                        <th style="width:33%;padding:10px;text-align:left">Product Description</th>
                                                                                                        <th style="width:12%;padding:10px;text-align:left">Product Code</th>
                                                                                                        <th style="width:10%;padding:10px;text-align:right">Unit Price (RM)</th>
                                                                                                        <th style="width:5%;padding:10px;text-align:right">Qty</th>
                                                                                                        <th style="width:10%;padding:10px;text-align:right">Subtotal (RM)</th>
                                                                                                    </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                    <?php
                                                                                                    $subtotal = 0;
                                                                                                    $total_postage = 0;
                                                                                                    $grand_total = 0;
                                                                                                    $due = 0;
                                                                                                    $penalty    = $data['order_info']->PENALTY_FEE ?? 0;
                                                                                                    $cancel_fee = $data['order_info']->CANCEL_FEE ?? 0;
                                                                                                    $discount   = $data['order_info']->DISCOUNT ?? 0;
                                                                                                    $payments   = $data['payments'] ?? [];
                                                                                                    $payment    = 0;
                                                                                                    ?>
                                                                                                    @if (isset($data['stock_info']) && !empty($data['stock_info']))
                                                                                                    @foreach ($data['stock_info'] as $item)
                                                                                                    <?php
                                                                                                    $line_total     = 0;
                                                                                                    if ($item->CURRENT_IS_REGULAR == 1) {
                                                                                                        $unit_price = $item->CURRENT_REGULAR_PRICE;
                                                                                                    }else{
                                                                                                        $unit_price = $item->CURRENT_INSTALLMENT_PRICE;
                                                                                                    }
                                                                                                    if ($item->CURRENT_IS_SM == 1) {
                                                                                                        $unit_postage = $item->CURRENT_SM_COST;
                                                                                                    }else{
                                                                                                        $unit_postage = $item->CURRENT_SS_COST;
                                                                                                    }
                                                                                                    $total_qty = $item->qty+$item->delete_qty+$item->refund_qty;

                                                                                                    $line_total     = $unit_price*($total_qty);
                                                                                                    $subtotal += $line_total;
                                                                                                    $total_postage += $unit_postage*($total_qty);
                                                                                                    $shipped_qty = $item->shipped_qty;
                                                                                                    ?>
                                                                                                    <tr>
                                                                                                        <td style="margin-bottom: 4px;display: block;"></td>
                                                                                                    </tr>
                                                                                                    <tr style="border-bottom:2px solid #212121">
                                                                                                        <td style="text-align:center;padding-right: 5px;">
                                                                                                            <img src="{{ getImagePath().$item->PRD_VARIANT_IMAGE_PATH }}" alt="{{ $item->PRD_VARINAT_NAME }}" style="width:100px;height:100px">
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <p>{{ $item->PRD_VARINAT_NAME }}</p>
                                                                                                            {{-- <p>Product code: TIS-1</p> --}}
                                                                                                        </td>
                                                                                                        <td>{{ $item->IG_CODE }}</td>
                                                                                                        <td>{{ number_format($unit_price) }}</td>
                                                                                                        <td>{{ $total_qty }}</td>
                                                                                                        <td style="text-align:right">
                                                                                                            {{ number_format($line_total,2) }}
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    @endforeach
                                                                                                    @endif
                                                                                                    @if (isset($data['deleted_items']) && !empty($data['deleted_items']))
                                                                                                    @foreach ($data['deleted_items'] as $item)
                                                                                                    <?php
                                                                                                    $line_total     = 0;
                                                                                                    if ($item->CURRENT_IS_REGULAR == 1) {
                                                                                                        $unit_price = $item->CURRENT_REGULAR_PRICE;
                                                                                                    }else{
                                                                                                        $unit_price = $item->CURRENT_INSTALLMENT_PRICE;
                                                                                                    }
                                                                                                    if ($item->CURRENT_IS_SM == 1) {
                                                                                                        $unit_postage = $item->CURRENT_SM_COST;
                                                                                                    }else{
                                                                                                        $unit_postage = $item->CURRENT_SS_COST;
                                                                                                    }
                                                                                                    $line_total     = $unit_price*($item->delete_qty);
                                                                                                    $subtotal += $line_total;
                                                                                                    $total_postage += $unit_postage*($item->delete_qty);
                                                                                                    ?>
                                                                                                    <tr>
                                                                                                        <td style="margin-bottom: 4px;display: block;"></td>
                                                                                                    </tr>
                                                                                                    <tr style="border-bottom:2px solid #212121">
                                                                                                        <td style="text-align:center;padding-right: 5px;">
                                                                                                            <img src="{{ getImagePath().$item->PRD_VARIANT_IMAGE_PATH }}" alt="{{ $item->PRD_VARINAT_NAME }}" style="width:100px;height:100px">
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <p>{{ $item->PRD_VARINAT_NAME }}</p>
                                                                                                        </td>
                                                                                                        <td>{{ $item->IG_CODE }}</td>
                                                                                                        <td>{{ number_format($unit_price) }}</td>
                                                                                                        <td>{{ $item->delete_qty }}</td>
                                                                                                        <td style="text-align:right">
                                                                                                            {{ number_format($line_total,2) }}
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    @endforeach
                                                                                                    @endif
                                                                                                    @if (isset($data['returned_items']) && !empty($data['returned_items']))
                                                                                                    @foreach ($data['returned_items'] as $item)
                                                                                                    <?php
                                                                                                    $line_total     = 0;
                                                                                                    if ($item->CURRENT_IS_REGULAR == 1) {
                                                                                                        $unit_price = $item->CURRENT_REGULAR_PRICE;
                                                                                                    }else{
                                                                                                        $unit_price = $item->CURRENT_INSTALLMENT_PRICE;
                                                                                                    }
                                                                                                    if ($item->CURRENT_IS_SM == 1) {
                                                                                                        $unit_postage = $item->CURRENT_SM_COST;
                                                                                                    }else{
                                                                                                        $unit_postage = $item->CURRENT_SS_COST;
                                                                                                    }
                                                                                                    $line_total     = $unit_price*($item->return_qty);
                                                                                                    $subtotal += $line_total;
                                                                                                    $total_postage += $unit_postage*($item->return_qty);
                                                                                                    ?>
                                                                                                    <tr>
                                                                                                        <td style="margin-bottom: 4px;display: block;"></td>
                                                                                                    </tr>
                                                                                                    <tr style="border-bottom:2px solid #212121">
                                                                                                        <td style="text-align:center;padding-right: 5px;">
                                                                                                            <img src="{{ getImagePath().$item->PRD_VARIANT_IMAGE_PATH }}" alt="{{ $item->PRD_VARINAT_NAME }}" style="width:100px;height:100px">
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <p>{{ $item->PRD_VARINAT_NAME }}</p>
                                                                                                        </td>
                                                                                                        <td>{{ $item->IG_CODE }}</td>
                                                                                                        <td>{{ number_format($unit_price) }}</td>
                                                                                                        <td>{{ $item->return_qty }}</td>
                                                                                                        <td style="text-align:right">
                                                                                                            {{ number_format($line_total,2) }}
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    @endforeach
                                                                                                    @endif
                                                                                                    <tr>
                                                                                                        <td style="border-bottom: 3px solid #212121;"></td>
                                                                                                        <td style="border-bottom: 3px solid #212121;"></td>
                                                                                                        <td style="border-bottom: 3px solid #212121;"></td>
                                                                                                        <td style="border-bottom: 3px solid #212121;"></td>
                                                                                                        <td style="border-bottom: 3px solid #212121;"></td>
                                                                                                        <td style="border-bottom: 3px solid #212121;"></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td style="padding-top: 10px; padding-bottom: 10px;"></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td colspan="5" style="text-align:right"><strong>Total</strong> </td>
                                                                                                        <td style="text-align:right"><strong>{{ number_format($subtotal,2) }}</strong>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    @if ($total_postage > 0)
                                                                                                    <tr>
                                                                                                        <td colspan="5" style="text-align:right">Delivery charge </td>
                                                                                                        <td style="text-align:right">{{ number_format($total_postage,2) }}</td>
                                                                                                    </tr>
                                                                                                    @endif
                                                                                                    @if ($penalty > 0)
                                                                                                    <tr>
                                                                                                        <td colspan="5" style="text-align:right">Penalty</td>
                                                                                                        <td style="text-align:right">{{ number_format($penalty,2) }}</td>
                                                                                                    </tr>
                                                                                                    @endif
                                                                                                    @if ($cancel_fee > 0)
                                                                                                    <tr>
                                                                                                        <td colspan="5" style="text-align:right">Cancel Fee</td>
                                                                                                        <td style="text-align:right">{{ number_format($cancel_fee,2) }}</td>
                                                                                                    </tr>
                                                                                                    @endif
                                                                                                    @if ($discount > 0)
                                                                                                    <tr>
                                                                                                        <td colspan="5" style="text-align:right">Discount</td>
                                                                                                        <td  style="text-align:right">{{ number_format($discount,2) }}</td>
                                                                                                    </tr>
                                                                                                    @endif
                                                                                                    <?php
                                                                                                    $grand_total = ($subtotal+$total_postage+$penalty+$cancel_fee)-$discount;
                                                                                                    $due = $grand_total;
                                                                                                    ?>
                                                                                                    <tr>
                                                                                                        <td colspan="5" style="text-align:right"><strong>Grand Total</strong> </td>
                                                                                                        <td style="text-align:right"><strong>{{ number_format($grand_total,2) }}</strong>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    @if (isset($payments) && !empty($payments))
                                                                                                    @foreach ($payments as $value)
                                                                                                    <?php
                                                                                                        $due        -= $value->PAYMENT_AMOUNT;
                                                                                                        $payment    += $value->PAYMENT_AMOUNT;
                                                                                                    ?>
                                                                                                    @endforeach
                                                                                                    <tr>
                                                                                                        <td colspan="5" style="text-align:right"><strong>Paid</strong></td>
                                                                                                        <td  style="text-align:right"><strong>{{ number_format($payment,2) }}</strong></td>
                                                                                                    </tr>
                                                                                                    @endif
                                                                                                    @if ($due > 0)
                                                                                                    <tr>
                                                                                                        <td colspan="5" style="text-align:right"><strong>Due</strong></td>
                                                                                                        <td  style="text-align:right"><strong>{{ number_format($due,2) }}</strong></td>
                                                                                                    </tr>
                                                                                                    @endif
                                                                                                </tbody>
                                                                                            </table>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td valign="top" style="padding-top: 30px;padding-right: 30px;padding-bottom: 30px;padding-left: 30px;word-break: break-word;color: #5f7d95;font-family: Helvetica;font-size: 13px;line-height: 150%;text-align: left;font-weight: 600;">
                                                                                            <div style="text-align: center;">
                                                                                                <a style="padding-right: 22px;color: #374957; font-weight: 700;" href="{{ url('/my-profile') }}">Please Click Here For Details</a>
                                                                                                <a style="padding-right: 22px;color: #374957; font-weight: 700;" href="{{ url('page/terms-and-conditions') }}">Our Terms & Condition</a>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top" id="m_-5683066376376837812templateFooter" style="background-color:#f8fafb;background-image:none;background-repeat:no-repeat;background-position:center;background-size:cover;border-top:0;border-bottom:0;padding-top:0px;padding-bottom:40px">
                                            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;max-width:600px">
                                                <tbody>
                                                    <tr>
                                                        <td valign="top" style="background-color:transparent;background-image:none;background-repeat:no-repeat;background-position:center;background-size:cover;border-top:0;border-bottom:0;padding-top:0px;padding-bottom:0px">
                                                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;border-collapse:collapse">
                                                                <tbody>
                                                                    <tr>
                                                                        <td valign="top" style="padding:9px">
                                                                            <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" style="min-width:100%;border-collapse:collapse">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td valign="top" style="padding-right:9px;padding-left:9px;padding-top:0;padding-bottom:0;text-align:center">
                                                                                            <a href="https://easybazar.com"  title="{{ $settings->TITLE ?? 'easybazar' }}" target="_blank">
                                                                                            @if(!empty($settings->EMAIL_FOOTER_LOGO))
                                                                                            <img align="center" alt="{{ $settings->TITLE }}" src="{{ $image_path.$settings->EMAIL_FOOTER_LOGO }}" width="100px" style="padding-bottom:0;display:inline!important;vertical-align:bottom;border:0;height:auto;outline:none;text-decoration:none">
                                                                                            @else
                                                                                            <img align="center" alt="easybazar" src="{{ $image_path }}/{{ 'app-assets/images/logo/easybazar-512.png' }}" width="100px" style="padding-bottom:0;display:inline!important;vertical-align:bottom;border:0;height:auto;outline:none;text-decoration:none">
                                                                                            @endif
                                                                                            </a>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;border-collapse:collapse;table-layout:fixed">
                                                                <tbody>
                                                                    <tr>
                                                                        <td style="min-width:100%;padding:12px 0px">
                                                                            <table border="0" cellpadding="0"
                                                                                cellspacing="0" width="100%"
                                                                                style="min-width:100%;border-top:1px solid #e3e9ed;border-collapse:collapse">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <span></span>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>

                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <table border="0" cellpadding="0" cellspacing="0"
                                                                width="100%"
                                                                style="min-width:100%;border-collapse:collapse">
                                                                <tbody>
                                                                    <tr>
                                                                        <td valign="top" style="padding-top:9px">
                                                                            <table align="left" border="0"
                                                                                cellpadding="0" cellspacing="0"
                                                                                style="max-width:100%;min-width:100%;border-collapse:collapse"
                                                                                width="100%">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td valign="top"
                                                                                            style="padding-top:0;padding-right:18px;padding-bottom:9px;padding-left:18px;word-break:break-word;color:#869fb2;font-family:Helvetica;font-size:13px;line-height:150%;text-align:center">
                                                                                            <p style="margin-top:0;margin-bottom:20px;margin:10px 0;padding:0;color:#869fb2;font-family:Helvetica;font-size:13px;line-height:150%;text-align:center">You will have access to all the platforms mentioned above by using the login details you have just entered to create your account.</p>
                                                                                            <p style="margin-top:0;margin-bottom:20px;margin:10px 0;padding:0;color:#869fb2;font-family:Helvetica;font-size:13px;line-height:150%;text-align:center">This is an automatically generated email, please do not reply.</p>
                                                                                            <p style="margin-top:0;margin-bottom:20px;margin:10px 0;padding:0;color:#869fb2;font-family:Helvetica;font-size:13px;line-height:150%;text-align:center">© {{ date('Y') }} easybazar, All rights reserved.</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </center>
    </div>
</body>

</html>
