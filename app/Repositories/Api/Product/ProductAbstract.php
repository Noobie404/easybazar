<?php
namespace App\Repositories\Api\Product;
use DB;
use App\Models\Stock;
use App\Models\Product;
use App\Models\MerStock;
use App\Models\ProdImgLib;
use App\Traits\ApiResponse;
use App\Models\ProductVariant;

class ProductAbstract implements ProductInterface
{
    use ApiResponse;

    function __construct() {}

    public function getProductList(){
        $data = Product::select('PK_NO as mp_id','DEFAULT_NAME as mp_name','PRIMARY_IMG_RELATIVE_PATH as mp_image','MODEL_NAME as mp_model', 'BRAND_NAME as mp_brand')->get();

        if (!empty($data)) {
            return $this->successResponse(200, 'Product list is available !', $data, 1);
        }
        return $this->successResponse(200, 'Data Not Found !', null, 0);
    }

    public function getVariantList($id){

        $data = DB::table('PRD_VARIANT_SETUP as v')
                    ->select('v.PK_NO','v.COMPOSITE_CODE as sku_id','v.BARCODE as barcode','v.MRK_ID_COMPOSITE_CODE as mkt_id','m.DEFAULT_NAME as product_name','v.VARIANT_NAME as product_variant_name','v.SIZE_NAME as size','v.COLOR as color','v.REGULAR_PRICE as price','v.INSTALLMENT_PRICE as ins_price','v.SEA_FREIGHT_CHARGE as sea_price', 'v.AIR_FREIGHT_CHARGE as air_price', 'v.PREFERRED_SHIPPING_METHOD as preferred_shipping_method', 'v.VAT_AMOUNT_PERCENT as vat', 'v.PRIMARY_IMG_RELATIVE_PATH as variant_primary_image','m.PRIMARY_IMG_RELATIVE_PATH as primary_image','v.INTER_DISTRICT_POSTAGE as ss_price','v.LOCAL_POSTAGE as sm_price'
                    ,DB::raw('(CASE WHEN v.PREFERRED_SHIPPING_METHOD = "AIR" THEN 1 ELSE 0 END) AS is_air')
                    ,DB::raw('(select ifnull(count(PK_NO),0) from PRD_VARIANT_SETUP where PREFERRED_SHIPPING_METHOD = "AIR" and F_PRD_MASTER_SETUP_NO = '.$id.') as is_air_count')
                    ,DB::raw('(select ifnull(count(PK_NO),0) from PRD_VARIANT_SETUP where PREFERRED_SHIPPING_METHOD = "SEA" and F_PRD_MASTER_SETUP_NO = '.$id.') as is_sea_count')
                    )
                    ->leftJoin('PRD_MASTER_SETUP as m', 'm.PK_NO', 'v.F_PRD_MASTER_SETUP_NO')
                    ->where('v.F_PRD_MASTER_SETUP_NO',$id)
                    ->get();

        if (count($data)>0) {
            return $this->successResponse(200, 'Product variant data is available !', $data, 1);
        }
        return $this->successResponse(200, 'Data Not Found !', null, 0);
    }

    public function getAllVariantList($request){
        $data = null;
        $barcode       = trim($request->barcode);
        $product_name  = trim($request->product_name);
        $mkt_id        = trim($request->mkt_id);
        $sku_id        = trim($request->sku_id);
        $data = DB::table('PRD_VARIANT_SETUP as v')
                ->select('v.PK_NO','v.COMPOSITE_CODE as sku_id','v.BARCODE as barcode','v.MRK_ID_COMPOSITE_CODE as mkt_id','m.DEFAULT_NAME as product_name','v.VARIANT_NAME as product_variant_name','v.SIZE_NAME as size','v.COLOR as color','v.REGULAR_PRICE as price','v.INSTALLMENT_PRICE as ins_price','v.SEA_FREIGHT_CHARGE as sea_price', 'v.AIR_FREIGHT_CHARGE as air_price', 'v.PREFERRED_SHIPPING_METHOD as preferred_shipping_method', 'v.VAT_AMOUNT_PERCENT as vat', 'v.PRIMARY_IMG_RELATIVE_PATH as variant_primary_image','m.PRIMARY_IMG_RELATIVE_PATH as primary_image','v.INTER_DISTRICT_POSTAGE as ss_price','v.LOCAL_POSTAGE as sm_price',
                DB::raw('(CASE WHEN v.PREFERRED_SHIPPING_METHOD = "AIR" THEN 1 ELSE 0 END) AS is_air'))
                ->leftJoin('PRD_MASTER_SETUP as m', 'm.PK_NO', 'v.F_PRD_MASTER_SETUP_NO');
                if (!empty($barcode) && $barcode != '') {
                    $data = $data->selectRaw('(select ifnull(count(PK_NO),0) from PRD_VARIANT_SETUP where PREFERRED_SHIPPING_METHOD = "AIR" and BARCODE = "'.$barcode.'") as is_air_count');
                    $data = $data->selectRaw('(select ifnull(count(PK_NO),0) from PRD_VARIANT_SETUP where PREFERRED_SHIPPING_METHOD = "SEA" and BARCODE = "'.$barcode.'") as is_sea_count');

                    $data = $data->where('v.BARCODE', $barcode);
                }else{
                    $pieces = explode(" ", $product_name);
                    if($pieces){
                        foreach ($pieces as $key => $piece) {
                            $data->where('v.VARIANT_NAME', 'LIKE', '%' . $piece . '%');
                            $data->where('v.KEYWORD_SEARCH', 'LIKE', '%' . $piece . '%');
                        }
                    }
                    $data = $data->selectRaw('(select ifnull(count(PK_NO),0) from PRD_VARIANT_SETUP where PREFERRED_SHIPPING_METHOD = "AIR" and VARIANT_NAME LIKE "%'.$product_name.'%" and COMPOSITE_CODE LIKE "%'.$sku_id.'%" and MRK_ID_COMPOSITE_CODE LIKE "%'.$mkt_id.'%") as is_air_count');

                    $data = $data->selectRaw('(select ifnull(count(PK_NO),0) from PRD_VARIANT_SETUP where PREFERRED_SHIPPING_METHOD = "SEA" and VARIANT_NAME LIKE "%'.$product_name.'%" and COMPOSITE_CODE LIKE "%'.$sku_id.'%" and MRK_ID_COMPOSITE_CODE LIKE "%'.$mkt_id.'%") as is_sea_count');

                    // $data = $data->where('v.VARIANT_NAME', 'like', '%' . $product_name . '%');
                    $data = $data->where('v.COMPOSITE_CODE', 'like', '%' . $sku_id . '%');
                    $data = $data->where('v.MRK_ID_COMPOSITE_CODE', 'like', '%' . $mkt_id . '%');
                }
                $data = $data->get();
                // echo '<pre>';
                // echo '======================<br>';
                // print_r($pieces);
                // echo '<br>======================<br>';
                // exit();
        if (count($data)>0) {
            return $this->successResponse(200, 'Variant is available !', $data, 1);
        }

        return $this->successResponse(200, 'Data Not Found !', null, 0);
    }

    public function getVariantImg($id){
        $data = ProdImgLib::select('RELATIVE_PATH as mp_image')->where('F_PRD_VARIANT_NO', $id)->get();
        if ($data->isEmpty()) {
            $data = ProductVariant::select('PRIMARY_IMG_RELATIVE_PATH as mp_image')->where('PK_NO', $id)->get();
        }

        if (count($data)>0) {
            return $this->successResponse(200, 'Variant Image is available !', $data, 1);
        }
        return $this->successResponse(200, 'Data Not Found !', null, 0);
    }

    public function getStockSearchList($request){
        $data = null;
        $user_map = DB::table('SS_INV_USER_MAP')->select('F_INV_WAREHOUSE_NO')->where('F_USER_NO', $request->user_id)->first();
        if (empty($user_map)) {
            return $this->successResponse(200, 'User Not Found !', null, 0);
        }
        $barcode       = trim($request->barcode);
        $product_name  = trim($request->product_name);
        $mkt_id        = trim($request->mkt_id);
        $sku_id        = trim($request->sku_id);
        $is_air = Stock::selectRaw('(select ifnull(count(PK_NO),0) from INV_STOCK where FINAL_PREFFERED_SHIPPING_METHOD = "AIR" and IG_CODE = mkt_id and F_INV_WAREHOUSE_NO = '.$user_map->F_INV_WAREHOUSE_NO.' and (PRODUCT_STATUS IS NULL OR PRODUCT_STATUS = 0 OR PRODUCT_STATUS = 90 OR PRODUCT_STATUS < 20))')->limit(1)->getQuery();

        $is_sea = Stock::selectRaw('(select ifnull(count(PK_NO),0) from INV_STOCK where FINAL_PREFFERED_SHIPPING_METHOD = "SEA" and IG_CODE = mkt_id and F_INV_WAREHOUSE_NO = '.$user_map->F_INV_WAREHOUSE_NO.' and (PRODUCT_STATUS IS NULL OR PRODUCT_STATUS = 0 OR PRODUCT_STATUS = 90 OR PRODUCT_STATUS < 20))')->limit(1)->getQuery();

        // if (!empty($request->barcode) && $request->barcode != '') {
            $data = DB::table('INV_STOCK as s')
                    ->select('s.INV_WAREHOUSE_NAME','v.PK_NO','v.COMPOSITE_CODE as sku_id','v.BARCODE as barcode','v.MRK_ID_COMPOSITE_CODE as mkt_id','v.VARIANT_NAME as product_variant_name','v.SIZE_NAME as size','v.COLOR as color','v.REGULAR_PRICE as price','v.INSTALLMENT_PRICE as ins_price', 'v.PRIMARY_IMG_RELATIVE_PATH as variant_primary_image', 'v.INTER_DISTRICT_POSTAGE as ss_price','v.LOCAL_POSTAGE as sm_price','s.FINAL_PREFFERED_SHIPPING_METHOD'
                    , DB::raw('count(s.PK_NO) as available_qty')
                    , DB::raw('(CASE WHEN s.FINAL_PREFFERED_SHIPPING_METHOD = "AIR" THEN 1 ELSE 0 END) AS is_air'))
                    ->join('PRD_VARIANT_SETUP as v', 'v.MRK_ID_COMPOSITE_CODE', 's.IG_CODE');
                    if (!empty($barcode) && $barcode != '') {
                        $data = $data->selectRaw('(select ifnull(count(PK_NO),0) from INV_STOCK where FINAL_PREFFERED_SHIPPING_METHOD = "AIR" and BARCODE = "'.$barcode.'" and F_INV_WAREHOUSE_NO = '.$user_map->F_INV_WAREHOUSE_NO.' and (PRODUCT_STATUS IS NULL OR PRODUCT_STATUS = 0 OR PRODUCT_STATUS = 90 OR PRODUCT_STATUS < 20)) as is_air_count');

                        $data = $data->selectRaw('(select ifnull(count(PK_NO),0) from INV_STOCK where FINAL_PREFFERED_SHIPPING_METHOD = "SEA" and BARCODE = "'.$barcode.'" and F_INV_WAREHOUSE_NO = '.$user_map->F_INV_WAREHOUSE_NO.' and (PRODUCT_STATUS IS NULL OR PRODUCT_STATUS = 0 OR PRODUCT_STATUS = 90 OR PRODUCT_STATUS < 20)) as is_sea_count');

                        $data = $data->where('s.BARCODE', $barcode);
                    }else{
                        $data = $data->selectSub($is_air, 'is_air_count');
                        $data = $data->selectSub($is_sea, 'is_sea_count');
                        $pieces = explode(" ", $product_name);
                        if($pieces){
                            foreach ($pieces as $key => $piece) {
                                $data->where('v.VARIANT_NAME', 'LIKE', '%' . $piece . '%');
                                $data->where('v.KEYWORD_SEARCH', 'LIKE', '%' . $piece . '%');
                            }
                        }
                        $data = $data->where('v.COMPOSITE_CODE', 'like', '%' . $mkt_id . '%');
                        $data = $data->where('v.MRK_ID_COMPOSITE_CODE', 'like', '%' . $sku_id . '%');
                    }
                    $data = $data->where('s.F_INV_WAREHOUSE_NO', $user_map->F_INV_WAREHOUSE_NO);

                    $data = $data->whereRaw('( s.PRODUCT_STATUS IS NULL OR s.PRODUCT_STATUS = 0 OR s.PRODUCT_STATUS = 90 OR s.PRODUCT_STATUS < 20 ) ');
                    $data = $data->groupBy('s.IG_CODE')->get();

        if ($data->count()>0) {
            return $this->successResponse(200, 'Variant is available !', $data, 1);
        }

        return $this->successResponse(200, 'Data Not Found !', null, 0);
    }

    public function getMerStockSearchList($request){
        $data = null;
        $user_map = DB::table('SS_INV_USER_MAP')->select('F_INV_WAREHOUSE_NO')->where('F_USER_NO', $request->user_id)->first();
        if (empty($user_map)) {
            return $this->successResponse(200, 'User Not Found !', null, 0);
        }
        $barcode       = trim($request->barcode);
        $product_name  = trim($request->product_name);
        $mkt_id        = trim($request->mkt_id);
        $sku_id        = trim($request->sku_id);
        $merchant_id   = $request->merchant_id;

        $is_air = MerStock::selectRaw('(select ifnull(count(PK_NO),0) from MER_INV_STOCK where FINAL_PREFFERED_SHIPPING_METHOD = "AIR" and IG_CODE = mkt_id and F_MERCHANT_NO = '.$merchant_id.' and (PRODUCT_STATUS IS NULL OR PRODUCT_STATUS = 0 OR PRODUCT_STATUS = 90 OR PRODUCT_STATUS < 20))')->limit(1)->getQuery();

        $is_sea = MerStock::selectRaw('(select ifnull(count(PK_NO),0) from MER_INV_STOCK where FINAL_PREFFERED_SHIPPING_METHOD = "SEA" and IG_CODE = mkt_id and F_MERCHANT_NO = '.$merchant_id.' and (PRODUCT_STATUS IS NULL OR PRODUCT_STATUS = 0 OR PRODUCT_STATUS = 90 OR PRODUCT_STATUS < 20))')->limit(1)->getQuery();

        // if (!empty($request->barcode) && $request->barcode != '') {
        $data = DB::table('MER_INV_STOCK as s')
                ->select('s.INV_WAREHOUSE_NAME','v.PK_NO','v.COMPOSITE_CODE as sku_id','v.BARCODE as barcode','v.MRK_ID_COMPOSITE_CODE as mkt_id','v.VARIANT_NAME as product_variant_name','v.SIZE_NAME as size','v.COLOR as color','s.MER_PRODUCT_PURCHASE_PRICE_GBP as price','s.MER_PRODUCT_PURCHASE_PRICE as ins_price', 'v.PRIMARY_IMG_RELATIVE_PATH as variant_primary_image', 'v.INTER_DISTRICT_POSTAGE as ss_price','v.LOCAL_POSTAGE as sm_price','s.FINAL_PREFFERED_SHIPPING_METHOD'
                , DB::raw('count(s.PK_NO) as available_qty')
                , DB::raw('(CASE WHEN s.FINAL_PREFFERED_SHIPPING_METHOD = "AIR" THEN 1 ELSE 0 END) AS is_air'))
                ->join('PRD_VARIANT_SETUP as v', 'v.MRK_ID_COMPOSITE_CODE', 's.IG_CODE');
                if (!empty($barcode) && $barcode != '') {
                    $data = $data->selectRaw('(select ifnull(count(PK_NO),0) from MER_INV_STOCK where FINAL_PREFFERED_SHIPPING_METHOD = "AIR" and BARCODE = "'.$barcode.'" and (PRODUCT_STATUS IS NULL OR PRODUCT_STATUS = 0 OR PRODUCT_STATUS = 90 OR PRODUCT_STATUS < 20)) as is_air_count');

                    $data = $data->selectRaw('(select ifnull(count(PK_NO),0) from MER_INV_STOCK where FINAL_PREFFERED_SHIPPING_METHOD = "SEA" and BARCODE = "'.$barcode.'" and (PRODUCT_STATUS IS NULL OR PRODUCT_STATUS = 0 OR PRODUCT_STATUS = 90 OR PRODUCT_STATUS < 20)) as is_sea_count');

                    $data = $data->where('s.BARCODE', $barcode);
                }else{
                    $data = $data->selectSub($is_air, 'is_air_count');
                    $data = $data->selectSub($is_sea, 'is_sea_count');
                    $pieces = explode(" ", $product_name);
                    if($pieces){
                        foreach ($pieces as $key => $piece) {
                            $data->where('v.VARIANT_NAME', 'LIKE', '%' . $piece . '%');
                            $data->where('v.KEYWORD_SEARCH', 'LIKE', '%' . $piece . '%');
                        }
                    }
                    $data = $data->where('v.COMPOSITE_CODE', 'like', '%' . $mkt_id . '%');
                    $data = $data->where('v.MRK_ID_COMPOSITE_CODE', 'like', '%' . $sku_id . '%');
                }
                // $data = $data->where('s.F_INV_WAREHOUSE_NO', $user_map->F_INV_WAREHOUSE_NO);
                $data = $data->where('s.F_MERCHANT_NO', $merchant_id);

                $data = $data->whereRaw('( s.PRODUCT_STATUS IS NULL OR s.PRODUCT_STATUS = 0 OR s.PRODUCT_STATUS = 90 OR s.PRODUCT_STATUS < 20 ) ');
                $data = $data->groupBy('s.IG_CODE')->get();

        if ($data->count()>0) {
            return $this->successResponse(200, 'Variant is available !', $data, 1);
        }

        return $this->successResponse(200, 'Data Not Found !', null, 0);
    }

    public function getAllStockSearchList($request){
        $data = [];
        $array = [];
        $user_map = DB::table('SS_INV_USER_MAP')->select('F_INV_WAREHOUSE_NO')->where('F_USER_NO', $request->user_id)->first();
        if (empty($user_map)) {
            return $this->successResponse(200, 'User Not Found !', null, 0);
        }
        $barcode       = trim($request->barcode);

        if (!empty($barcode) && $barcode != '') {
            $mer_data = DB::table('MER_INV_STOCK as s')
                ->select('v.PK_NO','v.COMPOSITE_CODE as sku_id','v.BARCODE as barcode','v.MRK_ID_COMPOSITE_CODE as mkt_id','v.VARIANT_NAME as product_variant_name','v.SIZE_NAME as size','v.COLOR as color','v.REGULAR_PRICE as price','v.INSTALLMENT_PRICE as ins_price', 'v.PRIMARY_IMG_RELATIVE_PATH as variant_primary_image', 'v.INTER_DISTRICT_POSTAGE as ss_price','v.LOCAL_POSTAGE as sm_price','s.FINAL_PREFFERED_SHIPPING_METHOD'
                , DB::raw('count(s.PK_NO) as mer_available_qty')
                , DB::raw('group_concat(DISTINCT s.F_MERCHANT_NO) as mer_list')
                , DB::raw('(CASE WHEN s.FINAL_PREFFERED_SHIPPING_METHOD = "AIR" THEN 1 ELSE 0 END) AS is_air'))
                ->join('PRD_VARIANT_SETUP as v', 'v.MRK_ID_COMPOSITE_CODE', 's.IG_CODE');
                    $mer_data = $mer_data->selectRaw('(select ifnull(count(PK_NO),0) from MER_INV_STOCK where FINAL_PREFFERED_SHIPPING_METHOD = "AIR" and BARCODE = "'.$barcode.'" and F_INV_WAREHOUSE_NO = '.$user_map->F_INV_WAREHOUSE_NO.' and (PRODUCT_STATUS IS NULL OR PRODUCT_STATUS = 0 OR PRODUCT_STATUS = 90 OR PRODUCT_STATUS < 20)) as is_air_count');

                    $mer_data = $mer_data->selectRaw('(select ifnull(count(PK_NO),0) from MER_INV_STOCK where FINAL_PREFFERED_SHIPPING_METHOD = "SEA" and BARCODE = "'.$barcode.'" and F_INV_WAREHOUSE_NO = '.$user_map->F_INV_WAREHOUSE_NO.' and (PRODUCT_STATUS IS NULL OR PRODUCT_STATUS = 0 OR PRODUCT_STATUS = 90 OR PRODUCT_STATUS < 20)) as is_sea_count');

                    $mer_data = $mer_data->where('s.BARCODE', $barcode);
                    $mer_data = $mer_data->where('s.F_INV_WAREHOUSE_NO', $user_map->F_INV_WAREHOUSE_NO);
                    $mer_data = $mer_data->whereRaw('( s.PRODUCT_STATUS IS NULL OR s.PRODUCT_STATUS = 0 OR s.PRODUCT_STATUS = 90 OR s.PRODUCT_STATUS < 20 ) ')->first();
        }
        if (!empty($barcode) && $barcode != '') {
            $azm_data = DB::table('INV_STOCK as s')
                ->select('v.PK_NO','v.COMPOSITE_CODE as sku_id','v.BARCODE as barcode','v.MRK_ID_COMPOSITE_CODE as mkt_id','v.VARIANT_NAME as product_variant_name','v.SIZE_NAME as size','v.COLOR as color','v.REGULAR_PRICE as price','v.INSTALLMENT_PRICE as ins_price', 'v.PRIMARY_IMG_RELATIVE_PATH as variant_primary_image', 'v.INTER_DISTRICT_POSTAGE as ss_price','v.LOCAL_POSTAGE as sm_price','s.FINAL_PREFFERED_SHIPPING_METHOD'
                , DB::raw('count(s.PK_NO) as azm_available_qty')
                , DB::raw('(CASE WHEN s.FINAL_PREFFERED_SHIPPING_METHOD = "AIR" THEN 1 ELSE 0 END) AS is_air'))
                ->join('PRD_VARIANT_SETUP as v', 'v.MRK_ID_COMPOSITE_CODE', 's.IG_CODE');
                    $azm_data = $azm_data->selectRaw('(select ifnull(count(PK_NO),0) from INV_STOCK where FINAL_PREFFERED_SHIPPING_METHOD = "AIR" and BARCODE = "'.$barcode.'" and F_INV_WAREHOUSE_NO = '.$user_map->F_INV_WAREHOUSE_NO.' and (PRODUCT_STATUS IS NULL OR PRODUCT_STATUS = 0 OR PRODUCT_STATUS = 90 OR PRODUCT_STATUS < 20)) as is_air_count');

                    $azm_data = $azm_data->selectRaw('(select ifnull(count(PK_NO),0) from INV_STOCK where FINAL_PREFFERED_SHIPPING_METHOD = "SEA" and BARCODE = "'.$barcode.'" and F_INV_WAREHOUSE_NO = '.$user_map->F_INV_WAREHOUSE_NO.' and (PRODUCT_STATUS IS NULL OR PRODUCT_STATUS = 0 OR PRODUCT_STATUS = 90 OR PRODUCT_STATUS < 20)) as is_sea_count');

                    $azm_data = $azm_data->where('s.BARCODE', $barcode);
                    $azm_data = $azm_data->where('s.F_INV_WAREHOUSE_NO', $user_map->F_INV_WAREHOUSE_NO);
                    $azm_data = $azm_data->whereRaw('( s.PRODUCT_STATUS IS NULL OR s.PRODUCT_STATUS = 0 OR s.PRODUCT_STATUS = 90 OR s.PRODUCT_STATUS < 20 ) ')->first();
        }
        if ((isset($azm_data) && !empty($azm_data->PK_NO)) || (isset($mer_data) && !empty($mer_data->PK_NO))) {
            $array = array('PK_NO' => $azm_data->PK_NO ?? $mer_data->PK_NO,'sku_id' => $azm_data->sku_id ?? $mer_data->sku_id, 'barcode' => $azm_data->barcode ?? $mer_data->barcode, 'mkt_id' => $azm_data->mkt_id ?? $mer_data->mkt_id, 'product_variant_name' => $azm_data->product_variant_name ?? $mer_data->product_variant_name, 'size' => $azm_data->size ?? $mer_data->size,'color' => $azm_data->color ?? $mer_data->color, 'price' => $azm_data->price ?? $mer_data->price, 'ins_price' => $azm_data->ins_price ?? $mer_data->ins_price, 'variant_primary_image' => $azm_data->variant_primary_image ?? $mer_data->variant_primary_image, 'ss_price' => $azm_data->ss_price ?? $mer_data->ss_price, 'sm_price' => $azm_data->sm_price ?? $mer_data->sm_price,'mer_available_qty' => $mer_data->mer_available_qty ?? 0, 'azm_available_qty' => $azm_data->azm_available_qty ?? 0,'is_air' => $azm_data->is_air ?? $mer_data->is_air,'is_air_count' => $azm_data->is_air_count + $mer_data->is_air_count,'is_sea_count' => $azm_data->is_sea_count + $mer_data->is_sea_count,'merchant_details' => array());
            // $data['data'][] = $array ?? [];
        }
        if (isset($mer_data) && !empty($mer_data->PK_NO)) {
            if ($mer_data->mer_list != '') {
                $merchant_list = explode(',',$mer_data->mer_list ?? '');
                foreach ($merchant_list as $key => $value) {
                    $mer_data = DB::table('MER_INV_STOCK as s')
                        ->select('m.NAME',DB::raw('count(s.PK_NO) as mer_available_qty'))
                        ->join('PRD_VARIANT_SETUP as v', 'v.MRK_ID_COMPOSITE_CODE', 's.IG_CODE')
                        ->join('SLS_MERCHANT as m', 'm.PK_NO', 's.F_MERCHANT_NO');
                        $mer_data = $mer_data->selectRaw('(select ifnull(count(PK_NO),0) from MER_INV_STOCK where FINAL_PREFFERED_SHIPPING_METHOD = "AIR" and BARCODE = "'.$barcode.'" and F_INV_WAREHOUSE_NO = '.$user_map->F_INV_WAREHOUSE_NO.' and F_MERCHANT_NO = '.$value.' and (PRODUCT_STATUS IS NULL OR PRODUCT_STATUS = 0 OR PRODUCT_STATUS = 90 OR PRODUCT_STATUS < 20)) as is_air_count');

                        $mer_data = $mer_data->selectRaw('(select ifnull(count(PK_NO),0) from MER_INV_STOCK where FINAL_PREFFERED_SHIPPING_METHOD = "SEA" and BARCODE = "'.$barcode.'" and F_INV_WAREHOUSE_NO = '.$user_map->F_INV_WAREHOUSE_NO.' and F_MERCHANT_NO = '.$value.' and (PRODUCT_STATUS IS NULL OR PRODUCT_STATUS = 0 OR PRODUCT_STATUS = 90 OR PRODUCT_STATUS < 20)) as is_sea_count');

                        $mer_data = $mer_data->where('s.BARCODE', $barcode)->where('F_MERCHANT_NO',$value);
                        $mer_data = $mer_data->where('s.F_INV_WAREHOUSE_NO', $user_map->F_INV_WAREHOUSE_NO);
                        $mer_data = $mer_data->whereRaw('( s.PRODUCT_STATUS IS NULL OR s.PRODUCT_STATUS = 0 OR s.PRODUCT_STATUS = 90 OR s.PRODUCT_STATUS < 20 ) ')->first();
                    if (isset($mer_data) && !empty($mer_data)) {
                        $merchant_array = array('merchant_name'=>$mer_data->NAME,'air_qty' => $mer_data->is_air_count,'sea_qty' => $mer_data->is_sea_count,'available_qty' => $mer_data->mer_available_qty);
                        $array['merchant_details'][] = $merchant_array;
                    }
                }
            }
        }
        if (count($array) > 0) {
            $data['data'][] = $array;
        }
        if (isset($data['data']) && count($data['data'])>0) {
            return (object) array(
                'status'        => 1,
                'success'       => true,
                'code'          => 200,
                'message'       => 'Variant is available !',
                'data'          => $data['data'],
            );
        }
        return $this->successResponse(200, 'Data Not Found !', [], 0);
    }

    public function postProductDetailsList($request)
    {
        $box_no = DB::table('SC_BOX')->select('PK_NO','F_INV_WAREHOUSE_NO')->where('PK_NO',$request->PK_NO)->first();
        if (empty($box_no)) {
            return $this->successResponse(200, 'Box not found !', null, 0);
        }
        $user_map = DB::table('SS_INV_USER_MAP')->select('F_INV_WAREHOUSE_NO')->where('F_USER_NO', $request->user_id)->first();

        if ($user_map->F_INV_WAREHOUSE_NO != $box_no->F_INV_WAREHOUSE_NO) {
            return $this->successResponse(200, 'Box not found !', null, 0);
        }

        $data = DB::table('INV_STOCK as s')
        ->select('v.PK_NO','s.INV_WAREHOUSE_NAME','v.PK_NO','v.COMPOSITE_CODE as sku_id','v.BARCODE as barcode','v.MRK_ID_COMPOSITE_CODE as mkt_id','v.VARIANT_NAME as product_variant_name','v.SIZE_NAME as size','v.COLOR as color','v.REGULAR_PRICE as price','v.INSTALLMENT_PRICE as ins_price','v.PRIMARY_IMG_RELATIVE_PATH as variant_primary_image', DB::raw('IFNULL(count(s.PK_NO),0) as given_qty'))
        ->join('PRD_VARIANT_SETUP as v', 'v.MRK_ID_COMPOSITE_CODE', 's.IG_CODE')
        ->where('F_INV_WAREHOUSE_NO',$box_no->F_INV_WAREHOUSE_NO)
        ->where('F_BOX_NO',$box_no->PK_NO)
        ->orderBy('s.PK_NO','DESC')
        ->groupBy('s.IG_CODE')->get();

        if (count($data)>0) {
            return $this->successResponse(200, 'Product List Found !', $data, 1);
        }
        return $this->successResponse(200, 'Box not found !', null, 0);
    }

    public function postProductSearchList($request)
    {
        $user_map = DB::table('SS_INV_USER_MAP')->select('F_INV_WAREHOUSE_NO')->where('F_USER_NO', $request->user_id)->first();
        if (empty($user_map)) {
            return $this->successResponse(200, 'Unauthorized Location!', null, 0);
        }
        $barcode       = trim($request->barcode);
        $product_name  = trim($request->product_name);
        $mkt_id        = trim($request->mkt_id);
        $sku_id        = trim($request->sku_id);
        $count_not_boxed = Stock::selectRaw('(SELECT IFNULL(COUNT(SKUID),0) from INV_STOCK where SKUID = sku_id and F_INV_WAREHOUSE_NO = '.$user_map->F_INV_WAREHOUSE_NO.' and (F_BOX_NO IS NULL OR F_BOX_NO = 0) and (PRODUCT_STATUS IS NULL OR PRODUCT_STATUS = 0 OR PRODUCT_STATUS = 90 OR PRODUCT_STATUS != 420))')->limit(1)->getQuery();

        $count_boxed = Stock::selectRaw('(SELECT IFNULL(COUNT(SKUID),0) from INV_STOCK where SKUID = sku_id and F_INV_WAREHOUSE_NO = '.$user_map->F_INV_WAREHOUSE_NO.' and PRODUCT_STATUS <= 50 and F_BOX_NO IS NOT NULL and (ORDER_STATUS IS NULL OR ORDER_STATUS < 80))')->limit(1)->getQuery();

        $count_shipped = Stock::selectRaw('(SELECT IFNULL(COUNT(SKUID),0) from INV_STOCK where SKUID = sku_id and F_INV_WAREHOUSE_NO = '.$user_map->F_INV_WAREHOUSE_NO.' and (F_SHIPPMENT_NO IS NOT NULL and F_BOX_NO IS NOT NULL) and (ORDER_STATUS IS NULL OR ORDER_STATUS < 80))')->limit(1)->getQuery();

        $count_shelved = Stock::selectRaw('(SELECT IFNULL(COUNT(SKUID),0) from INV_STOCK where SKUID = sku_id and F_INV_WAREHOUSE_NO = '.$user_map->F_INV_WAREHOUSE_NO.' and (F_INV_ZONE_NO IS NOT NULL))')->limit(1)->getQuery();

        $count_not_shelved = Stock::selectRaw('(SELECT IFNULL(COUNT(SKUID),0) from INV_STOCK where SKUID = sku_id and F_INV_WAREHOUSE_NO = '.$user_map->F_INV_WAREHOUSE_NO.' and (F_INV_ZONE_NO IS NULL and F_BOX_NO IS NOT NULL and F_SHIPPMENT_NO IS NOT NULL and PRODUCT_STATUS = 60))')->limit(1)->getQuery();

        $data = DB::table('INV_STOCK as s')
                ->select('v.PK_NO','v.COMPOSITE_CODE as sku_id','v.BARCODE as barcode','v.MRK_ID_COMPOSITE_CODE as mkt_id','v.VARIANT_NAME as product_variant_name','v.SIZE_NAME as size','v.COLOR as color','v.REGULAR_PRICE as price','v.INSTALLMENT_PRICE as ins_price','v.PRIMARY_IMG_RELATIVE_PATH as variant_primary_image','s.INV_WAREHOUSE_NAME as warehouse'
                ,DB::raw('IFNULL(COUNT(SKUID),0) as available_qty')
                ,DB::raw('(CASE WHEN s.FINAL_PREFFERED_SHIPPING_METHOD = "AIR" THEN 1 ELSE 0 END) AS is_air')
                )
                ->selectSub($count_boxed, 'boxed_qty')
                ->selectSub($count_not_boxed, 'yet_to_boxed_qty')
                ->selectSub($count_shipped, 'shipment_assigned_qty')
                // ->selectSub($count_shelved, 'shelved_qty')
                // ->selectSub($count_not_shelved, 'not_shelved_qty')
                ->join('PRD_VARIANT_SETUP as v', 'v.MRK_ID_COMPOSITE_CODE', 's.IG_CODE')
                ->where('s.F_INV_WAREHOUSE_NO', $user_map->F_INV_WAREHOUSE_NO)
                ->whereRaw('(s.ORDER_STATUS IS NULL OR s.ORDER_STATUS < 80)');
                if (!empty($barcode) && $barcode != ''){
                    $data = $data->where('s.BARCODE', $barcode);
                }else{
                    $pieces = explode(" ", $product_name);
                    if($pieces){
                        foreach ($pieces as $key => $piece) {
                            $data->where('v.VARIANT_NAME', 'LIKE', '%' . $piece . '%');
                            $data->where('v.KEYWORD_SEARCH', 'LIKE', '%' . $piece . '%');
                        }
                    }
                    // $data = $data->where('v.VARIANT_NAME', 'like', '%' . $product_name . '%');
                    $data = $data->where('v.COMPOSITE_CODE', 'like', '%' . $sku_id . '%');
                    $data = $data->where('v.MRK_ID_COMPOSITE_CODE', 'like', '%' . $mkt_id . '%');
                }
                $data = $data->groupBy('s.IG_CODE', 's.F_INV_WAREHOUSE_NO')
                ->take(150)
                ->get();

        if (count($data)>0) {
            return $this->successResponse(200, 'Product found !', $data, 1);
        }

        return $this->successResponse(200, 'Product not found !', null, 0);
    }

    public function postMerchantProductSearchList($request)
    {
        $user_map = DB::table('SS_INV_USER_MAP')->select('F_INV_WAREHOUSE_NO')->where('F_USER_NO', $request->user_id)->first();
        if (empty($user_map)) {
            return $this->successResponse(200, 'Unauthorized Location!', null, 0);
        }
        $barcode       = trim($request->barcode);
        $product_name  = trim($request->product_name);
        $mkt_id        = trim($request->mkt_id);
        $sku_id        = trim($request->sku_id);

        $count_not_boxed = MerStock::selectRaw('(SELECT IFNULL(COUNT(SKUID),0) from MER_INV_STOCK where SKUID = sku_id and F_MERCHANT_NO = '.$request->merchant_id.' and (F_BOX_NO IS NULL OR F_BOX_NO = 0) and (PRODUCT_STATUS IS NULL OR PRODUCT_STATUS = 0 OR PRODUCT_STATUS = 90 OR PRODUCT_STATUS != 420))')->limit(1)->getQuery();

        $count_boxed = MerStock::selectRaw('(SELECT IFNULL(COUNT(SKUID),0) from MER_INV_STOCK where SKUID = sku_id and F_MERCHANT_NO = '.$request->merchant_id.' and PRODUCT_STATUS <= 50 and F_BOX_NO IS NOT NULL)')->limit(1)->getQuery();

        $count_shipped = MerStock::selectRaw('(SELECT IFNULL(COUNT(SKUID),0) from MER_INV_STOCK where SKUID = sku_id and F_MERCHANT_NO = '.$request->merchant_id.' and (F_SHIPPMENT_NO IS NOT NULL and F_BOX_NO IS NOT NULL))')->limit(1)->getQuery();

        $data = DB::table('MER_INV_STOCK as s')
                ->select('v.PK_NO','v.COMPOSITE_CODE as sku_id','v.BARCODE as barcode','v.MRK_ID_COMPOSITE_CODE as mkt_id','v.VARIANT_NAME as product_variant_name','v.SIZE_NAME as size','v.COLOR as color','s.MER_PRODUCT_PURCHASE_PRICE_GBP as price','s.MER_PRODUCT_PURCHASE_PRICE as ins_price','v.PRIMARY_IMG_RELATIVE_PATH as variant_primary_image','s.INV_WAREHOUSE_NAME as warehouse'
                ,DB::raw('IFNULL(COUNT(SKUID),0) as available_qty')
                ,DB::raw('(CASE WHEN s.FINAL_PREFFERED_SHIPPING_METHOD = "AIR" THEN 1 ELSE 0 END) AS is_air')
                )
                ->selectSub($count_boxed, 'boxed_qty')
                ->selectSub($count_not_boxed, 'yet_to_boxed_qty')
                ->selectSub($count_shipped, 'shipment_assigned_qty')
                ->join('PRD_VARIANT_SETUP as v', 'v.MRK_ID_COMPOSITE_CODE', 's.IG_CODE')
                ->where('s.F_MERCHANT_NO', $request->merchant_id);
                // ->where('s.F_INV_WAREHOUSE_NO', $user_map->F_INV_WAREHOUSE_NO)
                if (!empty($barcode) && $barcode != ''){
                    $data = $data->where('s.BARCODE', $barcode);
                }else{
                    $pieces = explode(" ", $product_name);
                    if($pieces){
                        foreach ($pieces as $key => $piece) {
                            $data->where('v.VARIANT_NAME', 'LIKE', '%' . $piece . '%');
                            $data->where('v.KEYWORD_SEARCH', 'LIKE', '%' . $piece . '%');
                        }
                    }
                    // $data = $data->where('v.VARIANT_NAME', 'like', '%' . $product_name . '%');
                    $data = $data->where('v.COMPOSITE_CODE', 'like', '%' . $sku_id . '%');
                    $data = $data->where('v.MRK_ID_COMPOSITE_CODE', 'like', '%' . $mkt_id . '%');
                }
                $data = $data->groupBy('s.IG_CODE')
                ->take(150)
                ->get();

        if (count($data)>0) {
            return $this->successResponse(200, 'Product found !', $data, 1);
        }

        return $this->successResponse(200, 'Product not found !', null, 0);
    }

    public function postProductSearchListMy($request)
    {
        $user_map = DB::table('SS_INV_USER_MAP')->select('F_INV_WAREHOUSE_NO')->where('F_USER_NO', $request->user_id)->first();
        if (empty($user_map)) {
            return $this->successResponse(200, 'Unauthorized Location!', null, 0);
        }
        $barcode       = trim($request->barcode);
        $product_name  = trim($request->product_name);
        $mkt_id        = trim($request->mkt_id);
        $sku_id        = trim($request->sku_id);
        $count_boxed = Stock::selectRaw('(SELECT IFNULL(COUNT(SKUID),0) from INV_STOCK where SKUID = sku_id and F_INV_WAREHOUSE_NO = '.$user_map->F_INV_WAREHOUSE_NO.' and PRODUCT_STATUS <= 50 and (ORDER_STATUS IS NULL OR ORDER_STATUS < 80))')->limit(1)->getQuery();

        $count_shelved = Stock::selectRaw('(SELECT IFNULL(COUNT(SKUID),0) from INV_STOCK where SKUID = sku_id and F_INV_WAREHOUSE_NO = '.$user_map->F_INV_WAREHOUSE_NO.' and F_INV_ZONE_NO IS NOT NULL and (ORDER_STATUS IS NULL OR ORDER_STATUS < 80))')->limit(1)->getQuery();

        $count_not_shelved = Stock::selectRaw('(SELECT IFNULL(COUNT(SKUID),0) from INV_STOCK where SKUID = sku_id and F_INV_WAREHOUSE_NO = '.$user_map->F_INV_WAREHOUSE_NO.' and F_INV_ZONE_NO IS NULL and (ORDER_STATUS IS NULL OR ORDER_STATUS < 80))')->limit(1)->getQuery();

        $data = DB::table('INV_STOCK as s')
                ->select('v.PK_NO','v.COMPOSITE_CODE as sku_id','v.BARCODE as barcode','v.MRK_ID_COMPOSITE_CODE as mkt_id','v.VARIANT_NAME as product_variant_name','v.SIZE_NAME as size','v.COLOR as color','v.REGULAR_PRICE as price','v.INSTALLMENT_PRICE as ins_price','v.PRIMARY_IMG_RELATIVE_PATH as variant_primary_image','s.INV_WAREHOUSE_NAME as warehouse'
                ,DB::raw('IFNULL(COUNT(SKUID),0) as available_qty'),
                DB::raw('(CASE WHEN s.FINAL_PREFFERED_SHIPPING_METHOD = "AIR" THEN 1 ELSE 0 END) AS is_air')
                )
                ->selectSub($count_boxed, 'box_qty')
                ->selectSub($count_not_shelved, 'land_area_qty')
                ->selectSub($count_shelved, 'shelved_qty')
                ->join('PRD_VARIANT_SETUP as v', 'v.MRK_ID_COMPOSITE_CODE', 's.IG_CODE')
                ->where('s.F_INV_WAREHOUSE_NO', $user_map->F_INV_WAREHOUSE_NO)
                ->whereRaw('(s.ORDER_STATUS IS NULL OR s.ORDER_STATUS < 80)');
                if (!empty($barcode) && $barcode != ''){
                    $data = $data->where('s.BARCODE', $barcode);
                }else{
                    $pieces = explode(" ", $product_name);
                    if($pieces){
                        foreach ($pieces as $key => $piece) {
                            $data->where('v.VARIANT_NAME', 'LIKE', '%' . $piece . '%');
                            $data->where('v.KEYWORD_SEARCH', 'LIKE', '%' . $piece . '%');
                        }
                    }
                    // $data = $data->where('v.VARIANT_NAME', 'like', '%' . $product_name . '%');
                    $data = $data->where('v.COMPOSITE_CODE', 'like', '%' . $sku_id . '%');
                    $data = $data->where('v.MRK_ID_COMPOSITE_CODE', 'like', '%' . $mkt_id . '%');
                }
                $data = $data->groupBy('s.IG_CODE', 's.F_INV_WAREHOUSE_NO')
                ->take(150)
                ->get();

        if (count($data)>0) {
            return $this->successResponse(200, 'Product found !', $data, 1);
        }

        return $this->successResponse(200, 'Product not found !', null, 0);
    }

    public function postProductBoxLocation($request)
    {
        $user_map = DB::table('SS_INV_USER_MAP')->select('F_INV_WAREHOUSE_NO')->where('F_USER_NO', $request->user_id)->first();
        if (empty($user_map)) {
            return $this->successResponse(200, 'Unauthorized Location!', null, 0);
        }
        // $user = DB::table('SA_USER')->select('F_MERCHANT_NO')->where('PK_NO', $request->user_id)->first();
        if ($request->merchant_id > 0) {
            $data = DB::table('MER_INV_STOCK as s')
                    ->select('b.PK_NO','b.BOX_NO as box_label','b.BOX_STATUS as status','s.INV_WAREHOUSE_NAME as warehouse','s.F_BOX_NO as box_id'
                    ,DB::raw('(SELECT IFNULL(COUNT(F_BOX_NO),0) from MER_INV_STOCK where SKUID = '.$request->sku_id.' and F_MERCHANT_NO = '.$request->merchant_id.' and F_BOX_NO = box_id and F_BOX_NO IS NOT NULL) as product_count'))
                    ->join('SC_BOX as b', 'b.PK_NO', 's.F_BOX_NO')
                    ->where('s.SKUID', $request->sku_id)
                    ->where('s.F_MERCHANT_NO',$request->merchant_id)
                    ->whereNotNull('s.F_BOX_NO')
                    ->groupBy('s.F_BOX_NO')
                    ->get();
        }else{
            $data = DB::table('INV_STOCK as s')
                    ->select('b.PK_NO','b.BOX_NO as box_label','b.BOX_STATUS as status','s.INV_WAREHOUSE_NAME as warehouse','s.F_BOX_NO as box_id'
                    ,DB::raw('(SELECT IFNULL(COUNT(F_BOX_NO),0) from INV_STOCK where SKUID = '.$request->sku_id.' and F_INV_WAREHOUSE_NO = '.$user_map->F_INV_WAREHOUSE_NO.' and F_BOX_NO = box_id and F_BOX_NO IS NOT NULL) as product_count'))
                    ->join('SC_BOX as b', 'b.PK_NO', 's.F_BOX_NO')
                    ->where('s.SKUID', $request->sku_id)
                    ->where('s.F_INV_WAREHOUSE_NO',$user_map->F_INV_WAREHOUSE_NO)
                    ->whereNotNull('s.F_BOX_NO')
                    ->groupBy('s.F_BOX_NO')
                    ->get();
        }

                if (count($data)>0) {
                    return $this->successResponse(200, 'Product details found !', $data, 1);
                }
                return $this->successResponse(200, 'Product details not found !', null, 0);
    }

    public function postProductSearchListDetailsMy($request)
    {
        $user_map = DB::table('SS_INV_USER_MAP')->select('F_INV_WAREHOUSE_NO')->where('F_USER_NO', $request->user_id)->first();
        if (empty($user_map)) {
            return $this->successResponse(200, 'Unauthorized Location!', null, 0);
        }
        $count_boxed = Stock::selectRaw('(SELECT IFNULL(COUNT(F_BOX_NO),0) from INV_STOCK where SKUID = '.$request->sku_id.' and F_INV_WAREHOUSE_NO = 2 and PRODUCT_STATUS <= 50 and F_BOX_NO = box_id and F_BOX_NO IS NOT NULL)')->limit(1)->getQuery();
        $count_land = Stock::selectRaw('(SELECT IFNULL(COUNT(PK_NO),0) from INV_STOCK where SKUID = '.$request->sku_id.' and F_INV_WAREHOUSE_NO = 2 and (PRODUCT_STATUS != 420 OR PRODUCT_STATUS = 60 OR PRODUCT_STATUS IS NULL) and F_INV_ZONE_NO IS NULL)')->limit(1)->getQuery();
        $count_shelved = Stock::selectRaw('(SELECT IFNULL(COUNT(PK_NO),0) from INV_STOCK where SKUID = '.$request->sku_id.' and F_INV_WAREHOUSE_NO = 2 and F_INV_ZONE_NO = zone_no and F_INV_ZONE_NO IS NOT NULL)')->limit(1)->getQuery();

        $data = DB::table('INV_STOCK as s')
                ->select('s.PK_NO','s.INV_WAREHOUSE_NAME as warehouse','s.F_BOX_NO as box_id','s.BOX_BARCODE','s.INV_ZONE_BARCODE','s.F_INV_ZONE_NO as zone_no'
                ,DB::raw('(select ifnull(wz.DESCRIPTION,"Product Is In Landing Area")) as description')
                )
                ->leftjoin('INV_WAREHOUSE_ZONES as wz', 'wz.PK_NO', 's.F_INV_ZONE_NO')
                ->selectSub($count_boxed, 'qty1')
                ->selectSub($count_land, 'qty2')
                ->selectSub($count_shelved, 'qty3')
                ->where('s.SKUID', $request->sku_id)
                ->where('s.F_INV_WAREHOUSE_NO',2)
                ->groupBy('s.F_INV_ZONE_NO')
                ->get();

        foreach ($data as $key => $value) {
            if ($value->qty1 > 0) {
                $value->type    = 1;
                $value->label   = $value->BOX_BARCODE;
                $value->qty     = $value->qty1;
            }
            if ($value->qty2 > 0 && $value->INV_ZONE_BARCODE == '') {
                $value->type    = 2;
                $value->label   = 'land';
                $value->qty     = $value->qty2;
            }else {
                $value->type    = 3;
                $value->label   = $value->INV_ZONE_BARCODE;
                $value->qty     = $value->qty3;
            }
        }
        if (count($data)>0) {
            return $this->successResponse(200, 'Product details found !', $data, 1);
        }
        return $this->successResponse(200, 'Product details not found !', null, 0);
    }



    public function postProductStockList($request)
    {
        $user_map = DB::table('SS_INV_USER_MAP')->select('F_INV_WAREHOUSE_NO')->where('F_USER_NO', $request->user_id)->first();
        if (empty($user_map)) {
            return $this->successResponse(200, 'Unauthorized Location!', null, 0);
        }

        $barcode       = trim($request->barcode);
        $product_name  = trim($request->product_name);
        $mkt_id        = trim($request->mkt_id);
        $sku_id        = trim($request->sku_id);
        $data = [];
        if($barcode == '' && $product_name == '' && $mkt_id == '' && $sku_id == ''){
            return $this->successResponse(200, 'Product not found !', $data, 0);
        }


            $uk_stock = Stock::selectRaw('(SELECT IFNULL(COUNT(SKUID),0) from INV_STOCK where SKUID = SKU_ID and F_INV_WAREHOUSE_NO = 1 and F_SHIPPMENT_NO IS NULL)')->limit(1)->getQuery();

            $uk_stock_sold = Stock::selectRaw('(SELECT IFNULL(COUNT(SKUID),0) from INV_STOCK where SKUID = SKU_ID and F_INV_WAREHOUSE_NO = 1 and F_SHIPPMENT_NO IS NULL and BOOKING_STATUS IS NOT NULL )')->limit(1)->getQuery();

            $my_stock = Stock::selectRaw('(SELECT IFNULL(COUNT(SKUID),0) from INV_STOCK where SKUID = SKU_ID and F_INV_WAREHOUSE_NO = 2 and ( ORDER_STATUS != 80 or ORDER_STATUS IS NULL )  )')->limit(1)->getQuery();

            $my_stock_sold = Stock::selectRaw('(SELECT IFNULL(COUNT(SKUID),0) from INV_STOCK where SKUID = SKU_ID  and F_INV_WAREHOUSE_NO = 2 and ORDER_STATUS != 80 AND BOOKING_STATUS IS NOT NULL  )')->limit(1)->getQuery();

            $dispatch_qty = Stock::selectRaw('(SELECT IFNULL(COUNT(SKUID),0) from INV_STOCK where SKUID = SKU_ID and  ORDER_STATUS = 80 )')->limit(1)->getQuery();

            $total_sold_stock = Stock::selectRaw('(SELECT IFNULL(COUNT(SKUID),0) from INV_STOCK where SKUID = SKU_ID and BOOKING_STATUS IS NOT NULL and ORDER_STATUS != 80 )')->limit(1)->getQuery();

            $unsold_stock_avg_price = Stock::selectRaw('(SELECT AVG(PRODUCT_PURCHASE_PRICE_GBP) AS AVG_PRICE from INV_STOCK where SKUID = SKU_ID and (BOOKING_STATUS IS NULL OR BOOKING_STATUS = 90))')->limit(1)->getQuery();


            $product = DB::table('INV_STOCK as s')
                    ->select('v.PK_NO','v.COMPOSITE_CODE as SKU_ID','v.BARCODE','v.MRK_ID_COMPOSITE_CODE as MKT_ID','v.VARIANT_NAME','v.REGULAR_PRICE','v.INSTALLMENT_PRICE', 'v.PRIMARY_IMG_RELATIVE_PATH',
                    DB::raw('SUM(s.PRODUCT_PURCHASE_PRICE_GBP) AS TOTAL_PRICE'),
                    DB::raw('MIN(s.PRODUCT_PURCHASE_PRICE_GBP) AS MIN_PRICE'),
                    DB::raw('MAX(s.PRODUCT_PURCHASE_PRICE_GBP) AS MAX_PRICE'),
                    DB::raw('COUNT(*) AS TOTAL_QTY'))
                    ->selectSub($dispatch_qty, 'TOTAL_QTY_DISPATCHED')
                    ->selectSub($total_sold_stock, 'TOTAL_QTY_SOLD')
                    ->selectSub($my_stock, 'MY_QTY')
                    ->selectSub($my_stock_sold, 'MY_QTY_SOLD')
                    ->selectSub($uk_stock, 'UK_QTY')
                    ->selectSub($uk_stock_sold, 'UK_QTY_SOLD')
                    ->selectSub($unsold_stock_avg_price, 'AVG_PRICE_UNSOLD')
                    // ->whereNull('s.ORDER_STATUS')
                    ->whereRaw('( s.ORDER_STATUS IS NULL OR s.ORDER_STATUS  < 80 ) ')
                    ->join('PRD_VARIANT_SETUP as v', 'v.PK_NO', 's.F_PRD_VARIANT_NO');

                    if (!empty($barcode) && $barcode != ''){
                        $product = $product->where('s.BARCODE', $barcode);
                    }else{
                        $pieces = explode(" ", $product_name);
                        if($pieces){
                            foreach ($pieces as $key => $piece) {
                                $product->where('v.VARIANT_NAME', 'LIKE', '%' . $piece . '%');
                            }
                        }
                        $product = $product->where('v.COMPOSITE_CODE', 'like', '%' . $sku_id . '%');
                        $product = $product->where('v.MRK_ID_COMPOSITE_CODE', 'like', '%' . $mkt_id . '%');
                    }
                    $product = $product->groupBy('s.F_PRD_VARIANT_NO')
                    ->take(50)
                    ->get();

                    $intransit_sold = Stock::selectRaw('(SELECT IFNULL(COUNT(SKUID),0) from INV_STOCK where F_SHIPPMENT_NO = SHIPPMENT_NO and  PRODUCT_STATUS < 60 and F_PRD_VARIANT_NO = VARIANT_NO and BOOKING_STATUS IS NOT NULL )')->limit(1)->getQuery();

                    if($product){
                        foreach ($product as $key => $value) {
                            if($value->AVG_PRICE_UNSOLD == null){
                                $value->AVG_PRICE_UNSOLD = $value->TOTAL_PRICE/$value->TOTAL_QTY;
                            }
                            $value->INTRANSIT = Stock::select('INV_STOCK.F_PRD_VARIANT_NO as VARIANT_NO','INV_STOCK.F_SHIPPMENT_NO as SHIPPMENT_NO','INV_STOCK.SHIPMENT_NAME','INV_STOCK.SHIPMENT_TYPE','SC_SHIPMENT.SCH_ARRIVAL_DATE',DB::raw('COUNT(*) AS TOTAL_QTY'))
                            ->selectSub($intransit_sold, 'TOTAL_QTY_SOLD')
                            ->leftJoin('SC_SHIPMENT','SC_SHIPMENT.PK_NO','INV_STOCK.F_SHIPPMENT_NO')
                            ->where('INV_STOCK.F_PRD_VARIANT_NO', $value->PK_NO)
                            ->whereNotNull('INV_STOCK.F_SHIPPMENT_NO')
                            ->where('INV_STOCK.PRODUCT_STATUS', '<', '60')
                            ->where('INV_STOCK.F_INV_WAREHOUSE_NO', '1')
                            ->groupBy('INV_STOCK.F_SHIPPMENT_NO')
                            ->get();
                        }
                    }
                $data = $product;




        if (count($data)>0) {
            return $this->successResponse(200, 'Product found !', $data, 1);
        }

        return $this->successResponse(200, 'Product not found !', $data, 0);
    }


}
