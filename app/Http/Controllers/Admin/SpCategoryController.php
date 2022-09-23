<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Models\SpCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\SubCategoryRequest;
use App\Repositories\Admin\SpCategory\SpCategoryInterface;

class SpCategoryController extends BaseController
{
    protected $sp_category;
    public function __construct(SpCategoryInterface $sp_category)
    {
        $this->sp_category  = $sp_category;
    }

    public function getIndex(Request $request)
    {
        $this->resp = $this->sp_category->getSpCategoryList($request, 10);
        $data['rows'] = $this->resp->data;
        return view('admin.spcategory.index', compact('data'));
    }

    public function getEdit(Request $request,$id)
    {
        $data = SpCategory::find($id);
        return view('admin.spcategory.edit', compact('data'));
    }

    public function getCreate(Request $request)
    {
        return view('admin.spcategory.create');
    }

    public function postStore(Request $request) {

        $this->resp = $this->sp_category->postStore($request);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function postUpdate(Request $request,$id) {

        $this->resp = $this->sp_category->postUpdate($request,$id);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function postSlugUpdate(Request $request) {

        $this->resp = $this->sp_category->postSlugUpdate($request);
        return response()->json($this->resp);
    }

    public function getDelete($id) {

        $this->resp = $this->sp_category->getDelete($id);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }
}
