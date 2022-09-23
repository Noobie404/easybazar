<?php
namespace App\Repositories\Admin\Cart;
use DB;
use Session;
use Carbon\Carbon;
use App\Models\Cart;
use App\Traits\MAIL;
use App\Models\Booking;
use App\Traits\StockCheck;
use App\Traits\ApiResponse;
use App\Traits\CouponTrait;
use App\Traits\RepoResponse;

class CartAbstract implements CartInterface
{
    use RepoResponse;
    use MAIL;
    use ApiResponse;
    use StockCheck;
    use CouponTrait;

    protected $booking;
    protected $cart;

    public function __construct(
        Booking $booking,
        Cart $cart
        )
    {
        $this->booking = $booking;
        $this->cart = $cart;
    }

    public function getCartDetails($request){
        $customer_id = $request->customer_id;
        $branch_id = $request->branch_id;
        DB::beginTransaction();
        try {
            $carts = $this->getCart($customer_id,$branch_id);
            $address = DB::table('SLS_CUSTOMERS_ADDRESS')->where('SLS_CUSTOMERS_ADDRESS.F_CUSTOMER_NO',$customer_id)->first();
            $data['address_html'] = view('admin.customer.address._view_ajax')->withRow($address)->render();
            $data['html'] = view('admin.cart._cart_view')->with('carts',$carts)->with('branch_id',$branch_id)->render();
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return $this->successResponse($e->getCode(), 'Order status not updated!', '', 0);
        }
            DB::commit();
            return $this->successResponse(200, 'Order status sucessfully updated!',$data, 1);
    }


    public function addToCart($request)
    {
        $data                       = [];
        $cart_total                 = 0;
        $customer_id                = $request->customer_id;
        $product_id                 = $request->product_id;
        $branch_id                  = $request->branch_id;
        $product                    = DB::table('PRD_VARIANT_SETUP')->select('PK_NO','F_PRD_MASTER_SETUP_NO','INSTALLMENT_PRICE','REGULAR_PRICE','THUMB_PATH','VARIANT_NAME')->where('PK_NO',$request->product_id)->where('IS_ACTIVE',1)->first();
        DB::beginTransaction();
        try {
            if(empty($customer_id)){
                return $this->successResponse(200, 'Please select a customer', '', 0);
            }
            $checkExist = $this->checkCart($product_id,$customer_id);
            $checkStock = $this->checkProductStock($product_id,$branch_id);
            if($checkStock==false){
                return $this->successResponse(200, 'Product out of stock !',null,0);
            }

            if($checkExist==true){
                $msg                        =  'The product is already added to the basket !';
                return $this->successResponse(200, $msg, '', 0);
            }else{
                $cart                       = new Cart();
                $cart->F_PRD_MASTER_SETUP_NO= $product->F_PRD_MASTER_SETUP_NO;
                $cart->F_PRD_VARIANT_NO     = $request->product_id;
                $cart->F_CUSTOMER_NO        = $customer_id;
                $cart->TOTAL_ITEM_QTY       = $request->quantity <= 0 ? 1 : $request->quantity;
                $cart->REGULAR_PRICE        = $product->REGULAR_PRICE;
                $cart->INSTALLMENT_PRICE    = $product->INSTALLMENT_PRICE;
                $cart->F_SHOP_NO            = $request->warehouse;
                $cart->IS_BOOKING           = 0;
                $cart->save();
                if($cart){
                    $carts = $this->getCart($customer_id,$branch_id);
                $data['html'] = view('admin.cart._cart_view')->with('carts',$carts)->with('branch_id',$branch_id)->render();
                }
                $msg  = 'The product successfully added your cart !';
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return $this->successResponse($e->getCode(), $e->getMessage(), '', 0);
        }
        DB::commit();
        return $this->successResponse(200, $msg,$data, 1);
    }

    public function removeCart($request)
    {
        $data               = [];
        $customer_id = $request->customer_id;
        $cart_id = $request->cart_id;
        $branch_id = $request->branch_id;
        DB::begintransaction();
        try {
            $cart = DB::table('WEB_CART')->where('PK_NO',$cart_id)->delete();
            if($cart){
                $carts = $this->getCart($customer_id,$branch_id);

            $data['html'] = view('admin.cart._cart_view')->with('carts',$carts)->with('branch_id',$branch_id)->render();
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return $this->successResponse(200, 'Unable to delete the product from cart !', '', 0);
            // return $this->formatResponse(false, 'Unable to delete the product from cart !', '');
        }
        DB::commit();
        return $this->successResponse(200, 'The product successfully removed from cart !',$data,1);
    }

    public function updateCartQty($request){
        $cart_id        = $request->cart_id;
        $type           = $request->type;
        $customer_id    = $request->customer_id;
        $branch_id      = $request->branch_id;
        $data = [];
        $regular_price      = 0;
        $data               = [];
        $prd_array          = [];
        $prd_pks            = [];
        $postage            = 0;
        $msg            = '';
        DB::begintransaction();
        try {
            $cart = $this->cart->where('PK_NO',$cart_id)->where('IS_BOOKING',0)->first();
            $product = DB::table('PRD_VARIANT_SETUP as PV')
            ->select('PV.PK_NO','PV.MAX_ORDER','PS.TOTAL_FREE_STOCK','PS.F_SHOP_NO')
            ->leftJoin('PRD_VARIANT_STOCK_QTY as PS','PS.F_PRD_VARIANT_NO','=','PV.PK_NO')
            ->where('PV.PK_NO',$cart->F_PRD_VARIANT_NO)
            ->where('PS.F_SHOP_NO',$branch_id)
            ->first();
            if (isset($cart) && !empty($cart)) {
                if ($request->type == 'minus') { //ITEM QTY DECRESAE
                    $qty = $cart->TOTAL_ITEM_QTY - 1;
                }elseif ($request->type == 'plus') {  //ITEM QTY INCREASE
                    $checkStock = $this->checkProductStock($product->PK_NO,$branch_id);
                    if($checkStock==false){
                        return $this->successResponse(200, 'Your desired quantity is not available for this product !',null,0);
                        // return $this->successResponse(200, 'Product out of stock !',null,0);
                    }
                    if($cart->TOTAL_ITEM_QTY >= $product->MAX_ORDER || $cart->TOTAL_ITEM_QTY >= $product->TOTAL_FREE_STOCK){
                    return $this->successResponse(200, 'Your desired quantity is not available for this product !',null,0);
                    }
                    $qty = $cart->TOTAL_ITEM_QTY + 1;
                    $qty = $qty <= 0 ? 1 : $qty;
                }else{  // ITEM REMOVE FROM CART
                    $qty = 0;
                }
            }else{
                return $this->successResponse(200, 'Unable to update product quantity !',null,0);
            }
            if ($qty > 0) {
                $cart->TOTAL_ITEM_QTY = $qty;
                $cart->update();
                $msg = "Porduct quantity updated !";
            }else{
                 $cart->delete();
                $msg = "Product removed from cart !";
            }

            $carts = $this->getCart($customer_id,$branch_id);
            $data['html'] = view('admin.cart._cart_view')->with('carts',$carts)->with('branch_id',$branch_id)->render();

        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return $this->successResponse(200, 'Unable to update product quantity !',null,0);
        }
        DB::commit();

        return $this->successResponse(200, $msg,$data,1);
    }


    public function checkCart($product_id,$customer_id){
        $customer_id    = $customer_id;
        $checkExist     = DB::table('WEB_CART')->where('F_PRD_VARIANT_NO',$product_id)->where('IS_BOOKING',0)->where('WEB_CART.F_CUSTOMER_NO',$customer_id)->first();
        if($checkExist){
            return true;
        }
        else{
            return false;
        }
    }




   public function postFlatDiscount($request){
        $flat_discount  = $request->flat_discount;
        $customer_id    = $request->customer_id;
        $branch_id      = $request->branch_id;
    try {
        // Session::set('flat_discount', $flat_discount);
        session(['flat_discount' => $flat_discount]);

        $carts = $this->getCart($customer_id,$branch_id);
        $data['html'] = view('admin.cart._cart_view')->with('carts',$carts)->with('branch_id',$branch_id)->render();
    } catch (\Exception $e) {
        dd($e->getMessage());
        return $this->successResponse(200, 'Unable to flat discount !',null,0);
    }
    return $this->successResponse(200, 'set flat discount',$data,1);
   }


   public function postCouponDiscount($request){
        $coupon_code    = $request->coupon_code;
        $customer_id    = $request->customer_id;
        $branch_id      = $request->branch_id;
    try {
        $now = Carbon::now();
        $coupon_master = DB::table('SLS_COUPON_MASTER')->where('COUPON_CODE',$coupon_code)->where('IS_ACTIVE',1)->where('VALIDITY_FROM','<=',$now)->first();
        if (!isset($coupon_master) || empty($coupon_master)) {
            return $this->successResponse(200, 'Invalid coupon !',null,0);
        }
        if ($coupon_master->VALIDITY_TO < $now) {
            return $this->successResponse(200, 'Coupon expired !',null,0);
        }
        if(isset($coupon_code) && !empty($coupon_code)){
           $coupon_discount = $this->getCouponDiscount($coupon_code,$branch_id,$customer_id);
           session(['coupon_code' => $coupon_code]);
           session(['coupon_discount' => $coupon_discount]);
        }
        $carts = $this->getCart($customer_id,$branch_id);
        $data['html'] = view('admin.cart._cart_view')->with('carts',$carts)
        ->with('coupon_discount',$coupon_discount)
        ->with('branch_id',$branch_id)
        ->render();
    } catch (\Exception $e) {
        dd($e->getMessage());
        return $this->successResponse(200, 'Unable to flat discount !',null,0);
    }
    return $this->successResponse(200, 'set coupon discount',$data,1);
   }

   public function getRemoveCoupon($request){
        $data = [];
        $coupon_code    = $request->coupon_code;
        $customer_id    = $request->customer_id;
        $branch_id      = $request->branch_id;
        $booking_id     = $request->booking_id;
    try {
        $booking = DB::table('SLS_BOOKING')->where('PK_NO',$booking_id)->where('F_CUSTOMER_NO',$customer_id)->first();
        if(!empty($booking)){
            session()->forget('coupon_code');
            $total_price = $booking->TOTAL_PRICE;
            $without_coupon = $total_price - $booking->COUPON_DISCOUNT;
            // dd($without_coupon);
            // DB::table('SLS_BOOKING')->where('PK_NO',$booking_id)->where('F_CUSTOMER_NO',$customer_id)->update([
            //     'COUPON_CODE' =>NULL,
            //     'COUPON_DISCOUNT' => 0,
            //     'TOTAL_PRICE' => $without_coupon
            //  ]);
            // DB::statement('CALL PROC_CUSTOMER_BOOKING(:booking_pk,:postage_cost,:coupon_discount,:flat_discount);',array( $booking_pk, $postage_cost,$coupon_discount,$flat_discount));
        }
        else{
            return $this->successResponse(200, 'Unable to remove !',null,0);
        }
    } catch (\Exception $e) {
        dd($e->getMessage());
        return $this->successResponse(200, 'Unable to flat discount !',null,0);
    }
    return $this->successResponse(200, 'Coupon successfully removed',$data,1);
   }





}
