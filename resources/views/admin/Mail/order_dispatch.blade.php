<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Order Has been Dispatched</title>
</head>
<body>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Your Order Has been Dispatched</title>
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
<a href="https://azuramart.com" title="{{ $settings->TITLE ?? 'Azuramart' }}" target="_blank">
@if(!empty($settings->EMAIL_HEADER_LOGO))
<img align="center" alt="{{ $settings->TITLE }}" src="{{ $image_path.$settings->EMAIL_HEADER_LOGO }}" width="248" style="max-width:112px;padding-bottom:0;display:inline!important;vertical-align:bottom;border:0;height:auto;outline:none;text-decoration:none">
@else
<img align="center" alt="Azuramart" src="{{ $image_path }}/{{ 'app-assets/images/logo/azuramart-white.png' }}" width="248" style="max-width:112px;padding-bottom:0;display:inline!important;vertical-align:bottom;border:0;height:auto;outline:none;text-decoration:none">
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
            <p style="font-size:26px;color:#374957;margin:0;font-weight:600;padding:0;font-family:Helvetica,Arial;line-height:150%;text-align:left">Thank you for shopping with us!</p>
        </td>
    </tr>
    <tr>
        <td>
            <div style="padding: 10px;font-family: Helvetica,Arial;">
                <table style="margin:0;padding:0;width:100%" cellspacing="0" cellpadding="0" border="0">
                    <thead style="width:100%">
                        <tr style="width:100%;background-color:#212121;color:#fff">
                            {{-- <th style="width:5%;padding:10px">SL</th> --}}
                            <th style="width:20%;padding:10px">Image</th>
                            <th style="width:55%;padding:10px;text-align:left">Product Description</th>
                            <th style="width:20%;padding:10px;text-align:right">Price (RM)</th>
                        </tr>
                    </thead>
<tbody>
    <?php
    $subtotal = 0;
    $total_postage = 0;
    $grand_total = 0;
    $due = 0;
    ?>
    @if ($rows['order_info']->IS_BUNDLE_MATCHED == 1)
        @if (isset($rows['bundle']) && !empty($rows['bundle']))
            <tr>
                <td style="margin-bottom: 20px;display: block;"></td>
            </tr>
            @foreach($rows['bundle'] as $key => $bundle)
                @foreach($bundle as $key => $inner_bundle)
                    <?php
                    $line_total     = 0;
                    if ($inner_bundle->CURRENT_IS_REGULAR == 1) {
                        $unit_price = $inner_bundle->TOTAL_REGULAR_BUNDLE_PRICE;
                        $default_amount = $inner_bundle->TOTAL_REGULAR_PRICE;
                    }else{
                        $unit_price = $inner_bundle->TOTAL_INSTALLMENT_BUNDLE_PRICE;
                        $default_amount = $inner_bundle->TOTAL_INSTALLMENT_PRICE;
                    }
                    if ($inner_bundle->CURRENT_IS_SM == 1) {
                        $unit_postage = $inner_bundle->P_SM*$inner_bundle->BUNDLE_QTY;
                    }else{
                        $unit_postage = $inner_bundle->P_SS*$inner_bundle->BUNDLE_QTY;
                    }
                    $line_total     = $unit_price;
                    $subtotal += $line_total;
                    $total_postage += $unit_postage;
                    ?>
                    <tr class="offer_tr" style="color: #fff;background: #212121;border:1px solid #212121;">
                        <td colspan="3" style="text-align: center;height: 50px;padding: 10px 10px;">@if ($inner_bundle->BUNDLE_QTY > 1){{ $inner_bundle->BUNDLE_QTY }} X @endif{{ $inner_bundle->BUNDLE_NAME_PUBLIC ?? '' }}
                        <p style="font-weight: 500;color: #fff;position: relative;">Offer Value RM {{ number_format($unit_price,2) }}, You Saved RM {{ number_format($default_amount - $unit_price,2) }}<span style="position: absolute;right: 0;">RM {{ number_format($unit_price,2) }}</span></p>
                        </td>
                    </tr>
                    @foreach($inner_bundle->bundle_breakdown as $key => $items)
                        <?php
                        $total_qty = $items->VARIANT_COUNT;
                        if ($items->CURRENT_IS_REGULAR == 1) {
                            $unit_default_price = $items->REGULAR_PRICE;
                        }else{
                            $unit_default_price = $items->INSTALLMENT_PRICE;
                        }
                        ?>
                        <tr style="border-bottom: @if($loop->last) 1px solid #212121; @else .1rem solid #ebebeb; @endif border-right: 1px solid #212121;border-left: 3px solid #212121;">
                            <td style="text-align:center;padding-right: 5px;border-left:1px solid #212121">
                                <img src="{{ env('APP_URL') }}public/{{ $items->THUMB_PATH }}" alt="{{ $items->PRD_VARINAT_NAME }}" style="width:100px;height:100px">
                            </td>
                            <td colspan="2" style="border-right:1px solid #212121">
                                <p>{{ $items->PRD_VARINAT_NAME }}</p>
                                <p>Qty : {{ $total_qty }}</p>
                            </td>
                        </tr>
                        @if ($loop->last)
                        <tr>
                            <td style="border-bottom: 1px solid #212121;"></td>
                            <td style="border-bottom: 1px solid #212121;"></td>
                            <td style="border-bottom: 1px solid #212121;"></td>
                        </tr>
                        @endif
                        @endforeach
                        <tr>
                            <td style="margin-bottom: 20px;display: block;"></td>
                        </tr>
                @endforeach
            @endforeach
        @endif
        @if (isset($rows['non_bundle']) && !empty($rows['non_bundle']))
            @foreach($rows['non_bundle'] as $b => $inner_nrow )
                @foreach($inner_nrow as $b => $nrow )
                <?php
                $line_total     = 0;
                if ($nrow->CURRENT_IS_REGULAR == 1) {
                    $unit_price = $nrow->CURRENT_REGULAR_PRICE;
                    $unit_default_price = $nrow->REGULAR_PRICE;
                }else{
                    $unit_price = $nrow->CURRENT_INSTALLMENT_PRICE;
                    $unit_default_price = $nrow->INSTALLMENT_PRICE;
                }
                if ($nrow->CURRENT_IS_SM == 1) {
                    $unit_postage = $nrow->CURRENT_SM_COST;
                }else{
                    $unit_postage = $nrow->CURRENT_SS_COST;
                }
                $line_total     = $unit_price*$nrow->VARIANT_COUNT;
                $subtotal += $line_total;
                $total_postage += $unit_postage*$nrow->VARIANT_COUNT;
                $total_qty = $nrow->VARIANT_COUNT;
                ?>
                @if ($total_qty>0)
                <tr style="border-bottom: .1rem solid #ebebeb;">
                    <td style="text-align:center;padding-right: 5px;">
                        <img src="{{ env('APP_URL') }}public/{{ $nrow->THUMB_PATH }}" alt="{{ $nrow->PRD_VARINAT_NAME }}" style="width:100px;height:100px">
                    </td>
                    <td colspan="1">
                        <p>{{ $nrow->PRD_VARINAT_NAME }}</p>
                        <p>Qty : {{ $total_qty }}</p>
                    </td>
                    <td style="text-align:right">
                        {{ number_format($line_total) }}
                    </td>
                </tr>
                @endif
                @endforeach
            @endforeach
        @endif

    @else
            <?php
            $postage    = 0;
            $freight    = 0;
            $total      = 0;
            ?>
            @foreach ($rows['stock_info'] as $item)
            <?php
            $total_postage += $item->qty*$item->postage;
            $freight += $item->qty*$item->freight;
            ?>
            <tr>
                <td style="margin-bottom: 4px;display: block;"></td>
            </tr>
            <tr style="border-bottom:2px solid #212121">
                {{-- <td style="text-align:center">{{ $loop->index+1 }}</td> --}}
                <td style="text-align:center;padding-right: 5px;">
                    <img src="{{ env('APP_URL') }}public/{{ $item->productVariant->THUMB_PATH }}" alt="{{ $item->PRD_VARINAT_NAME }}" style="width:100px;height:100px">
                </td>
                <td>
                    <p>{{ $item->PRD_VARINAT_NAME }}</p>
                    {{-- <p>Product code: TIS-1</p> --}}
                    <p>Qty : {{ $item->qty }}</p>
                </td>
                <td style="text-align:right">
                    <?php $subtotal += $item->qty*$item->unit_price ?>
                    {{ number_format($item->qty*$item->unit_price,2) }}
                </td>
            </tr>
            @endforeach
    @endif
            <tr>
                <td style="border-bottom: 3px solid #212121;"></td>
                <td style="border-bottom: 3px solid #212121;"></td>
                <td style="border-bottom: 3px solid #212121;"></td>
            </tr>
            <tr>
                <td style="padding-top: 10px; padding-bottom: 10px;"></td>
            </tr>
            @if ($total_postage > 0)
            <?php $subtotal += $total_postage ?>
            <tr>
                <td colspan="2" style="text-align:right">Delivery charge </td>
                <td style="text-align:right">{{ number_format($total_postage,2) }}</td>
            </tr>
            @endif
            <tr>
                <td colspan="2" style="text-align:right"><strong>Total</strong> </td>
                <td style="text-align:right"><strong>{{ number_format($subtotal,2) }}</strong>
                </td>
            </tr>
</tbody>
                </table>
            </div>
        </td>
    </tr>
    <div class="chart">
        <tr>
            <td>
                <table style="width:100%;text-align:center">
                    <tbody>
                        <tr>
                            <td>
                                <p style="font-size:22px;margin:40px 0px 20px 0px"><strong style="font-family: Helvetica,Arial;">Tracking &amp; Delivery information</strong></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding: 10px;"><table style="width:100%;border:2px solid #212121;font-family: Helvetica,Arial;">
                <tbody style="width:100%">
                <tr><td style="width:50%">
                    <table style="width:100%;text-align:left;border-right:2px solid #212121">
                    <tbody>
                        <tr>
                        <td style="padding: 15px; font-size: 15px;">
                        <strong style="font-size:20px">Sent To :</strong>
                        <p>{{ $rows['consignment'][0]->TO_NAME }}</p>
                        <p>{{ $rows['consignment'][0]->TO_ADDRESS_LINE_1 }}</p>
                        <p>{{ $rows['consignment'][0]->TO_ADDRESS_LINE_2 }}</p>
                        <p>{{ $rows['consignment'][0]->TO_ADDRESS_LINE_3 }}</p>
                        <p>{{ $rows['consignment'][0]->TO_ADDRESS_LINE_4 }}</p>
                        <p>
                            {{ $rows['consignment'][0]->TO_CITY }}
                            {{ $rows['consignment'][0]->TO_POST_CODE }}
                        </p>
                        <p>
                            {{ $rows['consignment'][0]->TO_STATE }}
                            {{ $rows['consignment'][0]->TO_COUNTRY }}
                        </p>
                        <?php
                        if (!empty($rows['consignment'][0]->TO_TEL_NO)) {
                            $delivery_mob1 = substr($rows['consignment'][0]->TO_TEL_NO, 0, 2);
                            $delivery_mob2 = substr($rows['consignment'][0]->TO_TEL_NO, 2, 3);
                            $delivery_mob3 = substr($rows['consignment'][0]->TO_TEL_NO, 5,4);
                        }
                        ?>
                        {{ !empty($rows['consignment'][0]->TO_TEL_NO) ? ($rows['consignment'][0]->to_country->DIAL_CODE ?? '').' '.$delivery_mob1.' '.$delivery_mob2.' '.$delivery_mob3 : '' }}

                        </td>
                    </tr>
                    </tbody>
                </table>
                </td>
                <td style="width:50%">
                <table style="width:100%;text-align:right">
                    <tbody>
                    <tr>
                        <td style="padding: 15px; font-size: 15px;">
                        <strong style="font-size:20px"> Tracking Info :</strong>
                        @foreach ($rows['consignment'] as $items)
                        <?php
                        $order_date=date_create($items->order->booking->CONFIRM_TIME);
                        $dispatch_date=date_create($items->DISPATCH_DATE);
                        ?>
                        @if ($items->COURIER_TRACKING_NO)
                        <p>Tracking No : {{ $items->COURIER_TRACKING_NO }}</p>
                        <p>Carrier : <a href="{{ $items->courier->URLS }}" target="_blank">{{ $items->COURIER_NAME }}</a></p>
                        @else
                        <p>Carrier : Self Pickup
                        @endif
                        <p>Dispatch Date : {{ $dispatch_date->format('d F Y') }}</p>
                        <p>Order No : ORD-{{ $items->order->booking->BOOKING_NO }}</p>
                        <p>Order Date : {{ $order_date->format('d F Y') }}</p>
                        <p>Sales Agent : {{ $items->order->booking->SHOP_NAME ?? '' }}</p>
                        </td>
                        @endforeach
                    </tr>
                    </tbody>
                </table>
                </td>
            </tr></tbody>
            </table>
            </td>
            </tr>
    </div>
    <tr>
        <td valign="top" style="padding-top: 30px;padding-right: 30px;padding-bottom: 30px;padding-left: 30px;word-break: break-word;color: #5f7d95;font-family: Helvetica;font-size: 13px;line-height: 150%;text-align: left;font-weight: 600;">
            <div style="text-align: center;">
                <a style="padding-right: 22px;color: #374957; font-weight: 700;" href="#">Please Click Here For Details</a>
                <a style="padding-right: 22px;color: #374957; font-weight: 700;" href="#">Check Us On WhatsApp</a>
                <a style="padding-right: 22px;color: #374957; font-weight: 700;" href="#">Our Terms & Condition</a>
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
                                                                                            <td valign="top"
                                                                                                style="padding-right:9px;padding-left:9px;padding-top:0;padding-bottom:0;text-align:center">

<a href="https://azuramart.com" title="{{ $settings->TITLE ?? 'Azuramart' }}" target="_blank">
@if(!empty($settings->EMAIL_FOOTER_LOGO))
<img align="center" alt="{{ $settings->TITLE }}" src="{{ $image_path.$settings->EMAIL_FOOTER_LOGO }}" width="100px" style="padding-bottom:0;display:inline!important;vertical-align:bottom;border:0;height:auto;outline:none;text-decoration:none">
@else
<img align="center" alt="Azuramart" src="{{ $image_path }}/{{ 'app-assets/images/logo/azuramart-512.png' }}" width="100px" style="padding-bottom:0;display:inline!important;vertical-align:bottom;border:0;height:auto;outline:none;text-decoration:none">
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
                                                                                                <p style="margin-top:0;margin-bottom:20px;margin:10px 0;padding:0;color:#869fb2;font-family:Helvetica;font-size:13px;line-height:150%;text-align:center">© {{ date('Y') }} AzuraMart, All rights reserved.</p>
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
</body>
</html>
