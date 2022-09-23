<?php

namespace App\Http\Controllers\Admin;
use DB;
use App\Models\City;
use App\Models\Agent;
use App\Models\State;
use App\Models\PoCode;
use App\Models\Seller;
use App\Models\Address;
use App\Models\Country;
use App\Models\SellerArea;
use Illuminate\Http\Request;
use App\Models\CustomerAddress;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\SellerRequest;
use App\Repositories\Admin\Seller\SellerInterface;
use App\Repositories\Admin\Payment\PaymentInterface;
use App\Repositories\Admin\Customer\CustomerInterface;
use App\Repositories\Admin\CustomerAddress\CustomerAddressAbstract;



class SellerController extends BaseController
{
    protected $seller;
    protected $paymentInt;
    protected $customer;
    protected $state;
    protected $sellerArea;

    public function __construct(
        SellerInterface $seller,
        Agent $agent,
        Seller $sellermodel,
        Country $country,
        CustomerAddressAbstract $customerAddInt,
        PaymentInterface $paymentInt,
        CustomerInterface $customer,
        State $state,
        SellerArea $sellerArea
        )
    {
        $this->seller          = $seller;
        $this->agent           = $agent;
        $this->sellermodel     = $sellermodel;
        $this->country         = $country;
        $this->customerAddInt  = $customerAddInt;
        $this->paymentInt      = $paymentInt;
        $this->customer        = $customer;
        $this->state           = $state;
        $this->sellerArea      = $sellerArea;

    }

    public function getIndex(Request $request)
    {

        $data['title']  = 'Seller list';
        $this->resp     = $this->seller->getPaginatedList($request, 20);
        $data['rows']   = $this->resp->data;
        $data['regions'] =  $this->state->getStateCombo();
        // dd($this->resp->data);
        return view('admin.seller.index',compact('data'));
    }


    public function getCreate() {
        $agentCombo    = $this->agent->getAgentCombo();
        $country       = $this->country->getCountryComboWithCode();
        return view('admin.seller.create')->withAgentCombo($agentCombo)->withCountry($country);
    }


    // public function getSellerArea($id)
    // {
    //     // dd($id);
    //     $data['title']  = 'Seller user list';
    //     $this->resp     = $this->seller->getSellerUser($id);
    //     $data['rows']   = $this->resp->data;
    //     $data['seller']   = Seller::find($id);
    //     return view('admin.seller.seller_user',compact('data'));
    // }

    public function getCoverageAreaForm(Request $request,$id)
    {
        $response = $this->sellerArea->getCoverageAreaForm($id);
        return response()->json($response, $response->code);
    }

    public function postSellerAreaStore(Request $request)
    {
        // dd($request->all());
        $response = $this->seller->postSellerAreaStore($request);
        return response()->json($response, $response->code);
    }


    public function getCoverageAreaDelete(Request $request,$id)
    {
        $response = $this->sellerArea->getCoverageAreaDelete($id);
        return response()->json($response, $response->code);
    }
   //seller dashboard
   public function getHistory(Request $request, $id)
   {
       $user_id = $id;
       $customer_address = $this->customerAddInt->getDefaultShippingAdd($request,$user_id);
       $data['default_address'] = $customer_address->data;
       $due = 0.00;
       $seller_due = DB::SELECT("SELECT SUM(IFNULL(SLS_BOOKING.TOTAL_PRICE,0) - (IFNULL(SLS_BOOKING.DISCOUNT,0)) + IFNULL(SLS_BOOKING.PENALTY_FEE,0) - (IFNULL(SLS_ORDER.ORDER_BUFFER_TOPUP,0))) AS DUE_PRICE from SLS_BOOKING, SLS_ORDER where SLS_BOOKING.F_RESELLER_NO = $user_id AND SLS_BOOKING.PK_NO = SLS_ORDER.F_BOOKING_NO");
           if(!empty($seller_due)){
               $due = number_format($seller_due[0]->DUE_PRICE,2);
           }
           $data['reseller'] = Seller::find($user_id);
       $data['due'] = $due;
       return view('admin.seller.history')->withData($data);
   }

   public function getResellerDetails(Request $request,$id)
   {
      $data['reseller']  = Seller::find($id);
     return view('admin.seller.personal_details')->withData($data);
   }

   public function getAddressBook(Request $request, $id)
   {
       $data['shipping'] = CustomerAddress::where('F_CUSTOMER_NO',$id)->where('F_ADDRESS_TYPE_NO',1)->where('IS_ACTIVE',1)->get();
        //$data['billing'] = CustomerAddress::where('F_CUSTOMER_NO',$id)->where('F_ADDRESS_TYPE_NO',2)->where('IS_ACTIVE',1)->first();
        $data['billing'] = RSller::where('PK_NO',$id)->where('IS_ACTIVE',1)->first();
       $data['country']  = Country::all();
       $data['address']  = Address::pluck('PK_NO','NAME');
       $data['seller'] = Seller::find($id);
       return view('admin.seller.address_book')->withData($data);
   }


   public function getOrderlistByReseller(Request $request, $id){
       $data['reseller'] = Seller::find($id);
       return view('admin.seller.orders')->withData($data);
   }

   public function getResellerPayment(Request $request, $id){
         $this->resp         = $this->paymentInt->getPaymentList($request, $id);
       $data['reseller']   = Seller::find($id);
       return view('admin.seller.payment')->withRows($this->resp->data)->withData($data);
   }

   public function getResellerBalance(Request $request, $id)
    {
        $due    = 0.00;
        $seller_due = DB::SELECT("SELECT
            SUM(IFNULL(SLS_BOOKING.TOTAL_PRICE,0) - (IFNULL(SLS_BOOKING.DISCOUNT,0)) + (IFNULL(SLS_BOOKING.PENALTY_FEE,0)) - (IFNULL(SLS_ORDER.ORDER_BUFFER_TOPUP,0))) AS DUE_PRICE from SLS_BOOKING, SLS_ORDER where SLS_BOOKING.F_RESELLER_NO = $id AND SLS_BOOKING.PK_NO = SLS_ORDER.F_BOOKING_NO");
            if(!empty($seller_due)){
                $due = number_format($seller_due[0]->DUE_PRICE,2);
            }
        $data['due']        = $due;

        $this->resp         = $this->seller->getSellerHistory($id);
        $data['history']    = $this->resp->data ?? [];
        $data['reseller']   = Seller::find($id);
        return view('admin.seller.balance')->withData($data);
    }

   public function getOrderView(Request $request,$order_id)
   {
       $this->resp    = $this->order->getOrderView($request,$order_id);
       $data['order'] = $this->resp->data;
       $customer_id = $data['order']['order']->F_CUSTOMER_NO;
       $data['shipping_address'] = $this->cusAdd->where('F_RESELLER_NO',$customer_id)->where('F_ADDRESS_TYPE_NO',1)->where('IS_ACTIVE',1)->get();
      $data['billing_address'] = RSller::where('PK_NO',$customer_id)->where('IS_ACTIVE',1)->first();
       $data['country']    = $this->country->getCountryComboWithCode();
       return view('admin.seller.order_view')->withData($data);
   }

    public function postStore(SellerRequest $request)
    {
        $this->resp = $this->seller->postStore($request);
        if ($this->resp->status) {
            $data = $this->resp->data;
            return redirect()->route('admin.seller.edit',['id' => $data->PK_NO, 'tab' => 'two'])->with($this->resp->redirect_class, $this->resp->msg);
        }
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function postSellerUser(Request $request)
    {
        $this->resp = $this->seller->postSellerUser($request);
        // $shop_id = $request->seller_id;
        return redirect()->back()->with($this->resp->redirect_class, $this->resp->msg);

    }

    public function getView(Request $request, $id)
    {
        $this->resp             = $this->seller->getShow($id);
        $data['agent_combo']    = $this->agent->getAgentCombo();
        $data['country']        = $this->country->getCountryComboWithCode();
        $data['city']           = PoCode::where('PO_CODE',$this->resp->data->POST_CODE)->groupBy('F_CITY_NO')->pluck('CITY_NAME','F_CITY_NO');
        $data['state']          = City::where('PK_NO',$this->resp->data->CITY)->groupBy('F_STATE_NO')->pluck('STATE_NAME','F_STATE_NO');

        if (!$this->resp->status) {
            return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
        }
        return view('admin.seller.view')->withReseller($this->resp->data)->withData($data);
    }

    public function getEdit(Request $request,$id)
    {
        $this->resp             = $this->seller->getShow($id);
        $data['country']        = $this->country->getCountryComboWithCode();
        if($request->tab == 'two'){
            $data['business_doc'] = DB::table('SELLER_BUSINESS_DOC')->where('SELLER_NO',$id)->get();
            $data['business_info'] = DB::table('SELLER_BUSINESS_INFO')->where('SELLER_NO',$id)->first();
        }
        if($request->tab == 'three'){
            $data['bank_info'] = DB::table('SELLER_BANK_INFO')->where('SELLER_NO',$id)->first();
        }
        if($request->tab == 'four'){
            $data['warehouse_info'] = DB::table('SELLER_WAREHOUSE_INFO')->where('SELLER_NO',$id)->first();
        }
        $data['seller'] = $this->resp->data['seller'];
        if (!$this->resp->status) {
            return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
        }
        return view('admin.seller.edit')->withData($data);
    }


    public function businesDocDelete($id){
        $this->resp = $this->seller->businesDocDelete($id);
        return redirect()->back()->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function postUpdate(SellerRequest $request, $id)
    {
        $this->resp = $this->seller->postUpdate($request, $id);
        if (!$this->resp->status) {
            return redirect()->back()->with($this->resp->redirect_class, $this->resp->msg);
        }
        if($request->submit == 'update_next'){
            $tab = $request->tab;
            if('four' == $tab){
                return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
            }
            return redirect()->route('admin.seller.edit',['id' => $id,'tab'=>$tab])->with($this->resp->redirect_class, $this->resp->msg);
        }else{
            return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
        }
    }

    public function getDelete($id)
    {
        $this->resp = $this->seller->delete($id);

        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }
}
