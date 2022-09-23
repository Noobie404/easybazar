<?php

namespace App\Http\Controllers\Admin;

use DB;
use Carbon\Carbon;
use App\Models\Booking;
use App\Models\Product;
use App\Models\BestSell;
use App\Traits\RepoResponse;
use Illuminate\Http\Request;
use App\Models\BookingDetails;
use App\Models\ProductVariant;
use App\Models\BestSellMasterDetail;
use App\Http\Controllers\BaseController;
use App\Repositories\Admin\SalesReport\SalesReportInterface;

class SalesReportController extends BaseController
{
    use RepoResponse;

    private $salesreportInt;
    private $booking;
    private $booking_details;

    function __construct(SalesReportInterface $salesreportInt, Booking $booking, BookingDetails $booking_details)
    {
        $this->salesreportInt    = $salesreportInt;
        $this->booking           = $booking;
        $this->booking_details   = $booking_details;
    }

    public function getIndex()
    {
        return view('admin.salesReport.index');
    }

    public function getComissionReport($id)
    {
        $this->resp = $this->salesreportInt->getComissionReport($id);
        return view('admin.salesReport.sales_comission_view')->withReport($this->resp->data);
    }

    public function getYetToShip(Request $request)
    {
        $this->resp = $this->salesreportInt->getYetToShip($request);
        return view('admin.salesReport.yet_to_ship')->withReport($this->resp->data);
    }

    public function ajaxComissionReport($agent_id,$date)
    {
        $this->resp = $this->salesreportInt->ajaxComissionReport($agent_id,$date);
        return response()->json($this->resp);
    }
    public function topSell(Request $request)
    {
        $branch = DB::table('SA_USER')->where('USER_TYPE',10)->where('F_PARENT_USER_ID',0)->pluck('SHOP_NAME', 'PK_NO');
        $data['branch'] = $branch;
        $data['top_sell'] = $this->salesreportInt->topSell($request);
        return view('admin.salesReport.top_sell', compact('data'));
    }


    public function topSellCreate(Request $request)
    {
        $this->validate($request, [
            'branch_id'     => 'required',
            'from_date'     => 'required',
            'to_date'       => 'required',
            'max_variant'   => 'required',
        ]);

        $this->resp = $this->salesreportInt->topSellCreate($request);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function topSellView(Request $request, $id)
    {
        // $dataSet = DB::table("PRD_BEST_SELL_MASTER_DETAIL as p")
        // ->select('p.PK_NO','p.F_BEST_SELL_MASTER_NO','p.F_PRD_MASTER_SETUP_NO','p.QTY','p.SELL_AMOUNT','p.ORDER_ID', 'p.IS_MANUL','PRD_MASTER_SETUP.DEFAULT_NAME', 'p.TOTAL_BEST_SELL_VARIANT')
        // ->leftJoin('PRD_MASTER_SETUP','PRD_MASTER_SETUP.PK_NO','p.F_PRD_MASTER_SETUP_NO')
        // ->where('p.F_BEST_SELL_MASTER_NO',6)
        // ->orderBy('p.ORDER_ID', 'DESC');
        // dd($dataSet->get());

        $data = BestSell::find($id);
        return view('admin.salesReport.top_sell_view',compact('data'));
    }

    public function getTopSellVariant(Request $request, $id)
    {

        // $this->resp = $this->salesreportInt->getTopSellVariant($request,$id);
        // $data = $this->resp->data;
        $top_sell_master   = BestSellMasterDetail::find($id);
        $data['master'] = Product::find($top_sell_master->F_PRD_MASTER_SETUP_NO);
        $data['top_sell_master'] = $top_sell_master;

        return view('admin.salesReport.top_sell_variant_view',compact('data'));
    }

    public function getTopSellPdf(Request $request, $id)
    {
        $topSell = DB::table("PRD_VARIANT_BEST_SELL_DETAIL as p")
        ->select('p.PK_NO','p.F_BEST_SELL_MASTER_NO','p.F_PRD_VARIANT_NO','p.VARIANT_NAME','p.QTY','p.SELL_AMOUNT','p.ORDER_ID')
        ->where('F_BEST_SELL_MASTER_NO',$id)
        ->orderBy('p.ORDER_ID', 'DESC')
        ->get();

        $pdf_generate = BestSell::find($id);
        $pdf          = \App::make('dompdf.wrapper');
        $now          = Carbon::now();
        $time         = date('Y-m-d', strtotime($now));
        $primary_path = \public_path('media/top_sell');
        $alt_path     = 'media/top_sell/';
        $fileName     = $time . '-' . $pdf_generate->PK_NO . '.' . 'pdf' ;
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadView('admin.salesReport.top_sell_pdf', compact('topSell'));
        $pdf->save($primary_path . '/' . $fileName);

        $pdf_generate->PDF_PATH = $alt_path.$fileName;
        $pdf_generate->save();
        set_time_limit(300);
        return redirect()->back();
    }

    public function topSellDelete(Request $request)
    {
        $data =  $this->salesreportInt->topSellDelete($request);
        return response()->json($data);
    }

    public function topSellVariantDelete(Request $request)
    {
        $data =  $this->salesreportInt->topSellVariantDelete($request);
        return response()->json($data);
    }


    public function topSellOrderidUpdate(Request $request){
        $data = $this->salesreportInt->topSellOrderidUpdate($request);
        return response()->json($data);
    }

    public function topSellVariantOrderidUpdate(Request $request){
        $data = $this->salesreportInt->topSellVariantOrderidUpdate($request);
        return response()->json($data);
    }

    public function postTopSellMasterStore(Request $request){

        $data = $this->salesreportInt->postTopSellMasterStore($request);

        return response()->json($data);
    }

    public function postTopSellVaraitnStore(Request $request){
        $data = $this->salesreportInt->postTopSellVaraitnStore($request);
        return response()->json($data);
    }

    public function getTopSellMaster(Request $request)
    {
        $search = $request->search;
        if($search == ''){
           $products = Product::orderby('DEFAULT_NAME','asc')->select('PK_NO','DEFAULT_NAME')->limit(20)->get();
        }else{
           $products = Product::orderby('DEFAULT_NAME','asc')->select('PK_NO','DEFAULT_NAME');
           $pieces = explode(" ", $search);
           if($pieces){
               foreach ($pieces as $key => $piece) {
                $products->where('DEFAULT_NAME', 'LIKE', '%' . $piece . '%');
               }
           }
           $products = $products->limit(20)->get();
        }
        $response = array();
        foreach($products as $item){
           $response[] = array(
                "id"=>$item->PK_NO,
                "text"=>$item->DEFAULT_NAME
           );
        }
        return response()->json($response);
    }

    public function getNotTopSellVariant(Request $request, $id)
    {
        $top_sell_master   = BestSellMasterDetail::find($id);
        $master_no = $top_sell_master->F_PRD_MASTER_SETUP_NO;
        $f_best_sell_master_no = $top_sell_master->F_BEST_SELL_MASTER_NO;
        $f_shop_no = $top_sell_master->F_SHOP_NO;
        $search = $request->search;
        if($search == ''){
           $products = ProductVariant::select('PRD_VARIANT_SETUP.PK_NO','PRD_VARIANT_SETUP.VARIANT_NAME')
           ->leftJoin('PRD_BEST_SELL_VARIANT_DETAIL', function($join) use ($master_no,$f_best_sell_master_no){
                $join->on('PRD_VARIANT_SETUP.PK_NO', '=', 'PRD_BEST_SELL_VARIANT_DETAIL.F_PRD_VARIANT_NO');
                $join->on('PRD_BEST_SELL_VARIANT_DETAIL.F_PRD_MASTER_SETUP_NO','=',DB::raw($master_no));
                $join->on('PRD_BEST_SELL_VARIANT_DETAIL.F_BEST_SELL_MASTER_NO','=',DB::raw($f_best_sell_master_no));
            })
            ->join('PRD_SHOP_VARIANT_MAP', function($join) use ($f_shop_no){
                $join->on('PRD_VARIANT_SETUP.PK_NO', '=', 'PRD_SHOP_VARIANT_MAP.F_PRD_VARIANT_NO');
                $join->on('PRD_SHOP_VARIANT_MAP.F_SHOP_NO','=',DB::raw($f_shop_no));

            })
           ->whereNull('PRD_BEST_SELL_VARIANT_DETAIL.F_BEST_SELL_MASTER_NO')
           ->where('PRD_VARIANT_SETUP.F_PRD_MASTER_SETUP_NO',$master_no)
           ->orderby('PRD_VARIANT_SETUP.VARIANT_NAME','ASC')
           ->limit(20)
           ->get();
        }else{

           $products = ProductVariant::select('PRD_VARIANT_SETUP.PK_NO','PRD_VARIANT_SETUP.VARIANT_NAME')
           ->leftJoin('PRD_BEST_SELL_VARIANT_DETAIL', function($join) use ($master_no,$f_best_sell_master_no){
                $join->on('PRD_VARIANT_SETUP.PK_NO', '=', 'PRD_BEST_SELL_VARIANT_DETAIL.F_PRD_VARIANT_NO');
                $join->on('PRD_BEST_SELL_VARIANT_DETAIL.F_PRD_MASTER_SETUP_NO','=', DB::raw($master_no));
                $join->on('PRD_BEST_SELL_VARIANT_DETAIL.F_BEST_SELL_MASTER_NO','=', DB::raw($f_best_sell_master_no));
            })
            ->join('PRD_SHOP_VARIANT_MAP', function($join) use ($f_shop_no){
                $join->on('PRD_VARIANT_SETUP.PK_NO', '=', 'PRD_SHOP_VARIANT_MAP.F_PRD_VARIANT_NO');
                $join->on('PRD_SHOP_VARIANT_MAP.F_SHOP_NO','=',DB::raw($f_shop_no));

            })
          ->whereNull('PRD_BEST_SELL_VARIANT_DETAIL.F_BEST_SELL_MASTER_NO')
           ->where('PRD_VARIANT_SETUP.F_PRD_MASTER_SETUP_NO',$master_no)
           ->orderby('PRD_VARIANT_SETUP.VARIANT_NAME','ASC');

           $pieces = explode(" ", $search);
           if($pieces){
               foreach ($pieces as $key => $piece) {
                $products->where('PRD_VARIANT_SETUP.VARIANT_NAME', 'LIKE', '%' . $piece . '%');
               }
           }
           $products = $products->limit(20)->get();
        }

        $response = array();
        foreach($products as $item){
           $response[] = array(
                "id"=>$item->PK_NO,
                "text"=>$item->VARIANT_NAME
           );
        }
        return response()->json($response);
    }




}

