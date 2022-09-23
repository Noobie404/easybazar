<?php

namespace App\Repositories\Admin\Booking;

interface BookingInterface
{
    public function getPaginatedList($request, int $id = null);
    public function getProductINV($product,$branch_id);
    public function findOrThrowException($id, $for = null);
    public function postUpdate($request, int $id);
    public function postStore($request, int $id,string $type);
    public function getCusInfo($type,$customer);
    public function delete($id);
    public function getDownloadPDF($request,$id);
    public function assignDeliveryman($request);
    public function bookingStatusBulkUpdate($request);
    public function postCartStoreAjax($request);
    public function getReturnRequestOrder($request);
    public function postReturnOrder($request);
    public function postConfirmReturnOrder($request);
    public function bulkAssignDeliveryMan($request);
    public function updateApplyCoupon($request);


}
