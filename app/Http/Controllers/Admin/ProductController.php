<?php

namespace App\Http\Controllers\Admin;
use Session;
use App\Models\Seller;
use App\Models\Country;
use App\Models\Product;
use App\Models\Category;
use App\Models\SpCategory;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\ProductVariantSpCategoryMap;
use App\Http\Requests\Admin\ProductVariantRequest;
use App\Repositories\Admin\Product\ProductInterface;
use App\Repositories\Admin\Category\CategoryInterface;

class ProductController extends BaseController
{
    protected $product;
    protected $productInt;
    protected $category;
    protected $categoryInt;
    protected $country;
    protected $seller;
    public function __construct(
        Product             $product,
        ProductInterface    $productInt,
        Category            $category,
        CategoryInterface   $categoryInt,
        Country             $country,
        Seller             $seller
    )
    {
        $this->product          = $product;
        $this->productInt       = $productInt;
        $this->category         = $category;
        $this->categoryInt      = $categoryInt;
        $this->country          = $country;
        $this->seller          = $seller;
    }

    public function getIndex(Request $request)
    {
        return view('admin.product.index');
    }

    public function getProductSearch(Request $request)
    {
        Session::put('list_type', 'searchlist');
       return view('admin.product.search_result');
    }

    public function getVariantStoreView($id)
    {
        return view('admin.product.variant_store_index',compact('id'));
    }

    public function getCreate(Request $request)
    {
        $data[]                         = '';
        $data['categories']             =  $this->categoryInt->getCategoryList($request);
        $data['country']                =  $this->country->getCountryCombo();
        return view('admin.product.create')->withData($data);
    }

    public function getProAddToShop(Request $request)
    {
        $data[] = '';
        $data['sellers'] = $this->seller->getSellerCombo();
        $resp = $this->productInt->getProAddToShop($request,200);
        $data['rows'] = $resp->data['products'];
        $data['shop_info'] = $resp->data['shop_info'];
        return view('admin.product.branch-products')->withData($data);
    }

    public function getShopMaster(Request $request)
    {
        $res = $this->productInt->getShopMaster($request);
        return response()->json($res);
    }

    public function storeToShop(Request $request)
    {
        $res = $this->productInt->storeToShop($request);
        return response()->json($res);
    }

    public function getShopMasterStatus(Request $request)
    {
        $res = $this->productInt->getShopMasterStatus($request);
        return response()->json($res);
    }

    public function getShopVariantStatus(Request $request)
    {
        $res = $this->productInt->getShopVariantStatus($request);
        return response()->json($res);
    }

    public function getVariantByMasterAj(Request $request)
    {
        $res = $this->productInt->getVariantByMasterAj($request);
        return response()->json($res);
    }

    public function getAjaxCategoryChild(Request $request)
    {
        $res = $this->productInt->getAjaxCategoryChild($request);
        return response()->json($res);
    }

    public function getSubcat($cat_id)
    {
        $sub_cat = $this->subCategory->getSubcateByCategor($cat_id);
        return response()->json($sub_cat);
    }

    public function getAjaxCategoryAttr(Request $request)
    {
        $resp = $this->productInt->getAjaxCategoryAttr($request);
        return response()->json($resp);
    }

    public function getAjaxAttrChilds(Request $request)
    {
        $resp = $this->productInt->getAjaxAttrChilds($request);
        return response()->json($resp);
    }

    public function getAjaxFeaOptions(Request $request)
    {
        $resp = $this->productInt->getAjaxFeaOptions($request);
        return response()->json($resp);
    }

    public function getAjaxVariantGenerate(Request $request)
    {
        $resp = $this->productInt->getAjaxVariantGenerate($request);
        return response()->json($resp);
    }

    public function postAjaxDeleteAddtionalCategory(Request $request)
    {
        $resp = $this->productInt->postAjaxDeleteAddtionalCategory($request);
        return response()->json($resp);
    }

    public function postAjaxDeleteProductAttribute(Request $request)
    {
        $resp = $this->productInt->postAjaxDeleteProductAttribute($request);
        return response()->json($resp);
    }

    public function postAjaxRefreshProductAttribute(Request $request)
    {
        $resp = $this->productInt->postAjaxRefreshProductAttribute($request);
        return response()->json($resp);
    }

    public function postAjaxAddAddtionalCategory(Request $request)
    {
        $resp = $this->productInt->postAjaxAddAddtionalCategory($request);
        return response()->json($resp);
    }

    public function postSpcatDeleteAjax(Request $request) {
        $this->resp = $this->productInt->postSpcatDeleteAjax($request);
        return response()->json($this->resp);
    }

    public function postSpcatStoreAjax(Request $request) {
        $this->resp = $this->productInt->postSpcatStoreAjax($request);
        return response()->json($this->resp);
    }

    public function postStore(ProductRequest $request)
    {
        $this->resp = $this->productInt->postStore($request);
        if ($this->resp->status == true) {
            $pk_no = $this->resp->data;
            return redirect()->route('admin.product.edit',['id' => $pk_no,'type' => 'variant', 'tab' => 2])->with($this->resp->redirect_class, $this->resp->msg);
        }else{
              return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
        }
    }

    public function postStoreProductVariant(ProductVariantRequest $request)
    {
        $this->resp = $this->productInt->postStoreProductVariant($request);
        $pk_no = $request->pk_no;
        return redirect()->route('admin.product.edit',['id' => $pk_no,'type' => 'variant', 'tab' => 2])->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getEdit(Request $request, $id)
    {
        $data[] = '';
        $this->resp = $this->productInt->getShow($id);
        $data['categories']    = $this->categoryInt->getCategoryList($request);
        $data['spcategories']  = SpCategory::pluck('NAME','PK_NO');
        $data['selected_spcategories'] = ProductVariantSpCategoryMap::select('PK_NO')->where('F_PRD_MASTER_SETUP_NO',$id)->groupBy('F_PRD_SPCATEGORY')->get();
        if (!$this->resp->status) {
            return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
        }
        return view('admin.product.edit')->withProduct($this->resp->data)->withData($data);
    }

    public function editPendingVarint(Request $request, $id){
        $data = [];
        $variant = ProductVariant::where('IS_ACTIVE',2)->where('PK_NO',$id)->first();
        if($variant == null){ abort('404'); }
        $cat_id     = $variant->master->subcategory->category->PK_NO ?? 0;
        $brand_id   = $variant->master->F_BRAND ?? 0;
        $subcat_id  = $variant->master->subcategory->PK_NO;
        $data['category_combo']     =  $this->category->getCategorCombo();
        $data['subcategory_combo']  =  $this->subCategory->getSubcateByCategor($cat_id, 'list');
        $data['brand_combo']        =  $this->brand->getBrandCombo();
        $data['variant']            =  $variant;
        return view('admin.product.varint_edit', compact('data'));
    }

    public function getView($id)
    {
        $this->resp = $this->productInt->getShow($id);
        $cat_id     = $this->resp->data->subcategory->category->PK_NO ?? 0;
        $brand_id   = $this->resp->data->F_BRAND ?? 0;
        // $data['category_combo']     =  $this->category->getCategorCombo();
        // $data['subcategory_combo']  =  $this->subCategory->getSubcateByCategor($cat_id, 'list');
        if (!$this->resp->status) {
            return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
        }
        return view('admin.product.view')->withProduct($this->resp->data['product']);
        // ->withData($data);
    }

    public function getDeleteImage($id)
    {
        $this->resp = $this->productInt->deleteImage($id);
        return response()->json($this->resp);
    }

    public function getHscode($subcat_id = null)
    {
        $this->resp = $this->hscode->getHscodeCombo($subcat_id);
        return response()->json($this->resp);
    }
    public function getBrandModelByScat($subcat_id = null)
    {
        $this->resp = $this->productInt->getBrandModelByScat($subcat_id);
        return response()->json($this->resp);
    }

    public function putUpdate(ProductRequest $request, $id)
    {
        $this->resp = $this->productInt->postUpdate($request, $id);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function putUpdateProductVariant(ProductVariantRequest $request, $id)
    {
        $this->resp = $this->productInt->postUpdateProductVariant($request, $id);
        if($request->submit == 'approved' || $request->submit == 'discard' ){
            return redirect()->route('admin.varint.pending')->with($this->resp->redirect_class, $this->resp->msg);
        }else{
            return redirect()->route('admin.product.edit',['id' => $request->pk_no,'variant_id' => $id,'type' => 'variant', 'tab' => 2])->with($this->resp->redirect_class, $this->resp->msg);
        }
    }

    public function getDelete($id)
    {
        $this->resp = $this->productInt->delete($id);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getDeleteProductVariant($id)
    {
        $this->resp = $this->productInt->getDeleteProductVariant($id);
        return redirect()->back()->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getProductSearchList(Request $request)
    {
        if($request->ajax()){
            $this->resp = $this->productInt->getProductSearchList($request);
            $multiple_select = trim($request->multiple_select);
            $html = view('admin.components._result_rows')->withRows($this->resp->data)->withMultiselect($multiple_select)->render();
            $data['html'] = $html;
            return response()->json($data);
        }else {
             $this->resp = $this->productInt->getProductSearchList($request);
             $data[]                         = '';
             $data['category_combo']         =  $this->category->getCategorCombo();
             $data['rows']                   =  $this->resp->data;
             return view('admin.product.search_result', compact('data'));
        }
    }


    public function postMasterVariantView(Request $request)
    {
        $this->resp = $this->product->find($request->master);
        $data['category_combo']     =  $this->category->getCategorCombo();
        $data['subcategory_combo']  =  $this->subCategory->getSubcateByCategor($this->resp->F_PRD_CATEGORY_ID, 'list');
        $html = view('admin.components._master_variant_update_modal')->withRows($this->resp)->withData($data)->render();
        $data['html'] = $html;
        return response()->json($data);
    }

    public function postMasterSearch(Request $request)
    {
        $this->resp = $this->product->where('F_PRD_CATEGORY_ID',$request->category)->where('F_PRD_SUB_CATEGORY_ID',$request->sub_category)->where('F_BRAND',$request->brand)->where('F_MODEL',$request->prod_model)->get();

        $html = view('admin.components._search_master_list')->withRows($this->resp)->render();
        $data['html'] = $html;
        return response()->json($data);
    }

    public function postVariantMasterSwap(Request $request)
    {
        $data = $this->productInt->postVariantMasterSwap($request);
        return response()->json($data);
    }

    public function getProductSearchGoBack(Request $request)
    {
        $url = $request->parent_url;
        $queryString = $product_no_arra  =  request()->get('product_no');
       if (empty($url )) {
           return redirect()->back();
       }
       if(empty($queryString)){
            return redirect()->to($url);
       }
        $queryString = http_build_query($queryString,'product_no_');
        $queryString = $url.'?'.$queryString;
        if(!empty($url) && (!empty($product_no_arra))){
            return redirect()->to($queryString);
        }else{
            return redirect()->back();
        }
    }

    public function test(Request $request)
    {
        $data = '';
        return view('admin.product.test')->withData($data);
    }

    public function getPendingMaster(Request $request)
    {
        return view('admin.product.pending_master');
    }

    public function getPendingVarint(Request $request)
    {
        return view('admin.product.pending_varint');
    }

    public function postIfMasterStore(Request $request)
    {
        $data = $this->productInt->postIfMasterStore($request);
        return response()->json($data);
    }

    public function postIfVariantStore(Request $request)
    {
        $data = $this->productInt->postIfVariantStore($request);
        return response()->json($data);
    }

    public function postIfCategoryStore(Request $request)
    {
        $data = $this->productInt->postIfCategoryStore($request);
        return response()->json($data);
    }

    public function getSearchList(Request $request)
    {
         $data = $this->productInt->getSearchList($request);
        return response()->json($data);
    }

    
}
