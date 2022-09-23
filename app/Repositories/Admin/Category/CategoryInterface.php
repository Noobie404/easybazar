<?php

namespace App\Repositories\Admin\Category;

interface CategoryInterface
{
    public function getPaginatedList($request, int $per_page = 5);
    public function getPaginatedListStore($request, int $per_page = 5);
    public function postStore($request);
    public function postUpdate($request, int $id);
    public function getCategoryList($request,$id=null);
    // public function getCategorySlider($request,$id);
    public function delete($id);
    public function getSubcategory($id);
}
