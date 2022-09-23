<?php
namespace App\Http\Controllers\Admin;
use DB;
use PDF;
use Auth;
use App\Models\Vendor;
use App\Models\Packing;
use App\Models\Shipment;
use App\Models\Category;
use App\Models\Warehouse;
use App\Models\Packaging;
use App\Models\Shipmentbox;
use App\Traits\RepoResponse;
use App\Models\ShipmentSign;
use Illuminate\Http\Request;
use App\Models\ShippingAddress;
use App\Models\ShippingAddressSet;
use App\Http\Controllers\BaseController;
use App\Repositories\Admin\Packaging\PackagingInterface;

class PackagingController extends BaseController
{
    use RepoResponse;
    private $packagingInt;
    private $warehouse;
    private $shipmodel;
    private $shipmentbox;
    private $category;
    private $ShippingAddress;
    private $shipmentSign;

    function __construct(PackagingInterface $packagingInt, Warehouse $warehouse, Shipment $shipmodel, Shipmentbox $shipmentbox, Vendor $vendor, Category $category, ShipmentSign $shipmentSign, ShippingAddress $ShippingAddress )
    {

        $this->packagingInt       = $packagingInt;
        $this->warehouse          = $warehouse;
        $this->shipmodel          = $shipmodel;
        $this->shipmentbox        = $shipmentbox;
        $this->category           = $category;
        $this->ShippingAddress     = $ShippingAddress;
        $this->shipmentSign       = $shipmentSign;
    }




    public function getEdit(Request $request, $shipment_no)
    {
        if (Auth::user()->F_MERCHANT_NO > 0) {
            return redirect()->back()->with('flashMessageError','You do not have permission to access this page!');
        }
        $this->resp             = $this->packagingInt->findOrThrowException($shipment_no);
        if($this->resp->data['data'] && count($this->resp->data['data']) < 1){
            return redirect()->back();
        }

        $data['rows']           = $this->resp->data['data'];
        $data['packing_list']   = $this->resp->data['packing_list'];
        $data['category_combo'] = $this->resp->data['category'];
        $data['box_combo']      = $this->resp->data['box_combo'];
        $data['shipment_info']  = $this->resp->data['shipment_info'];
        return view('admin.packaging.edit', compact('data'));
    }

    public function getEndPackaging(Request $request, $shipment_no)
    {
        if (Auth::user()->F_MERCHANT_NO > 0) {
            return redirect()->back()->with('flashMessageError','You do not have permission to access this page!');
        }
        $this->resp             = $this->packagingInt->findOrThrowException($shipment_no);
        if($this->resp->data['data'] && count($this->resp->data['data']) < 1){
            return redirect()->back();
        }
        $data['rows']               = $this->resp->data['data'];
        $data['packing_list']       = $this->resp->data['packing_list'];
        $data['category_combo']     = $this->resp->data['category'];
        $data['box_combo']          = $this->resp->data['box_combo'];
        $data['shipment_info']      = $this->resp->data['shipment_info'];
        $data['shipment_address']   = $this->ShippingAddress->where('IS_ACTIVE',1)->get();
        $data['shipment_sign']      = $this->shipmentSign->get();
        return view('admin.packaging.end_packing', compact('data'));
    }

    public function postPackagingboxStore(Request $request)
    {
        if (Auth::user()->F_MERCHANT_NO > 0) {
            return redirect()->back()->with('flashMessageError','You do not have permission to access this page!');
        }
        $this->resp            = $this->packagingInt->postPackagingboxStore($request);
        return redirect()->back()->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function gePackagingListInfo(Request $request, $key, $type)
    {
        if (Auth::user()->F_MERCHANT_NO > 0) {
            return redirect()->back()->with('flashMessageError','You do not have permission to access this page!');
        }
        $data                   = array();
        $data['key']            = $key;
        $this->resp             = $this->packagingInt->gePackagingListInfo($key, $type);
        $data['row']            = $this->resp->data;
        return response()->json($data);
    }

    public function postPackingItemStore(Request $request)
    {
        if (Auth::user()->F_MERCHANT_NO > 0) {
            return redirect()->back()->with('flashMessageError','You do not have permission to access this page!');
        }
        $this->resp2            = $this->packagingInt->postPackingItemStore($request);
        $this->resp             = $this->packagingInt->findOrThrowException($request->shipment_no);
        $data['rows']           = $this->resp->data['data'];
        $data['packing_list']   = $this->resp->data['packing_list'];
        $html = view('admin.packaging._packing_item',compact('data'))->render();
        $this->resp2->html  = $html;
        return response()->json($this->resp2);
    }



    public function postDeleteItem(Request $request)
    {
        if (Auth::user()->F_MERCHANT_NO > 0) {
            return redirect()->back()->with('flashMessageError','You do not have permission to access this page!');
        }
        $this->resp2            = $this->packagingInt->postPackingItemDelete($request);
        $this->resp             = $this->packagingInt->findOrThrowException($request->shipment_no);
        $data['rows']           = $this->resp->data['data'];
        $data['packing_list']   = $this->resp->data['packing_list'];
        $html = view('admin.packaging._packing_item',compact('data'))->render();
        $this->resp2->html  = $html;
        return response()->json($this->resp2);
    }


    public  function getVariantInfoLike(Request $request)
    {
        if (Auth::user()->F_MERCHANT_NO > 0) {
            return redirect()->back()->with('flashMessageError','You do not have permission to access this page!');
        }
        $key    = $request->get('q');
        $shop_id = $request->get('shop_id');
        if($request->type == 'barcode') {
            $result = DB::table('PRD_VARIANT_SETUP');
            $pieces = explode(" ", $key);
                    if($pieces){
                        foreach ($pieces as $key => $piece) {
                            $result->where('VARIANT_NAME', 'LIKE', '%' . $piece . '%');
                            $result->where('KEYWORD_SEARCH', 'LIKE', '%' . $piece . '%');
                        }
                    }
            $result = $result->select('VARIANT_NAME as NAME', 'BARCODE as BAR_CODE','PRIMARY_IMG_RELATIVE_PATH','PK_NO')->get();
        }else{
              $result = DB::table('PRD_VARIANT_SETUP')->select('VARIANT_NAME as NAME', 'MRK_ID_COMPOSITE_CODE as IG_CODE','PRIMARY_IMG_RELATIVE_PATH')->where('KEYWORD_SEARCH', 'LIKE', '%'.$key. '%')->get();
        }

        foreach ($result as $key => $value) {
           $checkAssign =  DB::table('PRD_SHOP_VARIANT_MAP')->where('F_SHOP_NO',$shop_id)->where('F_PRD_VARIANT_NO',$value->PK_NO)->first();
           if(!empty($checkAssign)){
            $value->IS_ASSIGNED = 'enabled';
            $value->MSG = '';
           }else{
            $value->IS_ASSIGNED = 'disabled';
            $value->MSG = 'This product not assigned for this shop';
           }
           $value->PRIMARY_IMG_RELATIVE_PATH = fileExit($value->PRIMARY_IMG_RELATIVE_PATH);
        }

        // dd($result);
        return response()->json($result);
    }


    public function postPackingItemUpdate(Request $request)
    {
        if (Auth::user()->F_MERCHANT_NO > 0) {
            return redirect()->back()->with('flashMessageError','You do not have permission to access this page!');
        }
        $this->resp            = $this->packagingInt->postPackingItemUpdate($request);
        return redirect()->back()->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getPackaginglistPDF(Request $request, $shipment_no)
    {
        $data = array();
        $data['shipment_info']      = Shipment::find($request->shipment_no);
        if (Auth::user()->F_MERCHANT_NO > 0 && ($data['shipment_info']->F_MERCHANT_NO != Auth::user()->F_MERCHANT_NO)) {
            return redirect()->back()->with('flashMessageError','You do not have permission to access this page!');
        }
        $data['data']           = Packing::where('F_SHIPMENT_NO',$shipment_no)->orderBy('BOX_SERIAL_NO','ASC')->get();
        $data['box_summary']    = Packing::select('PK_NO', 'F_SHIPMENT_NO', 'SHIPMENT_NAME', 'BOX_SERIAL_NO', 'F_BOX_NO','BOX_SERIAL_NO', DB::RAW('SUM(QTY) AS BOX_QTY'), DB::RAW('SUM(TOTAL_PRICE) AS BOX_TOTAL_PRICE'), DB::RAW('SUM(MER_TOTAL_PRICE) AS MER_BOX_TOTAL_PRICE'))->where('F_SHIPMENT_NO',$shipment_no)->groupBy('BOX_SERIAL_NO')->orderBy('BOX_SERIAL_NO','ASC')->get();

        $data['hscode_summary']    = Packing::select('HS_CODE', DB::RAW('GROUP_CONCAT(DISTINCT(SUBCATEGORY_NAME )) AS UNIQUE_SUBCATEGORY_NAME'), DB::RAW('SUM(QTY) AS BOX_QTY'), DB::RAW('SUM(TOTAL_PRICE) AS BOX_TOTAL_PRICE'), DB::RAW('SUM(MER_TOTAL_PRICE) AS MER_BOX_TOTAL_PRICE'))->where('F_SHIPMENT_NO',$shipment_no)->groupBy('HS_CODE')->orderBy('BOX_SERIAL_NO','ASC')->get();

        $data['shipment_address']   = ShippingAddressSet::where('F_SHIPPMENT_NO',$request->shipment_no)->get();

        $fileName       = $shipment_no.'P.pdf';
        $data['price']  = $request->price;
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadView('admin.packaging.packing_list_pdf', compact('data'));
        set_time_limit(300);
        return $pdf->download($fileName);


    //   return view('admin.packaging.packing_list_pdf', compact('data'));
    //     return  $pdf->download($fileName);

    }



    public function getPackaginglistCommarcialpdf(Request $request, $shipment_no)
    {
        $data = array();
        $data['shipment_info']      = Shipment::find($request->shipment_no);
        if (Auth::user()->F_MERCHANT_NO > 0 && ($data['shipment_info']->F_MERCHANT_NO != Auth::user()->F_MERCHANT_NO)) {
            return redirect()->back()->with('flashMessageError','You do not have permission to access this page!');
        }
        $data['shipment_address']   = ShippingAddressSet::where('F_SHIPPMENT_NO',$request->shipment_no)->get();
        $data['box_summary']    = Packaging::select('PK_NO', 'F_SHIPMENT_NO', 'SHIPMENT_NAME', 'BOX_SERIAL_NO', 'F_BOX_NO','BOX_SERIAL_NO', 'WIDTH_CM', 'LENGTH_CM', 'HEIGHT_CM', 'WEIGHT_KG')->where('F_SHIPMENT_NO',$shipment_no)->orderBy('BOX_SERIAL_NO','ASC')->get();

        // $pdf                        = PDF::loadView('admin.packaging.packing_list_commercial_pdf', compact('data'));
        $fileName                   = $shipment_no.'C.pdf';

        //return view('admin.packaging.packing_list_commercial_pdf', compact('data'));

        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadView('admin.packaging.packing_list_commercial_pdf', compact('data'));
        set_time_limit(300);
        return $pdf->download($fileName);
    }


    public function getPackaginglistPdfWithInvoice(Request $request, $shipment_no)
    {
        if (Auth::user()->F_MERCHANT_NO > 0) {
            return redirect()->back()->with('flashMessageError','You do not have permission to access this page!');
        }
        $data = array();
        $data['data']           = Packing::where('F_SHIPMENT_NO',$shipment_no)->orderBy('BOX_SERIAL_NO','ASC')->get();

        $data['box_summary']    = Packing::select('SC_PACKING_LIST.PK_NO', 'SC_PACKING_LIST.F_SHIPMENT_NO', 'SC_PACKING_LIST.SHIPMENT_NAME', 'SC_PACKING_LIST.BOX_SERIAL_NO', 'SC_PACKING_LIST.F_BOX_NO', DB::RAW('SUM(SC_PACKING_LIST.QTY) AS BOX_QTY'), DB::RAW('SUM(SC_PACKING_LIST.TOTAL_PRICE) AS BOX_TOTAL_PRICE'), 'SC_PACKAGING_LIST.INVOICE_DETAILS')
        ->leftJoin('SC_PACKAGING_LIST', function($join)
        {
            $join->on('SC_PACKING_LIST.F_SHIPMENT_NO', '=', 'SC_PACKAGING_LIST.F_SHIPMENT_NO');
            $join->on('SC_PACKING_LIST.BOX_SERIAL_NO','=', 'SC_PACKAGING_LIST.BOX_SERIAL_NO');
        })
        ->where('SC_PACKING_LIST.F_SHIPMENT_NO',$shipment_no)
        ->groupBy('SC_PACKING_LIST.BOX_SERIAL_NO')
        ->orderBy('SC_PACKING_LIST.BOX_SERIAL_NO','ASC')
        ->get();

        $data['hscode_summary']    = Packing::select('HS_CODE', DB::RAW('GROUP_CONCAT(DISTINCT(SUBCATEGORY_NAME )) AS UNIQUE_SUBCATEGORY_NAME'), DB::RAW('SUM(QTY) AS BOX_QTY'), DB::RAW('SUM(TOTAL_PRICE) AS BOX_TOTAL_PRICE'))->where('F_SHIPMENT_NO',$shipment_no)->groupBy('HS_CODE')->orderBy('BOX_SERIAL_NO','ASC')->get();

        $data['shipment_info']      = Shipment::find($request->shipment_no);
        $data['shipment_address']   = ShippingAddressSet::where('F_SHIPPMENT_NO',$request->shipment_no)->get();
        set_time_limit(300);
        $fileName                   = $shipment_no.'PI.pdf';
        //return view('admin.packaging.packing_list_pdf_with_invoice', compact('data'));
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadView('admin.packaging.packing_list_pdf_with_invoice', compact('data'));
        set_time_limit(300);
        return $pdf->download($fileName);

    }





}

