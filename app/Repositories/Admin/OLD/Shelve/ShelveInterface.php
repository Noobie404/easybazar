<?php

namespace App\Repositories\Admin\Shelve;

interface ShelveInterface
{
    // public function getPaginatedList($request, int $per_page = 5);
    public function getUnshalvedItems();
    public function getAllProduct($request);
    public function getProductModal($request);
    public function getInvoiceProductModal($request);
    public function getWarehouseDropdown($request);
    public function getShelvedItem(int $id);
    public function getUnshelvedItem(int $id);
    public function getStockPriceInfo($request,int $id);
    public function postStore($request);
}
