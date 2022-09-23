<?php

namespace App\Repositories\Admin\Product;


interface ProductInterface
{
    public function getPaginatedList($request);
    public function getProAddToShop($request);
    public function getAjaxCategoryAttr($request);
    public function getAjaxAttrChilds($request);
    public function getAjaxFeaOptions($request);
    public function getAjaxVariantGenerate($request);
    public function postAjaxDeleteAddtionalCategory($request);
    public function postAjaxDeleteProductAttribute($request);
    public function postAjaxRefreshProductAttribute($request);
    public function postAjaxAddAddtionalCategory($request);
    public function getAjaxCategoryChild($request);
    public function postStore($request);
    public function postStoreProductVariant($request);
    public function postUpdate($request, int $id);
    public function postUpdateProductVariant($request, int $id);
    public function getBrandModelByScat(int $id);
    public function getDeleteProductVariant(int $id);
    public function getShow(int $id);
    public function delete(int $id);
    public function deleteImage(int $id);
    public function getProductSearchList($request);
    public function postVariantMasterSwap($request);
    public function postIfMasterStore($request);
    public function postIfVariantStore($request);
    public function postIfCategoryStore($request);
    public function getVariantByMaster(int $id);
    public function getVariantById(int $id);
    public function postSpcatStoreAjax($request);
    public function postSpcatDeleteAjax($request);
    public function getShopMaster($request);
    public function storeToShop($request);
    public function getShopMasterStatus($request);
    public function getShopVariantStatus($request);
    public function getVariantByMasterAj($request);
    public function getSearchList($request);
    




}
