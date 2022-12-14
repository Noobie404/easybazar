<?php

namespace App\Repositories\Api\Product;

interface ProductInterface
{
    public function getProductList();
    public function getVariantList($id);
    public function getAllVariantList($id);
    public function getVariantImg($id);
    public function getStockSearchList($request);
    public function getAllStockSearchList($request);
    public function getMerStockSearchList($request);
    public function postProductDetailsList($request);
    public function postProductSearchList($request);
    public function postMerchantProductSearchList($request);
    public function postProductStockList($request);
    public function postProductSearchListMy($request);
    public function postProductBoxLocation($request);
    public function postProductSearchListDetailsMy($request);
}
