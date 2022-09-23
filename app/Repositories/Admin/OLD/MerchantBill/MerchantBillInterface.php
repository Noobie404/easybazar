<?php

namespace App\Repositories\Admin\MerchantBill;

interface MerchantBillInterface
{
    public function getPaginatedList($request);
    public function postStore($request);
    public function postUpdate($request, $id);
    // public function postUpdate($request, int $id);
    public function getDelete($id);
}
