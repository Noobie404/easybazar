<?php

namespace App\Http\Controllers\Seller;

use DB;
use Auth;
use App\User;
use App\Models\Seller;
use App\Models\Vendor;
use App\Models\Invoice;
use App\Models\Currency;
use App\Models\Merchant;
use App\Models\Shipment;
use App\Models\AdminUser;
use App\Models\Warehouse;
use App\Models\MerInvoice;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use App\Models\AccountMethod;
use App\Models\AccountSource;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\InvoiceRequest;
use App\Repositories\Admin\Invoice\InvoiceInterface;
use App\Http\Requests\Admin\InvoiceProcessingRequest;
use App\Repositories\Admin\InvoiceDetails\InvoiceDetailsInterface;

class SellerInvoiceController extends BaseController
{
	protected $invoice;
	protected $vendor;
	protected $currency;
	protected $subcategory;
	protected $admin_user;
    protected $account_source;
    protected $payment_method;
    protected $bank_acc;
    protected $invoice_details;
    protected $auth;

	function __construct(
        InvoiceInterface $invoice
        , Vendor $vendor
        , Currency $currency
        , AdminUser $admin_user
        , AccountSource $account_source
        , BankAccount $bank_acc
        , AccountMethod $payment_method
        , Warehouse $warehouse
        , InvoiceDetailsInterface $invoice_details
        , Guard $auth
    )
	{
		$this->invoice 	          = $invoice;
		$this->vendor 		      = $vendor;
		$this->currency 	      = $currency;
		$this->admin_user 	      = $admin_user;
        $this->account_source     = $account_source;
        $this->payment_method     = $payment_method;
        $this->bank_acc           = $bank_acc;
        $this->warehouse          = $warehouse;
        $this->invoice_details    = $invoice_details;
        $this->auth               = $auth;
	}

	public function getIndex(Request $request)
    {
        if($request->open_poup == 'yes' && $request->from_date != '' && $request->to_date != '' && $request->merchant_no != ''){
            $from_date       = date('Y-m-d', strtotime($request->from_date));
            $to_date         = date('Y-m-d', strtotime($request->to_date));
            $merchant_no     = Auth::user()->F_MERCHANT_NO > 0 ? Auth::user()->F_MERCHANT_NO : $request->merchant_no;

            $invoices = MerInvoice::whereBetween('INVOICE_DATE', [$from_date, $to_date])
            ->where('F_MERCHANT_NO',$merchant_no)
            ->where('IS_PAID',0)
            ->orderBy('INVOICE_DATE','DESC')
            ->get();
            $data['shipments'] = Shipment::select('CODE','PK_NO')->where('F_MERCHANT_NO', $merchant_no)->get();
            $data['invoices'] = $invoices;
            $data['merchant'] = Merchant::where('IS_ACTIVE',1)->where('PK_NO',$merchant_no)->select('PK_NO','NAME', 'CUM_BALANCE', 'SHORT_NAME')->first();
        }
        $data['merchants'] = Merchant::where('IS_ACTIVE',1)->select('PK_NO','NAME', 'CUM_BALANCE');
        if (Auth::user()->F_MERCHANT_NO > 0) {
            $data['merchants'] = $data['merchants']->where('PK_NO',Auth::user()->F_MERCHANT_NO);
        }
        $data['merchants'] = $data['merchants']->get();
        return view('seller.procurement.invoice.index', compact('data'));
    }

    public function getCreate(Request $request)
    {
        if(request()->get('parent') && (request()->get('parent') != '' )){
            $parent_invoice     = Invoice::find(request()->get('parent'));
        }else{
            $parent_invoice     = null;
        }
        $acc_source_id          = null;
        $vendors 	            = $this->vendor->get();
        $currency 	            = Currency::first();
        $user 		            = User::select(DB::raw("CONCAT(FIRST_NAME,' ',LAST_NAME) AS NAME"),'PK_NO')->pluck('NAME','PK_NO');
        $acc_source             = $this->account_source->getAllSource();
        $payment_method         = $this->payment_method->getAllPaymentMethod($acc_source_id);
        $bank_acc               = $this->bank_acc->getAllBankAcc($acc_source_id);
        $store_list             = Seller::where(['FK_PARENT_USER_NO'=>0,'SHOP_ID'=>Auth::user()->SHOP_ID])->pluck('NAME','PK_NO');

        return view('seller.procurement.invoice.create')
            ->withVendors($vendors)
            ->withStores($store_list)
            ->withParentInvoice($parent_invoice)
            ->withCurrency($currency)
            ->withUser($user)
            ->withAccSource($acc_source)
            ->withBankAcc($bank_acc)
            ->withPaymentMethod($payment_method);
    }

    public function getBankAcc($acc_source_id){
        $data['payment_method'] = $this->payment_method->getAllPaymentMethod($acc_source_id,'combo');
        $data['bank_acc'] = $this->bank_acc->getAllBankAcc($acc_source_id,'combo');
        return response()->json($data);
    }

    public function postStore(InvoiceRequest $request)
    {
        $this->resp = $this->invoice->postStore($request);
        if ($this->resp->status == true) {
            $pk_no = $this->resp->data;
            return redirect()->route('seller.invoice-details.new',['id' => $pk_no])->with($this->resp->redirect_class, $this->resp->msg);
        }else{
            return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
        }

    }

    public function getEdit(Request $request, $id)
    {
        $invoice               = $this->invoice->findOrThrowException($request, $id);
        $acc_source_id         = $invoice->data->F_PAYMENT_SOURCE_NO;
        $vendors               = $this->vendor->get();
        $currency              = Currency::get();
        $user                  = User::select(DB::raw("CONCAT(FIRST_NAME,' ',LAST_NAME) AS NAME"),'PK_NO')->pluck('NAME','PK_NO');
        $acc_source            = $this->account_source->getAllSource();
        $payment_method        = $this->payment_method->getAllPaymentMethod($acc_source_id);
        $bank_acc              = $this->bank_acc->getAllBankAcc();
        $invoice_details       = $this->invoice_details->getPaginatedList($request, 200, $id);
        $store_list             = Seller::where('FK_PARENT_USER_NO',0)->pluck('NAME','PK_NO');

        return view('seller.procurement.invoice.edit')
            ->withInvoice($invoice->data)
            ->withStores($store_list)
            ->withItems($invoice_details->data)
            ->withVendors($vendors)
            ->withCurrency($currency)
            ->withUser($user)
            ->withAccSource($acc_source)
            ->withBankAcc($bank_acc)
            ->withPaymentMethod($payment_method);
    }

    public function postUpdate(InvoiceRequest $request, $id)
    {
        $this->resp = $this->invoice->postUpdate($request, $id);
        if ($this->resp->status == true) {
            $pk_no = $this->resp->data;
            return redirect()->route($this->resp->redirect_to,['id' => $pk_no])->with($this->resp->redirect_class, $this->resp->msg);
        }else{
            return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
        }
    }

    public function getDelete(Request $request, $id)
    {
        $this->resp = $this->invoice->delete($request, $id);
        return redirect()->back()->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getImgDelete($id, $invoice_for)
    {
        $this->resp = $this->invoice->deleteImage($id, $invoice_for);
        return response()->json($this->resp);
    }

    public function postMerchantInvoicePdfAccess(Request $request)
    {
        $this->resp = $this->invoice->postMerchantInvoicePdfAccess($request);
        return response()->json($this->resp);
    }

    public function invoiceProcessing(Request $request)
    {
        return view('seller.procurement.invoice_processing.index');
    }

    public function getStockDelete(Request $request, $invoice_id)
    {
        $data = array();
        $this->resp = $this->invoice->getDeleteGeneratedStock($request,$invoice_id);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }


    public function invoiceQBentry($invoice_id)
    {
        $this->resp = $this->invoice->invoiceQBentry($invoice_id);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function invoiceLoyaltyClaime(Request $request, $invoice_id)
    {
        $this->resp = $this->invoice->invoiceLoyaltyClaime($invoice_id, $request->invoice_for);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function invoiceVatClaime(Request $request, $invoice_id)
    {
        $this->resp = $this->invoice->invoiceVatClaime($invoice_id, $request->invoice_for);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function postStoreInvoiceProcessing(Request $request)
    {
        $this->resp = $this->invoice->postStoreInvoiceProcessing($request);
        return response()->json($this->resp);
    }
}
?>
