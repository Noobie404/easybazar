<?php

namespace App\Http\Controllers\Admin;

use DB;
use Auth;
use App\Models\Box;
use App\Models\Stock;
use App\Models\Shipment;
use App\Models\Warehouse;
use App\Models\Shipmentbox;
use App\Traits\RepoResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\MerStock;
use App\Repositories\Admin\Box\BoxInterface;

class BoxController extends BaseController
{
    use RepoResponse;

    private $box;
    private $warehouse;
    private $shipmodel;
    private $stock;
    function __construct(BoxInterface $box, Box $box_model, Shipment $shipmodel, Shipmentbox $shipmentbox, Stock $stock)
    {
        $this->box           = $box;
        $this->box_model     = $box_model;
        $this->stock         = $stock;
    }

    public function getIndex(Request $request)
    {
        return view('admin.box.index');
    }

    public function getBox(Request $request, $id)
    {
        $box = $this->box->getBox($id, $request);

        return view('admin.box.boxView')->withBoxs($box->data);
    }

    public function getNotBoxed(Request $request)
    {

        // $dataSet = DB::table('INV_STOCK')
        // ->select('PK_NO','SKUID','PRD_VARINAT_NAME as VARINAT_NAME','PRD_VARIANT_IMAGE_PATH','INV_WAREHOUSE_NAME','IG_CODE as ig_code_','BARCODE')
        // ->whereNull('F_BOX_NO')
        // ->Where('F_INV_WAREHOUSE_NO',1)
        // ->orderBy('VARINAT_NAME', 'ASC')
        // ->groupBy('F_INV_WAREHOUSE_NO','SKUID')
        // ->get();
        // dd($dataSet);

        return view('admin.box.not_boxed');
    }

    public function getNotBox(Request $request,$id)
    {
        if ($request->stock_for == 'MERCHANT' && Auth::user()->F_MERCHANT_NO > 0) {
            $sku_id = MerStock::select('SKUID')->where('PK_NO', $id)->where('F_MERCHANT_NO',Auth::user()->F_MERCHANT_NO)->first();
            $box = MerStock::select('*',DB::raw('GROUP_CONCAT(DISTINCT(PRC_IN_IMAGE_PATH)) as invoice_list'))->where('SKUID', $sku_id->SKUID)->whereRaw('F_BOX_NO IS NULL')->get();
        }elseif ($request->stock_for == 'MERCHANT' && Auth::user()->F_MERCHANT_NO == 0) {
            $sku_id = MerStock::select('SKUID')->where('PK_NO', $id)->first();
            $box = MerStock::select('*',DB::raw('GROUP_CONCAT(DISTINCT(PRC_IN_IMAGE_PATH)) as invoice_list'))->where('SKUID', $sku_id->SKUID)->whereRaw('F_BOX_NO IS NULL')->get();
        }elseif ($request->stock_for == 'AMT' && Auth::user()->F_MERCHANT_NO == 0) {
            $sku_id = $this->stock::select('SKUID')->where('PK_NO', $id)->first();
            $box = $this->stock->select('*',DB::raw('GROUP_CONCAT(DISTINCT(PRC_IN_IMAGE_PATH)) as invoice_list'))->where('SKUID', $sku_id->SKUID)->whereRaw('F_BOX_NO IS NULL')->get();
        }
        return view('admin.box.not_boxdView')->withItems($box);
    }

    public function putBoxLabelUpdate(Request $request)
    {
        $this->resp = $this->box->postUpdate($request);
        return view('admin.box.index')->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function postBoxTypeStore(Request $request)
    {
        $this->resp = $this->box->postBoxTypeStore($request);
        return redirect()->back()->with($this->resp->redirect_class, $this->resp->msg);
        // return view('admin.boxType.index')->with($this->resp->redirect_class, $this->resp->msg)->withRows($this->resp->data);
    }

    public function getBoxTypeList()
    {
        $this->resp = $this->box->getBoxTypeList();

        return view('admin.boxType.index')->withRows($this->resp->data);
    }

    public function getBoxTypeAdd($id = null)
    {
        $this->resp = $this->box->getBoxTypeAdd($id);

        return view('admin.boxType.create')->withData($this->resp->data);
    }

    public function getBoxTypeDelete($id)
    {
        $this->resp = $this->box->getBoxTypeDelete($id);

        return redirect()->back()->with($this->resp->redirect_class, $this->resp->msg);
    }
}
?>
