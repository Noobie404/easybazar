<?php
namespace App\Repositories\Admin\InvoiceDetails;

use DB;
use Auth;
use App\Models\Stock;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Currency;
use App\Models\VatClass;
use App\Models\MerInvoice;
use App\Traits\RepoResponse;
use App\Models\InvoiceDetails;
use App\Models\ProductVariant;
use App\Models\StockGeneration;
use App\Models\MerInvoiceDetails;

class InvoiceDetailsAbstract implements InvoiceDetailsInterface
{
    use RepoResponse;

    protected $innvoice_details;
    protected $mer_innvoice_details;
    protected $product;
    protected $vat_class;

    public function __construct(InvoiceDetails $innvoice_details, MerInvoiceDetails $mer_innvoice_details, Product $product, VatClass $vat_class)
    {
        $this->innvoice_details = $innvoice_details;
        $this->mer_innvoice_details = $mer_innvoice_details;
        $this->product          = $product;
        $this->vat_class        = $vat_class;
    }

    public function getPaginatedList($request, int $per_page = 20, $id)
    {
        $data = $this->innvoice_details;
        $data = $data->select('*')
            ->where('F_PRC_STOCK_IN', $id)
            ->where('IS_ACTIVE', 1)
            ->orderBy('PK_NO', 'ASC')
            ->get();

        return $this->formatResponse(true, '', 'admin.invoice-details', $data);
    }

    public function getProductBySubCategory($id){

        $products = Product::where('F_PRD_SUB_CATEGORY_ID', $id)->pluck('DEFAULT_NAME', 'PK_NO');
        $response = '';

        if (count($products) > 0) {
            $response .= '<option value=""> -- Please select product -- </option>';
            foreach ($products as $key => $value) {
                $response .= '<option value="'.$key.'">'. $value.'</option>';
            }
        }else{
            $response .= '<option value=""> Product not found </option>';
        }

        return $response;
    }

    public function getInvoiceData($id, $request){
        $data = Invoice::where('PK_NO', $id)->first();
        return $this->formatResponse(true, '', 'admin.invoice-details.new', $data);
    }

    public function getVariantListById($data){
        $variants = ProductVariant::whereIn('PK_NO', $data)->get();
        $remove_item = 'PK_NO';
        return $this->generateVariantResponse(null, $variants, $remove_item);
    }

    public function getVariantListByBarCode($request,$bar_code,$type){
        $bar_code = explode(",",$bar_code);
        $variants = ProductVariant::whereIn('BARCODE', $bar_code)->get();
        $remove_item = 'BARCODE';
        return $this->generateVariantResponse($variants,$type, $remove_item);
    }

    private function generateVariantResponse($variants,$type, $remove_item){
        $response = '';
        if (count($variants) > 0) {
            foreach ($variants as $item) {
                $item->remove_item = $remove_item;
                //$vat_class = $this->getVatClassCombo();
                $response .= $this->generateInputField($item,$type);
            }
        }


        return $response;
    }

    private function getVatClassCombo(){
        return VatClass::pluck('NAME', 'RATE');
    }

    private function generateInputField($item,$type){
        return view('admin.procurement.invoice-details._variant_tr')->withItem($item)->withType($type)->render();
    }

    public function postStore($request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $redirect_to = $request->segment(1) == 'seller' ? 'seller.invoice' : 'admin.invoice';

            $invoice = Invoice::where('PK_NO', $request->invoice_id)->where('INV_STOCK_RECORD_GENERATED', 0)->first();
            if(empty($invoice)){
                return $this->formatResponse(false, 'Unable to add new product in this invoice !', $redirect_to);
            }
            $variants = $request->variant_id;
            $currency = Currency::find($invoice->F_SS_CURRENCY_NO);
            if($variants == null ){
                return $this->formatResponse(false, 'Item not found in this invoice !', $redirect_to);
            }
            if(count(array_unique($request->variant_id))<count($request->variant_id)){
                return $this->formatResponse(false, 'Unable to add new product in this invoice, it has may duplicate item !', $redirect_to);
            }
            if(!empty($variants)){
                foreach ($variants as $key => $value) {
                    $variant_id = $value;

                    $variant = ProductVariant::find($variant_id);
                    $variant->VARIANT_CUSTOMS_NAME = $request->invoice_name[$key];
                    $variant->update();

                    $inv = new InvoiceDetails();
                    $inv->F_PRC_STOCK_IN    = $invoice->PK_NO;
                    $inv->F_PRD_VARIANT_NO  = $variant_id;
                    $inv->PRD_VARIANT_NAME  = $request->variant_name[$key];
                    $inv->INVOICE_NAME      = $request->invoice_name[$key];
                    $inv->BAR_CODE          = $request->barcode[$key];
                    $inv->QTY               = $request->total_line_qty[$key] ?? 0;
                    $inv->RECIEVED_QTY      = $request->recieved_qty[$key] ?? 0;
                    $inv->FAULTY_QTY        = $request->faulty_qty[$key] ?? 0;
                    $inv->CURRENCY          = $currency->NAME;
                    $inv->VAT_RATE          = $request->vat_class_rate[$key];

                    $inv->UNIT_PRICE_AC_EV          = $request->unit_price_ev2[$key];
                    $inv->UNIT_VAT_AC               = $request->unit_vat2[$key];
                    $inv->LINE_TOTAL_VAT_AC         = $request->line_vat_actual2[$key];
                    $inv->SUB_TOTAL_AC_RECEIPT      = $request->line_total[$key];
                    $inv->SUB_TOTAL_AC_EV           = $request->line_total_exvat_actual2[$key];
                    $inv->REC_TOTAL_AC_WITH_VAT     = ($request->unit_price_ev2[$key]+$request->unit_vat2[$key])*$request->recieved_qty[$key];
                    $inv->REC_TOTAL_AC_ONLY_VAT     = $request->unit_vat2[$key]*$request->recieved_qty[$key];

                    $unit_price_gbp_ev              = $request->unit_price_ev2[$key];
                    $unit_vat_gbp                   = $request->unit_vat2[$key];
                    $unit_total_vat_gbp             = $request->line_vat_actual2[$key];
                    $sub_total_gbp                  = $request->line_total[$key];
                    $sub_total_gbp_actual           = $request->line_total_exvat_actual2[$key];
                    $rec_total_gbp_with_vat         = (($request->unit_price_ev2[$key]+$request->unit_vat2[$key])*$request->recieved_qty[$key]);
                    $rec_total_gbp_only_vat         = ($request->unit_vat2[$key]*$request->recieved_qty[$key]);

                    $inv->UNIT_PRICE_GBP_EV         = $unit_price_gbp_ev;
                    $inv->UNIT_VAT_GBP              = $unit_vat_gbp;
                    $inv->LINE_TOTAL_VAT_GBP        = $unit_total_vat_gbp;
                    $inv->SUB_TOTAL_GBP_RECEIPT     = $sub_total_gbp;
                    $inv->SUB_TOTAL_GBP_EV          = $sub_total_gbp_actual;
                    $inv->REC_TOTAL_GBP_WITH_VAT    = $rec_total_gbp_with_vat;
                    $inv->REC_TOTAL_GBP_ONLY_VAT    = $rec_total_gbp_only_vat;

                    $inv->UNIT_PRICE_MR_EV          = $request->unit_price_ev2[$key];
                    $inv->UNIT_VAT_MR               = $request->unit_vat2[$key];
                    $inv->LINE_TOTAL_VAT_MR         = $request->line_vat_actual2[$key];
                    $inv->SUB_TOTAL_MR_RECEIPT      = $request->line_total[$key];
                    $inv->SUB_TOTAL_MR_EV           = $request->line_total_exvat_actual2[$key];
                    $inv->REC_TOTAL_MR_WITH_VAT     = (($request->unit_price_ev2[$key]+$request->unit_vat2[$key])*$request->recieved_qty[$key]);
                    $inv->REC_TOTAL_MR_ONLY_VAT     = ($request->unit_vat2[$key]*$request->recieved_qty[$key]);

                    $inv->save();

                    // if($key==50){
                    //     break;
                    // }
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return $this->formatResponse(false, 'Unable to create invoice !', $redirect_to);
        }
        DB::commit();
        return $this->formatResponse(true, 'Stock has been created successfully !', $redirect_to);
    }

    public function getVariantListByQueryString($request, $queryString){
        $data = ProductVariant::select('VARIANT_NAME', 'COMPOSITE_CODE', 'VARIANT_CUSTOMS_NAME', 'SIZE_NAME', 'REGULAR_PRICE', 'COLOR')
            ->where('VARIANT_NAME', 'like', '%'.$queryString.'%')
            ->orderBy('PK_NO')
            ->limit(10)
            ->get();

        return $this->formatResponse(true, '', 'Data found', $data);
    }

    // private function genarateRow($data)
    // {
    //     foreach ($data as $key => $value) {
    //         return '<tr> <td>'.$key.'</td></tr>';
    //     }
    // }
/*
    public function findOrThrowException($id)
    {
        $data = $this->vendor->where('PK_NO', '=', $id)->first();

        if (!empty($data)) {
            return $this->formatResponse(true, '', 'admin.vendor.edit', $data);
        }

        return $this->formatResponse(false, 'Did not found data !', 'admin.vendor', null);
    }

    public function postUpdate($request, $id)
    {
        $country = DB::table('SS_COUNTRY')->select('NAME')->where('PK_NO', '=', $request->country)->first();

        DB::beginTransaction();

        try {

            $vendor = $this->vendor->where('PK_NO', $id)->first();

            $vendor->where('PK_NO', $id)->update(
                [
                    'CODE'          => (!empty($request['code']) ?  $request['code'] : $id),
                    'NAME'          => $request['name'],
                    'ADDRESS'       => $request['address'],
                    'F_COUNTRY'     => $request['country'],
                    'COUNTRY'       => $country->NAME,
                    'PHONE'         => $request['phone'],
                    'HAS_LOYALITY'  => $request['has_loyality'],
                ]
            );

        } catch (\Exception $e) {
            DB::rollback();

            return $this->formatResponse(false, 'Unable to update vendor !', 'admin.vendor');
        }

        DB::commit();

        return $this->formatResponse(true, 'Vendor has been updated successfully !', 'admin.vendor');
    }
    */

    public function delete($id, $request)
    {
        $innvoice_details   = InvoiceDetails::find($id);
        $invoice = $innvoice_details->invoice->INV_STOCK_RECORD_GENERATED;
        if ($invoice == 1) {
            return $this->formatResponse(false, 'Unable to delete this action because stock already generated !', 'admin.invoice');
        }

        DB::begintransaction();
        try {
            InvoiceDetails::where('PK_NO', $id)->delete();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, 'Unable to delete this action !', 'admin.invoice');
        }
        DB::commit();
        return $this->formatResponse(true, 'Successfully delete this action !', 'admin.invoice');
    }

    public function getProductByInvoice($request, $id, $type)
    {
   
        if ($type == 'stock-processing') {
            $stock = DB::table('INV_STOCK')->select('PK_NO', 'SKUID', 'IG_CODE', 'BARCODE', 'PRD_VARINAT_NAME', 'PRD_VARIANT_IMAGE_PATH', 'SHOP_NAME', 'F_SHOP_NO', 'F_INV_ZONE_NO','PRODUCT_STATUS', 'BOOKING_STATUS')->where('F_PRC_STOCK_IN_NO',$id)->get();

            $dataSet = DB::SELECT("SELECT PK_NO, SKUID, IG_CODE, BARCODE, PRD_VARINAT_NAME, PRD_VARIANT_IMAGE_PATH,SHOP_NAME, F_SHOP_NO AS WAREHOUSE_NO
            FROM INV_STOCK
            WHERE F_PRC_STOCK_IN_NO = $id
            GROUP BY SKUID, F_SHOP_NO ORDER BY PK_NO DESC ");

        if(!empty($dataSet) && count($dataSet)> 0){
            foreach ($dataSet as $k => $value1) {
                $not_shelved_qty        = 0;
                $shelved_qty            = 0;
                $ordered                = 0;
                $dispatched             = 0;
                $available              = 0;
                if(!empty($stock)){
                    foreach ($stock as $l => $value2) {
                        if( ($value2->IG_CODE == $value1->IG_CODE) && ($value2->F_SHOP_NO == $value1->WAREHOUSE_NO ) && ($value2->BOOKING_STATUS >= 10) && ($value2->BOOKING_STATUS <= 80)){
                            $ordered += 1;
                        }
                        if( ($value2->IG_CODE == $value1->IG_CODE) && ($value2->F_SHOP_NO == $value1->WAREHOUSE_NO )){
                            $available += 1;
                        }
                        if( ($value2->IG_CODE == $value1->IG_CODE) && ($value2->F_SHOP_NO == $value1->WAREHOUSE_NO ) && ($value2->F_INV_ZONE_NO != null)){
                            $shelved_qty += 1;
                        }
                        if( ($value2->IG_CODE == $value1->IG_CODE) && ($value2->F_SHOP_NO == $value1->WAREHOUSE_NO ) && ($value2->F_INV_ZONE_NO == null)  && ($value2->PRODUCT_STATUS == 60)){
                            $not_shelved_qty += 1;
                        }
                        if( ($value2->IG_CODE == $value1->IG_CODE) && ($value2->F_SHOP_NO == $value1->WAREHOUSE_NO )){
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
        }else{
            $stock = DB::SELECT(" SELECT PK_NO, SKUID, IG_CODE, BARCODE, PRD_VARINAT_NAME, PRD_VARIANT_IMAGE_PATH, SHOP_NAME, F_SHOP_NO,F_SHIPPMENT_NO, F_BOX_NO, F_INV_ZONE_NO, PRODUCT_STATUS, BOOKING_STATUS FROM INV_STOCK WHERE F_PRC_STOCK_IN_NO = $id");

            $dataSet = DB::SELECT("SELECT PK_NO, SKUID, IG_CODE, BARCODE, PRD_VARINAT_NAME, PRD_VARIANT_IMAGE_PATH, SHOP_NAME, F_SHOP_NO AS WAREHOUSE_NO
            FROM INV_STOCK
            WHERE F_PRC_STOCK_IN_NO = $id
            GROUP BY SKUID ORDER BY PK_NO DESC ");
            if(!empty($dataSet) && count($dataSet)> 0){
                foreach ($dataSet as $k => $value1) {
                    $not_shelved_qty        = 0;
                    $shelved_qty            = 0;
                    $ordered                = 0;
                    $dispatched             = 0;
                    $available              = 0;
                    if(!empty($stock)){
                        foreach ($stock as $l => $value2) {
                            if( ($value2->IG_CODE == $value1->IG_CODE) && ($value2->BOOKING_STATUS >= 10) && ($value2->BOOKING_STATUS <= 80)){
                                $ordered += 1;
                            }
                            if( ($value2->IG_CODE == $value1->IG_CODE)){
                                $available += 1;
                            }
                            if( ($value2->IG_CODE == $value1->IG_CODE) && ($value2->F_INV_ZONE_NO != null)){
                                $shelved_qty += 1;
                            }
                            if( ($value2->IG_CODE == $value1->IG_CODE) && ($value2->F_INV_ZONE_NO == null) && ($value2->F_BOX_NO != null) && ($value2->F_SHIPPMENT_NO != null)){
                                $not_shelved_qty += 1;
                            }
                            if( ($value2->IG_CODE == $value1->IG_CODE) && ($value2->ORDER_STATUS >= 80)){
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
        }
        if (!empty($dataSet) && count($dataSet) > 0) {
            return $this->formatResponse(true, 'Data found !', 'admin.procurement.invoice-details.details',$dataSet);
        }
        return $this->formatResponse(false, 'Please try again !', 'admin.procurement.invoice-details.details');
    }
}
