<?php
namespace App\Repositories\Admin\Customer;

use DB;
use Image;
use App\Models\Booking;
use App\Models\Customer;
use App\Traits\ApiResponse;
use App\Models\OrderPayment;
use App\Traits\RepoResponse;
use App\Models\RefundRequest;
use App\Models\CustomerAddress;
use App\Models\PaymentCustomer;
use App\Models\AccSellerCustomerTnx;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class CustomerAbstract implements CustomerInterface
{
    use RepoResponse;
    use ApiResponse;

    protected $customer;
    public function __construct(Customer $customer, CustomerAddress $cusAdd)
    {
        $this->customer = $customer;
        $this->cusAdd   = $cusAdd;
    }
    public function getPaginatedList($request, int $per_page = 5)
    {
        $data = $this->customer->where('IS_ACTIVE',1)->orderBy('NAME', 'ASC')->get();
        return $this->formatResponse(true, '', 'admin.customer.index', $data);
    }

    public function getCustomerCombo($request,$id){
        $data = DB::table('SLS_CUSTOMERS')->where('IS_ACTIVE',1)->select('PK_NO','NAME')->orderBy('NAME', 'ASC')->get();
        return $this->formatResponse(true, '', 'admin.customer.index', $data);
    }

    public function getShow(int $id)
    {
        $data =  Customer::select('SLS_CUSTOMERS.*')
                        ->where('SLS_CUSTOMERS.PK_NO',$id)->first();
        if (!empty($data)) {
            return $this->formatResponse(true, 'Data found', 'admin.customer.edit', $data);
        }
        return $this->formatResponse(false, 'Did not found data !', 'admin.customer.list', null);
    }

    public function getCusAdd(int $id)
    {
        $data =  CustomerAddress::select('SLS_CUSTOMERS_ADDRESS.*')
                        ->where('F_CUSTOMER_NO', $id)->where('SLS_CUSTOMERS_ADDRESS.IS_ACTIVE', 1)->get();
        if ($data && count($data) > 0) {
            return $this->formatResponse(true, 'Data found', 'admin.customer.edit', $data);
        }
        return $this->formatResponse(false, 'Did not found data !', 'admin.customer.list', null);
    }


    public function postAjaxStore($request)
    {
        DB::beginTransaction();
        try {
            $mobile = $request->mobile_no;
            $check_customer = Customer::where('MOBILE_NO',$mobile)->first();
            if($check_customer){
                return $this->successResponse(200, 'This mobile no exists in customer table', '',0);
            }
            if(!empty($request->email)){
                $validator = Validator::make($request->all(), [
                    'email' => 'email:rfc,dns',
                ]);
            if ($validator->fails()) {
                return $this->successResponse(401, 'oops! You have entered invalid credentials!', $validator->errors(), 422);
            }
            }
            $customer               = new Customer();
            $customer->NAME            = $request->name;
            $customer->MOBILE_NO       = $mobile;
            $customer->ALTERNATE_NO    = $request->altno;
            $customer->EMAIL           = $request->email;
            if($request->birth_date){
                $customer->BIRTH_DATE  = date('Y-m-d', strtotime($request->birth_date));
            }
            $customer->GENDER          = $request->gender;
            $customer->CUSTOMER_NO     = $request->customer_no;
            if($request->password){
                $customer->PASSWORD    = bcrypt($request->password);
            }
            $customer->IS_ACTIVE       = $request->status ?? 1;
            $customer->F_SS_CREATED_BY = Auth::user()->PK_NO;
            $customer->SS_CREATED_ON   = date('Y-m-d H:i:s');
            if(!is_null($request->file('photo'))){
                $path       = 'media/images/customer';
                $image      = $request->file('photo');
                $img        = Image::make($image->getRealPath());
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }
                $base_name  = preg_replace('/\..+$/', '', $image->getClientOriginalName());
                $base_name  = explode(' ', $base_name);
                $base_name  = implode('-', $base_name);
                $image_name = $base_name."-".uniqid().'.webp';
                Image::make($img)->save($path.'/'.$image_name);
                $photo = '/'.$path .'/'. $image_name;
                $customer->PROFILE_PIC_URL = url($photo);
            }
            $customer->save();
            if(Auth::user()->USER_TYPE == 10){
                $f_seller_no = Auth::user()->SHOP_ID;
                $cust = new CustomerSellerMap();
                $cust->F_CUSTOMER_NO    = $customer->PK_NO;
                $cust->F_SELLER_NO      = $f_seller_no;
                $cust->save();
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
        return $this->successResponse(200, $e->getMessage(),'', 0);
        }
        DB::commit();
        return $this->successResponse(200, 'Customer has been created successfully!', $customer, 1);
        }

    public function postUpdate($request, $PK_NO)
    {
        if(!empty($request->email)){
            $validator = Validator::make($request->all(), [
                'email' => 'email:rfc,dns',
            ]);
        if ($validator->fails()) {
            return $this->successResponse(401, 'oops! You have entered invalid credentials!', $validator->errors(), 422);
        }
        }
        DB::beginTransaction();
        try {
        $customer = Customer::findOrFail($PK_NO);
        $customer->NAME            = $request->name;
        $customer->MOBILE_NO       = $request->mobile_no;
        $customer->ALTERNATE_NO    = $request->altno;
        $customer->EMAIL           = $request->email;
        if(!empty($request->birth_date)){
            $customer->BIRTH_DATE  = date('Y-m-d', strtotime($request->birth_date));
        }
        $customer->GENDER          = $request->gender;
        if (isset($request->password)) {
            $customer->PASSWORD    = bcrypt($request->password);
        }
        if(!is_null($request->file('photo'))){
            if (File::exists(public_path($customer->PROFILE_PIC_URL))) {
                File::delete(public_path($customer->PROFILE_PIC_URL));
            }
            $path       = 'media/images/customer';
            $image      = $request->file('photo');
            $img        = Image::make($image->getRealPath());
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            $base_name  = preg_replace('/\..+$/', '', $image->getClientOriginalName());
            $base_name  = explode(' ', $base_name);
            $base_name  = implode('-', $base_name);
            $image_name = $base_name."-".uniqid().'.webp';
            Image::make($img)->save($path.'/'.$image_name);
            $photo = '/'.$path .'/'. $image_name;
            $customer->PROFILE_PIC_URL = url($photo);
        }
        $customer->F_SS_MODIFIED_BY = Auth::user()->PK_NO;
        $customer->SS_MODIFIED_ON  = date('Y-m-d H:i:s');
        $customer->update();
        $data['address'] = $customer;
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
        return $this->successResponse($e->getCode(), 'Unable to update Customer Information !', '', 0);
        }
        DB::commit();
        return $this->successResponse(200, 'Customer Information has been Updated successfully !', $data, 1);
    }

    public function delete($PK_NO)
    {
        $customer = Customer::where('PK_NO',$PK_NO)->first();
        $customer->IS_ACTIVE = 0;
        if ($customer->update()) {
            return $this->successResponse(200, 'Successfully deleted Customer Information !', '', 1);
        }
        return $this->successResponse(422, 'Unable to delete Customer Information !','', 0);
    }

    public function addNewCustomer($request)
    {

        DB::beginTransaction();
        try {
            $mobile = (int)$request->customer_mobile;
            $checkSeller = Seller::where('MOBILE_NO',$mobile)->first();
            if($checkSeller){
                return ['customer_no'=>null,'customer_id'=>0, 'duplicate' => '1' ];
            }else{
                $customer                  = new Customer();
                $customer->NAME            = str_replace("’","'",$request->customer_name);
                $customer->MOBILE_NO       = $mobile;
                $customer->EMAIL           = $request->custom_email;
                $customer->F_SHOP_NO       = null;
                $customer->IS_ACTIVE       = 1;
                $customer->save();
            }
        } catch (\Exception $e) {
            DB::rollback();
            return ['customer_no'=>null,'customer_id'=>0,'duplicate' => '0'];
        }
        DB::commit();
        $customer_info = $this->customer::find($customer->PK_NO);

        return ['customer_no'=>$customer_info->CUSTOMER_NO,'customer_id'=>$customer_info->PK_NO
        // ,'cus_add_pk'=>$customer_add->PK_NO
        ];
    }

    public function postBlanceTransfer($request)
    {
        DB::beginTransaction();
        try {
        $balance =  PaymentCustomer::find($request->payment_no);
        if( ( $balance->PAYMENT_REMAINING_MR >= $request->amount_to_trans ) && ($request->from_customer != $request->to_customer_hidden) ){

            $trn = new AccSellerCustomerTnx();
            $trn->F_FROM_CUSTOMER_NO            = $request->from_customer;
            $trn->F_FROM_CUSTOMER_PAYMENT_NO    = $request->payment_no;
            $trn->F_TO_CUSTOMER                 = $request->to_customer_hidden;
            $trn->AMOUNT                        = $request->amount_to_trans;
            $trn->save();

            $payment                            = new PaymentCustomer();
            $payment->F_CUSTOMER_NO             = $request->to_customer_hidden;
            $payment->F_PAYMENT_CURRENCY_NO     = 2;
            $payment->PAYMENT_DATE              = date('Y-m-d');
            $payment->MR_AMOUNT                 = $request->amount_to_trans;
            $payment->PAYMENT_REMAINING_MR      = $request->amount_to_trans;
            $payment->F_PAYMENT_ACC_NO          = $balance->F_PAYMENT_ACC_NO;
            $payment->PAYMENT_NOTE              = $balance->PAYMENT_NOTE;
            $payment->PAID_BY                   = $balance->PAID_BY;
            $payment->SLIP_NUMBER               = $balance->SLIP_NUMBER.'-'.$request->to_customer_hidden;
            $payment->PAYMENT_CONFIRMED_STATUS  = 1;
            $payment->ATTACHMENT_PATH           = $balance->ATTACHMENT_PATH;
            $payment->F_CUSTOMER_PAYMENT_METHOD_NO  = $balance->F_CUSTOMER_PAYMENT_METHOD_NO;
            $payment->IS_COD                    = $balance->IS_COD;
            $payment->PAYMENT_TYPE              = $balance->PAYMENT_TYPE;
            $payment->IS_TRANSFERRED            = 1;
            $payment->F_BANK_TXN_NO_TRANSFERAR  = $balance->bankTxn->PK_NO;
            $payment->save();
        }else{
            return $this->formatResponse(false,'Balance transfer not successfull 1','admin.customer.list');
        }
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false,'Balance transfer not successfull 2','admin.customer.list');
        }
        DB::commit();
        return $this->formatResponse(true,'Balance transfer successfull !','admin.customer.list');
    }



    public function getRemainingBalance($id)
    {
        $data = PaymentCustomer::where('F_CUSTOMER_NO',$id)->where('PAYMENT_CONFIRMED_STATUS',1)->where('PAYMENT_REMAINING_MR','>',0)->get();
        $response = '<option value="">- select one -</option>';
            if ($data) {
                foreach ($data as $value) {
                    $response .= '<option value="'.$value->PK_NO.'">PAYID'.$value->PK_NO.' - '.$value->PAYMENT_REMAINING_MR.'</option>';
                }
            }else{
                $response .= '<option value="">No data found</option>';
            }
       return $response;
    }



    public function postRefundRequest($request)
    {
        DB::beginTransaction();
        try {
            $bank = BankList::find($request->bank_no);
            $refund =  new RefundRequest();
            $refund->F_CUSTOMER_NO  = $request->customer_no;
            $refund->IS_CUSTOMER    = $request->is_customer;
            if($bank){
                $refund->F_ACC_BANK_LIST_NO = $request->bank_no;
                $refund->REQ_BANK_NAME  = $bank->BANK_NAME;
            }
            $refund->REQ_BANK_ACC_NAME  = $request->cust_acc_name;
            $refund->REQ_BANK_ACC_NO     = $request->cust_acc_no;
            $refund->MR_AMOUNT          = $request->refund_amount;
            $refund->REQUEST_NOTE       = $request->refund_note;
            $refund->REQUEST_BY         = Auth::user()->PK_NO;
            $refund->REQUEST_BY_NAME    = Auth::user()->NAME;
            $refund->REQUEST_DATE       = date('Y-m-d');
            $refund->STATUS             = 0;
            $refund->save();

        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false,'Refund request not successfull','admin.customer.refund');
        }
        DB::commit();
        return $this->formatResponse(true,'Refund request successfull','admin.customer.refund');
    }


    public function postRefundRequestSeller($request)
    {
        DB::beginTransaction();
        try {
            $bank = BankList::find($request->bank_no);
            $refund =  new RefundRequest();
            $refund->F_SHOP_NO  = $request->seller_no;
            $refund->IS_CUSTOMER    = $request->is_customer;
            if($bank){
                $refund->F_ACC_BANK_LIST_NO = $request->bank_no;
                $refund->REQ_BANK_NAME  = $bank->BANK_NAME;
            }
            $refund->REQ_BANK_ACC_NAME  = $request->cust_acc_name;
            $refund->REQ_BANK_ACC_NO     = $request->cust_acc_no;
            $refund->MR_AMOUNT          = $request->refund_amount;
            $refund->REQUEST_NOTE       = $request->refund_note;
            $refund->REQUEST_BY         = Auth::user()->PK_NO;
            $refund->REQUEST_BY_NAME    = Auth::user()->NAME;
            $refund->REQUEST_DATE       = date('Y-m-d');
            $refund->STATUS             = 0;
            $refund->save();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false,'Refund request not successfull','admin.seller.refund');
        }
        DB::commit();
        return $this->formatResponse(true,'Refund request successfull','admin.seller.refund');
    }

    public function getRefundedRequestDeny($request, $id){
        DB::beginTransaction();
        try {
            $check =  PaymentCustomer::where('F_ACC_CUST_RES_REFUND_REQUEST_NO',$id)->first();
            if($check){
                $msg = 'This request already accepted';
            }else{
                RefundRequest::where('PK_NO',$id)->update(['STATUS' => 2]);
            }
            $msg = 'Refund request deny successfull';

        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false,'Refund request deny not successfull','admin.customer.refundrequest');
        }
        DB::commit();
        return $this->formatResponse(true,$msg,'admin.customer.refundrequest');

    }

    public function getRefundedRequestDenySeller($request, $id){
        DB::beginTransaction();
        try {
            $check =  PaymentSeller::where('F_ACC_CUST_RES_REFUND_REQUEST_NO',$id)->first();
            if($check){
                $msg = 'This request already accepted';
            }else{
                RefundRequest::where('PK_NO',$id)->update(['STATUS' => 2]);
            }
            $msg = 'Refund request deny successfull';

        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false,'Refund request deny not successfull','admin.seller.refundrequest');
        }
        DB::commit();
        return $this->formatResponse(true,$msg,'admin.seller.refundrequest');
    }


    public function getCustomerHistory($id)
    {
        try {

        $result = DB::SELECT("SELECT result.* FROM (

            SELECT o.PK_NO as ORDER_PK_NO, o.F_CUSTOMER_NO, o.CUSTOMER_NAME, o.ORDER_ACTUAL_TOPUP, o.ORDER_BUFFER_TOPUP, o.ORDER_BALANCE_RETURN, o.DISPATCH_STATUS, b.PK_NO AS BOOKING_PK_NO, b.BOOKING_NO, DATE(b.CONFIRM_TIME) as ORDER_DATE, SUM(IFNULL(b.TOTAL_PRICE,0) - b.DISCOUNT + IFNULL(b.PENALTY_FEE,0) - IFNULL(b.CUSTOMER_POSTAGE,0)) AS ORDER_PRICE, b.DISCOUNT AS ORDER_DISCOUNT, SUM(IFNULL(b.TOTAL_PRICE,0) - b.DISCOUNT - o.ORDER_ACTUAL_TOPUP + IFNULL(b.PENALTY_FEE,0)  - IFNULL(b.CUSTOMER_POSTAGE,0) ) AS ORDER_DUE, b.PENALTY_FEE, b.BOOKING_STATUS, o.IS_CANCEL,DATE(b.CONFIRM_TIME) as DATE_AT, NULL AS PAY_PK_NO, NULL AS PAYMENT_NO, NULL AS PAY_AMOUNT, NULL AS REFUND_MAPING, NULL AS PAYMENT_REMAINING_MR, NULL as TX_PK_NO, NULL AS PAYMENT_VERIFY, NULL AS F_BOOKING_NO_FOR_PAYMENT_TYPE3, NULL AS RETURN_PRICE, b.F_SS_CREATED_BY AS ENTRY_BY_NO, u.NAME as ENTRY_BY_NAME, b.SS_CREATED_ON as ENTRY_AT, 1 AS  ORDER_ID, 'Order Placed' AS TYPE  FROM SLS_ORDER as o JOIN SLS_BOOKING AS b ON b.PK_NO = o.F_BOOKING_NO LEFT JOIN SA_USER as u ON u.PK_NO = b.F_SS_CREATED_BY WHERE o.F_CUSTOMER_NO = $id GROUP BY o.PK_NO

            UNION

            SELECT NULL as ORDER_PK_NO, cp.F_CUSTOMER_NO, cp.CUSTOMER_NAME, NULL AS ORDER_ACTUAL_TOPUP, NULL AS ORDER_BUFFER_TOPUP, NULL AS ORDER_BALANCE_RETURN, NULL AS DISPATCH_STATUS, NULL AS BOOKING_PK_NO, NULL AS BOOKING_NO, NULL AS ORDER_DATE, NULL AS ORDER_PRICE, NULL AS ORDER_DISCOUNT, NULL AS ORDER_DUE, NULL AS PENALTY_FEE, NULL AS BOOKING_STATUS, NULL AS IS_CANCEL, cp.PAYMENT_DATE as DATE_AT, cp.PK_NO AS PAY_PK_NO, t.CODE AS PAYMENT_NO, cp.MR_AMOUNT AS PAY_AMOUNT, cp.REFUND_MAPING, cp.PAYMENT_REMAINING_MR, t.PK_NO as TX_PK_NO, t.IS_MATCHED AS PAYMENT_VERIFY,cp.F_BOOKING_NO_FOR_PAYMENT_TYPE3, NULL AS RETURN_PRICE, cp.F_SS_CREATED_BY AS ENTRY_BY_NO, u.NAME as ENTRY_BY_NAME, cp.SS_CREATED_ON as ENTRY_AT, 3 AS ORDER_ID, 'Payment' AS TYPE FROM ACC_CUSTOMER_PAYMENTS AS cp LEFT JOIN SA_USER as u ON u.PK_NO = cp.F_SS_CREATED_BY LEFT JOIN ACC_BANK_TXN AS t ON t.F_CUSTOMER_PAYMENT_NO = cp.PK_NO  WHERE cp.F_CUSTOMER_NO = $id AND cp.PAYMENT_TYPE = 1

            UNION

            SELECT NULL as ORDER_PK_NO, cp.F_CUSTOMER_NO, cp.CUSTOMER_NAME, NULL AS ORDER_ACTUAL_TOPUP, NULL AS ORDER_BUFFER_TOPUP, NULL AS ORDER_BALANCE_RETURN, NULL AS DISPATCH_STATUS, NULL AS BOOKING_PK_NO, NULL AS BOOKING_NO, NULL AS ORDER_DATE, NULL AS ORDER_PRICE, NULL AS ORDER_DISCOUNT, NULL AS ORDER_DUE, NULL AS PENALTY_FEE, NULL AS BOOKING_STATUS, NULL AS IS_CANCEL, cp.PAYMENT_DATE as DATE_AT, cp.PK_NO AS PAY_PK_NO, t.CODE AS PAYMENT_NO, cp.MR_AMOUNT AS PAY_AMOUNT, cp.REFUND_MAPING, cp.PAYMENT_REMAINING_MR, t.PK_NO as TX_PK_NO, t.IS_MATCHED AS PAYMENT_VERIFY,cp.F_BOOKING_NO_FOR_PAYMENT_TYPE3, NULL AS RETURN_PRICE, cp.F_SS_CREATED_BY AS ENTRY_BY_NO, u.NAME as ENTRY_BY_NAME, cp.SS_CREATED_ON as ENTRY_AT, 3 AS ORDER_ID, 'Payment' AS TYPE FROM ACC_CUSTOMER_PAYMENTS AS cp LEFT JOIN SA_USER as u ON u.PK_NO = cp.F_SS_CREATED_BY LEFT JOIN ACC_BANK_TXN AS t ON t.F_CUSTOMER_PAYMENT_NO = cp.PK_NO  WHERE cp.F_CUSTOMER_NO = $id AND cp.PAYMENT_TYPE = 4

            UNION

            SELECT NULL as ORDER_PK_NO, cp.F_CUSTOMER_NO, cp.CUSTOMER_NAME, NULL AS ORDER_ACTUAL_TOPUP, NULL AS ORDER_BUFFER_TOPUP, NULL AS ORDER_BALANCE_RETURN, NULL AS DISPATCH_STATUS, NULL AS BOOKING_PK_NO, NULL AS BOOKING_NO, NULL AS ORDER_DATE, NULL AS ORDER_PRICE, NULL AS ORDER_DISCOUNT,NULL AS ORDER_DUE, NULL AS PENALTY_FEE, NULL AS BOOKING_STATUS, NULL AS IS_CANCEL, cp.PAYMENT_DATE as DATE_AT, cp.PK_NO AS PAY_PK_NO, t.CODE AS PAYMENT_NO, cp.MR_AMOUNT AS PAY_AMOUNT, NULL AS REFUND_MAPING, cp.PAYMENT_REMAINING_MR, t.PK_NO as TX_PK_NO, t.IS_MATCHED AS PAYMENT_VERIFY, cp.F_BOOKING_NO_FOR_PAYMENT_TYPE3, NULL AS RETURN_PRICE, cp.F_SS_CREATED_BY AS ENTRY_BY_NO, u.NAME as ENTRY_BY_NAME, cp.SS_CREATED_ON as ENTRY_AT, 6 AS ORDER_ID, 'Refund' AS TYPE FROM ACC_CUSTOMER_PAYMENTS AS cp LEFT JOIN SA_USER as u ON u.PK_NO = cp.F_SS_CREATED_BY LEFT JOIN ACC_BANK_TXN AS t ON t.F_CUSTOMER_PAYMENT_NO = cp.PK_NO  WHERE cp.F_CUSTOMER_NO = $id AND cp.PAYMENT_TYPE = 2

            ) result ORDER BY result.DATE_AT ASC, result.ORDER_ID ASC

            ");

            if($result){
                foreach ($result as $key => $value) {
                    if($value->TYPE == 'Payment'){
                        $value->allOrderPayments =  OrderPayment::where('F_ACC_CUSTOMER_PAYMENT_NO',$value->PAY_PK_NO)->where('IS_CUSTOMER',1)->get();
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
                                $value->allRefunds = PaymentCustomer::whereIn('PK_NO',$refund_pk)->get();

                            }

                        }
                    }elseif($value->TYPE == 'Order Placed'){
                        $value->allPaymentForTheOrder = OrderPayment::where('ORDER_NO', $value->ORDER_PK_NO)->where('IS_CUSTOMER',1)->get();

                    }elseif($value->TYPE == 'AM payment'){
                        $value->amPaymentForOrder = Booking::find($value->F_BOOKING_NO_FOR_PAYMENT_TYPE3);

                    }

                }
            }
        } catch (\Exception $e) {
            return $this->formatResponse(false,'data not found','admin.customer.list');
        }
        return $this->formatResponse(true,'data found','admin.customer.list', $result);
    }


    public function getBillingAdd($request, $customer_id)
    {
        if (isset(Auth::user()->CUSTOMER_NO)) {
            $data = $this->customer_add->where('F_CUSTOMER_NO',$customer_id)->where('F_ADDRESS_TYPE_NO',2)->where('IS_ACTIVE',1)->first();
        }else{
            $data = Seller::where('PK_NO',$customer_id)->where('IS_ACTIVE',1)->first();
        }
      if (!empty($data)) {
        return $this->formatResponse(true, 'Data found', 'customer.index', $data);
        }
        return $this->formatResponse(false, 'Did not found data !', 'customer.index', null);
    }

}
