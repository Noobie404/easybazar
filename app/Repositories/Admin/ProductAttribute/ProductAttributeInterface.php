<?php
namespace App\Repositories\Admin\ProductAttribute;

interface ProductAttributeInterface {
    public function postMaster($request);
    public function postChildAddUpdate($request);
    public function getList($request);
    public function getMasterDelete(int $PK_NO);
    public function postMasterUpdate($request, $PK_NO);
}
