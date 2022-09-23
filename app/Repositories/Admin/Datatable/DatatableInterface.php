<?php

namespace App\Repositories\Admin\Datatable;

interface DatatableInterface
{
    public function getDatatableCustomer($request);
    // public function getDatatableReseller();
    public function getDatatableProduct($request);
    public function getDatatableBooking($request);
    // public function getCancelOrder($request);
    // public function getDatatableAlteredOrder($request);
    // public function getDatatableDefaultOrder($request);
    // public function getDatatableUnshelved($request);
    // public function getDatatableBoxed($request);
    // public function getDatatableShelved($request);
    // public function getDatatableNotBoxed($request);
    // public function getDatatableSalesComission($request);
    // public function getDatatableSalesComissionList($request);
    // public function getDatatableOrderCollection($request);
    // public function getDatatableItemCollection($request);
    // public function getDatatableItemCollectedList($request);
    // public function getDatatableDefaultOrderAction($request);
    // public function getDatatableDefaultOrderPenalty($request);
    public function customerRefundlist($request);
    public function resellerRefundlist($request);
    public function customerRefunded($request);
    // public function resellerRefunded($request);
    public function customerRefundedRequestList($request);
    // public function resellerRefundedRequestList($request);
    public function ajaxbankToOther();
    public function ajaxbankToBank();
    public function getTopSell($request);
    public function getTopSellView($request,$id);
    public function getTopSellVariantView($request,$id);
    public function getNewArivalVariantView($request,$id);
    public function getAllProduct($request);
    public function getProductVariantStore($request);
    public function getPendingVarint($request);
    public function getNewAriavalView($request,$id);
    public function getNewArival($request);
    public function getMyOrders($request);
    public function invoiceProcessingList($request);
    public function InvoiceList($request);
    public function sellerInvoiceList($request);
    public function getNotificationList($request);
    public function getEmailList($request);
    public function getVatProcessing($request);
    // public function getTopSellPdf($request,$id);
    // public function getTopSellPdf($request,$id);
}
