<?php

namespace App\Repositories\Admin\Coupon;

interface CouponInterface
{
    public function getPaginatedList($request, int $per_page = 500);
    public function postStore($request);
    public function postCouponSearch($request);
    public function postCouponMasterVariant($request);
    public function postUpdate($request, int $id);
    public function findOrThrowException(int $id);
    public function delete($id);
    public function getView($id);
    public function getVariantList($request);
    public function postStoreProduct($request);
    public function getDeleteProduct($id);
}
