<?php
namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

trait CouponTrait {

    public function checkCouponValidity($coupon_code,$branch_id)
    {
        $now                = Carbon::now();
        $info = DB::table('SLS_COUPON_MASTER')->where('COUPON_CODE',$coupon_code)->where('F_SHOP_NO',$branch_id)
        ->where('IS_ACTIVE',1)
        ->where('VALIDITY_TO', '>=', $now)
        ->where('VALIDITY_FROM', '<=', $now)
        ->first();
        if(!empty($info)){
            return true;
        }
        return false;

    }
    public function getCouponDiscount($coupon_code,$branch_id,$customer_id){
        session()->forget('flat_discount');
        session()->forget('coupon_code');
        session()->forget('coupon_discount');
        $total_amount = 0;
        $coupon_discount = 0;
        //COUPON REASSIGN
        if(isset($coupon_code) && !empty($coupon_code)){
            $carts = $this->getCart($customer_id,$branch_id);
            $data['is_coupon'] = 1;
            $now = Carbon::now();
            foreach($carts as $cart){
                if(!empty($cart->SPECIAL_PRICE)){
                    $total_amount += $cart->SPECIAL_PRICE;
                }
                else if(!empty($cart->REGULAR_PRICE)){
                    $total_amount += $cart->REGULAR_PRICE;
                }
                else{
                    $total_amount += $cart->REGULAR_PRICE;
                }
            }
            $coupon_master = DB::table('SLS_COUPON_MASTER')->where('COUPON_CODE',$coupon_code)->where('IS_ACTIVE',1)->where('VALIDITY_FROM','<=',$now)->first();
             //Flat amount/percentage from total amount
            if($coupon_master->COUPON_ON == 3){
               //COUPON_TYPE 1 = Percentage
               //COUPON_TYPE 2 = Amount
                if ($coupon_master->COUPON_TYPE == 1) {
                    $coupon_discount = round($total_amount *($coupon_master->DISCOUNT/100));
                   //  $coupon_discount =   $total_amount * ((100-$coupon_master->DISCOUNT) / 100);
                }else{
                    $coupon_discount  = round($coupon_master->DISCOUNT);
                }
            }
            else if($coupon_master->COUPON_ON == 1){
                // foreach($carts as $cart){
                // }
                // $coupon_child = DB::table('SLS_COUPON_CHILD')
                // ->whereIn('F_PRD_VARIANT_NO',$prd_pks)
                // ->where('F_COUPON_NO',$coupon_master->PK_NO)
                // ->where('IS_ACTIVE',1)
                // ->get();
                // foreach ($coupon_child as $key => $value) {
                //     $single_prd = $prd_array[$value->F_PRD_VARIANT_NO];
                //     if ($coupon_master->COUPON_TYPE == 1) {
                //         $regular_coupon_discount += $single_prd[0]*($value->DISCOUNT/100);
                //         $ins_coupon_discount += $single_prd[1]*($value->DISCOUNT/100);
                //     }else{
                //         $regular_coupon_discount += $single_prd[2]*$value->DISCOUNT;
                //         $ins_coupon_discount += $single_prd[2]*$value->DISCOUNT;
                //     }
                // }
            }
            else{}
            session(['coupon_code' => $coupon_code]);
            session(['coupon_discount' => $coupon_discount]);
        }
        return $coupon_discount;
       }
    public function getCouponDiscountByBooking($coupon_code,$branch_id,$booking_pk){
        session()->forget('flat_discount');
        session()->forget('coupon_code');
        session()->forget('coupon_discount');
        $total_amount = 0;
        $coupon_discount = 0;
        //COUPON REASSIGN
        if(isset($coupon_code) && !empty($coupon_code)){
            $carts = $this->getBookingDetails($booking_pk);
            $now = Carbon::now();
            foreach($carts as $cart){
                if(!empty($cart->SPECIAL_PRICE)){
                    $total_amount += $cart->SPECIAL_PRICE;
                }
                else if(!empty($cart->REGULAR_PRICE)){
                    $total_amount += $cart->REGULAR_PRICE;
                }
                else{
                    $total_amount += $cart->REGULAR_PRICE;
                }
            }
            $coupon_master = DB::table('SLS_COUPON_MASTER')->where('COUPON_CODE',$coupon_code)->where('IS_ACTIVE',1)->where('VALIDITY_FROM','<=',$now)->first();
             //Flat amount/percentage from total amount
            if($coupon_master->COUPON_ON == 3){
               //COUPON_TYPE 1 = Percentage
               //COUPON_TYPE 2 = Amount
                if ($coupon_master->COUPON_TYPE == 1) {
                    $coupon_discount = round($total_amount *($coupon_master->DISCOUNT/100));
                   //  $coupon_discount =   $total_amount * ((100-$coupon_master->DISCOUNT) / 100);
                }else{
                    $coupon_discount  = round($coupon_master->DISCOUNT);
                }
            }
            else if($coupon_master->COUPON_ON == 1){

            }
            else{}
            session(['coupon_code' => $coupon_code]);
            session(['coupon_discount' => $coupon_discount]);
        }
        return $coupon_discount;
       }
    public function getCouponDiscountByAmount($coupon_code,$branch_id,$total_amount){
        $coupon_discount = 0;
        //COUPON REASSIGN
        if(isset($coupon_code) && !empty($coupon_code)){
            $now = Carbon::now();
                  $coupon_master = DB::table('SLS_COUPON_MASTER')->where('COUPON_CODE',$coupon_code)->where('IS_ACTIVE',1)->where('VALIDITY_FROM','<=',$now)->first();
             //Flat amount/percentage from total amount
            if($coupon_master->COUPON_ON == 3){
               //COUPON_TYPE 1 = Percentage
               //COUPON_TYPE 2 = Amount
                if ($coupon_master->COUPON_TYPE == 1) {
                    $coupon_discount = round($total_amount *($coupon_master->DISCOUNT/100));
                   //  $coupon_discount =   $total_amount * ((100-$coupon_master->DISCOUNT) / 100);
                }else{
                    $coupon_discount  = round($coupon_master->DISCOUNT);
                }
            }
            else if($coupon_master->COUPON_ON == 1){

            }
            else{}
            session(['coupon_code' => $coupon_code]);
            session(['coupon_discount' => $coupon_discount]);
        }
        return $coupon_discount;
       }

       public function getBookingDetails($booking_pk){

        return DB::table('SLS_BOOKING_DETAILS')->where('F_BOOKING_NO',$booking_pk)->get();
       }



}
