<?php

namespace App\Http\Controllers\Admin;

use DB;
use Auth;
use App\User;
use App\Models\Vendor;
use App\Models\Invoice;
use App\Models\Currency;
use App\Models\AdminUser;
use App\Models\Warehouse;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use App\Models\AccountMethod;
use App\Models\AccountSource;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\InvoiceRequest;
use App\Repositories\Admin\Invoice\InvoiceInterface;
use App\Repositories\Admin\InvoiceDetails\InvoiceDetailsInterface;

class InvoiceController extends BaseController
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
	}

	public function getIndex(Request $request)
    {
        $data = [];

        if(Auth::user()->USER_TYPE ==10){
            $shop_id =Auth::user()->SHOP_ID;
            $branch = DB::table('SA_USER')->where('PK_NO',$shop_id)->pluck('SHOP_NAME', 'PK_NO');
        }else{
            $branch = DB::table('SA_USER')->where('USER_TYPE',10)->where('F_PARENT_USER_ID',0)->pluck('SHOP_NAME', 'PK_NO');
        }

        $data['branch'] = $branch;
        return view('admin.procurement.invoice.index', compact('data'));
    }

    public function getCreate(Request $request)
    {
        if(request()->get('parent') && (request()->get('parent') != '' )){
            $parent_invoice     = Invoice::find(request()->get('parent'));
        }else{
            $parent_invoice     = null;
        }
        $acc_source_id          = null;
        $shop_id =  Auth::user()->SHOP_ID;
// dd($shop_id);
        $vendors 	            = $this->vendor->where('F_SHOP_NO',$shop_id)->get();
        $auth_id =  Auth::id();

        $currency 	            = Currency::first();
        $user 		            = User::where('PK_NO',$auth_id)->orWhere('F_PARENT_USER_ID',$auth_id)->pluck('NAME','PK_NO');
        $acc_source             = $this->account_source->getAllSource();
        $payment_method         = $this->payment_method->getAllPaymentMethod($acc_source_id);
        $bank_acc               = $this->bank_acc->getAllBankAcc($acc_source_id);

        if(Auth::user()->USER_TYPE == 10){
            $branch          = User::where(['PK_NO' => $shop_id])->pluck('SHOP_NAME','PK_NO');
        }else{
            $branch          = User::where(['USER_TYPE' => 10, 'F_PARENT_USER_ID' => 0])->pluck('SHOP_NAME','PK_NO');

        }
        return view('admin.procurement.invoice.create')
            ->withVendors($vendors)
            ->withStores($branch)
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
            return redirect()->route('admin.invoice-details.new',['id' => $pk_no])->with($this->resp->redirect_class, $this->resp->msg);
        }else{
            return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
        }

    }

    public function getEdit(Request $request, $id)
    {
        $invoice               = $this->invoice->findOrThrowException($request, $id);
        $shop_id =  $invoice->data->F_SHOP_NO;
        $acc_source_id         = $invoice->data->F_PAYMENT_SOURCE_NO;
        $vendors 	           = $this->vendor->where('F_SHOP_NO',$shop_id)->get();
        $currency              = Currency::get();
        $auth_id               =  Auth::id();
        $user 		           = User::where('PK_NO',$auth_id)->orWhere('F_PARENT_USER_ID',$auth_id)->pluck('NAME','PK_NO');
        $acc_source            = $this->account_source->getAllSource();
        $payment_method        = $this->payment_method->getAllPaymentMethod($acc_source_id);
        $bank_acc              = $this->bank_acc->getAllBankAcc();
        $invoice_details       = $this->invoice_details->getPaginatedList($request, 200, $id);

        if(Auth::user()->USER_TYPE == 10){
            $branch          = User::where(['PK_NO' => $shop_id])->pluck('SHOP_NAME','PK_NO');
        }else{
            $branch          = User::where(['USER_TYPE' => 10, 'F_PARENT_USER_ID' => 0])->pluck('SHOP_NAME','PK_NO');

        }

        return view('admin.procurement.invoice.edit')
            ->withInvoice($invoice->data)
            ->withStores($branch)
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
        $data = [];
        if(Auth::user()->USER_TYPE ==10){
            $shop_id =Auth::user()->SHOP_ID;
            $branch = DB::table('SA_USER')->where('PK_NO',$shop_id)->pluck('SHOP_NAME', 'PK_NO');
        }else{
            $branch = DB::table('SA_USER')->where('USER_TYPE',10)->where('F_PARENT_USER_ID',0)->pluck('SHOP_NAME', 'PK_NO');
        }

        $data['branch'] = $branch;

        return view('admin.procurement.invoice_processing.index', compact('data'));
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
        // return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
        return response()->json($this->resp);
    }

    public function getPurchaser($id)
    {
        $users = DB::table('SA_USER')->where('F_PARENT_USER_ID',$id)->orWhere('PK_NO',$id)->pluck('NAME','PK_NO');
        $response = false;
        $html = $html2 = '';
        if ($users && count($users) > 0 ) {
            foreach ($users as $k => $val) {
                $html .= '<option value="'.$k.'"  title="'.$val.'">'.$val.'</option>';
            }
            $response = true;
        }else{
            $html .= '<option value="">No data found</option>';
            $response = true;
        }
        $data['html']       = $html;
        $data['response']   = $response;


        $vendor = DB::table('PRC_VENDORS')->where('F_SHOP_NO',$id)->pluck('NAME','PK_NO');
        if ($vendor && count($vendor) > 0 ) {
            foreach ($vendor as $k1 => $val1) {
                $html2 .= '<option value="'.$k1.'"  title="'.$val1.'">'.$val1.'</option>';
            }

        }else{
            $html2 .= '<option value="">No data found</option>';

        }
        $data['html2']       = $html2;

        return response()->json($data);

    }


}


?>
