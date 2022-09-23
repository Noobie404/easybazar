<?php
namespace App\Repositories\Admin\Product;
use DB;
use Str;
use Auth;
use File;
use Image;
use App\Models\Stock;
use App\Models\Seller;
use App\Models\UserGroup;
use App\Models\ProdImgLib;
use App\Models\ShopMaster;
use App\Models\ShopVariant;
use App\Traits\ApiResponse;
use App\Traits\CommonTrait;
use App\Traits\RepoResponse;
use App\Models\ProductShopMap;
use App\Models\ProductVariant;
use \Statickidz\GoogleTranslate;
use App\Models\AdminUser as User;
use App\Models\Product as Product;
use App\Models\ProductVariantShopMap;
use App\Models\ProductCategoryShopMap;
use App\Models\ProductMasterCategoryMap;
use App\Models\ProductMasterAttrRelation;
use App\Models\ProductVariantSpCategoryMap;
use App\Repositories\Admin\Auth\AuthAbstract;
use App\Traits\StockCheck;

class ProductAbstract implements ProductInterface
{
    use RepoResponse;
    use CommonTrait;
    use ApiResponse;
    use StockCheck;



    protected $user;
    protected $auth;
    protected $product;
    protected $seller;

    public function __construct(User $user, AuthAbstract $auth, Product $product,Seller $seller)
    {
        $this->user = $user;
        $this->auth = $auth;
        $this->seller = $seller;
        $this->product = $product;
    }

    public function getPaginatedList($request, int $per_page = 2000)
    {

        $data = DB::table('PRD_MASTER_SETUP')
        ->select('PRD_MASTER_SETUP.*','PRD_CATEGORY.NAME as CATEGORY_NAME')
        ->where('PRD_MASTER_SETUP.IS_ACTIVE',1)
        ->join('PRD_CATEGORY','PRD_CATEGORY.PK_NO','=','PRD_MASTER_SETUP.F_PRD_CATEGORY_ID')
        ->orderBy('PRD_MASTER_SETUP.DEFAULT_NAME','ASC')->get();
        return $this->formatResponse(true, '', 'admin', $data);
    }



    public function postStore($request)
    {
        $variable_array_list    = $request->variable_array_list ? json_decode($request->variable_array_list,true) : [];
        $features_names         = $request->features_names ? json_decode($request->features_names,true) : [];
        $features_full_names    = $request->features_full_names ? json_decode($request->features_full_names,true) : [];
        $variable_attribures    = $request->variable_attribures ? json_decode($request->variable_attribures,true) : [];
        $checkbox_values        = $request->checkbox_values ? json_decode($request->checkbox_values,true) : [];
        $variable_attribure_pks = $request->variable_attribure_pks ? json_decode($request->variable_attribure_pks,true) : [];
        $variant_combo          = $request->variant_combo ? json_decode($request->variant_combo,true) : [];
        $options = array();

        $brand_name         = null;
        $model_name         = null;
        $default_vat_amount = null;

        $roles = userRolePermissionArray();



        DB::beginTransaction();
        try {
            $slug = Str::slug(strtolower($request->name));
            $check = Product::where('URL_SLUG',$slug)->first();
            if($check){
                $slug = $slug.'-'.rand(1,99);
            }
            $f_color_parent = isset($features_names[0]) && isset($variable_array_list[$features_names[0]]) && $variable_array_list[$features_names[0]]['is_color'] == 1 ? $variable_array_list[$features_names[0]]['attr_pk'] : null;
            $f_size_parent  = isset($features_names[1]) && isset($variable_array_list[$features_names[1]]) && $variable_array_list[$features_names[1]]['is_color'] == 0 ? $variable_array_list[$features_names[1]]['attr_pk'] : (isset($features_names[0]) && isset($variable_array_list[$features_names[0]]) && $variable_array_list[$features_names[0]]['is_color'] == 0 ? $variable_array_list[$features_names[0]]['attr_pk'] : null);

            $f_color_parent_name = isset($f_color_parent) ? $features_full_names[0] : null;
            $f_size_parent_name  = isset($f_color_parent) ? $features_full_names[1] : (isset($f_size_parent) ? $features_full_names[0] : null);

            $prod                                       = new Product();
            $prod->F_PRD_CATEGORY_ID                    = $request->category[0];
            $prod->DEFAULT_NAME                         = $request->name;
            $prod->DEFAULT_NAME_BN                      = $request->bn_name;

            $prod->F_COLOR_PARENT                       = $f_color_parent;
            $prod->F_COLOR_PARENT_NAME                  = $f_color_parent_name;
            $prod->F_SIZE_PARENT                        = $f_size_parent;
            $prod->F_SIZE_PARENT_NAME                   = $f_size_parent_name;
            $prod->DEFAULT_PRICE                        = $request->price[0];
            $prod->DEFAULT_INSTALLMENT_PRICE            = $request->special_price[0];

            $prod->DEFAULT_NARRATION                    = $request->def_narration;
            $prod->SHORT_DESCRIPTION_EN                 = $request->short_description_en;
            $prod->SHORT_DESCRIPTION_BN                 = $request->short_description_bn;
            $prod->LONG_DESCRIPTION_EN                  = $request->long_description_en;
            $prod->LONG_DESCRIPTION_BN                  = $request->long_description_bn;

            $prod->PRIMARY_IMG_RELATIVE_PATH            = null;
            $prod->URL_SLUG                             = $slug;
            $prod->NEW_ARRIVAL                          = $request->new_arrival;
            $prod->IS_FEATURE                           = $request->is_feature;
            $prod->MAX_ORDER                            = $request->max_order;
            $prod->SEARCH_KEYWORD                       = $request->search_keyword;
            $prod->META_TITLE                           = $request->meta_title;
            $prod->META_KEYWARDS                        = $request->meta_keywards;
            $prod->META_DESCRIPTION                     = $request->meta_description;
            if(hasAccessAbility('product_approval', $roles)){
                $prod->IS_ACTIVE = 1;
            }else{
                $prod->IS_ACTIVE = 2;
            }
            $prod->save();
            foreach ($request->category as $cat_key => $category_array) {
                $category_pks = array();
                $selected_cat_array = array();
                $category = DB::table('PRD_CATEGORY')->select('PK_NO','PARENT_ID')->where('PK_NO',$category_array)->first();
                if(isset($category)){
                    for ($i=0; $i < 3; $i++) {
                        if(isset($category)){
                            if($category->PARENT_ID == 0){
                                $subcategory = DB::table('PRD_CATEGORY')->where('IS_ACTIVE',1)->where('PARENT_ID', 0)->count();
                            }else{
                                $subcategory = DB::table('PRD_CATEGORY')->where('IS_ACTIVE',1)->where('PARENT_ID', $category->PARENT_ID)->count();
                            }
                            if (isset($subcategory) && $subcategory > 0) {
                                if($i == 0){
                                    $cat_array_pk = $category_array;
                                    $selected = 1;
                                }else{
                                    $cat_array_pk = $category->PK_NO ?? 0;
                                    $selected = 0;
                                }
                                array_push($category_pks,$cat_array_pk);
                                array_push($selected_cat_array,$selected);
                            }
                            $category = DB::table('PRD_CATEGORY')->select('PARENT_ID','PK_NO')->where('PK_NO',$category->PARENT_ID)->first();
                            if(!isset($category) || empty($category)){ // parent is 0
                                $category = (object)[];
                                $category->PARENT_ID = 0;
                            }
                        }
                    }
                }
                foreach ($category_pks as $key => $value) {
                    if ($value > 0) {
                        $insert_category[] = [
                            'F_PRD_MASTER_SETUP_NO'          => $prod->PK_NO,
                            'F_PRD_CATEGORY_ID'        => $value,
                            'GROUP_ID'              => $cat_key,
                            'IS_SELECTED'           => $selected_cat_array[$key],
                            'SS_CREATED_ON'         => date('Y-m-d H:i:s'),
                            'F_SS_CREATED_BY'       => Auth::user()->PK_NO
                        ];
                    }
                }
            }
            // dd($insert_category);
            if (isset($insert_category)) {
                ProductMasterCategoryMap::insert($insert_category);
            }
            foreach ($variable_attribures as $key => $value) {
                $attrs = 'attr_'.$value;
                $attr_details = DB::table('PRD_ATTRIBUTE_MASTER')->select('ATTRIBUTE_TYPE')->where('PK_NO',$variable_attribure_pks[$key])->first();

                $attrs = explode(',',$request->$attrs);
                foreach ($attrs as $key2 => $value2) {
                    $insert_attribute[] = [
                        'F_PRD_MASTER_SETUP_NO'          => $prod->PK_NO,
                        'ATTRIBUTE_TYPE'        => $attr_details->ATTRIBUTE_TYPE,
                        'F_ATTRIBUTE_MASTER'    => $variable_attribure_pks[$key],
                        'F_ATTRIBUTE_CHILD'     => $value2,
                        'SS_CREATED_ON'         => date('Y-m-d H:i:s'),
                        'F_SS_CREATED_BY'       => Auth::user()->PK_NO
                    ];
                }
            }
            if (isset($insert_attribute)) {
                ProductMasterAttrRelation::insert($insert_attribute);
            }

            $loop = 0;
            if (count($features_names) > 0) {
                if (count($variant_combo['combo_text']) > 0) {
                    if (count($variant_combo['combo_text'][0]) > 1) { //COMBO OF TWO VALUES
                        for ($i=0; $i < count($variant_combo['combo_text']); $i++) {
                            if(hasAccessAbility('product_approval', $roles)){
                                $is_active = $checkbox_values[$i];
                            }else{
                                $is_active = 2;
                            }
                            $slug = Str::slug(strtolower($request->name.'-'.$variant_combo['combo_text'][$i][0].'-'.$variant_combo['combo_text'][$i][1]));
                            $check = ProductVariant::where('URL_SLUG',$slug)->first();
                            if($check){
                                $slug = $slug.'-'.rand(1,99);
                            }
                            $insert_data[] = [
                                'F_PRD_MASTER_SETUP_NO' => $prod->PK_NO,
                                'VARIANT_NAME'          => $request->name.'-'.$variant_combo['combo_text'][$i][0].'-'.$variant_combo['combo_text'][$i][1],
                                'VARIANT_NAME_BN'       => $this->trnaslate('bn',$request->bn_name.'-'.$variant_combo['combo_text'][$i][0].'-'.$variant_combo['combo_text'][$i][1]),
                                'URL_SLUG'              => $slug,
                                'REGULAR_PRICE'         => $request->price[$i],
                                'SPECIAL_PRICE'         => $request->special_price[$i] ?? $request->price[$i],
                                'WHOLESALE_PRICE'       => $request->wholesale_price[$i] ?? $request->price[$i],
                                'INSTALLMENT_PRICE'     => $request->installment_price[$i] ?? $request->price[$i],
                                'IS_BARCODE_BY_MFG'     => $request->barcode[$i] ? 1 : 0,
                                'BARCODE'               => $request->barcode[$i],
                                'IS_ACTIVE'             => $is_active,
                                'F_COLOR_PARENT'        => $f_color_parent,
                                'F_COLOR_PARENT_NAME'   => $f_color_parent_name,
                                'F_COLOR_NO'            => $variant_combo['is_color'][$i][0] == 1 ? $variant_combo['combo_id'][$i][0] : $variant_combo['combo_id'][$i][1],
                                'COLOR_NAME'                 => $variant_combo['is_color'][$i][0] == 1 ? $variant_combo['combo_text'][$i][0] : $variant_combo['combo_text'][$i][1],
                                'F_SIZE_PARENT'         => $f_size_parent,
                                'F_SIZE_PARENT_NAME'    => $f_size_parent_name,
                                'F_SIZE_NO'             => $variant_combo['is_color'][$i][0] == 0 ? $variant_combo['combo_id'][$i][0] : $variant_combo['combo_id'][$i][1],
                                'SIZE_NAME'             => $variant_combo['is_color'][$i][0] == 0 ? $variant_combo['combo_text'][$i][0] : $variant_combo['combo_text'][$i][1],
                                'SS_CREATED_ON'         => date('Y-m-d H:i:s'),
                                'F_SS_CREATED_BY'       => Auth::user()->PK_NO,
                                'NARRATION'             => $request->long_description_en,
                                'NARRATION_BN'          => $request->long_description_bn,
                                'SHORT_NARRATION'       => $request->short_description_en,
                                'SHORT_NARRATION_BN'    => $request->short_description_bn,
                                'META_TITLE'            => $request->meta_title,
                                'META_KEYWARDS'         => $request->meta_keywards,
                                'META_DESCRIPTION'      => $request->meta_description
                            ];
                        }
                    }else{  // COMBO OF SINGLE VALUE
                        for ($i=0; $i < count($variant_combo['combo_text']); $i++) {
                            if(hasAccessAbility('product_approval', $roles)){
                                $is_active = $checkbox_values[$i];
                            }else{
                                $is_active = 2;
                            }
                            $slug = Str::slug(strtolower($request->name.'-'.$variant_combo['combo_text'][$i][0]));
                            $check = ProductVariant::where('URL_SLUG',$slug)->first();
                            if($check){
                                $slug = $slug.'-'.rand(1,99);
                            }
                            $insert_data[] = [
                                'F_PRD_MASTER_SETUP_NO' => $prod->PK_NO,
                                'VARIANT_NAME'          => $request->name.'-'.$variant_combo['combo_text'][$i][0],
                                'VARIANT_NAME_BN'       => $this->trnaslate('bn',$request->bn_name.'-'.$variant_combo['combo_text'][$i][0]),
                                'URL_SLUG'              => $slug,
                                'REGULAR_PRICE'         => $request->price[$i],
                                'SPECIAL_PRICE'         => $request->special_price[$i],
                                'WHOLESALE_PRICE'       => $request->wholesale_price[$i],
                                'INSTALLMENT_PRICE'     => $request->installment_price[$i],
                                'IS_BARCODE_BY_MFG'     => $request->barcode[$i] ? 1 : 0,
                                'BARCODE'               => $request->barcode[$i],
                                'IS_ACTIVE'             => $is_active,
                                'F_COLOR_PARENT'        => $f_color_parent,
                                'F_COLOR_PARENT_NAME'   => $f_color_parent_name,
                                'F_COLOR_NO'            => $variant_combo['is_color'][$i][0] == 1 ? $variant_combo['combo_id'][$i][0] : null,
                                'COLOR_NAME'            => $variant_combo['is_color'][$i][0] == 1 ? $variant_combo['combo_text'][$i][0] : null,
                                'F_SIZE_PARENT'         => $f_size_parent,
                                'F_SIZE_PARENT_NAME'    => $f_size_parent_name,
                                'F_SIZE_NO'             => $variant_combo['is_color'][$i][0] == 0 ? $variant_combo['combo_id'][$i][0] : null,
                                'SIZE_NAME'             => $variant_combo['is_color'][$i][0] == 0 ? $variant_combo['combo_text'][$i][0] : null,
                                'SS_CREATED_ON'         => date('Y-m-d H:i:s'),
                                'F_SS_CREATED_BY'       => Auth::user()->PK_NO,
                                'NARRATION'             => $request->long_description_en,
                                'NARRATION_BN'          => $request->long_description_bn,
                                'SHORT_NARRATION'       => $request->short_description_en,
                                'SHORT_NARRATION_BN'    => $request->short_description_bn,
                                'META_TITLE'            => $request->meta_title,
                                'META_KEYWARDS'         => $request->meta_keywards,
                                'META_DESCRIPTION'      => $request->meta_description
                            ];
                        }
                    }
                }
            }else{
                $slug = Str::slug(strtolower($request->name));
                $check = ProductVariant::where('URL_SLUG',$slug)->first();
                if($check){
                    $slug = $slug.'-'.rand(1,99);
                }
                if(hasAccessAbility('product_approval', $roles)){
                    $is_active = $checkbox_values[0];
                }else{
                    $is_active = 2;
                }
                $insert_data[] = [
                    'F_PRD_MASTER_SETUP_NO' => $prod->PK_NO,
                    'VARIANT_NAME'          => $request->name,
                    'VARIANT_NAME_BN'       => $request->bn_name,
                    'URL_SLUG'              => $slug,
                    'REGULAR_PRICE'         => $request->price[0],
                    'SPECIAL_PRICE'         => $request->special_price[0],
                    'WHOLESALE_PRICE'       => $request->wholesale_price[0],
                    'INSTALLMENT_PRICE'     => $request->installment_price[0],
                    'IS_BARCODE_BY_MFG'     => $request->barcode[0] ? 1 : 0,
                    'BARCODE'               => $request->barcode[0],
                    'IS_ACTIVE'             => $is_active,
                    'SS_CREATED_ON'         => date('Y-m-d H:i:s'),
                    'F_SS_CREATED_BY'       => Auth::user()->PK_NO,
                    'NARRATION'             => $request->long_description_en,
                    'NARRATION_BN'          => $request->long_description_bn,
                    'SHORT_NARRATION'       => $request->short_description_en,
                    'SHORT_NARRATION_BN'    => $request->short_description_bn,
                    'META_TITLE'            => $request->meta_title,
                    'META_KEYWARDS'         => $request->meta_keywards,
                    'META_DESCRIPTION'      => $request->meta_description
                ];
            }

            if (isset($insert_data)) {
                ProductVariant::insert($insert_data);
            }

        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            return $this->formatResponse(false, 'Unable to create product !', 'admin.product.list');
        }
        DB::commit();
        return $this->formatResponse(true, 'Product has been created successfully !', 'admin.product.create',$prod->PK_NO);
    }

    public function postUpdate($request, int $id)
    {
        $variable_array_list    = $request->variable_array_list ? json_decode($request->variable_array_list,true) : [];
        $features_names         = $request->features_names ? json_decode($request->features_names,true) : [];
        $features_full_names    = $request->features_full_names ? json_decode($request->features_full_names,true) : [];
        $variable_attribures    = $request->variable_attribures ? json_decode($request->variable_attribures,true) : [];

        $variable_attribure_pks = $request->variable_attribure_pks ? json_decode($request->variable_attribure_pks,true) : [];
        $variant_combo          = $request->variant_combo ? json_decode($request->variant_combo,true) : [];

        $f_color_parent = isset($features_names[0]) && isset($variable_array_list[$features_names[0]]) && $variable_array_list[$features_names[0]]['is_color'] == 1 ? $variable_array_list[$features_names[0]]['attr_pk'] : null;
        $f_size_parent  = isset($features_names[1]) && isset($variable_array_list[$features_names[1]]) && $variable_array_list[$features_names[1]]['is_color'] == 0 ? $variable_array_list[$features_names[1]]['attr_pk'] : (isset($features_names[0]) && isset($variable_array_list[$features_names[0]]) && $variable_array_list[$features_names[0]]['is_color'] == 0 ? $variable_array_list[$features_names[0]]['attr_pk'] : null);

        $f_color_parent_name = isset($f_color_parent) ? $features_full_names[0] : null;
        $f_size_parent_name  = isset($f_color_parent) ? $features_full_names[1] : (isset($f_size_parent) ? $features_full_names[0] : null);


        $brand_name         = null;
        $model_name         = null;
        $default_vat_amount = null;
        $mkt_prefix         = null;
        $roles = userRolePermissionArray();
        $success_route = 'admin.product.list';
        if($request->status == 'pending'){
            $success_route = 'admin.product.pending';
        }

        $need_approval = [];

        DB::beginTransaction();
        try {
            $slug = Str::slug(strtolower($request->name));
            $check = Product::where('URL_SLUG',$slug)->where('PK_NO','!=',$id)->first();
            if($check){
                $slug = $slug.'-'.rand(1,99);
            }
            $prod  = Product::find($id);
            $updated_data = json_decode($prod->NEED_APPROVAL,TRUE);


            if(hasAccessAbility('product_approval', $roles)){
                $prod->IS_ACTIVE = $request->is_active;
            }else{
                $pending = 0;

                if($prod->DEFAULT_PRICE != $request->default_price){$pending = 1; $need_approval['REGULAR_PRICE'] = $prod->DEFAULT_PRICE; }
                if($prod->DEFAULT_INSTALLMENT_PRICE != $request->ins_price){$pending = 1; $need_approval['INSTALLMENT_PRICE'] = $prod->DEFAULT_INSTALLMENT_PRICE; }
                if($prod->DEFAULT_AIR_FREIGHT_CHARGE  != $request->def_air_freight){$pending = 1; $need_approval['AIR_FREIGHT'] = $prod->DEFAULT_AIR_FREIGHT_CHARGE; }
                if($prod->DEFAULT_SEA_FREIGHT_CHARGE != $request->def_sea_freight){$pending = 1; $need_approval['SEA_FREIGHT'] = $prod->DEFAULT_SEA_FREIGHT_CHARGE; }

                $need_approval['IS_ACTIVE'] = $prod->IS_ACTIVE;
                if($pending == 1){$prod->IS_ACTIVE = 2; $prod->NEED_APPROVAL = json_encode($need_approval); }
            }

            if($request->submit == 'discard'){
                $prod->DEFAULT_NAME                         = $updated_data['DEFAULT_NAME'] ?? $request->name;
                $prod->DEFAULT_NAME_BN                      = $updated_data['DEFAULT_NAME_BN'] ?? $request->bn_name;

                $prod->IS_ACTIVE                            = $updated_data['IS_ACTIVE'] ?? 1;
            }else{
                $prod->DEFAULT_NAME                         = $request->name;
                $prod->DEFAULT_NAME_BN                      = $request->bn_name;
            }

            if($request->submit == 'approved'){
                $prod->IS_ACTIVE = 1;
            }
            $prod->F_COLOR_PARENT                       = $f_color_parent;
            $prod->F_COLOR_PARENT_NAME                  = $f_color_parent_name;
            $prod->F_SIZE_PARENT                        = $f_size_parent;
            $prod->F_SIZE_PARENT_NAME                   = $f_size_parent_name;
            $prod->F_PRD_CATEGORY_ID                    = $request->category[0];

            $prod->DEFAULT_PRICE                        = $request->default_price;
            $prod->DEFAULT_INSTALLMENT_PRICE            = $request->ins_price;

            $prod->DEFAULT_NARRATION                    = $request->def_narration;
            $prod->SHORT_DESCRIPTION_EN                 = $request->short_description_en;
            $prod->SHORT_DESCRIPTION_BN                 = $request->short_description_bn;
            $prod->LONG_DESCRIPTION_EN                  = $request->long_description_en;
            $prod->LONG_DESCRIPTION_BN                  = $request->long_description_bn;

            $prod->URL_SLUG                             = $slug;
            $prod->NEW_ARRIVAL                          = $request->new_arrival;
            $prod->IS_FEATURE                           = $request->is_feature;
            $prod->MAX_ORDER                            = $request->max_order;
            $prod->SEARCH_KEYWORD                       = $request->search_keyword;
            $prod->META_TITLE                           = $request->meta_title;
            $prod->META_KEYWARDS                        = $request->meta_keywards;
            $prod->META_DESCRIPTION                     = $request->meta_description;
            $prod->update();


            ProductMasterCategoryMap::where('F_PRD_MASTER_SETUP_NO',$id)->delete();
            foreach ($request->category as $cat_key => $category_array) {
                $category_pks = array();
                $selected_cat_array = array();
                $category = DB::table('PRD_CATEGORY')->select('PK_NO','PARENT_ID')->where('PK_NO',$category_array)->first();
                if(isset($category)){
                    for ($i=0; $i < 3; $i++) {
                        if(isset($category)){
                            if($category->PARENT_ID == 0){
                                $subcategory = DB::table('PRD_CATEGORY')->where('IS_ACTIVE',1)->where('PARENT_ID', 0)->count();
                            }else{
                                $subcategory = DB::table('PRD_CATEGORY')->where('IS_ACTIVE',1)->where('PARENT_ID', $category->PARENT_ID)->count();
                            }
                            if (isset($subcategory) && $subcategory > 0) {
                                if($i == 0){
                                    $cat_array_pk = $category_array;
                                    $selected = 1;
                                }else{
                                    $cat_array_pk = $category->PK_NO ?? 0;
                                    $selected = 0;
                                }
                                array_push($category_pks,$cat_array_pk);
                                array_push($selected_cat_array,$selected);
                            }
                            $category = DB::table('PRD_CATEGORY')->select('PARENT_ID','PK_NO')->where('PK_NO',$category->PARENT_ID)->first();
                            if(!isset($category) || empty($category)){ // parent is 0
                                $category = (object)[];
                                $category->PARENT_ID = 0;
                            }
                        }
                    }
                }
                foreach ($category_pks as $key => $value) {
                    if ($value > 0) {
                        $insert_category[] = [
                            'F_PRD_MASTER_SETUP_NO'          => $prod->PK_NO,
                            'F_PRD_CATEGORY_ID'     => $value,
                            'GROUP_ID'              => $cat_key,
                            'IS_SELECTED'           => $selected_cat_array[$key],
                            'SS_CREATED_ON'         => date('Y-m-d H:i:s'),
                            'F_SS_CREATED_BY'       => Auth::user()->PK_NO
                        ];
                    }
                }
            }
            // dd($insert_category);
            if (isset($insert_category)) {
                ProductMasterCategoryMap::insert($insert_category);
            }

            ProductMasterAttrRelation::where('F_PRD_MASTER_SETUP_NO',$prod->PK_NO)->delete();
            if ($variable_attribures) {
                foreach ($variable_attribures as $key => $value) {
                    $attrs = 'attr_'.$value;
                    $attr_details = DB::table('PRD_ATTRIBUTE_MASTER')->select('ATTRIBUTE_TYPE')->where('PK_NO',$variable_attribure_pks[$key])->first();

                    $attrs = explode(',',$request->$attrs);
                    foreach ($attrs as $key2 => $value2) {
                        $insert_attribute[] = [
                            'F_PRD_MASTER_SETUP_NO'          => $prod->PK_NO,
                            'ATTRIBUTE_TYPE'        => $attr_details->ATTRIBUTE_TYPE,
                            'F_ATTRIBUTE_MASTER'    => $variable_attribure_pks[$key],
                            'F_ATTRIBUTE_CHILD'     => $value2,
                            'SS_CREATED_ON'         => date('Y-m-d H:i:s'),
                            'F_SS_CREATED_BY'       => Auth::user()->PK_NO
                        ];
                    }
                }
                if (isset($insert_attribute)) {
                    ProductMasterAttrRelation::insert($insert_attribute);
                }
            }

            if (count($features_names) > 0) {
                if (count($variant_combo['combo_text']) > 0) {
                    if (count($variant_combo['combo_text'][0]) > 1) { //COMBO OF TWO VALUES
                        for ($i=0; $i < count($variant_combo['combo_text']); $i++) {
                            if ($variant_combo['variant_pk'][$i] == 0) {
                                if(hasAccessAbility('product_approval', $roles)){
                                    $is_active = $request->is_active_variant[$i];
                                }else{
                                    $is_active = 2;
                                }
                                $slug = Str::slug(strtolower($request->name.'-'.$variant_combo['combo_text'][$i][0].'-'.$variant_combo['combo_text'][$i][1]));
                                $check = ProductVariant::where('URL_SLUG',$slug)->first();
                                if($check){
                                    $slug = $slug.'-'.rand(1,99);
                                }
                                $insert_data[] = [
                                    'F_PRD_MASTER_SETUP_NO' => $prod->PK_NO,
                                    'VARIANT_NAME'          => $request->name.'-'.$variant_combo['combo_text'][$i][0].'-'.$variant_combo['combo_text'][$i][1],
                                    'VARIANT_NAME_BN'       => $this->trnaslate('bn',$request->bn_name.'-'.$variant_combo['combo_text'][$i][0].'-'.$variant_combo['combo_text'][$i][1]),
                                    'URL_SLUG'              => $slug,
                                    'REGULAR_PRICE'         => $request->price[$i],
                                    'SPECIAL_PRICE'         => $request->special_price[$i],
                                    'WHOLESALE_PRICE'       => $request->wholesale_price[$i],
                                    'INSTALLMENT_PRICE'     => $request->installment_price[$i],
                                    'IS_BARCODE_BY_MFG'     => $request->barcode[$i] ? 1 : 0,
                                    'BARCODE'               => $request->barcode[$i],
                                    'IS_ACTIVE'             => $is_active,
                                    'F_COLOR_NO'            => $variant_combo['is_color'][$i][0] == 1 ? $variant_combo['combo_id'][$i][0] : $variant_combo['combo_id'][$i][1],
                                    'COLOR_NAME'            => $variant_combo['is_color'][$i][0] == 1 ? $variant_combo['combo_text'][$i][0] : $variant_combo['combo_text'][$i][1],
                                    'F_COLOR_PARENT_NAME'   => $f_color_parent_name,
                                    'F_COLOR_PARENT'        => $f_color_parent,
                                    'F_SIZE_NO'             => $variant_combo['is_color'][$i][0] == 0 ? $variant_combo['combo_id'][$i][0] : $variant_combo['combo_id'][$i][1],
                                    'F_SIZE_PARENT_NAME'    => $f_size_parent_name,
                                    'F_SIZE_PARENT'         => $f_size_parent,
                                    'SIZE_NAME'             => $variant_combo['is_color'][$i][0] == 0 ? $variant_combo['combo_text'][$i][0] : $variant_combo['combo_text'][$i][1],
                                    'SS_CREATED_ON'         => date('Y-m-d H:i:s'),
                                    'F_SS_CREATED_BY'       => Auth::user()->PK_NO,
                                    'NARRATION'             => $request->long_description_en,
                                    'NARRATION_BN'          => $request->long_description_bn,
                                    'SHORT_NARRATION'       => $request->short_description_en,
                                    'SHORT_NARRATION_BN'    => $request->short_description_bn,
                                    'META_TITLE'            => $request->meta_title,
                                    'META_KEYWARDS'         => $request->meta_keywards,
                                    'META_DESCRIPTION'      => $request->meta_description
                                ];
                            }
                        }
                    }else{  // COMBO OF SINGLE VALUE
                        for ($i=0; $i < count($variant_combo['combo_text']); $i++) {
                            if ($variant_combo['variant_pk'][$i] == 0) {
                                if(hasAccessAbility('product_approval', $roles)){
                                    $is_active = $request->is_active_variant[$i];
                                }else{
                                    $is_active = 2;
                                }
                                $slug = Str::slug(strtolower($request->name.'-'.$variant_combo['combo_text'][$i][0]));
                                $check = ProductVariant::where('URL_SLUG',$slug)->first();
                                if($check){
                                    $slug = $slug.'-'.rand(1,99);
                                }
                                $insert_data[] = [
                                    'F_PRD_MASTER_SETUP_NO' => $prod->PK_NO,
                                    'VARIANT_NAME'          => $request->name.'-'.$variant_combo['combo_text'][$i][0],
                                    'VARIANT_NAME_BN'       => $this->trnaslate('bn',$request->bn_name.'-'.$variant_combo['combo_text'][$i][0]),
                                    'URL_SLUG'              => $slug,
                                    'REGULAR_PRICE'         => $request->price[$i],
                                    'SPECIAL_PRICE'         => $request->special_price[$i],
                                    'WHOLESALE_PRICE'       => $request->wholesale_price[$i],
                                    'INSTALLMENT_PRICE'     => $request->installment_price[$i],
                                    'IS_BARCODE_BY_MFG'     => $request->barcode[$i] ? 1 : 0,
                                    'BARCODE'               => $request->barcode[$i],
                                    'IS_ACTIVE'             => $is_active,
                                    'F_COLOR_NO'            => $variant_combo['is_color'][$i][0] == 1 ? $variant_combo['combo_id'][$i][0] : null,
                                    'COLOR_NAME'            => $variant_combo['is_color'][$i][0] == 1 ? $variant_combo['combo_text'][$i][0] : null,
                                    'F_COLOR_PARENT_NAME'   => $f_color_parent_name,
                                    'F_COLOR_PARENT'        => $f_color_parent,
                                    'F_SIZE_NO'             => $variant_combo['is_color'][$i][0] == 0 ? $variant_combo['combo_id'][$i][0] : null,
                                    'SIZE_NAME'             => $variant_combo['is_color'][$i][0] == 0 ? $variant_combo['combo_text'][$i][0] : null,
                                    'F_SIZE_PARENT_NAME'    => $f_size_parent_name,
                                    'F_SIZE_PARENT'         => $f_size_parent,
                                    'SS_CREATED_ON'         => date('Y-m-d H:i:s'),
                                    'F_SS_CREATED_BY'       => Auth::user()->PK_NO,
                                    'NARRATION'             => $request->long_description_en,
                                    'NARRATION_BN'          => $request->long_description_bn,
                                    'SHORT_NARRATION'       => $request->short_description_en,
                                    'SHORT_NARRATION_BN'    => $request->short_description_bn,
                                    'META_TITLE'            => $request->meta_title,
                                    'META_KEYWARDS'         => $request->meta_keywards,
                                    'META_DESCRIPTION'      => $request->meta_description
                                ];
                            }
                        }
                    }
                }
            }else{
                if ($variant_combo['variant_pk'] == 0) {
                    $slug = Str::slug(strtolower($request->name));
                    $check = ProductVariant::where('URL_SLUG',$slug)->first();
                    if($check){
                        $slug = $slug.'-'.rand(1,99);
                    }
                    if(hasAccessAbility('product_approval', $roles)){
                        $is_active = $request->is_active_variant[0];
                    }else{
                        $is_active = 2;
                    }
                    $insert_data[] = [
                        'F_PRD_MASTER_SETUP_NO' => $prod->PK_NO,
                        'VARIANT_NAME'          => $request->name,
                        'VARIANT_NAME_BN'       => $request->bn_name,
                        'URL_SLUG'              => $slug,
                        'REGULAR_PRICE'         => $request->price[0],
                        'SPECIAL_PRICE'         => $request->special_price[0],
                        'WHOLESALE_PRICE'       => $request->wholesale_price[0],
                        'INSTALLMENT_PRICE'     => $request->installment_price[0],
                        'IS_BARCODE_BY_MFG'     => $request->barcode[0] ? 1 : 0,
                        'BARCODE'               => $request->barcode[0],
                        'IS_ACTIVE'             => $is_active,
                        'SS_CREATED_ON'         => date('Y-m-d H:i:s'),
                        'F_SS_CREATED_BY'       => Auth::user()->PK_NO,
                        'NARRATION'             => $request->long_description_en,
                        'NARRATION_BN'          => $request->long_description_bn,
                        'SHORT_NARRATION'       => $request->short_description_en,
                        'SHORT_NARRATION_BN'    => $request->short_description_bn,
                        'META_TITLE'            => $request->meta_title,
                        'META_KEYWARDS'         => $request->meta_keywards,
                        'META_DESCRIPTION'      => $request->meta_description
                    ];
                }
            }
            if (isset($insert_data)) {
                ProductVariant::insert($insert_data);
            }
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            return $this->formatResponse(false, 'Unable to update product !', $success_route);
        }
        DB::commit();
        return $this->formatResponse(true, 'Product has been updated successfully !', $success_route);

    }

    public function getShow(int $id)
    {

        // F_PRD_MASTER_SETUP_NO
        $html               = [];
        $selected_cat       = [];
        $data['product']    =  Product::find($id);
        $categories         = DB::table('PRD_MASTER_CATEGORY_MAP')->select('F_PRD_CATEGORY_ID','GROUP_ID')->where(['F_PRD_MASTER_SETUP_NO' => $id,'IS_ACTIVE' => 1])->get();
        $processed_category = array();
        foreach ($categories as $element) {
            $processed_category[$element->GROUP_ID][] = $element;
        }
        foreach ($processed_category as $key1 => $category_arr) {
            foreach ($category_arr as $key2 => $value) {
                $category = DB::table('PRD_CATEGORY')->select('PK_NO','PARENT_ID')->where('PK_NO',$value->F_PRD_CATEGORY_ID)->first();
                if(isset($category)){
                    if($category->PARENT_ID == 0){
                        $subcategory = DB::table('PRD_CATEGORY')->select('PK_NO as SUBCATEGORY_ID','NAME as SUBCATEGORY_NAME','PARENT_ID')->where('IS_ACTIVE',1)->where('PARENT_ID', 0)->orderBy('ORDER_ID','DESC')->get();
                    }else{
                        $subcategory = DB::table('PRD_CATEGORY')->select('PK_NO as SUBCATEGORY_ID','NAME as SUBCATEGORY_NAME','PARENT_ID')->where('IS_ACTIVE',1)->where('PARENT_ID', $category->PARENT_ID)->orderBy('ORDER_ID','DESC')->get();
                    }
                    foreach ($subcategory as $key => $subcat) {
                        $has_child = DB::table('PRD_CATEGORY')->where('IS_ACTIVE',1)->where('PARENT_ID', $subcat->SUBCATEGORY_ID)->count();
                        if($has_child > 0){
                            $subcat->HAS_CHILD = 1;
                        }else{
                            $subcat->HAS_CHILD = 0;
                        }
                    }
                    if (isset($subcategory) && $subcategory->count() > 0) {
                        $selected = $value->F_PRD_CATEGORY_ID;
                        $html[$key1][$key2] = view('admin.product.cat_child_render')->withCategories($subcategory)->withSelected($selected)->render();
                        $selected_cat[$key1][$key2] = $selected;
                    }
                }
            }
            if(!empty($html[$key1])){
                $html[$key1] = array_reverse($html[$key1]);
            }

        }

        $data['categories'] = $html;
        $data['selected_categories'] = $selected_cat;
        $data['category']   = DB::table('PRD_MASTER_CATEGORY_MAP')->select('F_PRD_CATEGORY_ID')->where('F_PRD_MASTER_SETUP_NO',$id)->where('IS_ACTIVE',1)->first();

        $data['variant']    = DB::table('PRD_VARIANT_SETUP')->select('PK_NO','COMPOSITE_CODE','F_COLOR_NO','COLOR_NAME','F_SIZE_NO','SIZE_NAME','BARCODE','QTY','REGULAR_PRICE','SPECIAL_PRICE','WHOLESALE_PRICE','INSTALLMENT_PRICE','IS_ACTIVE')->where('F_PRD_MASTER_SETUP_NO',$id)->get();

        $attribute = DB::table('PRD_ATTRIBUTE_RELATIONS')->select(DB::raw('(group_concat(distinct F_ATTRIBUTE_NO)) as attributes'))->where('IS_ACTIVE',1)->where('F_CATEGORY_NO', $data['category']->F_PRD_CATEGORY_ID)->first();

        if(isset($attribute->attributes)){
            $array = explode(',',$attribute->attributes);
            $attributes = DB::table('PRD_ATTRIBUTE_MASTER')->select('PK_NO','NAME','TITLE','SLUG','ATTRIBUTE_TYPE','IS_REQUIRED')->whereIn('PK_NO',$array)->where('IS_ACTIVE',1)->get();
            if(isset($attributes) && !empty($attributes)){
                foreach ($attributes as $key => $value) {

                    if ($value->ATTRIBUTE_TYPE == 2) {
                        $attribute_child = DB::table('PRD_ATTRIBUTE_CHILD')->where('F_ATTRIBUTE_MASTER',$value->PK_NO)->where('IS_ACTIVE',1)->orderBy('ORDER_NO','ASC')->pluck('VALUE','PK_NO');
                        $value->attribute_child = $attribute_child ?? '';
                        $value->selected_attribute_child = DB::table('PRD_MASTER_ATTRIBUTE_RELATIONS')->join('PRD_ATTRIBUTE_CHILD','PRD_ATTRIBUTE_CHILD.PK_NO','PRD_MASTER_ATTRIBUTE_RELATIONS.F_ATTRIBUTE_CHILD')->where('PRD_MASTER_ATTRIBUTE_RELATIONS.F_ATTRIBUTE_MASTER',$value->PK_NO)->where('PRD_MASTER_ATTRIBUTE_RELATIONS.F_PRD_MASTER_SETUP_NO',$id)->where('PRD_MASTER_ATTRIBUTE_RELATIONS.IS_ACTIVE',1)->pluck('PRD_MASTER_ATTRIBUTE_RELATIONS.F_ATTRIBUTE_CHILD');
                    }elseif($value->ATTRIBUTE_TYPE == 3) {
                        $value->selected_attribute_child = DB::table('PRD_MASTER_ATTRIBUTE_RELATIONS')->join('PRD_ATTRIBUTE_CHILD','PRD_ATTRIBUTE_CHILD.PK_NO','PRD_MASTER_ATTRIBUTE_RELATIONS.F_ATTRIBUTE_CHILD')->where('PRD_MASTER_ATTRIBUTE_RELATIONS.F_ATTRIBUTE_MASTER',$value->PK_NO)->where('PRD_MASTER_ATTRIBUTE_RELATIONS.F_PRD_MASTER_SETUP_NO',$id)->where('PRD_MASTER_ATTRIBUTE_RELATIONS.IS_ACTIVE',1)->pluck('PRD_ATTRIBUTE_CHILD.VALUE','PRD_ATTRIBUTE_CHILD.PK_NO');
                    }else{
                        $value->selected_attribute_child = DB::table('PRD_MASTER_ATTRIBUTE_RELATIONS')->where('F_ATTRIBUTE_MASTER',$value->PK_NO)->where('F_PRD_MASTER_SETUP_NO',$id)->where('IS_ACTIVE',1)->pluck('F_ATTRIBUTE_CHILD');
                    }
                }
            }
        }

        $feature = [];
        $feature_selected_options['color'] = [];
        $feature_selected_options['size'] = [];
        if(isset($data['product']->F_COLOR_PARENT))array_push($feature,$data['product']->F_COLOR_PARENT);
        if(isset($data['product']->F_SIZE_PARENT))array_push($feature,$data['product']->F_SIZE_PARENT);
        foreach ($data['variant'] as $key => $value) {
            if( isset($value->F_COLOR_NO) && (!in_array($value->F_COLOR_NO,$feature_selected_options['color']))){
                array_push($feature_selected_options['color'],$value->F_COLOR_NO);
            }
            if( isset($value->F_SIZE_NO) && (!in_array($value->F_SIZE_NO,$feature_selected_options['size']))){
                array_push($feature_selected_options['size'],$value->F_SIZE_NO);
            }
        }
        // echo '<pre>';
        // echo '======================<br>';
        // print_r($data['variant']);
        // echo '<br>======================<br>';
        // exit();
        if(isset($feature)){
            // $array = explode(',',$feature);
            $features = DB::table('PRD_FEATURE_MASTER')->select('PK_NO','NAME','TITLE','IS_COLOR','FEATURE_TYPE','SLUG')->whereIn('PK_NO',$feature)->where('IS_ACTIVE',1)->where('F_PARENT_NO',0)->orderBy('IS_COLOR','DESC')->get(); //COLOR_NAME,SIZE
            if(isset($features) && !empty($features)){
                $feature_names = array();
                $feature_slug = array();
                foreach ($features as $key => $value) {
                    array_push($feature_names,$value->NAME);
                    array_push($feature_slug,$value->SLUG);
                    if ($value->FEATURE_TYPE == 2) {
                        $feature_options = DB::table('PRD_FEATURE_MASTER')->where('F_PARENT_NO',$value->PK_NO)->where('IS_ACTIVE',1)->orderBy('ORDER_NO','ASC')->pluck('NAME','PK_NO')->toArray();
                        $value->feature_options = $feature_options ?? '';
                        if (isset($data['variant']) && $data['variant']->count() > 0) {
                            $selected_feature = DB::table('PRD_FEATURE_MASTER')->select('F_PARENT_NO')->where('PK_NO',end($feature_selected_options['size']))->first();
                            $feature_selected_options['option2'] = $selected_feature->F_PARENT_NO;
                            if(isset($value->feature_options) && !empty($value->feature_options)){
                                $value->feature_child = DB::table('PRD_FEATURE_MASTER')->where('F_PARENT_NO',$feature_selected_options['option2'])->where('IS_ACTIVE',1)->orderBy('ORDER_NO','ASC')->pluck('NAME','PK_NO');
                            }
                        }
                    }elseif($value->FEATURE_TYPE == 1){
                        $value->feature_child = DB::table('PRD_FEATURE_MASTER')->where('F_PARENT_NO',$value->PK_NO)->where('IS_ACTIVE',1)->orderBy('ORDER_NO','ASC')->pluck('NAME','PK_NO');
                    }
                }
            }
        }
        $data['features']       = $features->toArray() ?? [];
        $data['attributes']     = $attributes ?? [];
        $data['feature_selected_options'] = $feature_selected_options ?? [];
        if ((isset($attribute->attributes) && $attributes->count() > 0) || isset($feature) && $features->count() > 0) {
            $data['fea_html']       = view('admin.product.category_features')->withFeatures($features)->withFeatureoptions($feature_selected_options)->render();
            $data['variant_html']   = view('admin.product.product_variant_generate')->withFeaturenames($feature_names)->withVariants($data['variant'])->render();
            $data['attributes']     = $attributes ?? [];
        }else{
            $data['fea_html']       = '';
            $data['variant_html']   = view('admin.product.product_variant_generate')->withFeaturenames(array())->withVariants($data['variant'])->render();
            $data['attributes']     = [];
        }
        $data['variant']        = $data['variant']->toArray() ?? [];
        if (!empty($data['product'])) {
            return $this->formatResponse(true, 'Data found', 'admin.product.edit', $data);
        }
        return $this->formatResponse(false, 'Did not found data !', 'admin.product.list', null);
    }

    public function delete(int $id)
    {
        DB::begintransaction();
        try {
            $product = Product::find($id)->delete();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, 'Unable to delete product !', 'admin.product.list');
        }
        DB::commit();
        return $this->formatResponse(true, 'Successfully delete product with variant product !', 'admin.product.list');
    }

    public function getProductSearchList($request)
    {

        $category       = trim($request->category);
        $sub_category   = trim($request->sub_category);
        $brand          = trim($request->brand);
        $prod_model     = trim($request->prod_model);
        $name           = trim($request->keyword);
        $vat_class      = trim($request->vat_class);
        $ig_code        = trim($request->ig_code);
        $sku_id         = trim($request->sku_id);
        $barcode        = trim($request->barcode);
        $shipping_method        = trim($request->preferred_shipping_method);
        $is_active        = trim($request->is_active);


        $data = ProductVariant::select('PRD_VARIANT_SETUP.*')
        ->join('PRD_MASTER_SETUP','PRD_MASTER_SETUP.PK_NO','PRD_VARIANT_SETUP.F_PRD_MASTER_SETUP_NO');



        $data = $data->where('PRD_VARIANT_SETUP.IS_ACTIVE', '=', $is_active);

        if (!empty($name))
        {
            dd($name);
            $pieces = explode(" ", $name);
            if($pieces){
                foreach ($pieces as $key => $piece) {
                    $data->where('PRD_VARIANT_SETUP.VARIANT_NAME', 'LIKE', '%' . $piece . '%');
                    // $data->Where('PRD_VARIANT_SETUP.KEYWORD_SEARCH', 'LIKE', '%' . $piece . '%');
                }
            }
        }



        if (!empty($sub_category))
        {
            $data->join('PRD_MASTER_CATEGORY_MAP', 'PRD_MASTER_CATEGORY_MAP.F_PRD_MASTER_SETUP_NO', 'PRD_MASTER_SETUP.PK_NO');
            $data->where('PRD_MASTER_CATEGORY_MAP.F_PRD_CATEGORY_ID', '=',$sub_category);

        }elseif (!empty($category)){
            $data->join('PRD_MASTER_CATEGORY_MAP', 'PRD_MASTER_CATEGORY_MAP.F_PRD_MASTER_SETUP_NO', 'PRD_MASTER_SETUP.PK_NO');
            $data->where('PRD_MASTER_CATEGORY_MAP.F_PRD_CATEGORY_ID', '=',$category);

        }

        if (!empty($brand)){
            $data->join('PRD_MASTER_ATTRIBUTE_RELATIONS', 'PRD_MASTER_ATTRIBUTE_RELATIONS.F_PRD_MASTER_SETUP_NO', 'PRD_MASTER_SETUP.PK_NO');
            $data->where('PRD_MASTER_ATTRIBUTE_RELATIONS.F_ATTRIBUTE_CHILD', '=',$brand);
        }
        if (!empty($prod_model)){
            $data->join('PRD_MASTER_ATTRIBUTE_RELATIONS', 'PRD_MASTER_ATTRIBUTE_RELATIONS.F_PRD_MASTER_SETUP_NO', 'PRD_MASTER_SETUP.PK_NO');
            $data->where('PRD_MASTER_ATTRIBUTE_RELATIONS.F_ATTRIBUTE_CHILD', '=',$prod_model);
        }


        if (!empty($sku_id)){
            $data->where('PRD_VARIANT_SETUP.COMPOSITE_CODE', '=',$sku_id);
        }
        if (!empty($barcode)){
            $data->where('PRD_VARIANT_SETUP.BARCODE', '=',$barcode);
        }
        // if(Auth::user()->USER_TYPE == 10){
        //     $f_shop_no = Auth::user()->SHOP_ID;
        //     $data->join('PRD_SHOP_VARIANT_MAP', 'PRD_SHOP_VARIANT_MAP.F_PRD_VARIANT_NO', 'PRD_VARIANT_SETUP.PK_NO');
        //     $data->where('PRD_SHOP_VARIANT_MAP.F_SHOP_NO', '=',$f_shop_no);

        // }



        $data = $data->orderBy('PRD_MASTER_SETUP.DEFAULT_NAME','ASC')->groupBy('PRD_VARIANT_SETUP.PK_NO')->get();

        return $this->formatResponse(true, '', 'admin.product.list', $data);
    }


    public function deleteImage(int $id)
    {
        DB::begintransaction();
        try {

            $prod_img = ProdImgLib::find($id);
            if ($prod_img->IS_MASTER == 1) {
                ProdImgLib::where('PK_NO', $id)->delete();
                $product  = Product::find($prod_img->F_PRD_MASTER_SETUP_NO);
                $img_lib = ProdImgLib::where('F_PRD_MASTER_SETUP_NO', $product->PK_NO)->orderBy('SERIAL_NO','ASC')->first();
                if ($img_lib) {
                    $product->PRIMARY_IMG_RELATIVE_PATH = $img_lib->RELATIVE_PATH;
                    $product->update();
                    $img_lib->IS_MASTER = 1;
                    $img_lib->update();
                }else{
                    $product->PRIMARY_IMG_RELATIVE_PATH = null;
                    $product->update();
                }
            }else{
                $prod = ProductVariant::find($prod_img->F_PRD_VARIANT_NO);
                if($prod->F_COLOR_NO){
                    $similar_colors = ProductVariant::where('F_PRD_MASTER_SETUP_NO',$prod->F_PRD_MASTER_SETUP_NO)->where('F_COLOR_NO',$prod->F_COLOR_NO)->get();
                }
                if(isset($similar_colors) && $similar_colors->count() > 0){
                    foreach ($similar_colors as $key => $value) {
                        ProdImgLib::where('RELATIVE_PATH',$prod_img->RELATIVE_PATH)->where('F_PRD_VARIANT_NO',$value->PK_NO)->delete();
                    }
                }else{
                    ProdImgLib::where('PK_NO', $id)->delete();
                }
                $img_lib = ProdImgLib::select('RELATIVE_PATH','THUMB_PATH')->where('F_PRD_VARIANT_NO',$prod_img->F_PRD_VARIANT_NO)->orderBy('SERIAL_NO','ASC')->first();
                if ($img_lib) {
                    if(isset($similar_colors) && $similar_colors->count() > 0){
                        foreach ($similar_colors as $key => $value) {
                            $value->PRIMARY_IMG_RELATIVE_PATH = $img_lib->RELATIVE_PATH;
                            $value->THUMB_PATH = $img_lib->THUMB_PATH;
                            $value->update();
                        }
                    }else{
                        $prod->PRIMARY_IMG_RELATIVE_PATH = $img_lib->RELATIVE_PATH;
                        $prod->THUMB_PATH = $img_lib->THUMB_PATH;
                        $prod->update();
                    }
                }else{
                    if(isset($similar_colors) && $similar_colors->count() > 0){
                        foreach ($similar_colors as $key => $value) {
                            $value->PRIMARY_IMG_RELATIVE_PATH = null;
                            $value->THUMB_PATH = null;
                            $value->update();
                        }
                    }else{
                        $prod->PRIMARY_IMG_RELATIVE_PATH = null;
                        $prod->THUMB_PATH = null;
                        $prod->update();
                    }
                }
            }
            if($prod_img->THUMB_PATH){
                if (File::exists(public_path($prod_img->THUMB_PATH))) {
                    File::delete(public_path($prod_img->THUMB_PATH));
                }
            }
            if($prod_img->RELATIVE_PATH){
                if (File::exists(public_path($prod_img->RELATIVE_PATH))) {
                    File::delete(public_path($prod_img->RELATIVE_PATH));
                }
            }

        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return $this->formatResponse(false, 'Unable to delete product photo !', 'admin.product.list');
        }
        DB::commit();
        return $this->formatResponse(true, 'Successfully deleted product photo !', 'admin.product.list');
    }

    public function postStoreProductVariant($request)
    {
        $brand_name         = null;
        $model_name         = null;
        $vat_amount         = null;
        $roles              = userRolePermissionArray();
        $prd_no             = $request->pk_no;
        $color  = DB::table('PRD_COLOR')->where('PK_NO',$request->color)->first();
        $size   = DB::table('PRD_SIZE')->where('PK_NO',$request->size)->first();
        $vat_class = DB::table('ACC_VAT_CLASS')->where('PK_NO',$request->vat_class)->first();
        if ($color){ $color_name = $color->NAME; }

        if ($size){ $size_name = $size->NAME; }
        if ($vat_class){ $vat_amount = $vat_class->RATE; }

        $result = ProductVariant::where(['F_PRD_MASTER_SETUP_NO' => $prd_no,'F_SIZE_NO' => $request->size, 'F_COLOR_NO' => $request->color])->first();

        if($result){
            return $this->formatResponse(false, 'Unable to create product variant because multiple product not allow by same color and same size !', 'admin.product.create');
        }
        DB::beginTransaction();
        try {
            $slug = Str::slug(strtolower($request->name));
            $check = ProductVariant::where('URL_SLUG',$slug)->first();
            if($check){
                $slug = $slug.'-'.rand(1,99);
            }

            $prod                                       = new ProductVariant();
            $prod->F_PRD_MASTER_SETUP_NO                = $prd_no;
            $prod->VARIANT_NAME                         = $request->name;
            $prod->URL_SLUG                             = $slug;
            $prod->VARIANT_CUSTOMS_NAME                 = $request->customs_name;
            $prod->F_SIZE_NO                            = $request->size;
            $prod->SIZE_NAME                            = $size_name;
            $prod->F_COLOR_NO                           = $request->color;
            $prod->COLOR_NAME                                = $color_name;
            $prod->BARCODE                              = $request->barcode;
            $prod->IS_BARCODE_BY_MFG                    = $request->is_barcode_by_mfg ? 1 : 0;
            $prod->NARRATION                            = $request->narration;
            $prod->SHORT_NARRATION                      = $request->short_narration;
            $prod->NEW_ARRIVAL                          = $request->new_arrival;
            $prod->IS_FEATURE                           = $request->is_feature;
            $prod->PROMOTIONAL_MESSAGE                  = $request->promotional_message;
            $prod->F_PRIMARY_IMG_VARIANT_ID             = null;
            $prod->PRIMARY_IMG_RELATIVE_PATH            = null;
            $prod->REGULAR_PRICE                        = $request->price;
            $prod->INSTALLMENT_PRICE                    = $request->price_ins;
            $prod->MAX_ORDER                            = $request->max_order_qty;
            $prod->SEA_FREIGHT_CHARGE                   = $request->sea_freight;
            $prod->AIR_FREIGHT_CHARGE                   = $request->air_freight;
            $prod->PREFERRED_SHIPPING_METHOD            = $request->def_shipping_method;
            // $prod->LOCAL_POSTAGE                        = $request->local_postage;
            $prod->INTER_DISTRICT_POSTAGE               = $request->int_postage;
            $prod->F_VAT_CLASS                          = $request->vat_class;
            $prod->VAT_AMOUNT_PERCENT                   = $vat_amount;
            $prod->META_TITLE                           = $request->meta_title;
            $prod->META_KEYWARDS                        = $request->meta_keywards;
            $prod->META_DESCRIPTION                     = $request->meta_description;


            if(hasAccessAbility('product_approval', $roles)){
                $prod->IS_ACTIVE = $request->is_active;
            }else{
                $prod->IS_ACTIVE = 2;
            }

            $prod->save();

            if ($request->file('images')) {

                $i = 0;
                foreach($request->file('images') as $key => $image)
                    {
                        // $image = $request->file('pro_image');
                        $filename = $image->getClientOriginalExtension();

                        $destinationPath1   = 'media/images/products/'.$prd_no;
                        $destinationPath2    = 'media/images/products/'.$prd_no.'/thumb';
                        if (!file_exists($destinationPath1)) {
                            mkdir($destinationPath1, 0755, true);
                        }
                        if (!file_exists($destinationPath2)) {
                            mkdir($destinationPath2, 0755, true);
                        }
                        // echo '<pre>';
                        // echo '======================<br>';
                        // print_r($image->getRealPath());
                        // echo '<br>======================<br>';
                        // exit();
                        $img = Image::make($image->getRealPath());
                        $file_name1 = 'prod_'. date('dmY'). '_' .uniqid().'.'.$filename;
                        $file_name2 = 'prod_'. date('dmY'). '_' .uniqid(). '.webp' ;
                        Image::make($img)->save($destinationPath1.'/'.$file_name1);
                        Image::make($img)->encode('webp', 100)->resize(120, null, function ($constraint) {
                                  $constraint->aspectRatio();
                                 // $constraint->upsize();
                        })->save($destinationPath2.'/'.$file_name2);
                        $image_url = $destinationPath1 .'/'. $file_name1;
                        $thumb_url = $destinationPath2 .'/'. $file_name2;
                        $img_lib                    = new ProdImgLib();
                        $img_lib->F_PRD_VARIANT_NO  = $prod->PK_NO;
                        $img_lib->IS_MASTER         = 0;
                        $img_lib->F_FILE_TYPE       = 1;
                        $img_lib->FILE_EXT          = $image->getClientOriginalExtension();
                        $img_lib->RELATIVE_PATH     = '/'.$image_url;
                        $img_lib->THUMB_PATH        = '/'.$thumb_url;
                        $img_lib->SERIAL_NO         = $i;
                        $img_lib->save();
                        if($i == 0){
                            $def_relative_path      = '/media/images/products/'.$prd_no.'/'.$file_name1;
                            $def_thumb_path         = '/media/images/products/'.$prd_no.'/thumb/'.$file_name2;
                            $def_relative_id        = $img_lib->PK_NO;
                        }
                        $i++;
                    }
                    $update_prod = ProductVariant::find($prod->PK_NO);
                    $update_prod->F_PRIMARY_IMG_VARIANT_ID  = $def_relative_id ?? null;
                    $update_prod->PRIMARY_IMG_RELATIVE_PATH = $def_relative_path ?? null;
                    $update_prod->THUMB_PATH                = $def_thumb_path ?? null;
                    $update_prod->update();
            }
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            return $this->formatResponse(false, 'Product variant not created successfully!', 'admin.product.create');
        }
        DB::commit();
        return $this->formatResponse(true, 'Product variant has been created successfully !', 'admin.product.list');
    }

    public function postUpdateProductVariant($request, int $id)
    {
        // dd($id);
        $variable_array_list    = $request->variable_array_selected_list ? json_decode($request->variable_array_selected_list,true) : [];
        $features_names         = $request->features_names ? json_decode($request->features_names,true) : [];
        $vat_amount         = null;
        $roles = userRolePermissionArray();

        $prd_no = $request->pk_no;
        $vat_class = DB::table('ACC_VAT_CLASS')->where('PK_NO',$request->vat_class)->first();
        if ($vat_class){ $vat_amount = $vat_class->RATE; }
        $need_approval = [];

        DB::beginTransaction();
        try {
            $slug = Str::slug(strtolower($request->name));
            $check = ProductVariant::where('URL_SLUG',$slug)->where('PK_NO','!=',$id)->first();
            if($check){
                $slug = $slug.'-'.rand(1,999);
            }

            $prod = ProductVariant::find($id);
            $updated_data = json_decode($prod->NEED_APPROVAL,TRUE);

            if($prod->F_COLOR_NO){
                $similar_colors = ProductVariant::where('F_PRD_MASTER_SETUP_NO',$prod->F_PRD_MASTER_SETUP_NO)->where('F_COLOR_NO',$prod->F_COLOR_NO)->where('PK_NO','!=',$id)->get();
            }

            if(hasAccessAbility('product_approval', $roles)){
                $prod->IS_ACTIVE = $request->is_active;
            }else{
                $pending = 0;
                if($prod->REGULAR_PRICE != $request->price){$pending = 1; $need_approval['REGULAR_PRICE'] = $prod->REGULAR_PRICE;}
                if($prod->INSTALLMENT_PRICE != $request->price_ins){$pending = 1; $need_approval['INSTALLMENT_PRICE'] = $prod->INSTALLMENT_PRICE;}
                if($prod->BARCODE  != $request->barcode){$pending = 1; $need_approval['BARCODE'] = $prod->BARCODE;}
                $need_approval['IS_ACTIVE'] = $prod->IS_ACTIVE;

                if($pending == 1){$prod->IS_ACTIVE = 2; $prod->NEED_APPROVAL = json_encode($need_approval);}
            }
            $old_barcode = $prod->BARCODE;
            // dd($variable_array_list[$features_names[0]]);
            if (isset($features_names[0]) && isset($variable_array_list[$features_names[0]]) && $variable_array_list[$features_names[0]]['is_color'] == 1) {
                $prod->F_COLOR_NO = $variable_array_list[$features_names[0]]['attr_ids'][0];
                $prod->COLOR_NAME = $variable_array_list[$features_names[0]]['attr'][0];
            }
            if (isset($features_names[1]) && isset($variable_array_list[$features_names[1]]) && $variable_array_list[$features_names[1]]['is_color'] == 0) {
                $prod->F_SIZE_NO = $variable_array_list[$features_names[1]]['attr_ids'][0];
                $prod->SIZE_NAME = $variable_array_list[$features_names[1]]['attr'][0];
            }elseif(isset($features_names[0]) && isset($variable_array_list[$features_names[0]]) && $variable_array_list[$features_names[0]]['is_color'] == 0){
                $prod->F_SIZE_NO = $variable_array_list[$features_names[0]]['attr_ids'][0];
                $prod->SIZE_NAME = $variable_array_list[$features_names[0]]['attr'][0];
            }
            $prod->F_PRD_MASTER_SETUP_NO                = $prd_no;
            $prod->URL_SLUG                             = $slug;
            $prod->IS_BARCODE_BY_MFG                    = $request->is_barcode_by_mfg ? 1 : 0;
            $prod->NARRATION                            = $request->narration;
            $prod->SHORT_NARRATION                      = $request->short_narration;
            $prod->IS_FEATURE                           = $request->is_feature;
            $prod->PROMOTIONAL_MESSAGE                  = $request->promotional_message;
            $prod->F_PRIMARY_IMG_VARIANT_ID             = null;
            $prod->PRIMARY_IMG_RELATIVE_PATH            = null;
            if($request->submit == 'discard'){
                $prod->VARIANT_NAME                         = $updated_data['VARIANT_NAME'] ?? $request->name;
                $prod->VARIANT_NAME_BN                      = $updated_data['VARIANT_NAME_BN'] ?? $request->bn_name;
                $prod->REGULAR_PRICE                        = $updated_data['REGULAR_PRICE'] ?? $request->price;
                $prod->SPECIAL_PRICE                        = $updated_data['SPECIAL_PRICE'] ?? $request->price_special;
                $prod->INSTALLMENT_PRICE                    = $updated_data['INSTALLMENT_PRICE'] ?? $request->price_ins;
                $prod->WHOLESALE_PRICE                      = $updated_data['WHOLESALE_PRICE'] ?? $request->price_wholesale;
                $prod->MAX_ORDER                            = $updated_data['MAXIMUM_ORDER'] ?? $request->max_order_qty;

                $prod->BARCODE                              = $updated_data['BARCODE'] ?? $request->barcode;
                $prod->IS_ACTIVE                            = $updated_data['IS_ACTIVE'] ?? 1;
            }else{
                $prod->VARIANT_NAME                         = $request->name;
                $prod->VARIANT_NAME_BN                      = $request->bn_name;
                $prod->REGULAR_PRICE                        = $request->price;
                $prod->SPECIAL_PRICE                        = $request->price_special ?? $request->price;
                $prod->INSTALLMENT_PRICE                    = $request->price_ins ?? $request->price;
                $prod->WHOLESALE_PRICE                      = $request->price_wholesale ?? $request->price;
                $prod->MAX_ORDER                            = $request->max_order_qty;

                $prod->BARCODE                              = $request->barcode;
            }
            if($request->submit == 'approved'){
                $prod->IS_ACTIVE = 1;
            }

            // $prod->PREFERRED_SHIPPING_METHOD            = $request->def_shipping_method;
            $prod->F_VAT_CLASS                          = $request->vat_class;
            $prod->VAT_AMOUNT_PERCENT                   = $vat_amount;
            $prod->META_TITLE                           = $request->meta_title;
            $prod->META_KEYWARDS                        = $request->meta_keywards;
            $prod->META_DESCRIPTION                     = $request->meta_description;
            $prod->NARRATION                            = $request->def_narration;
            $prod->NARRATION_BN                         = $request->def_narration_bn;
            $prod->SHORT_NARRATION                      = $request->short_narration;
            $prod->SHORT_NARRATION_BN                   = $request->short_narration_bn;
            $prod->update();
            if ($request->file('images')) {
                $img_lib_pks = array();
                foreach($request->file('images') as $key => $image)
                {

                    $filename = pathinfo($image->getClientOriginalName())['filename'];
                    $filename = Str::slug(strtolower($filename));

                    $destinationPath1 = 'media/images/products/'.$prd_no;
                    $destinationPath2 = 'media/images/products/'.$prd_no.'/thumb';
                    if (!file_exists($destinationPath1)) {
                        mkdir($destinationPath1, 0755, true);
                    }

                    if (!file_exists($destinationPath2)) {
                        mkdir($destinationPath2, 0755, true);
                    }
                    $img = Image::make($image->getRealPath());
                    $file_unique = $filename. '-' .uniqid();
                    $file_name1 = $file_unique. '.webp';
                    $file_name2 = $file_unique. '.webp';
                    Image::make($img)->save($destinationPath1.'/'.$file_name1);
                    Image::make($img)->encode('webp', 100)->resize(150, null, function ($constraint) {
                        $constraint->aspectRatio();
                        // $constraint->upsize();
                    })->save($destinationPath2.'/'.$file_name2);
                    $image_url = $destinationPath1 .'/'. $file_name1;
                    $thumb_url = $destinationPath2 .'/'. $file_name2;
                    // dd($thumb_url);

                    $img_lib                    = new ProdImgLib();
                    $img_lib->F_PRD_VARIANT_NO  = $prod->PK_NO;
                    $img_lib->IS_MASTER         = 0;
                    $img_lib->F_FILE_TYPE       = 1;
                    $img_lib->RELATIVE_PATH     = '/'.$image_url;
                    $img_lib->THUMB_PATH        = '/'.$thumb_url;
                    $img_lib->SERIAL_NO         = $key;
                    $img_lib->save();
                    array_push($img_lib_pks,$img_lib->PK_NO);
                }
                $img_lib = ProdImgLib::select('RELATIVE_PATH','THUMB_PATH')->where('F_PRD_VARIANT_NO',$id)->orderBy('SERIAL_NO','ASC')->first();
                if ($img_lib) {
                    $prod->PRIMARY_IMG_RELATIVE_PATH = $img_lib->RELATIVE_PATH;
                    $prod->THUMB_PATH = $img_lib->THUMB_PATH;
                    $prod->update();
                }
                if(isset($similar_colors) && $similar_colors->count() > 0){
                    $toDuplicateImgLib = ProdImgLib::whereIn('PK_NO',$img_lib_pks)->get();
                    foreach ($similar_colors as $key => $value) {
                        $value->PRIMARY_IMG_RELATIVE_PATH = $img_lib->RELATIVE_PATH;
                        $value->THUMB_PATH = $img_lib->THUMB_PATH;
                        $value->update();
                        foreach($toDuplicateImgLib as $unit)
                        {
                            $new_row = $unit->replicate();
                            $new_row->F_PRD_VARIANT_NO = $value->PK_NO;
                            $new_row->save();
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            return $this->formatResponse(false, 'Product variant not updated successfully !', 'admin.product.list');
        }

        DB::commit();
        return $this->formatResponse(true, 'Product variant has been updated successfully !', 'admin.product.list');
    }

    public function getDeleteProductVariant(int $id)
    {
        DB::begintransaction();
        try {
            $product = ProductVariant::find($id)->delete();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, 'Unable to delete product variant !', 'admin.product.list');
        }

        DB::commit();

        return $this->formatResponse(true, 'Successfully delete product !', 'admin.product.list');
    }

    public function postVariantMasterSwap($request)
    {
        DB::begintransaction();

        try {
            $variant = ProductVariant::select('CODE','MKT_CODE','COMPOSITE_CODE')->where('F_PRD_MASTER_SETUP_NO',$request->master)->orderBy('CODE','DESC')->first();
            if (isset($variant) && !empty($variant)) {
                $new_code       = $variant->CODE+1;
                $new_mkt        = $variant->MKT_CODE+1;
                $new_composite  = ((int)$variant->COMPOSITE_CODE)+1;
            }else{
                $master = Product::find($request->master);
                $new_code       = 101;
                $new_mkt        = 101;
                $new_composite  = $master->COMPOSITE_CODE.$new_code;
            }

            ProductVariant::where('PK_NO',$request->variant)->update(['CODE' => $new_code,'MKT_CODE' => $new_mkt,'COMPOSITE_CODE' => $new_composite,'F_PRD_MASTER_SETUP_NO' => $request->master]);
            $ig_code = ProductVariant::select('MRK_ID_COMPOSITE_CODE')->where('PK_NO',$request->variant)->first();
            Stock::where('F_PRD_VARIANT_NO',$request->variant)->update(['IG_CODE' => $ig_code->MRK_ID_COMPOSITE_CODE,'SKUID' => $new_composite]);

        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return $this->formatResponse(false, 'Unable to update product variant !', 'admin.product.list');
        }
        DB::commit();
        return $this->formatResponse(true, 'Successfully done !', 'admin.product.list');
    }

    public function getAjaxCategoryChild($request)
    {
        DB::begintransaction();
        try {
            $subcategory = DB::table('PRD_CATEGORY')->select('PK_NO as SUBCATEGORY_ID','NAME as SUBCATEGORY_NAME','PARENT_ID')->where('IS_ACTIVE',1)->where('PARENT_ID', $request->cat_pk)->orderBy('ORDER_ID','DESC')->get();
            foreach ($subcategory as $key => $value) {
                $has_child = DB::table('PRD_CATEGORY')->where('IS_ACTIVE',1)->where('PARENT_ID', $value->SUBCATEGORY_ID)->count();
                if($has_child > 0){
                    $value->HAS_CHILD = 1;
                }else{
                    $value->HAS_CHILD = 0;
                }
            }
            if (isset($subcategory) && $subcategory->count() > 0) {
                $html = view('admin.product.cat_child_render')->withCategories($subcategory)->render();
                $resp = ['status' => 1,'html' => $html];
            }else{
                $resp = ['status' => 0];
            }
        } catch (\Exception $e) {
            DB::rollback();
            // dd($e);
            $resp = ['status' => 2];
            return $resp;
        }
        DB::commit();
        return $resp;
    }

    public function getAjaxCategoryAttr($request)
    {
        $features = array();
        $feature_names = array();
        $feature_slug = array();
        DB::begintransaction();
        try {
            $attribute = DB::table('PRD_ATTRIBUTE_RELATIONS')->select(DB::raw('(group_concat(distinct F_ATTRIBUTE_NO)) as attributes'))->where('IS_ACTIVE',1)->where('F_CATEGORY_NO', $request->category)->first();

            if(isset($attribute->attributes)){
                $array = explode(',',$attribute->attributes);
                $attributes = DB::table('PRD_ATTRIBUTE_MASTER')->select('PK_NO','NAME','TITLE','SLUG','ATTRIBUTE_TYPE','IS_REQUIRED')->whereIn('PK_NO',$array)->where('IS_ACTIVE',1)->get();
                if(isset($attributes) && !empty($attributes)){
                    foreach ($attributes as $key => $value) {
                        if ($value->ATTRIBUTE_TYPE == 2) {
                            $attribute_child = DB::table('PRD_ATTRIBUTE_CHILD')->where('F_ATTRIBUTE_MASTER',$value->PK_NO)->where('IS_ACTIVE',1)->orderBy('ORDER_NO','ASC')->pluck('VALUE','PK_NO');
                            $value->attribute_child = $attribute_child ?? '';
                        }
                    }
                }
            }
            $feature = DB::table('PRD_FEATURE_RELATIONS')->select(DB::raw('(group_concat(distinct F_FEATURE_NO)) as features'))->where('IS_ACTIVE',1)->where('F_CATEGORY_NO', $request->category)->first();

            if(isset($feature->features)){
                $array = explode(',',$feature->features);
                $features = DB::table('PRD_FEATURE_MASTER')->select('PK_NO','NAME','TITLE','IS_COLOR','FEATURE_TYPE','SLUG')->whereIn('PK_NO',$array)->where('IS_ACTIVE',1)->where('F_PARENT_NO',0)->orderBy('IS_COLOR','DESC')->get(); //COLOR_NAME,SIZE
                if(isset($features) && !empty($features)){

                    foreach ($features as $key => $value) {
                        array_push($feature_names,$value->NAME);
                        array_push($feature_slug,$value->SLUG);
                        if ($value->FEATURE_TYPE == 2) {
                            $feature_options = DB::table('PRD_FEATURE_MASTER')->where('F_PARENT_NO',$value->PK_NO)->where('IS_ACTIVE',1)->orderBy('ORDER_NO','ASC')->pluck('NAME','PK_NO')->toArray();
                            $value->feature_options = $feature_options ?? '';
                            if(isset($value->feature_options) && !empty($value->feature_options)){
                                $value->feature_child = DB::table('PRD_FEATURE_MASTER')->where('F_PARENT_NO',array_key_first($value->feature_options))->where('IS_ACTIVE',1)->orderBy('ORDER_NO','ASC')->pluck('NAME','PK_NO');
                            }
                        }elseif($value->FEATURE_TYPE == 1){
                            $value->feature_child = DB::table('PRD_FEATURE_MASTER')->where('F_PARENT_NO',$value->PK_NO)->where('IS_ACTIVE',1)->orderBy('ORDER_NO','ASC')->pluck('NAME','PK_NO');
                        }
                    }
                }
            }
            // echo '<pre>';
            // echo '======================<br>';
            // print_r($features);
            // echo '<br>======================<br>';
            // exit();
            if ((isset($attribute->attributes) && $attributes->count() > 0) || isset($feature->features) && $features->count() > 0 ) {
                $fea_html = view('admin.product.category_features')->withFeatures($features)->render();
                $attr_html = view('admin.product.category_attributes')->withAttributes($attributes ?? [])->render();
                $variant_html = view('admin.product.product_variant_generate')->withFeaturenames($feature_names)->render();
                $resp = ['status' => 1,'attributes' => $attributes ?? [],'attribute_html' => $attr_html,'features_html' => $fea_html,'features' => $features,'feature_slug' => $feature_slug,'variant_html'=>$variant_html,'feature_names'=>$feature_names];
            }else{
                $variant_html = view('admin.product.product_variant_generate')->withFeaturenames(array())->render();
                $resp = ['status' => 2,'variant_html'=>$variant_html];
            }
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            $resp = ['status' => 3];
            return $resp;
        }
        DB::commit();
        return $resp;
    }

    public function getAjaxAttrChilds($request)
    {
        DB::begintransaction();
        try {
            $attribute_childs = DB::table('PRD_ATTRIBUTE_CHILD')->select('VALUE','PK_NO')->where('F_ATTRIBUTE_MASTER',$request->attribute)->where('IS_ACTIVE',1)->orderBy('ORDER_NO','ASC')->get();

            if (isset($attribute_childs) && $attribute_childs->count() > 0) {
                $selected_tags = explode(',',$request->selected_tags);
                $html = view('admin.product.attribute_list_body')->withAttributes($attribute_childs)->withTags($selected_tags)->render();
                // echo '<pre>';
                // echo '======================<br>';
                // print_r($selected_tags);
                // echo '<br>======================<br>';
                // exit();
                $resp = ['status' => 1,'html' => $html];
            }else{
                $resp = ['status' => 0];
            }
        } catch (\Exception $e) {
            DB::rollback();
            // dd($e);
            $resp = ['status' => 2];
            return $resp;
        }
        DB::commit();
        return $resp;
    }

    public function getAjaxFeaOptions($request)
    {
        DB::begintransaction();
        try {
            $feature_options = DB::table('PRD_FEATURE_MASTER')->select('PK_NO','NAME')->where('F_PARENT_NO',$request->f_feature_master)->where('IS_ACTIVE',1)->orderBy('ORDER_NO','ASC')->get();

            if (isset($feature_options) && $feature_options->count() > 0) {
                $response = array();
                foreach($feature_options as $feature_option){
                    $response[] = array(
                        "id"=>$feature_option->PK_NO,
                        "text"=>$feature_option->NAME
                    );
                }
                $resp = ['status' => 1,'data' => $response];
            }else{
                $resp = ['status' => 1,'data' => []];
            }
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            $resp = ['status' => 2];
            return $resp;
        }
        DB::commit();
        return $resp;
    }

    public function getAjaxVariantGenerate($request)
    {
        DB::begintransaction();
        try {
            $html = [];
            $variable_array_list = $request->variable_array_list ? json_decode($request->variable_array_list,true) : [];
            $variant_combo = $request->variant_combo ? json_decode($request->variant_combo,true) : [];
            if(isset($variant_combo['combo_text']) && count($variant_combo['combo_text']) > 0){
                if ($request->type == 'add') {
                    $html[$request->to_add_array] = view('admin.product.product_variant_tbody_generate')->withName($variant_combo['combo_text'][$request->to_add_array])->withId($variant_combo['combo_combo'][$request->to_add_array])->render();

                }
            }

            $resp = ['status' => 1,'html' => $html];
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            $resp = ['status' => 2];
            return $resp;
        }
        DB::commit();
        return $resp;
    }

    public function postAjaxDeleteAddtionalCategory($request)
    {
        DB::begintransaction();
        try {
            $category_pks = array();
            $category = DB::table('PRD_CATEGORY')->select('PK_NO','PARENT_ID')->where('PK_NO',$request->cat_id)->first();
            if(isset($category)){
                for ($i=0; $i < 3; $i++) {
                    if(isset($category)){
                        if($category->PARENT_ID == 0){
                            $subcategory = DB::table('PRD_CATEGORY')->where('IS_ACTIVE',1)->where('PARENT_ID', 0)->count();
                        }else{
                            $subcategory = DB::table('PRD_CATEGORY')->where('IS_ACTIVE',1)->where('PARENT_ID', $category->PARENT_ID)->count();
                        }
                        if (isset($subcategory) && $subcategory > 0) {
                            if($i == 0){
                                $cat_array_pk = $request->cat_id;
                            }else{
                                $cat_array_pk = $category->PK_NO ?? 0;
                            }
                            array_push($category_pks,$cat_array_pk);
                        }
                        $category = DB::table('PRD_CATEGORY')->select('PARENT_ID','PK_NO')->where('PK_NO',$category->PARENT_ID)->first();
                        if(!isset($category) || empty($category)){ // parent is 0
                            $category = (object)[];
                            $category->PARENT_ID = 0;
                        }
                    }
                }
            }
            DB::table('PRD_MASTER_CATEGORY_MAP')->where('F_PRD_MASTER_SETUP_NO',$request->product_master)->whereIn('F_PRD_CATEGORY_ID',$category_pks)->delete();
            $resp = ['status' => 1];
        } catch (\Exception $e) {
            DB::rollback();
            $resp = ['status' => 0];
            return $resp;
        }
        DB::commit();
        return $resp;
    }

    public function postAjaxDeleteProductAttribute($request)
    {
        DB::begintransaction();
        try {
            DB::table('PRD_MASTER_ATTRIBUTE_RELATIONS')->where('F_PRD_MASTER_SETUP_NO',$request->product_master)->where('F_ATTRIBUTE_MASTER',$request->attribute)->delete();
            $resp = ['status' => 1];
        } catch (\Exception $e) {
            DB::rollback();
            $resp = ['status' => 0];
            return $resp;
        }
        DB::commit();
        return $resp;
    }

    public function postAjaxRefreshProductAttribute($request)
    {
        DB::begintransaction();
        try {
            $attribute = DB::table('PRD_ATTRIBUTE_RELATIONS')
            ->select(DB::raw('(group_concat(distinct F_ATTRIBUTE_NO)) as attributes'))
            ->where('IS_ACTIVE',1)
            ->where('F_CATEGORY_NO', $request->category)
            ->first();

            if(isset($attribute->attributes)){
                $array = explode(',',$attribute->attributes);
                $attributes = DB::table('PRD_ATTRIBUTE_MASTER')->select('PK_NO','NAME','TITLE','SLUG','ATTRIBUTE_TYPE','IS_REQUIRED')->whereIn('PK_NO',$array)->where('IS_ACTIVE',1)->get();
                if(isset($attributes) && !empty($attributes)){
                    foreach ($attributes as $key => $value) {
                        if ($value->ATTRIBUTE_TYPE == 2) {
                            $attribute_child = DB::table('PRD_ATTRIBUTE_CHILD')->where('F_ATTRIBUTE_MASTER',$value->PK_NO)->where('IS_ACTIVE',1)->orderBy('NAME','ASC')->pluck('VALUE','PK_NO');
                            $value->attribute_child = $attribute_child ?? '';
                        }
                    }
                }
            }
            if ((isset($attribute->attributes) && $attributes->count() > 0)) {
                $attr_html = view('admin.product.category_attributes')->withAttributes($attributes ?? [])->render();
                $resp = ['status' => 1,'attributes' => $attributes ?? [],'attribute_html' => $attr_html];
            }else{
                $resp = ['status' => 0];
            }
            // $resp = ['status' => 1];
        } catch (\Exception $e) {
            DB::rollback();
            $resp = ['status' => 0];
            return $resp;
        }
        DB::commit();
        return $resp;
    }

    public function postAjaxAddAddtionalCategory($request)
    {
        DB::begintransaction();
        try {
            if($request->status == 'update' && isset($request->prev_cat)){
                $group = ProductMasterCategoryMap::where(['F_PRD_MASTER_SETUP_NO'=>$request->product_master,'F_PRD_CATEGORY_ID'=>$request->prev_cat])->value('GROUP_ID');
                ProductMasterCategoryMap::where(['F_PRD_MASTER_SETUP_NO'=>$request->product_master,'GROUP_ID'=>$group])->delete();
            }
            $category_pks = array();
            $selected_cat_array = array();
            $data = DB::table('PRD_MASTER_CATEGORY_MAP')->where('F_PRD_MASTER_SETUP_NO',$request->product_master)->orderBy('PK_NO','DESC')->first();

            $category = DB::table('PRD_CATEGORY')->select('PK_NO','PARENT_ID')->where('PK_NO',$request->cat_id)->first();
            if(isset($category)){
                for ($i=0; $i < 3; $i++) {
                    if(isset($category)){
                        if($category->PARENT_ID == 0){
                            $subcategory = DB::table('PRD_CATEGORY')->where('IS_ACTIVE',1)->where('PARENT_ID', 0)->count();
                        }else{
                            $subcategory = DB::table('PRD_CATEGORY')->where('IS_ACTIVE',1)->where('PARENT_ID', $category->PARENT_ID)->count();
                        }
                        if (isset($subcategory) && $subcategory > 0) {
                            if($i == 0){
                                $cat_array_pk = $request->cat_id;
                                $selected = 1;
                            }else{
                                $cat_array_pk = $category->PK_NO ?? 0;
                                $selected = 0;
                            }
                            array_push($category_pks,$cat_array_pk);
                            array_push($selected_cat_array,$selected);
                        }
                        $category = DB::table('PRD_CATEGORY')->select('PARENT_ID','PK_NO')->where('PK_NO',$category->PARENT_ID)->first();
                        if(!isset($category) || empty($category)){ // parent is 0
                            $category = (object)[];
                            $category->PARENT_ID = 0;
                        }
                    }
                }
            }
            $group_id = $data->GROUP_ID+1;
            foreach ($category_pks as $key => $value) {
                if ($value > 0) {
                    $insert_category[] = [
                        'F_PRD_MASTER_SETUP_NO'          => $request->product_master,
                        'F_PRD_CATEGORY_ID'     => $value,
                        'GROUP_ID'              => $group_id,
                        'IS_SELECTED'           => $selected_cat_array[$key],
                        'SS_CREATED_ON'         => date('Y-m-d H:i:s'),
                        'F_SS_CREATED_BY'       => $data->F_SS_CREATED_BY
                    ];
                }
            }
            // dd($insert_category);
            if (isset($insert_category)) {
                ProductMasterCategoryMap::insert($insert_category);
            }
            $resp = ['status' => 1];
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            $resp = ['status' => 0];
            return $resp;
        }
        DB::commit();
        return $resp;
    }

    public function postIfMasterStore($request)
    {
        DB::begintransaction();
        try {
            if ($request->is_new == 1) {
                $master = new ProductShopMap();
                $master->F_PRD_MASTER_SETUP_NO = $request->product_id;
                $master->F_SHOP_NO = Auth::user()->SHOP_ID;
                $master->save();
                $variants = DB::table('PRD_VARIANT_SETUP')->select('PK_NO')->where('F_PRD_MASTER_SETUP_NO',$request->product_id)->where('IS_ACTIVE',1)->get();
                foreach($variants as $value){
                    $variantSetup[] = [
                        'F_PRD_MASTER_SETUP_NO'   => $request->product_id,
                        'F_PRD_VARIANT_NO'  => $value->PK_NO,
                        'F_SHOP_NO'         => Auth::user()->SHOP_ID,
                        'F_SS_CREATED_BY'   => Auth::user()->PK_NO,
                        'SS_CREATED_ON'     => date('Y-m-d H:i:s')
                    ];
                }
                ProductVariantShopMap::insert($variantSetup);
                $msg = 'Product added to store !';
                $status = 1;
            }else{
                $check = ProductVariantShopMap::where('F_PRD_MASTER_SETUP_NO',$request->product_id)->where('F_SHOP_NO',Auth::user()->SHOP_ID)->count();
                if($check > 0){
                    $msg = 'Please remove variant first !';
                    $status = 0;
                }else{
                    ProductShopMap::where('F_PRD_MASTER_SETUP_NO',$request->product_id)->where('F_SHOP_NO',Auth::user()->SHOP_ID)->delete();
                    ProductVariantShopMap::where('F_PRD_MASTER_SETUP_NO',$request->product_id)->where('F_SHOP_NO',Auth::user()->SHOP_ID)->delete();
                    $msg = 'Product removed from store !';
                    $status = 1;
                }
            }
            $resp = ['status' => $status,'msg' => $msg];
        }catch (\Exception $e) {
            DB::rollback();
            $resp = ['status' => 0,'msg' => $e->getMessage()];
            return $resp;
        }
        DB::commit();
        return $resp;
    }

    public function postIfVariantStore($request)
    {
        DB::begintransaction();
        try {
            if ($request->is_new == 1) {
                $check = ProductShopMap::where('F_PRD_MASTER_SETUP_NO',$request->product_id)->where('F_SHOP_NO',Auth::user()->SHOP_ID)->count();
                if($check == 0){
                    $msg = 'Please add product master first !';
                    $status = 0;
                }else{
                    $master = new ProductVariantShopMap();
                    $master->F_PRD_MASTER_SETUP_NO = $request->product_id;
                    $master->F_PRD_VARIANT_NO = $request->variant_id;
                    $master->F_SHOP_NO = Auth::user()->SHOP_ID;
                    $master->save();
                    $msg = 'Variant added to store !';
                    $status = 1;
                }
            }else{
                $master = ProductVariantShopMap::where('F_PRD_VARIANT_NO',$request->variant_id)->where('F_SHOP_NO',Auth::user()->SHOP_ID)->delete();
                $msg = 'Variant removed from store !';
                $status = 1;
            }
        } catch (\Exception $e) {
            DB::rollback();
            $resp = ['status' => 0,'msg' => $e->getMessage()];
            return $resp;
        }
        DB::commit();
        $resp = ['status' => $status,'msg' => $msg];
        return $resp;
    }

    public function postIfCategoryStore($request)
    {
        DB::begintransaction();
        try {
            $insert_data = [];
            if ($request->is_new == 1) {
                $parent = DB::table('PRD_CATEGORY')->select('PK_NO','PARENT_ID')->where('IS_ACTIVE',1)->where('PK_NO', $request->cat_id)->first();
                if(isset($parent) && !empty($parent)){
                    $insert_data[] = array(
                        'F_CATEGORY_NO'             => $request->cat_id,
                        'PARENT_ID'                 => $parent->PARENT_ID,
                        'F_SHOP_NO'                 => Auth::user()->SHOP_ID,
                        'F_SS_CREATED_BY'           => Auth::user()->PK_NO,
                        'SS_CREATED_ON'             => date('Y-m-d H:i:s'),
                    );
                    $parent = DB::table('PRD_CATEGORY')->select('PK_NO','PARENT_ID')->where('IS_ACTIVE',1)->where('PK_NO', $parent->PARENT_ID)->first();
                    if(isset($parent) && !empty($parent)){
                        $check = DB::table('PRD_SHOP_CATEGORY_MAP')->where('PARENT_ID', $parent->PARENT_ID)->where('F_CATEGORY_NO', $parent->PK_NO)->where('F_SHOP_NO',Auth::user()->SHOP_ID)->count();
                        if($check == 0){
                            $insert_data[] = array(
                                'F_CATEGORY_NO'             => $parent->PK_NO,
                                'PARENT_ID'                 => $parent->PARENT_ID,
                                'F_SHOP_NO'                 => Auth::user()->SHOP_ID,
                                'F_SS_CREATED_BY'           => Auth::user()->PK_NO,
                                'SS_CREATED_ON'             => date('Y-m-d H:i:s'),
                            );
                            $parent = DB::table('PRD_CATEGORY')->select('PK_NO','PARENT_ID')->where('IS_ACTIVE',1)->where('PK_NO', $parent->PARENT_ID)->first();
                            if(isset($parent) && !empty($parent)){
                                $check = DB::table('PRD_SHOP_CATEGORY_MAP')->where('PARENT_ID', $parent->PARENT_ID)->where('F_CATEGORY_NO', $parent->PK_NO)->where('F_SHOP_NO',Auth::user()->SHOP_ID)->count();
                                if($check == 0){
                                    $insert_data[] = array(
                                        'F_CATEGORY_NO'             => $parent->PK_NO,
                                        'PARENT_ID'                 => $parent->PARENT_ID,
                                        'F_SHOP_NO'                 => Auth::user()->SHOP_ID,
                                        'F_SS_CREATED_BY'           => Auth::user()->PK_NO,
                                        'SS_CREATED_ON'             => date('Y-m-d H:i:s'),
                                    );
                                    $parent = DB::table('PRD_CATEGORY')->select('PK_NO','PARENT_ID')->where('IS_ACTIVE',1)->where('PK_NO', $parent->PARENT_ID)->first();
                                    if(isset($parent) && !empty($parent)){
                                        $check = DB::table('PRD_SHOP_CATEGORY_MAP')->where('PARENT_ID', $parent->PARENT_ID)->where('F_CATEGORY_NO', $parent->PK_NO)->where('F_SHOP_NO',Auth::user()->SHOP_ID)->count();
                                        if($check == 0){
                                            $insert_data[] = array(
                                                'F_CATEGORY_NO'             => $parent->PK_NO,
                                                'PARENT_ID'                 => $parent->PARENT_ID,
                                                'F_SHOP_NO'                 => Auth::user()->SHOP_ID,
                                                'F_SS_CREATED_BY'           => Auth::user()->PK_NO,
                                                'SS_CREATED_ON'             => date('Y-m-d H:i:s'),
                                            );
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                if(count($insert_data) > 0){
                    ProductCategoryShopMap::insert($insert_data);
                }

                $msg = 'Category added to store !';
                $status = 1;
            }else{

                $delete_data = [];

    $parent = DB::table('PRD_SHOP_CATEGORY_MAP')->select('PK_NO','PARENT_ID')->where('F_CATEGORY_NO', $request->cat_id)->where('F_SHOP_NO',Auth::user()->SHOP_ID)->first(); //F_CATEGORY_NO 171 => 81(parent)
    if(isset($parent) && !empty($parent)){
        array_push($delete_data,$parent->PK_NO);
        DB::table('PRD_SHOP_CATEGORY_MAP')->where('PK_NO',$parent->PK_NO)->delete();

        $parent = DB::table('PRD_SHOP_CATEGORY_MAP')->select('PK_NO','PARENT_ID','F_CATEGORY_NO')->where('F_CATEGORY_NO', $parent->PARENT_ID)->where('F_SHOP_NO',Auth::user()->SHOP_ID)->first();// F_CATEGORY_NO 81 => 79(parent)
        if(isset($parent) && !empty($parent)){
            if ($parent->PARENT_ID == 0) {
                $check = DB::table('PRD_SHOP_CATEGORY_MAP')->where('PARENT_ID', $parent->F_CATEGORY_NO)->where('F_SHOP_NO',Auth::user()->SHOP_ID)->count();
                if($check == 0){
                    array_push($delete_data,$parent->PK_NO);
                    DB::table('PRD_SHOP_CATEGORY_MAP')->where('PK_NO',$parent->PK_NO)->delete();
                }
            }else{
                $check = DB::table('PRD_SHOP_CATEGORY_MAP')->where('PARENT_ID', $parent->F_CATEGORY_NO)->where('F_SHOP_NO',Auth::user()->SHOP_ID)->count();
                if($check == 0){
                    array_push($delete_data,$parent->PK_NO);
                    DB::table('PRD_SHOP_CATEGORY_MAP')->where('PK_NO',$parent->PK_NO)->delete();

                    $parent = DB::table('PRD_SHOP_CATEGORY_MAP')->select('PK_NO','PARENT_ID','F_CATEGORY_NO')->where('F_CATEGORY_NO', $parent->PARENT_ID)->where('F_SHOP_NO',Auth::user()->SHOP_ID)->first(); // F_CATEGORY_NO 79 => 78(parent)
                    if(isset($parent) && !empty($parent)){
                        if ($parent->PARENT_ID == 0) {
                            $check = DB::table('PRD_SHOP_CATEGORY_MAP')->where('PARENT_ID', $parent->F_CATEGORY_NO)->where('F_SHOP_NO',Auth::user()->SHOP_ID)->count();
                            if($check == 0){
                                array_push($delete_data,$parent->PK_NO);
                                DB::table('PRD_SHOP_CATEGORY_MAP')->where('PK_NO',$parent->PK_NO)->delete();
                            }
                        }else{
                            $check = DB::table('PRD_SHOP_CATEGORY_MAP')->where('PARENT_ID', $parent->F_CATEGORY_NO)->where('F_SHOP_NO',Auth::user()->SHOP_ID)->count();
                            if($check == 0){
                                array_push($delete_data,$parent->PK_NO);
                                DB::table('PRD_SHOP_CATEGORY_MAP')->where('PK_NO',$parent->PK_NO)->delete();

                                $parent = DB::table('PRD_SHOP_CATEGORY_MAP')->select('PK_NO','PARENT_ID','F_CATEGORY_NO')->where('F_CATEGORY_NO', $parent->PARENT_ID)->where('F_SHOP_NO',Auth::user()->SHOP_ID)->first();
                                if(isset($parent) && !empty($parent)){
                                    $check = DB::table('PRD_SHOP_CATEGORY_MAP')->where('PARENT_ID', $parent->F_CATEGORY_NO)->where('F_SHOP_NO',Auth::user()->SHOP_ID)->count();
                                    if($check == 0){
                                        array_push($delete_data,$parent->PK_NO);
                                        DB::table('PRD_SHOP_CATEGORY_MAP')->where('PK_NO',$parent->PK_NO)->delete();
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
                $msg = 'Category removed from store !';
                $status = 1;
            }
        } catch (\Exception $e) {
            DB::rollback();
            $resp = ['status' => 0,'msg' => $e->getMessage()];
            return $resp;
        }
        DB::commit();
        $resp = ['status' => $status,'msg' => $msg];
        return $resp;
    }

    public function getVariantByMaster($id){
        return ProductVariant::where('F_PRD_MASTER_SETUP_NO',$id)->orderBy('PK_NO','DESC')->get();
    }

    public function getVariantById($id){
        return ProductVariant::where('PK_NO',$id)->first();

    }

    public function makeCombinations($request) {
        $variable_array_list = $request->variant_combo ? json_decode($request->variant_combo,true) : [];
        // echo '<pre>';
        // echo '======================<br>';
        // print_r($variable_array_list[$request->variable_array_name[0]]['attr']);
        // echo '<br>======================<br>';
        // exit();

        // return $result;
    }

    public function postSpcatStoreAjax($request)
    {
        DB::begintransaction();
        try {
            if($request->status == 'update'){
                ProductVariantSpCategoryMap::where(['F_PRD_SPCATEGORY' => $request->previous_sp_value,'F_PRD_MASTER_SETUP_NO' => $request->product_master])->delete();
            }
            if(ProductVariantSpCategoryMap::where(['F_PRD_SPCATEGORY' => $request->spcat_id,'F_PRD_MASTER_SETUP_NO' => $request->product_master])->exists()){
                return ['status' => 2];
            }
            $variants = DB::table('PRD_VARIANT_SETUP')->select('PK_NO')->where('F_PRD_MASTER_SETUP_NO',$request->product_master)->get();
            foreach($variants as $item){
                $inset_item[] = [
                    'F_PRD_SPCATEGORY'  => $request->spcat_id,
                    'F_PRD_MASTER_SETUP_NO'      => $request->product_master,
                    'F_PRD_VARIANT'     => $item->PK_NO,
                    'SS_CREATED_ON'     => date('Y-m-d H:i:s'),
                    'F_SS_CREATED_BY'   => Auth::user()->PK_NO
                ];
            }
            ProductVariantSpCategoryMap::insert($inset_item);
            $resp = ['status' => 1];
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return ['status' => 0];
        }
        DB::commit();
        return $resp;
    }

    public function postSpcatDeleteAjax($request)
    {
        DB::begintransaction();
        try {
            DB::table('PRD_VARIANT_SPCATEGORY_MAP')->where(['F_PRD_SPCATEGORY' => $request->spcat_id,'F_PRD_MASTER_SETUP_NO' => $request->product_master])->delete();
            $resp = ['status' => 1];
        } catch (\Exception $e) {
            DB::rollback();
            return ['status' => 0];
        }
        DB::commit();
        return $resp;
    }

    public function getBrandModelByScat($scat_id) {
        $query = DB::table('PRD_MASTER_CATEGORY_MAP')
        ->select('PRD_MASTER_CATEGORY_MAP.*','PRD_MASTER_ATTRIBUTE_RELATIONS.F_ATTRIBUTE_CHILD', 'PRD_ATTRIBUTE_CHILD.VALUE as ATTRIBUTE_CHILD_VALUE')
        ->leftJoin('PRD_MASTER_ATTRIBUTE_RELATIONS', 'PRD_MASTER_ATTRIBUTE_RELATIONS.F_PRD_MASTER_SETUP_NO','PRD_MASTER_CATEGORY_MAP.F_PRD_MASTER_SETUP_NO')
        ->leftJoin('PRD_ATTRIBUTE_CHILD', 'PRD_ATTRIBUTE_CHILD.PK_NO','PRD_MASTER_ATTRIBUTE_RELATIONS.F_ATTRIBUTE_CHILD')
        ->where('PRD_MASTER_CATEGORY_MAP.F_PRD_CATEGORY_ID', $scat_id);
        $model = clone $query;

        $brand = $query->where('PRD_MASTER_ATTRIBUTE_RELATIONS.F_ATTRIBUTE_MASTER', 38)

        ->groupBy('PRD_MASTER_ATTRIBUTE_RELATIONS.F_ATTRIBUTE_CHILD')
        ->get();
        $brand_opt = '';
           if ($brand) {
              $brand_opt .= '<option value="">- Select brand -</option>';
              foreach ($brand as $value) {
                   $brand_opt .= '<option value="'.$value->F_ATTRIBUTE_CHILD.'"  title="">'.$value->ATTRIBUTE_CHILD_VALUE.'</option>';
               }
           }else{
               $brand_opt .= '<option value="">No data found</option>';
           }

         $data['brand'] = $brand_opt;
         $model = $model->where('PRD_MASTER_ATTRIBUTE_RELATIONS.F_ATTRIBUTE_MASTER', 39)
         ->groupBy('PRD_MASTER_ATTRIBUTE_RELATIONS.F_ATTRIBUTE_CHILD')
         ->get();

         $model_opt = '';
           if ($model) {
              $model_opt .= '<option value="">- Select brand -</option>';
              foreach ($model as $value) {
                   $model_opt .= '<option value="'.$value->F_ATTRIBUTE_CHILD.'"  title="">'.$value->ATTRIBUTE_CHILD_VALUE.'</option>';
               }
           }else{
               $model_opt .= '<option value="">No data found</option>';
           }
         $data['model'] = $model_opt;
         return $data;
    }



    public function storeToShop($request){

        // dd($request->all());

        DB::begintransaction();
        try {
            if(!empty($request->branch_id)) {
                if($request->master_id){
                    $count = count($request->master_id);
                }else{
                    $count = 0;
                    $request->master_id = [];
                }
                $products = $variant_stock = $variants = array();

                DB::table('PRD_SHOP_MASTER_MAP')->where('F_SHOP_NO',$request->branch_id)->whereNotIn('F_PRD_MASTER_SETUP_NO',$request->master_id)->delete();
                DB::table('PRD_SHOP_VARIANT_MAP')->where('F_SHOP_NO',$request->branch_id)->whereNotIn('F_PRD_MASTER_SETUP_NO',$request->master_id)->delete();

                for($i=0; $i<$count; $i++)
                {
                    $_check = DB::table('PRD_SHOP_MASTER_MAP')->where('F_SHOP_NO',$request->branch_id)->where('F_PRD_MASTER_SETUP_NO',$request->master_id[$i])->first();
                    if($_check == null ){
                        array_push($products, [
                            'F_PRD_MASTER_SETUP_NO' => $request->master_id[$i],
                            'F_SHOP_NO'             => $request->branch_id,
                            'IS_ADMIN_CREATED'      => 1,
                            'IS_ACTIVE'             => 1,
                            'F_SS_CREATED_BY'       => Auth::user()->PK_NO,
                            'SS_CREATED_ON'         => date("Y-m-d H:i:s"),
                          ]);
                    }

                    $rows = DB::table('PRD_VARIANT_SETUP')->select('PK_NO','F_PRD_MASTER_SETUP_NO')->where('F_PRD_MASTER_SETUP_NO',$request->master_id[$i])->get();

                        foreach($rows as $row){
                            $_check_variant = DB::table('PRD_SHOP_VARIANT_MAP')
                            ->where('F_PRD_MASTER_SETUP_NO',$request->master_id[$i])
                            ->where('F_SHOP_NO',$request->branch_id)
                            ->where('F_PRD_VARIANT_NO',$row->PK_NO)
                            ->first();

                            if($_check_variant == null){
                                array_push($variants, [
                                    'F_PRD_MASTER_SETUP_NO' => $request->master_id[$i],
                                    'F_PRD_VARIANT_NO'      => $row->PK_NO,
                                    'F_SHOP_NO'             => $request->branch_id,
                                    'IS_ADMIN_CREATED'      => 1,
                                    'IS_ACTIVE'             => 1,
                                    'F_SS_CREATED_BY'       => Auth::user()->PK_NO,
                                    'SS_CREATED_ON'         => date("Y-m-d H:i:s"),
                                  ]);
                            }

                            $check_stock = DB::table('PRD_VARIANT_STOCK_QTY')
                            ->where('F_SHOP_NO',$request->branch_id)
                            ->where('F_PRD_VARIANT_NO',$row->PK_NO)
                            ->first();
                            if($check_stock == null){
                                array_push($variant_stock, [
                                    'F_PRD_MASTER_SETUP_NO' => $request->master_id[$i],
                                    'F_PRD_VARIANT_NO'      => $row->PK_NO,
                                    'F_SHOP_NO'             => $request->branch_id,
                                    'TOTAL_FREE_STOCK'      => 0,
                                    'IS_ACTIVE'             => 1,
                                    'F_SS_CREATED_BY'       => Auth::user()->PK_NO,
                                    'SS_CREATED_ON'         => date("Y-m-d H:i:s"),
                                    ]);
                            }
                        }
                }
          }
        if(!empty($products)){
            DB::table('PRD_SHOP_MASTER_MAP')->insert($products);
        }

        if(!empty($variants)){
          DB::table('PRD_SHOP_VARIANT_MAP')->insert($variants);
        }

        if(!empty($variant_stock)){
          DB::table('PRD_VARIANT_STOCK_QTY')->insert($variant_stock);
        }

        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return $this->successResponse($e->getCode(), 'Unable to add product for the shop!', '', 0);
        }
            DB::commit();
            return $this->successResponse(200, 'Product has been added for the shop!', '', 1);

        }

        public function getShopMasterStatus($request){

        DB::beginTransaction();
        try
        {
            $shop =  ShopMaster::where('F_PRD_MASTER_SETUP_NO',$request->master_id)->where('F_SHOP_NO',$request->branch_id)->first();
            $shop->IS_ACTIVE = !$shop->IS_ACTIVE;
            $shop->SS_MODIFIED_ON = date("Y-m-d H:i:s");
            $shop->update();

            $cshop =  ShopMaster::where('F_PRD_MASTER_SETUP_NO',$request->master_id)->where('F_SHOP_NO',$request->branch_id)->first();

            if($cshop->IS_ACTIVE==1){
              $data =   DB::table('PRD_SHOP_VARIANT_MAP')
                ->where('F_PRD_MASTER_SETUP_NO',$cshop->F_PRD_MASTER_SETUP_NO)
                ->where('F_SHOP_NO',$cshop->F_SHOP_NO)
                ->update(
                    [
                        'IS_ACTIVE'=>0,
                        "SS_MODIFIED_ON" => date("Y-m-d H:i:s")
                        ]
                    );

            }else{
                $data= DB::table('PRD_SHOP_VARIANT_MAP')
                ->where('F_PRD_MASTER_SETUP_NO',$cshop->F_PRD_MASTER_SETUP_NO)
                ->where('F_SHOP_NO',$cshop->F_SHOP_NO)
                ->update(
                    [
                        'IS_ACTIVE' => 1,
                        "SS_MODIFIED_ON" => date("Y-m-d H:i:s")
                        ]
                );
            }

            }
            catch(\Exception $e)
            {
                dd($e->getMessage());
                DB::rollback();
                return $this->successResponse($e->getCode(), 'Data not found !', '', 0);
            }
            DB::commit();
            return $this->successResponse(200, 'Success !', $data, 1);

        }


        public function getShopMaster($request){
            $data = [];
            $category           = $request->category;
            $subcategory        = $request->subcategory;
            $subsubcategory     = $request->subsubcategory;
            if(!empty($subsubcategory)){
                $category_id    = $subsubcategory;
            }elseif($subcategory){
                $category_id    = $subcategory;
            }else{
                $category_id    = $category;
            }
            $sku_id             = $request->sku_id;
            $barcode            = $request->barcode;
            $brand              = $request->brand;
            $is_active          = $request->is_active;
            $branch_id            = $request->branch_id;

            DB::begintransaction();
            try {
                $data = DB::table('PRD_MASTER_SETUP as PM')->select('PM.*');
                $data->leftJoin('PRD_MASTER_CATEGORY_MAP','PRD_MASTER_CATEGORY_MAP.F_PRD_MASTER_SETUP_NO','PM.PK_NO')->orderBy('PM.DEFAULT_NAME', 'ASC');
                if(!empty($is_active)){
                    $data->where('PM.IS_ACTIVE',$is_active);
                }
                else{
                    $data->whereIn('PM.IS_ACTIVE',[0,1])
                    ->orderBy('F_PRD_CATEGORY_ID', 'ASC');
                    }
                if($category_id){
                    $data =  $data->where('PRD_MASTER_CATEGORY_MAP.F_PRD_CATEGORY_ID','=',$category_id);
                }
                if(!empty($keyword)){
                    $data->where(function ($query) use($keyword) {
                        $query->where('PM.DEFAULT_NAME', 'like', '%' . $keyword . '%');
                        $query->orWhere('PM.DEFAULT_NAME_BN', 'like', '%' . $keyword . '%');
                    });
                }
                if(!empty($brand)){
                    $data = $data->leftJoin('PRD_MASTER_ATTRIBUTE_RELATIONS','PRD_MASTER_ATTRIBUTE_RELATIONS.F_PRD_MASTER_SETUP_NO','=','PM.PK_NO')
                    ->where('PRD_MASTER_ATTRIBUTE_RELATIONS.F_ATTRIBUTE_MASTER',38)
                    ->where('PRD_MASTER_ATTRIBUTE_RELATIONS.F_ATTRIBUTE_CHILD',$brand);
                }
                $rows = $data->groupBy('PM.PK_NO')->get();
                $selected = DB::table('PRD_SHOP_MASTER_MAP')->where('F_SHOP_NO',$branch_id)->get();
                $html = view('admin.product.branch_products_view')->with('rows',$rows)->with('selected',$selected)->render();
            } catch (\Exception $e) {
                dd($e->getMessage());
                DB::rollback();
                return $this->successResponse($e->getCode(), 'Data not found !', '', 0);
            }
                DB::commit();
            return $this->successResponse(200, 'Data found !', $html, 1);
        }


        public function getProAddToShop($request)
    {
        $category = $request->category;
        $subcategory = $request->subcategory;
        $subsubcategory =$request->subsubcategory;

        if(!empty($subsubcategory)){
            $category_id = $subsubcategory;
        }elseif($subcategory){
            $category_id = $subcategory;
        }else{
            $category_id = $category;
        }
        if(Auth::user()->USER_TYPE == 10){
            $branch_id = Auth::user()->SHOP_ID;
            $data['shop_info'] = User::where('PK_NO',$branch_id)->get();
        }else{
            $branch_id = $request->branch_id;
            $data['shop_info'] = User::where('USER_TYPE',10)->where('F_PARENT_USER_ID',0)->get();
        }

        $response['shop'] = null;
        if($branch_id){
            $response['shop'] = User::find($branch_id);
        }
        $products = DB::table('PRD_MASTER_SETUP')
        ->select('PRD_MASTER_SETUP.*','PRD_SHOP_MASTER_MAP.PK_NO as PRD_SHOP_MASTER_MAP_NO')
        ->where('PRD_MASTER_SETUP.IS_ACTIVE',1)
        ->leftJoin('PRD_MASTER_CATEGORY_MAP','PRD_MASTER_CATEGORY_MAP.F_PRD_MASTER_SETUP_NO','=','PRD_MASTER_SETUP.PK_NO')
        ->orderBy('PRD_MASTER_SETUP.DEFAULT_NAME','ASC');
        if(!empty($category_id)){
            $products = $products->where('PRD_MASTER_CATEGORY_MAP.F_PRD_CATEGORY_ID',$category_id);
        }
        $products = $products->leftJoin('PRD_SHOP_MASTER_MAP', function($join) use ($branch_id)
        {
            $join->on('PRD_MASTER_SETUP.PK_NO', '=', 'PRD_SHOP_MASTER_MAP.F_PRD_MASTER_SETUP_NO');
            $join->where('PRD_SHOP_MASTER_MAP.F_SHOP_NO', '=', $branch_id);
        });
        $data['products'] = $products->groupBy('PRD_MASTER_SETUP.PK_NO')->get();
        return $this->formatResponse(true, '', 'admin', $data);
    }

        public function getVariantByMasterAj($request)
        {
            $branch_id = $request->branch_id;
            DB::begintransaction();
            try {
                $products  =  DB::table('PRD_VARIANT_SETUP')
                ->select('PRD_VARIANT_SETUP.VARIANT_NAME','PRD_VARIANT_SETUP.PK_NO','PRD_VARIANT_SETUP.THUMB_PATH','PRD_VARIANT_SETUP.F_PRD_MASTER_SETUP_NO','PRD_SHOP_VARIANT_MAP.PK_NO as PRD_SHOP_VARIANT_MAP_NO')
                ->where('PRD_VARIANT_SETUP.IS_ACTIVE',1)
                ->where('PRD_VARIANT_SETUP.F_PRD_MASTER_SETUP_NO',$request->master_id)
                ->orderBy('PRD_VARIANT_SETUP.VARIANT_NAME','ASC');
                $products = $products->leftJoin('PRD_SHOP_VARIANT_MAP', function($join) use ($branch_id)
                {
                    $join->on('PRD_VARIANT_SETUP.PK_NO', '=', 'PRD_SHOP_VARIANT_MAP.F_PRD_VARIANT_NO');
                    $join->where('PRD_SHOP_VARIANT_MAP.F_SHOP_NO', '=', $branch_id);
                });
                $products = $products->get();
                $data['shop_id'] = $branch_id;
                $data['rows'] = $products;
                $data['master_map'] = DB::table('PRD_SHOP_MASTER_MAP')->where('F_PRD_MASTER_SETUP_NO',$request->master_id)->where('F_SHOP_NO',$branch_id)->first();
                $html = view('admin.product.variant_by_master')->withData($data)->render();
            } catch (\Exception $e) {
                // dd($e->getMessage());
                DB::rollback();
                return $this->successResponse($e->getCode(), 'Data not found !', '', 0);
            }
                DB::commit();
                return $this->successResponse(200, 'Data found !', $html, 1);
        }

        public function getShopVariantStatus($request){
            DB::beginTransaction();
                try
                {
                if($request->variant_status ==1){
                    $ss_created_on = date('Y-m-d H:i:s');
                    $f_ss_created_by =Auth::id();
                    $is_admin_created = (Auth::user()->USER_TYPE == 10) ? 0 : 1;
                    ShopVariant::insert(['F_PRD_VARIANT_NO' =>$request->variant_id,'F_SHOP_NO'=>$request->branch_id,'IS_ACTIVE'=>1, 'IS_ADMIN_CREATED' => $is_admin_created, 'F_SS_CREATED_BY' => $f_ss_created_by, 'SS_CREATED_ON'=>$ss_created_on]);

                }else{
                    ShopVariant::where('F_PRD_VARIANT_NO',$request->variant_id)->where('F_SHOP_NO',$request->branch_id)->delete();
                }
                }
                catch(\Exception $e)
                {
                    DB::rollback();
                    return $this->successResponse($e->getCode(), 'Data not found !', '', 0);
                }
                DB::commit();
                return $this->successResponse(200, 'Success !', '', 1);
            }

            public function getSearchList($request)
            {
                $data = [];
                $category       = trim($request->category);
                $brand          = trim($request->brand);
                $keyword        = trim($request->keyword);
                $ig_code        = trim($request->ig_code);
                $sku_id         = trim($request->sku_id);
                $barcode        = trim($request->barcode);
                if(!empty($request->branch_id)){
                    $branch_id        = $request->branch_id;
                }else{
                    $branch_id        = 79;
                }
                try
                {
                    $data =  DB::table('PRD_SHOP_VARIANT_MAP')
                    ->select(
                        'PRD_VARIANT_SETUP.PK_NO',
                        'PRD_VARIANT_SETUP.VARIANT_NAME',
                        'PRD_VARIANT_SETUP.VARIANT_NAME_BN',
                        'PRD_VARIANT_SETUP.F_SIZE_PARENT_NAME',
                        'PRD_VARIANT_SETUP.SIZE_NAME',
                        'PRD_VARIANT_SETUP.F_COLOR_PARENT_NAME',
                        'PRD_VARIANT_SETUP.COLOR_NAME',
                        'PRD_VARIANT_SETUP.PRIMARY_IMG_RELATIVE_PATH',
                        'PRD_VARIANT_SETUP.THUMB_PATH',
                        'PRD_VARIANT_SETUP.REGULAR_PRICE',
                        'PRD_VARIANT_SETUP.SPECIAL_PRICE',
                        'PRD_VARIANT_SETUP.INSTALLMENT_PRICE',
                        'PRD_VARIANT_SETUP.WHOLESALE_PRICE',
                        'PRD_VARIANT_SETUP.MAX_ORDER','PRD_VARIANT_STOCK_QTY.TOTAL_FREE_STOCK','PRD_SHOP_VARIANT_MAP.F_PRD_VARIANT_NO')
                    ->leftJoin('PRD_VARIANT_SETUP','PRD_VARIANT_SETUP.PK_NO','=','PRD_SHOP_VARIANT_MAP.F_PRD_VARIANT_NO')
                    ->leftJoin('PRD_MASTER_SETUP','PRD_MASTER_SETUP.PK_NO','PRD_VARIANT_SETUP.F_PRD_MASTER_SETUP_NO')
                    ->leftJoin('PRD_VARIANT_STOCK_QTY','PRD_VARIANT_STOCK_QTY.F_PRD_VARIANT_NO','=','PRD_VARIANT_SETUP.PK_NO')
                    ->where('PRD_SHOP_VARIANT_MAP.F_SHOP_NO',$branch_id)
                    ->where('PRD_VARIANT_SETUP.IS_ACTIVE',1);
                    // ->get();
               if (!empty($keyword))
                {
                    // dd($name);
                    // $pieces = explode(" ", $name);
                    // if($pieces){
                    //     foreach ($pieces as $key => $piece) {
                            $data->where('PRD_VARIANT_SETUP.VARIANT_NAME', 'LIKE', '%' . $keyword . '%');
                    //     }
                    // }
                }
                if (!empty($category)){
                    $data->leftJoin('PRD_MASTER_CATEGORY_MAP', 'PRD_MASTER_CATEGORY_MAP.F_PRD_MASTER_SETUP_NO', 'PRD_MASTER_SETUP.PK_NO');
                    $data->where('PRD_MASTER_CATEGORY_MAP.F_PRD_CATEGORY_ID', '=',$category);
                }
                if (!empty($brand)){
                    $data->join('PRD_MASTER_ATTRIBUTE_RELATIONS', 'PRD_MASTER_ATTRIBUTE_RELATIONS.F_PRD_MASTER_SETUP_NO', 'PRD_MASTER_SETUP.PK_NO');
                    $data->where('PRD_MASTER_ATTRIBUTE_RELATIONS.F_ATTRIBUTE_CHILD', '=',$brand);
                }
                if (!empty($sku_id)){
                    $data->where('PRD_VARIANT_SETUP.COMPOSITE_CODE', '=',$sku_id);
                }
                if (!empty($barcode)){
                    $data->where('PRD_VARIANT_SETUP.BARCODE', '=',$barcode);
                }
                if(Auth::user()->USER_TYPE == 10){
                    $f_shop_no = Auth::user()->SHOP_ID;
                    $data->join('PRD_SHOP_VARIANT_MAP as PSHOP', 'PSHOP.F_PRD_VARIANT_NO', 'PRD_VARIANT_SETUP.PK_NO');
                    $data->where('PSHOP.F_SHOP_NO', '=',$f_shop_no);
                }
                    $rows = $data->groupBy('PRD_VARIANT_SETUP.PK_NO')->orderBy('PRD_VARIANT_SETUP.PK_NO','DESC')->paginate(20);
                    foreach ($rows as $key => $row) {
                        $stock = $this->checkProductStock($row->PK_NO,$branch_id);
                        $totalStock = $this->getVariantStaock($row->PK_NO,$branch_id);
                        if($stock){
                            $row->IS_STOCK = true;
                            $row->TOTAL_STOCK = $totalStock ?? 0;
                        }
                        else{
                            $row->IS_STOCK = false;
                            $row->TOTAL_STOCK = 0;
                        }
                    }
                    // dd($rows);
                    $_data['html'] = view('admin.cart._product')->withData($rows)->render();
                    $_data['rows'] = $rows;
                    }
                catch(\Exception $e)
                {
                    dd($e->getMessage());
                    return $this->successResponse(200, 'Data not found !', '', 0);
                }
                return $this->successResponse(200, 'Success !', $_data, 1);
            }

}
