<?php

$rows = $data ?? [];
$unit_price = 0;
$line_qty = 0


?>
@if(!empty($rows) && count($rows) > 0 )
@foreach ($rows as $key => $row)
   <div class="col-3 col-md-2" style="@if($row->IS_STOCK==false) opacity:.5; @endif ">
        <div class="card bg-white c-pointer product-card hov-container shadow overfolow-hidden">
            <div class="position-relative">
                <span class="absolute-top-left mt-1 ml-1 mr-0">
                    <span class="badge badge-inline badge-success fs-13">In stock
                    : {{$row->TOTAL_STOCK}}</span>
                </span>
                <span class="float-right badge badge-inline badge-warning absolute-bottom-left mb-1 ml-1 mr-0 fs-13 text-truncate">{{$row->SIZE_NAME}}</span>
                <img src="{{fileExit($row->PRIMARY_IMG_RELATIVE_PATH)}}" class="card-img-top img-fit h-120px h-xl-180px h-xxl-210px mw-100 mx-auto">
            </div>
            <div class="card-body p-2 p-xl-3">
                <div class="text-truncate fw-600 fs-14 mb-2">{{$row->VARIANT_NAME}}</div>
                <div class="">
                    <h4>
                        @if($row->SPECIAL_PRICE)
                        <label>
                            <span>
                                ৳ <span class="sp_amt mr-1"> <del>{{$row->REGULAR_PRICE}}</del></span>
                            </span>
                            <span>
                                ৳ <span class="sp_amt"> {{$row->SPECIAL_PRICE ?? 0}}</span>
                            </span>
                        </label>
                        @else
                        <label v-else>
                            <span class="sp_amt mr-1">৳ {{$row->REGULAR_PRICE}}</span>
                        </label>
                        @endif
                    </h4>
                </div>
            </div>
            <div class="add-plus absolute-full rounded overflow-hidden hov-box btn-cart" data-stock-id="{{$row->TOTAL_FREE_STOCK}}" data-id="{{$row->PK_NO}}">
                <div class="absolute-full bg-dark opacity-50">
                </div>
                <i class="la la-plus absolute-center la-6x text-white"></i>
            </div>
        </div>
   </div>
@endforeach
<input type="hidden" name="total_page" id="total-page" value="{{$rows->lastPage()}}">
@else
<div class="col-12">
    <div class="text-center">
        <i class="la la-frown la-3x opacity-50"></i>
        <p>Product Not Found</p>
    </div>
</div>
@endif
