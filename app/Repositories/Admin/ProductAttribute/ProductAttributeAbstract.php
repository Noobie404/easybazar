<?php

namespace App\Repositories\Admin\ProductAttribute;

use DB;
use Str;
use App\Traits\RepoResponse;
use App\Models\ProductAttrChild;
use App\Models\ProductAttrMaster;

class ProductAttributeAbstract implements ProductAttributeInterface
{
    use RepoResponse;
    protected $productAttrMaster;

    public function __construct(ProductAttrMaster $productAttrMaster)
    {
        $this->productAttrMaster = $productAttrMaster;
    }


    public function postMaster($request)
    {
        DB::beginTransaction();
        try {
            $check = DB::table('PRD_ATTRIBUTE_MASTER')->where('NAME',$request->name)->count();
            if ($check > 0) {
                return $this->formatResponse(false, 'Duplicate product attribute !', 'admin.product-attr-master.new');
            }
            $productAttrMaster                  = new ProductAttrMaster();
            $productAttrMaster->NAME            = $request->name;
            $productAttrMaster->TITLE           = $request->title;
            $productAttrMaster->SLUG            = Str::slug(strtolower($request->name));
            $productAttrMaster->IS_ACTIVE       = $request->is_active;
            $productAttrMaster->IS_REQUIRED     = $request->is_required;
            $productAttrMaster->ATTRIBUTE_TYPE  = $request->type;
            $productAttrMaster->save();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, 'Unable to create product attribute !', 'admin.product-attr-master.new');
        }
        DB::commit();
        return $this->formatResponse(true, 'Product attribute has been created successfully', 'admin.product-attr-master.index');
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
            $check = DB::table('PRD_ATTRIBUTE_MASTER')->where('NAME',$request->name)->where('PK_NO','!=',$PK_NO)->count();
            if ($check > 0) {
                return $this->formatResponse(false, 'Duplicate product attribute !', 'admin.product-attr-master.new');
            }
            $productAttrMaster                  = ProductAttrMaster::find($PK_NO);
            $productAttrMaster->NAME            = $request->name;
            $productAttrMaster->TITLE           = $request->title;
            $productAttrMaster->SLUG            = Str::slug(strtolower($request->name));
            $productAttrMaster->IS_REQUIRED     = $request->is_required;
            $productAttrMaster->IS_ACTIVE       = $request->is_active;
            $productAttrMaster->ATTRIBUTE_TYPE  = $request->type;
            $productAttrMaster->update();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, 'Unable to update Product attribute !', 'admin.product-attr-master.index');
        }
        DB::commit();
        return $this->formatResponse(true, 'Product attribute has been Updated successfully', 'admin.product-attr-master.index');
    }

    public function getMasterDelete(int $PK_NO)
    {
        DB::beginTransaction();
        try {

            // DB::table('PRD_MASTER_ATTRIBUTE_RELATIONS')->where('F_ATTRIBUTE_MASTER',$PK_NO)->delete();
            // DB::table('PRD_ATTRIBUTE_RELATIONS')->where('F_ATTRIBUTE_NO',$PK_NO)->delete();
            // ProductAttrChild::where('F_ATTRIBUTE_MASTER',$PK_NO)->delete();
            $attribute = ProductAttrMaster::find($PK_NO);
            $attribute->IS_ACTIVE = 0;
            $attribute->update();
            //->delete();


        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, 'Unable to delete Product attribute !', 'admin.product-attr-master.index');
        }
        DB::commit();
        return $this->formatResponse(true,'Successfully deleted product model','admin.product-attr-master.index');
    }

    public function postChildAddUpdate($request)
    {
        DB::beginTransaction();
        try {
            $data = null;
            if ($request->type == 'add') {
                $check = ProductAttrChild::select('VALUE','F_ATTRIBUTE_MASTER')->where('VALUE',$request->value)->where('F_ATTRIBUTE_MASTER',$request->parent)->first();
                if (isset($check) || !empty($check)) {
                    return $this->formatResponse(false, 'Duplicate value !', 'admin.product-attr-master.index');
                }
                $productAttrChild                   = new ProductAttrChild();
                $productAttrChild->NAME             = $request->parent_name;
                $productAttrChild->VALUE            = $request->value;
                $productAttrChild->F_ATTRIBUTE_MASTER = $request->parent;
                $productAttrChild->save();
                $msg = 'Successfully added product attribute !';
                $pk_no = $productAttrChild->PK_NO;
                $data['value'] = $request->value;
                $data['pk_no'] = $pk_no;
                $data['html']  = view('admin.product-attr.append_child_new_value')->withData($data)->render();
            }elseif($request->type == 'update'){
                $check = ProductAttrChild::where('VALUE',$request->value)->where('F_ATTRIBUTE_MASTER',$request->parent)->where('PK_NO','!=',$request->pk_no)->count();
                if ($check > 0) {
                    return $this->formatResponse(false, 'Duplicate value !', 'admin.product-attr-master.index');
                }
                $productAttrChild                   = ProductAttrChild::find($request->pk_no);
                $productAttrChild->VALUE            = $request->value;
                $productAttrChild->F_ATTRIBUTE_MASTER = $request->parent;
                $productAttrChild->update();
                $msg = 'Successfully updated product attribute !';
            }elseif($request->type == 'is_active'){
                $productAttrChild                   = ProductAttrChild::find($request->pk_no);
                $productAttrChild->IS_ACTIVE        = $request->value;
                $productAttrChild->update();
                $msg = 'Successfully updated product attribute !';
            }else{
                ProductAttrChild::where('PK_NO',$request->pk_no)->delete();
                $msg = 'Successfully deleted product attribute !';
            }
        } catch (\Exception $e) {
            DB::rollback();
            // dd($e);
            return $this->formatResponse(false, 'Unable to perform action !', 'admin.product-attr-master.index');
        }
        DB::commit();
        return $this->formatResponse(true,$msg,'admin.product-attr-master.index',$data);
    }

    public function getList($request)
    {
        return DB::table('admin.product-Model')->pluck('name', 'PK_NO');
    }
}
