<?php
namespace App\Repositories\Admin\UserGroup;


interface UserGroupInterface
{
    public function getPaginatedList($request, int $per_page = 10);
    public function postStore($request);
    public function getList($request);
    public function postUpdate($request, int $id);
    public function getShow(int $id);
    public function delete($request,int $id);
}
