<?php
use Carbon\Carbon;
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
<tr id="prod_{{ $item->MRK_ID_COMPOSITE_CODE }}" style="@if($item->TOTAL_FREE_STOCK==0) opacity:.5; @endif">
    {!! Form::hidden('products[]', $item->VARIANT_PK_NO ?? '' ) !!}
    <td id="th_book_qty" class="text-center">
        <div class="qty-counter qtySelector">
            <a class="qty-btn increase-btn increaseQty"><i class="la la-caret-up"></i></a>
            <!-- <input name="booking_qty[]" class="form-control input-sm max_val_check remove_first_zero min_val_check booking_qty" type="number" min="1" max="{{ $item->TOTAL_FREE_STOCK  }}" value="{{ $line_qty }}" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1"> -->
            <input name="booking_qty[]" class="form-control input-sm booking_qty max_val_check" type="number" min="1" max="{{ $item->TOTAL_FREE_STOCK  }}" value="{{ $line_qty ?? 1 }}" placeholder="{{ $line_qty ?? 1 }}"  data-field="quantity">
            <a class="qty-btn decrease-btn decreaseQty"><i class="la la-caret-down"></i></a>
        </div>
    </td>

    <td style="width: 40%" class="position-relative">
        @if($item->TOTAL_FREE_STOCK==0)
            <div class="soldout-box">
                <div class="notice-text">out of stock</div>
            </div>
        @endif
        <div class="lightgallery" style="margin:0px  auto; text-align: center; ">
            <a class="img_popup" href="{{'https://admin.easybazar.com'.$item->PRIMARY_IMG_RELATIVE_PATH}}"  title="">
                <img style="width: 50px !important; height: 50px;" data-src="{{'https://admin.easybazar.com'.$item->PRIMARY_IMG_RELATIVE_PATH}}" alt="" src="{{'https://admin.easybazar.com'.$item->THUMB_PATH}}" class="unveil">
            </a>
        </div>
        <div class="product-title">
        {{ $item->VARIANT_NAME ?? '' }}
        <span class="badge">Stock:  {{ $item->TOTAL_FREE_STOCK ?? 0 }}</span>
        <div>৳ {{  number_format($unit_price,2) }} / {{ $item->F_SIZE_PARENT_NAME }}: {{ $item->SIZE_NAME }}</div>
        </div>
    </td>
    <td class="text-right">
    <span>৳ {{ number_format($unit_price,2) }}</span> x</span> <span>{{ $line_qty }}</span>
    <input name="unit_price[]" type="hidden" class="form-control pull-right text-right unit_price"  value="{{ $unit_price }}" readonly>
        <select class="form-control price_used hidden" name="price_used[]">
            @if(isset($price_used) && count($price_used) > 0 )
                @foreach($price_used as $k => $pu )
                <option vlaue="{{ $k }}" {{ $item->PRICE_USED == $pu ? 'selected' : '' }} >{{ $pu }}</option>
                @endforeach
            @endif
        </select>
    </td>

    <td style="width: 10%" class="text-right">
    ৳ <span class="_line_price">{{  number_format($unit_price*$line_qty,2) }}</span>
        <input name="product_price[]" class="form-control pull-right text-right product_price input-sm" type="number"  value="{{ $unit_price*$line_qty }}" readonly >
    </td>
    <td style="width: 10%" class="text-center">
        @if($item->BOOKING_STATUS <= 50 || $item->BOOKING_STATUS < 70)
        <a href="javascript:void(0)" class="text-right text-danger" id="delete_prd"><i class="la la-close"></i></a>
        @endif
        @if($item->BOOKING_STATUS == 90)
        @if($item->IS_RETURN=='0')
        <span>Return Requested</span>
        @elseif($item->IS_RETURN=='1')
        <span>Returned</span>
        @else
        <a href="javascript:void(0)" class="text-right text-danger" title="Product return" data-title="{{$item->VARIANT_NAME}}" order-id="{{$item->F_BOOKING_NO}}"  data-id="{{$item->PK_NO}}" id="return_prd"><i class="la la-undo"></i></a>
        @endif
        @endif
    </td>
    @if(isset($mode) && ($mode != 'view'))
    @endif
</tr>

 <!-- <script src="{{ asset('assets/lightgallery/js/lightgallery.min.js')}}"></script> -->
<script>
    //  $(".lightgallery").lightGallery();
// var minVal = 1, maxVal = 20; // Set Max and Min values
// $(".increaseQty").on('click', function(){
// 		var $parentElm = $(this).parents(".qtySelector");
// 		$(this).addClass("clicked");
// 		setTimeout(function(){
// 			$(".clicked").removeClass("clicked");
// 		},100);
// 		var value = $parentElm.find(".qtyValue").val();
// 		if (value < maxVal) {
// 			value++;
// 		}
// 		$parentElm.find(".qtyValue").val(value);
// });
// Decrease product quantity on cart page
// $(".decreaseQty").on('click', function(){
// 		var $parentElm = $(this).parents(".qtySelector");
// 		$(this).addClass("clicked");
// 		setTimeout(function(){
// 			$(".clicked").removeClass("clicked");
// 		},100);
// 		var value = $parentElm.find(".qtyValue").val();
// 		if (value > 1) {
// 			value--;
// 		}
// 		$parentElm.find(".qtyValue").val(value);
// 	});
</script>
