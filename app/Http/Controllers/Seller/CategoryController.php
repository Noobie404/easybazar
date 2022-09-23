<?php

namespace App\Http\Controllers\Seller;

use DB;
use Illuminate\Http\Request;
use App\Models\ProductAttrMaster;
use App\Models\ProductAttrRelation;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\CategoryRequest;
use App\Repositories\Admin\Category\CategoryInterface;

class CategoryController extends BaseController
{
    protected $category;

    public function __construct(CategoryInterface $category)
    {

        $this->category  = $category;
    }

    public function getIndex(Request $request)
    {
        $this->resp = $this->category->getPaginatedListStore($request, 20);
        return view('seller.category.index')->withRows($this->resp->data);

    }

    public function getCreate(Request $request) {
        $data= [];
        $data['attr']  = ProductAttrMaster::select('PK_NO','NAME','ATTRIBUTE_TYPE','IS_REQUIRED')->where('IS_ACTIVE',1)->get();
        $data['categories'] = $this->category->getCategoryList($request);
        return view('seller.category.create')->withData($data);
    }

    public function postStore(CategoryRequest $request) {

        $this->resp = $this->category->postStore($request);
        //dd($this->resp);

        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getEdit(Request $request, $id){

        $data = [];
        $this->resp             = $this->category->findOrThrowException($id);
        $data['categories']     = $this->category->getCategoryList($request);
        $data['category']       = $this->resp->data;
        $data['all_attr']       = ProductAttrMaster::select('PK_NO','NAME','ATTRIBUTE_TYPE','IS_REQUIRED')->where('IS_ACTIVE',1)->get();
        $data['selected_attr'] = DB::table('PRD_ATTRIBUTE_RELATIONS')->where('F_CATEGORY_NO',$id)->pluck('F_ATTRIBUTE_NO')->toArray();

        return view('seller.category.edit')->withData($data);
    }

    public function postUpdate(CategoryRequest $request, $id)
    {
        $this->resp = $this->category->postUpdate($request, $id);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getDelete($id)
    {
        $this->resp = $this->category->delete($id);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getParentAttributes($id)
    {
        $data = DB::table('PRD_ATTRIBUTE_RELATIONS')->select(DB::raw('group_concat(F_ATTRIBUTE_NO) as F_ATTRIBUTE_NO'))->where('F_CATEGORY_NO',$id)->where('IS_ACTIVE',1)->first();
        if (isset($data) && isset($data->F_ATTRIBUTE_NO)) {
            $resp = ['status' => 1,'data' => $data];
        }else{
            $resp = ['status' => 0];
        }
        return response()->json($resp);
    }
}
