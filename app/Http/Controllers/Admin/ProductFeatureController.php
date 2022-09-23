<?php

namespace App\Http\Controllers\Admin;
use DB;
use Illuminate\Http\Request;
use App\Models\ProductFeatureChild;
use App\Models\ProductFeatureMaster;
use App\Http\Controllers\BaseController;
use App\Repositories\Admin\ProductFeature\ProductFeatureInterface;

class ProductFeatureController extends BaseController
{
    protected $productFeatureInt;

    public function __construct(
        ProductFeatureInterface     $productFeatureInt,
        ProductFeatureMaster        $prdFeatureMaster,
        ProductFeatureChild         $prdFeatureChild
    )
    {
        $this->productFeatureInt       = $productFeatureInt;
        $this->prdfeaturemaster        = $prdFeatureMaster;
        $this->prdfeaturechild         = $prdFeatureChild;
    }

    public function getMasterIndex(Request $request)
    {
        $data['data'] = $this->prdfeaturemaster->where('F_PARENT_NO',0)->orderBy('NAME')->get();
        return view('admin.product-feature.index', compact('data'));
    }

    public function getChildIndex(Request $request)
    {
        $this->resp = $this->productFeatureInt->getChildIndex($request);
        return view('admin.product-model.index')
        ->withModel($this->resp->data);
    }

    public function getMasterNew() {
        return view('admin.product-feature.create');
    }

    public function postMaster(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:PRD_FEATURE_MASTER',
        ]);
        $this->resp = $this->productFeatureInt->postMaster($request);
        return redirect()->back()->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getMasterEdit($id)
    {
        $data['parent'] = $this->prdfeaturemaster->find($id);
        $data['child'] = $this->prdfeaturemaster->where('F_PARENT_NO',$data['parent']->PK_NO)->orderBy('ORDER_NO','ASC')->get();
        if($data['parent']){
            return view('admin.product-feature.edit')->withData($data);
        }
        return redirect()->back()->with('flashMessageError', 'Product feature not found !');
    }

    public function getChildNew($id)
    {
        $data['master'] = $this->prdfeaturemaster->find($id);
        $data['child']  = $this->prdfeaturechild->select('PK_NO','VALUE','IS_ACTIVE')->where('F_ATTRIBUTE_MASTER',$id)->orderBy('ORDER_NO','ASC')->get();
        if($data['master']){
            return view('admin.product-feature.child')->withData($data);
        }
        return redirect()->back()->with('flashMessageError', 'Attribute not found !');
    }

    public function postMasterUpdate(Request $request, $PK_NO)
    {
        $request->validate([
            'name' => 'required|unique:PRD_FEATURE_MASTER,NAME,'. $PK_NO .',PK_NO'
        ]);
        $this->resp = $this->productFeatureInt->postMasterUpdate($request, $PK_NO);

        return redirect()->back()->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function postShowFeatureChild(Request $request)
    {
        $data = $this->productFeatureInt->postShowFeatureChild($request);

        return response()->json($data);
    }

    public function postFeatureAddUpdate(Request $request)
    {
        $data = $this->productFeatureInt->postFeatureAddUpdate($request);

        return response()->json($data);
    }

    public function postAddUpdateFeatureChilds(Request $request)
    {
        $data = $this->productFeatureInt->postAddUpdateFeatureChilds($request);

        return response()->json($data);
    }

    public function getMasterDelete($PK_NO) {

        $this->resp = $this->productFeatureInt->getMasterDelete($PK_NO);
        return redirect()->back()->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function postMasterOrderUpdate(Request $request){
        DB::beginTransaction();
        try {
            if($request->has('ids')){
                $fea = explode(',',$request->input('ids'));
                foreach($fea as $sortOrder => $id){
                    $feature = $this->prdfeaturemaster::find($id);
                    $feature->ORDER_NO = $sortOrder+1;
                    $feature->update();
                }
                // if ($request->type == 'parent') {
                //     foreach($fea as $sortOrder => $id){
                //         $feature = $this->prdfeaturemaster::find($id);
                //         $feature->ORDER_NO = $sortOrder+1;
                //         $feature->update();
                //     }
                // }else{
                //     foreach($fea as $sortOrder => $id){
                //         $feature = $this->prdfeaturechild::find($id);
                //         $feature->ORDER_NO = $sortOrder+1;
                //         $feature->update();
                //     }
                // }
            }
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return ['status'=>0,'msg'=>'Unseccessfull !'];
        }
        DB::commit();
        return ['status'=>1,'msg'=>'Feature order updated !'];
    }
}

