<?php

namespace App\Repositories\Api\Shipment;

interface ShipmentInterface
{
    public function ShipmentPost($request);
    public function MerchantShipmentPost($request);
    public function MerchantshipmentReceived($request);
    public function shipmentReceived($request);
    public function shipmentList($request);
    public function MerchantshipmentList($request);
}
