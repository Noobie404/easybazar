<?php
namespace App\Repositories\Admin\Stock;

use DB;
use Auth;
use App\Models\Stock;
use App\Models\Shipmentbox;
use App\Traits\RepoResponse;

class StockAbstract implements StockInterface
{
    use RepoResponse;
    protected $stock;

    public function __construct(Stock $stock)
    {
        $this->stock = $stock;

    }


    public function getAllStockList($request, int $per_page = 50)
    {
        $category = $request->category;
        $subcategory = $request->subcategory;
        $subsubcategory =$request->subsubcategory;
        if(!empty($subsubcategory)){
            $category_id = $subsubcategory;
        }elseif($subcategory){
            $category_id = $subcategory;
        }else{
            $category_id = $category;
        }
        $sku_id =   $request->sku_id;
        $barcode =  $request->barcode;
        $brand =  $request->brand;
        $is_active =  $request->is_active;
        $shop_id = $request->shop_id;
        $data = [];
        try {
            $data = $this->stock->select(
                'INV_STOCK.PK_NO',
                'INV_STOCK.SKUID',
                'INV_STOCK.IG_CODE',
                'INV_STOCK.BARCODE',
                'INV_STOCK.PRD_VARINAT_NAME',
                'PRD_VARIANT_SETUP.PRIMARY_IMG_RELATIVE_PATH',
                'PRD_VARIANT_SETUP.THUMB_PATH',
                'INV_STOCK.SHOP_NAME',
                'INV_STOCK.F_SHOP_NO',
                'INV_STOCK.F_PRD_VARIANT_NO',
                'PRD_VARIANT_SETUP.REGULAR_PRICE',
                'PRD_VARIANT_SETUP.INSTALLMENT_PRICE',
                'PRD_VARIANT_SETUP.SPECIAL_PRICE',
                'PRD_VARIANT_SETUP.WHOLESALE_PRICE',
                'INV_STOCK.F_CATEGORY_NO'
                )
            ->leftJoin('PRD_VARIANT_SETUP', 'PRD_VARIANT_SETUP.PK_NO', 'INV_STOCK.F_PRD_VARIANT_NO');

            if(Auth::user()->USER_TYPE == 0){
                if(!empty($shop_id)){
                    $data = $data->where('F_SHOP_NO',$shop_id);
                }
            }else{
                $shop_id = Auth::user()->SHOP_ID;
                $data = $data->where('F_SHOP_NO',$shop_id);
            }

            if(!empty($category_id)){
                $data = $data->where('INV_STOCK.F_CATEGORY_NO',$category_id);
            }

            if(!empty($sku_id)){
                $data = $data->where('INV_STOCK.SKUID',$sku_id);
            }

            if(!empty($barcode)){
                $data = $data->where('INV_STOCK.BARCODE',$barcode);
            }
            if(!empty($brand)){
                $data = $data->leftJoin('PRD_MASTER_SETUP','PRD_MASTER_SETUP.PK_NO','=','PRD_VARIANT_SETUP.F_PRD_MASTER_SETUP_NO')
                ->leftJoin('PRD_MASTER_ATTRIBUTE_RELATIONS','PRD_MASTER_ATTRIBUTE_RELATIONS.F_PRD_MASTER_SETUP_NO','=','PRD_MASTER_SETUP.PK_NO')
                ->where('PRD_MASTER_ATTRIBUTE_RELATIONS.F_ATTRIBUTE_MASTER',38)
                ->where('PRD_MASTER_ATTRIBUTE_RELATIONS.F_ATTRIBUTE_CHILD',$brand);
            }

            if($request->keywords != ''){
                if($request->shop_id != ''){
                    $data = $data->where('INV_STOCK.F_SHOP_NO', $request->shop_id);
                }
                if($request->keywords != ''){
                    $pieces = explode(" ", $request->keywords);
                    if($pieces){
                        foreach ($pieces as $key => $piece) {
                            $data->Where('INV_STOCK.PRD_VARINAT_NAME', 'LIKE', '%' . $piece . '%');
                        }
                    }
                    $search = $request->keywords;
                    $data->orWhere(function($query) use ($search){
                        $query->where('INV_STOCK.SKUID', 'LIKE', '%'.$search.'%');
                    });
                    $data->orWhere(function($query) use ($search){
                        $query->where('INV_STOCK.BARCODE', 'LIKE', '%'.$search.'%');
                    });
                }
            }

                $data = $data->groupBy('INV_STOCK.SKUID', 'INV_STOCK.F_SHOP_NO')->paginate($per_page);

                if(!empty($data) && count($data)> 0){
                    foreach ($data as $k => $value1) {
                        $ordered                = 0;
                        $dispatched             = 0;
                        $available              = 0;
                        $stock = [];
                        $stock = Stock::select('PK_NO', 'SKUID', 'IG_CODE', 'BARCODE', 'PRD_VARINAT_NAME', 'PRD_VARIANT_IMAGE_PATH', 'SHOP_NAME', 'F_SHOP_NO', 'F_INV_ZONE_NO', 'PRODUCT_STATUS', 'BOOKING_STATUS')->where('IG_CODE',$value1->IG_CODE)
                        ->where('F_SHOP_NO',$value1->F_SHOP_NO)
                        ->whereRaw('(PRODUCT_STATUS IS NULL OR PRODUCT_STATUS != 420)')
                        ->get();
                        if(!empty($stock)){
                            foreach ($stock as $l => $value2) {
                                if( ($value2->IG_CODE == $value1->IG_CODE) && ($value2->F_SHOP_NO == $value1->F_SHOP_NO ) && ($value2->BOOKING_STATUS >= 10) && ($value2->BOOKING_STATUS <= 80) ){
                                    $ordered += 1;
                                }
                                if( ($value2->IG_CODE == $value1->IG_CODE) && ($value2->F_SHOP_NO == $value1->F_SHOP_NO ) ){
                                    $available += 1;
                                }
                                if( ($value2->IG_CODE == $value1->IG_CODE) && ($value2->F_SHOP_NO == $value1->F_SHOP_NO ) && ($value2->ORDER_STATUS >= 80)){
                                    $dispatched += 1;
                                }
                            }
                        }
                        $value1->ORDERED                = $ordered ;
                        $value1->DISPATCHED             = $dispatched ;
                        $value1->COUNTER                = $available ;
                    }
                }
        } catch (\Exception $th) {

            return $th->getMessage();
        }
        return $this->formatResponse(true, '', 'admin.stock.index', $data);
    }


    public function getStockDetail($request)
    {
        $data = '';
        if ($request->type == 'boxed') {
            $data = DB::table('INV_STOCK as s')
            ->select('s.F_BOX_NO as box_id', 'b.BOX_NO as label'
            , DB::raw('(SELECT IFNULL(COUNT(F_BOX_NO),0) from INV_STOCK where SKUID = '.$request->sku_id.' and F_INV_WAREHOUSE_NO = '.$request->warehouse_no.' and F_BOX_NO = box_id and F_BOX_NO IS NOT NULL and F_SHIPPMENT_NO IS NULL and (ORDER_STATUS < 80 OR ORDER_STATUS IS NULL)) as qty'))
            ->join('SC_BOX as b', 'b.PK_NO', 's.F_BOX_NO')
            ->where('s.SKUID', $request->sku_id)
            ->where('s.F_INV_WAREHOUSE_NO',$request->warehouse_no)
            ->whereNotNull('s.F_BOX_NO')
            ->whereRaw('(ORDER_STATUS < 80 OR ORDER_STATUS IS NULL)')
            ->whereNull('s.F_SHIPPMENT_NO')
            ->groupBy('s.F_BOX_NO')
            ->get();
        }else if ($request->type == 'shipped') {
            $data = Stock::select('SHIPMENT_NAME as label', 'F_SHIPPMENT_NO as shipment_no'
            , DB::raw('(SELECT IFNULL(COUNT(F_SHIPPMENT_NO),0) from INV_STOCK where SKUID = '.$request->sku_id.' and F_INV_WAREHOUSE_NO = '.$request->warehouse_no.' and F_SHIPPMENT_NO = shipment_no and F_SHIPPMENT_NO IS NOT NULL and (ORDER_STATUS < 80 OR ORDER_STATUS IS NULL)) as qty'))
            ->where('SKUID', $request->sku_id)
            ->where('F_INV_WAREHOUSE_NO',$request->warehouse_no)
            ->whereRaw('(ORDER_STATUS < 80 OR ORDER_STATUS IS NULL)')
            ->whereNotNull('F_SHIPPMENT_NO')
            ->groupBy('F_SHIPPMENT_NO')
            ->get();
        }else if ($request->type == 'shelved') {
            $data = DB::table('INV_STOCK')
            ->select('INV_STOCK.INV_ZONE_BARCODE as label', 'INV_STOCK.F_INV_ZONE_NO as shelve_no','INV_WAREHOUSE_ZONES.DESCRIPTION'
            , DB::raw('(SELECT IFNULL(COUNT(F_INV_ZONE_NO),0) from INV_STOCK where SKUID = '.$request->sku_id.' and F_INV_WAREHOUSE_NO = '.$request->warehouse_no.' and F_INV_ZONE_NO = shelve_no and F_INV_ZONE_NO IS NOT NULL and (ORDER_STATUS < 80 OR ORDER_STATUS IS NULL)) as qty'))
            ->join('INV_WAREHOUSE_ZONES','INV_WAREHOUSE_ZONES.PK_NO','INV_STOCK.F_INV_ZONE_NO')
            ->where('INV_STOCK.SKUID', $request->sku_id)
            ->where('INV_STOCK.F_INV_WAREHOUSE_NO',$request->warehouse_no)
            ->whereRaw('(ORDER_STATUS < 80 OR ORDER_STATUS IS NULL)')
            ->whereNotNull('INV_STOCK.F_INV_ZONE_NO')
            ->groupBy('INV_STOCK.F_INV_ZONE_NO')
            ->get();

        }else if ($request->type == 'shipped_invoice') {
            $box_label = Shipmentbox::selectRaw('(SELECT BOX_SERIAL FROM SC_SHIPMENT_BOX WHERE F_BOX_NO = f_box_no1)')->limit(1)->getQuery();
            $box_count = Stock::selectRaw('(SELECT IFNULL(COUNT(F_BOX_NO),0) from INV_STOCK where F_PRC_STOCK_IN_NO = '.$request->invoice_no.' and F_SHIPPMENT_NO = '.$request->shipment_no.' and F_BOX_NO = f_box_no1 and F_INV_WAREHOUSE_NO = '.$request->warehouse_no.' and (ORDER_STATUS < 80 OR ORDER_STATUS IS NULL))')->limit(1)->getQuery();
            $data = Stock::select('F_BOX_NO as f_box_no1', 'BOX_BARCODE'
            )
            ->selectSub($box_label, 'BOX_SERIAL')
            ->selectSub($box_count, 'qty')
            ->where('F_PRC_STOCK_IN_NO', $request->invoice_no)
            ->where('F_SHIPPMENT_NO',$request->shipment_no)
            ->where('F_INV_WAREHOUSE_NO',$request->warehouse_no)
            ->whereRaw('(ORDER_STATUS < 80 OR ORDER_STATUS IS NULL)')
            ->groupBy('F_BOX_NO')->get();
            return view('admin.shipment._product_modal_content')->withData($data)->withType($request->type)->render();

        }else if ($request->type == 'booked') {

            $data = Stock::select('INV_STOCK.F_BOOKING_NO as f_booking_no1','b.BOOKING_NO','b.CUSTOMER_NAME','b.F_CUSTOMER_NO','INV_STOCK.SHOP_NAME','INV_STOCK.F_SHOP_NO','b.BOOKING_STATUS', DB::raw('(SELECT IFNULL(COUNT(PK_NO),0) from INV_STOCK where F_BOOKING_NO = f_booking_no1 and F_SHOP_NO = '.$request->warehouse_no.' and (BOOKING_STATUS < 80 OR BOOKING_STATUS IS NULL) and SKUID = '.$request->sku_id.' and BOOKING_STATUS between 10 and 80) as order_qty')
            )
            ->join('SLS_BOOKING as b','b.PK_NO','INV_STOCK.F_BOOKING_NO')
            ->whereRaw('b.BOOKING_STATUS between 10 and 80')
            ->where('INV_STOCK.SKUID', $request->sku_id)
            ->where('INV_STOCK.F_SHOP_NO',$request->warehouse_no);

            // if (Auth::user()->F_AGENT_NO > 0) {
            //     $data = $data->where('b.F_SHOP_NO',Auth::user()->F_AGENT_NO);
            // }

            $data = $data->whereRaw('(INV_STOCK.BOOKING_STATUS < 80 OR INV_STOCK.BOOKING_STATUS IS NULL)')
            ->groupBy('INV_STOCK.F_BOOKING_NO')
            ->get();
            // dd($data);


        }else if ($request->type == 'dispatched') {
            $data = Stock::select('INV_STOCK.F_BOOKING_NO as f_booking_no1','b.BOOKING_NO','b.CUSTOMER_NAME','b.F_CUSTOMER_NO','INV_STOCK.SHOP_NAME','INV_STOCK.F_SHOP_NO','b.BOOKING_STATUS',
            DB::raw('(SELECT IFNULL(COUNT(PK_NO),0) from INV_STOCK where F_BOOKING_NO = f_booking_no1 and F_SHOP_NO = '.$request->warehouse_no.' and SKUID = '.$request->sku_id.'  and BOOKING_STATUS = 100) as order_qty')
            )
            ->join('SLS_BOOKING as b','b.PK_NO','INV_STOCK.F_BOOKING_NO')
            ->where('INV_STOCK.SKUID', $request->sku_id)
            ->where('INV_STOCK.F_SHOP_NO',$request->warehouse_no)
            ->where('INV_STOCK.BOOKING_STATUS','=',100)
            ->groupBy('INV_STOCK.F_BOOKING_NO')
            ->get();
        }
        $warehouse = $request->warehouse_no ?? '';
        return view('admin.shelve._product_modal_content')->withData($data)->withType($request->type)->withWarehouse($warehouse)->withSkuid($request->sku_id)->render();
    }









}
