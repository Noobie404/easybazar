<?php
namespace App\Repositories\Admin\Shelve;

use DB;
use Auth;
use App\Models\Stock;
use App\Models\Booking;
use App\Models\MerStock;
use App\Models\Warehouse;
use App\Models\Shipmentbox;
use App\Traits\RepoResponse;
use App\Models\WarehouseZone;

class ShelveAbstract implements ShelveInterface
{
    use RepoResponse;

    protected $stock;
    protected $warehousezone;

    public function __construct(Stock $stock, WarehouseZone $warehousezone)
    {
        $this->stock = $stock;
        $this->warehousezone = $warehousezone;
    }

    public function getUnshalvedItems()
    {
        $data = $this->stock->select('PK_NO','SKUID','PRD_VARINAT_NAME','INV_WAREHOUSE_NAME','PRODUCT_STATUS','PRC_IN_IMAGE_PATH',DB::raw('IFNULL(count(SKUID),0) as count'))->where('PRODUCT_STATUS', '>=', 60)->groupBy('SKUID')->orderBy('PK_NO','DESC')->get();

        return $this->formatResponse(true, '', 'admin.unshalved.list', $data);
    }

    public function getAllProduct($request, int $per_page = 50)
    {
        $dataSet = [];
        try {

            $dataSet = $this->stock->select('INV_STOCK.PK_NO', 'INV_STOCK.SKUID', 'INV_STOCK.IG_CODE', 'INV_STOCK.BARCODE', 'INV_STOCK.PRD_VARINAT_NAME', 'PRD_VARIANT_SETUP.PRIMARY_IMG_RELATIVE_PATH','PRD_VARIANT_SETUP.THUMB_PATH', 'INV_STOCK.SHOP_NAME', 'INV_STOCK.F_SHOP_NO','INV_STOCK.F_PRD_VARIANT_NO','PRD_VARIANT_SETUP.REGULAR_PRICE','PRD_VARIANT_SETUP.INSTALLMENT_PRICE','PRD_VARIANT_SETUP.SPECIAL_PRICE','PRD_VARIANT_SETUP.WHOLESALE_PRICE')
            ->leftJoin('PRD_VARIANT_SETUP', 'PRD_VARIANT_SETUP.PK_NO', 'INV_STOCK.F_PRD_VARIANT_NO');

            if($request->shop_id){
                $dataSet = $dataSet->where('F_SHOP_NO',$request->shop_id);
            }

            if($request->keywords != ''){

                if($request->shop_id != ''){
                    $dataSet = $dataSet->where('INV_STOCK.F_SHOP_NO', $request->shop_id);
                }
                if($request->keywords != ''){
                    $pieces = explode(" ", $request->keywords);
                    if($pieces){
                        foreach ($pieces as $key => $piece) {
                            $dataSet->Where('INV_STOCK.PRD_VARINAT_NAME', 'LIKE', '%' . $piece . '%');
                        }
                    }
                    $search = $request->keywords;

                    $dataSet->orWhere(function($query) use ($search){
                        $query->where('INV_STOCK.SKUID', 'LIKE', '%'.$search.'%');
                    });

                    $dataSet->orWhere(function($query) use ($search){
                        $query->where('INV_STOCK.BARCODE', 'LIKE', '%'.$search.'%');
                    });
                    // $dataSet->orWhere(function($query) use ($search){
                    //     $query->where('INV_STOCK.IG_CODE', 'LIKE', '%'.$search.'%');
                    // });
                }
            }

                $dataSet = $dataSet->groupBy('INV_STOCK.SKUID', 'INV_STOCK.F_SHOP_NO')
                ->paginate($per_page);
                // dd($dataSet);

                if(!empty($dataSet) && count($dataSet)> 0){
                    foreach ($dataSet as $k => $value1) {
                        $not_shelved_qty        = 0;
                        $shelved_qty            = 0;
                        $ordered                = 0;
                        $dispatched             = 0;
                        $available              = 0;
                        $stock = [];
                        $stock = Stock::select('PK_NO', 'SKUID', 'IG_CODE', 'BARCODE', 'PRD_VARINAT_NAME', 'PRD_VARIANT_IMAGE_PATH', 'SHOP_NAME', 'F_SHOP_NO', 'F_INV_ZONE_NO', 'PRODUCT_STATUS', 'BOOKING_STATUS', 'ORDER_STATUS')->where('IG_CODE',$value1->IG_CODE)->where('F_SHOP_NO',$value1->F_SHOP_NO)->whereRaw('(PRODUCT_STATUS IS NULL OR PRODUCT_STATUS != 420)')->get();

                        if(!empty($stock)){

                            foreach ($stock as $l => $value2) {
                                if( ($value2->IG_CODE == $value1->IG_CODE) && ($value2->F_SHOP_NO == $value1->F_SHOP_NO ) && ($value2->BOOKING_STATUS >= 10) && ($value2->BOOKING_STATUS <= 80) && ($value2->ORDER_STATUS < 80 OR $value2->ORDER_STATUS == null)){
                                    $ordered += 1;
                                }

                                if( ($value2->IG_CODE == $value1->IG_CODE) && ($value2->F_SHOP_NO == $value1->F_SHOP_NO ) && ($value2->ORDER_STATUS < 80 OR $value2->ORDER_STATUS == null)){
                                    $available += 1;
                                }

                                if( ($value2->IG_CODE == $value1->IG_CODE) && ($value2->F_SHOP_NO == $value1->F_SHOP_NO ) && ($value2->F_INV_ZONE_NO != null) && ($value2->ORDER_STATUS < 80 OR $value2->ORDER_STATUS == null)){
                                    $shelved_qty += 1;
                                }

                                if( ($value2->IG_CODE == $value1->IG_CODE) && ($value2->F_SHOP_NO == $value1->F_SHOP_NO ) && ($value2->F_INV_ZONE_NO == null) && ($value2->ORDER_STATUS < 80 OR $value2->ORDER_STATUS == null) && ($value2->PRODUCT_STATUS >= 60)){
                                    $not_shelved_qty += 1;
                                }

                                if( ($value2->IG_CODE == $value1->IG_CODE) && ($value2->F_SHOP_NO == $value1->F_SHOP_NO ) && ($value2->ORDER_STATUS >= 80)){
                                    $dispatched += 1;
                                }
                            }
                        }
                        $value1->NOT_SHELVED_QTY        = $not_shelved_qty ;
                        $value1->SHELVED_QTY            = $shelved_qty ;
                        $value1->ORDERED                = $ordered ;
                        $value1->DISPATCHED             = $dispatched ;
                        $value1->COUNTER                = $available ;
                    }
                }
                // echo '<pre>';
                // echo '======================<br>';
                // print_r($dataSet);
                // echo '<br>======================<br>';
                // exit();
                // $data = $dataSet->paginate($per_page);

        } catch (\Exception $th) {
            return $th->getMessage();
        }
        return $this->formatResponse(true, '', 'admin.all_product.list', $dataSet);
    }

    public function getProductModal($request)
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
            $data = Stock::select('INV_STOCK.F_BOOKING_NO as f_booking_no1','b.BOOKING_NO','b.CUSTOMER_NAME','b.F_CUSTOMER_NO','b.SHOP_NAME','b.F_SHOP_NO','INV_STOCK.F_INV_WAREHOUSE_NO','b.BOOKING_STATUS'
            , DB::raw('(SELECT IFNULL(COUNT(PK_NO),0) from INV_STOCK where F_BOOKING_NO = f_booking_no1 and F_INV_WAREHOUSE_NO = '.$request->warehouse_no.' and (ORDER_STATUS < 80 OR ORDER_STATUS IS NULL) and SKUID = '.$request->sku_id.' and BOOKING_STATUS between 10 and 80) as order_qty')
            )
            ->join('SLS_BOOKING as b','b.PK_NO','INV_STOCK.F_BOOKING_NO')
            ->whereRaw('b.BOOKING_STATUS between 10 and 80')
            ->where('INV_STOCK.SKUID', $request->sku_id)
            ->where('INV_STOCK.F_INV_WAREHOUSE_NO',$request->warehouse_no);
            if (Auth::user()->F_AGENT_NO > 0) {
                $data = $data->where('b.F_SHOP_NO',Auth::user()->F_AGENT_NO);
            }
            $data = $data->whereRaw('(ORDER_STATUS < 80 OR ORDER_STATUS IS NULL)')
            ->groupBy('INV_STOCK.F_BOOKING_NO')
            ->get();

        }else if ($request->type == 'dispatched') {
            $data = Stock::select('INV_STOCK.F_BOOKING_NO as f_booking_no1','b.BOOKING_NO','b.CUSTOMER_NAME','b.F_CUSTOMER_NO','b.SHOP_NAME','b.F_SHOP_NO','INV_STOCK.F_INV_WAREHOUSE_NO','b.BOOKING_STATUS'
            , DB::raw('(SELECT IFNULL(COUNT(PK_NO),0) from INV_STOCK where F_BOOKING_NO = f_booking_no1 and F_INV_WAREHOUSE_NO = '.$request->warehouse_no.' and SKUID = '.$request->sku_id.'  and ORDER_STATUS >= 80) as order_qty')
            )
            ->join('SLS_BOOKING as b','b.PK_NO','INV_STOCK.F_BOOKING_NO')
            ->where('INV_STOCK.SKUID', $request->sku_id)
            ->where('INV_STOCK.F_INV_WAREHOUSE_NO',$request->warehouse_no)
            ->where('INV_STOCK.ORDER_STATUS','>=',80)
            ->groupBy('INV_STOCK.F_BOOKING_NO')
            ->get();
        }
        $warehouse = $request->warehouse_no ?? '';
        return view('admin.shelve._product_modal_content')->withData($data)->withType($request->type)->withWarehouse($warehouse)->withSkuid($request->sku_id)->render();
    }

    public function getInvoiceProductModal($request)
    {
        $data = '';
        if ($request->type == 'boxed') {
            if ($request->invoice_type == 'vat-processing') {

                $data = DB::table('INV_STOCK as s')
                ->select('s.F_BOX_NO as box_id', 'b.BOX_NO as label'
                , DB::raw('(SELECT IFNULL(COUNT(F_BOX_NO),0) from INV_STOCK where SKUID = '.$request->sku_id.' and F_PRC_STOCK_IN_NO = '.$request->invoice_id.' and F_BOX_NO = box_id and F_BOX_NO IS NOT NULL and F_SHIPPMENT_NO IS NULL) as qty'))
                ->join('SC_BOX as b', 'b.PK_NO', 's.F_BOX_NO')
                ->where('s.SKUID', $request->sku_id)
                // ->where('s.F_INV_WAREHOUSE_NO',$request->warehouse_no)
                ->where('s.F_PRC_STOCK_IN_NO',$request->invoice_id)
                ->whereNotNull('s.F_BOX_NO')
                // ->whereRaw('(ORDER_STATUS < 80 OR ORDER_STATUS IS NULL)')
                ->whereNull('s.F_SHIPPMENT_NO')
                ->groupBy('s.F_BOX_NO')
                ->get();
            }else{
                $data = DB::table('INV_STOCK as s')
                ->select('s.F_BOX_NO as box_id', 'b.BOX_NO as label'
                , DB::raw('(SELECT IFNULL(COUNT(F_BOX_NO),0) from INV_STOCK where SKUID = '.$request->sku_id.' and F_INV_WAREHOUSE_NO = '.$request->warehouse_no.' and F_PRC_STOCK_IN_NO = '.$request->invoice_id.' and F_BOX_NO = box_id and F_BOX_NO IS NOT NULL and F_SHIPPMENT_NO IS NULL and (ORDER_STATUS < 80 OR ORDER_STATUS IS NULL)) as qty'))
                ->join('SC_BOX as b', 'b.PK_NO', 's.F_BOX_NO')
                ->where('s.SKUID', $request->sku_id)
                ->where('s.F_INV_WAREHOUSE_NO',$request->warehouse_no)
                ->where('s.F_PRC_STOCK_IN_NO',$request->invoice_id)
                ->whereNotNull('s.F_BOX_NO')
                ->whereRaw('(ORDER_STATUS < 80 OR ORDER_STATUS IS NULL)')
                ->whereNull('s.F_SHIPPMENT_NO')
                ->groupBy('s.F_BOX_NO')
                ->get();
            }
        }else if ($request->type == 'shipped') {
            if ($request->invoice_type == 'vat-processing') {

                $data = Stock::select('SHIPMENT_NAME as label', 'F_SHIPPMENT_NO as shipment_no'
                , DB::raw('(SELECT IFNULL(COUNT(F_SHIPPMENT_NO),0) from INV_STOCK where SKUID = '.$request->sku_id.' and F_PRC_STOCK_IN_NO = '.$request->invoice_id.' and F_SHIPPMENT_NO = shipment_no) as qty'))
                ->where('SKUID', $request->sku_id)
                // ->where('F_INV_WAREHOUSE_NO',$request->warehouse_no)
                ->where('F_PRC_STOCK_IN_NO',$request->invoice_id)
                // ->whereRaw('(ORDER_STATUS < 80 OR ORDER_STATUS IS NULL)')
                ->whereNotNull('F_SHIPPMENT_NO')
                ->groupBy('F_SHIPPMENT_NO')
                ->get();
            }else{
                $data = Stock::select('SHIPMENT_NAME as label', 'F_SHIPPMENT_NO as shipment_no'
                , DB::raw('(SELECT IFNULL(COUNT(F_SHIPPMENT_NO),0) from INV_STOCK where SKUID = '.$request->sku_id.' and F_INV_WAREHOUSE_NO = '.$request->warehouse_no.' and F_PRC_STOCK_IN_NO = '.$request->invoice_id.' and F_SHIPPMENT_NO = shipment_no and (ORDER_STATUS < 80 OR ORDER_STATUS IS NULL)) as qty'))
                ->where('SKUID', $request->sku_id)
                ->where('F_INV_WAREHOUSE_NO',$request->warehouse_no)
                ->where('F_PRC_STOCK_IN_NO',$request->invoice_id)
                ->whereRaw('(ORDER_STATUS < 80 OR ORDER_STATUS IS NULL)')
                ->whereNotNull('F_SHIPPMENT_NO')
                ->groupBy('F_SHIPPMENT_NO')
                ->get();
            }
        }else if ($request->type == 'shelved') {
            $data = DB::table('INV_STOCK')
            ->select('INV_STOCK.INV_ZONE_BARCODE as label', 'INV_STOCK.F_INV_ZONE_NO as shelve_no','INV_WAREHOUSE_ZONES.DESCRIPTION'
            , DB::raw('(SELECT IFNULL(COUNT(F_INV_ZONE_NO),0) from INV_STOCK where SKUID = '.$request->sku_id.' and F_INV_WAREHOUSE_NO = '.$request->warehouse_no.' and F_PRC_STOCK_IN_NO = '.$request->invoice_id.' and F_INV_ZONE_NO = shelve_no and F_INV_ZONE_NO IS NOT NULL and (ORDER_STATUS < 80 OR ORDER_STATUS IS NULL)) as qty'))
            ->join('INV_WAREHOUSE_ZONES','INV_WAREHOUSE_ZONES.PK_NO','INV_STOCK.F_INV_ZONE_NO')
            ->where('INV_STOCK.SKUID', $request->sku_id)
            ->where('INV_STOCK.F_INV_WAREHOUSE_NO',$request->warehouse_no)
            ->where('INV_STOCK.F_PRC_STOCK_IN_NO',$request->invoice_id)
            ->whereRaw('(ORDER_STATUS < 80 OR ORDER_STATUS IS NULL)')
            ->whereNotNull('F_INV_ZONE_NO')
            ->groupBy('INV_STOCK.F_INV_ZONE_NO')
            ->get();

        }else if ($request->type == 'shipped_invoice') {
            $box_label = Shipmentbox::selectRaw('(SELECT BOX_SERIAL FROM SC_SHIPMENT_BOX WHERE F_BOX_NO = f_box_no1)')->limit(1)->getQuery();
            $box_count = Stock::selectRaw('(SELECT IFNULL(COUNT(F_BOX_NO),0) from INV_STOCK where F_PRC_STOCK_IN_NO = '.$request->invoice_no.' and F_SHIPPMENT_NO = '.$request->shipment_no.' and F_BOX_NO = f_box_no1 and F_INV_WAREHOUSE_NO = '.$request->warehouse_no.' and F_PRC_STOCK_IN_NO = '.$request->invoice_id.' and (ORDER_STATUS < 80 OR ORDER_STATUS IS NULL))')->limit(1)->getQuery();
            $data = Stock::select('F_BOX_NO as f_box_no1', 'BOX_BARCODE'
            )
            ->selectSub($box_label, 'BOX_SERIAL')
            ->selectSub($box_count, 'qty')
            ->where('F_PRC_STOCK_IN_NO',$request->invoice_id)
            ->where('F_SHIPPMENT_NO',$request->shipment_no)
            // ->where('F_INV_WAREHOUSE_NO',$request->warehouse_no)
            ->whereRaw('(ORDER_STATUS < 80 OR ORDER_STATUS IS NULL)')
            ->groupBy('F_BOX_NO')->get();
            return view('admin.shipment._product_modal_content')->withData($data)->withType($request->type)->render();

        }else if ($request->type == 'booked') {
            $data = Stock::select('INV_STOCK.F_BOOKING_NO as f_booking_no1','b.BOOKING_NO','b.CUSTOMER_NAME','b.F_CUSTOMER_NO','b.SHOP_NAME','b.F_SHOP_NO','b.BOOKING_STATUS'
            , DB::raw('(SELECT IFNULL(COUNT(PK_NO),0) from INV_STOCK where F_BOOKING_NO = f_booking_no1 and F_INV_WAREHOUSE_NO = '.$request->warehouse_no.' and F_PRC_STOCK_IN_NO = '.$request->invoice_id.' and SKUID = '.$request->sku_id.' and BOOKING_STATUS between 10 and 80 and (ORDER_STATUS < 80 OR ORDER_STATUS IS NULL)) as order_qty')
            )
            ->join('SLS_BOOKING as b','b.PK_NO','INV_STOCK.F_BOOKING_NO')
            ->whereRaw('INV_STOCK.BOOKING_STATUS between 10 and 80')
            ->where('INV_STOCK.SKUID', $request->sku_id)
            // ->where('INV_STOCK.F_INV_WAREHOUSE_NO',$request->warehouse_no)
            ->where('F_PRC_STOCK_IN_NO',$request->invoice_id)
            ->whereRaw('(ORDER_STATUS < 80 OR ORDER_STATUS IS NULL)')
            ->groupBy('INV_STOCK.F_BOOKING_NO')
            ->get();

        }else if ($request->type == 'dispatched') {
            $data = Stock::select('INV_STOCK.F_BOOKING_NO as f_booking_no1','b.BOOKING_NO','b.CUSTOMER_NAME','b.F_CUSTOMER_NO','b.SHOP_NAME','b.F_SHOP_NO','b.BOOKING_STATUS'
            , DB::raw('(SELECT IFNULL(COUNT(PK_NO),0) from INV_STOCK where F_BOOKING_NO = f_booking_no1 and F_INV_WAREHOUSE_NO = '.$request->warehouse_no.' and F_PRC_STOCK_IN_NO = '.$request->invoice_id.' and SKUID = '.$request->sku_id.'  and ORDER_STATUS >= 80) as order_qty')
            )
            ->join('SLS_BOOKING as b','b.PK_NO','INV_STOCK.F_BOOKING_NO')
            ->where('INV_STOCK.SKUID', $request->sku_id)
            // ->where('INV_STOCK.F_INV_WAREHOUSE_NO',$request->warehouse_no)
            ->where('F_PRC_STOCK_IN_NO',$request->invoice_id)
            ->where('INV_STOCK.ORDER_STATUS','>=',80)
            ->groupBy('INV_STOCK.F_BOOKING_NO')
            ->get();
        }
        $warehouse = $request->warehouse_no ?? '';
        $prc_stoc_in_no = $request->invoice_id ?? '';
        $invoice_type = $request->invoice_type ?? '';
        return view('admin.shelve._product_modal_content')->withData($data)->withType($request->type)->withWarehouse($warehouse)->withSkuid($request->sku_id)->withInvoiceid($prc_stoc_in_no)->withInvoicetype($invoice_type)->render();
    }

    public function getWarehouseDropdown($request)
    {
        $data = Warehouse::get();
        return view('admin.shelve.warehouse_dropdown')->withData($data)->render();
    }



    public function getShelvedItem($id)
    {
        $count_shelved = Stock::selectRaw('(SELECT IFNULL(COUNT(SKUID),0) from INV_STOCK where SKUID = sku_id and F_INV_WAREHOUSE_NO = warehouse_no and F_INV_ZONE_NO = '.$id.' and (F_INV_ZONE_NO IS NOT NULL))')->limit(1)->getQuery();

        $item = $this->stock->select('PK_NO','SKUID as sku_id','PRC_IN_IMAGE_PATH','PRD_VARIANT_IMAGE_PATH','IG_CODE','PRD_VARINAT_NAME','F_INV_WAREHOUSE_NO as warehouse_no','INV_WAREHOUSE_NAME','BRAND_NAME','MODEL_NAME','BARCODE'
        ,DB::raw('IFNULL(AVG(PRODUCT_PURCHASE_PRICE),0) as PRODUCT_PURCHASE_PRICE')
        ,DB::raw('IFNULL(AVG(REGULAR_PRICE),0) as REGULAR_PRICE')
        )
        ->selectSub($count_shelved, 'shelved_qty')
        ->where('F_INV_ZONE_NO', $id)
        ->groupBy('SKUID','F_INV_WAREHOUSE_NO')
        ->get();

        return $this->formatResponse(true, '', 'admin.shelved.view', $item);
    }

    public function getUnshelvedItem($id)
    {
        $data = $this->stock->select('IG_CODE')->where('PK_NO',$id)->first();
        $item = $this->stock->select('*', 'SKUID as sku_id'
        ,DB::raw('GROUP_CONCAT(DISTINCT(F_PRC_STOCK_IN_NO)) as F_PRC_STOCK_IN_NO')
        ,DB::raw('IFNULL(COUNT(PK_NO),0) as count')
        )->where('IG_CODE', $data->IG_CODE)->groupBy('IG_CODE')->get();
        return $this->formatResponse(true, '', 'admin.unshelved.view', $item);
    }


    public function getStockPriceInfo($request,$id)
    {
        $data = $this->stock->select('IG_CODE','F_SHOP_NO')->where('PK_NO',$id)->first();
        $item = $this->stock->select('INV_STOCK.*', 'INV_STOCK.SKUID as sku_id','PRD_VARIANT_SETUP.PRIMARY_IMG_RELATIVE_PATH','PRD_VARIANT_SETUP.THUMB_PATH', 'PRD_VARIANT_SETUP.SPECIAL_PRICE','PRD_VARIANT_SETUP.WHOLESALE_PRICE', 'PRD_VARIANT_SETUP.REGULAR_PRICE','PRD_VARIANT_SETUP.INSTALLMENT_PRICE'
        ,DB::raw('GROUP_CONCAT(DISTINCT(F_PRC_STOCK_IN_NO)) as F_PRC_STOCK_IN_NO')
        ,DB::raw('IFNULL(COUNT(INV_STOCK.PK_NO),0) as count')
        )
        ->join('PRD_VARIANT_SETUP','PRD_VARIANT_SETUP.PK_NO','INV_STOCK.F_PRD_VARIANT_NO')
        ->where('IG_CODE', $data->IG_CODE)
        ->where('F_SHOP_NO', $data->F_SHOP_NO)
        ->groupBy('IG_CODE')
        ->get();

        return $this->formatResponse(true, '', 'admin.stock_price.view', $item);
    }

    public function postStore($request)
    {
        // echo '<pre>';
        // echo '======================<br>';
        // print_r($request->all());
        // echo '<br>======================<br>';
        // exit();
        DB::beginTransaction();
        try {
            if ($request->pk_no > 0) {
                $warehousezone                  = WarehouseZone::where('PK_NO',$request->pk_no)->first();
            }else{
                $warehousezone                  = new WarehouseZone();
            }
            $warehousezone->ZONE_BARCODE        = $request->zone_barcode;
            $warehousezone->DESCRIPTION         = $request->description;
            $warehousezone->F_INV_WAREHOUSE_NO  = $request->warehouse;
            $warehousezone->save();

        } catch (\Exception $th) {
            DB::rollback();
            return $this->formatResponse(false, $th->getMessage(), 'admin.shelve.list');
        }
        DB::commit();
        // echo '<pre>';
        // echo '======================<br>';
        // print_r($warehousezone);
        // echo '<br>======================<br>';
        // exit();
        if ($request->pk_no > 0) {
            return $this->formatResponse(true, 'Warehouse Zone Updated Successfully !', 'admin.shelve.list');
        }else{
            return $this->formatResponse(true, 'Warehouse Zone Created Successfully !', 'admin.shelve.list');
        }
    }
}
