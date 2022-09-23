<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\PermissionGroupRequest;
use App\Repositories\Admin\PermissionGroup\PermissionGroupInterface;


class PermissionGroupController extends BaseController
{
    protected $permissionGroup;

    public function __construct(PermissionGroupInterface $permissionGroup)
    {
        $this->permissionGroup = $permissionGroup;
    }

    public function getIndex(Request $request)
    {
        $this->resp = $this->permissionGroup->getPaginatedList($request, 20);
        return view('admin.permission-group.index')->withRows($this->resp->data);

        // if ($request->segment(1) == 'seller') {
        //     return view('admin.seller-permission-group.index')->withRows($this->resp->data);
        // }else{
        // }
    }

    public function getCreate(Request $request) {
        if ($request->segment(1) == 'seller') {
            return view('admin.seller-permission-group.create');
        }else{
            return view('admin.permission-group.create');
        }
    }

    public function postStore(PermissionGroupRequest $request)
    {
        $this->resp = $this->permissionGroup->postStore($request);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getEdit(Request $request, $id)
    {
        $this->resp = $this->permissionGroup->getShow($id);
        if (!$this->resp->status) {
            return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
        }
        if ($request->segment(1) == 'seller') {
            return view('admin.seller-permission-group.edit')->withPermissionGroup($this->resp->data);
        }else{
            return view('admin.permission-group.edit')->withPermissionGroup($this->resp->data);
        }
    }

    public function putUpdate(PermissionGroupRequest $request, $id)
    {
        $this->resp = $this->permissionGroup->postUpdate($request, $id);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getDelete(Request $request, $id)
    {
        $this->resp = $this->permissionGroup->delete($request,$id);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }
}
