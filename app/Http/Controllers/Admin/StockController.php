<?php

namespace App\Http\Controllers\Admin;

use DB;
use Auth;
use App\Models\Stock;
use App\Traits\RepoResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Repositories\Admin\Stock\StockInterface;


class StockController extends BaseController
{
    use RepoResponse;

    private $stock;


    function __construct(StockInterface $stock)
    {

        $this->stock         = $stock;

    }



    public function getAllStockList(Request $request)
    {
        $this->resp = $this->stock->getAllStockList($request);
        if(Auth::user()->USER_TYPE == 10 ){
            $shop_id  = Auth::user()->SHOP_ID;
            $store = DB::table('SA_USER')->where('PK_NO',$shop_id)->pluck('SHOP_NAME', 'PK_NO');
        }else{
            $store = DB::table('SA_USER')->where('USER_TYPE',10)->where('F_PARENT_USER_ID',0)->pluck('SHOP_NAME', 'PK_NO');
        }
        return view('admin.stock.index')->withRows($this->resp->data)->withstore($store);
    }

    public function getStockDetail(Request $request)
    {
        $this->resp = $this->stock->getStockDetail($request);
        return json_encode($this->resp);
    }



}

