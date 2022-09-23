<?php
namespace App\Repositories\Admin\AdminUser;

use App\Models\AdminUser as User;
use App\Traits\RepoResponse;
use App\Repositories\Admin\Auth\AuthAbstract;
use App\Models\Auth;
use App\Models\AuthUserGroup;
use App\Models\UserGroup;
use DB;
use File;

class AdminUserAbstract implements AdminUserInterface
{
    use RepoResponse;

    protected $user;
    protected $auth;

    public function __construct(User $user, AuthAbstract $auth)
    {
        $this->user = $user;
        $this->auth = $auth;
    }

    public function getPaginatedList($request)
    {
        $data = Auth::leftJoin('SA_USER_GROUP_USERS', 'SA_USER_GROUP_USERS.F_USER_NO', 'SA_USER.PK_NO')
        ->leftJoin('SA_USER_GROUP_ROLE', 'SA_USER_GROUP_ROLE.F_USER_GROUP_NO', 'SA_USER_GROUP_USERS.F_GROUP_NO')
        ->leftJoin('SA_ROLE', 'SA_ROLE.PK_NO', 'SA_USER_GROUP_ROLE.F_ROLE_NO')
        ->leftJoin('SA_USER_GROUP', 'SA_USER_GROUP.PK_NO', 'SA_USER_GROUP_USERS.F_GROUP_NO')
        ->where('SA_USER.USER_TYPE','0')
        ->select('SA_USER.USER_TYPE','SA_USER.NAME as USER_NAME','SA_USER.EMAIL','SA_USER.MOBILE_NO','SA_USER.CAN_LOGIN','SA_USER.DESIGNATION','SA_USER.PK_NO','SA_USER.PROFILE_PIC_URL','SA_USER.STATUS', 'SA_USER_GROUP.GROUP_NAME','SA_ROLE.NAME', 'SA_USER.SHOP_NAME','SA_USER.SHOP_ID')
        ->orderBy('SA_USER.USER_TYPE','ASC')
        ->orderBy('SA_USER.NAME','ASC')
        ->get();
        // dd($data);

        return $this->formatResponse(true, '', 'admin', $data);

    }
    public function getBranchAdmin($request)
    {
        $data = Auth::leftJoin('SA_USER_GROUP_USERS', 'SA_USER_GROUP_USERS.F_USER_NO', 'SA_USER.PK_NO')
        ->leftJoin('SA_USER_GROUP_ROLE', 'SA_USER_GROUP_ROLE.F_USER_GROUP_NO', 'SA_USER_GROUP_USERS.F_GROUP_NO')
        ->leftJoin('SA_ROLE', 'SA_ROLE.PK_NO', 'SA_USER_GROUP_ROLE.F_ROLE_NO')
        ->leftJoin('SA_USER_GROUP', 'SA_USER_GROUP.PK_NO', 'SA_USER_GROUP_USERS.F_GROUP_NO')
        ->where('SA_USER.USER_TYPE','10')
        ->where('SA_USER.F_PARENT_USER_ID','0')
        ->select('SA_USER.USER_TYPE','SA_USER.NAME as USER_NAME','SA_USER.EMAIL','SA_USER.MOBILE_NO','SA_USER.CAN_LOGIN','SA_USER.DESIGNATION','SA_USER.PK_NO','SA_USER.PROFILE_PIC_URL','SA_USER.STATUS', 'SA_USER_GROUP.GROUP_NAME','SA_ROLE.NAME', 'SA_USER.SHOP_NAME','SA_USER.SHOP_ID',DB::raw("(SELECT IFNULL(COUNT(*),0) FROM SA_USER as child_u
        WHERE child_u.F_PARENT_USER_ID = SA_USER.PK_NO
        GROUP BY child_u.F_PARENT_USER_ID) as SUB_USER") )
        ->orderBy('SA_USER.USER_TYPE','ASC')
        ->orderBy('SA_USER.NAME','ASC')
        ->get();


        return $this->formatResponse(true, '', 'admin', $data);

    }


    public function getBranchUser($request)
    {
        $data = Auth::where('SA_USER.USER_TYPE',10)
            ->leftJoin('SA_USER_GROUP_USERS', 'SA_USER_GROUP_USERS.F_USER_NO', 'SA_USER.PK_NO')
            ->leftJoin('SA_USER_GROUP_ROLE', 'SA_USER_GROUP_ROLE.F_USER_GROUP_NO', 'SA_USER_GROUP_USERS.F_GROUP_NO')
            ->leftJoin('SA_ROLE', 'SA_ROLE.PK_NO', 'SA_USER_GROUP_ROLE.F_ROLE_NO')
            ->leftJoin('SA_USER_GROUP', 'SA_USER_GROUP.PK_NO', 'SA_USER_GROUP_USERS.F_GROUP_NO')
            ->select('SA_USER.NAME','SA_USER.EMAIL','SA_USER.MOBILE_NO','SA_USER.CAN_LOGIN','SA_USER.DESIGNATION','SA_USER.PK_NO','SA_USER.PROFILE_PIC_URL','SA_USER.STATUS', 'SA_USER_GROUP.GROUP_NAME','SA_ROLE.NAME');
            // if ($request->segment(1) == 'seller') {
            //     $data = $data->where('SA_ROLE.GROUP_FOR',2);
            // }else{
            //     $data = $data->where('SA_ROLE.GROUP_FOR',1);
            // }
        $data = $data->get();
        // dd($data);

        return $this->formatResponse(true, '', 'admin', $data);
    }

    public function postStore($request)
    {
        DB::beginTransaction();
        $redirect_to = $request->segment(1) == 'seller' ? 'seller.seller-user' : 'admin.admin-user';
        try {
            $auth = $this->auth->postStore($request);
            if($request->user_group != "")
            {
                $roleAuth               = new AuthUserGroup();
                $roleAuth->F_USER_NO    = $auth->PK_NO;
                $roleAuth->F_GROUP_NO   = $request->user_group;
                $roleAuth->save();
            }else{
                return $this->formatResponse(false, 'Please select User Group', $redirect_to);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), $redirect_to);
        }
        DB::commit();
        return $this->formatResponse(true, 'Admin User has been created successfully !', $redirect_to);
    }

    public function postUpdate($request, int $id, string $type = null)
    {

        $redirect_to = 'admin.admin-user';
        DB::beginTransaction();
        try {
            $this->auth->postUpdate($request, $id,$type);

            if($request->user_group != "")
            {

                $check = AuthUserGroup::where('F_USER_NO',$id)->first();
                if($check == null){
                    $ss = AuthUserGroup::insert(['F_GROUP_NO' => $request->user_group, 'F_USER_NO' => $id, 'STATUS' => 1]);
                    // dd($ss);
                }else{

                    AuthUserGroup::where('F_USER_NO',$id)->update(['F_GROUP_NO' => $request->user_group]);
                }

                // if ($request->profile_pic != '') {

                //     if(File::exists(public_path('media/images/profile/'.$request->PROFILE_PIC))) {
                //         File::delete(public_path('media/images/profile/'.$request->PROFILE_PIC));
                //     }
                //     $file_name = 'profile_'. date('dmY'). '_' .time(). '.' . $request->profile_pic->getClientOriginalExtension();
                //     $request->PROFILE_PIC->move(public_path('media/images/profile/'), $file_name);
                //     $request->PROFILE_PIC = '/media/images/profile/'.$file_name;
                //     $request->PROFILE_PIC = $file_name;
                // }

                // dd($request->profile_pic);

            }
            /*$roleAuth = AuthUserGroup::where('Auth_id',$id)->first();
            $roleAuth->role_id = $request->role;
            $roleAuth->update();*/
        } catch (\Exception $e) {
            dd($e);
            return $this->formatResponse(false, 'Unable to update user !', $redirect_to);
        }
        DB::commit();
        return $this->formatResponse(true, 'User has been updated successfully !', $redirect_to);
    }

    public function getShow(int $id)
    {
        $data =  Auth::leftJoin('SA_USER_GROUP_USERS','SA_USER_GROUP_USERS.F_USER_NO','SA_USER.PK_NO')
            ->select('SA_USER.*','SA_USER.STATUS as auth_status','SA_USER_GROUP_USERS.F_GROUP_NO')
            ->where('SA_USER.PK_NO', $id)
            ->first();

        if (!empty($data)) {
            return $this->formatResponse(true, '', 'admin.admin-user.admin-user', $data);
        }

        return $this->formatResponse(false, 'Did not found data !', 'admin.admin-user', null);
    }

    public function delete(int $id)
    {
        DB::begintransaction();
        try {
            AuthUserGroup::where('F_USER_NO',$id)->delete();
            Auth::where('PK_NO',$id)->delete();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, 'Unable to delete admin user !', 'admin.admin-user');
        }
        DB::commit();
        return $this->formatResponse(true, 'Successfully delete admin user !', 'admin.admin-user');
    }

    public function getSearchList($request)
    {
        $string = trim($request->search_string);
        $data = Auth::where('USER_TYPE','!=',1 )
                ->where('SA_USER.EMAIL', 'LIKE', '%' . $string . '%')->orWhere('SA_USER.NAME', 'LIKE', '%' . $string . '%')
                ->join('SA_USER_GROUP_USERS', 'SA_USER_GROUP_USERS.F_USER_NO', 'SA_USER.PK_NO')
                ->join('SA_USER_GROUP', 'SA_USER_GROUP.PK_NO', 'SA_USER_GROUP_USERS.F_GROUP_NO')
                ->join ('SA_USER_GROUP_ROLE', 'SA_USER_GROUP_ROLE.F_USER_GROUP_NO', 'SA_USER_GROUP_USERS.F_GROUP_NO')
                ->join ('SA_ROLE', 'SA_ROLE.PK_NO', 'SA_USER_GROUP_ROLE.F_ROLE_NO')
                ->select('SA_USER.NAME','SA_USER.EMAIL','SA_USER.MOBILE_NO','SA_USER.CAN_LOGIN','SA_USER.DESIGNATION','SA_USER.PK_NO','SA_USER.PROFILE_PIC_URL','SA_USER.STATUS', 'SA_USER_GROUP.GROUP_NAME','SA_ROLE.NAME')->get();
        //prixt($data,1);
        return $this->formatResponse(true, '', 'admin', $data);
    }
}
