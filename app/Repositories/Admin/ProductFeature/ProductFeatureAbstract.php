<?php

namespace App\Repositories\Admin\ProductFeature;

use DB;
use Str;
use App\Traits\RepoResponse;
use App\Models\ProductFeatureChild;
use App\Models\ProductFeatureMaster;

class ProductFeatureAbstract implements ProductFeatureInterface
{
    use RepoResponse;
    protected $productFeatureMaster;

    public function __construct(ProductFeatureMaster $productFeatureMaster)
    {
        $this->productFeatureMaster = $productFeatureMaster;
    }

    public function postMaster($request)
    {
        DB::beginTransaction();
        try {
            // $check = DB::table('PRD_ATTRIBUTE_MASTER')->where('NAME',$request->name)->count();
            // if ($check > 0) {
            //     return $this->formatResponse(false, 'Duplicate product attribute !', 'admin.product-attr-master.new');
            // }
            $slug = Str::slug(strtolower($request->name));
            $check = ProductFeatureMaster::where('SLUG',$slug)->first();
            if($check){
                $slug = $slug.'-'.rand(1,99);
            }
            $productFeaMaster                   = new ProductFeatureMaster();
            $productFeaMaster->NAME             = $request->name;
            $productFeaMaster->TITLE            = $request->title;
            $productFeaMaster->SLUG             = $slug;
            $productFeaMaster->IS_ACTIVE        = $request->is_active;
            $productFeaMaster->IS_COLOR         = $request->is_color;
            $productFeaMaster->FEATURE_TYPE     = $request->type;
            $productFeaMaster->DESCRIPTION      = $request->description;
            $productFeaMaster->save();
            // if ($request->type == 2) { //MULTISELECT
                $values = explode(',',$request->multiselect_attributes);
                foreach ($values as $key => $value) {
                    $productFeaChild            = new ProductFeatureMaster();
                    $productFeaChild->NAME      = $value;
                    $productFeaChild->TITLE     = $value;
                    $productFeaChild->ORDER_NO  = $key+1;
                    $productFeaChild->F_PARENT_NO = $productFeaMaster->PK_NO;
                    $productFeaChild->save();
                }
            // }
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, 'Unable to create product feature !', 'admin.product-feature-master.new');
        }
        DB::commit();
        return $this->formatResponse(true, 'Product feature has been created successfully', 'admin.product-feature-master.index');
    }

    public function getShow(int $PK_NO)
    {
        $data = ProductModel::where('PK_NO',$PK_NO)->first();
        if (!empty($data)) {
            return $this->formatResponse(true, 'Data found', 'admin.product-model.edit', $data);
        }

        return $this->formatResponse(false, 'Did not found data !', 'admin.product-model', null);
    }

    public function postMasterUpdate($request, $PK_NO)
    {
        DB::beginTransaction();
        try {
            $check = DB::table('PRD_FEATURE_MASTER')->where('NAME',$request->name)->where('PK_NO','!=',$PK_NO)->count();
            if ($check > 0) {
                return $this->formatResponse(false, 'Duplicate product feature !', 'admin.product-feature-master.new');
            }
            $slug = Str::slug(strtolower($request->name));
            $check = ProductFeatureMaster::where('SLUG',$slug)->where('PK_NO','!=',$PK_NO)->first();
            if($check){
                $slug = $slug.'-'.rand(1,99);
            }
            $productFeaMaster               = ProductFeatureMaster::find($PK_NO);
            $productFeaMaster->NAME         = $request->name;
            $productFeaMaster->TITLE        = $request->title;
            $productFeaMaster->SLUG         = $slug;
            $productFeaMaster->IS_ACTIVE    = $request->is_active;
            $productFeaMaster->IS_COLOR     = $request->is_color;
            $productFeaMaster->FEATURE_TYPE = $request->type;
            $productFeaMaster->DESCRIPTION  = $request->description;
            $productFeaMaster->update();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, 'Unable to update Product feature !', 'admin.product-feature-master.index');
        }
        DB::commit();
        return $this->formatResponse(true, 'Product feature has been Updated successfully', 'admin.product-feature-master.index');
    }

    public function getMasterDelete(int $PK_NO)
    {
        DB::beginTransaction();
        try {
            ProductAttrMaster::find($PK_NO)->delete();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, 'Unable to delete Product attribute !', 'admin.product-attr-master.index');
        }
        DB::commit();
        return $this->formatResponse(true,'Successfully deleted product model','admin.product-attr-master.index');
    }

    public function postFeatureAddUpdate($request)
    {
        DB::beginTransaction();
        try {
            $data = null;
            if ($request->type == 'add') {
                $check = ProductFeatureMaster::where('NAME',$request->value)->where('F_PARENT_NO',$request->parent)->count();
                if ($check > 0) {
                    return $this->formatResponse(false, 'Duplicate value !', 'admin.product-feature-master.index');
                }
                $check = ProductFeatureMaster::select('FEATURE_TYPE')->where('PK_NO',$request->parent)->first();
                $max_order = ProductFeatureMaster::where('F_PARENT_NO',$request->parent)->max('ORDER_NO');
                $productFeature                 = new ProductFeatureMaster();
                $productFeature->NAME           = $request->value;
                $productFeature->TITLE          = $request->value;
                $productFeature->F_PARENT_NO    = $request->parent;
                $productFeature->ORDER_NO       = $max_order+1;
                $productFeature->save();
                $msg = 'Successfully added product feature !';
                $pk_no = $productFeature->PK_NO;
                $data['value'] = $request->value;
                $data['pk_no'] = $pk_no;
                $data['type']  = $check->FEATURE_TYPE;
                $data['html']  = view('admin.product-feature.append_child_new_value')->withData($data)->render();
            }elseif($request->type == 'update'){
                $check = ProductFeatureMaster::where('NAME',$request->value)->where('F_PARENT_NO',$request->parent)->where('PK_NO','!=',$request->pk_no)->count();
                if ($check > 0) {
                    return $this->formatResponse(false, 'Duplicate value !', 'admin.product-feature-master.index');
                }
                $productFeature         = ProductFeatureMaster::find($request->pk_no);
                $productFeature->NAME   = $request->value;
                $productFeature->TITLE  = $request->value;
                $productFeature->update();
                $msg = 'Successfully updated product feature !';
            }else{
                ProductFeatureMaster::where('PK_NO',$request->pk_no)->delete();
                $msg = 'Successfully deleted product feature !';
            }
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return $this->formatResponse(false, 'Unable to perform action !', 'admin.product-feature-master.index');
        }
        DB::commit();
        return $this->formatResponse(true,$msg,'admin.product-feature-master.index',$data);
    }

    public function postAddUpdateFeatureChilds($request)
    {
        DB::beginTransaction();
        try {
            $data = null;
            if ($request->type == 'add') {
                $check = ProductFeatureMaster::where('NAME',$request->value)->where('F_PARENT_NO',$request->parent_pk)->count();
                if ($check > 0) {
                    return $this->formatResponse(false, 'Duplicate value !', 'admin.product-feature-master.index');
                }
                $max_order = ProductFeatureMaster::where('F_PARENT_NO',$request->parent_pk)->max('ORDER_NO');
                $productFeature                 = new ProductFeatureMaster();
                $productFeature->NAME           = $request->value;
                $productFeature->F_PARENT_NO    = $request->parent_pk;
                $productFeature->ORDER_NO       = $max_order+1;
                $productFeature->save();
                $msg = 'Successfully added product feature child !';
                $pk_no = $productFeature->PK_NO;
                $data['value'] = $request->value;
                $data['pk_no'] = $pk_no;
                $data['html']  = view('admin.product-feature.append_fea_child_new_value')->withData($data)->render();
            }elseif($request->type == 'update'){
                $check = ProductFeatureMaster::where('NAME',$request->value)->where('F_PARENT_NO',$request->parent_pk)->where('PK_NO','!=',$request->pk_no)->count();
                if ($check > 0) {
                    return $this->formatResponse(false, 'Duplicate value !', 'admin.product-feature-master.index');
                }
                $productFeature         = ProductFeatureMaster::find($request->pk_no);
                $productFeature->NAME   = $request->value;
                $productFeature->update();
                $msg = 'Successfully updated product feature !';
            }else{
                ProductFeatureMaster::where('PK_NO',$request->pk_no)->delete();
                $msg = 'Successfully deleted product feature !';
            }
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return $this->formatResponse(false, 'Unable to perform action !', 'admin.product-feature-master.index');
        }
        DB::commit();
        return $this->formatResponse(true,$msg,'admin.product-feature-master.index',$data);
    }

    public function postShowFeatureChild($request)
    {
        DB::beginTransaction();
        try {
            $data = null;
            $featureChilds = DB::table('PRD_FEATURE_MASTER')->where('F_PARENT_NO',$request->pk_no)->orderBy('ORDER_NO','ASC')->get();
            if (isset($featureChilds) && !empty($featureChilds)) {
                $data['html']  = view('admin.product-feature.show_feature_child')->withData($featureChilds)->render();
            }
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return $this->formatResponse(false, 'Unable to perform action !', 'admin.product-feature-master.index');
        }
        DB::commit();
        return $this->formatResponse(true,'Feature child loaded successfully !','admin.product-feature-master.index',$data);
    }

    public function getList($request)
    {
        return DB::table('admin.product-Model')->pluck('name', 'PK_NO');
    }
}
