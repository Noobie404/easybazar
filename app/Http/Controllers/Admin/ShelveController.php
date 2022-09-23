<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\User;
use App\Models\Stock;
use App\Models\Warehouse;
use App\Traits\RepoResponse;
use Illuminate\Http\Request;
use App\Models\WarehouseZone;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use App\Repositories\Admin\Shelve\ShelveInterface;

class ShelveController extends BaseController
{
    use RepoResponse;

    private $shelve;
    private $stock;
    private $warehouse;
    private $warehoueszone;

    function __construct(ShelveInterface $shelve, Stock $stock, WarehouseZone $warehoueszone, Warehouse $warehouse)
    {
        $this->shelve        = $shelve;
        $this->stock         = $stock;
        $this->warehouse     = $warehouse;
        $this->warehoueszone = $warehoueszone;
    }

    public function getUnshelved(Request $request)
    {
        return view('admin.shelve.unshelved');
    }

    public function getUnshelvedItem($id)
    {
        $item = $this->shelve->getUnshelvedItem($id);
        return view('admin.shelve.unshelve_view')->withItems($item->data);
    }

    public function getShelvedItem($zone_id)
    {   $item = $this->shelve->getShelvedItem($zone_id);
        return view('admin.shelve.shelve_view')->withItems($item->data);
    }

    public function getStockPriceInfo(Request $request, $id)
    {
        $item = $this->shelve->getStockPriceInfo($request,$id);
        return view('admin.shelve.stock_price_info')->withItems($item->data);
    }

    public function getShelveList()
    {
        return view('admin.shelve.shelved');
    }

    public function getShelveStore($id = null)
    {
        $warehouse = $this->warehouse->getWarehpuseCombo();
        $data = null;
        if ($id != null) {
            $data = $this->warehoueszone->where('PK_NO',$id)->first();
        }
        return view('admin.shelve.addShelve')->withWarehouse($warehouse)->withData($data);
    }

    public function getAllProduct(Request $request)
    {

        $this->resp = $this->shelve->getAllProduct($request);

        if(Auth::user()->USER_TYPE == 10 ){
            $shop_id  = Auth::user()->SHOP_ID;
            $store = DB::table('SA_USER')->where('PK_NO',$shop_id)->pluck('SHOP_NAME', 'PK_NO');
        }else{
            $store = DB::table('SA_USER')->where('USER_TYPE',10)->where('F_PARENT_USER_ID',0)->pluck('SHOP_NAME', 'PK_NO');
        }

        return view('admin.shelve.product-list')->withRows($this->resp->data)->withstore($store);
    }

    public function getProductModal(Request $request)
    {
        $this->resp = $this->shelve->getProductModal($request);
        return json_encode($this->resp);
    }

    public function getInvoiceProductModal(Request $request)
    {
        $this->resp = $this->shelve->getInvoiceProductModal($request);
        return json_encode($this->resp);
    }

    public function getWarehouseDropdown(Request $request)
    {
        $this->resp = $this->shelve->getWarehouseDropdown($request);
        return json_encode($this->resp);
    }

    public function postStore(Request $request)
    {
        $this->resp = $this->shelve->postStore($request);

        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }
}

