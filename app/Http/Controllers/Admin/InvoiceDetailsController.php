<?php

namespace App\Http\Controllers\Admin;
use Session;
use App\Models\Currency;
use App\Models\SubCategory;
use App\Models\ProductVariant;
use App\Models\Invoice;
use App\Http\Controllers\BaseController;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use App\Repositories\Admin\InvoiceDetails\InvoiceDetailsInterface;

class InvoiceDetailsController extends BaseController
{
	protected $invoice_details;
	protected $currency;
	protected $subcategory;
    protected $invoice;
    protected $productVariant;
    use CommonTrait;

	function __construct(
        InvoiceDetailsInterface $invoice_details
        , Currency $currency
        , SubCategory $subcategory
        , Invoice $invoice
        , ProductVariant $productVariant
    )
	{
		$this->invoice_details    = $invoice_details;
		$this->currency 	      = $currency;
		$this->subcategory 	      = $subcategory;
        $this->invoice            = $invoice;
        $this->productVariant     = $productVariant;
	}

	public function getIndex(Request $request, $id)
    {
        $data               = array();
        $invoice            = $this->invoice_details->getInvoiceData($id, $request);
        if (!isset($invoice->data)) {
            return redirect()->back()->with('flashMessageError', 'Data not found !');
        }
        $data['invoice']    = $invoice->data;
        $this->resp         = $this->invoice_details->getPaginatedList($request, 200, $id);
        $data['rows']       = $this->resp->data;
        return view('admin.procurement.invoice-details.index', compact('data'));
    }

    public function getCreate(Request $request, $id=null)
    {
        $data           = array();
        $variant_info   = null;
        if ($id != null) {
            $this->resp     = $this->invoice_details->getInvoiceData($id,$request);
            if ($this->resp->data->INV_STOCK_RECORD_GENERATED == 1) {
                return redirect()->route('admin.invoice')->with('flashMessageError', 'Can not update invoice as stock has been generated !');
            }
            $this->resp->old_data       = $this->invoice_details->getPaginatedList($request, 200, $id);
            $data['invoice_info']   = $this->resp->data;
            $data['old_data']       = $this->resp->old_data->data;
        }
        $variant_pk_arr = $this->getVariantNo($request);
        if ($variant_pk_arr) {
            $variant_info = $this->productVariant->getProductVariantInfo($variant_pk_arr);
        }
        $data['variant_info']   = $variant_info;
        Session::put('list_type', '');
        return view('admin.procurement.invoice-details.create', compact('data'));
    }

    public function getVariantListById(Request $request)
    {
        $this->resp = $this->invoice_details->getVariantListById($request->data);
        return response()->json($this->resp);
    }

    public function getVariantListByBarCode(Request $request, $bar_code,$type)
    {
        $this->resp = $this->invoice_details->getVariantListByBarCode($request, $bar_code,$type);
        return response()->json($this->resp);
    }

    public function getProductBySubCategory($id)
    {
        $product 	= $this->invoice_details->getProductBySubCategory($id);
        return response()->json($product);
    }

    public function postStore(Request $request)
    {
        $this->resp = $this->invoice_details->postStore($request);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getDelete($id, Request $request)
    {
        $this->resp = $this->invoice_details->delete($id, $request);
        return redirect()->back()->with($this->resp->redirect_class, $this->resp->msg);
    }


    public function getVariantListByQueryString(Request $request, $queryString)
    {
        $products = $this->invoice_details->getVariantListByQueryString($request, $queryString);
        return response()->json($products->data);
    }

    public function getProductByInvoice(Request $request, $id, $type)
    {
        $this->resp = $this->invoice_details->getProductByInvoice($request, $id, $type);
        return view($this->resp->redirect_to)->withData($this->resp->data)->withInvoiceid($id)->withPagetype($type);
    }


}
