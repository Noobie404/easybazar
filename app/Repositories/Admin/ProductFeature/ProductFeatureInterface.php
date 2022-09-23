<?php
namespace App\Repositories\Admin\ProductFeature;

interface ProductFeatureInterface {
    public function postMaster($request);
    public function postFeatureAddUpdate($request);
    public function postAddUpdateFeatureChilds($request);
    public function postShowFeatureChild($request);
    public function getList($request);
    public function getMasterDelete(int $PK_NO);
    public function postMasterUpdate($request, $PK_NO);
}
