<?php
namespace App\Repositories\Admin\PermissionGroup;

use App\Models\PermissionGroup;
use App\Traits\RepoResponse;
use DB;
use Auth;

class PermissionGroupAbstract implements PermissionGroupInterface
{
    use RepoResponse;

    protected $permissionGroup;

    public function __construct(PermissionGroup $permissionGroup)
    {
        $this->permissionGroup = $permissionGroup;
    }

    public function getPaginatedList($request, int $per_page = 20)
    {
        if ($request->segment(1) == 'seller') {
            $data = $this->permissionGroup::where('GROUP_FOR',2)->orderBy('ORDER_ID','DESC')->get();
        }else{
            $data = $this->permissionGroup::where('GROUP_FOR',1)->orderBy('ORDER_ID','DESC')->get();
        }
        return $this->formatResponse(true, '', 'admin.permission-group', $data);
    }

    public function postStore($request)
    {
        DB::beginTransaction();
        $redirect_to = $request->segment(1) == 'seller' ? 'seller.permission-group' : 'admin.permission-group';
        try {
            $permissionGroup = new PermissionGroup();
            $permissionGroup->NAME = $request->permission_group_name;
            $permissionGroup->STATUS = 1;
            $permissionGroup->ORDER_ID = $request->order_id;
            $permissionGroup->GROUP_FOR = $request->segment(1) == 'seller' ? 2 : 1;
            $permissionGroup->save();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, 'Unable to create admin permissionGroup !', $redirect_to);
        }
        DB::commit();
        return $this->formatResponse(true, 'permission Menu has been created successfully !', $redirect_to);
    }

    public function postUpdate($request, int $id)
    {
        DB::beginTransaction();
        $redirect_to = $request->segment(1) == 'seller' ? 'seller.permission-group' : 'admin.permission-group';
        try {
            $this->permissionGroup->where('PK_NO',$id)->update(['NAME' => $request->permission_group_name,'STATUS' => 1,  'ORDER_ID' => $request->order_id]);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, 'Unable to update admin permissionGroup !', $redirect_to);
        }
        DB::commit();
        return $this->formatResponse(true, 'Menu has been updated successfully !', $redirect_to);
    }

    public function getShow(int $id)
    {
        $data =  PermissionGroup::find($id);

        if (!empty($data)) {
            return $this->formatResponse(true, '', 'admin.permission-group.edit', $data);
        }

        return $this->formatResponse(false, 'Did not found data !', 'admin.permission-group', null);
    }

    public function delete($request,$id)
    {
        DB::begintransaction();
        $redirect_to = $request->segment(1) == 'seller' ? 'seller.permission-group' : 'admin.permission-group';
        try {
            PermissionGroup::where('PK_NO', $id)->delete();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, 'Unable to delete admin permissionGroup !', $redirect_to);
        }
        DB::commit();
        return $this->formatResponse(true, 'Successfully delete admin permissionGroup !', $redirect_to);
    }
}
