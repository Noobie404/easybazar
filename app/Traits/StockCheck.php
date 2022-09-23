<?php
namespace App\Traits;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

trait StockCheck {


    public function getCart($customer_id,$branch_id){
        $carts = DB::table('WEB_CART as C')
        ->select(
        'C.PK_NO',
        'C.F_CUSTOMER_NO',
        'C.TOTAL_ITEM_QTY',
        'C.F_PRD_VARIANT_NO',
        'PV.VARIANT_NAME',
        'PV.F_SIZE_PARENT_NAME',
        'PV.SIZE_NAME',
        'PV.F_COLOR_PARENT_NAME',
        'PV.COLOR_NAME',
        'PV.REGULAR_PRICE',
        'PV.SPECIAL_PRICE',
        'PV.THUMB_PATH',
        'PV.PRIMARY_IMG_RELATIVE_PATH'
        )
        ->where('C.F_CUSTOMER_NO',$customer_id)
        ->leftJoin('PRD_VARIANT_SETUP as PV','PV.PK_NO','=','C.F_PRD_VARIANT_NO')
        ->orderBy('C.PK_NO','DESC')
        ->get();
        foreach ($carts as $key => $value) {
            $checkStock = $this->checkProductStock($value->F_PRD_VARIANT_NO,$branch_id);
            if($checkStock){
                $value->IN_STOCK = 1;
            }
            else{
                $value->IN_STOCK = 0;
            }
        }
        return $carts;
    }

    public function checkProductStock($product_id,$branch_id)
    {
    $info = DB::table('INV_STOCK')
    ->where('F_PRD_VARIANT_NO', $product_id)
    ->where('F_SHOP_NO',$branch_id)
    ->whereNull('F_BOOKING_NO')
    ->where('BOOKING_STATUS',0)
    ->get();
    if(!empty($info) && count($info) > 0){
        return true;
    }
    return false;
   }

   public function getVariantStaock($product_id,$branch_id){
    $info = DB::table('INV_STOCK')
    ->where('F_PRD_VARIANT_NO', $product_id)
    ->where('F_SHOP_NO',$branch_id)
    ->whereNull('F_BOOKING_NO')
    ->where('BOOKING_STATUS',0)
    ->get();

    return $info->count();

   }



}
