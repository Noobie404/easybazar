<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use App\Repositories\Admin\Datatable\DatatableInterface;

class DatatableController extends BaseController
{
    protected $datatable;

    public function __construct(DatatableInterface $datatable)
    {
        $this->datatable = $datatable;
    }

    public function all_customer(Request $request)
    {
        $this->resp = $this->datatable->getDatatableCustomer($request);
        return $this->resp;
    }
    public function all_reseller()
    {
        $this->resp = $this->datatable->getDatatableReseller();
        return $this->resp;
    }

    public function getDatatableBooking(Request $request)
    {
        $this->resp = $this->datatable->getDatatableBooking($request);
        return $this->resp;
    }

    public function getCancelOrder(Request $request)
    {
        $this->resp = $this->datatable->getCancelOrder($request);
        return $this->resp;
    }


    public function getAlteredOrder(Request $request)
    {
        $this->resp = $this->datatable->getDatatableAlteredOrder($request);
        return $this->resp;
    }

    public function getDefaultOrder(Request $request)
    {
        $this->resp = $this->datatable->getDatatableDefaultOrder($request);
        return $this->resp;
    }

    public function getDefaultOrderAction(Request $request)
    {
        $this->resp = $this->datatable->getDatatableDefaultOrderAction($request);
        return $this->resp;
    }

    public function getDefaultOrderPenalty(Request $request)
    {
        $this->resp = $this->datatable->getDatatableDefaultOrderPenalty($request);
        return $this->resp;
    }

    public function all_product_list(Request $request)
    {
        $this->resp = $this->datatable->getDatatableProduct($request);
        return $this->resp;
    }

    public function unshelved_product_list(Request $request)
    {
        $this->resp = $this->datatable->getDatatableUnshelved($request);
        return $this->resp;
    }

    public function boxed_product_list(Request $request)
    {
        $this->resp = $this->datatable->getDatatableBoxed($request);
        return $this->resp;
    }

    public function shelved_product_list(Request $request)
    {
        $this->resp = $this->datatable->getDatatableShelved($request);
        return $this->resp;
    }

    public function notBoxed_product_list(Request $request)
    {
        $this->resp = $this->datatable->getDatatableNotBoxed($request);
        return $this->resp;
    }

    public function sales_comission_report(Request $request)
    {
        $this->resp = $this->datatable->getDatatableSalesComission($request);
        return $this->resp;
    }

    public function sales_comission_report_list(Request $request)
    {
        $this->resp = $this->datatable->getDatatableSalesComissionList($request);
        return $this->resp;
    }

    public function getOrderCollection(Request $request)
    {
        $this->resp = $this->datatable->getDatatableOrderCollection($request);
        return $this->resp;
    }

    public function getItemCollection(Request $request)
    {
        $this->resp = $this->datatable->getDatatableItemCollection($request);
        return $this->resp;
    }

    public function getItemCollectedList(Request $request)
    {
        $this->resp = $this->datatable->getDatatableItemCollectedList($request);
        return $this->resp;
    }
    public function customerRefundlist(Request $request)
    {
        $this->resp = $this->datatable->customerRefundlist($request);
        return $this->resp;
    }

    public function resellerRefundlist(Request $request)
    {
        $this->resp = $this->datatable->resellerRefundlist($request);
        return $this->resp;
    }
    public function customerRefunded(Request $request)
    {
        $this->resp = $this->datatable->customerRefunded($request);
        return $this->resp;
    }
    public function resellerRefunded(Request $request)
    {
        $this->resp = $this->datatable->resellerRefunded($request);
        return $this->resp;
    }
    public function customerRefundedRequestList(Request $request)
    {
        $this->resp = $this->datatable->customerRefundedRequestList($request);
        return $this->resp;
    }
    public function resellerRefundedRequestList(Request $request)
    {
        $this->resp = $this->datatable->resellerRefundedRequestList($request);
        return $this->resp;
    }
    public function ajaxbankToOther()
    {
        $this->resp = $this->datatable->ajaxbankToOther();
        return $this->resp;
    }

    public function ajaxbankToBank()
    {
        $this->resp = $this->datatable->ajaxbankToBank();
        return $this->resp;
    }

    public function getTopSell(Request $request)
    {
        $this->resp = $this->datatable->getTopSell($request);
        return $this->resp;
    }

    public function getTopSellView(Request $request, $id)
    {
        $this->resp = $this->datatable->getTopSellView($request,$id);
        return $this->resp;
    }

    public function getTopSellVariantView(Request $request, $id)
    {

        $this->resp = $this->datatable->getTopSellVariantView($request, $id);
        return $this->resp;
    }

    public function getNewArivalVariantView(Request $request, $id)
    {
        $this->resp = $this->datatable->getNewArivalVariantView($request, $id);
        return $this->resp;
    }

    public function getNewAriavalView(Request $request, $id)
    {
        $this->resp = $this->datatable->getNewAriavalView($request,$id);
        return $this->resp;
    }

    public function getAllProduct(Request $request)
    {
        $this->resp = $this->datatable->getAllProduct($request);
        return $this->resp;
    }

    public function getNotificationList(Request $request)
    {
        $this->resp = $this->datatable->getNotificationList($request);
        return $this->resp;
    }

    public function getEmailList(Request $request)
    {
        $this->resp = $this->datatable->getEmailList($request);
        return $this->resp;
    }

    public function getPendingMaster(Request $request)
    {
        $request->status = 'pending';
        $this->resp = $this->datatable->getAllProduct($request);
        return $this->resp;
    }
    public function getPendingVarint(Request $request)
    {
        $request->status = 'pending';
        $this->resp = $this->datatable->getPendingVarint($request);
        return $this->resp;
    }
    public function getNewArival(Request $request)
    {
        $this->resp = $this->datatable->getNewArival($request);
        return $this->resp;
    }
    public function getMyOrders(Request $request)
    {
        $this->resp = $this->datatable->getMyOrders($request);
        return $this->resp;
    }

    public function invoiceProcessingList(Request $request)
    {
        $this->resp = $this->datatable->invoiceProcessingList($request);
        return $this->resp;
    }
    public function getVatProcessing(Request $request)
    {
        $this->resp = $this->datatable->getVatProcessing($request);
        return $this->resp;
    }
    public function getProductVariantStore(Request $request)
    {
        $this->resp = $this->datatable->getProductVariantStore($request);
        return $this->resp;
    }
    public function InvoiceList(Request $request)
    {
        $this->resp = $this->datatable->InvoiceList($request);
        return $this->resp;
    }
}

