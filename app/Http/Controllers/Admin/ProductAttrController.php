<?php

namespace App\Http\Controllers\Admin;
use DB;
use Illuminate\Http\Request;
use App\Models\ProductAttrChild;
use App\Models\ProductAttrMaster;
use App\Http\Controllers\BaseController;
use App\Repositories\Admin\ProductAttribute\ProductAttributeInterface;

class ProductAttrController extends BaseController
{
    protected $productAttrlInt;

    public function __construct(
        ProductAttributeInterface   $productAttrlInt,
        ProductAttrMaster           $prdAttrMaster,
        ProductAttrChild            $prdAttrChild
    )
    {
        $this->productAttrInt       = $productAttrlInt;
        $this->prdattrmaster        = $prdAttrMaster;
        $this->prdattrchild         = $prdAttrChild;
    }

    public function getMasterIndex(Request $request)
    {
        $data['data'] = $this->prdattrmaster->orderBy('NAME')->get();
        return view('admin.product-attr.index', compact('data'));
    }

    public function getChildIndex(Request $request)
    {
        $this->resp = $this->productAttrInt->getChildIndex($request);
        return view('admin.product-model.index')
        ->withModel($this->resp->data);
    }

    public function getMasterNew() {
        return view('admin.product-attr.create');
    }

    public function postMaster(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:PRD_ATTRIBUTE_MASTER',
        ]);
        $this->resp = $this->productAttrInt->postMaster($request);
        return redirect()->back()->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getMasterEdit($id)
    {
        $data = $this->prdattrmaster->find($id);
        if($data){
            return view('admin.product-attr.edit')->withData($data);
        }
        return redirect()->back()->with('flashMessageError', 'Attribute not found !');
    }

    public function getChildNew($id)
    {
        $data['master'] = $this->prdattrmaster->find($id);
        $data['child']  = $this->prdattrchild->select('PK_NO','VALUE','IS_ACTIVE')->where('F_ATTRIBUTE_MASTER',$id)->orderBy('ORDER_NO','ASC')->get();
        if($data['master']){
            return view('admin.product-attr.child')->withData($data);
        }
        return redirect()->back()->with('flashMessageError', 'Attribute not found !');
    }

    public function postMasterUpdate(Request $request, $PK_NO)
    {
        $request->validate([
            'name' => 'required|unique:PRD_ATTRIBUTE_MASTER,NAME,'. $PK_NO .',PK_NO'
        ]);
        $this->resp = $this->productAttrInt->postMasterUpdate($request, $PK_NO);

        return redirect()->back()->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function postChildAddUpdate(Request $request)
    {
        $data = $this->productAttrInt->postChildAddUpdate($request);

        return response()->json($data);
    }

    public function getMasterDelete($PK_NO) {

        $this->resp = $this->productAttrInt->getMasterDelete($PK_NO);
        return redirect()->back()->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function postChildOrderUpdate(Request $request){
        DB::beginTransaction();
        try {
            if($request->has('ids')){
                $arr = explode(',',$request->input('ids'));
                foreach($arr as $sortOrder => $id){
                    $attr = $this->prdattrchild::find($id);
                    $attr->ORDER_NO = $sortOrder+1;
                    $attr->update();
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            return ['status'=>0,'msg'=>'Unseccessfull !'];
        }
        DB::commit();
        return ['status'=>1,'msg'=>'Attribute order updated !'];
    }
}

