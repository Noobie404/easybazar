<?php

namespace App\Repositories\Admin\Brand;

interface BrandInterface
{
    public function getPaginatedList($request);
    public function postStore($request);
    public function postUpdate($request, int $id);
    public function findOrThrowException($id);
    public function delete($id);
}
