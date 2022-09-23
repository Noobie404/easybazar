<?php
namespace App\Repositories\Admin\Box;

use DB;
use Auth;
use App\Models\Box;
use App\Models\Stock;
use App\Models\BoxType;
use App\Models\MerStock;
use App\Models\Shipment;
use App\Traits\RepoResponse;

class BoxAbstract implements BoxInterface
{
    use RepoResponse;

    protected $shipment;
    protected $box_type;
    protected $stock;
    protected $merstock;

    public function __construct(Shipment $shipment, Stock $stock, MerStock $merstock, BoxType $box_type)
    {
        $this->shipment = $shipment;
        $this->box_type = $box_type;
        $this->stock    = $stock;
        $this->merStock = $merstock;
    }

    public function getBox($id, $request)
    {
        $box = DB::table('SC_BOX')->select('F_MERCHANT_NO')->where('PK_NO',$id)->first();
        if($request->invoice_for == 'azuramart' || $box->F_MERCHANT_NO == 0){
            $box = $this->stock->select('INV_STOCK.*','SC_BOX.PREFEX','SKUID as sku_id'
            ,DB::raw('IFNULL(count(INV_STOCK.SKUID),0) as total')
            ,DB::raw('IFNULL(AVG(INV_STOCK.PRODUCT_PURCHASE_PRICE),0) as PRODUCT_PURCHASE_PRICE')
            ,DB::raw('IFNULL(AVG(INV_STOCK.REGULAR_PRICE),0) as REGULAR_PRICE')
            ,DB::raw('GROUP_CONCAT(DISTINCT(INV_STOCK.PRC_IN_IMAGE_PATH)) as PRC_IN_IMAGE_PATH')
            ,DB::raw('(select ifnull(count(INV_STOCK.PK_NO),0) from INV_STOCK where INV_STOCK.F_BOX_NO='.$id.' and INV_STOCK.PRODUCT_STATUS = 60 and INV_STOCK.SKUID = sku_id ) as unboxed'))
            ->leftJoin('SC_BOX', 'SC_BOX.PK_NO', 'INV_STOCK.F_BOX_NO')
            ->where('INV_STOCK.F_BOX_NO', $id)
            ->groupBy('INV_STOCK.SKUID');
        }else{
            $box = $this->merStock->select('MER_INV_STOCK.*','SC_BOX.PREFEX','SKUID as sku_id'
            ,DB::raw('IFNULL(count(MER_INV_STOCK.SKUID),0) as total')
            ,DB::raw('IFNULL(AVG(MER_INV_STOCK.PRODUCT_PURCHASE_PRICE),0) as PRODUCT_PURCHASE_PRICE')
            ,DB::raw('IFNULL(AVG(MER_INV_STOCK.REGULAR_PRICE),0) as REGULAR_PRICE')
            ,DB::raw('GROUP_CONCAT(DISTINCT(MER_INV_STOCK.PRC_IN_IMAGE_PATH)) as PRC_IN_IMAGE_PATH')
            ,DB::raw('(select ifnull(count(MER_INV_STOCK.PK_NO),0) from MER_INV_STOCK where MER_INV_STOCK.F_BOX_NO='.$id.' and MER_INV_STOCK.PRODUCT_STATUS = 60 and MER_INV_STOCK.SKUID = sku_id ) as unboxed'))
            ->leftJoin('SC_BOX', 'SC_BOX.PK_NO', 'MER_INV_STOCK.F_BOX_NO')
            ->where('MER_INV_STOCK.F_BOX_NO', $id);
            if(Auth::user()->F_MERCHANT_NO > 0){
                $box = $box->where('SC_BOX.F_MERCHANT_NO',Auth::user()->F_MERCHANT_NO);
            }
            $box = $box->groupBy('MER_INV_STOCK.SKUID');
        }

        $box = $box->get();
        return $this->formatResponse(true, '', ' ', $box);
    }

    public function getBoxTypeAdd($id)
    {
        $data = [];
        if ($id > 0) {
            $data = $this->box_type->where('PK_NO', $id)->first();
        }
        return $this->formatResponse(true, '', ' ', $data);
    }

    public function getBoxTypeList()
    {
        $box_type = $this->box_type->where('IS_ACTIVE', 1)->get();
        return $this->formatResponse(true, '', ' ', $box_type);
    }

    public function postUpdate($request)
    {
        $box_type = 'SEA';

        $dup_box = Box::where('BOX_NO',$request->box_label)->count();
        if ($dup_box > 0) {
            return $this->formatResponse(false, 'Duplicate Box Label !', ' ', null);
        }
        $box_type = substr($request->box_label, 0, 1);
        if ($box_type == 1) {
            $box_type = 'AIR';
        }
        DB::beginTransaction();
        try {
            Box::where('PK_NO',$request->id)->update(['BOX_NO'=>$request->box_label]);
            Stock::where('F_BOX_NO',$request->id)->update(['BOX_BARCODE'=>$request->box_label,'BOX_TYPE'=>$box_type]);

        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(true, 'Please Try Again !', ' ', null);
        }
        DB::commit();
        return $this->formatResponse(false, 'Box Label Updated !', ' ', null);

    }

    public function postBoxTypeStore($request)
    {
        DB::beginTransaction();
        try {
            if ($request->box_pk > 0) {
                $box_type       = BoxType::find($request->box_pk);
            }else{
                $box_type           = new BoxType();
            }
            $box_type->TYPE     = $request->type;
            $box_type->WIDTH_CM = $request->width;
            $box_type->LENGTH_CM= $request->length;
            $box_type->HEIGHT_CM= $request->height;

            $box_type->save();
            $type_list = $this->box_type->where('IS_ACTIVE', 1)->get();

        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, 'Please Try Again !', ' ', $type_list);
        }
        DB::commit();
        return $this->formatResponse(true, 'Action was successfull !', '', $type_list);
    }

    public function getBoxTypeDelete($id)
    {
        DB::beginTransaction();
        try {
            $this->box_type->where('PK_NO',$id)->delete();

        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, 'Please Try Again !', ' ');
        }
        DB::commit();
        return $this->formatResponse(true, 'Action was successfull !', '');
    }
}
