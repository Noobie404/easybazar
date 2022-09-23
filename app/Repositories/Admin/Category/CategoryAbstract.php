<?php
namespace App\Repositories\Admin\Category;
use DB;
use Str;
use Auth;
use File;
use Image;
use App\User;
use App\Models\Category;
use App\Models\SubCategory;
use App\Traits\RepoResponse;
use App\Models\Web\SliderPhoto;
use App\Models\ProductAttrRelation;
use App\Models\ProductFeatureRelation;

class CategoryAbstract implements CategoryInterface
{
    use RepoResponse;
    protected $category;
    protected $subcategory;

    public function __construct(Category $category, SubCategory $subcategory)
    {
        $this->category     = $category;
        $this->subcategory  = $subcategory;
    }

    public function getPaginatedList($request, int $per_page = 20)
    {

        DB::beginTransaction();
        try {
        // PRD_SHOP_CATEGORY_MAP
        if(Auth::user()->USER_TYPE == 10){
            $shop_id = Auth::user()->SHOP_ID;
        }else{
            $shop_id = $request->shop;
        }
        $response['shop'] = null;
        if($shop_id){
            $response['shop'] = User::find($shop_id);
        }
        $category = [];
        $data = DB::table('PRD_CATEGORY')->select('PRD_CATEGORY.PK_NO','PRD_CATEGORY.ORDER_ID','PRD_CATEGORY.NAME','PRD_CATEGORY.BN_NAME','PRD_CATEGORY.PARENT_ID','PRD_CATEGORY.IS_ACTIVE','PRD_CATEGORY.ORDER_ID', 'PRD_CATEGORY.META_TITLE', 'PRD_SHOP_CATEGORY_MAP.F_SHOP_NO', 'PRD_SHOP_CATEGORY_MAP.ORDER_ID as CATEGORY_ORDER_ID','PRD_CATEGORY.TOTAL_VARIANT','PRD_CATEGORY.ICON')
        ->leftJoin('PRD_SHOP_CATEGORY_MAP', function($join) use ($shop_id)
        {
            $join->on('PRD_CATEGORY.PK_NO', '=', 'PRD_SHOP_CATEGORY_MAP.F_CATEGORY_NO');
            $join->where('PRD_SHOP_CATEGORY_MAP.F_SHOP_NO', '=', $shop_id);
        });
        if($shop_id){
            $data =  $data->orderBy('PRD_SHOP_CATEGORY_MAP.ORDER_ID','DESC');
        }else{
            $data =  $data->orderBy('PRD_CATEGORY.ORDER_ID','ASC');
        }
        if(!empty($request->is_active) && $request->is_active==2){
            $data->where('PRD_CATEGORY.IS_ACTIVE', '=' , 2);
        }
        else{
            $data->where('PRD_CATEGORY.IS_ACTIVE', '!=' , 2)->whereNull('PRD_CATEGORY.DELETED_AT')->where('PRD_CATEGORY.PARENT_ID', 0);
        }
        $categories = $data->get();
        foreach ($categories as $key => $category) {
            $subcategory = DB::table('PRD_CATEGORY')
            ->select('PRD_CATEGORY.PK_NO as SUBCATEGORY_ID','PRD_CATEGORY.NAME as SUBCATEGORY_NAME','PRD_CATEGORY.BN_NAME','PRD_CATEGORY.PARENT_ID','PRD_CATEGORY.IS_ACTIVE','PRD_SHOP_CATEGORY_MAP.F_SHOP_NO', 'PRD_SHOP_CATEGORY_MAP.ORDER_ID as SUB_CATEGORY_ORDER_ID','PRD_CATEGORY.TOTAL_VARIANT','PRD_CATEGORY.ORDER_ID')
            ->leftJoin('PRD_SHOP_CATEGORY_MAP', function($join) use ($shop_id)
            {
                $join->on('PRD_CATEGORY.PK_NO', '=', 'PRD_SHOP_CATEGORY_MAP.F_CATEGORY_NO');
                $join->where('PRD_SHOP_CATEGORY_MAP.F_SHOP_NO', '=', $shop_id);
            });
            if($shop_id){
                $subcategory =  $subcategory->orderBy('PRD_SHOP_CATEGORY_MAP.ORDER_ID','DESC');
            }else{
                $subcategory =  $subcategory->orderBy('PRD_CATEGORY.ORDER_ID','ASC');
            }
            $subcategory = $subcategory->where('PRD_CATEGORY.PARENT_ID', $category->PK_NO);
            if(!empty($request->is_active) && $request->is_active==2){
                $subcategory->where('PRD_CATEGORY.IS_ACTIVE', '=' , 2);
            }
            else{
                $subcategory->where('PRD_CATEGORY.IS_ACTIVE', '!=' , 2)->whereNull('PRD_CATEGORY.DELETED_AT');
            }
            $subcategory = $subcategory->get();
            $category->subcategories = $subcategory;
            foreach ($subcategory as $key => $value) {
                $subsubcategory = DB::table('PRD_CATEGORY')
                ->select('PRD_CATEGORY.PK_NO AS SUBSUBCATEGORY_ID','PRD_CATEGORY.NAME as SUBSUBCATEGORY_NAME','PRD_CATEGORY.BN_NAME','PRD_CATEGORY.PARENT_ID','PRD_CATEGORY.IS_ACTIVE','PRD_SHOP_CATEGORY_MAP.F_SHOP_NO', 'PRD_SHOP_CATEGORY_MAP.ORDER_ID as SUB_SUB_CATEGORY_ORDER_ID','PRD_CATEGORY.TOTAL_VARIANT','PRD_CATEGORY.ORDER_ID')
                ->leftJoin('PRD_SHOP_CATEGORY_MAP', function($join) use ($shop_id)
                {
                    $join->on('PRD_CATEGORY.PK_NO', '=', 'PRD_SHOP_CATEGORY_MAP.F_CATEGORY_NO');
                    $join->where('PRD_SHOP_CATEGORY_MAP.F_SHOP_NO', '=', $shop_id);
                });
                if($shop_id){
                    $subsubcategory =  $subsubcategory->orderBy('PRD_SHOP_CATEGORY_MAP.ORDER_ID','DESC');
                }else{
                    $subsubcategory =  $subsubcategory->orderBy('PRD_CATEGORY.ORDER_ID','ASC');
                }
                $subsubcategory = $subsubcategory->where('PRD_CATEGORY.PARENT_ID', $value->SUBCATEGORY_ID);
                if(!empty($request->is_active) && $request->is_active==2){
                    $subsubcategory->where('PRD_CATEGORY.IS_ACTIVE', '=' , 2);
                }
                else{
                    $subsubcategory->where('PRD_CATEGORY.IS_ACTIVE', '!=' , 2)->whereNull('PRD_CATEGORY.DELETED_AT');
                }
                $subsubcategory = $subsubcategory->get();
                $value->subsubcategory = $subsubcategory;
            }
        }
        $response['data'] = $categories;
    } catch (\Exception $e) {
        dd($e->getMessage());
        DB::rollback();
        return $this->formatResponse(false, $e->getMessage(), 'product.category.list');
    }
    DB::commit();
    return $this->formatResponse(true, '', 'product.category.list', $response);
    }


    public function getPaginatedListStore($request, int $per_page = 20)
    {
        if ($request->category == 'all') {
            $data = DB::table('PRD_CATEGORY')->select('PK_NO','NAME','BN_NAME','PARENT_ID','IS_ACTIVE','ORDER_ID', 'META_TITLE')->where('IS_ACTIVE',1)->where('PARENT_ID', 0)->orderBy('ORDER_ID','ASC')->get();
        }else{
            $data = DB::table('PRD_CATEGORY')->join('PRD_SHOP_CATEGORY_MAP','PRD_SHOP_CATEGORY_MAP.F_CATEGORY_NO','PRD_CATEGORY.PK_NO')->select('PRD_CATEGORY.PK_NO','NAME','BN_NAME','PRD_CATEGORY.PARENT_ID','IS_ACTIVE','ORDER_ID', 'META_TITLE')->where('IS_ACTIVE',1)->where('PRD_SHOP_CATEGORY_MAP.PARENT_ID', 0)->where('PRD_SHOP_CATEGORY_MAP.F_SHOP_NO', Auth::user()->SHOP_ID)->orderBy('ORDER_ID','DESC')->get();
        }
        foreach ($data as $key => $category) {
            $subcategory = DB::table('PRD_CATEGORY')->select('PRD_CATEGORY.PK_NO as SUBCATEGORY_ID','NAME as SUBCATEGORY_NAME','BN_NAME','PRD_CATEGORY.PARENT_ID','IS_ACTIVE','PRD_SHOP_CATEGORY_MAP.F_SHOP_NO');
            if($request->category == 'all'){
                $subcategory = $subcategory->leftJoin('PRD_SHOP_CATEGORY_MAP', function($join)
                {
                    $join->on('PRD_CATEGORY.PK_NO', '=', 'PRD_SHOP_CATEGORY_MAP.F_CATEGORY_NO');
                    $join->where('PRD_SHOP_CATEGORY_MAP.F_SHOP_NO', '=', Auth::user()->SHOP_ID);
                });
            }else{
                $subcategory = $subcategory->join('PRD_SHOP_CATEGORY_MAP', function($join)
                {
                    $join->on('PRD_CATEGORY.PK_NO', '=', 'PRD_SHOP_CATEGORY_MAP.F_CATEGORY_NO');
                    $join->where('PRD_SHOP_CATEGORY_MAP.F_SHOP_NO', '=', Auth::user()->SHOP_ID);
                });
            }
            $subcategory = $subcategory->where('IS_ACTIVE',1)->where('PRD_CATEGORY.PARENT_ID', $category->PK_NO)->orderBy('ORDER_ID','DESC')->get();
            $category->subcategories = $subcategory;
            foreach ($subcategory as $key => $value) {
                $value->subsubcategory = DB::table('PRD_CATEGORY')->select('PRD_CATEGORY.PK_NO AS SUBCATEGORY_ID','NAME as SUBSUBCATEGORY_NAME','BN_NAME','PRD_CATEGORY.PARENT_ID','IS_ACTIVE','PRD_SHOP_CATEGORY_MAP.F_SHOP_NO');
                if($request->category == 'all'){
                    $value->subsubcategory = $value->subsubcategory->leftJoin('PRD_SHOP_CATEGORY_MAP', function($join)
                    {
                        $join->on('PRD_CATEGORY.PK_NO', '=', 'PRD_SHOP_CATEGORY_MAP.F_CATEGORY_NO');
                        $join->where('PRD_SHOP_CATEGORY_MAP.F_SHOP_NO', '=', Auth::user()->SHOP_ID);
                    });
                }else{
                    $value->subsubcategory = $value->subsubcategory->join('PRD_SHOP_CATEGORY_MAP', function($join)
                    {
                        $join->on('PRD_CATEGORY.PK_NO', '=', 'PRD_SHOP_CATEGORY_MAP.F_CATEGORY_NO');
                        $join->where('PRD_SHOP_CATEGORY_MAP.F_SHOP_NO', '=', Auth::user()->SHOP_ID);
                    });
                }
                $value->subsubcategory = $value->subsubcategory->where('IS_ACTIVE',1)->where('PRD_CATEGORY.PARENT_ID', $value->SUBCATEGORY_ID)->orderBy('ORDER_ID','DESC')->get();
                foreach ($value->subsubcategory as $key2 => $value2) {
                    $value2->subsubcategory2 = DB::table('PRD_CATEGORY')->select('PRD_CATEGORY.PK_NO AS SUBCATEGORY_ID2','NAME as SUBSUBCATEGORY_NAME2','BN_NAME','PRD_CATEGORY.PARENT_ID','IS_ACTIVE','PRD_SHOP_CATEGORY_MAP.F_SHOP_NO');
                    if($request->category == 'all'){
                        $value2->subsubcategory2 = $value2->subsubcategory2->leftJoin('PRD_SHOP_CATEGORY_MAP', function($join)
                        {
                            $join->on('PRD_CATEGORY.PK_NO', '=', 'PRD_SHOP_CATEGORY_MAP.F_CATEGORY_NO');
                            $join->where('PRD_SHOP_CATEGORY_MAP.F_SHOP_NO', '=', Auth::user()->SHOP_ID);
                        });
                    }else{
                        $value2->subsubcategory2 = $value2->subsubcategory2->join('PRD_SHOP_CATEGORY_MAP', function($join)
                        {
                            $join->on('PRD_CATEGORY.PK_NO', '=', 'PRD_SHOP_CATEGORY_MAP.F_CATEGORY_NO');
                            $join->where('PRD_SHOP_CATEGORY_MAP.F_SHOP_NO', '=', Auth::user()->SHOP_ID);
                        });
                    }
                    $value2->subsubcategory2 = $value2->subsubcategory2->where('IS_ACTIVE',1)->where('PRD_CATEGORY.PARENT_ID', $value2->SUBCATEGORY_ID)->orderBy('ORDER_ID','DESC')->get();
                }
            }
        }
        // if ($data) {
        //     foreach ($data as $key => $value) {
        //        $value->allHScodes = $this->getAllHScodes($value->PK_NO);
        //     }
        // }
        return $this->formatResponse(true, '', 'product.category.list', $data);
    }

    public function getCategoryList($request,$id=null){
        $categories = DB::table('PRD_CATEGORY')->select('PK_NO','NAME','PARENT_ID','IS_ACTIVE')->where('PARENT_ID', 0)->orderBy('ORDER_ID','ASC')->get();
        foreach ($categories as $key => $category) {
            $subcategory = DB::table('PRD_CATEGORY')->select('PK_NO as SUBCATEGORY_ID','NAME as SUBCATEGORY_NAME','PARENT_ID','IS_ACTIVE')->where('PARENT_ID', $category->PK_NO)->orderBy('ORDER_ID','DESC')->get();
            $category->subcategories = $subcategory;
            foreach ($subcategory as $key => $value) {
                $value->subsubcategory = DB::table('PRD_CATEGORY')->select('PK_NO AS SUBCATEGORY_ID','NAME as SUBSUBCATEGORY_NAME','PARENT_ID','IS_ACTIVE')->where('PARENT_ID', $value->SUBCATEGORY_ID)->orderBy('ORDER_ID','DESC')->get();
                // foreach ($value->subsubcategory as $key2 => $value2) {
                //     $value2->subsubcategory2 = DB::table('PRD_CATEGORY')->select('PK_NO AS SUBCATEGORY_ID2','NAME as SUBSUBCATEGORY_NAME2','PARENT_ID','IS_ACTIVE')->where('PARENT_ID', $value2->SUBCATEGORY_ID)->orderBy('ORDER_ID','DESC')->get();
                // }
            }
        }
          return $categories;
    }

    public function postStore($request)
    {

        DB::beginTransaction();
        try {
            $category                           = new Category();
            $category->NAME                     = $request->name;
            $category->BN_NAME                  = $request->bn_name;
            // $category->CODE                     = $request->code;
            if(!empty($request->url_slug)){
                $category->URL_SLUG             = Str::slug(strtolower($request->url_slug));
            }
            else {
                $category->URL_SLUG             = Str::slug(strtolower($request->name));
            }
            $category->ORDER_ID                 = $request->order_id;
            $category->PARENT_ID                = $request->parent_id;
            $category->HS_PREFIX                = $request->hs_prefix;
            if(!is_null($request->file('thumbnail_image')))
            {
                $category->THUMBNAIL_PATH       = $this->uploadImage($request->thumbnail_image);
            }
            if(!is_null($request->file('banner_image')))
            {
                $category->BANNER_PATH          = $this->uploadImage($request->banner_image);
            }
            if(!is_null($request->file('icon')))
            {
                $category->ICON                 = $this->uploadImage($request->icon);
            }
            $category->ORDER_ID                 = Category::max('ORDER_ID')+1;
            $category->COMMENTS                 = $request->comment;
            $category->IS_FEATURE               = $request->is_feature;
            $category->IS_POPULAR               = $request->is_popular;
            $category->META_TITLE               = $request->meta_title;
            $category->META_KEYWARDS            = $request->meta_keywards;
            $category->META_DESCRIPTION         = $request->meta_description;
            $category->IS_ACTIVE                = $request->is_active;
            $category->save();
            if (isset($request->input_tags) && !empty($request->input_tags)) {
                $tags = explode(',',$request->input_tags);
                $tags_array = array();
                foreach ($tags as $key => $value) {
                    array_push($tags_array,array('F_ATTRIBUTE_NO'=> $value, 'F_CATEGORY_NO'=> $category->PK_NO,'TYPE' => 1,'SS_CREATED_ON'=>date('Y-m-d H:i:s'), 'F_SS_CREATED_BY' => Auth::user()->PK_NO));
                }
                ProductAttrRelation::insert($tags_array);
            }
            if (isset($request->feature_input_tags) && !empty($request->feature_input_tags)) {
                $tags = explode(',',$request->feature_input_tags);
                $tags_array = array();
                foreach ($tags as $key => $value) {
                    array_push($tags_array,array('F_FEATURE_NO'=> $value, 'F_CATEGORY_NO'=> $category->PK_NO,'TYPE' => 1,'SS_CREATED_ON'=>date('Y-m-d H:i:s'), 'F_SS_CREATED_BY' => Auth::user()->PK_NO));
                }
                ProductFeatureRelation::insert($tags_array);
            }
            if(!is_null($request->file('images'))){
                $count = count($request->file('images'));
                for($i=0; $i<$count; $i++)
                {
                  if(!empty($request->file('images')[$i])){
                    $image                           = $request->file('images')[$i];
                    $mobile_path                     = $request->file('mobile_image')[$i] ?? NULL;
                    $caption                         = $request->caption[$i] ?? NULL;
                    $custom_link                     = $request->custom_link[$i] ?? NULL;
                    $slider_photo                    = new SliderPhoto();
                    $slider_photo->F_PRD_CATEGORY_ID = $category->PK_NO;
                    $slider_photo->CUSTOM_LINK       = $custom_link;
                    $slider_photo->CAPTION           = $caption;
                    $slider_photo->RELATIVE_PATH     = $this->uploadImage($image);
                    $slider_photo->save();
                  }
                }
             }
            //  $category_up = Category::find($category->PK_NO);
            //  $category_up->BANNER_PATH =
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), 'product.category.list');
        }
        DB::commit();
        return $this->formatResponse(true, 'Category has been created successfully !', 'product.category.list');
    }


    public function uploadImage($image)
    {
      if($image)
      {
        $path1      = 'public/media/images/slider';
        $img        = Image::make($image->getRealPath());
        if (!file_exists($path1)) {
            mkdir($path1, 0755, true);
        }
        $base_name  = preg_replace('/\..+$/', '', $image->getClientOriginalName());
        $base_name  = explode(' ', $base_name);
        $base_name  = implode('-', $base_name);
        $image_name = $base_name."-".uniqid().'.webp';
        Image::make($img)->save($path1.'/'.$image_name);
          $imageUrl1 = '/'.$path1 .'/'. $image_name;
      }
      return $imageUrl1;
    }

    public function findOrThrowException($id)
    {
        $data = $this->category->where('PK_NO', '=', $id)->first();

        if (!empty($data)) {
            return $this->formatResponse(true, '', 'admin.category.edit', $data);
        }
        return $this->formatResponse(false, 'Did not found data !', 'admin.category.list', null);
    }

    public function postUpdate($request, $id)
    {
        DB::beginTransaction();
        try {
            if($request->shop_id){
                DB::table('PRD_SHOP_CATEGORY_MAP')->where('F_SHOP_NO',$request->shop_id)->where('F_CATEGORY_NO',$id)->update([
                    'ORDER_ID'      => $request->order_id,
                    'IS_FEATURE'    => $request->is_feature,
                    'IS_POPULAR'    => $request->is_popular,
                ]);
            }else{
            $category = Category::find($id);
            $category->NAME                     = $request->name;
            $category->BN_NAME                  = $request->bn_name;
            if(!empty($request->url_slug)){
                $category->URL_SLUG             = Str::slug(strtolower($request->url_slug));
            }
            else {
                $category->URL_SLUG             = Str::slug(strtolower($request->name));
            }
            $category->HS_PREFIX                = $request->hs_prefix;
            if(!is_null($request->file('thumbnail_image')))
            {
                if (File::exists(public_path($category->THUMBNAIL_PATH))) {
                    File::delete(public_path($category->THUMBNAIL_PATH));
                }
                $category->THUMBNAIL_PATH       = $this->uploadImage($request->thumbnail_image);
            }
            if(!is_null($request->file('banner_image')))
            {
                if (File::exists(public_path($category->BANNER_PATH))) {
                    File::delete(public_path($category->BANNER_PATH));
                }
                $category->BANNER_PATH          = $this->uploadImage($request->banner_image);
            }
            if(!is_null($request->file('icon')))
            {
                if (File::exists(public_path($category->ICON))) {
                    File::delete(public_path($category->ICON));
                }
                $category->ICON                 = $this->uploadImage($request->icon);
            }
           // $category->ORDER_ID                 = Category::max('ORDER_ID')+1;
            $category->PARENT_ID                = $request->parent_id;
            $category->ORDER_ID                 = $request->order_id;
            $category->COMMENTS                 = $request->comment;
            $category->IS_FEATURE               = $request->is_feature;
            $category->IS_POPULAR               = $request->is_popular;
            $category->META_TITLE               = $request->meta_title;
            $category->META_KEYWARDS            = $request->meta_keywards;
            $category->META_DESCRIPTION         = $request->meta_description;
            $category->IS_ACTIVE                = $request->is_active;
            $category->update();

            ProductAttrRelation::where('F_CATEGORY_NO',$id)->delete();
            if (isset($request->input_tags) && !empty($request->input_tags)) {
                $tags = explode(',',$request->input_tags);
                $tags_array = array();
                foreach ($tags as $key => $value) {
                    array_push($tags_array,array('F_ATTRIBUTE_NO'=> $value, 'F_CATEGORY_NO'=> $category->PK_NO,'TYPE' => 1,'SS_CREATED_ON'=>date('Y-m-d H:i:s'), 'F_SS_CREATED_BY' => Auth::user()->PK_NO));
                }
                ProductAttrRelation::insert($tags_array);
            }
            ProductFeatureRelation::where('F_CATEGORY_NO',$id)->delete();
            if (isset($request->feature_input_tags) && !empty($request->feature_input_tags)) {
                $tags = explode(',',$request->feature_input_tags);
                $tags_array = array();
                foreach ($tags as $key => $value) {
                    array_push($tags_array,array('F_FEATURE_NO'=> $value, 'F_CATEGORY_NO'=> $category->PK_NO,'TYPE' => 1,'SS_CREATED_ON'=>date('Y-m-d H:i:s'), 'F_SS_CREATED_BY' => Auth::user()->PK_NO));
                }
                ProductFeatureRelation::insert($tags_array);
            }
            if(!is_null($request->file('images'))){
                $count = count($request->file('images'));
                for($i=0; $i<$count; $i++)
                {
                  if(!empty($request->file('images')[$i])){
                    $image                           = $request->file('images')[$i];
                    $mobile_path                     = $request->file('mobile_image')[$i] ?? NULL;
                    $caption                         = $request->caption[$i] ?? NULL;
                    $custom_link                     = $request->custom_link[$i] ?? NULL;
                    $slider_photo                    = new SliderPhoto();
                    $slider_photo->F_PRD_CATEGORY_ID = $category->PK_NO;
                    $slider_photo->CUSTOM_LINK       = $custom_link;
                    $slider_photo->CAPTION           = $caption;
                    $slider_photo->RELATIVE_PATH     = $this->uploadImage($image);
                    $slider_photo->save();
                  }
                }
            }
        }

        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return $this->formatResponse(false, 'Unable to update Category !', 'product.category.list');
        }
        DB::commit();
        return $this->formatResponse(true, 'Category has been updated successfully !', 'product.category.list');
    }
    public function delete($id)
    {
        DB::begintransaction();
        try {

            $checkChild= DB::table('PRD_CATEGORY')->where('PARENT_ID',$id)->where('IS_ACTIVE',1)->first();
            if(!empty($checkChild)){
                return $this->formatResponse(false, 'Please delete child category first !', 'product.category.list');
            }
            $checkExistProduct = DB::table('PRD_MASTER_CATEGORY_MAP')->where('F_PRD_CATEGORY_ID',$id)->where('IS_ACTIVE',1)->get();
            if(!empty($checkExistProduct)){
                DB::table('PRD_MASTER_CATEGORY_MAP')->where('F_PRD_CATEGORY_ID',$id)->where('IS_ACTIVE',1)->update([
                    'IS_ACTIVE' => 2,
                    'DELETED_AT' => date('Y-m-d H:i:s'),
                    'DELETED_BY' => Auth::user()->PK_NO,
                ]);
            }
            $checkShopCat = DB::table('PRD_SHOP_CATEGORY_MAP')->where('IS_ACTIVE',1)->where('F_CATEGORY_NO',$id)->get();
            if(!empty($checkShopCat)){
                DB::table('PRD_SHOP_CATEGORY_MAP')->where('F_CATEGORY_NO',$id)->where('IS_ACTIVE',1)->update([
                    'IS_ACTIVE' => 2,
                    'DELETED_AT' => date('Y-m-d H:i:s'),
                    'DELETED_BY' => Auth::user()->PK_NO
                ]);
            }
            $category = Category::find($id);
            $category->IS_ACTIVE = 2;
            $category->DELETED_AT = date('Y-m-d H:i:s');
            $category->DELETED_BY = Auth::user()->PK_NO;
            $category->update();
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return $this->formatResponse(false, 'Unable to delete this category !', 'product.category.list');
        }
        DB::commit();
        return $this->formatResponse(true, 'Successfully delete this category !', 'product.category.list');
    }

    public function getAllHScodes($category_id){
        return $this->subcategory->select('hs.CODE as HS_CODE', 'hs.PK_NO as HS_PK_NO', 'hs.NARRATION as HS_NARRATION', 'PRD_SUB_CATEGORY.NAME as SCAT_NAME', 'PRD_SUB_CATEGORY.PK_NO as SCAT_PK_NO'  )->where('F_PRD_CATEGORY_NO', $category_id)->join('PRD_HS_CODE as hs', 'hs.F_PRD_SUB_CATEGORY_NO','=','PRD_SUB_CATEGORY.PK_NO')->get();
    }

    public function getSubcategory($category_id){
       $data = Category::select('PK_NO','NAME')->where('PARENT_ID',$category_id)->get();
        $response = '<option value="">Select category</option>';
           if ($data->count() > 0) {
               foreach ($data as $value) {
                   $response .= '<option value="'.$value->PK_NO.'">'.$value->NAME.'</option>';
               }
           }else{
               $response .= '<option value="">No subcategory found</option>';
           }
       return $response;

    }

}
