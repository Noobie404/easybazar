<?php
namespace App\Repositories\Admin\Role;

use DB;
use App\User;
use App\Models\Auth;
use App\Models\Role;
use App\Traits\RepoResponse;
use App\Models\RolePermission;
use App\Models\PermissionGroup;

class RoleAbstract implements RoleInterface
{
    use RepoResponse;

    protected $role;

    protected $permGroup;

    public function __construct(Role $role, PermissionGroup $permGroup)
    {
        $this->role = $role;
        $this->permGroup = $permGroup;
    }

    public function getPaginatedList($request, int $per_page = 20)
    {
        $data = $this->role->select(
            'SA_ROLE.PK_NO',
            'SA_ROLE.NAME',
            'SA_ROLE.CREATED_AT',
            'SA_ROLE.GROUP_FOR',
            'SA_USER.NAME as CREATED_BY_NAME',
            )->leftJoin('SA_USER', 'SA_USER.PK_NO', 'SA_ROLE.CREATED_BY');

            // if ($request->segment(1) == 'seller') {
            //     $data = $data->where('GROUP_FOR',2);
            // }else{
            //     $data = $data->where('SA_ROLE.GROUP_FOR',1);
            // }

            $data = $data->orderBy('SA_ROLE.GROUP_FOR', 'ASC')->orderBy('SA_ROLE.NAME', 'ASC')->get();
        return $this->formatResponse(true, '', 'admin.role', $data);
    }

    public function getAllGroups($request,$status = 1, $order_by = 'PK_NO', $sort = 'asc')
    {
        if ($request->segment(1) == 'seller') {
            return $this->permGroup->with('permissions')->where(['STATUS'=> $status,'GROUP_FOR' => 2])->orderBy('ORDER_ID', 'DESC')->get();
        }else{
            return $this->permGroup->with('permissions')->where(['STATUS'=> $status,'GROUP_FOR' => 1])->orderBy('ORDER_ID', 'DESC')->get();
        }
    }

    public function postStore($request, $permissions)
    {
        DB::beginTransaction();
        $redirect_to = $request->segment(1) == 'seller' ? 'seller.role' : 'admin.role';
        try {
            $role = new Role();
            $role->NAME = $request['role_name'];
            $role->CREATED_BY = auth()->user()->PK_NO;
            $role->UPDATED_BY = 0;
            $role->STATUS = 1;
            $role->GROUP_FOR = $request->role_for;

            if($role->save()) {
                $perm_string = ",dashboard,";
                if(count($permissions['permission'])){
                    $perm_string = implode(',',$permissions['permission']);
                    $perm_string = ','.$perm_string.',';
                }
                $rolePermission = new RolePermission();
                $rolePermission->F_ROLE_NO = $role->PK_NO;
                $rolePermission->PERMISSIONS = $perm_string;
                $rolePermission->save();
            }
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), $redirect_to);
        }
        DB::commit();
        return $this->formatResponse(true, 'Role has been created successfully !', $redirect_to);
    }

    public function findOrThrowException($id)
    {
        $role = $this->role->with('permission')->find($id);

        if (! is_null($role)) return $role;
        // throw new \Exception('That role does not exist.');
    }

    public function postUpdate($request, int $id, $permissions)
    {
        DB::beginTransaction();
        $redirect_to = $request->segment(1) == 'seller' ? 'seller.role' : 'admin.role';
        try {
            $role = $this->findOrThrowException($id);

            $role->NAME = $request->role_name;
            $role->UPDATED_BY = 1;

            //Update Role permission table
            $perm_string = ",dashboard,";
            if (empty($permissions)) {
                $role->permission->permissions = '';
                $role->push();
            }else if(count($permissions['permission'])) {
                $perm_string = implode(',', $permissions['permission']);
                $perm_string = ','.$perm_string.',';
                $role->permission->permissions = $perm_string;
                $role->push();
            }

        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), $redirect_to);
        }
        DB::commit();
        return $this->formatResponse(true, 'Role has been updated successfully !', $redirect_to);
    }

    public function delete($request,int $id)
    {
        DB::begintransaction();
        $redirect_to = $request->segment(1) == 'seller' ? 'seller.role' : 'admin.role';
        try {
            User::where('auth_id', $id)->delete();
            Auth::where('id',$id)->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, 'Unable to delete role !', $redirect_to);
        }
        return $this->formatResponse(true, 'Successfully delete role !', $redirect_to);
    }

    public function getList($request)
    {
        return DB::table('SA_ROLE')->orderBy('USER_TYPE', 'ASC')->orderBy('NAME','ASC')->pluck('NAME', 'PK_NO');

        // if ($request->segment(1) == 'seller') {
        //     return DB::table('SA_ROLE')->where('GROUP_FOR',2)->pluck('NAME', 'PK_NO');
        // }else{
        //     return DB::table('SA_ROLE')->where('GROUP_FOR',1)->pluck('NAME', 'PK_NO');
        // }
    }
}
