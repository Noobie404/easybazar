<?php
namespace App\Repositories\Admin\Booking;
use DB;
use App\User;
use Carbon\Carbon;
use App\Traits\MAIL;
use App\Models\Stock;
use App\Models\Booking;
use App\Models\SubArea;
use App\Models\Customer;
use App\Traits\StockCheck;
use App\Traits\ApiResponse;
use App\Traits\CouponTrait;
use App\Traits\Notification;
use App\Traits\RepoResponse;
use App\Models\BookingDetails;
use App\Models\ProductVariant;
use App\Models\CustomerAddress;
use App\Models\PaymentCustomer;
use App\Models\DispatchItemReturn;
use Illuminate\Support\Facades\Auth;

class BookingAbstract implements BookingInterface
{
    use RepoResponse;
    use MAIL;
    use ApiResponse;
    use StockCheck;
    use CouponTrait;
    use Notification;


    protected $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
        $this->server_key = env('FIREBASE_AUTH_KEY');
    }

    public function getPaginatedList($request, $id = null)
    {
        $data = $this->booking->where('F_CUSTOMER_NO', $id)->orderBy('PK_NO','DESC')->paginate(20);
        return $this->formatResponse(true, '', 'admin.booking.list', $data);
    }

    public function getCusInfo($table,$customer)
    {
        $customer_info['info'] = DB::table($table)->where('PK_NO', $customer)->first();
        $customer_info['delivery_address']  = CustomerAddress::where('F_CUSTOMER_NO',$customer)->where('IS_DEFAULT',1)->first();
        return $customer_info;
    }

    public function getProductINV($ig_code,$branch_id,$f_booking_no=null,$price_type=null)
    {
        $data['is_stock_out'] = 0;
        $stock = null;
        $stock =  ProductVariant::select('PRD_VARIANT_SETUP.PK_NO as VARIANT_PK_NO','PRD_VARIANT_SETUP.*','PRD_VARIANT_STOCK_QTY.TOTAL_FREE_STOCK')
        ->where('PRD_VARIANT_SETUP.MRK_ID_COMPOSITE_CODE',$ig_code)
        ->leftJoin('PRD_VARIANT_STOCK_QTY', function($join) use ($branch_id)
        {
            $join->on('PRD_VARIANT_STOCK_QTY.F_PRD_VARIANT_NO', '=', 'PRD_VARIANT_SETUP.PK_NO');
            $join->on('PRD_VARIANT_STOCK_QTY.F_SHOP_NO', '=', DB::raw("'$branch_id'"));
        })
        ->first();
        if ($stock != null ) {
            return $this->generateInputField($stock, $f_booking_no);
        }else{
            $data['is_stock_out'] = 1;
        }
        return $data;
    }

    private function generateInputField($item, $book_qty = 0){
        return view('admin.booking._variant_tr')->withItem($item)->withBookqty($book_qty)->render();
    }

    public function findOrThrowException($PK_NO, $for=null)
    {
        $now = Carbon::now();
        $data       = array();
        $booking    = $this->booking->find($PK_NO);
        $branch_id = $booking->F_SHOP_NO;
        $booking_details = BookingDetails::select(
        'SLS_BOOKING_DETAILS.*',
        'PRD_VARIANT_SETUP.VARIANT_NAME','SLS_BOOKING_DETAILS.F_PRD_VARIANT_NO as VARIANT_PK_NO',
        'PRD_VARIANT_SETUP.VARIANT_NAME','PRD_VARIANT_SETUP.MRK_ID_COMPOSITE_CODE',
        'PRD_VARIANT_STOCK_QTY.TOTAL_FREE_STOCK',
        'PRD_VARIANT_SETUP.THUMB_PATH','PRD_VARIANT_SETUP.F_SIZE_PARENT_NAME'
        ,'PRD_VARIANT_SETUP.SIZE_NAME'
        )
        ->leftJoin('PRD_VARIANT_SETUP','PRD_VARIANT_SETUP.PK_NO','SLS_BOOKING_DETAILS.F_PRD_VARIANT_NO')

        ->leftJoin('PRD_VARIANT_STOCK_QTY', function($join) use ($branch_id)
        {
            $join->on('PRD_VARIANT_STOCK_QTY.F_PRD_VARIANT_NO', '=', 'SLS_BOOKING_DETAILS.F_PRD_VARIANT_NO');
            $join->on('PRD_VARIANT_STOCK_QTY.F_SHOP_NO', '=', DB::raw("'$branch_id'"));

        })
        ->where('SLS_BOOKING_DETAILS.F_BOOKING_NO', $PK_NO)
        ->get();
        $shop_state = DB::table('SS_SHOP_AREA_COVERAGE')->where('F_SHOP_NO',$booking->F_SHOP_NO)->groupBy('F_STATE_NO')->pluck('STATE_NAME','STATE_NAME');
        $shop_city = DB::table('SS_SHOP_AREA_COVERAGE')->where('F_SHOP_NO',$booking->F_SHOP_NO)->groupBy('F_CITY_NO')->pluck('CITY_NAME','CITY_NAME');
        $shop_area = DB::table('SS_SHOP_AREA_COVERAGE')->where('F_SHOP_NO',$booking->F_SHOP_NO)->groupBy('F_AREA_NO')->pluck('AREA_NAME','AREA_NAME');
        $shop_sub_area = DB::table('SS_SHOP_AREA_COVERAGE')->where('F_SHOP_NO',$booking->F_SHOP_NO)->groupBy('F_SUB_AREA_NO')->pluck('SUB_AREA_NAME','SUB_AREA_NAME');
        $sub_area = DB::table('SS_SHOP_AREA_COVERAGE')->where('F_SHOP_NO',$booking->F_SHOP_NO)->groupBy('F_SUB_AREA_NO')->pluck('F_SUB_AREA_NO')->implode(',');
        $delivery_boy = DB::table('SS_DELIVERYBOY_AREA_COVERAGE')
        ->whereIn('F_SUB_AREA_NO',[$sub_area])
        ->groupBy('F_USER_NO')->get()->pluck('USER_NAME','F_USER_NO');
        $delivery_booking = DB::table('SLS_DELIVERY_HISTORY')->where('F_BOOKING_NO',$PK_NO)->where('IS_ACTIVE',1)->first();
        // dd($delivery_booking);
        $data['booking_details'] = $booking_details;
        $data['booking'] = $booking;
        $data['shop_state'] = $shop_state;
        $data['shop_city'] = $shop_city;
        $data['shop_area'] = $shop_area;
        $data['shop_sub_area'] = $shop_sub_area;
        $data['delivery_boy'] = $delivery_boy;
        $data['delivery_booking'] = $delivery_booking ? $delivery_booking->F_DELIVERY_BOY_NO : null;
        $coupon_code = $booking->COUPON_CODE;
        if(isset($coupon_code) && !empty($coupon_code)){
                $coupon_master = DB::table('SLS_COUPON_MASTER')->where('COUPON_CODE',$coupon_code)->where('IS_ACTIVE',1)->where('VALIDITY_FROM','<=',$now)->first();
                if (isset($coupon_master) || !empty($coupon_master)) {
                    $booking->COUPON_VALID = true;
                }
                else{
                    $booking->COUPON_VALID = false;
                }
                if ($coupon_master->VALIDITY_TO < $now) {
                    $booking->COUPON_EXPIRED = true;
                }else{
                    $booking->COUPON_EXPIRED = false;
                }
            $data['coupon_discount']= $this->getCouponDiscountByBooking($coupon_code,$branch_id,$booking->PK_NO);
        }
        return $this->formatResponse(true, 'Data found successfully !', 'admin.booking.list', $data);
    }

    public function postStore($request, $PK_NO, $type = null)
    {
        $auth_id = AUth::id();
        DB::beginTransaction();
        try {
            $response_status    = false;
            $response_msg       = 'Order unsuccessfull !';
            $response_route     = 'admin.booking.list';
            $response_data      = null;
            $booking_type = 'production';
            $shop = User::find($request->shop_id);
            $dalivery_date      = $request->delivery_date;
            $dalivery_slot      = $request->delivery_time;
            $slot = DB::table('SLS_DELIVERY_SCHEDULE')->where('PK_NO',$dalivery_slot)->first();
            // $cust       = Customer::find($request->customer_id);
            $subarea   = SubArea::where('PK_NO',$request->sub_area)->first();
            if($request->f_delivery_address == null){
                $customer_address                           = new CustomerAddress();
                $customer_address->NAME                     = $request->full_name;
                $customer_address->MOBILE_NO                = $request->mobile_no;
                $customer_address->ADDRESS_LINE_1           = $request->address;
                $customer_address->F_COUNTRY_NO             = 1;
                $customer_address->F_STATE_NO               = $subarea->F_STATE_NO;
                $customer_address->STATE_NAME               = $subarea->STATE_NAME;
                $customer_address->F_CITY_NO                = $subarea->F_CITY_NO;
                $customer_address->CITY_NAME                = $subarea->CITY_NAME;
                $customer_address->F_AREA_NO                = $subarea->F_AREA_NO;
                $customer_address->AREA_NAME                = $subarea->AREA_NAME;
                $customer_address->F_SUBAREA_NO             = $subarea->PK_NO;
                $customer_address->SUB_AREA_NAME            = $subarea->SUB_AREA_NAME;
                $customer_address->POST_CODE                = 1;
                $customer_address->IS_ACTIVE                = 1;
                $customer_address->IS_DEFAULT               = 1;
                $customer_address->save();
                $f_delivery_address = $customer_address->PK_NO;
            }else{
                $customer_address = CustomerAddress::where('F_CUSTOMER_NO',$request->customer_id)->where('IS_DEFAULT',1)->first();
                $f_delivery_address = $request->f_delivery_address;
            }
            $booking = new Booking();
            if(!empty($slot)){
                $booking->DELIVERY_SLOT = $slot->SLOT_TITLE;
                $booking->DELIVERY_DATE = $dalivery_date;
            }
            $booking->BOOKING_TIME              = date('Y-m-d h:i:s');
            $booking->REQUEST_FOR               = 'ADMIN';
            $booking->F_SHOP_NO                 = $request->shop_id;
            $booking->SHOP_NAME                 = $shop->SHOP_NAME;
            $booking->BOOKING_STATUS            = 10;
            $booking->BOOKING_NOTES             = $request->booking_note ?? null;
            $booking->F_CUSTOMER_NO             = $request->customer_id;
            $booking->CUSTOMER_NAME             = $request->full_name;
            $booking->TOTAL_ITEM_QTY            = $request->total_booking_qty;
            $booking->POSTAGE_COST              = $request->total_delivery_cost;
            $booking->SUB_TOTAL                 = $request->total_product_price;
            $booking->DISCOUNT                  = $request->total_discount ?? 0;
            $booking->F_DELIVERY_ADDRESS        = $f_delivery_address;
            $booking->DELIVERY_NAME             = $customer_address->NAME;
            $booking->DELIVERY_MOBILE           = $customer_address->MOBILE_NO;
            $booking->DELIVERY_ADDRESS_LINE_1   = $customer_address->ADDRESS_LINE_1;
            $booking->DELIVERY_CITY             = $customer_address->CITY_NAME;
            $booking->DELIVERY_POSTCODE         = null;
            $booking->PAYMENT_METHOD            = 'cod';
            $booking->DELIVERY_STATE            = $customer_address->STATE_NAME;
            $booking->DELIVERY_AREA_NAME        = $customer_address->AREA_NAME;
            $booking->DELIVERY_SUB_AREA_NAME    = $customer_address->SUB_AREA_NAME;
            $booking->TOTAL_PRICE               = $request->grand_total;
            $booking->save();
            foreach($request->products as $k => $prod){
                $variant = ProductVariant::find($prod);
                $unit_price = $variant->REGULAR_PRICE;
                if($variant->SPECIAL_PRICE < $variant->REGULAR_PRICE){
                    $unit_price = $variant->SPECIAL_PRICE;
                }
                $qty                    = $request->booking_qty[$k];
                $item                   =  new BookingDetails();
                $item->F_BOOKING_NO     = $booking->PK_NO;
                $item->F_PRD_VARIANT_NO = $prod;
                $item->DISPATCH_STATUS  = 0;
                $item->REGULAR_PRICE    = $variant->REGULAR_PRICE;
                $item->SPECIAL_PRICE    = $variant->SPECIAL_PRICE;
                $item->WHOLESALE_PRICE  = $variant->WHOLESALE_PRICE;
                $item->INSTALLMENT_PRICE = $variant->INSTALLMENT_PRICE;
                $item->PRICE_USED       = $request->price_used[$k];
                $item->BOOKING_STATUS   = 10;
                $item->ARRIVAL_NOTIFICATION_FLAG = 0;
                $item->DISPATCH_NOTIFICATION_FLAG = 0;
                $item->COMISSION        = 0;
                $item->LINE_PRICE       = $qty*$unit_price;
                $item->LINE_QTY         = $qty;
                $item->F_SHOP_NO        = $request->shop_id;
                $item->COMMENTS         = '';
                $item->IS_ADMIN_APPROVAL = 1;
                $item->IS_SELF_PICKUP   = 0;
                $item->IS_ACTIVE        = 1;
                $item->IS_ADMIN_HOLD    = 0;
                $item->IS_SYSTEM_HOLD   = 0;
                $item->F_SS_CREATED_BY  = $auth_id;
                $item->save();
                $stcok = Stock::where('F_PRD_VARIANT_NO',$variant->PK_NO)
                ->where('F_SHOP_NO',$request->shop_id)
                ->where('IS_FAULTY',0)
                ->whereNull('F_BOOKING_NO')
                ->limit($qty)
                ->update([
                    'F_BOOKING_NO' => $booking->PK_NO ,
                    'F_BOOKING_DETAILS_NO' => $item->PK_NO,
                    'BOOKING_STATUS' => 10,
                    'PRODUCT_STATUS' => null,
                    'F_SS_MODIFIED_BY' => $auth_id
                ]);
            }
            $response_status = true;
            $response_msg = 'Order successfull';
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return $this->formatResponse(false, $e->getMessage(), 'admin.booking.list');
        }
        DB::commit();
        return $this->formatResponse($response_status, $response_msg, $response_route);
    }


    public function postUpdate($request,$PK_NO)
    {
        $data               = [];
        $coupon_code        = $request->_coupon_code;
        $booking_note       = $request->booking_note;
        $booking_status     = $request->booking_status;
        $dalivery_date      = $request->delivery_date;
        $dalivery_slot      = $request->delivery_time;
        $now                = Carbon::now();
        $branch_id          = $request->branch_id;
        $customer_id        = $request->customer_id;
        $shipping           = $request->shipping;
        $flat_discount      = $request->flat_discount ?? 0;
        $coupon_discount = 0;
        $auth_id = AUth::id();
        $booking_type = 'production';
        DB::beginTransaction();
        try {
            $slot = DB::table('SLS_DELIVERY_SCHEDULE')->where('PK_NO',$dalivery_slot)->first();
            $booking = Booking::find($PK_NO);
            if($booking->BOOKING_STATUS > 70){
                return $this->successResponse(200, 'Order not editable !',null,0);
            }

            $booking->BOOKING_NOTES             = $request->booking_note ?? null;
            if(!empty($slot)){
                $booking->DELIVERY_SLOT         = $slot->SLOT_TITLE;
                $booking->DELIVERY_DATE         = $dalivery_date;
            }
            if($coupon_code){
                $booking->COUPON_CODE           = $coupon_code ?? NULL;
                $booking->COUPON_DISCOUNT       = $coupon_discount ?? 0;
            }
            $booking->BOOKING_STATUS            = $request->booking_status;
            $booking->update();
            DB::table('SLS_BOOKING_DETAILS')->where('F_BOOKING_NO',$PK_NO)->delete();
            foreach($request->products as $k => $prod){
                $variant = ProductVariant::find($prod);
                $unit_price = $variant->REGULAR_PRICE;
                if($variant->SPECIAL_PRICE < $variant->REGULAR_PRICE){
                    $unit_price = $variant->SPECIAL_PRICE;
                }
                $qty = $request->booking_qty[$k];
                 Stock::where('F_SHOP_NO',$branch_id)
                    ->where('F_BOOKING_NO',$booking->PK_NO)
                    // ->limit($qty)
                    ->update([
                        'F_BOOKING_NO' => null,
                        'F_BOOKING_DETAILS_NO' => null,
                        'BOOKING_STATUS' => null,
                        'PRODUCT_STATUS' => null,
                        'F_SS_MODIFIED_BY' => $auth_id
                    ]);
                      //newly insert booking_details & update inv_stocks
                    $booking_details                   =  new BookingDetails();
                    $booking_details->F_BOOKING_NO     = $booking->PK_NO;
                    $booking_details->F_PRD_VARIANT_NO = $prod;
                    $booking_details->DISPATCH_STATUS  = 0;
                    $booking_details->REGULAR_PRICE    = $variant->REGULAR_PRICE;
                    $booking_details->SPECIAL_PRICE    = $variant->SPECIAL_PRICE;
                    $booking_details->WHOLESALE_PRICE  = $variant->WHOLESALE_PRICE;
                    $booking_details->INSTALLMENT_PRICE = $variant->INSTALLMENT_PRICE;
                    $booking_details->PRICE_USED       = $request->price_used[$k];
                    $booking_details->BOOKING_STATUS   = 50;
                    $booking_details->ARRIVAL_NOTIFICATION_FLAG = 0;
                    $booking_details->DISPATCH_NOTIFICATION_FLAG = 0;
                    $booking_details->COMISSION        = 0;
                    $booking_details->LINE_PRICE       = $qty*$unit_price;
                    $booking_details->LINE_QTY         = $qty;
                    $booking_details->F_SHOP_NO        = $request->shop_id;
                    $booking_details->COMMENTS         = '';
                    $booking_details->IS_ADMIN_APPROVAL = 1;
                    $booking_details->IS_SELF_PICKUP   = 0;
                    $booking_details->IS_ACTIVE        = 1;
                    $booking_details->IS_ADMIN_HOLD    = 0;
                    $booking_details->IS_SYSTEM_HOLD   = 0;
                    $booking_details->F_SS_CREATED_BY  = $auth_id;
                    $booking_details->save();
                    $checkStock = DB::table('INV_STOCK')
                    ->select('PK_NO','F_PRD_VARIANT_NO','F_SHOP_NO')
                    ->where('F_PRD_VARIANT_NO',$booking_details->F_PRD_VARIANT_NO)
                    ->where('IS_FAULTY',0)
                    ->where('F_SHOP_NO',$branch_id)
                    ->orderBy('PK_NO','ASC')
                    ->take($booking_details->LINE_QTY)
                    ->get();
                    if(!empty($checkStock) && count($checkStock) > 0){
                        foreach($checkStock as $stock){
                            DB::table('INV_STOCK')->where('PK_NO',$stock->PK_NO)->update(
                                    [
                                        'F_BOOKING_NO' => $booking->PK_NO,
                                        'BOOKING_STATUS' => 50,
                                        'F_BOOKING_DETAILS_NO'=>$booking_details->PK_NO,
                                        'F_SS_MODIFIED_BY' => $auth_id
                                    ]
                            );
                        }
                    }

                $delivery_boy_id = $request->delivery_boy_id;
                $check =  DB::table('SLS_DELIVERY_HISTORY')->where('F_BOOKING_NO',$PK_NO)->where('IS_ACTIVE',1)->first();
                if($delivery_boy_id){
                    if($check){
                        if($delivery_boy_id != $check->F_DELIVERY_BOY_NO){
                            //change deliveryboy
                            DB::table('SLS_DELIVERY_HISTORY')->where('F_BOOKING_NO',$PK_NO)->update(['IS_ACTIVE' => 0]);
                            DB::table('SLS_DELIVERY_HISTORY')->insert([
                                'F_BOOKING_NO' => $PK_NO,
                                'F_DELIVERY_BOY_NO' => $delivery_boy_id,
                                'PAYMENT_TYPE' => $booking->PAYMENT_METHOD,
                                'PAYMENT_AMOUNT' => 0,
                                'DELIVERY_STATUS' => 0,
                                'DELIVERED_AT' => null,
                                'F_SS_CREATED_BY' => Auth::id(),
                                'SS_CREATED_ON' => date('Y-m-d H:i:s'),
                                'IS_ACTIVE' => 1,
                            ]);
                        }
                    }else{
                        //assigned deliveryboy
                        DB::table('SLS_DELIVERY_HISTORY')->insert([
                            'F_BOOKING_NO' => $PK_NO,
                            'F_DELIVERY_BOY_NO' => $delivery_boy_id,
                            'PAYMENT_TYPE' => $booking->PAYMENT_METHOD,
                            'PAYMENT_AMOUNT' => 0,
                            'DELIVERY_STATUS' => 0,
                            'DELIVERED_AT' => null,
                            'F_SS_CREATED_BY' => Auth::id(),
                            'SS_CREATED_ON' => date('Y-m-d H:i:s'),
                            'IS_ACTIVE' => 1,
                        ]);
                    }
                }
            }
            //  FOR COUPON
            if(isset($coupon_code) && !empty($coupon_code)){
                $coupon_master = DB::table('SLS_COUPON_MASTER')->where('COUPON_CODE',$coupon_code)->where('IS_ACTIVE',1)->where('VALIDITY_FROM','<=',$now)->first();
                if (!isset($coupon_master) || empty($coupon_master)) {
                    return $this->successResponse(200, 'Invalid coupon !',null,0);
                }
                if ($coupon_master->VALIDITY_TO < $now) {
                    return $this->successResponse(200, 'Coupon expired !',null,0);
                }
            }
            $rows = DB::table('SLS_BOOKING_DETAILS')->where('F_BOOKING_NO',$booking->PK_NO)
            ->select('F_SHOP_NO',DB::raw('SUM(IFNULL(LINE_PRICE,0)) as LINE_PRICE,SUM(COUPON_DISCOUNT) as COUPON_DISCOUNT'))->first();
            $subtotal = $rows->LINE_PRICE;
            $postage_cost           = getOrderDeliveryCost($subtotal,$branch_id);
            $booking_pk = $booking->PK_NO;
            $coupon_discount        = $this->getCouponDiscountByBooking($coupon_code,$branch_id,$booking_pk);
                DB::statement('CALL PROC_CUSTOMER_BOOKING(:booking_pk,:postage_cost,:coupon_discount,:flat_discount);',array( $booking_pk, $postage_cost,$coupon_discount,$flat_discount));
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return $this->successResponse(200, 'Order not updated!',$data, 0);
        }
        DB::commit();
        return $this->successResponse(200, 'Order sucessfully updated!',$data, 1);
     }


    public function postCartStoreAjax($request)
    {
        $now                = Carbon::now();
        $branch_id          = $request->branch_id;
        $customer_id        = $request->customer_id;
        $dalivery_date      = $request->delivery_date;
        $dalivery_slot      = $request->delivery_time;
        $shipping           = $request->shipping;
        $flat_discount      = $request->flat_discount ?? 0;
        $coupon_discount    = 0;
        $coupon_code        = $request->coupon_code;
        $response_status    = false;
        $response_msg       = 'Order unsuccessfull !';
        $response_data      = null;
        $booking_type       = 'production';
        $pro_coupon_discount = 0;
        $total_qty          = 0;
       DB::beginTransaction();
        try {
            $shop = User::where('SHOP_ID',$branch_id)->first();
            $slot = DB::table('SLS_DELIVERY_SCHEDULE')->where('PK_NO',$dalivery_slot)->first();
            $customer_address = CustomerAddress::where('F_CUSTOMER_NO',$request->customer_id)->where('IS_DEFAULT',1)->first();
            $customer = Customer::where('PK_NO',$request->customer_id)->first();
            if(empty($customer_address)){
                return $this->successResponse(200, 'Please add customer shipping address', '', 0);
            }
            if(isset($coupon_code) && !empty($coupon_code)){
                $coupon_master = DB::table('SLS_COUPON_MASTER')->where('COUPON_CODE',$coupon_code)->where('IS_ACTIVE',1)->where('VALIDITY_FROM','<=',$now)->first();
                if (!isset($coupon_master) || empty($coupon_master)) {
                    return $this->successResponse(200, 'Invalid coupon !',null,0);
                }
                if ($coupon_master->VALIDITY_TO < $now) {
                    return $this->successResponse(200, 'Coupon expired !',null,0);
                }
            }
            $booking = new Booking();
            if(!empty($slot)){
                $booking->DELIVERY_SLOT = $slot->SLOT_TITLE;
                $booking->DELIVERY_DATE = $dalivery_date;
            }
            $booking->BOOKING_TIME              = date('Y-m-d h:i:s');
            $booking->REQUEST_FOR               = 'ADMIN';
            $booking->F_SHOP_NO                 = $branch_id;
            $booking->SHOP_NAME                 = $shop->SHOP_NAME;
            $booking->BOOKING_STATUS            = 50;
            $booking->BOOKING_NOTES             = $request->booking_note ?? null;
            $booking->F_CUSTOMER_NO             = $customer_id;
            $booking->CUSTOMER_NAME             = $customer->NAME;
            $booking->TOTAL_ITEM_QTY            = 0;
            $booking->POSTAGE_COST              = 0;
            $booking->SUB_TOTAL                 = 0;
            $booking->TOTAL_PRICE               = 0;
            $booking->DISCOUNT                  = 0;
            if($coupon_code){
                $booking->COUPON_CODE           = $coupon_code ?? NULL;
                $booking->COUPON_DISCOUNT       = $coupon_discount ?? 0;
            }
            $booking->F_DELIVERY_ADDRESS        = $customer_address->PK_NO;
            $booking->DELIVERY_NAME             = $customer_address->NAME;
            $booking->DELIVERY_MOBILE           = $customer_address->MOBILE_NO;
            $booking->DELIVERY_ADDRESS_LINE_1   = $customer_address->ADDRESS_LINE_1;
            $booking->DELIVERY_CITY             = $customer_address->CITY_NAME;
            $booking->DELIVERY_POSTCODE         = null;
            $booking->PAYMENT_METHOD            = 'cod';
            $booking->DELIVERY_STATE            = $customer_address->STATE_NAME;
            $booking->DELIVERY_AREA_NAME        = $customer_address->AREA_NAME;
            $booking->DELIVERY_SUB_AREA_NAME    = $customer_address->SUB_AREA_NAME;
            $booking->save();
            $carts = $this->getCart($customer_id,$branch_id);
            foreach($carts as $k => $cart){
                if(!empty($cart->SPECIAL_PRICE)){
                    $line_total = $cart->SPECIAL_PRICE * $cart->TOTAL_ITEM_QTY;
                    $price_used = 'SPECIAL_PRICE';
                }
                else{
                    $line_total = $cart->REGULAR_PRICE * $cart->TOTAL_ITEM_QTY;
                    $price_used = 'REGULAR_PRICE';
                }
                $variant = ProductVariant::find($cart->F_PRD_VARIANT_NO);
                $unit_price = $variant->REGULAR_PRICE;
                if($variant->SPECIAL_PRICE < $variant->REGULAR_PRICE){
                    $unit_price = $variant->SPECIAL_PRICE;
                }
                $qty                               = $cart->TOTAL_ITEM_QTY;
                $booking_details                   =  new BookingDetails();
                $booking_details->F_BOOKING_NO     = $booking->PK_NO;
                $booking_details->F_PRD_VARIANT_NO = $cart->F_PRD_VARIANT_NO;
                $booking_details->DISPATCH_STATUS  = 0;
                $booking_details->REGULAR_PRICE    = $variant->REGULAR_PRICE;
                $booking_details->SPECIAL_PRICE    = $variant->SPECIAL_PRICE;
                $booking_details->WHOLESALE_PRICE  = $variant->WHOLESALE_PRICE;
                $booking_details->INSTALLMENT_PRICE = $variant->INSTALLMENT_PRICE;
                $booking_details->PRICE_USED       = $price_used;
                $booking_details->BOOKING_STATUS   = 50;
                $booking_details->ARRIVAL_NOTIFICATION_FLAG = 0;
                $booking_details->DISPATCH_NOTIFICATION_FLAG = 0;
                $booking_details->COMISSION        = 0;
                $booking_details->LINE_PRICE       = $line_total;
                $booking_details->LINE_QTY         = $qty;
                $booking_details->F_SHOP_NO        = $branch_id;
                $booking_details->COMMENTS         = NULL;
                $booking_details->COUPON_DISCOUNT  = 0;
                $booking_details->IS_ADMIN_APPROVAL= 1;
                $booking_details->IS_SELF_PICKUP   = 0;
                $booking_details->IS_ACTIVE        = 1;
                $booking_details->IS_ADMIN_HOLD    = 0;
                $booking_details->IS_SYSTEM_HOLD   = 0;
                $booking_details->F_SS_CREATED_BY  = Auth::user()->PK_NO;
                $booking_details->save();
                $checkStock = DB::table('INV_STOCK')
                ->select('PK_NO','F_PRD_VARIANT_NO','F_SHOP_NO')
                ->where('F_PRD_VARIANT_NO',$cart->F_PRD_VARIANT_NO)
                ->where('IS_FAULTY',0)
                ->where('F_SHOP_NO',$branch_id)
                ->orderBy('PK_NO','ASC')
                ->take($cart->TOTAL_ITEM_QTY)
                ->get();
                if(!empty($checkStock) && count($checkStock) > 0){
                    foreach($checkStock as $stock){
                        DB::table('INV_STOCK')->where('PK_NO',$stock->PK_NO)->update(
                                [
                                    'F_BOOKING_NO' => $booking->PK_NO,
                                    'BOOKING_STATUS' => 10,
                                    'F_BOOKING_DETAILS_NO'=>$booking_details->PK_NO,
                                ]
                        );
                    }
                }
                DB::table('WEB_CART')->where('PK_NO',$cart->PK_NO)->where('F_CUSTOMER_NO',$customer_id)->delete();
             }
            //  FOR COUPON
                $rows = DB::table('SLS_BOOKING_DETAILS')->where('F_BOOKING_NO',$booking->PK_NO)
                ->select('F_SHOP_NO',DB::raw('SUM(IFNULL(LINE_PRICE,0)) as LINE_PRICE,SUM(COUPON_DISCOUNT) as COUPON_DISCOUNT'))->first();
                $subtotal = $rows->LINE_PRICE;
                $postage_cost           = getOrderDeliveryCost($subtotal,$branch_id);
                $booking_pk = $booking->PK_NO;
                $coupon_discount        = $this->getCouponDiscountByBooking($coupon_code,$branch_id,$booking_pk);
            DB::statement('CALL PROC_CUSTOMER_BOOKING(:booking_pk,:postage_cost,:coupon_discount,:flat_discount);',array( $booking_pk, $postage_cost,$coupon_discount,$flat_discount));
                $carts = $this->getCart($customer_id,$branch_id);
            $data['html'] = view('admin.cart._cart_view')->with('carts',$carts)->with('branch_id',$branch_id)->render();
            session()->forget('flat_discount');
            session()->forget('coupon_code');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            return $this->successResponse(200, 'Order sucessfully not placed!',[], 0);
        }
        DB::commit();
        return $this->successResponse(200, 'Order sucessfully placed!',$data, 1);
    }

    public function postReturnOrder($request)
    {
        $data = [];
        $curr_date = date('Y-m-d');
        DB::beginTransaction();
        try{
            $child      = BookingDetails::find($request->booking_details_id);
            $booking    = Booking::where('PK_NO',$child->F_BOOKING_NO)->first();
            $checkExist = DispatchItemReturn::where('F_BOOKING_NO',$child->F_BOOKING_NO)
                            ->where('F_BOOKING_DETAILS_NO',$child->PK_NO)
                            ->first();
            if(!empty($checkExist)){
                return $this->successResponse(200, 'Already have a request ! Thanks','', 0);
            }
            $return = new DispatchItemReturn();
            $return->F_BOOKING_NO = $child->F_BOOKING_NO;
            $return->F_BOOKING_DETAILS_NO = $child->PK_NO;
            $return->F_PRD_VARIANT_NO = $child->F_PRD_VARIANT_NO;
            $return->F_REQUEST_BY = Auth::user()->PK_NO;
            $return->REQUEST_AT = date('Y-m-d H:i:s');
            $return->RETURN_DATE = $request->return_date;
            $return->F_APPROVED_BY = '';
            $return->APPROVED_AT = '';
            $return->CREDIT_AMT = $child->LINE_PRICE ;
            $return->POSTAGE_AMT = NULL;
            $return->PENALTY_AMT = NULL ;
            $return->RETURN_NOTE = $request->return_note;
            $return->F_SHOP_NO = $child->F_SHOP_NO;
            $return->F_CUSTOMER_NO = $booking->F_CUSTOMER_NO;
            $return->STATUS = 0 ;
            $return->RETURN_CONDITION = $request->reason;
            $return->F_SS_CREATED_BY = Auth::user()->PK_NO;
            $return->SS_CREATED_ON = date('Y-m-d H:i:s');
            if($request->file('photo')){
                $image = $request->file('photo');
                $photo_ext = $image->getClientOriginalExtension();
                $filename = 'return_'. date('dmY'). '_' .uniqid().'.'.$photo_ext;
                $destinationPath1 = '/media/images/order_return';
                $image->move(public_path($destinationPath1), $filename);
                $return->PHOTO_PATH = $destinationPath1.'/'.$filename;
                $return->PHOTO_EXT = $photo_ext;
            }
            $return->save();
            DB::table('SLS_BOOKING_DETAILS')->where('PK_NO',$child->PK_NO)->update([
                'IS_RETURN' => 0,
                'RETURN_REASON' => $request->reason,
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return $this->successResponse(200, 'error !', '', 0);
        }
        DB::commit();
        return $this->successResponse(200, 'Order Item return entry successfull !', $data, 1);
    }


    public function getReturnRequestOrder($request){
        $data = DB::table('SC_ORDER_ITEM_RETURN')
        ->select('SC_ORDER_ITEM_RETURN.*','PRD_VARIANT_SETUP.VARIANT_NAME','SLS_BOOKING.BOOKING_NO','SLS_BOOKING.CUSTOMER_NAME','SA_USER.NAME as REQUESTED_BY')
        ->leftJoin('PRD_VARIANT_SETUP','PRD_VARIANT_SETUP.PK_NO','=','SC_ORDER_ITEM_RETURN.F_PRD_VARIANT_NO')
        ->leftJoin('SLS_BOOKING','SLS_BOOKING.PK_NO','=','SC_ORDER_ITEM_RETURN.F_BOOKING_NO')
        ->leftJoin('SA_USER','SA_USER.PK_NO','=','SC_ORDER_ITEM_RETURN.F_REQUEST_BY')
        ->where('SC_ORDER_ITEM_RETURN.STATUS',0)
        ->orderBy('SC_ORDER_ITEM_RETURN.PK_NO', 'ASC');
        if(Auth::user()->USER_TYPE == 10){
            $data->where('SC_ORDER_ITEM_RETURN.F_SHOP_NO',Auth::user()->SHOP_ID);
        }
        $data = $data->paginate(50);
        return $this->formatResponse(true, '', 'admin.agent.index', $data);
    }


    public function postConfirmReturnOrder($request){
        $data = [];
        $return_id = $request->return_id;
        $booking_id = $request->booking_id;
        $booking_details_id = $request->booking_details_id;

        $return     = DispatchItemReturn::find($return_id);
        $child      = BookingDetails::find($request->booking_details_id);
        $booking    = Booking::where('PK_NO',$child->F_BOOKING_NO)->first();
        if(empty($return) || empty($child) || empty($booking)){
            return $this->successResponse(200, 'error !', '', 0);
        }
        DB::beginTransaction();
        try{
            if($return){
            DB::table('SC_ORDER_ITEM_RETURN')->where('PK_NO',$return_id)->update([
                'APPROVED_AT' => date('Y-m-d H:i:s'),
                'APPROVED_BY' => Auth::user()->PK_NO,
                'STATUS' => 1
            ]);
        Stock::where('F_BOOKING_NO',$child->F_BOOKING_NO)->where('F_PRD_VARIANT_NO',$child->F_PRD_VARIANT_NO)->update([
            'BOOKING_STATUS' => null,
            'F_BOOKING_NO' => null,
        ]);
        DB::table('SLS_BOOKING_DETAILS')->where('PK_NO',$booking_details_id)->where('F_BOOKING_NO',$booking_id)->update([
            'IS_RETURN'=>1,
            'RETURN_REASON'=> $return->RETURN_CONDITION,
        ]);

        $payment = new PaymentCustomer();
        $payment->F_CUSTOMER_NO  = $booking->F_CUSTOMER_NO;
        $payment->F_PAYMENT_CURRENCY_NO     = 4;
        $payment->PAYMENT_DATE              = date('Y-m-d');
        $payment->PAY_AMOUNT                = $child->LINE_PRICE;
        // $payment->PAYMENT_REMAINING         = $amount_to_credit;
        $payment->F_PAYMENT_ACC_NO          = 24;
        $payment->PAYMENT_NOTE              = $return->RETURN_NOTE;
        $payment->PAID_BY                   = Auth::user()->PK_NO;
        $payment->SLIP_NUMBER               = $booking->PK_NO.$child->PK_NO;
        $payment->PAYMENT_CONFIRMED_STATUS  = 1;
        $payment->PAYMENT_TYPE              = 3;
        // $payment->PAYMENT_TYPE              = NULL;
        // $payment->F_BOOKING_NO_FOR_PAYMENT_TYPE3  = $child->F_BOOKING_NO;
        $payment->save();
        $pay_pk_no = $payment->PK_NO;
        $type      = 'customer';
        DB::statement('CALL PROC_CUSTOMER_PAYMENT(:pay_pk_no, :type);',array( $pay_pk_no,$type));
        }
    }catch(\Exception $e){
        dd($e->getMessage());
        DB::rollback();
        return $this->successResponse(200, 'error !', '', 0);
    }
    DB::commit();

    return $this->successResponse(200, 'Order Item return entry successfull !', $data, 1);
    }



    public function delete($PK_NO)
    {
      $book = Booking::where('PK_NO',$PK_NO)->first();
      if($book->BOOKING_STATUS >= 50 ){
        return $this->formatResponse(false, 'Can Not Delete Booking At This Moment!', 'admin.booking.list');
      }
        DB::beginTransaction();
        try {
            $stock = Stock::select('PK_NO')->where('F_BOOKING_NO',$PK_NO)->get();
            foreach ($stock as $key => $value) {
                Stock::where('PK_NO',$value->PK_NO)->update(['BOOKING_STATUS' => null, 'F_BOOKING_NO' => null]);
            }
            BookingDetails::where('F_BOOKING_NO',$PK_NO)->delete();
            Booking::where('PK_NO',$PK_NO)->delete();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), 'admin.booking.list');
        }
        DB::commit();
        return $this->formatResponse(true, 'Successfully deleted booking with details !', 'admin.booking.list');
    }

    public function getDownloadPDF($request,$id){
        $data       = array();
        $booking    = DB::table('SLS_BOOKING')
        ->select('PK_NO','BOOKING_TIME','POSTAGE_COST','SUB_TOTAL','TOTAL_PRICE','DISCOUNT','DELIVERY_NAME',
        'DELIVERY_MOBILE','DELIVERY_ADDRESS_LINE_1','DELIVERY_CITY','DELIVERY_POSTCODE','DELIVERY_STATE',
        'DELIVERY_AREA_NAME','DELIVERY_SUB_AREA_NAME','DELIVERY_SLOT','DELIVERY_DATE','F_SHOP_NO','COUPON_DISCOUNT')
        ->where('PK_NO',$id)
        ->first();
        $branch_id = $booking->F_SHOP_NO;
        $booking_details = BookingDetails::select('SLS_BOOKING_DETAILS.*','PRD_VARIANT_SETUP.VARIANT_NAME','SLS_BOOKING_DETAILS.F_PRD_VARIANT_NO as VARIANT_PK_NO','PRD_VARIANT_SETUP.VARIANT_NAME','PRD_VARIANT_SETUP.MRK_ID_COMPOSITE_CODE', 'PRD_VARIANT_STOCK_QTY.TOTAL_FREE_STOCK')
        ->leftJoin('PRD_VARIANT_SETUP','PRD_VARIANT_SETUP.PK_NO','SLS_BOOKING_DETAILS.F_PRD_VARIANT_NO')
        ->leftJoin('PRD_VARIANT_STOCK_QTY', function($join) use ($branch_id)
        {
            $join->on('PRD_VARIANT_STOCK_QTY.F_PRD_VARIANT_NO', '=', 'SLS_BOOKING_DETAILS.F_PRD_VARIANT_NO');
            $join->on('PRD_VARIANT_STOCK_QTY.F_SHOP_NO', '=', DB::raw("'$branch_id'"));
        })
        ->where('SLS_BOOKING_DETAILS.F_BOOKING_NO', $id)
        ->get();
        $data['booking_details'] = $booking_details;
        $data['booking'] = $booking;
        return $this->formatResponse(true, 'Data found successfully !', 'admin.booking.list', $data);

    }

    public function getOrderPaymentStatus($order_id){
        $order = DB::table('SLS_BOOKING')->where('PK_NO',$order_id)->first();
        $order_payment = DB::table('ACC_ORDER_PAYMENT')->where('F_BOOKING_NO',$order_id)->first();
        if(!empty($order_payment) && ($order->PAYMENT_STATUS=='Complete')){
            return $order->PAYMENT_STATUS;
        }
        return NULL;
    }

    public function getOrderPaymentMethod($order_id){
        $cod = "cod";
        $order = DB::table('SLS_BOOKING')->where('PK_NO',$order_id)->first();
        $order_payment = DB::table('ACC_ORDER_PAYMENT')->where('F_BOOKING_NO',$order_id)->first();
        if(!empty($order_payment) && $order->PAYMENT_STATUS=='Complete'){
            return $order->PAYMENT_METHOD;
        }
        return $cod;
    }



    public function bookingStatusBulkUpdate($request)
    {
        $booking_id = $request->booking_id;
        $booking_status = $request->booking_status;
        $booking_validity = \Config::get('static_array.booking_status_notice') ?? array();
        DB::beginTransaction();
        try {
            if(!is_null($request->booking_id[0])){

                $count = count($request->booking_id);
                $booking_cycle = array();
                for($i=0; $i<$count; $i++)
                {
                    $booking = Booking::find($request->booking_id[$i]);
                    $booking->BOOKING_STATUS = $booking_status;
                    $booking->update();
                    $booking_details = BookingDetails::where('F_BOOKING_NO',$request->booking_id[$i])->get();
                        foreach($booking_details as $booking_detail){
                            DB::table('SLS_BOOKING_DETAILS')->where('PK_NO',$booking_detail->PK_NO)->update([
                                'BOOKING_STATUS' => $booking_status,
                                'F_SS_MODIFIED_BY' => Auth::user()->PK_NO,
                            ]);
                        }
                    Stock::where('F_BOOKING_NO',$request->booking_id[$i])
                            ->update([
                                'BOOKING_STATUS' => $booking_status,
                                'F_SS_MODIFIED_BY' => Auth::user()->PK_NO,
                    ]);

                if(!empty($request->booking_id[$i])){
                      array_push($booking_cycle, [
                    'F_BOOKING_NO' => $request->booking_id[$i],
                    'BOOKING_STATUS' => $booking_status,
                    'F_SHOP_NO' => $booking->F_SHOP_NO,
                    'COMMENTS' => $booking_validity[$booking_status] ?? NULL,
                    'F_USER_NO' => Auth::user()->PK_NO,
                    'IS_ACTIVE' => 1,
                    'REQUEST_FROM' => 'ADMIN',
                    'SS_CREATED_ON' => date('Y-m-d H:i:s'),
                    'F_SS_CREATED_BY' => Auth::user()->PK_NO,
                    ]);
                }
                }
                DB::table('SLS_BOOKING_LIFECYCLE')->insert($booking_cycle);
            }
            } catch (\Exception $e) {
                dd($e->getMessage());
                DB::rollback();
                return $this->successResponse($e->getCode(), 'Order status not updated!', '', 0);
            }
            DB::commit();
        return $this->successResponse(200, 'Order status sucessfully updated!',[], 1);
    }



    public function bulkAssignDeliveryMan($request)
    {
        $delivery_boy_id = $request->delivery_boy_id;
        $booking_validity = \Config::get('static_array.booking_status_notice') ?? array();
        DB::beginTransaction();
        try {
            if(!is_null($request->booking_id[0])){

                $count = count($request->booking_id);
                $booking_cycle = array();
                for($i=0; $i<$count; $i++)
                {
                    $booking = Booking::find($request->booking_id[$i]);
                    $booking->BOOKING_STATUS = 70;
                    $booking->update();
                    $booking_details = BookingDetails::where('F_BOOKING_NO',$request->booking_id[$i])->get();
                        foreach($booking_details as $booking_detail){
                            DB::table('SLS_BOOKING_DETAILS')->where('PK_NO',$booking_detail->PK_NO)->update([
                                'BOOKING_STATUS' => 70,
                                'F_SS_MODIFIED_BY' => Auth::user()->PK_NO,
                            ]);
                        }
                    Stock::where('F_BOOKING_NO',$request->booking_id[$i])
                            ->update([
                                'BOOKING_STATUS' => 70,
                                'F_SS_MODIFIED_BY' => Auth::user()->PK_NO,
                    ]);

                if(!empty($delivery_boy_id)){
                        $payment_status =  $this->getOrderPaymentStatus($request->booking_id[$i]);
                        $payment_method = $this->getOrderPaymentMethod($request->booking_id[$i]);
                    DB::table('SLS_DELIVERY_HISTORY')->insert([
                            'F_BOOKING_NO' => $request->booking_id[$i],
                            'F_DELIVERY_BOY_NO' => $delivery_boy_id,
                            'PAYMENT_METHOD' => $payment_method,
                            'PAYMENT_STATUS' => $payment_status ,
                            'PAYMENT_AMOUNT' => $booking->TOTAL_PRICE,
                            'DELIVERY_STATUS' => 0,
                            'DELIVERED_AT' => null,
                            'F_SS_CREATED_BY' => Auth::id(),
                            'SS_CREATED_ON' => date('Y-m-d H:i:s'),
                            'IS_ACTIVE' => 1,
                    ]);
                }

                if(!empty($request->booking_id[$i])){
                      array_push($booking_cycle, [
                    'F_BOOKING_NO' => $request->booking_id[$i],
                    'BOOKING_STATUS' => 70,
                    'F_SHOP_NO' => $booking->F_SHOP_NO,
                    'COMMENTS' => $booking_validity[70] ?? NULL,
                    'F_USER_NO' => Auth::user()->PK_NO,
                    'IS_ACTIVE' => 1,
                    'REQUEST_FROM' => 'ADMIN',
                    'SS_CREATED_ON' => date('Y-m-d H:i:s'),
                    'F_SS_CREATED_BY' => Auth::user()->PK_NO,
                    ]);
                }
                }
                DB::table('SLS_BOOKING_LIFECYCLE')->insert($booking_cycle);
            }
            } catch (\Exception $e) {
                dd($e->getMessage());
                DB::rollback();
                return $this->successResponse($e->getCode(), 'Order status not updated!', '', 0);
            }
            DB::commit();
        return $this->successResponse(200, 'Order status sucessfully updated!',[], 1);
    }


    public function assignDeliveryman($request)
    {
        $image = NULL;
        $booking_id = $request->booking_id;
        $delivery_boy_id = $request->delivery_boy_id;
        DB::beginTransaction();
        try {
            $delivery_boy = DB::table('SA_USER')->where('PK_NO',$delivery_boy_id)->first();
            $booking = Booking::find($booking_id);
            if(empty($booking)){
                return $this->successResponse(200, 'Order not found', '', 0);
            }
            $check =  DB::table('SLS_DELIVERY_HISTORY')->where('F_BOOKING_NO',$booking_id)->where('IS_ACTIVE',1)->first();
            if(!empty($check)){
                $response_msg       = 'Order already assigned a delivery man !';
            }
            else{
                if(!empty($delivery_boy_id)){


                    $payment_status =  $this->getOrderPaymentStatus($booking_id);
                    $payment_method = $this->getOrderPaymentMethod($booking_id);
                        //assigned deliveryboy
                    DB::table('SLS_DELIVERY_HISTORY')->insert([
                            'F_BOOKING_NO' => $booking_id,
                            'F_DELIVERY_BOY_NO' => $delivery_boy_id,
                            'PAYMENT_METHOD' => $payment_method,
                            'PAYMENT_STATUS' => $payment_status ,
                            'PAYMENT_AMOUNT' => $booking->TOTAL_PRICE,
                            'DELIVERY_STATUS' => 0,
                            'DELIVERED_AT' => null,
                            'F_SS_CREATED_BY' => Auth::id(),
                            'SS_CREATED_ON' => date('Y-m-d H:i:s'),
                            'IS_ACTIVE' => 1,
                    ]);
                    DB::table('SLS_BOOKING')->where('PK_NO',$booking_id)->update([
                        'BOOKING_STATUS'=>70,
                    ]);
                    $notice_title = "Order assigned";
                    $notice_text = 'Dear '.$delivery_boy->NAME .', Order no. '.$booking->BOOKING_NO.' has been assigned to you.';
                    $notification = $this->sendUserNotification($delivery_boy_id,$notice_text,$notice_title,$image);
                }
              }
            } catch (\Exception $e) {
                dd($e->getMessage());
                DB::rollback();
            return $this->successResponse(200, 'Delivery man not assigned !', '', 0);
            }
            DB::commit();
            return $this->successResponse(200, 'Delivery man sucessfully assigned!', $booking, 1);
    }

    public function updateApplyCoupon($request)
    {
        $customer_id = $request->customer_id;
        $branch_id = $request->branch_id;
        $booking_id = $request->booking_id;
        $grand_total = $request->grand_total;
        $coupon_code = $request->coupon_code;
        $now = Carbon::now();
        $data = [];
        try {
        if(isset($coupon_code) && !empty($coupon_code)){
                $coupon_master = DB::table('SLS_COUPON_MASTER')->where('COUPON_CODE',$coupon_code)->where('IS_ACTIVE',1)->where('VALIDITY_FROM','<=',$now)->first();
                if (!isset($coupon_master) || empty($coupon_master)) {
                    return $this->successResponse(200, 'Invalid coupon !',null,0);
                }
                if ($coupon_master->VALIDITY_TO < $now) {
                    return $this->successResponse(200, 'Coupon expired !',null,0);
                }
            }
        $coupon_discount        = $this->getCouponDiscountByAmount($coupon_code,$branch_id,$grand_total);
        $data['coupon_discount'] = $coupon_discount;
        $data['coupon_code'] = $coupon_code;
        } catch (\Exception $e) {
            dd($e->getMessage());
        return $this->successResponse(200, 'Error !', '', 0);
        }
        return $this->successResponse(200, 'sucessfully !', $data, 1);
    }

}
