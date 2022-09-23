<?php
namespace App\Http\Controllers\Admin;
use App\Models\State;
use App\Models\Seller;
use App\Models\Address;
use App\Models\Country;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\CustomerAddress;
use App\Models\PaymentCustomer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\CustomerRequest;
use App\Repositories\Admin\Booking\BookingInterface;
use App\Repositories\Admin\Payment\PaymentInterface;
use App\Repositories\Admin\Customer\CustomerInterface;
use App\Repositories\Admin\CustomerAddress\CustomerAddressAbstract;


class CustomerController extends BaseController
{
    protected $customerInt;
    protected $customerAddInt;
    protected $bookingInt;
    protected $paymentInt;
    protected $state;
    protected $customer;

    public function __construct(CustomerInterface $customerInt,
    CustomerAddress $cusAdd,
    Country $country,
    CustomerAddressAbstract $customerAddInt,
    BookingInterface $bookingInt,
    PaymentInterface $paymentInt,
    State $state,
    Customer $customer)
    {
        $this->customerInt     = $customerInt;
        $this->cusAdd          = $cusAdd;
        $this->country         = $country;
        $this->customerAddInt  = $customerAddInt;
        $this->bookingInt           = $bookingInt;
        $this->paymentInt      = $paymentInt;
        $this->state           = $state;
        $this->customer        = $customer;


    }

    public function getIndex(Request $request)
    {

        if(Auth::user()->USER_TYPE == 10 ){
            $shop_id  = Auth::user()->SHOP_ID;
            $branch   = DB::table('SA_USER')->where('PK_NO',$shop_id)->pluck('SHOP_NAME', 'PK_NO');
        }else{
            $branch   = DB::table('SA_USER')->where('USER_TYPE',10)->where('F_PARENT_USER_ID',0)->pluck('SHOP_NAME', 'PK_NO');
        }



        return view('admin.customer.index')->withBranch($branch);
    }
    public function getCombo($type)
    {
       if ($type == 'seller') {
            $combo    = $this->seller->getSellerComboCustomer();
        }else{
            $combo = [];
        }
        return response()->json($combo);

    }

    public function getCreate() {
        $response = $this->customer->getCreate();
        return response()->json($response, $response->code);
    }

    public function postAjaxStore(CustomerRequest $request)
    {
        $response = $this->customerInt->postAjaxStore($request);
        return response()->json($response, $response->code);
    }


    public function addNewCustomer(Request $request)
    {
        $this->resp = $this->customerInt->addNewCustomer($request);
        return response()->json($this->resp);
    }

    public function getEdit($id)
    {
        $this->resp = $this->customerInt->getShow($id);
        $data['agent_combo'] = $this->agent->getUKCombo();
        $data['seller_combo'] = $this->seller->getSellerCombo();
        $data['country'] = $this->country->getCountryComboWithCode();
        if (!$this->resp->status) {
            return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
        }
        return view('admin.customer.edit_customer')->withCustomer($this->resp->data)->withData($data);
    }

    public function getAjaxEdit(Request $request,$id)
    {
        $response = $this->customer->getAjaxEdit($id);
        return response()->json($response, $response->code);
    }

    public function postUpdate(Request $request, $id)
    {

        $response = $this->customerInt->postUpdate($request, $id);

    return response()->json($response, $response->code);
    }

    public function getDelete($id)
    {
        $response = $this->customerInt->delete($id);
     return response()->json($response, $response->code);
    }


    public function getView(Request $request,$id)
    {
        $data= [];
        $this->resp = $this->customerInt->getCusAdd($id);
        $data['cus_info'] = $this->customerInt->getShow($id);
        if($this->resp->status==true){
            $data['address'] = $this->resp->data[0];
        }
        else{
            $data['address'] = [];
        }
        $customer = $this->customerInt->getShow($id);
        $data['customer'] = $customer->data;

        $result = $this->customerInt->getCustomerHistory($id);
        if($result->status){
            $rows = $result->data;
        }else{
            $rows = null;
        }
        $data['orders'] = $this->bookingInt->getPaginatedList($request,$id);
        return view('admin.customer.view')->withAddress($this->resp->data)->withCustomer($data['cus_info']->data)->withRows($rows)->withData($data);
    }


    public function getCustomer(Request $request)
    {

        $customer_info = DB::table('SLS_CUSTOMERS')
        ->select('SLS_CUSTOMERS.NAME','SLS_CUSTOMERS.MOBILE_NO','SLS_CUSTOMERS.PK_NO as pk_no1','SLS_CUSTOMERS.CUSTOMER_NO','SLS_CUSTOMERS_ADDRESS.ADDRESS_LINE_1','SLS_CUSTOMERS_ADDRESS.F_COUNTRY_NO','SLS_CUSTOMERS_ADDRESS.COUNTRY','SLS_CUSTOMERS_ADDRESS.F_STATE_NO','SLS_CUSTOMERS_ADDRESS.STATE_NAME','SLS_CUSTOMERS_ADDRESS.F_CITY_NO','SLS_CUSTOMERS_ADDRESS.CITY_NAME', 'SLS_CUSTOMERS_ADDRESS.F_AREA_NO', 'SLS_CUSTOMERS_ADDRESS.AREA_NAME','SLS_CUSTOMERS_ADDRESS.POST_CODE')
        ->leftJoin('SLS_CUSTOMERS_ADDRESS', function($join)
         {
             $join->on('SLS_CUSTOMERS.PK_NO', '=', 'SLS_CUSTOMERS_ADDRESS.F_CUSTOMER_NO');
             $join->on('SLS_CUSTOMERS_ADDRESS.IS_DEFAULT','>=',DB::raw("'1'"));

         })
        ->where('SLS_CUSTOMERS.IS_ACTIVE',1)
        ->where('SLS_CUSTOMERS.NAME', 'LIKE', '%'.$request->get('q').'%')
        ->orWhere('SLS_CUSTOMERS.MOBILE_NO', 'LIKE', '%'.$request->get('q').'%')
        ->get();

        return $customer_info;
    }


    public function postBlanceTransfer(Request $request)
    {
        $this->resp = $this->customerInt->postBlanceTransfer($request);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getRemainingBalance($id)
    {
        $data = $this->customerInt->getRemainingBalance($id);
        return response()->json($data);
    }


    public function getHistory($id)
    {

        $this->resp = $this->customerInt->getCusAdd($id);

        $data['address'] = $this->resp->data != null ? $this->resp->data[0] : null;
        $customer = $this->customerInt->getShow($id);

        $data['customer'] = $customer->data;

        $result = $this->customerInt->getCustomerHistory($id);
        if($result->status){
            $rows = $result->data;
        }else{
            $rows = null;
        }
        $balance_history = PaymentCustomer::where('F_CUSTOMER_NO', $id)->where('PAYMENT_REMAINING_MR','>', 0)->where('PAYMENT_CONFIRMED_STATUS',1)->get();

        return view('admin.customer.history',compact('data','rows','balance_history'));
    }



//customer dashboard
    public function getHistory2(Request $request, $id)
    {
        $type = $request->type;
        $user_id = $id;
        $customer_address = $this->customerAddInt->getDefaultShippingAdd($request,$user_id);
        $data['default_address'] = $customer_address->data;
        $due = 0.00;
        if ($type == 'customer') {

            $customer_due = DB::SELECT("SELECT SUM(IFNULL(SLS_BOOKING.TOTAL_PRICE,0) - (IFNULL(SLS_BOOKING.DISCOUNT,0)) + IFNULL(SLS_BOOKING.PENALTY_FEE,0) - (IFNULL(SLS_ORDER.ORDER_BUFFER_TOPUP,0))) AS DUE_PRICE from SLS_BOOKING, SLS_ORDER where SLS_BOOKING.F_CUSTOMER_NO = $user_id AND SLS_BOOKING.PK_NO = SLS_ORDER.F_BOOKING_NO");
            if(!empty($customer_due)){
                $due = number_format($customer_due[0]->DUE_PRICE,2);
            }
            $data['customer'] = Customer::find($user_id);
        }else{
            $seller_due = DB::SELECT("SELECT SUM(IFNULL(SLS_BOOKING.TOTAL_PRICE,0) - (IFNULL(SLS_BOOKING.DISCOUNT,0)) + IFNULL(SLS_BOOKING.PENALTY_FEE,0) - (IFNULL(SLS_ORDER.ORDER_BUFFER_TOPUP,0))) AS DUE_PRICE from SLS_BOOKING, SLS_ORDER where SLS_BOOKING.F_SHOP_NO = $user_id AND SLS_BOOKING.PK_NO = SLS_ORDER.F_BOOKING_NO");
            if(!empty($seller_due)){
                $due = number_format($seller_due[0]->DUE_PRICE,2);
            }
            $data['customer'] = Seller::find($user_id);
        }
        $data['due'] = $due;
        $data['type'] = $type;
        return view('admin.customer.history2')->withData($data);
    }



    public function getAddressBook(Request $request, $id)
    {
        $type = $request->type;
        $data['shipping'] = CustomerAddress::where('F_CUSTOMER_NO',$id)->where('IS_ACTIVE',1)->get();
        if ($type == 'customer') {
            $data['billing'] = CustomerAddress::where('F_CUSTOMER_NO',$id)->where('IS_ACTIVE',1)->first();
        }else{
            $data['billing'] = Seller::where('PK_NO',$id)->where('IS_ACTIVE',1)->first();
        }
        $data['country']  = Country::all();
        $data['address']  = Address::pluck('PK_NO','NAME');
        $data['customer'] = Customer::find($id);
        $data['type']     = $type;
        return view('admin.customer.address_book')->withData($data);
    }


    public function getOrderlistByCustomer(Request $request, $id){
        $type = $request->type;
        $data['customer'] = Customer::find($id);
        $data['type'] = $type;
        return view('admin.customer.orders')->withData($data);
    }

    public function getCustomerPayment(Request $request, $id){
        $type = $request->type;
        $this->resp         = $this->paymentInt->getPaymentList($request, $id);
        $data['customer']   = Customer::find($id);
        $data['type']       = $type;
        return view('admin.customer.payment')->withRows($this->resp->data)->withData($data);
    }

    public function getCustomerBalance(Request $request, $id)
    {
        $type   = $request->type;
        $due    = 0.00;
        if ($type=='customer') {
            $customer_due = DB::SELECT("SELECT SUM(IFNULL(SLS_BOOKING.TOTAL_PRICE,0) - (IFNULL(SLS_BOOKING.DISCOUNT,0)) + (IFNULL(SLS_BOOKING.PENALTY_FEE,0)) - (IFNULL(SLS_ORDER.ORDER_BUFFER_TOPUP,0))) AS DUE_PRICE FROM SLS_BOOKING, SLS_ORDER where SLS_BOOKING.F_CUSTOMER_NO = $id AND SLS_BOOKING.PK_NO = SLS_ORDER.F_BOOKING_NO");

            if(!empty($customer_due)){
                $due = number_format($customer_due[0]->DUE_PRICE,2);
            }
        }else{
            $seller_due = DB::SELECT("SELECT
            SUM(IFNULL(SLS_BOOKING.TOTAL_PRICE,0) - (IFNULL(SLS_BOOKING.DISCOUNT,0)) + (IFNULL(SLS_BOOKING.PENALTY_FEE,0)) - (IFNULL(SLS_ORDER.ORDER_BUFFER_TOPUP,0))) AS DUE_PRICE from SLS_BOOKING, SLS_ORDER where SLS_BOOKING.F_SHOP_NO = $id AND SLS_BOOKING.PK_NO = SLS_ORDER.F_BOOKING_NO");

            if(!empty($seller_due)){
                $due = number_format($seller_due[0]->DUE_PRICE,2);
            }
        }

        $data['due']        = $due;
        if ($type=='customer') {
            $this->resp         = $this->customerInt->getCustomerHistory($id);
        }
        $data['history']    = $this->resp->data ?? [];
        $data['customer']   = Customer::find($id);
        $data['type']       = $type;
        return view('admin.customer.balance')->withData($data);
    }

    public function getCustomerDetails(Request $request,$id)
    {
        $type = $request->type;
        if ($type=='customer') {
            $data['customer']  = Customer::find($id);
        }else{
            $data['customer']  = Seller::find($id);
        }
        $data['type'] = $type;
        return view('admin.customer.personal_details')->withData($data);
    }




    public function getOrderView(Request $request,$order_id)
    {
        $type = $request->type;
        $this->resp    = $this->order->getOrderView($request,$order_id);
        $data['order'] = $this->resp->data;
        $customer_id = $data['order']['order']->F_CUSTOMER_NO;

        if ($type=='customer') {

            $data['shipping_address'] = $this->cusAdd->where('F_CUSTOMER_NO',$customer_id)->where('F_ADDRESS_TYPE_NO',1)->where('IS_ACTIVE',1)->get();

            $data['billing_address'] = $this->cusAdd->where('F_CUSTOMER_NO',$customer_id)->where('F_ADDRESS_TYPE_NO',2)->where('IS_ACTIVE',1)->first();
        }else{
            $data['shipping_address'] = $this->cusAdd->where('F_SHOP_NO',$customer_id)->where('F_ADDRESS_TYPE_NO',1)->where('IS_ACTIVE',1)->get();
            $data['billing_address'] = Seller::where('PK_NO',$customer_id)->where('IS_ACTIVE',1)->first();
        }
        $data['country']    = $this->country->getCountryComboWithCode();
        return view('admin.customer.order_view')->withData($data);
    }

    public function getCustomerByID($type,$id){
        if ($type=='customer') {
            $customer  = Customer::find($id);
        }else{
            $customer  = Seller::find($id);
        }
        return $customer;
    }

    public function postSearchCustomer(Request $request){
        $term = trim($request->q);
        if (empty($term)) {
            return \Response::json([]);
        }
        $customers = DB::table('SLS_CUSTOMERS')
        // ->where('NAME','LIKE',"%$term%")
        ->where(function($query) use ($term){
            $query->where('NAME', 'LIKE', '%'.$term.'%')
                  ->orWhere('MOBILE_NO', 'LIKE', '%'.$term.'%');
        })
        ->orderBy('PK_NO','DESC')->limit(20)->get();
        $formatted_customers = [];

        foreach ($customers as $customer) {
            $formatted_customers[] = ['id' => $customer->PK_NO, 'text' => $customer->NAME .'-'.$customer->MOBILE_NO];
        }
        return \Response::json($formatted_customers);
    }








}

