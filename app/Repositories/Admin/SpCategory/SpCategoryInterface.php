<?php

namespace App\Repositories\Admin\SpCategory;

interface SpCategoryInterface
{
    public function getSpCategoryList($request, int $per_page = 5);
    public function postStore($request);
    public function postUpdate($request, int $id);
    public function postSlugUpdate($request);
    //public function findOrThrowException($id);
    public function getDelete($id);
}
