<?php

namespace App\Repositories\Admin\Role;


interface RoleInterface
{
    public function getPaginatedList($request, int $per_page = 20);
    public function getAllGroups($request,$status = 1, $order_by = 'id', $sort = 'asc');
    public function postStore($request, $permissions);
    public function getList($request);
    public function postUpdate($request, int $id, $permissions);
    public function findOrThrowException($id);
    public function delete($request,int $id);
}
