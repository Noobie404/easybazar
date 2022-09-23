<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Repositories\Admin\Permission\PermissionInterface;
use App\Http\Requests\Admin\PermissionRequest;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

class PermissionController extends BaseController
{
    protected $permission;

    public function __construct(PermissionInterface $permission)
    {
        $this->permission = $permission;
    }

    public function getIndex(Request $request)
    {
        $this->resp = $this->permission->getPaginatedList($request, 50);
        return view('admin.permission.index')->withRows($this->resp->data);

        // if ($request->segment(1) == 'seller') {
        //     return view('admin.seller-permission.index')->withRows($this->resp->data);
        // }else{
        // }
    }

    public function getCreate(Request $request) {
        if ($request->segment(1) == 'seller') {
            return view('admin.seller-permission.create')->withGroup($this->permission->getList($request));
        }else{
            return view('admin.permission.create')->withGroup($this->permission->getList($request));
        }
    }

    public function postStore(PermissionRequest $request)
    {
        $this->resp = $this->permission->postStore($request);

        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getEdit(Request $request, $id)
    {
        $this->resp = $this->permission->getShow($request,$id);

        if (!$this->resp->status) {
            return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
        }
        $view = $request->segment(1) == 'seller' ? 'admin.seller-permission.edit' : 'admin.permission.edit';

        return view($view)->withPermission($this->resp->data)->withGroup($this->permission->getList($request));
    }

    public function putUpdate(PermissionRequest $request, $id)
    {
        $this->resp = $this->permission->postUpdate($request, $id);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getDelete(Request $request,$id)
    {
        $this->resp = $this->permission->delete($request,$id);

        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }
}
