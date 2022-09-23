<?php

namespace App\Http\Controllers\Seller;

use Auth;
use Session;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Hscode;
use App\Models\Product;
use App\Models\Category;
use App\Models\VatClass;
use App\Models\ProductSize;
use App\Models\SubCategory;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Models\Country;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\ProductRequest;
use App\Http\Requests\Admin\ProductVariantRequest;
use App\Repositories\Admin\Product\ProductInterface;
use App\Repositories\Admin\Category\CategoryInterface;

class ProductController extends BaseController
{
    protected $product;
    protected $productModel;
    protected $productInt;
    protected $vatClass;
    protected $category;
    protected $subCategory;
    protected $brand;
    protected $size;
    protected $color;
    protected $hscode;
    protected $categoryInt;
    protected $country;
    public function __construct(
        Product             $product,
        ProductModel        $productModel,
        ProductInterface    $productInt,
        VatClass            $vatClass,
        Category            $category,
        CategoryInterface   $categoryInt,
        SubCategory         $subCategory,
        Brand               $brand,
        ProductSize         $size,
        Color               $color,
        Hscode              $hscode,
        Country             $country
    )
    {
        $this->product          = $product;
        $this->productModel     = $productModel;
        $this->productInt       = $productInt;
        $this->vatClass         = $vatClass;
        $this->category         = $category;
        $this->subCategory      = $subCategory;
        $this->brand            = $brand;
        $this->color            = $color;
        $this->size             = $size;
        $this->hscode           = $hscode;
        $this->categoryInt      = $categoryInt;
        $this->country          = $country;

    }

    public function getIndex(Request $request)
    {
        return view('seller.product.index');
    }


    public function getProductSearch()
    {
        Session::put('list_type', 'searchlist');
        return view('seller.product.search_list');
    }

    public function getCreate(Request $request)
    {
        $data[]                         = '';
        $data['vat_class_combo']        =  $this->vatClass->getVatClassCombo();
        $data['categories']             =  $this->categoryInt->getCategoryList($request);
        $data['brand_combo']            =  $this->brand->getBrandCombo();
        $data['country']                =  $this->country->getCountryCombo();

        return view('seller.product.create')->withData($data);
    }

    public function getProdModel($brand_id)
    {
        $prod_model = $this->productModel->getProdModel($brand_id);
        return response()->json($prod_model);
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

    public function postStore(ProductRequest $request)
    {
        dd($request->all());
        $this->resp = $this->productInt->postStore($request);
        if ($this->resp->status == true) {
            $pk_no = $this->resp->data;
            return redirect()->route('seller.product.edit',['id' => $pk_no,'type' => 'variant', 'tab' => 2])->with($this->resp->redirect_class, $this->resp->msg);
        }else{
            return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
        }

    }

    public function postStoreProductVariant(ProductVariantRequest $request)
    {
        $this->resp = $this->productInt->postStoreProductVariant($request);
        $pk_no = $request->pk_no;
        return redirect()->route('seller.product.edit',['id' => $pk_no,'type' => 'variant', 'tab' => 2])->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getEdit(Request $request, $id)
    {
        $data[] = '';
        $this->resp = $this->productInt->getShow($id);
        $cat_id     = $this->resp->data->subcategory->category->PK_NO ?? 0;
        $brand_id   = $this->resp->data->F_BRAND ?? 0;
        $subcat_id  = $this->resp->data->subcategory->PK_NO ?? 0;

        $data['vat_class_combo']    = $this->vatClass->getVatClassCombo();
        $data['category_combo']     = $this->category->getCategorCombo();
        $data['subcategory_combo']  = $this->subCategory->getSubcateByCategor($cat_id, 'list');
        $data['brand_combo']        = $this->brand->getBrandCombo();
        $data['prod_color_combo']   = $this->color->getColorCombo($brand_id);

        $data['prod_size_combo']    = $this->size->getProductSize($brand_id);
        $data['prod_model_combo']   = $this->productModel->getProdModel($brand_id, 'list');
        $data['hscode_combo']       = $this->hscode->getHscodeCombo($subcat_id,'list');
        // $data['variant_list']       = $this->productInt->getVariantByMaster($id);
        // $data['variant_info']       = $this->productInt->getVariantById($request->variant_id);

        if (!$this->resp->status) {
            return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
        }

        return view('seller.product.edit')->withProduct($this->resp->data)->withData($data);

    }

    public function editPendingVarint(Request $request, $id){

        $data = [];
        $variant = ProductVariant::where('IS_ACTIVE',2)->where('PK_NO',$id)->first();
        if($variant == null){ abort('404'); }

        $cat_id     = $variant->master->subcategory->category->PK_NO ?? 0;
        $brand_id   = $variant->master->F_BRAND ?? 0;
        $subcat_id  = $variant->master->subcategory->PK_NO;

        $data['vat_class_combo']    =  $this->vatClass->getVatClassCombo();
        $data['category_combo']     =  $this->category->getCategorCombo();
        $data['subcategory_combo']  =  $this->subCategory->getSubcateByCategor($cat_id, 'list');
        $data['brand_combo']        =  $this->brand->getBrandCombo();
        $data['prod_color_combo']   =  $this->color->getColorCombo($brand_id);

        $data['prod_size_combo']    =  $this->size->getProductSize($brand_id);
        $data['prod_model_combo']   =  $this->productModel->getProdModel($brand_id, 'list');
        $data['hscode_combo']       =  $this->hscode->getHscodeCombo($subcat_id,'list');
        $data['variant']            =  $variant;

        return view('seller.product.varint_edit', compact('data'));
    }

    public function getView($id)
    {
        $data[] = '';
        $this->resp = $this->productInt->getShow($id);
        $cat_id     = $this->resp->data->subcategory->category->PK_NO ?? 0;
        $brand_id   = $this->resp->data->F_BRAND ?? 0;
        $data['vat_class_combo']    =  $this->vatClass->getVatClassCombo();
        $data['category_combo']     =  $this->category->getCategorCombo();
        $data['subcategory_combo']  =  $this->subCategory->getSubcateByCategor($cat_id, 'list');
        $data['brand_combo']        =  $this->brand->getBrandCombo();
        $data['prod_color_combo']   =  $this->color->getColorCombo($brand_id);
        $data['prod_size_combo']    =  $this->size->getProductSize($brand_id);
        $data['prod_model_combo']   =  $this->productModel->getProdModel($brand_id, 'list');

        if (!$this->resp->status) {
            return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
        }
        return view('seller.product.view')->withProduct($this->resp->data)->withData($data);
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

    public function putUpdate(ProductRequest $request, $id)
    {
        $this->resp = $this->productInt->postUpdate($request, $id);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function putUpdateProductVariant(ProductVariantRequest $request, $id)
    {
        // dd(123);
        $this->resp = $this->productInt->postUpdateProductVariant($request, $id);
        if($request->submit == 'approved' || $request->submit == 'discard' ){
            return redirect()->route('admin.varint.pending')->with($this->resp->redirect_class, $this->resp->msg);
        }else{
            return redirect()->route('seller.product.edit',['id' => $request->pk_no,'type' => 'variant', 'tab' => 2])->with($this->resp->redirect_class, $this->resp->msg);

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
             $data['vat_class_combo']        =  $this->vatClass->getVatClassCombo();
             $data['category_combo']         =  $this->category->getCategorCombo();
             $data['brand_combo']            =  $this->brand->getBrandCombo();
             $data['rows']                   =  $this->resp->data;

             return view('seller.product.search_result', compact('data'));
        }
    }


    public function postMasterVariantView(Request $request)
    {
        $this->resp = $this->product->find($request->master);

        $data['category_combo']     =  $this->category->getCategorCombo();
        $data['subcategory_combo']  =  $this->subCategory->getSubcateByCategor($this->resp->F_PRD_CATEGORY_ID, 'list');
        $data['brand_combo']        =  $this->brand->getBrandCombo();
        $data['prod_model_combo']   =  $this->productModel->getProdModel($this->resp->F_BRAND, 'list');

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
        return view('seller.product.test')->withData($data);
    }

    public function getPendingMaster(Request $request)
    {
        return view('seller.product.pending_master');
    }

    public function getPendingVarint(Request $request)
    {
        return view('seller.product.pending_varint');
    }
}
