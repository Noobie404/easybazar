<?php
namespace App\Repositories\Api\Shipment;
use DB;
use App\Models\Box;
use App\Models\Stock;
use App\Models\Product;
use App\Models\MerStock;
use App\Models\Shipment;
use App\Models\AdminUser;
use App\Models\ProdImgLib;
use App\Models\Shipmentbox;
use App\Traits\ApiResponse;
use App\Models\ProductVariant;
use Symfony\Component\HttpFoundation\Request;

class ShipmentAbstract implements ShipmentInterface
{
    use ApiResponse;

    function __construct() {
    }

    public function ShipmentPost($request)
    {
        $shipment_label = (int)$request->shipment_label/1000;
        $shipment_label = floor($shipment_label);
        $box_serial     = (int)$request->shipment_label%1000;
        $box_label      = (int)$request->box_label;
        $ship_type = 'SEA';
        $box_type = 'SEA';

        $shipment_master = DB::table('SC_SHIPMENT')->select('PK_NO','F_FROM_INV_WAREHOUSE_NO','CODE','SHIPMENT_STATUS','IS_AIR_SHIPMENT','F_MERCHANT_NO')->where('CODE', $shipment_label)->whereRaw('( SHIPMENT_STATUS IS NULL OR SHIPMENT_STATUS = 10 )')->first();
        if (empty($shipment_master)) {
            return $this->successResponse(200, 'Shipment not found!', null, 0);
        }
        if ($shipment_master->IS_AIR_SHIPMENT == 1) {
            $ship_type = 'AIR';
        }
        $box_type = substr($box_label, 0, 1);
        if ($box_type == 1 || $box_type == 3) {
            $box_type = 'AIR';
        }
        if ($ship_type == 'SEA' && $box_type == 'AIR') {
            return $this->successResponse(200, 'Box Type is Air But Ship Type is Sea !', null, 0);
        }
        $user_map = DB::table('SS_INV_USER_MAP')->select('F_INV_WAREHOUSE_NO')->where('F_USER_NO', $request->user_id)->first();
        $box_master3 = DB::table('SC_BOX')->where('BOX_NO', $box_label)->first();
        $box_master2 = DB::table('SC_BOX')->where('BOX_NO', $box_label)->whereRaw('BOX_STATUS > 10')->first();
        $box_master = DB::table('SC_BOX')->where('BOX_NO', $box_label)->whereRaw('BOX_STATUS = 10')->first();

        if (empty($box_master3)) {
            return $this->successResponse(200, 'Box not found !', null, 0);
        }else if(!empty($box_master2)){
                return $this->successResponse(200, 'Box is in use !', null, 0);
        }else if (($user_map->F_INV_WAREHOUSE_NO != $box_master->F_INV_WAREHOUSE_NO) || ($box_master->F_INV_WAREHOUSE_NO != $shipment_master->F_FROM_INV_WAREHOUSE_NO)) {
            return $this->successResponse(200, 'Unauthorized Location!', null, 0);
        }
        if ($box_master->F_MERCHANT_NO != $shipment_master->F_MERCHANT_NO) {
            return $this->successResponse(200, 'Merchant box and shipment does not match !', null, 0);
        }
        // $box_master['serial'] = $box_serial;
        if($shipment_master->F_MERCHANT_NO > 0){
            $inv_stock = DB::table('MER_INV_STOCK')->select('PREFERRED_SHIPPING_METHOD','FINAL_PREFFERED_SHIPPING_METHOD')->where('F_BOX_NO', $box_master->PK_NO)->count();
        }else{
            $inv_stock = DB::table('INV_STOCK')->select('PREFERRED_SHIPPING_METHOD','FINAL_PREFFERED_SHIPPING_METHOD')->where('F_BOX_NO', $box_master->PK_NO)->count();
        }
        if ($inv_stock == 0) {
            return $this->successResponse(200, 'Box is empty !', null, 0);
        }
        if ($inv_stock != $box_master->ITEM_COUNT) {
            return $this->successResponse(200, 'Product quantity does not match !', null, 0);
        }

        // foreach ($inv_stock as $key => $value) {
        //     // if ($ship_type != $value->CUSTOMER_PREFFERED_SHIPPING_METHOD || $value->CUSTOMER_PREFFERED_SHIPPING_METHOD != $value->PREFERRED_SHIPPING_METHOD) {
        //         // return $this->successResponse(200, 'Box Item & Shipment Method Does Not Match !', null, 0);
        //         // }
        //         if ($ship_type == 'SEA' && ($value->FINAL_PREFFERED_SHIPPING_METHOD == 'AIR')) {
        //             return $this->successResponse(200, 'Box Item & Shipment Method Does Not Match !', null, 0);
        //     }
        // }
        $shipment_label = DB::table('SC_SHIPMENT_BOX')->select('PK_NO')->where('F_SHIPMENT_NO',$shipment_master->PK_NO)->where('BOX_SERIAL', $box_serial)->first();

        if (!empty($shipment_label)) {
            return $this->successResponse(200, 'Duplicate Serial No.', null, 0);
        }
        $shipment_box = DB::table('SC_SHIPMENT_BOX')->select('PK_NO')->where('F_BOX_NO', $box_master->PK_NO)->first();

        if (!empty($shipment_box)) {
            return $this->successResponse(200, 'Duplicate Box Entry !', null, 0);
        }
        DB::beginTransaction();
        try {
            if($shipment_master->F_MERCHANT_NO > 0){
                MerStock::where('F_BOX_NO', $box_master->PK_NO)->update(['F_SHIPPMENT_NO' => $shipment_master->PK_NO,
                                                                        'SHIPMENT_NAME' => $shipment_master->CODE,
                                                                        'SHIPMENT_TYPE' => $shipment_master->IS_AIR_SHIPMENT == 1 ? 'AIR' : 'SEA']);
            }else{
                Stock::where('F_BOX_NO', $box_master->PK_NO)->update(['F_SHIPPMENT_NO' => $shipment_master->PK_NO,
                                                                        'SHIPMENT_NAME' => $shipment_master->CODE,
                                                                        'SHIPMENT_TYPE' => $shipment_master->IS_AIR_SHIPMENT == 1 ? 'AIR' : 'SEA']);
            }
            Box::where('PK_NO',$box_master->PK_NO)->update(['BOX_STATUS'=>20]);
            $shipment_box = new Shipmentbox();
            $shipment_box->F_SHIPMENT_NO = $shipment_master->PK_NO;
            $shipment_box->BOX_SERIAL    = $box_serial;
            $shipment_box->F_BOX_NO      = $box_master->PK_NO;
            $shipment_box->PRODUCT_COUNT = $box_master->ITEM_COUNT;
            $shipment_box->save();

            // $count = Shipmentbox::where('F_SHIPMENT_NO', $shipment_master->PK_NO)->count();
            // Shipment::where('PK_NO', $shipment_master->PK_NO)->update(['SENDER_BOX_COUNT' => $count]);
            Box::where('BOX_NO', $box_label)->update(['BOX_STATUS' => 20]);

        } catch (\Exception $e) {
            DB::rollback();
            return $this->successResponse(200, $e->getMessage(), null, 0);
        }
        DB::commit();

        return $this->successResponse(200, 'Box added successfully !', $box_master, 1);
    }

    public function MerchantShipmentPost($request)
    {
        $shipment_label = (int)$request->shipment_label/1000;
        $shipment_label = floor($shipment_label);
        $box_serial     = (int)$request->shipment_label%1000;
        $box_label      = (int)$request->box_label;
        $ship_type = 'SEA';
        $box_type = 'SEA';

        $shipment_master = DB::table('SC_SHIPMENT')->select('PK_NO','F_FROM_INV_WAREHOUSE_NO','CODE','SHIPMENT_STATUS','IS_AIR_SHIPMENT','F_MERCHANT_NO')->where('CODE', $shipment_label)->whereRaw('( SHIPMENT_STATUS IS NULL OR SHIPMENT_STATUS = 10 )')->first();
        if (empty($shipment_master)) {
            return $this->successResponse(200, 'Shipment not found!', null, 0);
        }
        if ($shipment_master->IS_AIR_SHIPMENT == 1) {
            $ship_type = 'AIR';
        }
        $box_type = substr($box_label, 0, 1);
        if ($box_type == 3) {
            $box_type = 'AIR';
        }
        if ($ship_type == 'SEA' && $box_type == 'AIR') {
            return $this->successResponse(200, 'Box Type is Air But Ship Type is Sea !', null, 0);
        }
        $user_map = DB::table('SS_INV_USER_MAP')->select('F_INV_WAREHOUSE_NO')->where('F_USER_NO', $request->user_id)->first();
        $box_master3 = DB::table('SC_BOX')->where('BOX_NO', $box_label)->where('F_MERCHANT_NO',$request->merchant_id)->first();
        $box_master2 = DB::table('SC_BOX')->where('BOX_NO', $box_label)->whereRaw('BOX_STATUS > 10')->first();
        $box_master = DB::table('SC_BOX')->where('BOX_NO', $box_label)->whereRaw('BOX_STATUS = 10')->first();

        if (empty($box_master3)) {
            return $this->successResponse(200, 'Box not found !', null, 0);
        }else if(!empty($box_master2)){
                return $this->successResponse(200, 'Box is in use !', null, 0);
        }else if (($user_map->F_INV_WAREHOUSE_NO != $box_master->F_INV_WAREHOUSE_NO) || ($box_master->F_INV_WAREHOUSE_NO != $shipment_master->F_FROM_INV_WAREHOUSE_NO)) {
            return $this->successResponse(200, 'Unauthorized Location!', null, 0);
        }
        if ($box_master->F_MERCHANT_NO != $shipment_master->F_MERCHANT_NO) {
            return $this->successResponse(200, 'Merchant box and shipment does not match !', null, 0);
        }
        $box_master['serial'] = $box_serial;

        $inv_stock = DB::table('MER_INV_STOCK')->select('PREFERRED_SHIPPING_METHOD','FINAL_PREFFERED_SHIPPING_METHOD')->where('F_BOX_NO', $box_master->PK_NO)->where('F_MERCHANT_NO',$request->merchant_id)->get();
        if (count($inv_stock) == 0) {
            return $this->successResponse(200, 'Box is empty !', null, 0);
        }
        if (count($inv_stock) != $box_master->ITEM_COUNT) {
            return $this->successResponse(200, 'Product quantity does not match !', null, 0);
        }
        $shipment_label = DB::table('SC_SHIPMENT_BOX')->select('PK_NO')->where('F_SHIPMENT_NO',$shipment_master->PK_NO)->where('BOX_SERIAL', $box_serial)->first();

        if (!empty($shipment_label)) {
            return $this->successResponse(200, 'Duplicate Serial No.', null, 0);
        }
        $shipment_box = DB::table('SC_SHIPMENT_BOX')->select('PK_NO')->where('F_BOX_NO', $box_master->PK_NO)->first();

        if (!empty($shipment_box)) {
            return $this->successResponse(200, 'Duplicate Box Entry !', null, 0);
        }
        DB::beginTransaction();
        try {
            MerStock::where('F_BOX_NO', $box_master->PK_NO)->update(['F_SHIPPMENT_NO' => $shipment_master->PK_NO,
                                                                'SHIPMENT_NAME' => $shipment_master->CODE,
                                                                'SHIPMENT_TYPE' => $shipment_master->IS_AIR_SHIPMENT == 1 ? 'AIR' : 'SEA']);
            Box::where('PK_NO',$box_master->PK_NO)->update(['BOX_STATUS'=>20]);
            $shipment_box = new Shipmentbox();
            $shipment_box->F_SHIPMENT_NO = $shipment_master->PK_NO;
            $shipment_box->BOX_SERIAL    = $box_serial;
            $shipment_box->F_BOX_NO      = $box_master->PK_NO;
            $shipment_box->PRODUCT_COUNT = $box_master->ITEM_COUNT;
            $shipment_box->save();
            Box::where('BOX_NO', $box_label)->update(['BOX_STATUS' => 20]);

        } catch (\Exception $e) {
            DB::rollback();
            return $this->successResponse(200, $e->getMessage(), null, 0);
        }
        DB::commit();
        return $this->successResponse(200, 'Box added successfully !', $box_master, 1);
    }

///////////////////////////////// SHIPMENT RECIEVED AT DESTINATION ///////////////////////////
    public function shipmentReceived($request)
    {
        // $shipment_label = (int)$request->shipment_label/1000;
        // $shipment_label = floor($shipment_label);
        // $box_serial     = (int)$request->shipment_label%1000;
        $box_label      = (int)$request->box_label;

        $status_ = Box::select('BOX_STATUS')->where('BOX_NO', $box_label)->first();
        if ($status_->BOX_STATUS == 50) {
            return $this->successResponse(200, 'Shipment already received !', null, 0);
        }
        $box_master = Box::where('BOX_NO', $box_label)->where('BOX_STATUS', 40)->first();
        if (empty($box_master)) {
            return $this->successResponse(200, 'Box not ready to receive !', null, 0);
        }
        $shipment_no = Shipmentbox::select('F_SHIPMENT_NO')->where('F_BOX_NO', $box_master->PK_NO)->first();
        if (empty($shipment_no)) {
            return $this->successResponse(200, 'Box not found!', null, 0);
        }
        $shipment_status = Shipment::select('SHIPMENT_STATUS','F_TO_INV_WAREHOUSE_NO','F_MERCHANT_NO')->where('PK_NO', $shipment_no->F_SHIPMENT_NO)->first();
        if (empty($shipment_status)) {
            return $this->successResponse(200, 'Shipment not found!', null, 0);
        }
        if ($shipment_status->F_MERCHANT_NO != $box_master->F_MERCHANT_NO) {
            return $this->successResponse(200, 'Shipment and merchant does not match !', null, 0);
        }
        $user_map = DB::table('SS_INV_USER_MAP')->select('F_INV_WAREHOUSE_NO')->where('F_USER_NO', $request->user_id)->first();

        if ($user_map->F_INV_WAREHOUSE_NO != $shipment_status->F_TO_INV_WAREHOUSE_NO) {
            return $this->successResponse(200, 'Unauthorized Location!', null, 0);
        }else if($shipment_status->SHIPMENT_STATUS == 70){
            DB::beginTransaction();
            try {
                // $all_box = Shipmentbox::select('F_BOX_NO')->where('F_SHIPMENT_NO',$shipment_no->F_SHIPMENT_NO)->get();

                // Box::whereIn('PK_NO', $all_box)->update(['F_INV_WAREHOUSE_NO' => $shipment_status->F_TO_INV_WAREHOUSE_NO,'F_BOX_USER_NO' => $request->user_id,'BOX_STATUS' => 50]);
                // Stock::where('F_SHIPPMENT_NO', $shipment_no->F_SHIPMENT_NO)->update(['PRODUCT_STATUS' => 50, 'F_INV_WAREHOUSE_NO' => $shipment_status->F_TO_INV_WAREHOUSE_NO , 'INV_WAREHOUSE_NAME' => $shipment_status->to_warehouse->NAME]);
                // Shipment::where('PK_NO', $shipment_no->F_SHIPMENT_NO)->update(['SHIPMENT_STATUS' => 80]);

                Box::where('BOX_NO', $box_label)->update(['F_INV_WAREHOUSE_NO' => $shipment_status->F_TO_INV_WAREHOUSE_NO,'F_BOX_USER_NO' => $request->user_id,'BOX_STATUS' => 50]);

                // Stock::where('BOX_BARCODE', $box_label)->update(['PRODUCT_STATUS' => 50, 'F_INV_WAREHOUSE_NO' => $shipment_status->F_TO_INV_WAREHOUSE_NO , 'INV_WAREHOUSE_NAME' => $shipment_status->to_warehouse->NAME]);
                if ($shipment_status->F_MERCHANT_NO > 0){
                    MerStock::where('BOX_BARCODE', $box_label)->update(['PRODUCT_STATUS' => 50]);
                }else{
                    Stock::where('BOX_BARCODE', $box_label)->update(['PRODUCT_STATUS' => 50]);
                }

                $product_count = Shipmentbox::leftjoin('SC_BOX as b','b.PK_NO','SC_SHIPMENT_BOX.F_BOX_NO')
                                ->where('SC_SHIPMENT_BOX.F_SHIPMENT_NO',$shipment_no->F_SHIPMENT_NO)
                                ->where('b.BOX_STATUS',40)
                                ->count();

                if ($product_count == 0) {
                    Shipment::where('PK_NO', $shipment_no->F_SHIPMENT_NO)->update(['SHIPMENT_STATUS' => 80]);
                }
            } catch (\Exception $th) {
                DB::rollback();
                return $this->successResponse(200, $th->getMessage(), null, 0);
            }
            DB::commit();
            return $this->successResponse(200, 'Shipment Received successfully !', null, 1);
        }else {
            return $this->successResponse(200, 'Please try again !', null, 0);
        }
    }

    public function MerchantshipmentReceived($request)
    {
        $box_label      = (int)$request->box_label;

        $status_ = Box::select('BOX_STATUS')->where('BOX_NO', $box_label)->first();
        if ($status_->BOX_STATUS == 50) {
            return $this->successResponse(200, 'Shipment already received !', null, 0);
        }
        $box_master = Box::where('BOX_NO', $box_label)->where('BOX_STATUS', 40)->first();
        if (empty($box_master)) {
            return $this->successResponse(200, 'Box not ready to receive !', null, 0);
        }
        $shipment_no = Shipmentbox::select('F_SHIPMENT_NO')->where('F_BOX_NO', $box_master->PK_NO)->first();
        if (empty($shipment_no)) {
            return $this->successResponse(200, 'Box not found!', null, 0);
        }
        $shipment_status = Shipment::select('SHIPMENT_STATUS','F_TO_INV_WAREHOUSE_NO','F_MERCHANT_NO')->where('PK_NO', $shipment_no->F_SHIPMENT_NO)->first();
        if (empty($shipment_status)) {
            return $this->successResponse(200, 'Shipment not found!', null, 0);
        }
        if ($shipment_status->F_MERCHANT_NO != $request->merchant_id) {
            return $this->successResponse(200, 'Shipment and merchant does not match !', null, 0);
        }
        $user_map = DB::table('SS_INV_USER_MAP')->select('F_INV_WAREHOUSE_NO')->where('F_USER_NO', $request->user_id)->first();

        if ($user_map->F_INV_WAREHOUSE_NO != $shipment_status->F_TO_INV_WAREHOUSE_NO) {
            return $this->successResponse(200, 'Unauthorized Location!', null, 0);
        }else if($shipment_status->SHIPMENT_STATUS == 70){
            DB::beginTransaction();
            try {
                // $all_box = Shipmentbox::select('F_BOX_NO')->where('F_SHIPMENT_NO',$shipment_no->F_SHIPMENT_NO)->get();

                // Box::whereIn('PK_NO', $all_box)->update(['F_INV_WAREHOUSE_NO' => $shipment_status->F_TO_INV_WAREHOUSE_NO,'F_BOX_USER_NO' => $request->user_id,'BOX_STATUS' => 50]);
                // Stock::where('F_SHIPPMENT_NO', $shipment_no->F_SHIPMENT_NO)->update(['PRODUCT_STATUS' => 50, 'F_INV_WAREHOUSE_NO' => $shipment_status->F_TO_INV_WAREHOUSE_NO , 'INV_WAREHOUSE_NAME' => $shipment_status->to_warehouse->NAME]);
                // Shipment::where('PK_NO', $shipment_no->F_SHIPMENT_NO)->update(['SHIPMENT_STATUS' => 80]);

                Box::where('BOX_NO', $box_label)->update(['F_INV_WAREHOUSE_NO' => $shipment_status->F_TO_INV_WAREHOUSE_NO,'F_BOX_USER_NO' => $request->user_id,'BOX_STATUS' => 50]);

                // Stock::where('BOX_BARCODE', $box_label)->update(['PRODUCT_STATUS' => 50, 'F_INV_WAREHOUSE_NO' => $shipment_status->F_TO_INV_WAREHOUSE_NO , 'INV_WAREHOUSE_NAME' => $shipment_status->to_warehouse->NAME]);
                MerStock::where('BOX_BARCODE', $box_label)->update(['PRODUCT_STATUS' => 50]);

                $product_count = Shipmentbox::leftjoin('SC_BOX as b','b.PK_NO','SC_SHIPMENT_BOX.F_BOX_NO')
                                ->where('SC_SHIPMENT_BOX.F_SHIPMENT_NO',$shipment_no->F_SHIPMENT_NO)
                                ->where('b.BOX_STATUS',40)
                                ->count();

                if ($product_count == 0) {
                    Shipment::where('PK_NO', $shipment_no->F_SHIPMENT_NO)->update(['SHIPMENT_STATUS' => 80]);
                }
            } catch (\Exception $th) {
                DB::rollback();
                return $this->successResponse(200, $th->getMessage(), null, 0);
            }
            DB::commit();
            return $this->successResponse(200, 'Shipment Received successfully !', null, 1);
        }else {
            return $this->successResponse(200, 'Please try again !', null, 0);
        }
    }

    public function shipmentList($request)
    {
        $user_map = DB::table('SS_INV_USER_MAP')->select('F_INV_WAREHOUSE_NO')->where('F_USER_NO', $request->user_id)->first();
        if (empty($user_map)) {
            return $this->successResponse(200, 'Unauthorized Location!', null, 0);
        }
        $data = Shipment::select('SC_SHIPMENT.PK_NO as shipment_no','SC_SHIPMENT.CODE as shipment_label','SCH_DEPARTING_DATE as departure_time','SCH_ARRIVAL_DATE as ETA_date','SENDER_BOX_COUNT as box_count','IS_AIR_SHIPMENT as is_air','SHIPMENT_STATUS as status','m.SHORT_NAME','SHIPMENT_FOR','F_MERCHANT_NO as merchant_id','m.NAME as merchant_name'
        )->leftjoin('SLS_MERCHANT as m','m.PK_NO','SC_SHIPMENT.F_MERCHANT_NO')
        // ->where('F_FROM_INV_WAREHOUSE_NO',$user_map->F_INV_WAREHOUSE_NO)
        // ->where('SHIPMENT_FOR',1)
        ->orderBy('shipment_no','DESC')
        ->get();

        foreach ($data as $key => $value) {
            $value->SHORT_NAME = $value->SHIPMENT_FOR == 1 ? 'AMT' : $value->SHORT_NAME;
            if ($value->status > 20) {
                $shipment_box       = Shipmentbox::select('F_BOX_NO')->where('F_SHIPMENT_NO',$value->shipment_no)->get();
                $received_count     = Box::whereIn('PK_NO',$shipment_box)->where('BOX_STATUS','>=',50)->count();
                $value->received_qty    = $received_count;
            }else{
                $value->received_qty    = 0;
            }
        }
        if (count($data)>0) {
            return $this->successResponse(200, 'Shipment is available !', $data, 1);
        }
        return $this->successResponse(200, 'Shipment Not Found !', null, 0);
    }

    public function MerchantshipmentList($request)
    {
        $user_map = DB::table('SS_INV_USER_MAP')->select('F_INV_WAREHOUSE_NO')->where('F_USER_NO', $request->user_id)->first();
        if (empty($user_map)) {
            return $this->successResponse(200, 'Unauthorized Location!', null, 0);
        }
        $user = DB::table('SA_USER')->select('F_MERCHANT_NO')->where('PK_NO', $request->user_id)->first();
        $data = DB::table('SC_SHIPMENT as s')->select('s.PK_NO as shipment_no','s.CODE as shipment_label','SCH_DEPARTING_DATE as departure_time','SCH_ARRIVAL_DATE as ETA_date','SENDER_BOX_COUNT as box_count','IS_AIR_SHIPMENT as is_air','SHIPMENT_STATUS as status','m.NAME as merchant_name','m.PK_NO as merchant_id','m.SHORT_NAME'
        )->join('SLS_MERCHANT as m','m.PK_NO','s.F_MERCHANT_NO')
        ->where('SHIPMENT_FOR',2);
        if ($user->F_MERCHANT_NO > 0) {
            $data = $data->where('s.F_MERCHANT_NO',$user->F_MERCHANT_NO);
        }
        $data = $data->orderBy('shipment_no','DESC')
        ->get();

        foreach ($data as $key => $value) {
            if ($value->status > 20) {
                $shipment_box       = Shipmentbox::select('F_BOX_NO')->where('F_SHIPMENT_NO',$value->shipment_no)->get();
                $received_count     = Box::whereIn('PK_NO',$shipment_box)->where('BOX_STATUS','>=',50)->count();
                $value->received_qty    = $received_count;
            }else{
                $value->received_qty    = 0;
            }
        }
        if (count($data)>0) {
            return $this->successResponse(200, 'Shipment is available !', $data, 1);
        }
        return $this->successResponse(200, 'Shipment Not Found !', null, 0);
    }
}
