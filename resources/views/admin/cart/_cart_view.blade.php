@php
$subtotal = 0;
$tax = 0;
$shipping = 0;
$price = 0;
$unit_price = 0;
$branch_id = $branch_id;
$total = 0;
$flat_discount = session('flat_discount');
$coupon_discount = $coupon_discount ?? 0;
@endphp
<div class="pos-cart-list c-scrollbar-light">
<ul class="list-group list-group-flush">
@if(!empty($carts))
@foreach ($carts as $key => $item)
@php
$line_qty = $item->TOTAL_ITEM_QTY ?? 1;
if(!empty($item->SPECIAL_PRICE)){
    $unit_price = $item->SPECIAL_PRICE; 
}
else{
    $unit_price = $item->REGULAR_PRICE;
}
$line_total = $unit_price*$line_qty;
$subtotal += $line_total;
@endphp
    <li class="list-group-item py-0 pl-2 overflow-hidden" id="prod_{{ $item->PK_NO }}" style="@if($item->IN_STOCK==false) opacity:.5; @endif">
        <div class="row gutters-5 align-items-center">
            <div class="col-1 w-60px">

                <div class="quantity">
                    <div class="caret caret-up">
                        <button class="btn btn-icon btn-sm cart-update" data-id="{{ $item->PK_NO }}" type="button" data-type="plus"  data-field="qty-0">
                            <i class="la la-plus"></i>
                        </button>
                    </div>
                    <span class="onHoverCursor" >
                        <span>{{ $line_qty }}</span>
                    </span>
                    <div class="caret caret-down" title="Remove one from bag">
                        <button class="btn btn-icon btn-sm cart-update" data-id="{{ $item->PK_NO }}" type="button" data-type="minus"
                             data-field="qty-0">
                            <i class="la la-minus"></i>
                        </button>
                    </div>
            </div>

            </div>
            <div class="col-7 position-relative">
                    @if($item->IN_STOCK==false)
                    <div class="soldout-box">
                        <div class="notice-text">out of stock</div>
                    </div>
                    @endif
                <div class="cart-img">
                     <img style="width: 50px !important; height: 50px;" alt="" src="{{'https://admin.easybazar.com'.$item->THUMB_PATH}}" class="unveil">
                </div>
                <div class="text-truncate-2 line-height15">{{ $item->VARIANT_NAME}}</div>
                <span class="span badge badge-inline fs-12 badge-soft-secondary"></span>
                <div>৳ {{ $unit_price }} / {{ $item->SIZE_NAME }}</div>
            </div>
            <div class="col-3">
                <div class="fs-12 opacity-60">৳ {{ $unit_price }} x {{ $line_qty }}</div>
                <div class="fs-15 fw-600">৳ {{ $unit_price*$line_qty }}</div>
            </div>
            <div class="col-1">
                <button type="button" data-id="{{ $item->PK_NO}}" class="btn btn-circle btn-icon btn-sm btn-soft-danger ml-2 mr-0 float-right delete-cart">
                    <i class="la la-trash"></i>
                </button>
            </div>
        </div>
    </li>
@endforeach
</ul>
</div>
<div>
    <?php
        $total_tax = 0;
        // $flat_discount = 0;
        $postage_cost = getOrderDeliveryCost($subtotal,$branch_id) ?? 0;
        $total_discount = 0;
        if(!empty($coupon_discount)){
            $total = ($subtotal+$postage_cost)-($coupon_discount);
        }
        else{
            $total = ($subtotal+$postage_cost)-($flat_discount);
        }
    ?>
    <div class="d-flex justify-content-between fw-600 mb-2 opacity-70 text-muted">
        <span>Sub Total</span>
        <span>৳ {{number_format($subtotal,2)}}</span>
    </div>
    <div class="d-flex justify-content-between fw-600 mb-2 opacity-70 text-muted">
        <span>Tax</span>
        <span>৳ {{number_format($total_tax,2)}}</span>
    </div>
    <div class="d-flex justify-content-between fw-600 mb-2 opacity-70 text-muted">
        <span>Shipping</span>
        <span>৳ {{number_format($postage_cost,2)}}</span>
    </div>
    <div class="d-flex justify-content-between fw-600 mb-2 opacity-70 text-muted">
        <span>Discount</span>
        <span>৳ {{number_format($flat_discount,2)}}</span>
    </div>
    <div class="d-flex justify-content-between fw-600 mb-2 opacity-70 text-muted">
        <span>Coupon Discount</span>
        <span>৳ {{number_format($coupon_discount,2)}}</span>
    </div>
    <div class="d-flex justify-content-between fw-600 fs-18 border-top pt-2 text-muted">
        <span>Total</span>
        <span>৳ {{number_format($total,2)}}</span>
    </div>
</div>
@else
<tr>
    <td colspan="5" class="text-center">
        <i class="la la-frown la-3x opacity-50"></i>
        <p>{{ 'No Product Added' }}</p>
    </td>
</tr>
@endif