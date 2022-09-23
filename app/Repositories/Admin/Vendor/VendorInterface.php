<?php

namespace App\Repositories\Admin\Vendor;

interface VendorInterface
{
    public function getPaginatedList($request, int $per_page = 20);
    public function getSellerPaginatedList($request, int $per_page = 20);
    public function postStore($request);
    public function postSellerStore($request);
    public function postUpdate($request, int $id);
    public function postSellerUpdate($request, int $id);
    public function findOrThrowException($id);
    public function delete($id);
    public function sellerDelete($id);
}
