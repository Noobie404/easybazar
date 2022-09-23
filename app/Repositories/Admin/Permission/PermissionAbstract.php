<?php
namespace App\Repositories\Admin\Permission;

use App\Models\Permission;
use App\Traits\RepoResponse;
use DB;

class PermissionAbstract implements PermissionInterface
{
    use RepoResponse;

    protected $permission;

    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }

    public function getPaginatedList($request, int $per_page = 20)
    {
        $data = $this->permission->select('SA_PERMISSION_GROUP_DTL.*','SA_PERMISSION_GROUP.NAME as GROUP_NAME')->join('SA_PERMISSION_GROUP','SA_PERMISSION_GROUP.PK_NO', 'SA_PERMISSION_GROUP_DTL.F_PERMISSION_GROUP_NO');
        if ($request->segment(1) == 'seller') {
            $data = $data->where('GROUP_FOR',2);
        }else{
            $data = $data->where('GROUP_FOR',1);
        }
        $data = $data->orderBy('SA_PERMISSION_GROUP.NAME')->get();

        return $this->formatResponse(true, '', '', $data);
    }

    public function getList($request) {
        if ($request->segment(1) == 'seller') {
            return DB::table('SA_PERMISSION_GROUP')->where('GROUP_FOR',2)->pluck('NAME', 'PK_NO');
        }else{
            return DB::table('SA_PERMISSION_GROUP')->where('GROUP_FOR',1)->pluck('NAME', 'PK_NO');
        }
    }

    public function postStore($request)
    {
        DB::beginTransaction();
        $redirect_to = $request->segment(1) == 'seller' ? 'seller.permission' : 'admin.permission';
        try {
            $permission = new Permission();
            $permission->NAME = $request->permission_slug;
            $permission->DISPLAY_NAME = $request->display_name;
            $permission->F_PERMISSION_GROUP_NO = $request->permission_group;
            $permission->STATUS = 1;
            $permission->save();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, 'Unable to create permission !', $redirect_to);
        }
        DB::commit();
        return $this->formatResponse(true, 'Permission has been created successfully !', $redirect_to);
    }

    public function postUpdate($request, int $id)
    {
        DB::beginTransaction();
        $redirect_to = $request->segment(1) == 'seller' ? 'seller.permission' : 'admin.permission';
        try {
            $this->permission->where('PK_NO', $id)->update(['NAME'=>$request->permission_slug,'DISPLAY_NAME'=>$request->display_name,'F_PERMISSION_GROUP_NO'=>$request->permission_group,'STATUS'=>1]);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, 'Unable to update permission !', $redirect_to);
        }
        DB::commit();
        return $this->formatResponse(true, 'Permission has been updated successfully !', $redirect_to);
    }

    public function getShow($request,int $id)
    {
        $data =  Permission::find($id);
        $redirect_to = $request->segment(1) == 'seller' ? 'seller.permission' : 'admin.permission';
        if (!empty($data)) {
            return $this->formatResponse(true, '', $redirect_to, $data);
        }

        return $this->formatResponse(false, 'Did not found data !', $redirect_to, null);
    }

    public function delete($request,int $id)
    {
        DB::begintransaction();
        $redirect_to = $request->segment(1) == 'seller' ? 'seller.permission' : 'admin.permission';
        try {
            Permission::where('PK_NO', $id)->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, 'Unable to delete this action !', $redirect_to);
        }
        return $this->formatResponse(true, 'Successfully delete this action !', $redirect_to);
    }

}
