<?php

namespace App\Repositories\Admin\Permission;


interface PermissionInterface
{
    public function getPaginatedList($request, int $per_page = 20);
    public function getList($request);
    public function postStore($request);
    public function postUpdate($request, int $id);
    public function getShow($request,int $id);
    public function delete($request,int $id);
}
