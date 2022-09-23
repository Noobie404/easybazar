<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\User;
use App\Seller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\AdminUserRequest;
use App\Repositories\Admin\Role\RoleInterface;
use App\Repositories\Admin\Seller\SellerInterface;
use App\Repositories\Admin\AdminUser\AdminUserInterface;
use App\Repositories\Admin\UserGroup\UserGroupInterface;

class AdminUserController extends BaseController
{
    protected $user;
    protected $role;
    protected $userGroup;

    public function __construct( SellerInterface $seller, AdminUserInterface $user, RoleInterface $role, UserGroupInterface $userGroup)
    {
        $this->user = $user;
        $this->role = $role;
        $this->userGroup = $userGroup;
        $this->seller          = $seller;
    }

    public function getIndex(Request $request)
    {
        $this->resp = $this->user->getPaginatedList($request);
        return view('admin.admin-user.index')
        ->withTriggers($this->resp->data);
    }

    public function getSellerUser($id)
    {
        $data['title']  = 'Branch user list';
        $this->resp     = $this->seller->getSellerUser($id);
        $data['rows']   = $this->resp->data;
        $data['seller']   = User::find($id);

        return view('admin.admin-user.branch_admin_user',compact('data'));
    }

    public function getBranchAdmin(Request $request)
    {
        $this->resp = $this->user->getBranchAdmin($request);
        return view('admin.admin-user.branch_admin')
        ->withTriggers($this->resp->data);
    }

    public function editBranchAdmin(Request $request, $id)
    {
        $this->resp = $this->user->getShow($id);
        if($this->resp->data->USER_TYPE == '0'){
            if(Auth::user()->USER_TYPE != '0' ){
                return abort(404);
            }
        }
        if (!$this->resp->status) {
            return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
        }

        return view('admin.admin-user.branch_admin_edit')->withUser($this->resp->data)->withUserGroup($this->userGroup->getAdminGroupList($this->resp->data->USER_TYPE));

    }

    public function getBranchUser(Request $request)
    {

        $this->resp = $this->user->getBranchUser($request);
        return view('admin.seller-user.index')
        ->withTriggers($this->resp->data);

    }

    public function getCreate(Request $request) {
        if ($request->segment(1) == 'seller') {
            return view('admin.seller-user.create')->withUserGroup($this->userGroup->getList($request))->withRole($this->role->getList($request));
        }else{
            return view('admin.admin-user.create')->withUserGroup($this->userGroup->getList($request))->withRole($this->role->getList($request));
        }
    }

    public function postStore(AdminUserRequest $request)
    {
        $this->resp = $this->user->postStore($request);

        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getEdit(Request $request, $id)
    {
        $this->resp = $this->user->getShow($id);
        if($this->resp->data->USER_TYPE == '0'){
            if(Auth::user()->USER_TYPE != '0' ){
                return abort(404);
            }
        }
        if (!$this->resp->status) {
            return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
        }

        return view('admin.admin-user.edit')->withUser($this->resp->data)->withUserGroup($this->userGroup->getAdminGroupList($this->resp->data->USER_TYPE));


    }

    public function putUpdate(AdminUserRequest $request, $id, $type = null)
    {

        $this->resp = $this->user->postUpdate($request, $id,$type);
        if($request->user == 'branch_user'){
            return redirect()->route('admin.branch-admin')->with($this->resp->redirect_class, $this->resp->msg);
        }else{
            return redirect()->back()->with($this->resp->redirect_class, $this->resp->msg);
        }

    }

    public function getDelete($id)
    {
        $this->resp = $this->user->delete($id);

        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getEditSingle(Request $request, $id)
    {
        $this->resp = $this->user->getShow($id);

        if (!$this->resp->status) {
            return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
        }

        return view('admin.admin-user.singleEdit')->withUser($this->resp->data);
    }


}
