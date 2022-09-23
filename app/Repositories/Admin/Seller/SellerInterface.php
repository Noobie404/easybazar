<?php

namespace App\Repositories\Admin\Seller;

interface SellerInterface
{
    public function getPaginatedList($request, int $per_page = 5);
    public function getShow(int $id);
    public function getSellerUser(int $id);
    public function postStore($request);
    public function postSellerUser($request);
    public function postUpdate($request, int $id);
    public function businesDocDelete(int $id);
    public function delete($id);
    public function postSellerAreaStore($request);
    
}
