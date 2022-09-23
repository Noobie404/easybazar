<?php

namespace App\Repositories\Admin\Cart;

interface CartInterface
{
 
    public function getCartDetails($request);
    public function addToCart($request);
    public function removeCart($request);
    public function updateCartQty($request);
    public function postFlatDiscount($request);
    public function postCouponDiscount($request);
    public function getRemoveCoupon($request);


    
    
}
