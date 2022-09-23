<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\User;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ProductAttrMaster;
use App\Models\ProductAttrRelation;
use App\Models\ProductFeatureMaster;
use Illuminate\Support\Facades\Auth;
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
        $this->category_resp = $this->category->getPaginatedList($request, 20);
        return view('admin.category.index')->withRows($this->category_resp->data['data'])->withShop($this->category_resp->data['shop']);

    }

    public function getCreate(Request $request) {
        $data= [];
        $data['attr']  = ProductAttrMaster::select('PK_NO','NAME','ATTRIBUTE_TYPE','IS_REQUIRED')->where('IS_ACTIVE',1)->get();
        $data['feature'] = ProductFeatureMaster::select('PK_NO','NAME','IS_COLOR','FEATURE_TYPE','DESCRIPTION')->where('F_PARENT_NO',0)->where('IS_ACTIVE',1)->get();
        $data['categories'] = $this->category->getCategoryList($request);
        $data['max_order_id'] = Category::max('ORDER_ID');
        return view('admin.category.create')->withData($data);
    }

    public function postStore(CategoryRequest $request) {
        $this->resp = $this->category->postStore($request);
         return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getEdit(Request $request, $id){
        $data = [];
        $this->resp             = $this->category->findOrThrowException($id);
        $data['categories']     = $this->category->getCategoryList($request,$id);
        // $data['slider']         = $this->category->getCategorySlider($request,$id);
        $category       = $this->resp->data;
        $data['all_attr']       = ProductAttrMaster::select('PK_NO','NAME','ATTRIBUTE_TYPE','IS_REQUIRED')->where('IS_ACTIVE',1)->get();
        $data['all_feature']    = ProductFeatureMaster::select('PK_NO','NAME','IS_COLOR','FEATURE_TYPE','DESCRIPTION')->where('F_PARENT_NO',0)->where('IS_ACTIVE',1)->get();
        $data['selected_attr'] = DB::table('PRD_ATTRIBUTE_RELATIONS')->where('F_CATEGORY_NO',$id)->pluck('F_ATTRIBUTE_NO')->toArray();
        $data['selected_feature'] = DB::table('PRD_FEATURE_RELATIONS')->where('F_CATEGORY_NO',$id)->pluck('F_FEATURE_NO')->toArray();

        if(Auth::user()->USER_TYPE == 10){
            $shop_id = Auth::user()->SHOP_ID;
        }else{
            $shop_id = $request->shop;
        }
        $data['shop'] = null;
        if($shop_id){
            $data['shop'] = User::find($shop_id);
            $shop_category = DB::table('PRD_SHOP_CATEGORY_MAP')->where('F_CATEGORY_NO',$id)->where('F_SHOP_NO',$shop_id)->first();
            $category->ORDER_ID = $shop_category->ORDER_ID;
            $category->IS_FEATURE = $shop_category->IS_FEATURE;
            $category->IS_POPULAR = $shop_category->IS_POPULAR;
            $data['shop_category'] = $shop_category;
        }
        $data['category'] = $category;

        return view('admin.category.edit')->withData($data);
    }

    public function postUpdate(CategoryRequest $request, $id)
    {
        $this->resp = $this->category->postUpdate($request, $id);
        if($request->shop_id){
            return redirect()->route($this->resp->redirect_to,['shop'=>$request->shop_id])->with($this->resp->redirect_class, $this->resp->msg);
        }else{
            return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
        }
    }

    public function getDelete(Request $request, $id)
    {
        $this->resp = $this->category->delete($id);

        if($request->shop_id){
            return redirect()->route($this->resp->redirect_to,['shop_id'=>$request->shop_id])->with($this->resp->redirect_class, $this->resp->msg);
        }else{
            // return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
            return redirect()->back()->with($this->resp->redirect_class, $this->resp->msg);
        }

    }

    public function getParentAttributes($id)
    {
        $data['attr'] = DB::table('PRD_ATTRIBUTE_RELATIONS')->select(DB::raw('group_concat(F_ATTRIBUTE_NO) as F_ATTRIBUTE_NO'))->where('F_CATEGORY_NO',$id)->where('IS_ACTIVE',1)->first();
        $data['feature'] = DB::table('PRD_FEATURE_RELATIONS')->select(DB::raw('group_concat(F_FEATURE_NO) as F_FEATURE_NO'))->where('F_CATEGORY_NO',$id)->where('IS_ACTIVE',1)->first();
        if (isset($data) && isset($data['attr']->F_ATTRIBUTE_NO)) {
            $resp = ['status' => 1,'data' => $data];
        }else{
            $resp = ['status' => 0];
        }
        return response()->json($resp);
    }

    public function shopCatAddRemove($shop_id,$cat_id,$mode)
    {
        if($mode == 'uncheckd'){
            DB::table('PRD_SHOP_CATEGORY_MAP')->where('F_CATEGORY_NO',$cat_id)->where('F_SHOP_NO',$shop_id)->delete();
            $message = 'Category removed';
        }

        $is_admin_created = 1;
        $parent_id = 0;
        if(Auth::user()->USER_TYPE == 10){
            $is_admin_created = 0;
        }
        $cat = DB::table('PRD_CATEGORY')->where('PK_NO',$cat_id)->first();
        $parent_id = $cat->PARENT_ID;

        if($mode == 'checkd'){
            DB::table('PRD_SHOP_CATEGORY_MAP')->insert([
                'F_CATEGORY_NO'=>$cat_id,
                'F_SHOP_NO'=>$shop_id,
                'PARENT_ID'=>$parent_id,
                'IS_ADMIN_CREATED' =>$is_admin_created,
                'F_SS_CREATED_BY' => Auth::id(),
                'SS_CREATED_ON' => date('Y-m-d H:i:s')
                  ]);
                  $message = 'Category assigned';
        }

        $resp = ['status' => 1, 'message' => $message];
        return response()->json($resp);
    }


    public function getSubcategory($category_id)
    {
        $res = $this->category->getSubcategory($category_id);
        return response()->json($res);
    }


}
