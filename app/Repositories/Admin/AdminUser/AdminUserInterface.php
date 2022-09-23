<?php

namespace App\Repositories\Admin\AdminUser;


interface AdminUserInterface
{
    public function getPaginatedList($request);
    public function getBranchAdmin($request);
    public function getBranchUser($request);
//    public function getList();
    public function postStore($request);
    public function postUpdate($request, int $id, string $type = null );
    public function getShow(int $id);
    public function delete(int $id);

    public function getSearchList($request);
}
