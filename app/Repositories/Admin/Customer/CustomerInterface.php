<?php

namespace App\Repositories\Admin\Customer;

interface CustomerInterface
{
    public function getPaginatedList($request, int $per_page = 20);
    // public function postStore($request);
    public function postBlanceTransfer($request);
    public function getRemainingBalance($id);
    public function addNewCustomer($request);
    public function getShow(int $id);
    public function getCusAdd(int $id);
    public function getCustomerHistory(int $id);
    // public function postUpdate($request, int $id);
    // public function findOrThrowException($id);
    public function delete($id);
    // public function postBillplzPayout($request);
    // public function getBillplzPayoutResponse($request);
    public function postRefundRequest($request);
    public function postRefundRequestSeller($request);
    public function getRefundedRequestDeny($request, int $id);
    public function getRefundedRequestDenySeller($request, int $id);
    public function getBillingAdd($request, int $id);
    public function getCustomerCombo($request,$id);

}
