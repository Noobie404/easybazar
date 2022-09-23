<?php

namespace App\Http\Controllers\Admin;
use App\Models\Country;
use App\Models\Merchant;
use App\Models\MerchantBill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\Admin\MerchantBill\MerchantBillInterface;





class MerchantBillController extends Controller
{

    protected $merchant_bill;
    protected $country;

    public function __construct(MerchantBillInterface $merchant_bill, Country $country)
    {
        $this->merchant_bill     = $merchant_bill;
        $this->country     = $country;
    }

    public function getIndex(Request $request){

        $this->resp = $this->merchant_bill->getPaginatedList($request);
        $data['rows'] = $this->resp->data;
        return view('admin.merchant_bill.index',compact('data'));
    }
    public function getDelete($id, Request $request) {
        $this->resp = $this->merchant_bill->getDelete($id);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }
    public function postStore(Request $request) {
        $this->resp = $this->merchant_bill->postStore($request);
        return redirect()->route($this->resp->redirect_to,['invoice_for' => 'merchant'])->with($this->resp->redirect_class, $this->resp->msg);
    }
    public function getEdit($id) {
        $data['row'] = MerchantBill::find($id);
        $merchant_no = $data['row']->F_MERCHANT_NO;
        $data['merchant'] = Merchant::find($merchant_no);

        $data['invoices'] = DB::table('SC_MERCHANT_BILL_DETAILS')->select('MER_PRC_STOCK_IN.*')->leftJoin('MER_PRC_STOCK_IN', 'MER_PRC_STOCK_IN.PK_NO', 'SC_MERCHANT_BILL_DETAILS.F_MER_PRC_STOCK_IN_NO')->where('F_MERCHANT_BILL_NO',$id)->get();

        $data['from_address']   = DB::table('SC_SHIPING_ADDRESS')->where('ADDRESS_TYPE', 'From')->first();
        $data['to_address']     = DB::table('SC_SHIPING_ADDRESS')->where('ADDRESS_TYPE', 'Bill_to')->where('F_MERCHANT_NO',$merchant_no)->first();

        return view('admin.merchant_bill.edit', compact('data'));

    }

    public function postUpdate(Request $request, $id) {
        $this->resp = $this->merchant_bill->postUpdate($request, $id);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }










}
