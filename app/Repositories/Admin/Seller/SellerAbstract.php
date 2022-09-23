<?php
namespace App\Repositories\Admin\Seller;

use DB;
use App\Models\Area;
use App\Models\City;
use App\Models\State;
use App\Models\Seller;
use App\Models\Vendor;
use App\Models\AreaMap;
use App\Models\Customer;
use App\Models\SellerArea;
use App\Traits\ApiResponse;
use App\Models\OrderPayment;
use App\Traits\RepoResponse;
use App\Models\AuthUserGroup;
use App\Models\CustomerAddress;
use App\Models\PaymentReseller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class SellerAbstract implements SellerInterface
{
    use RepoResponse;
    use ApiResponse;
    protected $seller;
    public function __construct(Seller $seller)
    {
        $this->seller = $seller;
    }

    public function getPaginatedList($request, int $per_page = 5)
    {

        $data = $this->seller->sortable()->where(['USER_TYPE' => 10, 'F_PARENT_USER_ID' => 0])->orderBy('NAME', 'ASC')->paginate(50);
        foreach ($data as $key => $value) {
            $value->area = DB::table('SS_SHOP_AREA_COVERAGE')->where('F_SHOP_NO',$value->PK_NO)->get();
        }

        // dd($data);

        return $this->formatResponse(true, '', 'admin.seller.index', $data);
    }
    public function getSellerUser($id)
    {

        $data = $this->seller->sortable()
        ->select('SA_USER.*','SA_USER_GROUP_USERS.F_GROUP_NO','SA_USER_GROUP.GROUP_NAME')
        ->where(['SA_USER.F_PARENT_USER_ID' => $id, 'SA_USER.USER_TYPE' => 10])
        ->where('SA_USER.F_PARENT_USER_ID', '>', 0)
        ->leftJoin('SA_USER_GROUP_USERS', 'SA_USER_GROUP_USERS.F_USER_NO','SA_USER.PK_NO')
        ->leftJoin('SA_USER_GROUP', 'SA_USER_GROUP.PK_NO','SA_USER_GROUP_USERS.F_GROUP_NO')
        ->paginate(50);
        // dd($data);
        return $this->formatResponse(true, '', 'admin.seller.index', $data);
    }


    public function getShow(int $id)
    {
        $data['seller'] = Seller::find($id);
        // $data['address'] = DB::table('SLS_CUSTOMERS_ADDRESS')->where('F_SHOP_NO',$id)->where('F_ADDRESS_TYPE_NO',2)->first();
        if (!empty($data)) {
            return $this->formatResponse(true, 'Data found', 'admin.seller.edit', $data);
        }
        return $this->formatResponse(false, 'Did not found data !', 'admin.seller.list', null);
    }
    public function postStore($request)
    {
        $auth_id = Auth::id();
        DB::beginTransaction();
            try {
                $mobile = (int)$request->phone;
                $seller                       = new Seller();
                $seller->NAME             = str_replace("’","'",$request->name);
                $seller->SHOP_NAME            = str_replace("’","'",$request->name);
                $seller->MOBILE_NO            = $mobile;
                $seller->EMAIL                = $request->email;
                $seller->PASSWORD             = Hash::make($request->password);
                $seller->STATUS               = 1;
                $seller->USER_TYPE            = 10;
                $seller->UPDATED_BY           = $auth_id;
                $seller->UPDATED_AT           = date('Y-m-d H:i:s');
                $seller->save();
                Seller::where('PK_NO',$seller->PK_NO)->update(['SHOP_ID' => $seller->PK_NO]);

            } catch (\Exception $e) {
                DB::rollback();
                return $this->formatResponse(false, $e->getMessage(), 'admin.seller.list');
            }
        DB::commit();
        return $this->formatResponse(true, 'Reseller has been created successfully !', 'admin.seller.list',$seller);
    }

    public function postSellerUser($request)
    {
        $auth_id = Auth::id();
        $shop_id = $request->seller_id;
        DB::beginTransaction();
            try {
                $mobile = (int)$request->mobile_no;
                if($request->user_id){
                    $seller                   = Seller::find($request->user_id);
                    if($request->password){
                        $seller->PASSWORD     = Hash::make($request->password);
                    }
                    $seller->UPDATED_BY       = $auth_id;
                    $seller->UPDATED_AT       = date('Y-m-d H:i:s');
                    $txt = 'Seller user has been updated successfully !';

                }else{
                    $seller                   = new Seller();
                    $seller->PASSWORD         = Hash::make($request->password);
                    $seller->CREATED_BY       = $auth_id;
                    $seller->CREATED_AT       = date('Y-m-d H:i:s');
                    $txt = 'Seller user has been created successfully !';
                }

                $seller->NAME             = str_replace("’","'",$request->name);
                $seller->MOBILE_NO            = $mobile;
                $seller->DESIGNATION          = $request->designation;
                // $seller->F_USER_GROUP_NO      = $request->user_group_id;
                $seller->F_PARENT_USER_ID     = $shop_id;
                $seller->EMAIL                = $request->email;
                $seller->STATUS               = $request->status;
                $seller->USER_TYPE            = 10;
                $seller->SHOP_ID              = $shop_id;
                $seller->save();

                $check_user_role =  AuthUserGroup::where('F_USER_NO',$seller->PK_NO)->first();
                // dd($check_user_role);
                if($check_user_role){
                    $check_user_role->F_GROUP_NO   = $request->user_group_id;
                    $check_user_role->update();
                }else{
                    $roleAuth               = new AuthUserGroup();
                    $roleAuth->F_USER_NO    = $seller->PK_NO;
                    $roleAuth->F_GROUP_NO   = $request->user_group_id;
                    $roleAuth->save();
                }


            } catch (\Exception $e) {
                DB::rollback();
                return $this->formatResponse(false, $e->getMessage(), 'admin.seller.list');
            }
        DB::commit();
        return $this->formatResponse(true, $txt, 'admin.seller.list',$seller);
    }


    public function postUpdate($request, $PK_NO)
    {
        $auth_id = Auth::id();
        DB::beginTransaction();
            try {
                if($request->tab == 'two'){
                    $mobile = (int)$request->phone;
                    $data = [
                        'NAME'              => str_replace("’","'",$request->name),
                        'MOBILE_NO'             => $mobile,
                        'EMAIL'                 => $request->email,
                        'UPDATED_BY'            => $auth_id,
                        'UPDATED_AT'            => date('Y-m-d H:i:s'),
                    ];
                    if($request->password){
                        $data['PASSWORD']             = Hash::make($request->password);
                    }
                    DB::table('SA_USER')->where('PK_NO',$PK_NO)->update($data);
                }

                if($request->tab == 'three'){
                    $data = [
                        'SELLER_NO'         => $PK_NO,
                        'OWNER_NAME'        => $request->legal_name,
                        'SHOP_NAME'         => $request->shop_name,
                        'ADDRESS1'          => $request->address1,
                        'ADDRESS2'          => $request->address2,
                        'INCHARGE_NAME'     => $request->in_charge,
                        'BUSINESS_REGI_NO'  => $request->registration_no,
                        'TIN_NO'            => $request->seller_tin,
                        'COUNTRY_NO'        => $request->legal_name,
                        'DIVISION_NO'       => $request->state,
                        'CITY_NO'           => $request->city,
                        'POST_CODE'         => $request->post_code,
                        'F_SS_MODIFIED_BY'  => $auth_id,
                        'SS_MODIFIED_ON'    => date('Y-m-d H:i:s'),
                    ];

                    if($request->hasFile('registration_file')){
                        $doc_data = [];
                        $allowedfileExtension=['pdf','jpg','png','docx'];
                        $files = $request->file('registration_file');
                        foreach($files as $k => $file){
                            $filename = $file->getClientOriginalName();
                            $extension = $file->getClientOriginalExtension();
                            $check = in_array($extension,$allowedfileExtension);

                            if($check){
                                $fileNameString = pathinfo($filename,PATHINFO_FILENAME);
                                $fileNameString = strtolower(str_replace(' ', '_', $fileNameString));
                                if(count($files)>0){
                                    $fileNameString = $fileNameString.'_'.$k;
                                }
                                $name = $fileNameString.'.'.$file->extension();
                                $path = '/media/business_doc/'.$PK_NO.'/'.$name;
                                $file->move(public_path().'/media/business_doc/'.$PK_NO.'/', $name);
                                $doc_data[$k] = [
                                    'SELLER_NO'         => $PK_NO,
                                    'DOC_TYPE'          => 'Business Document',
                                    'NAME'              => $name,
                                    'PATH'              => $path,
                                    'EXT'               => $extension,
                                    'F_SS_MODIFIED_BY'  => $auth_id,
                                    'SS_MODIFIED_ON'    => date('Y-m-d H:i:s'),
                                    'IS_ACTIVE'         => 1,
                                ];
                            }
                        }
                        if(!empty($doc_data)){
                            DB::table('SELLER_BUSINESS_DOC')->insert($doc_data);
                        }
                    }
                    $check = DB::table('SELLER_BUSINESS_INFO')->where('SELLER_NO',$PK_NO)->first();
                    if($check){
                        //update
                        DB::table('SELLER_BUSINESS_INFO')->where('SELLER_NO',$PK_NO)->update($data);
                    }else{
                        //insert
                        DB::table('SELLER_BUSINESS_INFO')->insert($data);
                    }
                    DB::table('SA_USER')->where('PK_NO',$PK_NO)->update(['SHOP_NAME' => $request->shop_name]);
                }
                if($request->tab == 'four'){
                    $data = [
                        'SELLER_NO'         => $PK_NO,
                        'ACC_TITLE'         => $request->account_title,
                        'ACC_NO'            => $request->account_no,
                        'BANK_NAME'         => $request->bank_name,
                        'BRANCH_NAME'       => $request->branch_name,
                        'ROUTING_NO'        => $request->routing_number,
                        'F_SS_MODIFIED_BY'  => $auth_id,
                        'SS_MODIFIED_ON'    => date('Y-m-d H:i:s'),
                    ];
                    $check = DB::table('SELLER_BANK_INFO')->where('SELLER_NO',$PK_NO)->first();
                    if($check){
                        //update
                        DB::table('SELLER_BANK_INFO')->where('SELLER_NO',$PK_NO)->update($data);
                    }else{
                        //insert
                        DB::table('SELLER_BANK_INFO')->insert($data);
                    }
                }

                if($request->tab == 'complete'){
                    $data = [
                        'SELLER_NO'         => $PK_NO,
                        'WAREHOUSE_NAME'    => $request->warehouse_name,
                        'ADDRESS1'          => $request->address,
                        'COUNTRY_NO'        => $request->country,
                        'DIVISION_NO'       => $request->state,
                        'CITY_NO'           => $request->city,
                        'POST_CODE'         => $request->post_code,
                        'PHONE_NO'          => $request->phone_no,
                        'F_SS_MODIFIED_BY'  => $auth_id,
                        'SS_MODIFIED_ON'    => date('Y-m-d H:i:s'),
                    ];
                    $check = DB::table('SELLER_WAREHOUSE_INFO')->where('SELLER_NO',$PK_NO)->first();
                    if($check){
                        //update
                        DB::table('SELLER_WAREHOUSE_INFO')->where('SELLER_NO',$PK_NO)->update($data);
                    }else{
                        //insert
                        DB::table('SELLER_WAREHOUSE_INFO')->insert($data);
                    }
                }

            } catch (\Exception $e) {
                DB::rollback();
                return $this->formatResponse(false, $e->getMessage(), 'admin.seller.list');
            }
            DB::commit();
            $route = 'admin.seller.list';
            return $this->formatResponse(true, 'seller Informstion has been Updated successfully',$route);
    }

    public function delete($PK_NO)
    {
        $seller = Seller::where('PK_NO',$PK_NO)->first();
        $seller->IS_ACTIVE = 0;
        if ($seller->update()) {
            return $this->formatResponse(true, 'Successfully deleted Reseller Account', 'admin.reseller.list');
        }
        return $this->formatResponse(false,'Unable to delete Reseller Account','admin.reseller.list');
    }


    public function postSellerAreaStore($request)
    {
        $data = [];
        // dd($request->all());
        $auth_id = Auth::id();
        DB::beginTransaction();
            try {
                $state  = State::find($request->region);
                $city   = City::find($request->city);
                $area   = Area::find($request->area);
                $store  = Seller::find($request->id);
                if (!empty($request->subarea))
                {
                    $area_id = array();
                    foreach ($request->subarea as $value)
                    {
                        $area_id[] = $value;
                    }
                    $area_id = array_unique($area_id);

                    $data = array();
                    foreach ($area_id as $key => $value)
                    {
                        $sub_area = AreaMap::find($value);

                        // dd($sub_area);

                        $checkDuplicate = SellerArea::where('F_SUB_AREA_NO',$value)->where('F_SHOP_NO',$request->id)->first();
                        $checkExist = SellerArea::where('F_SUB_AREA_NO',$value)->where('F_SHOP_NO','!=',$request->id)->first();
                        if($checkExist){

                            return $this->successResponse(200, 'This area already assigned other shop !', '', 0);
                        }
                        if(is_null($checkDuplicate)){
                        array_push($data, [
                            'F_COUNTRY_NO' => 1,
                            'F_STATE_NO' => $request->region,
                            'STATE_NAME' => $state->STATE_NAME,
                            'F_CITY_NO' => $request->city,
                            'CITY_NAME' => $city->CITY_NAME,
                            'F_AREA_NO' => $request->area,
                            'AREA_NAME' => $area->AREA_NAME,
                            'F_SUB_AREA_NO' => $value,
                            'SUB_AREA_NAME' => $sub_area->SUB_AREA_NAME,
                            'F_SHOP_NO' => $store->PK_NO,
                            'SHOP_NAME' => $store->SHOP_NAME ?? NULL,
                            'F_SS_CREATED_BY' => Auth::id(),
                            'F_SS_MODIFIED_BY' => NULL,
                            'SS_MODIFIED_ON' => NULL,
                            'SS_CREATED_ON' => date('Y-m-d H:i:s'),
                            ]
                        );
                        }
                    }
                    DB::table('SS_SHOP_AREA_COVERAGE')->insert($data);
                }

            } catch (\Exception $e) {
                dd($e->getMessage());
                DB::rollback();
                return $this->successResponse($e->getCode(), 'Area not saved !', '', 0);
            }
                DB::commit();
            return $this->successResponse(200, 'Area sucessfully save!', $data, 1);
     }


    public function businesDocDelete($PK_NO)
    {
        $doc = DB::table('SELLER_BUSINESS_DOC')->where('PK_NO',$PK_NO)->first();
        if ($doc){
            DB::table('SELLER_BUSINESS_DOC')->where('PK_NO',$PK_NO)->delete();
            File::delete(public_path($doc->PATH));
            return $this->formatResponse(true, 'Successfully deleted doc file', 'admin.seller.list');
        }
        return $this->formatResponse(false,'Unable to delete doc file','admin.seller.list');
    }



    public function getSellerHistory($id)
    {
        try {

        $result = DB::SELECT("SELECT result.* FROM (
            SELECT o.PK_NO as ORDER_PK_NO, o.F_SHOP_NO, o.RESHOP_NAME, o.ORDER_ACTUAL_TOPUP, o.ORDER_BUFFER_TOPUP, o.ORDER_BALANCE_RETURN, o.DISPATCH_STATUS, b.PK_NO AS BOOKING_PK_NO, b.BOOKING_NO, DATE(b.CONFIRM_TIME) as ORDER_DATE, SUM(IFNULL(b.TOTAL_PRICE,0) - b.DISCOUNT + IFNULL(b.PENALTY_FEE,0) - IFNULL(b.CUSTOMER_POSTAGE,0)) AS ORDER_PRICE, b.DISCOUNT AS ORDER_DISCOUNT, SUM(IFNULL(b.TOTAL_PRICE,0) - b.DISCOUNT - o.ORDER_ACTUAL_TOPUP + IFNULL(b.PENALTY_FEE,0)  - IFNULL(b.CUSTOMER_POSTAGE,0) ) AS ORDER_DUE, b.PENALTY_FEE, b.BOOKING_STATUS, o.IS_CANCEL,DATE(b.CONFIRM_TIME) as DATE_AT, NULL AS PAY_PK_NO, NULL AS PAYMENT_NO, NULL AS PAY_AMOUNT, NULL AS REFUND_MAPING, NULL AS PAYMENT_REMAINING_MR, NULL as TX_PK_NO, NULL AS PAYMENT_VERIFY, NULL AS F_BOOKING_NO_FOR_PAYMENT_TYPE3, NULL AS RETURN_PRICE, b.F_SS_CREATED_BY AS ENTRY_BY_NO, u.NAME as ENTRY_BY_NAME, b.SS_CREATED_ON as ENTRY_AT, 1 AS  ORDER_ID, 'Order Placed' AS TYPE  FROM SLS_ORDER as o JOIN SLS_BOOKING AS b ON b.PK_NO = o.F_BOOKING_NO LEFT JOIN SA_USER as u ON u.PK_NO = b.F_SS_CREATED_BY WHERE o.F_SHOP_NO = $id GROUP BY o.PK_NO

            UNION

            SELECT NULL as ORDER_PK_NO, cp.F_SHOP_NO, cp.RESHOP_NAME, NULL AS ORDER_ACTUAL_TOPUP, NULL AS ORDER_BUFFER_TOPUP, NULL AS ORDER_BALANCE_RETURN, NULL AS DISPATCH_STATUS, NULL AS BOOKING_PK_NO, NULL AS BOOKING_NO, NULL AS ORDER_DATE, NULL AS ORDER_PRICE, NULL AS ORDER_DISCOUNT, NULL AS ORDER_DUE, NULL AS PENALTY_FEE, NULL AS BOOKING_STATUS, NULL AS IS_CANCEL, cp.PAYMENT_DATE as DATE_AT, cp.PK_NO AS PAY_PK_NO, t.CODE AS PAYMENT_NO, cp.MR_AMOUNT AS PAY_AMOUNT, cp.REFUND_MAPING, cp.PAYMENT_REMAINING_MR, t.PK_NO as TX_PK_NO, t.IS_MATCHED AS PAYMENT_VERIFY,cp.F_BOOKING_NO_FOR_PAYMENT_TYPE3, NULL AS RETURN_PRICE, cp.F_SS_CREATED_BY AS ENTRY_BY_NO, u.NAME as ENTRY_BY_NAME, cp.SS_CREATED_ON as ENTRY_AT, 3 AS ORDER_ID, 'Payment' AS TYPE FROM ACC_RESELLER_PAYMENTS AS cp LEFT JOIN SA_USER as u ON u.PK_NO = cp.F_SS_CREATED_BY LEFT JOIN ACC_BANK_TXN AS t ON t.F_RESELLER_PAYMENT_NO = cp.PK_NO  WHERE cp.F_SHOP_NO = $id AND cp.PAYMENT_TYPE = 1

            UNION

            SELECT NULL as ORDER_PK_NO, cp.F_SHOP_NO, cp.RESHOP_NAME, NULL AS ORDER_ACTUAL_TOPUP, NULL AS ORDER_BUFFER_TOPUP, NULL AS ORDER_BALANCE_RETURN, NULL AS DISPATCH_STATUS, NULL AS BOOKING_PK_NO, NULL AS BOOKING_NO, NULL AS ORDER_DATE, NULL AS ORDER_PRICE, NULL AS ORDER_DISCOUNT, NULL AS ORDER_DUE, NULL AS PENALTY_FEE, NULL AS BOOKING_STATUS, NULL AS IS_CANCEL, cp.PAYMENT_DATE as DATE_AT, cp.PK_NO AS PAY_PK_NO, t.CODE AS PAYMENT_NO, cp.MR_AMOUNT AS PAY_AMOUNT, cp.REFUND_MAPING, cp.PAYMENT_REMAINING_MR, t.PK_NO as TX_PK_NO, t.IS_MATCHED AS PAYMENT_VERIFY,cp.F_BOOKING_NO_FOR_PAYMENT_TYPE3, NULL AS RETURN_PRICE, cp.F_SS_CREATED_BY AS ENTRY_BY_NO, u.NAME as ENTRY_BY_NAME, cp.SS_CREATED_ON as ENTRY_AT, 3 AS ORDER_ID, 'Payment' AS TYPE FROM ACC_RESELLER_PAYMENTS AS cp LEFT JOIN SA_USER as u ON u.PK_NO = cp.F_SS_CREATED_BY LEFT JOIN ACC_BANK_TXN AS t ON t.F_RESELLER_PAYMENT_NO = cp.PK_NO  WHERE cp.F_SHOP_NO = $id AND cp.PAYMENT_TYPE = 4

            UNION

            SELECT NULL as ORDER_PK_NO, cp.F_SHOP_NO, cp.RESHOP_NAME, NULL AS ORDER_ACTUAL_TOPUP, NULL AS ORDER_BUFFER_TOPUP, NULL AS ORDER_BALANCE_RETURN, NULL AS DISPATCH_STATUS, NULL AS BOOKING_PK_NO, NULL AS BOOKING_NO, NULL AS ORDER_DATE, NULL AS ORDER_PRICE, NULL AS ORDER_DISCOUNT,NULL AS ORDER_DUE, NULL AS PENALTY_FEE, NULL AS BOOKING_STATUS, NULL AS IS_CANCEL, cp.PAYMENT_DATE as DATE_AT, cp.PK_NO AS PAY_PK_NO, t.CODE AS PAYMENT_NO, cp.MR_AMOUNT AS PAY_AMOUNT, NULL AS REFUND_MAPING, cp.PAYMENT_REMAINING_MR, t.PK_NO as TX_PK_NO, t.IS_MATCHED AS PAYMENT_VERIFY, cp.F_BOOKING_NO_FOR_PAYMENT_TYPE3, NULL AS RETURN_PRICE, cp.F_SS_CREATED_BY AS ENTRY_BY_NO, u.NAME as ENTRY_BY_NAME, cp.SS_CREATED_ON as ENTRY_AT, 6 AS ORDER_ID, 'Refund' AS TYPE FROM ACC_RESELLER_PAYMENTS AS cp LEFT JOIN SA_USER as u ON u.PK_NO = cp.F_SS_CREATED_BY LEFT JOIN ACC_BANK_TXN AS t ON t.F_RESELLER_PAYMENT_NO = cp.PK_NO  WHERE cp.F_SHOP_NO = $id AND cp.PAYMENT_TYPE = 2

            ) result ORDER BY result.DATE_AT ASC, result.ORDER_ID ASC

            ");

            if($result){
                foreach ($result as $key => $value) {
                    if($value->TYPE == 'Payment'){
                        $value->allOrderPayments =  OrderPayment::where('F_ACC_RESELLER_PAYMENT_NO',$value->PAY_PK_NO)->where('IS_CUSTOMER',0)->get();
                        if($value->REFUND_MAPING){
                            $refund_pk = array();
                            $refunds = explode('|',$value->REFUND_MAPING);
                            foreach ($refunds as $key2 => $value2) {
                                if($value2 != ''){
                                    $refund = explode(',',$value2);

                                    array_push($refund_pk,$refund[0]);
                                }
                            }
                            if($refund_pk){
                                $value->allRefunds = PaymentSeller::whereIn('PK_NO',$refund_pk)->get();

                            }

                        }
                    }elseif($value->TYPE == 'Order Placed'){
                        $value->allPaymentForTheOrder = OrderPayment::where('ORDER_NO', $value->ORDER_PK_NO)->where('IS_CUSTOMER',0)->get();

                    }elseif($value->TYPE == 'AM payment'){
                        $value->amPaymentForOrder = Booking::find($value->F_BOOKING_NO_FOR_PAYMENT_TYPE3);

                    }

                }
            }
        } catch (\Exception $e) {
            return $this->formatResponse(false,'data not found','admin.seller.list');
        }
        return $this->formatResponse(true,'data found','admin.seller.list', $result);


    }


}
