<?php

use App\Models\City;
use App\Models\Brand;
use App\Models\State;
use App\Models\Hscode;
use App\Models\Country;
use App\Models\Product;
use App\Models\Category;
use App\Models\VatClass;
use App\Models\AdminUser;
use App\Models\SubCategory;
use App\Models\Auth as CustomAuth;
use App\Models\ProductVariant;

if (!function_exists('getWebSettings')) {
    function getWebSettings() {
    return DB::table('WEB_SETTINGS')->first();
    }
}

if (!function_exists('getAuthId')) {

    function getAuthId()
    {
        if (Auth::user()) {
            $user_session = Auth::user();
            return $user_session->PK_NO;
        }
    }
}

if (!function_exists('userRolePermissionArray')) {
    function userRolePermissionArray() {
        $roles = DB::table('SA_ROLE_DTL')
            ->select('SA_ROLE_DTL.PERMISSIONS')
            ->join('SA_USER_GROUP_ROLE', 'SA_USER_GROUP_ROLE.F_ROLE_NO', 'SA_ROLE_DTL.F_ROLE_NO')
            ->join('SA_USER_GROUP_USERS','SA_USER_GROUP_USERS.F_GROUP_NO', 'SA_USER_GROUP_ROLE.F_USER_GROUP_NO')
            ->where('SA_USER_GROUP_USERS.F_USER_NO', getAuthId())
            ->first();

        if (! empty($roles)) {
            return explode(",", $roles->PERMISSIONS);
        }
        return [];
    }
}

if (!function_exists('hasRoleToThisUser')) {
    function hasRoleToThisUser($user_id)
    {
        return DB::table('SA_USER_GROUP_USERS')
                ->join('SA_USER_GROUP_ROLE','SA_USER_GROUP_ROLE.F_USER_GROUP_NO','SA_USER_GROUP_USERS.F_GROUP_NO')
                ->where('SA_USER_GROUP_USERS.F_USER_NO', $user_id)
                ->value('SA_USER_GROUP_ROLE.F_ROLE_NO');
    }
}

if (!function_exists('getCategoryChain')) {
    function getCategoryChain($prd_master_id)
    {
        $html = null;
        $cat = DB::table('PRD_MASTER_CATEGORY_MAP')->select('PRD_CATEGORY.PK_NO','PRD_CATEGORY.PARENT_ID','PRD_CATEGORY.NAME','PRD_CATEGORY.BN_NAME')
        ->join('PRD_CATEGORY', 'PRD_CATEGORY.PK_NO', 'PRD_MASTER_CATEGORY_MAP.F_PRD_CATEGORY_ID')
        ->where('PRD_MASTER_CATEGORY_MAP.F_PRD_MASTER_SETUP_NO',$prd_master_id)
        ->orderBy('PRD_CATEGORY.PARENT_ID', 'ASC')
        ->get();

        if($cat && count($cat) > 0){
            $abc = count($cat) - 1;
            foreach($cat as $k => $val){
                $html .= $val->NAME;
                if($k < $abc){
                    $html .= ' > ';
                }

            }
        }
        return $html;

    }
}


if (!function_exists('getModelName')) {
    function getModelName($F_PRD_MASTER_NO) {
        $model = DB::table('PRD_MASTER_ATTRIBUTE_RELATIONS')->where('PRD_MASTER_ATTRIBUTE_RELATIONS.F_PRD_MASTER_SETUP_NO',$F_PRD_MASTER_NO)
        ->select('PRD_ATTRIBUTE_CHILD.VALUE as BRAND_NAME')
        ->where('PRD_MASTER_ATTRIBUTE_RELATIONS.F_ATTRIBUTE_MASTER',39)
        ->leftJoin('PRD_ATTRIBUTE_CHILD','PRD_ATTRIBUTE_CHILD.PK_NO', 'PRD_MASTER_ATTRIBUTE_RELATIONS.F_ATTRIBUTE_CHILD')
        ->first();
        return $model->BRAND_NAME ?? '';
    }
}

if (!function_exists('getBrandName')) {
    function getBrandName($F_PRD_MASTER_NO) {

        $brand = DB::table('PRD_MASTER_ATTRIBUTE_RELATIONS')->where('PRD_MASTER_ATTRIBUTE_RELATIONS.F_PRD_MASTER_SETUP_NO',$F_PRD_MASTER_NO)
        ->select('PRD_ATTRIBUTE_CHILD.VALUE as BRAND_NAME')
        ->where('PRD_MASTER_ATTRIBUTE_RELATIONS.F_ATTRIBUTE_MASTER',38)
        ->leftJoin('PRD_ATTRIBUTE_CHILD','PRD_ATTRIBUTE_CHILD.PK_NO', 'PRD_MASTER_ATTRIBUTE_RELATIONS.F_ATTRIBUTE_CHILD')
        ->first();
        return $brand->BRAND_NAME ?? '';

    }
}

if (!function_exists('hasAccessAbility')) {
    function hasAccessAbility($permission_slug, $permission_array) {
        // if (Auth::user()) {
        //     if(isset(Auth::user()->USER_TYPE) && (Auth::user()->USER_TYPE == 10) && (Auth::user()->FK_PARENT_USER_NO == 0)){
        //         return true;
        //     }
        // }

        $user_id = getAuthId();

        if ($user_id == 1) return true;

        $role_id = hasRoleToThisUser($user_id);

        if ($role_id == 1) return true;

        if (! empty($permission_slug) && ! empty($permission_array)) {
            if (in_array($permission_slug, $permission_array)) {
                return true;
            }
        }

        return false;
    }
}
/*
*user type (Admin/seller)
*/
if (!function_exists('getUserType')){
    function getUserType(){

        if (Auth::user()) {
            if(isset(Auth::user()->USER_TYPE) && (Auth::user()->USER_TYPE == 10)){
                return 'seller';
            }else{
                return 'admin';
            }
        }

    }
}

/*
 *PHP Array into a PHP Object
 */
if (!function_exists('array_to_object')) {
    function array_to_object($array) {
        return (object) $array;
    }
}

/*
 *PHP Object into a PHP Array
 */
if (!function_exists('object_to_array')) {
    function object_to_array($object) {
        return (array) $object;
    }
}
/*Print+Exit = print */
if (!function_exists('prixt')) {

    function prixt($data, $exit = 0)
    {
        echo "<pre>";
        print_r($data);
        if($exit == 1)
        {
            exit;
        }
    }
}

/*Print Validation Error List*/
if (!function_exists('vError')) {

    function vError($errors)
    {
        if ($errors->any()){
            foreach ($errors->all() as $error){
                echo '<li class="text-danger">'. $error .'</li>';
            }
        }
        else {
            echo 'Not found any validation error';
        }

    }
}

if (!function_exists('get_error_response')) {

    function get_error_response($code, $reason, $errors = [],  $error_as_string = '', $description = '')
    {
        if ($error_as_string == '') {
            $error_as_string = $reason;
        }

        if ($description == '') {
            $description = $reason;
        }

        return [
            'code'          => $code,
            'errors'        => $errors,
            'error_as_string'  => $error_as_string,
            'reason'        => $reason,
            'description'   => $description,
            'error_code'    => $code,
            'link'          => ''
        ];
    }
}


if (!function_exists('getCategorCombo')) {
    function getCategorCombo() {
       return Category::where('PARENT_ID',0)->pluck('NAME', 'PK_NO');

    }
}

if (!function_exists('getSubCategorCombo')) {
    function getSubCategorCombo($category_id =  null) {
        if($category_id){
            return Category::where(['PARENT_ID' => $category_id])->pluck('NAME', 'PK_NO');
        }else{
            return [];
        }
    }
}

if (!function_exists('getBrandCombo')) {
    function getBrandCombo() {
       return DB::table('PRD_ATTRIBUTE_CHILD')->where('F_ATTRIBUTE_MASTER',38)->pluck('VALUE','PK_NO');
    }
}

if (!function_exists('getVatClassCombo')) {
    function getVatClassCombo() {
       return VatClass::where('IS_ACTIVE',1)->pluck('NAME', 'RATE');
    }
}


if (!function_exists('getHScodeCombo')) {
    function getHScodeCombo($subcat_id) {
       return Hscode::where(['F_PRD_SUB_CATEGORY_NO' => $subcat_id])->pluck('CODE', 'PK_NO');
    }
}

if(!function_exists('getVariantName')){
    function getVariantName($booking_no) {
       return  DB::SELECT("select INV_STOCK.PRD_VARINAT_NAME,count(*) as ORD_QTY from
        SLS_BOOKING_DETAILS, INV_STOCK
        where SLS_BOOKING_DETAILS.F_BOOKING_NO = $booking_no
        and INV_STOCK.PK_NO = SLS_BOOKING_DETAILS.F_INV_STOCK_NO
        group by INV_STOCK.F_PRD_VARIANT_NO");
    }
}

if (!function_exists('getCityName')) {
    function getCityName($id) {
        $city_name = City::select('CITY_NAME')->where('PK_NO',$id)->first();
       return $city_name->CITY_NAME;

    }
}

if (!function_exists('getStateName')) {
    function getStateName($id) {
       $state_name = State::select('STATE_NAME')->where('PK_NO',$id)->first();
       return $state_name->STATE_NAME;
    }
}

if (!function_exists('getCountryName')) {
    function getCountryName($id) {
        $country_name = Country::select('NAME')->where('PK_NO',$id)->first();
       return $country_name->NAME;
    }
}

if (!function_exists('getPendingProduct')) {
    function getPendingProduct() {
        return Product::where('IS_ACTIVE',2)->count();

    }
}
if (!function_exists('getPendingVariant')) {
    function getPendingVariant() {
        return ProductVariant::where('IS_ACTIVE',2)->count();

    }
}

if (!function_exists('getHomeSetting')) {
    function getHomeSetting($type) {
        return DB::table('WEB_HOME_PAGE_SETTING')->where('SECTION_TYPE',$type)->first();
    }
}


if (!function_exists('getSingleData')) {
    function getSingleData($table,$condition = array()) {
        return DB::table($table)->where($condition)->first();
    }
}

if (!function_exists('getOptionsData')) {
    function getOptionsData($table,$condition=array(),$key,$value) {
        return DB::table($table)->where($condition)->orderBy($value, 'ASC')->pluck($value,$key);
    }
}

if (!function_exists('getMultipleData')) {
    function getMultipleData($table,$condition = array(),$select = null, $orderBy = null) {
        return DB::table($table)->where([$condition])->select($select)->orderBy($orderBy)->get();
    }
}
if (!function_exists('getOrderDeliveryCost')) {
    function getOrderDeliveryCost($order_value,$branch_id) {
        $branch  = DB::table('SLS_POSTAGE_COST')->select('AMOUNT')->where('F_SHOP_NO',$branch_id)->where('STATUS',1)
        ->where('FROM_PRICE','<=',$order_value)
        ->where('TO_PRICE','>=',$order_value)
        ->first();
        if($branch){
           return $branch->AMOUNT;
        }else{
            return 0;
        }
    }
}

if (!function_exists('helpCustomerAddress')) {
    function helpCustomerAddress($cust_id) {
        return DB::table('SLS_CUSTOMERS_ADDRESS')->where('F_CUSTOMER_NO',$cust_id)
        ->where('IS_DEFAULT',1)
        ->where('IS_ACTIVE',1)
        ->first();

    }
}
if (!function_exists('booking_status_edit')) {
    function booking_status_edit($current_status) {
        // 10 - Ordered,
        // 20 - Cancel request
        // 30 - Cancelled
        // 50 - Confirmed
        // 70 - Ready to Dispatch
        // 80 - Dispatched
        // 90 - Delivered
        // 100 - Customer Acknowladged
        // 110 - Customer Returned

        $res = [];
        if($current_status == 10 ){
            $res['10'] = 'Ordered';
            $res['30'] = 'Cancelled';
            $res['50'] = 'Confirmed';
        }
        if($current_status == 20 ){
            $res['20'] = 'Cancel request';
            $res['30'] = 'Cancelled';
        }
        if($current_status == 30 ){
            $res['30'] = 'Cancelled';
        }
        if($current_status == 50 ){
            $res['50'] = 'Confirmed';
            $res['30'] = 'Cancelled';
            $res['70'] = 'Ready to Dispatch';
        }
        if($current_status == 70 ){
            $res['70'] = 'Ready to Dispatch';
            $res['80'] = 'Dispatched';
            $res['30'] = 'Cancelled';
        }
        if($current_status == 80 ){
            $res['80'] = 'Dispatched';
            $res['90'] = 'Delivered';
        }

        if($current_status == 90 ){
            $res['90'] = 'Delivered';
            $res['110'] = 'Customer Returned';
        }
        if($current_status == 100 ){
            $res['100'] = 'Customer Acknowladged';
            $res['110'] = 'Customer Returned';
        }
        if($current_status == 110 ){
            $res['110'] = 'Customer Returned';
        }

        return $res;

    }
}

if (!function_exists('fileExit')) {
    function fileExit($path) {
        if($path){
            $ppath = public_path($path);
            if(file_exists($ppath)){
              return asset($path);
            } else {
                return asset('assets/images/no-photo.png');
           }
        }else{
            return asset('assets/images/no-photo.png');
        }

    }
}



