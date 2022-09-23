<?php
namespace App\Repositories\Admin\Coupon;
use DB;
use App\Models\Coupon;
use App\Models\CouponChild;
use App\Models\CouponMaster;
use App\Models\OfferPrimary;
use App\Traits\RepoResponse;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\File;

class CouponAbstract implements CouponInterface
{
    use RepoResponse;

    protected $offerPrimary;

    public function __construct(OfferPrimary $offerPrimary)
    {
        $this->offerPrimary = $offerPrimary;
    }

    public function getPaginatedList($request, int $per_page = 5)
    {
        $data = DB::table('SLS_COUPON_MASTER')->get();
        //dd($data);
        return $this->formatResponse(true, 'Data Found', 'admin.coupon.list', $data);
    }

    public function postStore($request)
    {
        DB::beginTransaction();
        try {
            $check = DB::table('SLS_COUPON_MASTER')->where('COUPON_CODE',$request->coupon_code)->count();
            if ($check > 0) {
                return $this->formatResponse(false, 'Duplicate coupon code !', 'admin.coupon.list');
            }
            $master                 = new CouponMaster();
            $master->COUPON_CODE    = str_replace(' ', '', $request->coupon_code);
            $master->COUPON_ON      = $request->coupon_for;
            if($request->store_no){
                $shop =  DB::table('SA_USER')->where('SHOP_ID',$request->store_no)->first();
                $master->F_SHOP_NO      = $request->store_no;
                $master->SHOP_NAME      = $shop->SHOP_NAME;
            }
            $master->ORDER_MIN_VALUE = $request->order_min_value;
            $master->IS_ACTIVE      = $request->is_active;
            $master->COUPON_TYPE    = $request->coupon_type;
            $master->DISCOUNT       = (int)$request->discount;
            $master->VALIDITY_FROM  = $request->validity_from ? date('Y-m-d',strtotime($request->validity_from)) : null;;
            $master->VALIDITY_TO    = $request->validity_to ? date('Y-m-d',strtotime($request->validity_to)) : null;;
            if($request->file('image')){
                $path1      = 'media/images/coupon';
                if (!file_exists($path1)) {
                    mkdir($path1, 0755, true);
                }
                $image = $request->file('image');
                $file_name = 'coupon_'. date('dmY'). '_' .uniqid(). '.' . $image->getClientOriginalExtension();
                $master->COUPON_IMAGE     = '/media/images/coupon/'.$file_name;
                $image->move(public_path().'/media/images/coupon/', $file_name);
            }
            $master->save();
            $childs = $request->input_values[0];
            $childs = explode(',',$childs);
            // if ($request->coupon_for == 2) {
            //     $childs = DB::table('PRD_VARIANT_SETUP')->select('PK_NO')->whereIn('F_PRD_MASTER_SETUP_NO',$childs)->where('IS_ACTIVE',1)->get();
            // }
            foreach ($childs as $key => $value) {
                if ($request->coupon_type == 2) {
                    $varinat = DB::table('PRD_VARIANT_SETUP')->select('REGULAR_PRICE')->where('PK_NO',$value)->first();
                    if ($varinat->REGULAR_PRICE <= (int)$request->discount) {
                        return $this->formatResponse(false, 'Discount amount more than product value !', 'admin.coupon.list');
                    }
                }
                $child                  = new CouponChild();
                $child->COUPON_CODE     = str_replace(' ', '', $request->coupon_code);
                $child->F_COUPON_NO     = $master->PK_NO;
                $child->F_PRD_VARIANT_NO = $value;
                $child->DISCOUNT        = (int)$request->discount;
                if($request->store_no){
                    $shop =  DB::table('SA_USER')->where('SHOP_ID',$request->store_no)->first();
                    $master->F_SHOP_NO      = $request->store_no;
                    $master->SHOP_NAME      = $shop->SHOP_NAME;
                }
                $child->IS_ACTIVE       = $request->is_active;
                if (isset($request->to_show) && in_array($value,$request->to_show)) {
                    $child->TO_SHOW     = 1;
                }else{
                    $child->TO_SHOW     = 0;
                }
                $child->save();
            }
        } catch (\Exception $e) {
            // dd($e);
            DB::rollback();
            return $this->formatResponse(false, 'Coupon not created !', 'admin.coupon.list');
        }
        DB::commit();

        return $this->formatResponse(true, 'Coupon has been created successfully !', 'admin.coupon.list');
    }

    public function findOrThrowException(int $id)
    {
        $data['master'] = DB::table('SLS_COUPON_MASTER')->where('PK_NO',$id)->first();

        $data['child'] = DB::table('SLS_COUPON_CHILD')->join('PRD_VARIANT_SETUP','PRD_VARIANT_SETUP.PK_NO','SLS_COUPON_CHILD.F_PRD_VARIANT_NO')->select('PRD_VARIANT_SETUP.PK_NO','PRD_VARIANT_SETUP.VARIANT_NAME','PRD_VARIANT_SETUP.THUMB_PATH','PRD_VARIANT_SETUP.F_PRD_MASTER_SETUP_NO','SLS_COUPON_CHILD.F_PRD_VARIANT_NO','SLS_COUPON_CHILD.TO_SHOW')->where('F_COUPON_NO',$id)->orderBy('TO_SHOW','DESC')->get();

        if (!empty($data['master'])) {
            return $this->formatResponse(true, 'Data found', 'admin.coupon.edit', $data);
        }
        return $this->formatResponse(false, 'Did not found data !', 'admin.coupon.list', null);
    }

    public function getView($id)
    {
        $data['master'] = DB::table('SLS_COUPON_MASTER')->where('PK_NO',$id)->first();

        $data['child'] = DB::table('SLS_COUPON_CHILD')->join('PRD_VARIANT_SETUP','PRD_VARIANT_SETUP.PK_NO','SLS_COUPON_CHILD.F_PRD_VARIANT_NO')->select('PRD_VARIANT_SETUP.PK_NO','PRD_VARIANT_SETUP.VARIANT_NAME','PRD_VARIANT_SETUP.THUMB_PATH','PRD_VARIANT_SETUP.F_PRD_MASTER_SETUP_NO','SLS_COUPON_CHILD.F_PRD_VARIANT_NO','TO_SHOW')->where('F_COUPON_NO',$id)->orderBy('TO_SHOW','DESC')->get();

        if (!empty($data['master'])) {
            return $this->formatResponse(true, 'Data found', 'admin.coupon.view', $data);
        }
        return $this->formatResponse(false, 'Did not found data !', 'admin.coupon.view', null);
    }

    public function postUpdate($request, $PK_NO)
    {
        DB::beginTransaction();
        try {
            $master                 = CouponMaster::find($PK_NO);
            $master->COUPON_CODE    = str_replace(' ', '', $request->coupon_code);
            $master->COUPON_ON      = $request->coupon_for;
            $master->ORDER_MIN_VALUE = $request->order_min_value;
            if($request->branch_id){
                $shop =  DB::table('SA_USER')->where('SHOP_ID',$request->branch_id)->first();
                $master->F_SHOP_NO      = $request->branch_id;
                $master->SHOP_NAME      = $shop->SHOP_NAME;
            }
            $master->IS_ACTIVE      = $request->is_active;
            $master->COUPON_TYPE    = $request->coupon_type;
            $master->DISCOUNT       = (int)$request->discount;
            $master->VALIDITY_FROM  = $request->validity_from ? date('Y-m-d',strtotime($request->validity_from)) : null;;
            $master->VALIDITY_TO    = $request->validity_to ? date('Y-m-d',strtotime($request->validity_to)) : null;;
            if($request->file('image')){
                $path1      = 'media/images/coupon';
                if (!file_exists($path1)) {
                    mkdir($path1, 0755, true);
                }
                if (File::exists(public_path($master->COUPON_IMAGE))) {
                    File::delete(public_path($master->COUPON_IMAGE));
                }
                $image = $request->file('image');
                $file_name = 'coupon_'. date('dmY'). '_' .uniqid(). '.' . $image->getClientOriginalExtension();
                $master->COUPON_IMAGE     = '/media/images/coupon/'.$file_name;
                $image->move(public_path().'/media/images/coupon/', $file_name);
            }
            $master->update();
            DB::table('SLS_COUPON_CHILD')->where('F_COUPON_NO',$PK_NO)->delete();
            $childs = $request->input_values[0];
            $childs = explode(',',$childs);
            foreach ($childs as $key => $value) {
                if ($request->coupon_type == 2) {
                    $varinat = DB::table('PRD_VARIANT_SETUP')->select('REGULAR_PRICE')->where('PK_NO',$value)->first();

                    if ($varinat->REGULAR_PRICE <= (int)$request->discount) {
                            return $this->formatResponse(false, 'Discount amount more than product value !', 'admin.coupon.list');
                    }
                }
                $child                  = new CouponChild();
                $child->COUPON_CODE     = str_replace(' ', '', $request->coupon_code);
                $child->F_COUPON_NO     = $master->PK_NO;
                $child->F_PRD_VARIANT_NO= $value;
                $child->DISCOUNT        = (int)$request->discount;
                if($request->store_no){
                    $shop =  DB::table('SA_USER')->where('SHOP_ID',$request->store_no)->first();
                    $master->F_SHOP_NO      = $request->store_no;
                    $master->SHOP_NAME      = $shop->SHOP_NAME;
                }
                $child->IS_ACTIVE       = $request->is_active;
                if (isset($request->to_show) && in_array($value,$request->to_show)) {
                    $child->TO_SHOW     = 1;
                }else{
                    $child->TO_SHOW     = 0;
                }
                $child->save();
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return $this->formatResponse(false, 'Coupon update unsuccessfull !', 'admin.coupon.list');
        }
        DB::commit();
        return $this->formatResponse(true, 'Coupon has been updated successfully !', 'admin.coupon.list');
    }

    public function delete($PK_NO)
    {
        DB::beginTransaction();
        try {
            DB::table('SLS_COUPON_CHILD')->where('F_COUPON_NO',$PK_NO)->delete();
            DB::table('SLS_COUPON_MASTER')->where('PK_NO',$PK_NO)->delete();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, 'Can not delete coupon !', 'admin.offer_primary.list');
        }
        DB::commit();
        return $this->formatResponse(true,'Coupon deleted successfully !','admin.account.list');
    }
    public function getVariantList($request){

            $products = ProductVariant::whereIn('PK_NO', $request->product_no)->get();
            // return  $products;
            $data = view('admin.offer_primary._product_list')->withRows($products)->render();
            return $this->formatResponse(true, 'Data found', 'admin.offer_primary.list', $data);


    }

    public function postStoreProduct($request)
    {
        DB::beginTransaction();
        try {
            if(isset($request->variant_no ) && (count($request->variant_no) > 0 )){
                foreach($request->variant_no as $key => $variant_no){
                    $offer                                  = new OfferPrimaryDetails();
                    $offer->F_SLS_BUNDLE_PRIMARY_SET_NO     = $request->master_pk_no;
                    $offer->F_PRD_VARIANT_NO                = $variant_no;
                    $offer->PRD_VARIANT_NAME                = $request->variant_name[$key];
                    $offer->SKUID                           = $request->variant_skuid[$key];
                    $offer->save();
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, 'Primary list product not created successfully !', 'admin.offer_primary.list');
        }
        DB::commit();
        return $this->formatResponse(true, 'Primary list product has been created successfully !', 'admin.offer_primary.list');
    }

    public function getDeleteProduct($id)
    {
        DB::beginTransaction();
        try {
            OfferPrimaryDetails::where('PK_NO',$id)->delete($id);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, 'Primary list product not deleted successfully !', 'admin.offer_primary.list');
        }
        DB::commit();
        return $this->formatResponse(true, 'Primary list product has been deleted successfully !', 'admin.offer_primary.list');
    }

    public function postCouponSearch($request)
    {
        DB::beginTransaction();
        try {
            if ($request->coupon_for == 1) {
                $query = DB::table('PRD_VARIANT_SETUP')->select('PK_NO','VARIANT_NAME AS NAME','THUMB_PATH AS IMAGE_PATH','F_PRD_MASTER_SETUP_NO AS MASTER_NO',DB::raw('(SELECT 1) AS IS_PRODUCT'));
                if($request->value != ''){
                    $pieces = explode(" ", $request->value);
                    if($pieces){
                        foreach ($pieces as $key => $piece) {
                            $query = $query->Where('VARIANT_NAME', 'LIKE', '%' . $piece . '%');
                        }
                    }
                }
            }else{
                $query = DB::table('PRD_MASTER_SETUP')->select('PK_NO AS MASTER_NO','DEFAULT_NAME AS NAME','PRIMARY_IMG_RELATIVE_PATH AS IMAGE_PATH',DB::raw('(SELECT 0) AS IS_PRODUCT'));
                if($request->value != ''){
                    $pieces = explode(" ", $request->value);
                    if($pieces){
                        foreach ($pieces as $key => $piece) {
                            $query = $query->Where('DEFAULT_NAME', 'LIKE', '%' . $piece . '%');
                        }
                    }
                }
            }
            $query = $query->where('IS_ACTIVE',1)->get();
            if (!isset($query) || empty($query)) {
                return $this->formatResponse(false, 'Product not found !', 'admin.coupon.list');
            }
            $html = [];
            foreach ($query as $key => $value) {
                array_push($html,array($value->IS_PRODUCT == 1 ? $value->PK_NO : $value->MASTER_NO,$value->IMAGE_PATH,$value->NAME,$value->IS_PRODUCT == 1 ? route('admin.product.searchlist.view',[$value->MASTER_NO,'variant_id'=>$value->PK_NO,'type'=>'variant','tab'=>2]) : route('admin.product.view',$value->MASTER_NO)));
            }
            $data['html'] = $html;
            $data['count'] = $query->count();
        } catch (\Exception $e) {
            // dd($e);
            DB::rollback();
            return $this->formatResponse(false, 'Product not found !', 'admin.coupon.list');
        }
        DB::commit();
        return $this->formatResponse(true, 'Product found !', 'admin.coupon.list',$data);
    }

    public function postCouponMasterVariant($request)
    {
        DB::beginTransaction();
        try {
            $query = DB::table('PRD_VARIANT_SETUP')->select('PK_NO','VARIANT_NAME AS NAME','THUMB_PATH AS IMAGE_PATH','F_PRD_MASTER_SETUP_NO AS MASTER_NO')->where('IS_ACTIVE',1)->whereIn('F_PRD_MASTER_SETUP_NO',$request->master_pks)->get();
            if (!isset($query) || empty($query)) {
                return $this->formatResponse(false, 'Product not found !', 'admin.coupon.list');
            }
            $html = [];
            foreach ($query as $key => $value) {
                array_push($html,array($value->PK_NO,$value->IMAGE_PATH,$value->NAME,route('admin.product.searchlist.view',[$value->MASTER_NO,'variant_id'=>$value->PK_NO,'type'=>'variant','tab'=>2])));
            }
            $data['html'] = $html;
            $data['count'] = $query->count();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, 'Product not found !', 'admin.coupon.list');
        }
        DB::commit();
        return $this->formatResponse(true, 'Product found !', 'admin.coupon.list',$data);
    }
}
