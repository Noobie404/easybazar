<?php
namespace App\Repositories\Admin\Faulty;
use DB;
use App\Models\Box;
use App\Models\Stock;
use App\Models\Faulty;
use App\Models\Shipment;
use App\Models\Shipmentbox;
use App\Traits\RepoResponse;
class FaultyAbstract implements FaultyInterface
{
    use RepoResponse;

    protected $inv_stock;
    protected $box;

    public function __construct(Stock $inv_stock,Box $box)
    {
        $this->inv_stock = $inv_stock;
        $this->box       = $box;
    }

    public function getProductINV($ig_code,$type,$id,$dispatched)
    {
        $info = DB::table('INV_STOCK as v')->select('v.PK_NO','v.PRD_VARINAT_NAME','v.SKUID','v.PRODUCT_STATUS','v.BOOKING_STATUS','v.PRC_IN_IMAGE_PATH','v.F_BOOKING_NO','v.REGULAR_PRICE','v.INSTALLMENT_PRICE','v.PRD_VARIANT_IMAGE_PATH','v.F_BOOKING_NO','v.IS_FAULTY', 'v.SHOP_NAME', 'v.SPECIAL_PRICE', 'v.WHOLESALE_PRICE' );
        $info = $info->orderBy('v.F_PRD_VARIANT_NO','ASC');
        $info = $info->get();
        $data['info'] = $info;
        if (!empty($data['info'])) {
            return $this->generateInputField($data);
        }
        return $data;
    }

    private function generateInputField($item){
        return view('admin.faulty.faulty_variant_tr')->withItem($item)->render();
    }

    public function findOrThrowException($type,$id,$dispatched=null)
    {
        $product_details = $this->inv_stock->select('IG_CODE'
        );
        if ($type == 'box') {
            $product_details = $product_details->where('F_BOX_NO',$id);
        }else if ($type == 'product') {
            $product_details = $product_details->where('F_PRD_VARIANT_NO',$id);

        }
        $product_details = $product_details->groupBy('IG_CODE');
        $product_details = $product_details->get();

        if ($product_details && count($product_details) > 0 ) {
            foreach ($product_details as $key => $value) {
                $value->product_info = $this->getProductINV($value->IG_CODE,$type,$id,$dispatched);
            }
        }

        return $this->formatResponse(true, 'Data found successfully !', 'admin.booking.list', $product_details);
    }

    public function ajaxFaultyChecker($type,$id,$faulty_type)
    {
        DB::beginTransaction();
        try {
            $box = Stock::select('F_BOX_NO')->where('PK_NO',$id)->first();

            if (!empty($box) && $type == 'box') {
                if ($faulty_type == 'non-sellable') {
                    $shipment_no = Shipmentbox::select('F_SHIPMENT_NO')->where('F_BOX_NO', $box->F_BOX_NO)->first();
                    if (!empty($shipment_no)) {
                        $shipment_status = Shipment::select('PK_NO','SHIPMENT_STATUS','F_TO_INV_WAREHOUSE_NO')->where('PK_NO', $shipment_no->F_SHIPMENT_NO)->first();
                        $product_count = Stock::where('F_BOX_NO',$box->F_BOX_NO)->where('PRODUCT_STATUS','<=',50)->where('F_SHIPPMENT_NO',$shipment_no->F_SHIPMENT_NO)->count();
                        if ($product_count == 0) {
                            Box::where('PK_NO', $box->F_BOX_NO)->update(['BOX_STATUS' => 60, 'F_INV_WAREHOUSE_NO' => $shipment_status->F_TO_INV_WAREHOUSE_NO]);
                        }
                    }
                    Stock::where('PK_NO', $id)
                    ->update(['PRODUCT_STATUS' => 420
                            ,'F_INV_WAREHOUSE_NO' => $shipment_status->F_TO_INV_WAREHOUSE_NO ?? 1
                            ,'INV_WAREHOUSE_NAME' => $shipment_status->to_warehouse->NAME ?? 'UK WAREHOUSE 01']);

                    DB::table('SC_BOX_INV_STOCK')->where('F_INV_STOCK_NO',$id)->delete();
                }elseif($faulty_type == 'sellable'){
                    Stock::where('PK_NO', $id)->update(['IS_FAULTY' => 1]);
                }
            }elseif($type == 'product'){
                if ($faulty_type == 'non-sellable') {
                    Stock::where('PK_NO', $id)->update(['PRODUCT_STATUS' => 420]);
                }elseif($faulty_type == 'sellable'){
                    Stock::where('PK_NO', $id)->update(['IS_FAULTY' => 1]);
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
        DB::commit();
        return 1;
    }
}
