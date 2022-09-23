<?php
namespace App\Http\Controllers\Admin;
use App\Models\Agent;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\RefundRequest;
use App\Models\PaymentBankAcc;
use App\Models\CustomerAddress;
use App\Models\PaymentCustomer;
use App\Models\PaymentReseller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use App\Repositories\Admin\Payment\PaymentInterface;
use App\Repositories\Admin\Customer\CustomerInterface;

class RefundController extends BaseController
{

    protected $customer;
    protected $country;

    public function __construct(CustomerInterface $customer, 
    CustomerAddress $cusAdd, 
    Country $country, 
    PaymentInterface $paymentInt
    )
    {
        $this->customer        = $customer;
        $this->cusAdd          = $cusAdd;
        $this->country         = $country;
        $this->paymentInt      = $paymentInt;
    }

    public function getIndex(Request $request)
    {
        $data['mybank_list'] = DB::table('ACC_BANK_LIST')->pluck('BANK_NAME','PK_NO');
        return view('admin.refund.index',compact('data'));
    }

    public function getRefunded(Request $request)
    {
        
        return view('admin.refund.refunded');
    }
    public function getRefundedReseller(Request $request)
    {
        return view('admin.refund_reseller.refunded');
    }

    public function getrefundRequestList(Request $request)
    {
        return view('admin.refund.request_list');
    }

    public function postRefundRequest(Request $request)
    {
        $this->resp = $this->customer->postRefundRequest($request);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function postRefundRequestReseller(Request $request)
    {
        $this->resp = $this->customer->postRefundRequestReseller($request);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getRefundedRequestDeny(Request $request,$id)
    {
        $this->resp = $this->customer->getRefundedRequestDeny($request,$id);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }
    public function getRefundedRequestDenyReseller(Request $request,$id)
    {
        $this->resp = $this->customer->getRefundedRequestDenyReseller($request,$id);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getRefund(Request $request, $id, $type)
    {
        $data = array();
        $acc_source_id         = null;
        $data['refund_request'] = null;
        $data['mybank_list'] = DB::table('ACC_BANK_LIST')->pluck('BANK_NAME','PK_NO');

        if($request->request_no){
            $data['refund_request'] = RefundRequest::where('PK_NO',$request->request_no)->where('STATUS',0)->first();
        }
        if($type == 'customer'){
            $data['customer']      = Customer::where('PK_NO',$id)->where('IS_ACTIVE', 1)->first();
            $data['remaining_balance'] = PaymentCustomer::where('F_CUSTOMER_NO',$id)
                                        ->where('PAYMENT_REMAINING', '>', 0)
                                        ->get();
        }

        if($type == 'reseller'){
            $data['customer']      = Reseller::where('PK_NO',$id)->where('IS_ACTIVE', 1)->first();
            $data['remaining_balance'] = PaymentReseller::where('F_RESELLER_NO',$id)
                                        ->where('PAYMENT_REMAINING', '>', 0)
                                        ->get();
        }

        $data['currency']       = Currency::pluck('NAME', 'PK_NO');
        $data['payment_acc_no'] = PaymentBankAcc::where('IS_ACTIVE','1')->get();
        $data['type']           = $type;
        return view('admin.refund.create',compact('data'));
    }


    public function getRefundReseller(Request $request, $id, $type)
    {

        $data = array();
        $acc_source_id         = null;
        $data['refund_request'] = null;
        $data['mybank_list'] = DB::table('ACC_BANK_LIST')->pluck('BANK_NAME','PK_NO');

        if($request->request_no){
            $data['refund_request'] = RefundRequest::where('PK_NO',$request->request_no)->where('STATUS',0)->first();
        }
        $data['customer']      = Reseller::where('PK_NO',$id)->where('IS_ACTIVE', 1)->first();
        $data['remaining_balance'] = PaymentReseller::where('F_RESELLER_NO',$id)
                                    ->where('PAYMENT_REMAINING', '>', 0)
                                    ->get();

        $data['currency']       = Currency::pluck('NAME', 'PK_NO');
        $data['payment_acc_no'] = PaymentBankAcc::where('IS_ACTIVE','1')->get();
        $data['type']           = $type;
        return view('admin.refund_reseller.create',compact('data'));
    }

    public function postRefund(Request $request){
        $this->resp = $this->paymentInt->postRefund($request);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }
    public function postRefundReseller(Request $request){
        $this->resp = $this->paymentInt->postRefund($request);
        return redirect()->route('admin.reseller.refund')->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getIndexReseller(Request $request)
    {
        $data['mybank_list'] = DB::table('ACC_BANK_LIST')->pluck('BANK_NAME','PK_NO');
        return view('admin.refund_reseller.index',compact('data'));
    }
    public function getrefundRequestListReseller(Request $request)
    {
        return view('admin.refund_reseller.request_list');
    }



}

