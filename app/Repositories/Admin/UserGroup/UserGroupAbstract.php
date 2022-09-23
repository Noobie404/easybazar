<?php
namespace App\Repositories\Admin\UserGroup;

use DB;
use Auth;
use App\Models\UserGroup;
use App\Traits\RepoResponse;
use App\Models\UserGroupRole;

class UserGroupAbstract implements UserGroupInterface
{
    use RepoResponse;

    protected $userGroup;
    protected $userGroupRole;

    public function __construct(UserGroup $userGroup, UserGroupRole $userGroupRole)
    {
        $this->userGroup        = $userGroup;
        $this->userGroupRole    = $userGroupRole;
    }

    public function getPaginatedList($request, int $per_page = 20)
    {
        $data = $this->userGroup::join('SA_USER_GROUP_ROLE', 'SA_USER_GROUP_ROLE.F_USER_GROUP_NO', 'SA_USER_GROUP.PK_NO')
                                ->join('SA_ROLE', 'SA_USER_GROUP_ROLE.F_ROLE_NO', 'SA_ROLE.PK_NO')
                                ->select('SA_ROLE.NAME','SA_USER_GROUP.*','SA_ROLE.PK_NO as role_pk', 'SA_USER_GROUP.GROUP_FOR')
                                ->orderBy('SA_USER_GROUP.GROUP_FOR', 'ASC')
                                ->orderBy('SA_USER_GROUP.GROUP_NAME','ASC');
                                // if ($request->segment(1) == 'seller') {
                                //     $data = $data->where('SA_ROLE.GROUP_FOR',2);
                                // }else{
                                //     $data = $data->where('SA_ROLE.GROUP_FOR',1);
                                // }
                                $data = $data->get();
        //prixt($data,1);
        return $this->formatResponse(true, '', 'admin.user-group', $data);
    }

    public function postStore($request)
    {
        DB::beginTransaction();
        $redirect_to = $request->segment(1) == 'seller' ? 'seller.user-group' : 'admin.user-group';
        try {
            $userGroup = new UserGroup();
            $userGroup->GROUP_NAME = $request->user_group_name;
            $userGroup->STATUS = 1;
            $userGroup->CREATED_BY = Auth::user()->PK_NO;
            $userGroup->save();

            $userGroupRole = new UserGroupRole();
            $userGroupRole->F_USER_GROUP_NO = $userGroup->PK_NO;
            $userGroupRole->F_ROLE_NO = $request->role;
            $userGroupRole->STATUS = 1;
            $userGroupRole->CREATED_BY = Auth::user()->PK_NO;
            $userGroupRole->save();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, 'Unable to create Admin User Group !', $redirect_to);
        }
        DB::commit();
        return $this->formatResponse(true, 'Admin User Group has been created successfully !', $redirect_to);
    }

    public function postUpdate($request, int $id)
    {
        DB::beginTransaction();
        $redirect_to = $request->segment(1) == 'seller' ? 'seller.user-group' : 'admin.user-group';
        try {
            $this->userGroup->where('PK_NO', $id)->update(['GROUP_NAME' => $request->user_group_name]);
            $this->userGroupRole->where('F_USER_GROUP_NO', $id)->update(['F_ROLE_NO' => $request->role]);
         } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, 'Unable to update admin User Group !', $redirect_to);
        }
        DB::commit();
        return $this->formatResponse(true, 'Admin User Group has been updated successfully !', $redirect_to);
    }

    public function getShow(int $id)
    {
        $data =  UserGroup::join('SA_USER_GROUP_ROLE','SA_USER_GROUP_ROLE.F_USER_GROUP_NO','SA_USER_GROUP.PK_NO')
                            ->select('SA_USER_GROUP_ROLE.F_ROLE_NO','SA_USER_GROUP.GROUP_NAME','SA_USER_GROUP.PK_NO')
                            ->where('SA_USER_GROUP.PK_NO',$id)
                            ->first();

        if (!empty($data)) {
            return $this->formatResponse(true, '', 'admin.user-group.edit', $data);
        }

        return $this->formatResponse(false, 'Did not found data !', 'admin.user-group', null);
    }

    public function delete($request,int $id)
    {
        DB::begintransaction();
        $redirect_to = $request->segment(1) == 'seller' ? 'seller.user-group' : 'admin.user-group';
        try {
            UserGroupRole::where('F_USER_GROUP_NO', $id)->delete();
            UserGroup::where('PK_NO', $id)->delete();
            DB::commit();
            echo 'deleted successfully';
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, 'Unable to delete admin User Group !', $redirect_to);
        }
        return $this->formatResponse(true, 'Successfully delete admin User Group !', $redirect_to);
    }

    public function getList($request)
    {
        if ($request->segment(1) == 'seller') {
            return DB::table('SA_USER_GROUP')->where('GROUP_FOR',2)->pluck('GROUP_NAME', 'PK_NO');
        }else{
            return DB::table('SA_USER_GROUP')->where('GROUP_FOR',1)->pluck('GROUP_NAME', 'PK_NO');
        }
    }

    public function getAdminGroupList($user_type)
    {

        if ($user_type == '0') {
            return DB::table('SA_USER_GROUP')->where('GROUP_FOR',0)->pluck('GROUP_NAME', 'PK_NO');
        }elseif ($user_type == '10') {
            return DB::table('SA_USER_GROUP')->where('GROUP_FOR',1)->pluck('GROUP_NAME', 'PK_NO');
        }else{
            return DB::table('SA_USER_GROUP')->where('GROUP_FOR',2)->pluck('GROUP_NAME', 'PK_NO');
        }
    }


}
