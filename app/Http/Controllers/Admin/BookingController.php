<?php

namespace App\Http\Controllers\Admin;

use PDF;
use App\Models\Stock;
use App\Models\Booking;
use App\Models\Country;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Models\CustomerAddress;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use Symfony\Component\Console\Helper\Helper;
use App\Http\Requests\Admin\DeliveryBulkRequest;
use App\Http\Requests\Admin\AssignDeliveryRequest;
use App\Http\Requests\Admin\CartToCheckoutRequest;
use App\Repositories\Admin\Booking\BookingInterface;
use App\Http\Requests\Admin\bookingStatusBulkUpdateRequest;

class BookingController extends BaseController
{
    protected $bookingInt;
    protected $booking_model;
    protected $customer;
    protected $prd_variant;
    protected $country;

    public function __construct(
        BookingInterface $bookingInt, 
        Booking $booking_model, 
        Customer $customer, 
        ProductVariant $prd_variant, 
        Country $country)
    {
        $this->customer        = $customer;
        $this->bookingInt      = $bookingInt;
        $this->booking_model   = $booking_model;
        $this->prd_variant     = $prd_variant;
        $this->country         = $country;
    }

    public function getIndex(Request $request, $id = null, $type = null)
    {
        /*
        $this->resp = $this->bookingInt->getPaginatedList($request, $id, $type);
        $info['type'] = '';

        if ($id != null && $type != null) {
            if ($type=='customer') {
                $info = $this->customer->select('PK_NO','NAME','MOBILE_NO','EMAIL','CUSTOMER_NO')->where('PK_NO',$id)->first();
                $info['type'] = $type;
            }else{
                $info = $this->reseller->select('PK_NO','NAME','MOBILE_NO','EMAIL','POST_CODE','RESELLER_NO')->where('PK_NO',$id)->first();
                $info['type'] = $type;
            }
        }
        */
        // return view('admin.booking.index')->withRows($this->resp->data)->withInfo($info);

        // dd(1);
        if(Auth::user()->USER_TYPE == 10 ){
            $shop_id  = Auth::user()->SHOP_ID;
            $data['branch'] = DB::table('SA_USER')->where('PK_NO',$shop_id)->pluck('SHOP_NAME', 'PK_NO');
        }else{
            $data['branch'] = DB::table('SA_USER')->where('USER_TYPE',10)->where('F_PARENT_USER_ID',0)->pluck('SHOP_NAME', 'PK_NO');
        }

        return view('admin.booking.index',compact('data'));

    }

    public function search(Request $request,$branch_id)
    {
         $result = Stock::select('PRD_VARINAT_NAME','IG_CODE','PRD_VARIANT_IMAGE_PATH')
        ->whereRaw('( (BOOKING_STATUS IS NULL OR BOOKING_STATUS = 0 OR BOOKING_STATUS = 90) and (PRODUCT_STATUS IS NULL OR PRODUCT_STATUS < 420) ) ')
        ->where('F_SHOP_NO',$branch_id);


        if($request->get('q')){
            $pieces = explode(" ", $request->get('q'));
            if($pieces){
                foreach ($pieces as $key => $piece) {
                    $result->where('PRD_VARINAT_NAME', 'LIKE', '%' . $piece . '%');
                    // $result->Where('PRD_VARIANT_SETUP.IG_CODE', 'LIKE', '%' . $piece . '%');
                }
            }
            $result->orWhere('IG_CODE',$request->get('q'));
            $result->orWhere('BARCODE',$request->get('q'));
        }

        $result =  $result->groupBy('IG_CODE')->get();
        if($result){
            foreach ($result as $key => $value) {
                $value->PRD_VARIANT_IMAGE_PATH = fileExit($value->PRD_VARIANT_IMAGE_PATH);
            }
        }
     

        return $result;
    }


    public function getCusInfo(Request $request)
    {
        $table = 'SLS_CUSTOMERS';
        // if ($request->type == 'reseller') {
        //     $table = 'SLS_RESELLERS';
        // }
        $this->resp = $this->bookingInt->getCusInfo($table,$request->customer);
        return json_encode($this->resp);
    }

    public function getCustomer(Request $request)
    {
         $result = DB::table('SLS_CUSTOMERS')->select('NAME','PK_NO')->where('NAME', 'LIKE', '%'. $request->get('q'). '%')->orWhere('MOBILE_NO', 'LIKE', '%'. $request->get('q'). '%')->orwhere('CUSTOMER_NO', 'LIKE', '%'. $request->get('q'). '%')->get();
        return $result;
    }

    public function getProductINV(Request $request)
    {
        $this->resp = $this->bookingInt->getProductINV($request->product, $request->branch_id);
        return $this->resp;
    }

    // public function postStore(Request $request)
    // {
    //     $this->resp = $this->bookingInt->postStore($request);
    //     return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    // }

    public function getCreate($id=null,$type=null)
    {
        $info = '';
        if ($id != null && $type != null) {
            if ($type=='customer') {
                $info = $this->customer->select('PK_NO','NAME','MOBILE_NO','EMAIL','CUSTOMER_NO')->where('PK_NO',$id)->first();
                $info['POST_CODE'] = CustomerAddress::select('POST_CODE')->where('F_CUSTOMER_NO',$id)->where('F_ADDRESS_TYPE_NO',1)->first();
                $info['POST_CODE'] = $info['POST_CODE']->POST_CODE ?? 0;
                $info['type'] = $type;

            }else{
                $info = $this->reseller->select('PK_NO','NAME','MOBILE_NO','EMAIL','POST_CODE','RESELLER_NO')->where('PK_NO',$id)->first();
                $info['POST_CODE'] = $info->POST_CODE ?? 0;
                $info['type'] = $type;
            }
        }
        $customer   = $this->customer->getCustomerCombo();
        // $reseller   = $this->reseller->getResellerCombo();
        $country    = $this->country->getCountryComboWithCode();

        return view('admin.booking.create')
        ->withCustomer($customer)
        // ->withReseller($reseller)
        ->withCountry($country)
        ->withInfo($info);
    }

    public function searchBook(Request $request)
    {
        $customer   = $this->customer->getCustomerCombo();
        $country    = $this->country->getCountryComboWithCode();
        $branch = $area = $subarea = [];


        if(Auth::user()->USER_TYPE == 10 ){
            $shop_id  = Auth::user()->SHOP_ID;
            $branch   = DB::table('SA_USER')->where('PK_NO',$shop_id)->get();
        }else{
            $branch   = DB::table('SA_USER')->where('USER_TYPE',10)->where('F_PARENT_USER_ID',0)->get();
        }
        $city = DB::table('SS_SHOP_AREA_COVERAGE')->where('F_SHOP_NO',$request->branch_id)->groupBy('F_CITY_NO')->get();
        if(count($city)>0){
            $f_area_no = $city[0]->F_AREA_NO;
            $area = DB::table('SS_SHOP_AREA_COVERAGE')->where('F_SHOP_NO',$request->branch_id)->where('F_AREA_NO',$f_area_no)->groupBy('F_AREA_NO')->get();

            if(count($area)>0){
                $f_sub_area_no = $area[0]->F_SUB_AREA_NO;
                $subarea = DB::table('SS_SHOP_AREA_COVERAGE')->where('F_SHOP_NO',$request->branch_id)->where('F_SUB_AREA_NO',$f_sub_area_no)->groupBy('F_SUB_AREA_NO')->get();
            }
        }
        $data['delivery_schedules'] = DB::table('SLS_DELIVERY_SCHEDULE')->orderBy('SLOT_TO','ASC')->get(); 

        return view('admin.booking.search_book')
        ->withCustomer($customer)
        ->withBranch($branch)
        ->withCountry($country)
        ->withCity($city)
        ->withArea($area)
        ->with('data',$data)
        ->withSubarea($subarea);
    }
    public function getDeliveryCost(Request $request){
        return getOrderDeliveryCost($request->total_order_price,$request->branch_id);
    }

    public function getEdit(Request $request, $PK_NO)
    {
        $customer   = $this->customer->getCustomerCombo();
        $this->resp = $this->bookingInt->findOrThrowException($PK_NO,'edit');
        $data       = $this->resp->data;
        $delivery_schedules = DB::table('SLS_DELIVERY_SCHEDULE')->orderBy('SLOT_TO','ASC')->get(); 
        return view('admin.booking.edit')
        ->withCustomer($customer)
        ->with('delivery_schedules',$delivery_schedules)
        ->withData($data);
    }

    public function getView(Request $request, $PK_NO)
    {
        $customer   = $this->customer->getCustomerCombo();
        $this->resp = $this->bookingInt->findOrThrowException($PK_NO,'edit');
        $data       = $this->resp->data;
        return view('admin.booking.view')
        ->withCustomer($customer)
        ->withData($data);
    }
    

    public function deliveryAddressUpdate(Request $request, $id){
        $bok = Booking::where('PK_NO',$id)->update([
            'DELIVERY_NAME'             => $request->delivery_name,
            'DELIVERY_MOBILE'           => $request->delivery_mobile,
            'DELIVERY_ADDRESS_LINE_1'   => $request->delivery_address_line_1,
            'DELIVERY_STATE'            => $request->state_id,
            'DELIVERY_CITY'             => $request->city_id,
            'DELIVERY_AREA_NAME'        => $request->area_id,
            'DELIVERY_SUB_AREA_NAME'    => $request->sub_area_id,
            'DELIVERY_POSTCODE'         => $request->delivery_postcode,
        ]);
        if($bok){
            $resp['data'] = $request->all();
            $resp['status'] = true;
            $resp['status'] = 'Delivery address updated successful';
        }else{
            $resp['status'] = false;
            $resp['status'] = 'Delivery address not updated successful';
        }
        return response()->json($resp);

    }


    public function postStore(Request $request, $PK_NO,$type = null)
    {
        $this->resp = $this->bookingInt->postStore($request, $PK_NO,$type);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }
  
    public function postUpdate(Request $request, $PK_NO)
    {
        $response = $this->bookingInt->postUpdate($request, $PK_NO);
        return response()->json($response, $response->code);
    }


    public function postCartStoreAjax(CartToCheckoutRequest $request)
    {
        $response = $this->bookingInt->postCartStoreAjax($request);
        return response()->json($response, $response->code);
    }
    
    public function updateApplyCoupon(CartToCheckoutRequest $request)
    {
        $response = $this->bookingInt->updateApplyCoupon($request);
        return response()->json($response, $response->code);
    }
   
    
    public function postCheckOffer(Request $request, $PK_NO = 0, $type = 'checkoffer')
    {
        $this->resp = $this->bookingInt->postUpdate($request, $PK_NO, $type);
        $data = $this->bookingInt->postCheckOffer($this->resp->data);
        $this->resp->html =  $data;
        return response()->json($this->resp);
    }


    public function getDelete($PK_NO)
    {
        $this->resp = $this->bookingInt->delete($PK_NO);
        return redirect()->back()->with($this->resp->redirect_class, $this->resp->msg);
    }
    /*
    public function postOfferApply(Request $request)
    {
        $this->resp = $this->bookingInt->postOfferApply($request);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }
    */

    public function callProcedure()
    {

        DB::beginTransaction();
        try {

            DB::table('R')->insert([
                'R' => '1'
            ]);
            DB::commit();
        } catch(\Exception $e){

        DB::rollback();
        }
        echo 'ok';
        exit();
        DB::beginTransaction();
        try {
            DB::statement('CALL PROC_SLS_BOOKING_CHECK_EXPIRE(@OUT_STATUS);');
            $prc = DB::select('select @OUT_STATUS as OUT_STATUS');
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
        echo 'ok';
    }

    public function getDownloadPDF(Request $request, $PK_NO)
    {
        $currency_code = 'BDT';
        $this->resp = $this->bookingInt->getDownloadPDF($request,$PK_NO);
        $font_family = "'Roboto','sans-serif'";
        if($this->resp->status){
            $data = $this->resp->data;
              return PDF::loadView('admin.booking.invoice',[
            'data' => $data,
            'font_family' => $font_family
        ])->download('order-'.$data['booking']->PK_NO.'.pdf');

        }
        else{
            return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
        }
    }

    public function assignDeliveryman(AssignDeliveryRequest $request)
    {
        $this->resp = $this->bookingInt->assignDeliveryman($request);
        return response()->json($this->resp);

    }
    public function postBulkUpdate(bookingStatusBulkUpdateRequest $request)
    {
        $this->resp = $this->bookingInt->bookingStatusBulkUpdate($request);
        return response()->json($this->resp);
    }

    public function bulkAssignDeliveryMan(DeliveryBulkRequest $request)
    {
        $this->resp = $this->bookingInt->bulkAssignDeliveryMan($request);
        return response()->json($this->resp);
    }


    

    


}
