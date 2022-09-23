<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>INVOICE</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="UTF-8">
    <style media="all">
        @page {
            margin: 0;
            padding:0;
        }
        body{
            font-size: 0.875rem;
            font-family: '<?php echo  $font_family ?>';
            font-weight: normal;
            direction: left;
            text-align: left;
            padding:0;
            margin:0;
        }
        .gry-color *,
        .gry-color{
            color:#000;
        }
        table{
            width: 100%;
        }
        table th{
            font-weight: normal;
        }
        table.padding th{
            padding: .25rem .7rem;
        }
        table.padding td{
            padding: .25rem .7rem;
        }
        table.sm-padding td{
            padding: .1rem .7rem;
        }
        .border-bottom td,
        .border-bottom th{
            border-bottom:1px solid #eceff4;
        }
        .text-left{
            text-align:left;
        }
        .text-right{
            text-align:right;
        }
    </style>
</head>
<body>
    <div> 
       
        <?php 
            $setting = getWebSettings();
            $order =  $data['booking'] ?? [];
            $booking_details =  $data['booking_details'] ?? [];
        ?>
         @php
            $logo = $setting->HEADER_LOGO;
        @endphp
        <div style="background: #eceff4;padding: 1rem;">
            <table>
                <tr>
                    <td>
                        @if($logo != null)
                            <img src="{{ asset($logo) }}" height="30" style="display:inline-block;">
                        @else
                            <img src="{{ asset('assets/img/logo.png') }}" height="30" style="display:inline-block;">
                        @endif
                    </td>
                    <td style="font-size: 1.5rem;" class="text-right strong">INVOICE</td>
                </tr>
            </table>
            <table>
                <tr>
                    <td style="font-size: 1rem;" class="strong">{{$setting->TITLE}}</td>
                    <td class="text-right"></td>
                </tr>
                <tr>
                    <td class="gry-color small">{{ $setting->HQ_ADDRESS ?? NULL }}</td>
                    <td class="text-right"></td>
                </tr>
                <tr>
                    <td class="gry-color small">Email: {{ $setting->EMAIL_1 ?? NULL }}</td>
                    <td class="text-right small">
                        <span class="gry-color small">Order ID:</span> 
                        <span class="strong">{{ $order->PK_NO }}</span>
                </td>
                </tr>
                <tr>
                    <td class="gry-color small">Phone: {{ $setting->PHONE_1 }}</td>
                    <td class="text-right small">
                        <span class="gry-color small">Order Date:</span> 
                        <span class=" strong"> {{ date('d-m-Y H:i:s A', strtotime($order->BOOKING_TIME)) }}</span>
                    </td>
                </tr>
            </table>
        </div>
        <div style="padding: 1rem;padding-bottom: 0">
            <table>
                <tr><td class="strong small gry-color">Bill to:</td></tr>
                <tr><td class="strong">{{ $order->DELIVERY_NAME }}</td></tr>
                <tr>
                    <td class="gry-color small">{{ $order->DELIVERY_ADDRESS_LINE_1 }},
                        {{$order->DELIVERY_SUB_AREA_NAME }}, 
                        {{ $order->DELIVERY_AREA_NAME }}, 
                        {{ $order->DELIVERY_CITY }}, {{ $order->DELIVERY_STATE }}
                    </td>
                </tr>
                <tr><td class="gry-color small">Email: </td></tr>
                <tr><td class="gry-color small">Phone: {{ $order->DELIVERY_MOBILE }}</td></tr>
            </table>
        </div>

        <div style="padding: 1rem;">
            <table class="padding text-left small border-bottom">
                <thead>
                    <tr class="gry-color" style="background: #eceff4;">
                        <th width="35%" class="text-left">Product Name</th>
                        <th width="10%" class="text-left">Qty</th>
                        <th width="15%" class="text-left">Unit Price</th>
                        <th width="15%" class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="strong">
                    @if($booking_details)
	                @foreach ($booking_details as $key => $booking_details)
						<tr class="">
							<td>{{ $booking_details->VARIANT_NAME }}</td>
							<td class="">{{ $booking_details->REGULAR_PRICE }}</td>
							<td class="currency"> {{$booking_details->LINE_QTY }}</td>
			                <td class="text-right currency">{{$booking_details->LINE_PRICE }}</td>
						</tr>
					@endforeach
                    @endif
	            </tbody>
            </table>
        </div>

        <div style="padding:0 1.5rem;">
	        <table class="text-right sm-padding small strong">
	        	<thead>
	        		<tr>
	        			<th width="60%"></th>
	        			<th width="40%"></th>
	        		</tr>
	        	</thead>
		        <tbody>
			        <tr>
			            <td>
			            </td>
			            <td>
					        <table class="text-right sm-padding small strong">
						        <tbody>
							        <tr>
							            <th class="gry-color text-left">Sub Total</th>
							            <td class="currency text-right">{{ $order->SUB_TOTAL }}</td>
							        </tr>
							        <tr>
							            <th class="gry-color text-left">Shipping Cost</th>
							            <td class="currency text-right">{{ $order->POSTAGE_COST }}</td>
							        </tr>
				                    <tr class="border-bottom">
							            <th class="gry-color text-left">Coupon Discount</th>
							            <td class="currency text-right">{{ $order->COUPON_DISCOUNT }}</td>
							        </tr>
                                    <tr class="border-bottom">
							            <th class="gry-color text-left">Discount</th>
							            <td class="currency text-right">{{ $order->DISCOUNT }}</td>
							        </tr>
							        <tr>
							            <th class="text-left strong">Grand Total</th>
							            <td class="currency text-right">{{ $order->TOTAL_PRICE }}</td>
							        </tr>
						        </tbody>
						    </table>
			            </td>
			        </tr>
		        </tbody>
		    </table>
	    </div>
    </div>
</body>
</html>
