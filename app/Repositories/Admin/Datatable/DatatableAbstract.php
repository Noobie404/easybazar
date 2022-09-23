<?php
namespace App\Repositories\Admin\Datatable;
use DB;
use Auth;
use Carbon\Carbon;
use App\Models\Stock;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\OrderRtc;
use App\Models\NotifySms;
use App\Models\MerInvoice;
use App\Traits\CommonTrait;
use App\Models\AuthUserGroup;
use App\Models\BookingDetails;
use App\Models\PaymentBankAcc;
use App\Models\ProductVariant;
use Yajra\Datatables\Datatables;
use App\Models\EmailNotification;
class DatatableAbstract implements DatatableInterface
{
    use CommonTrait;
    protected $notifySms;
    protected $invoice;
    protected $merInvoice;
    protected $notifyEmail;
    public function __construct(NotifySms $notifySms, Invoice $invoice, MerInvoice $merInvoice, EmailNotification $notifyEmail){
        $this->notifySms    = $notifySms;
        $this->invoice 	    = $invoice;
        $this->merInvoice 	= $merInvoice;
        $this->notifyEmail  = $notifyEmail;
    }

    public function getDatatableCustomer($request)
    {
        if(Auth::user()->USER_TYPE == 10 ){
            $shop_id  = Auth::user()->SHOP_ID;

            $dataSet = DB::table('SLS_CUSTOMER_SELLER_MAP')
            ->select('c.PK_NO','c.CUSTOMER_NO','c.NAME','c.EMAIL','c.MOBILE_NO','c.CUSTOMER_BALANCE_BUFFER','c.CUSTOMER_BALANCE_ACTUAL','c.CUM_BALANCE')
            ->leftjoin('SLS_CUSTOMERS as c', 'c.PK_NO','SLS_CUSTOMER_SELLER_MAP.F_CUSTOMER_NO')
            ->where('SLS_CUSTOMER_SELLER_MAP.F_SELLER_NO',$shop_id)
            ->where('c.IS_ACTIVE', 1)
            ->orderBy('c.NAME', 'ASC');
        }else{
            if($request->shop_id){

                $dataSet = DB::table('SLS_CUSTOMER_SELLER_MAP')
                ->select('c.PK_NO','c.CUSTOMER_NO','c.NAME','c.EMAIL','c.MOBILE_NO','c.CUSTOMER_BALANCE_BUFFER','c.CUSTOMER_BALANCE_ACTUAL','c.CUM_BALANCE')
                ->leftjoin('SLS_CUSTOMERS as c', 'c.PK_NO','SLS_CUSTOMER_SELLER_MAP.F_CUSTOMER_NO')
                ->where('SLS_CUSTOMER_SELLER_MAP.F_SELLER_NO',$shop_id)
                ->where('c.IS_ACTIVE', 1)
                ->orderBy('c.NAME', 'ASC');

            }else{
                $dataSet = DB::table("SLS_CUSTOMERS as c")
                ->select('c.PK_NO','c.CUSTOMER_NO','c.NAME','c.EMAIL','c.MOBILE_NO','c.CUSTOMER_BALANCE_BUFFER','c.CUSTOMER_BALANCE_ACTUAL','c.CUM_BALANCE')
                ->where('c.IS_ACTIVE', 1)
                ->orderBy('c.NAME', 'ASC');
            }
        }
        return Datatables::of($dataSet)
                    ->addColumn('mobile', function($dataSet){
                        $mobile = '+88'.$dataSet->MOBILE_NO;
                        return $mobile;
                    })
                    ->addColumn('action', function($dataSet){
                        $roles = userRolePermissionArray();
                        $edit = $view = $delete = $payment = $balance_trans = $add_booking = $view_booking = $view_booking = $view_payment = $view_history = '';
                        if (hasAccessAbility('edit_customer', $roles)) {
                            // $edit = '<a href="'.route("admin.customer.edit", [$dataSet->PK_NO]).'" class="btn btn-xs btn-info mb-05 mr-05" title="EDIT"><i class="la la-edit"></i></a>';
                            $edit = '<button class="btn btn-xs btn-info mb-05 mr-05 edit-row" data-id="'.$dataSet->PK_NO.'" title="Edit Customer"><i class="la la-edit"></i></button>';
                        }
                        if (hasAccessAbility('view_customer', $roles)) {
                            $view = ' <a href="'.route("admin.customer.view", [$dataSet->PK_NO]). '" class="btn btn-xs btn-success mb-05 mr-05" title="VIEW"><i class="la la-eye"></i></a>';
                        }
                        if (hasAccessAbility('delete_customer', $roles)) {
                            $delete = ' <button class="btn btn-xs btn-danger mb-05 delete-row" title="DELETE" data-id="'.$dataSet->PK_NO.'"><i class="la la-trash"></i></button>';
                        }
                        if (hasAccessAbility('new_payment', $roles)) {
                            $payment = ' <a href="'.route('admin.payment.create', [$dataSet->PK_NO, 'customer' ]).'" class="btn btn-xs btn-primary mb-05 mr-05" title="Add new payment"><i class="la la-usd"></i></a>';
                        }

                        if (hasAccessAbility('new_booking', $roles)) {
                            $add_booking = ' <a href="'.route("admin.booking.create", ['id'=>$dataSet->PK_NO,'type'=>'customer']). '" class="btn btn-xs btn-primary mb-05 mr-05" title="ADD BOOKING"><i class="la la-plus"></i></a>';
                        }

                        if (hasAccessAbility('view_booking', $roles)) {
                            $view_booking = ' <a href="'.route("admin.booking.list", ['id' => $dataSet->PK_NO,'type'=>'customer']). '" class="btn btn-xs btn-success mb-05 mr-05" title="ALL BOOKING LIST">&nbsp;B&nbsp;</a>';
                        }
                        if (hasAccessAbility('view_booking', $roles)) {
                            $view_booking = ' <a href="'.route("admin.booking.list", ['id' => $dataSet->PK_NO,'type'=>'customer']). '" class="btn btn-xs btn-info mb-05 mr-05" title="ALL ORDER LIST">&nbsp;O&nbsp;</a>';
                        }
                        if (hasAccessAbility('view_payment', $roles)) {
                            $view_payment = ' <a href="'.route("admin.payment.list", ['id' => $dataSet->PK_NO,'type'=>'customer']). '" class="btn btn-xs btn-success mb-05 mr-05" title="ALL PAYMENTS LIST">&nbsp;P&nbsp;</a>';
                        }
                        return $edit.$delete.$view;
                        // $payment.$balance_trans.$add_booking.$view_booking.$view_booking.$view_payment;
                    })
                    ->addColumn('due', function($dataSet){
                        $due = '0';
                        $customer_due = DB::SELECT("SELECT
                        SLS_BOOKING.PK_NO as BOOKING_PK_NO,
                        SLS_BOOKING.F_CUSTOMER_NO AS CUSTOMER_PK_NO,
                        SUM(SLS_BOOKING.TOTAL_PRICE) AS TOTAL_PRICE,
                        IFNULL(SLS_ORDER.ORDER_BUFFER_TOPUP,0) AS ORDER_BUFFER_TOPUP,
                        SUM( IFNULL(SLS_BOOKING.TOTAL_PRICE,0) - IFNULL(SLS_BOOKING.DISCOUNT,0) - (IFNULL(SLS_ORDER.ORDER_BUFFER_TOPUP,0))) AS DUE_PRICE

                        from SLS_BOOKING, SLS_ORDER
                        where SLS_BOOKING.F_CUSTOMER_NO = $dataSet->PK_NO
                        AND SLS_BOOKING.PK_NO = SLS_ORDER.F_BOOKING_NO");
                        if(!empty($customer_due)){
                            $due = '<span titel="Sum of unverified payments">'.number_format($customer_due[0]->DUE_PRICE,2).'</span>';
                        }
                        return $due;
                    })
                    ->addColumn('credit', function($dataSet){
                        $roles = userRolePermissionArray();
                        $credit = '';
                        if($dataSet->CUM_BALANCE > 0 ){
                            if (hasAccessAbility('new_payment', $roles)) {
                                $credit = ' <a href="'.route('admin.payment.create', [$dataSet->PK_NO, 'customer' ]).'?payfrom=credit" class="link" title="Customer actual credit balance (only verified)">'.number_format($dataSet->CUM_BALANCE,2).'</a>';
                            }
                        }else{
                            $credit = '<span>'.number_format($dataSet->CUM_BALANCE,2).'</span>';
                        }
                        return $credit;
                    })
                    ->addColumn('balance', function($dataSet){
                        $roles = userRolePermissionArray();
                        $balance = '';
                        if (hasAccessAbility('new_payment', $roles)) {
                            $buffer = $dataSet->CUSTOMER_BALANCE_BUFFER;
                            $actual = $dataSet->CUSTOMER_BALANCE_ACTUAL;
                            if($buffer == $actual){
                                $balance = '<span title="Actual balance & buffer balance is same (SUM)">'.number_format($dataSet->CUSTOMER_BALANCE_ACTUAL,2).'</span>';
                            }else{
                                $balance = '<span title="Actual balance (SUM)">'.number_format($dataSet->CUSTOMER_BALANCE_ACTUAL,2).'</span >/<span title="Buffer balance (SUM)">'. number_format($dataSet->CUSTOMER_BALANCE_BUFFER,2).'</span>';
                            }
                        }
                        return $balance;
                    })
                    ->addColumn('total_unverified', function($dataSet){
                        $roles = userRolePermissionArray();
                        $total_unverified = 0;
                        if (hasAccessAbility('new_payment', $roles)) {
                            $query = DB::table('ACC_CUSTOMER_PAYMENTS')
                            ->select(DB::raw("sum(ACC_CUSTOMER_PAYMENTS.PAY_AMOUNT) as total_unverified"))
                            ->where('F_CUSTOMER_NO',$dataSet->PK_NO)
                            ->where('PAYMENT_CONFIRMED_STATUS',0)
                            ->groupBy('ACC_CUSTOMER_PAYMENTS.F_CUSTOMER_NO')
                            ->first();
                            if($query){
                                $total_unverified = $query->total_unverified;
                            }
                            $total_unverified = number_format($total_unverified,2);
                        }
                        return $total_unverified;
                    })
                    ->addColumn('customer_no', function($dataSet){

                        $customer_no = '';
                        $customer_no = '<a href="#" class="" title="Customer No">'.$dataSet->CUSTOMER_NO.'</a>';
                        return $customer_no;

                    })
                    ->rawColumns(['mobile','action','due', 'balance','customer_no','credit'])
                    ->make(true);
    }

    public function ajaxbankToOther()
    {
        $dataSet = DB::table("ACC_PAYMENT_BANK_ACC_EXFER as ex")
        ->select('ex.*','h.NARRATION as head_narration','acc.BANK_ACC_NAME','u.NAME')
        ->leftjoin('ACC_PAYMENT_ACC_HEAD as h', 'h.PK_NO','ex.F_ACC_PAYMENT_ACC_HEAD_NO')
        ->join('ACC_PAYMENT_BANK_ACC as acc', 'acc.PK_NO','ex.F_I_ACC_PAYMENT_BANK_ACC_NO')
        ->join('SA_USER as u', 'u.PK_NO','ex.SS_CREATED_BY');
        if (Auth::user()->F_AGENT_NO > 0) {
            $dataSet = $dataSet->where('acc.F_USER_NO',Auth::user()->PK_NO);
        }
        $dataSet = $dataSet->orderBy('ex.SS_CREATED_ON', 'DESC');
        return Datatables::of($dataSet)
        ->addColumn('is_in', function($dataSet){
            if ($dataSet->IS_IN == 0) {
                $is_in = 'Cash Out';
            }else{
                $is_in = 'Cash In';
            }
            return $is_in;
        })
        ->addColumn('status', function($dataSet){
            if ($dataSet->IS_VERIFIED == 0) {
                $status = '<div class="badge badge-danger round w-100 f-100">Not Verified</div>';
            }elseif($dataSet->IS_VERIFIED == 1){
                $status = '<div class="badge badge-success round w-100 f-100">Verified</div>';
            }else{
                $status = '<div class="badge border-info round w-100 f-100">Cancelled</div>';
            }
            return $status;
        })
        ->addColumn('action', function($dataSet){
                $action = '<a href="'.route("admin.account_to_other.view", [$dataSet->PK_NO]).'" class="btn btn-xs btn-info mb-05 mr-05" title="EDIT"><i class="la la-edit"></i></a> <a href="'.route("admin.account_to_other.details", [$dataSet->PK_NO]).'" class="btn btn-xs btn-primary mb-05 mr-05" title="VIEW"><i class="la la-eye"></i></a>';
            return $action;
        })
        ->rawColumns(['status','is_in','action'])
        ->make(true);
    }

    public function ajaxbankToBank()
    {
        $agent_pk = '0';
        if (Auth::user()->F_AGENT_NO > 0) {
            $agent_pk = PaymentBankAcc::select('PK_NO')->where('F_USER_NO',Auth::user()->PK_NO)->first();
            $agent_pk = $agent_pk->PK_NO;
        }
        $dataSet = DB::table("ACC_PAYMENT_BANK_ACC_IXFER as ix")
        ->select('ix.*','acc.BANK_ACC_NAME','acc.BANK_NAME','u.NAME'
        ,DB::raw('(select BANK_ACC_NAME from ACC_PAYMENT_BANK_ACC where PK_NO = F_TO_ACC_PAYMENT_BANK_ACC_NO) as to_bank_acc_name')
        ,DB::raw('(select BANK_NAME from ACC_PAYMENT_BANK_ACC where PK_NO = F_TO_ACC_PAYMENT_BANK_ACC_NO) as to_bank_name')
        ,DB::raw(''.$agent_pk.' as agent_pk')
        )
        ->join('ACC_PAYMENT_BANK_ACC as acc', 'acc.PK_NO','ix.F_FROM_ACC_PAYMENT_BANK_ACC_NO')
        ->join('SA_USER as u', 'u.PK_NO','ix.SS_CREATED_BY');
        if (Auth::user()->F_AGENT_NO > 0) {
            $dataSet = $dataSet->where('ix.F_FROM_ACC_PAYMENT_BANK_ACC_NO',$agent_pk);
            $dataSet = $dataSet->orWhere('ix.F_TO_ACC_PAYMENT_BANK_ACC_NO',$agent_pk);
        }
        $dataSet = $dataSet->orderBy('ix.SS_CREATED_ON', 'DESC');

        return Datatables::of($dataSet)
        ->addColumn('status', function($dataSet){
            if ($dataSet->IS_VERIFIED == 0) {
                $status = '<div class="badge badge-danger round w-100 f-100">Not Verified</div>';
            }elseif($dataSet->IS_VERIFIED == 1){
                $status = '<div class="badge badge-success round w-100 f-100">Verified</div>';
            }else{
                $status = '<div class="badge border-info round w-100 f-100">Cancelled</div>';
            }
            return $status;
        })
        ->addColumn('action', function($dataSet){
            $action = '';
            if (Auth::user()->F_AGENT_NO > 0 && $dataSet->agent_pk == $dataSet->F_TO_ACC_PAYMENT_BANK_ACC_NO) {
                $action .= '';
            }else{
                $action .= '<a href="'.route("admin.account_to_bank.view", [$dataSet->PK_NO]).'" class="btn btn-xs btn-info mb-05 mr-05" title="EDIT"><i class="la la-edit"></i></a> ';
            }
                $action .= '<a href="'.route("admin.account_to_bank.details", [$dataSet->PK_NO]).'" class="btn btn-xs btn-primary mb-05 mr-05" title="VIEW"><i class="la la-eye"></i></a>';
            return $action;
        })
        ->rawColumns(['status','action'])
        ->make(true);
    }

    public function getDatatableBooking($request)
    {
        $booking_status = $request->booking_status;
        $order_id      = $request->order_id;
        $order_date    = $request->order_date;
        $delivery_boy = '';
        // $_date_range = explode(' - ',$order_date,0);
        if(!empty($order_date)){
        $date = explode('-',$order_date);
        $startDate = date('Y-m-d',strtotime($date[0]));
        $endDate = date('Y-m-d',strtotime($date[1]));
        }
        $shop_id = null;
        $dispatch       = $request->dispatch == 'dispatch' ?? null;
        $dispatched     = $request->dispatch == 'dispatched' ?? null;
        $confirm     = $request->dispatch == 'confirm' ?? null;
        $ready          = $request->dispatch == 'ready' ?? null;
        $delivered          = $request->dispatch == 'delivered' ?? null;

        // dd($ready);
        $cancel          = $request->dispatch == 'cancel' ?? null;
        $dataSet = DB::table("SLS_BOOKING")
            ->select('SLS_BOOKING.PK_NO','SLS_BOOKING.REQUEST_FOR','SLS_BOOKING.F_CUSTOMER_NO','SLS_BOOKING.BOOKING_STATUS','SLS_BOOKING.F_SHOP_NO','SLS_BOOKING.CUSTOMER_NAME','SLS_BOOKING.SS_CREATED_ON','SA_USER.NAME as CREATED_BY','SLS_BOOKING.CONFIRM_TIME as ORDER_DATE','SLS_BOOKING.BOOKING_NO','SLS_BOOKING.SHOP_NAME','SLS_BOOKING.TOTAL_PRICE','SLS_BOOKING.DISCOUNT','SLS_BOOKING.PK_NO as SLS_BOOKING_PK_NO','SLS_BOOKING.ORDER_ACTUAL_TOPUP','SLS_BOOKING.IS_SYSTEM_HOLD','SLS_BOOKING.IS_ADMIN_HOLD','SLS_BOOKING.DISPATCH_STATUS','SLS_BOOKING.CANCEL_REQUEST_BY','SLS_BOOKING.CANCEL_REQUEST_AT','SLS_BOOKING.CANCEL_REQUEST_FROM','SLS_BOOKING.CANCELED_AT','SLS_BOOKING.CANCEL_NOTE','SLS_BOOKING.IS_SELF_PICKUP','SLS_BOOKING.IS_ADMIN_APPROVAL','SLS_BOOKING.BOOKING_NOTES','SLS_BOOKING.CONFIRM_TIME', 'SLS_BOOKING.PAYMENT_METHOD')
            ->leftJoin('SA_USER','SLS_BOOKING.F_SS_CREATED_BY','SA_USER.PK_NO');
            if(Auth::user()->USER_TYPE == 10){
                $shop_id = Auth::user()->SHOP_ID;
            }else{
                $shop_id = $request->branch_id;
            }
            if($booking_status){
                $dataSet->where('SLS_BOOKING.BOOKING_STATUS',$booking_status);
            }
            if(!empty($startDate) && !empty($endDate)){
                $dataSet->whereBetween('SLS_BOOKING.BOOKING_TIME',[$startDate, $endDate]);
            }
            if($order_id){
                $dataSet->where('SLS_BOOKING.BOOKING_NO',$order_id);
            }
            if($dispatch){
                $dataSet->whereIn('SLS_BOOKING.BOOKING_STATUS',[50,70]);
                // $dataSet->whereIn('SLS_BOOKING.BOOKING_STATUS',[50]);
            }
            if($ready){
                $dataSet->where('SLS_BOOKING.BOOKING_STATUS',70);
            }
            if($confirm){
                $dataSet->where('SLS_BOOKING.BOOKING_STATUS',50);
            }
            if($delivered){
                $dataSet->where('SLS_BOOKING.BOOKING_STATUS',90);
            }
            if($dispatched){
                $dataSet->whereIn('SLS_BOOKING.BOOKING_STATUS',[80,85,90,100,110]);
            }
            if($cancel){
                $dataSet->whereIn('SLS_BOOKING.BOOKING_STATUS',[20]);
            }
            $dataSet->orderBy('SLS_BOOKING.PK_NO','DESC');
        return Datatables::of($dataSet)
        ->addColumn('created_at', function($dataSet){
            if ($dataSet->REQUEST_FOR == 'WEB') {
                $created_by = $dataSet->CUSTOMER_NAME;
            }else{
                $created_by = $dataSet->SHOP_NAME;
            }
            $created_at = '<div class="font-11">'.date('d-m-y h:i A',strtotime($dataSet->SS_CREATED_ON)).'</div><div>'.$created_by.'</div>';
            return $created_at;
        })
        ->addColumn('SL', function($dataSet){
            $SL = '';
            // $SL .= '<input class="checkSingle" type="checkbox" name="booking_id[]" value="'.$dataSet->PK_NO.'">';
            $SL .= '<input type="checkbox" class="input-chk check-one" name="booking_id[]" value="'.$dataSet->PK_NO.'">';
            return $SL;
        })
        ->addColumn('order_date', function($dataSet){
            if($dataSet->CONFIRM_TIME){
            $order_date = '<div>'.date('d-m-y',strtotime($dataSet->CONFIRM_TIME)).'</div>';
            }else{
                $order_date = '<div>'.date('d-m-y',strtotime($dataSet->SS_CREATED_ON)).'</div>';
            }
            return $order_date;
        })
        ->addColumn('order_id', function($dataSet){
            $order_id = '';

            $title = 'ORD-'.$dataSet->BOOKING_NO;
            $order_id .= '<a href="'.route("admin.booking.view", [$dataSet->SLS_BOOKING_PK_NO]).'" title="'.$title.'">ORD-'.$dataSet->BOOKING_NO.'</a>';

            return $order_id;
        })
        ->addColumn('customer_name', function($dataSet){
            $customer_name = '';
            $customer_name .= '<a class="text-capitalize" href="'.route('admin.customer.view', [$dataSet->F_CUSTOMER_NO]).'">'.$dataSet->CUSTOMER_NAME.'</a>';
            $delivery_boy = DB::table('SLS_DELIVERY_HISTORY')->select('SA_USER.PK_NO', 'SA_USER.NAME','SA_USER.MOBILE_NO','SA_USER.MOBILE_NO', 'SA_USER.CODE')
            ->leftJoin('SA_USER', 'SA_USER.PK_NO', 'SLS_DELIVERY_HISTORY.F_DELIVERY_BOY_NO')
            ->where('SLS_DELIVERY_HISTORY.IS_ACTIVE',1)
            ->where('SLS_DELIVERY_HISTORY.F_BOOKING_NO',$dataSet->PK_NO)
            ->first();

            if($delivery_boy){
                $customer_name .= '<br><a class="text-capitalize" href="">Delivery man:'.$delivery_boy->NAME.'</a>';
            }
            return $customer_name;
        })
        ->addColumn('variantion', function($dataSet){
            $booking_no = $dataSet->PK_NO;
            $item = 0;
            $item_type = '';
            $query = [];

            $query = DB::SELECT("SELECT COUNT(*) AS ITEM_QTY  , sum(LINE_QTY) as TOTAL_ITEM
            FROM SLS_BOOKING_DETAILS WHERE SLS_BOOKING_DETAILS.F_BOOKING_NO = $booking_no GROUP BY SLS_BOOKING_DETAILS.F_BOOKING_NO ");

            if($query){
                $item_type ='<div title="Total Quantity/Total Item">'.$query[0]->TOTAL_ITEM.'/'.$query[0]->ITEM_QTY.'</div>';
            }
            return $item_type;
        })
        ->addColumn('price_after_dis', function($dataSet){
            $price_after_dis = number_format(($dataSet->TOTAL_PRICE) - $dataSet->DISCOUNT,2);
            return $price_after_dis;
        })
        ->addColumn('payment', function($dataSet){
            $payment = '';
            if($dataSet->ORDER_ACTUAL_TOPUP > 0 ){
                $payment .= '<div class="badge badge-success d-block" title="PAID">'.number_format($dataSet->ORDER_ACTUAL_TOPUP,2).'</div>';
            }
            if(($dataSet->TOTAL_PRICE) - $dataSet->ORDER_ACTUAL_TOPUP > 0 ){
                $payment .= '<div class="badge badge-danger d-block" title="DUE" >'.number_format(($dataSet->TOTAL_PRICE)  - $dataSet->DISCOUNT,2).'</div>';
            }
            return $payment;
        })
        ->addColumn('avaiable', function($dataSet){
            $avaiable = $dataSet->REQUEST_FOR . '('.$dataSet->PAYMENT_METHOD.')';

            return $avaiable;
        })
        ->addColumn('status', function($dataSet){
            $booking_status =  \Config::get('static_array.booking_status') ?? array();
            $status = $booking_status[$dataSet->BOOKING_STATUS] ?? '';
            return $status;
        })
        ->addColumn('admin_hold', function($dataSet){
            $roles = userRolePermissionArray();
            $admin_hold = '';
            // $agent_id            = Auth::user()->F_AGENT_NO;
            if (hasAccessAbility('edit_booking', $roles)) {
                if($dataSet->IS_ADMIN_HOLD == 0){
                    $admin_hold = '<label title=""><input type="checkbox" class="is_admin_hold" data-booking_id="'.$dataSet->PK_NO.'" /></label>';
                }elseif($dataSet->IS_ADMIN_HOLD == 1)
                {
                    $admin_hold = '<label title=""><input type="checkbox" class="is_admin_hold"  data-booking_id="'.$dataSet->PK_NO.'" checked/></label>';
                }
            }else{
                if($dataSet->IS_ADMIN_HOLD == 0){
                    $admin_hold = '<label title=""><input type="checkbox" class="is_admin_hold" data-booking_id="'.$dataSet->PK_NO.'" disabled /></label>';
                }elseif($dataSet->IS_ADMIN_HOLD == 1)
                {
                    $admin_hold = '<label title=""><input type="checkbox" class="is_admin_hold"  data-booking_id="'.$dataSet->PK_NO.'" checked disabled/></label>';
                }
            }
            return $admin_hold;
        })
        ->addColumn('self_pickup', function($dataSet){
            $roles = userRolePermissionArray();
            $self_pickup = '';
            if (hasAccessAbility('edit_booking', $roles)) {
                if($dataSet->IS_SELF_PICKUP == 0){
                    $self_pickup = '<label title=""><input type="checkbox" class="is_self_pickup" data-booking_id="'.$dataSet->PK_NO.'" /></label>';
                }elseif($dataSet->IS_SELF_PICKUP == 1)
                {
                    $self_pickup = '<label title=""><input type="checkbox" class="is_self_pickup"  data-booking_id="'.$dataSet->PK_NO.'" checked/></label>';
                }
            }else{
                if($dataSet->IS_SELF_PICKUP == 0){
                    $self_pickup = '<label title=""><input type="checkbox" class="is_self_pickup" data-booking_id="'.$dataSet->PK_NO.'" disabled /></label>';
                }elseif($dataSet->IS_SELF_PICKUP == 1)
                {
                    $self_pickup = '<label title=""><input type="checkbox" class="is_self_pickup"  data-booking_id="'.$dataSet->PK_NO.'" checked disabled/></label>';
                }
            }
            return $self_pickup;
        })
        ->addColumn('action', function($dataSet){
            $roles = userRolePermissionArray();
            $action = '';
            if (hasAccessAbility('view_booking', $roles)) {
            $action .=' <a href="'.route("admin.booking.view", [$dataSet->PK_NO]).'" class="btn btn-xs btn-primary mb-05 mr-05" title="View order"><i class="la la-eye"></i></a>';
            }
            $delivery_boy = DB::table('SLS_DELIVERY_HISTORY')->select('SA_USER.PK_NO', 'SA_USER.NAME','SA_USER.MOBILE_NO','SA_USER.MOBILE_NO', 'SA_USER.CODE')
            ->leftJoin('SA_USER', 'SA_USER.PK_NO', 'SLS_DELIVERY_HISTORY.F_DELIVERY_BOY_NO')
            ->where('SLS_DELIVERY_HISTORY.IS_ACTIVE',1)
            ->where('SLS_DELIVERY_HISTORY.F_BOOKING_NO',$dataSet->PK_NO)
            ->first();
            if(empty($delivery_boy)){
                if (hasAccessAbility('assign_deliveryman', $roles)) {
                    $action .=' <a href="#" class="btn btn-xs btn-primary mb-05 mr-05" shop-id="'.$dataSet->F_SHOP_NO.'" data-id="'.$dataSet->PK_NO.'" id="assign-deliveryman" title="Assign Delivery Man"><i class="la la-user-plus"></i></a>';
                }
            }
            if (hasAccessAbility('download_booking', $roles)) {
            $action .=' <a href="'.route("admin.booking.download_pdf", [$dataSet->PK_NO]).'" class="btn btn-xs btn-primary mb-05 mr-05 " title="Download Invoice"><i class="la la-download"></i></a>';
            }

            if (hasAccessAbility('edit_booking', $roles)) {
            $action .=' <a href="'.route('admin.booking.edit',$dataSet->PK_NO).'" class="btn btn-xs btn-info mb-05 mr-05" title="Edit"><i class="la la-edit"></i></a>';
            }
            $auth_id = Auth::user()->PK_NO;
            $role_id = AuthUserGroup::join('SA_USER','SA_USER.PK_NO','SA_USER_GROUP_USERS.F_USER_NO')
                                ->join('SA_USER_GROUP_ROLE','SA_USER_GROUP_ROLE.F_USER_GROUP_NO','SA_USER_GROUP_USERS.F_GROUP_NO')
                                ->select('F_ROLE_NO')->where('F_USER_NO',$auth_id)->first();
            if ($dataSet->IS_ADMIN_APPROVAL == 1 && $role_id->F_ROLE_NO == 1) {
                $action .= ' <a href="'.route('admin.booking_to_order.admin-approval',$dataSet->PK_NO).'" class="btn btn-xs btn-azura mb-05 mr-05" ><i class="ft-help-circle"></i></a>';
            }
            $price_after_dis = ($dataSet->TOTAL_PRICE) - $dataSet->DISCOUNT;
            $order_payment = $dataSet->ORDER_ACTUAL_TOPUP;
            if ((hasAccessAbility('delete_booking', $roles)) && ($price_after_dis <= 0 ) && ($order_payment <= 0 ) ) {
                $action .=' <a href="'.route('admin.booking.delete',$dataSet->PK_NO).'" class="btn btn-xs btn-danger mb-05 mr-05" onclick="return confirm('. "'" .'Are you sure you want to delete the order ?'. "'" .')"  ><i class="la la-trash"></i></a>';
                }
            return $action;
        })
        ->addColumn('altered', function($dataSet){
            if ($dataSet->IS_ADMIN_APPROVAL == 1) {
                return 'Altered';
            }else{
                return '';
            }
        })
        ->rawColumns(['SL','created_at','order_date','order_id','customer_name','variantion','price_after_dis','payment','avaiable','status','admin_hold','self_pickup','action','altered'])
        ->make(true);
    }


    public function getCancelOrder($request)
    {
        $cancel_type       = $request->type ?? 'canceled';
        $dataSet = DB::table("SLS_ORDER")
            ->select('SLS_ORDER.PK_NO','SLS_ORDER.F_BOOKING_NO','SLS_ORDER.F_CUSTOMER_NO','SLS_ORDER.F_SHOP_NO','SLS_ORDER.CUSTOMER_NAME','SLS_ORDER.IS_READY','SLS_BOOKING.SS_CREATED_ON','SA_USER.NAME as CREATED_BY','SLS_BOOKING.SHOP_NAME','SLS_BOOKING.CONFIRM_TIME as ORDER_DATE','SLS_BOOKING.BOOKING_NO','SLS_BOOKING.SHOP_NAME','SLS_BOOKING.TOTAL_PRICE','SLS_BOOKING.DISCOUNT','SLS_BOOKING.PK_NO as  SLS_BOOKING_PK_NO','SLS_BOOKING.IS_RETURN','SLS_ORDER.ORDER_BUFFER_TOPUP','SLS_ORDER.ORDER_ACTUAL_TOPUP','SLS_ORDER.IS_SYSTEM_HOLD','SLS_ORDER.IS_ADMIN_HOLD','SLS_ORDER.DISPATCH_STATUS','SLS_ORDER.IS_CANCEL','SLS_BOOKING.CANCEL_REQUEST_BY','SLS_BOOKING.CANCEL_REQUEST_AT','SLS_ORDER.IS_SELF_PICKUP','SLS_ORDER.IS_ADMIN_APPROVAL','SLS_BOOKING.BOOKING_NOTES','SLS_BOOKING.IS_READ_BOOKING_NOTES','SLS_BOOKING.IS_BUNDLE_MATCHED','SLS_BOOKING.CONFIRM_TIME','SLS_BOOKING.PENALTY_FEE','SLS_BOOKING.F_SHOP_NO'
            ,DB::raw('(select "'.$cancel_type.'" ) as cancel_type'))
            ->leftJoin('SLS_BOOKING','SLS_ORDER.F_BOOKING_NO','SLS_BOOKING.PK_NO')
            ->leftJoin('SA_USER','SLS_BOOKING.F_SS_CREATED_BY','SA_USER.PK_NO')
            ->whereRaw('SLS_ORDER.DISPATCH_STATUS < 40')
            ->where('DEFAULT_TYPE',0);
        if($cancel_type == 'cancelrequest'){
            $dataSet->where('SLS_ORDER.IS_CANCEL',2);
        }else{
            $dataSet->where('SLS_ORDER.IS_CANCEL',1);
        }

        $dataSet->orderBy('SLS_ORDER.PK_NO','DESC');
        return Datatables::of($dataSet)

        ->addColumn('created_at', function($dataSet){
            if ($dataSet->F_SHOP_NO == 19) {
                if($dataSet->IS_RETURN == 1){
                    $created_by = $dataSet->SHOP_NAME;
                }else{
                    $created_by = $dataSet->CUSTOMER_NAME;
                }
            }else{
                $created_by = $dataSet->CREATED_BY;
            }
            $created_at = '<div class="font-11">'.date('d-m-y h:i A',strtotime($dataSet->SS_CREATED_ON)).'</div><div>'.$created_by.'</div>';
            return $created_at;
        })
        ->addColumn('order_date', function($dataSet){
            if($dataSet->CONFIRM_TIME){
            $order_date = '<div>'.date('d-m-y',strtotime($dataSet->CONFIRM_TIME)).'</div>';
            }else{
                $order_date = '<div>'.date('d-m-y',strtotime($dataSet->SS_CREATED_ON)).'</div>';
            }
            return $order_date;
        })
        ->addColumn('order_id', function($dataSet){
            $order_id = '';
            $title = $dataSet->IS_BUNDLE_MATCHED == 1 ? 'The contains offer item' : '';
            $order_id .= '<a href="'.route("admin.booking.view", [$dataSet->SLS_BOOKING_PK_NO]).'" title="'.$title.'">ORD-'.$dataSet->BOOKING_NO.'</a>';
            if($dataSet->IS_BUNDLE_MATCHED == 1){
                $order_id .= '<i class="la la-gift pull-right text-azura"><i>';
            }
            return $order_id;
        })
        ->addColumn('customer_name', function($dataSet){

            if($dataSet->IS_RETURN == 1){
                $customer_name = '<a href="'.route("admin.seller.edit", [$dataSet->F_SHOP_NO]). '">'.$dataSet->SHOP_NAME.'</a>';
            }else{
                $customer_name = '<a href="'.route('admin.customer.view', [$dataSet->F_CUSTOMER_NO]).'">'.$dataSet->CUSTOMER_NAME.'</a>';
            }
            return $customer_name;
        })
       ->addColumn('item_type', function($dataSet){
            $booking_no = $dataSet->F_BOOKING_NO;
            $item = 0;
            $item_type = '';
            if($dataSet->cancel_type == 'cancelrequest'){
                $query = DB::SELECT("SELECT SLS_BOOKING_DETAILS.F_BOOKING_NO,INV_STOCK.F_PRD_VARIANT_NO, COUNT(*) AS ITEM_QTY  FROM SLS_BOOKING_DETAILS LEFT JOIN INV_STOCK ON INV_STOCK.PK_NO = SLS_BOOKING_DETAILS.F_INV_STOCK_NO WHERE SLS_BOOKING_DETAILS.F_BOOKING_NO = $booking_no GROUP BY INV_STOCK.F_PRD_VARIANT_NO ");
            }else{
                $query = DB::SELECT("SELECT SLS_BOOKING_DETAILS_AUD.F_BOOKING_NO,INV_STOCK.F_PRD_VARIANT_NO, COUNT(*) AS ITEM_QTY  FROM SLS_BOOKING_DETAILS_AUD LEFT JOIN INV_STOCK ON INV_STOCK.PK_NO = SLS_BOOKING_DETAILS_AUD.F_INV_STOCK_NO WHERE SLS_BOOKING_DETAILS_AUD.F_BOOKING_NO = $booking_no GROUP BY INV_STOCK.F_PRD_VARIANT_NO ");
            }


            if(!empty($query)){
                foreach($query as $variant){
                    $item +=  $variant->ITEM_QTY;
                }
            }

            $item_type_qty = count($query) ?? 0;
            if($item_type_qty > 1){
                $item_type ='<div title="Total Quantity/Total Item">'.$item.'/'.$item_type_qty.'</div>';
            }else{
                $item_type ='<div >'.$item_type_qty.'</div>';
            }
            return $item_type;
        })
        ->addColumn('price_after_dis', function($dataSet){
            if($dataSet->cancel_type == 'cancelrequest'){
                $order_val = $dataSet->TOTAL_PRICE;
            }else{
                $order_val = DB::table('SLS_BOOKING_DETAILS_AUD')->where('F_BOOKING_NO',$dataSet->F_BOOKING_NO)->where('SLS_BOOKING_DETAILS_AUD.CHANGE_TYPE','ORDER_CANCEL')->sum('LINE_PRICE');
            }
            return number_format(($order_val)-$dataSet->DISCOUNT,2);
        })
        ->addColumn('payment', function($dataSet){
            $payment = '';
            if($dataSet->ORDER_ACTUAL_TOPUP > 0 ){
                $payment .= '<div class="badge badge-success d-block" title="PAID AND VERIFIED">'.number_format($dataSet->ORDER_ACTUAL_TOPUP,2).'</div>';
            }

            if($dataSet->ORDER_BUFFER_TOPUP - $dataSet->ORDER_ACTUAL_TOPUP > 0 ){
                $payment .= '<div class="badge badge-warning d-block" title="PAID BUT NOT VERIFIED">'.number_format($dataSet->ORDER_BUFFER_TOPUP - $dataSet->ORDER_ACTUAL_TOPUP,2).'</div>';
            }
            if(($dataSet->TOTAL_PRICE) - $dataSet->DISCOUNT  - $dataSet->ORDER_BUFFER_TOPUP > 0 ){
                $payment .= '<div class="badge badge-danger d-block" title="DUE" >'.number_format(($dataSet->TOTAL_PRICE) - $dataSet->DISCOUNT -  $dataSet->ORDER_BUFFER_TOPUP,2).'</div>';
            }
            return $payment;
        })
        ->addColumn('avaiable', function($dataSet){
            $avaiable = '';
            $zones = '';
            $shelve_zones = DB::SELECT("SELECT GROUP_CONCAT(IFNULL(INV_STOCK.F_INV_ZONE_NO,0)) AS ZONES from SLS_BOOKING_DETAILS join INV_STOCK on INV_STOCK.PK_NO = SLS_BOOKING_DETAILS.F_INV_STOCK_NO where SLS_BOOKING_DETAILS.F_BOOKING_NO = $dataSet->F_BOOKING_NO GROUP BY SLS_BOOKING_DETAILS.F_BOOKING_NO ");

            if($dataSet->IS_READY == 0){
                $avaiable = '<div class="badge badge-primary d-block" title="NOT READY">Intransit</div>';
            }elseif($dataSet->IS_READY == 1){
                $avaiable = '<div class="badge badge-success d-block" title="READY">Ready</div>';
                if(!empty($shelve_zones)){
                    $zones  = $shelve_zones[0]->ZONES;
                    $zones_arr = explode(',', $zones);
                    if(in_array(0,$zones_arr)){
                        $avaiable = '<div class="badge badge-warning d-block " title="READY (Need to Shelve)">Ready</div>';
                    }
                }
            }elseif($dataSet->IS_READY == 2){
                $avaiable = '<div class="badge badge-warning d-block" title="PARTIALLY READY">Partially Ready</div>';
                if(!empty($shelve_zones)){
                    $zones  = $shelve_zones[0]->ZONES;
                    $zones_arr = explode(',', $zones);
                    if(in_array(0,$zones_arr)){
                        $avaiable = '<div class="badge badge-warning d-block  (Need to Shelve)" title="PARTIALLY READY">Partially</div>';
                    }
                }
            }
            return $avaiable;
        })
        ->addColumn('status', function($dataSet){
            if($dataSet->cancel_type == 'cancelrequest'){
                $status = 'Cancel Request';
            }else{
                $status = 'Canceled';
            }

            return $status;
        })
        ->addColumn('admin_hold', function($dataSet){
            $roles = userRolePermissionArray();
            $admin_hold = '';
            return $admin_hold;
        })
        ->addColumn('self_pickup', function($dataSet){
            $self_pickup = '';
            return $self_pickup;
        })
        ->addColumn('action', function($dataSet){
            $roles = userRolePermissionArray();
            $action = '';
            if (hasAccessAbility('view_booking', $roles)) {
                $action .=' <a href="'.route("admin.booking.view", [$dataSet->F_BOOKING_NO]).'" class="btn btn-xs btn-primary mb-05 mr-05" title="View order"><i class="la la-eye"></i></a>';
            }
            if($dataSet->cancel_type == 'cancelrequest'){
                if (hasAccessAbility('edit_booking', $roles)) {
                    $action .=' <a href="'.route('admin.booking.edit',$dataSet->F_BOOKING_NO).'" class="btn btn-xs btn-info mb-05 mr-05" title="Edit"><i class="la la-edit"></i></a>';
                }
            }
            return $action;
        })
        ->addColumn('altered', function($dataSet){
            if ($dataSet->IS_ADMIN_APPROVAL == 1) {
                return 'Altered';
            }else{
                return '';
            }
        })
        ->rawColumns(['created_at','order_date','order_id','customer_name','item_type','price_after_dis','payment','avaiable','status','admin_hold','self_pickup','action','altered'])
        ->make(true);
    }


    public function getDatatableAlteredOrder($request)
    {
        $agent_id            = Auth::user()->F_AGENT_NO;
        $dispatch_type       = $request->dispatch ?? '0';
        $dataSet = DB::table("SLS_ORDER")
            ->select('SLS_ORDER.PK_NO','SLS_ORDER.F_BOOKING_NO','SLS_ORDER.F_CUSTOMER_NO','SLS_ORDER.F_SHOP_NO','SLS_ORDER.CUSTOMER_NAME','SLS_ORDER.IS_READY','SLS_BOOKING.SS_CREATED_ON','SA_USER.NAME as CREATED_BY','SLS_BOOKING.SHOP_NAME','SLS_BOOKING.CONFIRM_TIME as ORDER_DATE','SLS_BOOKING.BOOKING_NO','SLS_BOOKING.SHOP_NAME','SLS_BOOKING.TOTAL_PRICE','SLS_BOOKING.DISCOUNT','SLS_BOOKING.PK_NO as  SLS_BOOKING_PK_NO','SLS_BOOKING.IS_RETURN','SLS_ORDER.ORDER_BUFFER_TOPUP','SLS_ORDER.ORDER_ACTUAL_TOPUP','SLS_ORDER.IS_SYSTEM_HOLD','SLS_ORDER.IS_ADMIN_HOLD','SLS_ORDER.DISPATCH_STATUS','SLS_ORDER.IS_CANCEL','SLS_BOOKING.CANCEL_REQUEST_BY','SLS_BOOKING.CANCEL_REQUEST_AT','SLS_ORDER.IS_SELF_PICKUP','SLS_ORDER.IS_ADMIN_APPROVAL','SLS_BOOKING.CONFIRM_TIME','SLS_BOOKING.IS_BUNDLE_MATCHED','SLS_BOOKING.PENALTY_FEE','SLS_BOOKING.F_SHOP_NO'
            ,DB::raw('(select "'.$dispatch_type.'" ) as dispatch_type'))
            ->leftJoin('SLS_BOOKING','SLS_ORDER.F_BOOKING_NO','SLS_BOOKING.PK_NO')
            ->leftJoin('SA_USER','SLS_BOOKING.F_SS_CREATED_BY','SA_USER.PK_NO')
           ->where('SLS_ORDER.DISPATCH_STATUS', '<', '40')
            ->where('SLS_ORDER.IS_ADMIN_APPROVAL', 1);

            if ($agent_id > 0) {
                $dataSet->where('SLS_BOOKING.F_SHOP_NO',$agent_id);
            }
        if($request->id){
            if($request->type == 'customer'){
                $dataSet->where('SLS_ORDER.F_CUSTOMER_NO',$request->id);
            }elseif($request->type == 'seller'){
                $dataSet->where('SLS_ORDER.F_SHOP_NO',$request->id);
            }

        }
        if($request->dispatch){
            if($request->dispatch == 'rts'){
                $dataSet->whereIn('SLS_ORDER.DISPATCH_STATUS',[30,20])->where('SLS_ORDER.IS_SELF_PICKUP',0);
                $dataSet->where('SLS_ORDER.PICKUP_ID',0);
            }
            if($request->dispatch == 'cod_rtc'){
                $dataSet->where('IS_READY','!=',0)->where('SLS_ORDER.IS_SELF_PICKUP',1);
            }
        }
        $dataSet->orderBy('SLS_ORDER.PK_NO','DESC');

        return Datatables::of($dataSet)

        ->addColumn('created_at', function($dataSet){
            if ($dataSet->F_SHOP_NO == 19) {
                if($dataSet->IS_RETURN == 1){
                    $created_by = $dataSet->SHOP_NAME;
                }else{
                    $created_by = $dataSet->CUSTOMER_NAME;
                }
            }else{
                $created_by = $dataSet->CREATED_BY;
            }
            $created_at = '<div class="font-11">'.date('d-m-y h:i A',strtotime($dataSet->SS_CREATED_ON)).'</div><div>'.$created_by.'</div>';
            return $created_at;
        })
        ->addColumn('order_date', function($dataSet){
            if($dataSet->CONFIRM_TIME){
            $order_date = '<div>'.date('d-m-y',strtotime($dataSet->CONFIRM_TIME)).'</div>';
            }else{
                $order_date = '<div>'.date('d-m-y',strtotime($dataSet->SS_CREATED_ON)).'</div>';
            }
            return $order_date;
        })
        ->addColumn('order_id', function($dataSet){
            $order_id = '';
            $title = $dataSet->IS_BUNDLE_MATCHED == 1 ? 'The contains offer item' : '';
            $order_id .= '<a href="'.route("admin.booking.view", [$dataSet->SLS_BOOKING_PK_NO]).'" title="'.$title.'">ORD-'.$dataSet->BOOKING_NO.'</a>';
            if($dataSet->IS_BUNDLE_MATCHED == 1){
                $order_id .= '<i class="la la-gift pull-right text-azura"><i>';
            }
            return $order_id;
        })
        ->addColumn('customer_name', function($dataSet){

            if($dataSet->IS_RETURN == 1){
                $customer_name = '<a href="'.route("admin.seller.edit", [$dataSet->F_SHOP_NO]). '">'.$dataSet->SHOP_NAME.'</a>';
            }else{
                $customer_name = '<a href="'.route('admin.customer.view', [$dataSet->F_CUSTOMER_NO]).'">'.$dataSet->CUSTOMER_NAME.'</a>';
            }
            return $customer_name;
        })
       ->addColumn('item_type', function($dataSet){
            $booking_no = $dataSet->F_BOOKING_NO;
            $item = 0;
            $item_type = '';

            $query = DB::SELECT("SELECT SLS_BOOKING_DETAILS.F_BOOKING_NO,INV_STOCK.F_PRD_VARIANT_NO, COUNT(*) AS ITEM_QTY  FROM SLS_BOOKING_DETAILS LEFT JOIN INV_STOCK ON INV_STOCK.PK_NO = SLS_BOOKING_DETAILS.F_INV_STOCK_NO WHERE SLS_BOOKING_DETAILS.F_BOOKING_NO = $booking_no GROUP BY INV_STOCK.F_PRD_VARIANT_NO ");
            if(!empty($query)){
                foreach($query as $variant){
                    $item +=  $variant->ITEM_QTY;
                }
            }

            $item_type_qty = count($query) ?? 0;
            if($item_type_qty > 1){
                $item_type ='<div title="Total Quantity/Total Item">'.$item.'/'.$item_type_qty.'</div>';
            }else{
                $item_type ='<div >'.$item_type_qty.'</div>';
            }

            return $item_type;
        })
        ->addColumn('price_after_dis', function($dataSet){

            $price_after_dis = number_format(($dataSet->TOTAL_PRICE) - $dataSet->DISCOUNT,2);

            return $price_after_dis;
        })
        ->addColumn('payment', function($dataSet){
            $payment = '';
            if($dataSet->ORDER_ACTUAL_TOPUP > 0 ){
                $payment .= '<div class="badge badge-success d-block" title="PAID AND VERIFIED">'.number_format($dataSet->ORDER_ACTUAL_TOPUP,2).'</div>';
            }

            if($dataSet->ORDER_BUFFER_TOPUP - $dataSet->ORDER_ACTUAL_TOPUP > 0 ){
                $payment .= '<div class="badge badge-warning d-block" title="PAID BUT NOT VERIFIED">'.number_format($dataSet->ORDER_BUFFER_TOPUP - $dataSet->ORDER_ACTUAL_TOPUP,2).'</div>';
            }
            if(($dataSet->TOTAL_PRICE) - $dataSet->DISCOUNT  - $dataSet->ORDER_BUFFER_TOPUP > 0 ){
                $payment .= '<div class="badge badge-danger d-block" title="DUE" >'.number_format(($dataSet->TOTAL_PRICE) - $dataSet->ORDER_BUFFER_TOPUP,2).'</div>';
            }
            return $payment;
        })
        ->addColumn('avaiable', function($dataSet){
            $avaiable = '';
            $zones = '';
            $shelve_zones = DB::SELECT("SELECT GROUP_CONCAT(IFNULL(INV_STOCK.F_INV_ZONE_NO,0)) AS ZONES from SLS_BOOKING_DETAILS join INV_STOCK on INV_STOCK.PK_NO = SLS_BOOKING_DETAILS.F_INV_STOCK_NO where SLS_BOOKING_DETAILS.F_BOOKING_NO = $dataSet->F_BOOKING_NO GROUP BY SLS_BOOKING_DETAILS.F_BOOKING_NO ");

            if($dataSet->IS_READY == 0){
                $avaiable = '<div class="badge badge-primary d-block" title="NOT READY">Intransit</div>';
            }elseif($dataSet->IS_READY == 1){
                $avaiable = '<div class="badge badge-success d-block" title="READY">Ready</div>';
                if(!empty($shelve_zones)){
                    $zones  = $shelve_zones[0]->ZONES;
                    $zones_arr = explode(',', $zones);
                    if(in_array(0,$zones_arr)){
                        $avaiable = '<div class="badge badge-warning d-block " title="READY (Need to Shelve)">Ready</div>';
                    }
                }
            }elseif($dataSet->IS_READY == 2){
                $avaiable = '<div class="badge badge-warning d-block" title="PARTIALLY READY">Partially Ready</div>';
                if(!empty($shelve_zones)){
                    $zones  = $shelve_zones[0]->ZONES;
                    $zones_arr = explode(',', $zones);
                    if(in_array(0,$zones_arr)){
                        $avaiable = '<div class="badge badge-warning d-block  (Need to Shelve)" title="PARTIALLY READY">Partially</div>';
                    }
                }
            }
            return $avaiable;
        })
        ->addColumn('status', function($dataSet){

            $status = '';
            if($dataSet->IS_ADMIN_HOLD == 0){
                /*NO ACTION BY ADMIN*/
                $assigned_user = DB::SELECT("SELECT RTS_COLLECTION_USER_ID FROM SLS_BOOKING_DETAILS WHERE F_BOOKING_NO = $dataSet->F_BOOKING_NO");
                $assigned_user = count($assigned_user) ?? 0;
                if ($dataSet->dispatch_type == 'rts' || $dataSet->dispatch_type == 'cod_rtc') {
                    $rts_link = '<a href="'.route("admin.order.dispatch",[$dataSet->F_BOOKING_NO]).'?type=rts">RTS</a>';
                }else{
                    $rts_link = '<a href="javascript:void(0)">RTS</a>';
                }
                if($dataSet->DISPATCH_STATUS == '40'){
                    $status = '<div class="badge badge-success d-block" title="DISPACTHED">Dispacthed</div>';
                }elseif($dataSet->DISPATCH_STATUS == '30'){
                    $status = '<div class="badge badge-success d-block" title="READY TO SHIP">'.$rts_link.'</div>';
                }elseif($dataSet->DISPATCH_STATUS == '20'){
                    $status = '<div class="badge badge-success d-block" title="READY TO COLLECT (Partially)"><a href="'.route("admin.order.dispatch",[$dataSet->F_BOOKING_NO]).'?type=rts">RTS(H)</a></div>';
                }elseif($dataSet->DISPATCH_STATUS == '10'){
                    $status = '<div class="badge badge-success d-block" title="DISPACTHED (Partially)">Dispacthed(H)</div>';
                }
            }else{
                /*ALL ADMIN ACTION*/
                if($dataSet->IS_ADMIN_HOLD == 1){
                    $status = '<div class="badge badge-warning d-block" title="HOLD">HOLD</div>';
                }
            }

            if($dataSet->IS_CANCEL == '1'){
                $status .= '<div class="badge badge-warning d-block" title="Canceled">Canceled</div>';
            }elseif($dataSet->IS_CANCEL == '2'){
                $status .= '<div class="badge badge-warning d-block" title="Cancele Request Pending">CR</div>';
            }

            if($dataSet->IS_SELF_PICKUP == 1){

                $due_amt = ($dataSet->TOTAL_PRICE) - $dataSet->DISCOUNT - $dataSet->ORDER_BUFFER_TOPUP;
                if ($dataSet->dispatch_type == 'rts' || $dataSet->dispatch_type == 'cod_rtc') {
                    $cod_link = route("admin.order.dispatch",[$dataSet->F_BOOKING_NO]).'?type=cod';
                }else{
                    $cod_link = 'javascript:void(0)';
                }
                if($due_amt > 0 ){
                    $status = '<div class="badge badge-warning d-block" title="CASH ON DELIVERY"><a href="'.$cod_link.'">COD</a></div>';
                }else{
                    $status = '<div class="badge badge-warning d-block" title="READY TO SELF PICKUP BY CUSTOMER"><a href="'.$cod_link.'">RTC</a></div>';
                }

            }
            if($status == ''){
                if($dataSet->IS_SYSTEM_HOLD == 1)
                    {
                        $status = '<div class="badge badge-default d-block" title="In Processing"><i class="la la-spinner spinner"></i></div>';
                    }
            }
            if ($dataSet->IS_ADMIN_APPROVAL == 1) {
                $status .= '<div class="badge badge-danger d-block" title="DATA IS ALTERED NEED ADMIN APPROVAL">ALTERED</div>';
            }
            return $status;
        })
        ->addColumn('admin_hold', function($dataSet){
            $roles = userRolePermissionArray();
            $admin_hold = '';
            if (hasAccessAbility('edit_booking', $roles)) {
                if($dataSet->IS_ADMIN_HOLD == 0){
                    $admin_hold = '<label title=""><input type="checkbox" class="is_admin_hold" data-booking_id="'.$dataSet->F_BOOKING_NO.'" /></label>';
                }elseif($dataSet->IS_ADMIN_HOLD == 1)
                {
                    $admin_hold = '<label title=""><input type="checkbox" class="is_admin_hold"  data-booking_id="'.$dataSet->F_BOOKING_NO.'" checked/></label>';
                }
            }else{
                if($dataSet->IS_ADMIN_HOLD == 0){
                    $admin_hold = '<label title=""><input type="checkbox" class="is_admin_hold" data-booking_id="'.$dataSet->F_BOOKING_NO.'" disabled /></label>';
                }elseif($dataSet->IS_ADMIN_HOLD == 1)
                {
                    $admin_hold = '<label title=""><input type="checkbox" class="is_admin_hold"  data-booking_id="'.$dataSet->F_BOOKING_NO.'" checked disabled/></label>';
                }
            }
            return $admin_hold;
        })
        ->addColumn('self_pickup', function($dataSet){
            $roles = userRolePermissionArray();
            $self_pickup = '';

            if (hasAccessAbility('edit_booking', $roles)) {
                if($dataSet->IS_SELF_PICKUP == 0){
                    $self_pickup = '<button type="button" title="IS SELF PICKUP" class="btn btn-xs btn-success mb-05 mr-05 self_pick" data-booking_id="'.$dataSet->F_BOOKING_NO.'" data-toggle="modal" data-target="#self_pick_modal">SP</button>';

                }elseif($dataSet->IS_SELF_PICKUP == 1)
                {
                    $rtc = OrderRtc::select('BANK_ACC_NAME','F_ACC_PAYMENT_BANK_NO','IS_REQUEST_PENDING')->where('F_BOOKING_NO',$dataSet->F_BOOKING_NO)->first();
                    $bank_acc_name = $rtc->BANK_ACC_NAME ?? '';
                    $bank_acc_no = $rtc->F_ACC_PAYMENT_BANK_NO ?? '';

                    if($rtc){
                        if($rtc->IS_REQUEST_PENDING == 1){
                            $btn_class = 'btn-warning';
                            $title = 'SELF PICKUP (PENDING FOR DISPATCH MANAGER APPROVAL)';
                        }else{
                            $btn_class = 'btn-success';
                            $title = 'SELF PICKUP';

                        }
                        if(($rtc->IS_CONFIRM_HOLDER == 0) && ($rtc->IS_REQUEST_PENDING == 0)){
                            $title = 'SELF PICKUP (PENDING FOR ORDER ITEM RECEIVED BY AGENT)';
                        }
                    }else{
                        $btn_class = "";
                        $title = "";
                    }

                    $self_pickup = '<button type="button" title="'.$title.'" class="btn btn-xs '.$btn_class.' mb-05 mr-05 self_pick" data-booking_id="'.$dataSet->F_BOOKING_NO.'" data-rtc_no="'.$bank_acc_no.'" data-toggle="modal" data-target="#self_pick_modal">'.$bank_acc_name.'</button>';

                }
            }else{
                if($dataSet->IS_SELF_PICKUP == 0){
                    $self_pickup = '<button type="button" title="IS SELF PICKUP" class="btn btn-xs btn-info mb-05 mr-05 self_pick" data-booking_id="'.$dataSet->F_BOOKING_NO.'" data-toggle="modal" data-target="#self_pick_modal" disabled>SP</button>';
                }elseif($dataSet->IS_SELF_PICKUP == 1)
                {
                    $rtc = OrderRtc::select('BANK_ACC_NAME','F_ACC_PAYMENT_BANK_NO')->where('F_BOOKING_NO',$dataSet->F_BOOKING_NO)->first();
                    $bank_acc_name = $rtc->BANK_ACC_NAME ?? '';
                    $bank_acc_no = $rtc->F_ACC_PAYMENT_BANK_NO ?? '';
                    $self_pickup = '<button type="button" title="IS SELF PICKUP" class="btn btn-xs btn-success mb-05 mr-05 self_pick" data-booking_id="'.$dataSet->F_BOOKING_NO.'" data-rtc_no="'.$bank_acc_no.'" data-toggle="modal" data-target="#self_pick_modal" disabled>'.$bank_acc_name.'</button>';
                }
            }

            return $self_pickup;
        })



        ->addColumn('action', function($dataSet){
            $roles = userRolePermissionArray();
            $action = '';
            if ($dataSet->IS_ADMIN_APPROVAL == 1) {
                $action .= ' <a href="'.route('admin.booking_to_order.admin-approval',$dataSet->F_BOOKING_NO).'" class="btn btn-xs btn-warning mb-05 mr-05" ><i class="ft-help-circle"></i></a>';

            }
            return $action;
        })
        ->addColumn('altered', function($dataSet){
            if ($dataSet->IS_ADMIN_APPROVAL == 1) {
                return 'Altered';
            }else{
                return '';
            }
        })

        ->rawColumns(['created_at','order_date','order_id','customer_name','item_type','price_after_dis','payment','avaiable','status','admin_hold','self_pickup','action','altered'])
        ->make(true);
    }

    public function getDatatableDefaultOrder($request)
    {
        $agent_id       = Auth::user()->F_AGENT_NO;
        $dispatch_type  = $request->dispatch ?? '0';
        $now            = Carbon::now()->subDays(7)->toDateString();

        $dataSet = DB::table("SLS_ORDER")
            ->select('SLS_ORDER.PK_NO','SLS_ORDER.F_BOOKING_NO','SLS_ORDER.F_CUSTOMER_NO','SLS_ORDER.F_SHOP_NO','SLS_ORDER.CUSTOMER_NAME','SLS_ORDER.IS_READY','SLS_BOOKING.SS_CREATED_ON','SA_USER.NAME as CREATED_BY','SLS_BOOKING.SHOP_NAME','SLS_BOOKING.CONFIRM_TIME as ORDER_DATE','SLS_BOOKING.BOOKING_NO','SLS_BOOKING.SHOP_NAME','SLS_BOOKING.TOTAL_PRICE','SLS_BOOKING.DISCOUNT','SLS_BOOKING.PK_NO as  SLS_BOOKING_PK_NO','SLS_BOOKING.IS_RETURN','SLS_ORDER.ORDER_BUFFER_TOPUP','SLS_ORDER.ORDER_ACTUAL_TOPUP','SLS_ORDER.IS_SYSTEM_HOLD','SLS_ORDER.IS_ADMIN_HOLD','SLS_ORDER.DISPATCH_STATUS','SLS_ORDER.IS_CANCEL','SLS_BOOKING.CANCEL_REQUEST_BY','SLS_BOOKING.CANCEL_REQUEST_AT','SLS_ORDER.IS_SELF_PICKUP','SLS_ORDER.IS_ADMIN_APPROVAL','SLS_BOOKING.CONFIRM_TIME','SLS_BOOKING.IS_BUNDLE_MATCHED','DEFAULT_TYPE','SLS_NOTIFICATION.IS_SEND','SLS_NOTIFICATION.PK_NO as sms_pk','SLS_BOOKING.PENALTY_FEE','SLS_BOOKING.F_SHOP_NO','DEFAULT_AT'
            ,DB::raw('(select "'.$dispatch_type.'" ) as dispatch_type')
            // ,DB::raw('(DEFAULT_AT + interval 7 day ) as DEFAULT_AT')
            )
            ->leftJoin('SLS_BOOKING','SLS_ORDER.F_BOOKING_NO','SLS_BOOKING.PK_NO')
            ->leftJoin('SA_USER','SLS_BOOKING.F_SS_CREATED_BY','SA_USER.PK_NO')
            ->Join('SLS_NOTIFICATION','SLS_NOTIFICATION.F_BOOKING_NO','SLS_ORDER.F_BOOKING_NO')
            ->where('SLS_ORDER.DISPATCH_STATUS', '<', '40')
            ->where('SLS_ORDER.IS_DEFAULT',1)
            // ->whereNotNull('SLS_ORDER.DEFAULT_AT')
            ->whereNull('SLS_ORDER.GRACE_TIME')
            ->whereRaw('((SLS_NOTIFICATION.IS_SEND = 0 OR SLS_NOTIFICATION.SEND_AT > "'.$now.'") AND SLS_NOTIFICATION.TYPE = "Default")')
            ;
            if ($agent_id > 0) {
                $dataSet->where('SLS_BOOKING.F_SHOP_NO',$agent_id);
            }
        if($request->id){
            if($request->type == 'customer'){
                $dataSet->where('SLS_ORDER.F_CUSTOMER_NO',$request->id);
            }elseif($request->type == 'seller'){
                $dataSet->where('SLS_ORDER.F_SHOP_NO',$request->id);
            }

        }
        if($request->dispatch){
            if($request->dispatch == 'rts'){
                $dataSet->whereIn('SLS_ORDER.DISPATCH_STATUS',[30,20])->where('SLS_ORDER.IS_SELF_PICKUP',0);

            }
            if($request->dispatch == 'cod_rtc'){
                $dataSet->where('IS_READY','!=',0)->where('SLS_ORDER.IS_SELF_PICKUP',1);
            }
        }
        // $dataSet->orderBy('SLS_ORDER.PK_NO','DESC');
        $dataSet->orderBy('SLS_ORDER.DEFAULT_AT','DESC')
                // ->groupBy('SLS_ORDER.F_BOOKING_NO')
                ;

        return Datatables::of($dataSet)

        ->addColumn('created_at', function($dataSet){
            if ($dataSet->F_SHOP_NO == 19) {
                if($dataSet->IS_RETURN == 1){
                    $created_by = $dataSet->SHOP_NAME;
                }else{
                    $created_by = $dataSet->CUSTOMER_NAME;
                }
            }else{
                $created_by = $dataSet->CREATED_BY;
            }
            $created_at = '<div class="font-11">'.date('d-m-y h:i A',strtotime($dataSet->SS_CREATED_ON)).'</div><div>'.$created_by.'</div>';
            return $created_at;
        })
        ->addColumn('order_date', function($dataSet){
            if($dataSet->CONFIRM_TIME){
            $order_date = '<div>'.date('d-m-y',strtotime($dataSet->CONFIRM_TIME)).'</div>';
            }else{
                $order_date = '<div>'.date('d-m-y',strtotime($dataSet->SS_CREATED_ON)).'</div>';
            }
            return $order_date;
        })
        ->addColumn('order_id', function($dataSet){
            $order_id = '';
            $title = $dataSet->IS_BUNDLE_MATCHED == 1 ? 'The contains offer item' : '';
            $order_id .= '<a href="'.route("admin.booking.view", [$dataSet->SLS_BOOKING_PK_NO]).'" title="'.$title.'">ORD-'.$dataSet->BOOKING_NO.'</a>';
            if($dataSet->IS_BUNDLE_MATCHED == 1){
                $order_id .= '<i class="la la-gift pull-right text-azura"><i>';
            }
            return $order_id;
        })
        ->addColumn('customer_name', function($dataSet){

            if($dataSet->IS_RETURN == 1){
                $customer_name = '<a href="'.route("admin.seller.edit", [$dataSet->F_SHOP_NO]). '">'.$dataSet->SHOP_NAME.'</a>';
            }else{
                $customer_name = '<a href="'.route('admin.customer.view', [$dataSet->F_CUSTOMER_NO]).'">'.$dataSet->CUSTOMER_NAME.'</a>';
            }
            return $customer_name;
        })
       ->addColumn('item_type', function($dataSet){
            $booking_no = $dataSet->F_BOOKING_NO;
            $item = 0;
            $item_type = '';

            $query = DB::SELECT("SELECT SLS_BOOKING_DETAILS.F_BOOKING_NO,INV_STOCK.F_PRD_VARIANT_NO, COUNT(*) AS ITEM_QTY  FROM SLS_BOOKING_DETAILS LEFT JOIN INV_STOCK ON INV_STOCK.PK_NO = SLS_BOOKING_DETAILS.F_INV_STOCK_NO WHERE SLS_BOOKING_DETAILS.F_BOOKING_NO = $booking_no GROUP BY INV_STOCK.F_PRD_VARIANT_NO ");
            if(!empty($query)){
                foreach($query as $variant){
                    $item +=  $variant->ITEM_QTY;
                }
            }

            $item_type_qty = count($query) ?? 0;
            if($item_type_qty > 1){
                $item_type ='<div title="Total Quantity/Total Item">'.$item.'/'.$item_type_qty.'</div>';
            }else{
                $item_type ='<div >'.$item_type_qty.'</div>';
            }

            return $item_type;
        })
        ->addColumn('price_after_dis', function($dataSet){

            $price_after_dis = number_format(($dataSet->TOTAL_PRICE) - $dataSet->DISCOUNT,2);

            return $price_after_dis;
        })
        ->addColumn('payment', function($dataSet){
            $payment = '';
            if($dataSet->ORDER_ACTUAL_TOPUP > 0 ){
                $payment .= '<div class="badge badge-success d-block" title="PAID AND VERIFIED">'.number_format($dataSet->ORDER_ACTUAL_TOPUP,2).'</div>';
            }

            if($dataSet->ORDER_BUFFER_TOPUP - $dataSet->ORDER_ACTUAL_TOPUP > 0 ){
                $payment .= '<div class="badge badge-warning d-block" title="PAID BUT NOT VERIFIED">'.number_format($dataSet->ORDER_BUFFER_TOPUP - $dataSet->ORDER_ACTUAL_TOPUP,2).'</div>';
            }
            if(($dataSet->TOTAL_PRICE) - $dataSet->DISCOUNT  - $dataSet->ORDER_BUFFER_TOPUP > 0 ){
                $payment .= '<div class="badge badge-danger d-block" title="DUE" >'.number_format(($dataSet->TOTAL_PRICE) - $dataSet->ORDER_BUFFER_TOPUP,2).'</div>';
            }
            return $payment;
        })
        ->addColumn('avaiable', function($dataSet){
            $avaiable = '';
            $zones = '';
            $shelve_zones = DB::SELECT("SELECT GROUP_CONCAT(IFNULL(INV_STOCK.F_INV_ZONE_NO,0)) AS ZONES from SLS_BOOKING_DETAILS join INV_STOCK on INV_STOCK.PK_NO = SLS_BOOKING_DETAILS.F_INV_STOCK_NO where SLS_BOOKING_DETAILS.F_BOOKING_NO = $dataSet->F_BOOKING_NO GROUP BY SLS_BOOKING_DETAILS.F_BOOKING_NO ");

            if($dataSet->IS_READY == 0){
                $avaiable = '<div class="badge badge-primary d-block" title="NOT READY">Intransit</div>';
            }elseif($dataSet->IS_READY == 1){
                $avaiable = '<div class="badge badge-success d-block" title="READY">Ready</div>';
                if(!empty($shelve_zones)){
                    $zones  = $shelve_zones[0]->ZONES;
                    $zones_arr = explode(',', $zones);
                    if(in_array(0,$zones_arr)){
                        $avaiable = '<div class="badge badge-warning d-block " title="READY (Need to Shelve)">Ready</div>';
                    }
                }
            }elseif($dataSet->IS_READY == 2){
                $avaiable = '<div class="badge badge-warning d-block" title="PARTIALLY READY">Partially Ready</div>';
                if(!empty($shelve_zones)){
                    $zones  = $shelve_zones[0]->ZONES;
                    $zones_arr = explode(',', $zones);
                    if(in_array(0,$zones_arr)){
                        $avaiable = '<div class="badge badge-warning d-block  (Need to Shelve)" title="PARTIALLY READY">Partially</div>';
                    }
                }
            }
            return $avaiable;
        })
        ->addColumn('status', function($dataSet){

            $status = '';
            if($dataSet->IS_ADMIN_HOLD == 0){
                /*NO ACTION BY ADMIN*/
                $assigned_user = DB::SELECT("SELECT RTS_COLLECTION_USER_ID FROM SLS_BOOKING_DETAILS WHERE F_BOOKING_NO = $dataSet->F_BOOKING_NO");
                $assigned_user = count($assigned_user) ?? 0;
                if ($dataSet->dispatch_type == 'rts' || $dataSet->dispatch_type == 'cod_rtc') {
                    $rts_link = '<a href="'.route("admin.order.dispatch",[$dataSet->F_BOOKING_NO]).'?type=rts">RTS</a>';
                }else{
                    $rts_link = '<a href="javascript:void(0)">RTS</a>';
                }
                if($dataSet->DISPATCH_STATUS == '40'){
                    $status = '<div class="badge badge-success d-block" title="DISPACTHED">Dispacthed</div>';
                }elseif($dataSet->DISPATCH_STATUS == '30'){
                    $status = '<div class="badge badge-success d-block" title="READY TO SHIP">'.$rts_link.'</div>';
                }elseif($dataSet->DISPATCH_STATUS == '20'){
                    $status = '<div class="badge badge-success d-block" title="READY TO COLLECT (Partially)"><a href="'.route("admin.order.dispatch",[$dataSet->F_BOOKING_NO]).'?type=rts">RTS(H)</a></div>';
                }elseif($dataSet->DISPATCH_STATUS == '10'){
                    $status = '<div class="badge badge-success d-block" title="DISPACTHED (Partially)">Dispacthed(H)</div>';
                }
            }else{
                /*ALL ADMIN ACTION*/
                if($dataSet->IS_ADMIN_HOLD == 1){
                    $status = '<div class="badge badge-warning d-block" title="HOLD">HOLD</div>';
                }
            }

            if($dataSet->IS_CANCEL == '1'){
                $status .= '<div class="badge badge-warning d-block" title="Canceled">Canceled</div>';
            }elseif($dataSet->IS_CANCEL == '2'){
                $status .= '<div class="badge badge-warning d-block" title="Cancele Request Pending">CR</div>';
            }

            if($dataSet->IS_SELF_PICKUP == 1){

                $due_amt = ($dataSet->TOTAL_PRICE) - $dataSet->DISCOUNT - $dataSet->ORDER_BUFFER_TOPUP;
                if ($dataSet->dispatch_type == 'rts' || $dataSet->dispatch_type == 'cod_rtc') {
                    $cod_link = route("admin.order.dispatch",[$dataSet->F_BOOKING_NO]).'?type=cod';
                }else{
                    $cod_link = 'javascript:void(0)';
                }
                if($due_amt > 0 ){
                    $status = '<div class="badge badge-warning d-block" title="CASH ON DELIVERY"><a href="'.$cod_link.'">COD</a></div>';
                }else{
                    $status = '<div class="badge badge-warning d-block" title="READY TO SELF PICKUP BY CUSTOMER"><a href="'.$cod_link.'">RTC</a></div>';
                }

            }
            if($status == ''){
                if($dataSet->IS_SYSTEM_HOLD == 1)
                    {
                        $status = '<div class="badge badge-default d-block" title="In Processing"><i class="la la-spinner spinner"></i></div>';
                    }
            }
            if ($dataSet->IS_ADMIN_APPROVAL == 1) {
                $status .= '<div class="badge badge-danger d-block" title="DATA IS ALTERED NEED ADMIN APPROVAL">ALTERED</div>';
            }
            return $status;
        })
        ->addColumn('admin_hold', function($dataSet){
            $roles = userRolePermissionArray();
            $admin_hold = '';
            // $agent_id            = Auth::user()->F_AGENT_NO;
            if (hasAccessAbility('edit_booking', $roles)) {
                if($dataSet->IS_ADMIN_HOLD == 0){
                    $admin_hold = '<label title=""><input type="checkbox" class="is_admin_hold" data-booking_id="'.$dataSet->F_BOOKING_NO.'" /></label>';
                }elseif($dataSet->IS_ADMIN_HOLD == 1)
                {
                    $admin_hold = '<label title=""><input type="checkbox" class="is_admin_hold"  data-booking_id="'.$dataSet->F_BOOKING_NO.'" checked/></label>';
                }
            }else{
                if($dataSet->IS_ADMIN_HOLD == 0){
                    $admin_hold = '<label title=""><input type="checkbox" class="is_admin_hold" data-booking_id="'.$dataSet->F_BOOKING_NO.'" disabled /></label>';
                }elseif($dataSet->IS_ADMIN_HOLD == 1)
                {
                    $admin_hold = '<label title=""><input type="checkbox" class="is_admin_hold"  data-booking_id="'.$dataSet->F_BOOKING_NO.'" checked disabled/></label>';
                }
            }
            return $admin_hold;
        })
        ->addColumn('self_pickup', function($dataSet){
            $roles = userRolePermissionArray();
            $self_pickup = '';
            // $agent_id            = Auth::user()->F_AGENT_NO;

            if (hasAccessAbility('edit_booking', $roles)) {
                if($dataSet->IS_SELF_PICKUP == 0){
                    $self_pickup = '<button type="button" title="IS SELF PICKUP" class="btn btn-xs btn-success mb-05 mr-05 self_pick" data-booking_id="'.$dataSet->F_BOOKING_NO.'" data-toggle="modal" data-target="#self_pick_modal">SP</button>';

                    // $self_pickup = '<label title=""><input type="checkbox" class="is_self_pickup" data-booking_id="'.$dataSet->F_BOOKING_NO.'"/></label>';
                }elseif($dataSet->IS_SELF_PICKUP == 1)
                {
                    $rtc = OrderRtc::select('BANK_ACC_NAME','F_ACC_PAYMENT_BANK_NO','IS_REQUEST_PENDING')->where('F_BOOKING_NO',$dataSet->F_BOOKING_NO)->first();
                    // $self_pickup = '<label title=""><input type="checkbox" class="is_self_pickup" data-booking_id="'.$dataSet->F_BOOKING_NO.'" checked/></label>';
                    $bank_acc_name = $rtc->BANK_ACC_NAME ?? '';
                    $bank_acc_no = $rtc->F_ACC_PAYMENT_BANK_NO ?? '';

                    if($rtc){
                        if($rtc->IS_REQUEST_PENDING == 1){
                            $btn_class = 'btn-warning';
                            $title = 'SELF PICKUP (PENDING FOR DISPATCH MANAGER APPROVAL)';
                        }else{
                            $btn_class = 'btn-success';
                            $title = 'SELF PICKUP';

                        }
                        if(($rtc->IS_CONFIRM_HOLDER == 0) && ($rtc->IS_REQUEST_PENDING == 0)){
                            $title = 'SELF PICKUP (PENDING FOR ORDER ITEM RECEIVED BY AGENT)';
                        }
                    }else{
                        $btn_class = "";
                        $title = "";
                    }

                    $self_pickup = '<button type="button" title="'.$title.'" class="btn btn-xs '.$btn_class.' mb-05 mr-05 self_pick" data-booking_id="'.$dataSet->F_BOOKING_NO.'" data-rtc_no="'.$bank_acc_no.'" data-toggle="modal" data-target="#self_pick_modal">'.$bank_acc_name.'</button>';

                }
            }else{
                if($dataSet->IS_SELF_PICKUP == 0){
                    $self_pickup = '<button type="button" title="IS SELF PICKUP" class="btn btn-xs btn-info mb-05 mr-05 self_pick" data-booking_id="'.$dataSet->F_BOOKING_NO.'" data-toggle="modal" data-target="#self_pick_modal" disabled>SP</button>';
                }elseif($dataSet->IS_SELF_PICKUP == 1)
                {
                    $rtc = OrderRtc::select('BANK_ACC_NAME','F_ACC_PAYMENT_BANK_NO')->where('F_BOOKING_NO',$dataSet->F_BOOKING_NO)->first();
                    // $self_pickup = '<label title=""><input type="checkbox" class="is_self_pickup" data-booking_id="'.$dataSet->F_BOOKING_NO.'" checked/></label>';
                    $bank_acc_name = $rtc->BANK_ACC_NAME ?? '';
                    $bank_acc_no = $rtc->F_ACC_PAYMENT_BANK_NO ?? '';
                    $self_pickup = '<button type="button" title="IS SELF PICKUP" class="btn btn-xs btn-success mb-05 mr-05 self_pick" data-booking_id="'.$dataSet->F_BOOKING_NO.'" data-rtc_no="'.$bank_acc_no.'" data-toggle="modal" data-target="#self_pick_modal" disabled>'.$bank_acc_name.'</button>';
                }
            }

            return $self_pickup;
        })

        ->addColumn('action', function($dataSet){
            $roles = userRolePermissionArray();
            $action = '';
            if (hasAccessAbility('view_booking', $roles)) {
            $action .=' <a href="'.route("admin.booking.view", [$dataSet->F_BOOKING_NO]).'" class="btn btn-xs btn-primary mb-05 mr-05" title="View order"><i class="la la-eye"></i></a>';
            }

            if (hasAccessAbility('edit_booking', $roles)) {
            $action .=' <a href="'.route('admin.booking.edit',$dataSet->F_BOOKING_NO).'" class="btn btn-xs btn-info mb-05 mr-05" title="Edit"><i class="la la-edit"></i></a>';

            }
            $auth_id = Auth::user()->PK_NO;
            $role_id = AuthUserGroup::join('SA_USER','SA_USER.PK_NO','SA_USER_GROUP_USERS.F_USER_NO')
                                ->join('SA_USER_GROUP_ROLE','SA_USER_GROUP_ROLE.F_USER_GROUP_NO','SA_USER_GROUP_USERS.F_GROUP_NO')
                                ->select('F_ROLE_NO')->where('F_USER_NO',$auth_id)->first();

            if ($dataSet->IS_ADMIN_APPROVAL == 1 && $role_id->F_ROLE_NO == 1) {
                $action .= ' <a href="'.route('admin.booking_to_order.admin-approval',$dataSet->F_BOOKING_NO).'" class="btn btn-xs btn-azura mb-05 mr-05" ><i class="ft-help-circle"></i></a>';

            }
            $price_after_dis = ($dataSet->TOTAL_PRICE) - $dataSet->DISCOUNT;
            $order_payment = $dataSet->ORDER_BUFFER_TOPUP;

            if ((hasAccessAbility('delete_booking', $roles)) && ($price_after_dis <= 0 ) && ($order_payment <= 0 ) ) {
                $action .=' <a href="'.route('admin.order.delete',$dataSet->F_BOOKING_NO).'" class="btn btn-xs btn-danger mb-05 mr-05" onclick="return confirm('. "'" .'Are you sure you want to delete the order ?'. "'" .')"  ><i class="la la-trash"></i></a>';
            }
            $action .= '<a href="'.route('admin.order_revert.default',[$dataSet->F_BOOKING_NO]).'" onclick="return confirm('. "'" .'Are you sure you want to revert ?'. "'" .')" class="btn btn-xs btn-primary mb-05 mr-05" title="REVERT BACK"><i class="la la-exchange"></i></a>';

            if ($dataSet->IS_SEND == 0) {
                $action .= '<a href="'.route('admin.notify_sms.send', [$dataSet->sms_pk]).'" onclick="return confirm('. "'" .'Are you sure ?'. "'" .')" class="btn btn-xs btn-success" title="SEND SMS"><i class="la la-envelope"></i></a>';
            }elseif($dataSet->IS_SEND == 1){
                $action .= '<a href="#!" class="btn btn-xs btn-success" style="opacity: .5;" title="VIEW SMS" data-sms_pk="'.$dataSet->sms_pk.'"><i class="la la-envelope"></i></a>';
            }
            return $action;
        })
        ->addColumn('option_details', function($dataSet){
            if($dataSet->DEFAULT_TYPE == 1){
                $option = 'Air Option 1';
            }else if($dataSet->DEFAULT_TYPE == 2){
                $option = 'Air Option 2';
            }else if($dataSet->DEFAULT_TYPE == 3){
                $option = 'Sea Option 1';
            }else if($dataSet->DEFAULT_TYPE == 4){
                $option = 'Sea Option 2';
            }else if($dataSet->DEFAULT_TYPE == 5){
                $option = 'Ready Option 1';
            }else{
                $option = 'Ready Option 2';
            }
            return $option;
        })
        ->rawColumns(['created_at','order_date','order_id','customer_name','item_type','price_after_dis','payment','avaiable','status','admin_hold','self_pickup','action','option_details'])
        ->make(true);
    }

    public function getDatatableDefaultOrderAction($request)
    {
        $agent_id       = Auth::user()->F_AGENT_NO;
        $dispatch_type  = $request->dispatch ?? '0';
        $now            = Carbon::now()->subDays(7)->toDateString();
        $dataSet = DB::table("SLS_ORDER")
            ->select('SLS_ORDER.PK_NO','SLS_ORDER.F_BOOKING_NO','SLS_ORDER.F_CUSTOMER_NO','SLS_ORDER.F_SHOP_NO','SLS_ORDER.CUSTOMER_NAME','SLS_ORDER.IS_READY','SLS_BOOKING.SS_CREATED_ON','SA_USER.NAME as CREATED_BY','SLS_BOOKING.SHOP_NAME','SLS_BOOKING.CONFIRM_TIME as ORDER_DATE','SLS_BOOKING.BOOKING_NO','SLS_BOOKING.SHOP_NAME','SLS_BOOKING.TOTAL_PRICE','SLS_BOOKING.DISCOUNT','SLS_BOOKING.PK_NO as  SLS_BOOKING_PK_NO','SLS_BOOKING.IS_RETURN','SLS_ORDER.ORDER_BUFFER_TOPUP','SLS_ORDER.ORDER_ACTUAL_TOPUP','SLS_ORDER.IS_SYSTEM_HOLD','SLS_ORDER.IS_ADMIN_HOLD','SLS_ORDER.DISPATCH_STATUS','SLS_ORDER.IS_CANCEL','SLS_BOOKING.CANCEL_REQUEST_BY','SLS_BOOKING.CANCEL_REQUEST_AT','SLS_ORDER.IS_SELF_PICKUP','SLS_ORDER.IS_ADMIN_APPROVAL','SLS_BOOKING.CONFIRM_TIME','SLS_BOOKING.IS_BUNDLE_MATCHED','DEFAULT_TYPE','SLS_NOTIFICATION.IS_SEND','SLS_NOTIFICATION.PK_NO as sms_pk','SLS_BOOKING.PENALTY_FEE','SLS_BOOKING.F_SHOP_NO','DEFAULT_AT'
            ,DB::raw('(select "'.$dispatch_type.'" ) as dispatch_type')
            // ,DB::raw('(DEFAULT_AT + interval 7 day ) as DEFAULT_AT')
            )
            ->leftJoin('SLS_BOOKING','SLS_ORDER.F_BOOKING_NO','SLS_BOOKING.PK_NO')
            ->leftJoin('SA_USER','SLS_BOOKING.F_SS_CREATED_BY','SA_USER.PK_NO')
            ->Join('SLS_NOTIFICATION','SLS_NOTIFICATION.F_BOOKING_NO','SLS_ORDER.F_BOOKING_NO')
            ->where('SLS_ORDER.DISPATCH_STATUS', '<', '40')
            ->where('SLS_ORDER.IS_DEFAULT', 1)
            // ->whereNotNull('SLS_ORDER.DEFAULT_AT')
            ->whereNull('SLS_ORDER.GRACE_TIME')
            ->whereRaw('((SLS_NOTIFICATION.IS_SEND = 1 AND SLS_NOTIFICATION.SEND_AT < "'.$now.'") AND SLS_NOTIFICATION.TYPE = "Default")')
            ;
            if ($agent_id > 0) {
                $dataSet->where('SLS_BOOKING.F_SHOP_NO',$agent_id);
            }
        if($request->id){
            if($request->type == 'customer'){
                $dataSet->where('SLS_ORDER.F_CUSTOMER_NO',$request->id);
            }elseif($request->type == 'seller'){
                $dataSet->where('SLS_ORDER.F_SHOP_NO',$request->id);
            }

        }
        if($request->dispatch){
            if($request->dispatch == 'rts'){
                $dataSet->whereIn('SLS_ORDER.DISPATCH_STATUS',[30,20])->where('SLS_ORDER.IS_SELF_PICKUP',0);

            }
            if($request->dispatch == 'cod_rtc'){
                $dataSet->where('IS_READY','!=',0)->where('SLS_ORDER.IS_SELF_PICKUP',1);
            }
        }
        $dataSet->orderBy('SLS_ORDER.PK_NO','DESC');

        return Datatables::of($dataSet)

        ->addColumn('created_at', function($dataSet){
            if ($dataSet->F_SHOP_NO == 19) {
                if($dataSet->IS_RETURN == 1){
                    $created_by = $dataSet->SHOP_NAME;
                }else{
                    $created_by = $dataSet->CUSTOMER_NAME;
                }
            }else{
                $created_by = $dataSet->CREATED_BY;
            }
            $created_at = '<div class="font-11">'.date('d-m-y h:i A',strtotime($dataSet->SS_CREATED_ON)).'</div><div>'.$created_by.'</div>';
            return $created_at;
        })
        ->addColumn('order_date', function($dataSet){
            if($dataSet->CONFIRM_TIME){
            $order_date = '<div>'.date('d-m-y',strtotime($dataSet->CONFIRM_TIME)).'</div>';
            }else{
                $order_date = '<div>'.date('d-m-y',strtotime($dataSet->SS_CREATED_ON)).'</div>';
            }
            return $order_date;
        })
        ->addColumn('order_id', function($dataSet){
            $order_id = '';
            $title = $dataSet->IS_BUNDLE_MATCHED == 1 ? 'The contains offer item' : '';
            $order_id .= '<a href="'.route("admin.booking.view", [$dataSet->SLS_BOOKING_PK_NO]).'" title="'.$title.'">ORD-'.$dataSet->BOOKING_NO.'</a>';
            if($dataSet->IS_BUNDLE_MATCHED == 1){
                $order_id .= '<i class="la la-gift pull-right text-azura"><i>';
            }
            return $order_id;
        })
        ->addColumn('customer_name', function($dataSet){

            if($dataSet->IS_RETURN == 1){
                $customer_name = '<a href="'.route("admin.seller.edit", [$dataSet->F_SHOP_NO]). '">'.$dataSet->SHOP_NAME.'</a>';
            }else{
                $customer_name = '<a href="'.route('admin.customer.view', [$dataSet->F_CUSTOMER_NO]).'">'.$dataSet->CUSTOMER_NAME.'</a>';
            }
            return $customer_name;
        })
       ->addColumn('item_type', function($dataSet){
            $booking_no = $dataSet->F_BOOKING_NO;
            $item = 0;
            $item_type = '';

            $query = DB::SELECT("SELECT SLS_BOOKING_DETAILS.F_BOOKING_NO,INV_STOCK.F_PRD_VARIANT_NO, COUNT(*) AS ITEM_QTY  FROM SLS_BOOKING_DETAILS LEFT JOIN INV_STOCK ON INV_STOCK.PK_NO = SLS_BOOKING_DETAILS.F_INV_STOCK_NO WHERE SLS_BOOKING_DETAILS.F_BOOKING_NO = $booking_no GROUP BY INV_STOCK.F_PRD_VARIANT_NO ");
            if(!empty($query)){
                foreach($query as $variant){
                    $item +=  $variant->ITEM_QTY;
                }
            }

            $item_type_qty = count($query) ?? 0;
            if($item_type_qty > 1){
                $item_type ='<div title="Total Quantity/Total Item">'.$item.'/'.$item_type_qty.'</div>';
            }else{
                $item_type ='<div >'.$item_type_qty.'</div>';
            }

            return $item_type;
        })
        ->addColumn('price_after_dis', function($dataSet){

            $price_after_dis = number_format(($dataSet->TOTAL_PRICE) - $dataSet->DISCOUNT,2);

            return $price_after_dis;
        })
        ->addColumn('payment', function($dataSet){
            $payment = '';
            if($dataSet->ORDER_ACTUAL_TOPUP > 0 ){
                $payment .= '<div class="badge badge-success d-block" title="PAID AND VERIFIED">'.number_format($dataSet->ORDER_ACTUAL_TOPUP,2).'</div>';
            }

            if($dataSet->ORDER_BUFFER_TOPUP - $dataSet->ORDER_ACTUAL_TOPUP > 0 ){
                $payment .= '<div class="badge badge-warning d-block" title="PAID BUT NOT VERIFIED">'.number_format($dataSet->ORDER_BUFFER_TOPUP - $dataSet->ORDER_ACTUAL_TOPUP,2).'</div>';
            }
            if(($dataSet->TOTAL_PRICE) - $dataSet->DISCOUNT  - $dataSet->ORDER_BUFFER_TOPUP > 0 ){
                $payment .= '<div class="badge badge-danger d-block" title="DUE" >'.number_format(($dataSet->TOTAL_PRICE) - $dataSet->ORDER_BUFFER_TOPUP,2).'</div>';
            }
            return $payment;
        })
        ->addColumn('avaiable', function($dataSet){
            $avaiable = '';
            $zones = '';
            $shelve_zones = DB::SELECT("SELECT GROUP_CONCAT(IFNULL(INV_STOCK.F_INV_ZONE_NO,0)) AS ZONES from SLS_BOOKING_DETAILS join INV_STOCK on INV_STOCK.PK_NO = SLS_BOOKING_DETAILS.F_INV_STOCK_NO where SLS_BOOKING_DETAILS.F_BOOKING_NO = $dataSet->F_BOOKING_NO GROUP BY SLS_BOOKING_DETAILS.F_BOOKING_NO ");

            if($dataSet->IS_READY == 0){
                $avaiable = '<div class="badge badge-primary d-block" title="NOT READY">Intransit</div>';
            }elseif($dataSet->IS_READY == 1){
                $avaiable = '<div class="badge badge-success d-block" title="READY">Ready</div>';
                if(!empty($shelve_zones)){
                    $zones  = $shelve_zones[0]->ZONES;
                    $zones_arr = explode(',', $zones);
                    if(in_array(0,$zones_arr)){
                        $avaiable = '<div class="badge badge-warning d-block " title="READY (Need to Shelve)">Ready</div>';
                    }
                }
            }elseif($dataSet->IS_READY == 2){
                $avaiable = '<div class="badge badge-warning d-block" title="PARTIALLY READY">Partially Ready</div>';
                if(!empty($shelve_zones)){
                    $zones  = $shelve_zones[0]->ZONES;
                    $zones_arr = explode(',', $zones);
                    if(in_array(0,$zones_arr)){
                        $avaiable = '<div class="badge badge-warning d-block  (Need to Shelve)" title="PARTIALLY READY">Partially</div>';
                    }
                }
            }
            return $avaiable;
        })
        ->addColumn('status', function($dataSet){

            $status = '';
            if($dataSet->IS_ADMIN_HOLD == 0){
                /*NO ACTION BY ADMIN*/
                $assigned_user = DB::SELECT("SELECT RTS_COLLECTION_USER_ID FROM SLS_BOOKING_DETAILS WHERE F_BOOKING_NO = $dataSet->F_BOOKING_NO");
                $assigned_user = count($assigned_user) ?? 0;
                if ($dataSet->dispatch_type == 'rts' || $dataSet->dispatch_type == 'cod_rtc') {
                    $rts_link = '<a href="'.route("admin.order.dispatch",[$dataSet->F_BOOKING_NO]).'?type=rts">RTS</a>';
                }else{
                    $rts_link = '<a href="javascript:void(0)">RTS</a>';
                }
                if($dataSet->DISPATCH_STATUS == '40'){
                    $status = '<div class="badge badge-success d-block" title="DISPACTHED">Dispacthed</div>';
                }elseif($dataSet->DISPATCH_STATUS == '30'){
                    $status = '<div class="badge badge-success d-block" title="READY TO SHIP">'.$rts_link.'</div>';
                }elseif($dataSet->DISPATCH_STATUS == '20'){
                    $status = '<div class="badge badge-success d-block" title="READY TO COLLECT (Partially)"><a href="'.route("admin.order.dispatch",[$dataSet->F_BOOKING_NO]).'?type=rts">RTS(H)</a></div>';
                }elseif($dataSet->DISPATCH_STATUS == '10'){
                    $status = '<div class="badge badge-success d-block" title="DISPACTHED (Partially)">Dispacthed(H)</div>';
                }
            }else{
                /*ALL ADMIN ACTION*/
                if($dataSet->IS_ADMIN_HOLD == 1){
                    $status = '<div class="badge badge-warning d-block" title="HOLD">HOLD</div>';
                }
            }

            if($dataSet->IS_CANCEL == '1'){
                $status .= '<div class="badge badge-warning d-block" title="Canceled">Canceled</div>';
            }elseif($dataSet->IS_CANCEL == '2'){
                $status .= '<div class="badge badge-warning d-block" title="Cancele Request Pending">CR</div>';
            }

            if($dataSet->IS_SELF_PICKUP == 1){

                $due_amt = ($dataSet->TOTAL_PRICE) - $dataSet->DISCOUNT - $dataSet->ORDER_BUFFER_TOPUP;
                if ($dataSet->dispatch_type == 'rts' || $dataSet->dispatch_type == 'cod_rtc') {
                    $cod_link = route("admin.order.dispatch",[$dataSet->F_BOOKING_NO]).'?type=cod';
                }else{
                    $cod_link = 'javascript:void(0)';
                }
                if($due_amt > 0 ){
                    $status = '<div class="badge badge-warning d-block" title="CASH ON DELIVERY"><a href="'.$cod_link.'">COD</a></div>';
                }else{
                    $status = '<div class="badge badge-warning d-block" title="READY TO SELF PICKUP BY CUSTOMER"><a href="'.$cod_link.'">RTC</a></div>';
                }

            }
            if($status == ''){
                if($dataSet->IS_SYSTEM_HOLD == 1)
                    {
                        $status = '<div class="badge badge-default d-block" title="In Processing"><i class="la la-spinner spinner"></i></div>';
                    }
            }
            if ($dataSet->IS_ADMIN_APPROVAL == 1) {
                $status .= '<div class="badge badge-danger d-block" title="DATA IS ALTERED NEED ADMIN APPROVAL">ALTERED</div>';
            }
            return $status;
        })
        ->addColumn('admin_hold', function($dataSet){
            $roles = userRolePermissionArray();
            $admin_hold = '';
            if (hasAccessAbility('edit_booking', $roles)) {
                if($dataSet->IS_ADMIN_HOLD == 0){
                    $admin_hold = '<label title=""><input type="checkbox" class="is_admin_hold" data-booking_id="'.$dataSet->F_BOOKING_NO.'" /></label>';
                }elseif($dataSet->IS_ADMIN_HOLD == 1)
                {
                    $admin_hold = '<label title=""><input type="checkbox" class="is_admin_hold"  data-booking_id="'.$dataSet->F_BOOKING_NO.'" checked/></label>';
                }
            }else{
                if($dataSet->IS_ADMIN_HOLD == 0){
                    $admin_hold = '<label title=""><input type="checkbox" class="is_admin_hold" data-booking_id="'.$dataSet->F_BOOKING_NO.'" disabled /></label>';
                }elseif($dataSet->IS_ADMIN_HOLD == 1)
                {
                    $admin_hold = '<label title=""><input type="checkbox" class="is_admin_hold"  data-booking_id="'.$dataSet->F_BOOKING_NO.'" checked disabled/></label>';
                }
            }
            return $admin_hold;
        })
        ->addColumn('self_pickup', function($dataSet){
            $roles = userRolePermissionArray();
            $self_pickup = '';

            if (hasAccessAbility('edit_booking', $roles)) {
                if($dataSet->IS_SELF_PICKUP == 0){
                    $self_pickup = '<button type="button" title="IS SELF PICKUP" class="btn btn-xs btn-success mb-05 mr-05 self_pick" data-booking_id="'.$dataSet->F_BOOKING_NO.'" data-toggle="modal" data-target="#self_pick_modal">SP</button>';

                }elseif($dataSet->IS_SELF_PICKUP == 1)
                {
                    $rtc = OrderRtc::select('BANK_ACC_NAME','F_ACC_PAYMENT_BANK_NO','IS_REQUEST_PENDING')->where('F_BOOKING_NO',$dataSet->F_BOOKING_NO)->first();
                    $bank_acc_name = $rtc->BANK_ACC_NAME ?? '';
                    $bank_acc_no = $rtc->F_ACC_PAYMENT_BANK_NO ?? '';

                    if($rtc){
                        if($rtc->IS_REQUEST_PENDING == 1){
                            $btn_class = 'btn-warning';
                            $title = 'SELF PICKUP (PENDING FOR DISPATCH MANAGER APPROVAL)';
                        }else{
                            $btn_class = 'btn-success';
                            $title = 'SELF PICKUP';

                        }
                        if(($rtc->IS_CONFIRM_HOLDER == 0) && ($rtc->IS_REQUEST_PENDING == 0)){
                            $title = 'SELF PICKUP (PENDING FOR ORDER ITEM RECEIVED BY AGENT)';
                        }
                    }else{
                        $btn_class = "";
                        $title = "";
                    }

                    $self_pickup = '<button type="button" title="'.$title.'" class="btn btn-xs '.$btn_class.' mb-05 mr-05 self_pick" data-booking_id="'.$dataSet->F_BOOKING_NO.'" data-rtc_no="'.$bank_acc_no.'" data-toggle="modal" data-target="#self_pick_modal">'.$bank_acc_name.'</button>';

                }
            }else{
                if($dataSet->IS_SELF_PICKUP == 0){
                    $self_pickup = '<button type="button" title="IS SELF PICKUP" class="btn btn-xs btn-info mb-05 mr-05 self_pick" data-booking_id="'.$dataSet->F_BOOKING_NO.'" data-toggle="modal" data-target="#self_pick_modal" disabled>SP</button>';
                }elseif($dataSet->IS_SELF_PICKUP == 1)
                {
                    $rtc = OrderRtc::select('BANK_ACC_NAME','F_ACC_PAYMENT_BANK_NO')->where('F_BOOKING_NO',$dataSet->F_BOOKING_NO)->first();
                    $bank_acc_name = $rtc->BANK_ACC_NAME ?? '';
                    $bank_acc_no = $rtc->F_ACC_PAYMENT_BANK_NO ?? '';
                    $self_pickup = '<button type="button" title="IS SELF PICKUP" class="btn btn-xs btn-success mb-05 mr-05 self_pick" data-booking_id="'.$dataSet->F_BOOKING_NO.'" data-rtc_no="'.$bank_acc_no.'" data-toggle="modal" data-target="#self_pick_modal" disabled>'.$bank_acc_name.'</button>';
                }
            }

            return $self_pickup;
        })

        ->addColumn('action', function($dataSet){
            $roles = userRolePermissionArray();
            $action = '';
            if (hasAccessAbility('view_booking', $roles)) {
            $action .=' <a href="'.route("admin.booking.view", [$dataSet->F_BOOKING_NO]).'" class="btn btn-xs btn-primary mb-05 mr-05" title="View order"><i class="la la-eye"></i></a>';
            }

            if (hasAccessAbility('edit_booking', $roles)) {
                $action .=' <a href="'.route('admin.booking.edit',$dataSet->F_BOOKING_NO).'" class="btn btn-xs btn-info mb-05 mr-05" title="Edit"><i class="la la-edit"></i></a>';
            }
            $auth_id = Auth::user()->PK_NO;
            $role_id = AuthUserGroup::join('SA_USER','SA_USER.PK_NO','SA_USER_GROUP_USERS.F_USER_NO')
                                ->join('SA_USER_GROUP_ROLE','SA_USER_GROUP_ROLE.F_USER_GROUP_NO','SA_USER_GROUP_USERS.F_GROUP_NO')
                                ->select('F_ROLE_NO')->where('F_USER_NO',$auth_id)->first();

            if ($dataSet->IS_ADMIN_APPROVAL == 1 && $role_id->F_ROLE_NO == 1) {
                $action .= ' <a href="'.route('admin.booking_to_order.admin-approval',$dataSet->F_BOOKING_NO).'" class="btn btn-xs btn-azura mb-05 mr-05" ><i class="ft-help-circle"></i></a>';
            }
            $price_after_dis = ($dataSet->TOTAL_PRICE) - $dataSet->DISCOUNT;
            $order_payment = $dataSet->ORDER_BUFFER_TOPUP;

            if ((hasAccessAbility('delete_booking', $roles)) && ($price_after_dis <= 0 ) && ($order_payment <= 0 ) ) {
                $action .=' <a href="'.route('admin.order.delete',$dataSet->F_BOOKING_NO).'" class="btn btn-xs btn-danger mb-05 mr-05" onclick="return confirm('. "'" .'Are you sure you want to delete the order ?'. "'" .')"  ><i class="la la-trash"></i></a>';
            }
            $action .= '<a href="'.route('admin.order_revert.default',[$dataSet->F_BOOKING_NO]).'" onclick="return confirm('. "'" .'Are you sure you want to revert ?'. "'" .')" class="btn btn-xs btn-primary mb-05" title="REVERT BACK"><i class="la la-exchange"></i></a>';

            if ($dataSet->IS_SEND == 0) {
                $action .= '<a href="'.route('admin.notify_sms.send', [$dataSet->sms_pk]).'" onclick="return confirm('. "'" .'Are you sure ?'. "'" .')" class="btn btn-xs btn-success" title="SEND SMS"><i class="la la-envelope"></i></a>';
            }elseif($dataSet->IS_SEND == 1){
                $action .= '<a href="#!" class="btn btn-xs btn-success" style="opacity: .5;" title="VIEW SMS" data-sms_pk="'.$dataSet->sms_pk.'"><i class="la la-envelope"></i></a>';
            }
            return $action;
        })
        ->addColumn('option_details', function($dataSet){
            if($dataSet->DEFAULT_TYPE == 1){
                $option = 'Air Option 1';
            }else if($dataSet->DEFAULT_TYPE == 2){
                $option = 'Air Option 2';
            }else if($dataSet->DEFAULT_TYPE == 3){
                $option = 'Sea Option 1';
            }else if($dataSet->DEFAULT_TYPE == 4){
                $option = 'Sea Option 2';
            }else if($dataSet->DEFAULT_TYPE == 5){
                $option = 'Ready Option 1';
            }else{
                $option = 'Ready Option 2';
            }
            return $option;
        })
        ->rawColumns(['created_at','order_date','order_id','customer_name','item_type','price_after_dis','payment','avaiable','status','admin_hold','self_pickup','action','option_details'])
        ->make(true);
    }

    public function getDatatableDefaultOrderPenalty($request)
    {
        $agent_id       = Auth::user()->F_AGENT_NO;
        $dispatch_type  = $request->dispatch ?? '0';
        // $now            = Carbon::now()->subDays(7)->toDateString();
        $dataSet = DB::table("SLS_ORDER")
            ->select('SLS_ORDER.PK_NO','SLS_ORDER.F_BOOKING_NO','SLS_ORDER.F_CUSTOMER_NO','SLS_ORDER.F_SHOP_NO','SLS_ORDER.CUSTOMER_NAME','SLS_ORDER.IS_READY','SLS_BOOKING.SS_CREATED_ON','SA_USER.NAME as CREATED_BY','SLS_BOOKING.SHOP_NAME','SLS_BOOKING.CONFIRM_TIME as ORDER_DATE','SLS_BOOKING.BOOKING_NO','SLS_BOOKING.SHOP_NAME','SLS_BOOKING.TOTAL_PRICE','SLS_BOOKING.DISCOUNT','SLS_BOOKING.PK_NO as  SLS_BOOKING_PK_NO','SLS_BOOKING.IS_RETURN','SLS_ORDER.ORDER_BUFFER_TOPUP','SLS_ORDER.ORDER_ACTUAL_TOPUP','SLS_ORDER.IS_SYSTEM_HOLD','SLS_ORDER.IS_ADMIN_HOLD','SLS_ORDER.DISPATCH_STATUS','SLS_ORDER.IS_CANCEL','SLS_BOOKING.CANCEL_REQUEST_BY','SLS_BOOKING.CANCEL_REQUEST_AT','SLS_ORDER.IS_SELF_PICKUP','SLS_ORDER.IS_ADMIN_APPROVAL','SLS_BOOKING.CONFIRM_TIME','SLS_BOOKING.IS_BUNDLE_MATCHED','DEFAULT_TYPE','GRACE_TIME','SLS_NOTIFICATION.IS_SEND','SLS_NOTIFICATION.PK_NO as sms_pk','SLS_BOOKING.PENALTY_FEE','SLS_BOOKING.F_SHOP_NO'
            ,DB::raw('(select "'.$dispatch_type.'" ) as dispatch_type'))
            ->leftJoin('SLS_BOOKING','SLS_ORDER.F_BOOKING_NO','SLS_BOOKING.PK_NO')
            ->leftJoin('SA_USER','SLS_BOOKING.F_SS_CREATED_BY','SA_USER.PK_NO')
            ->Join('SLS_NOTIFICATION','SLS_NOTIFICATION.F_BOOKING_NO','SLS_ORDER.F_BOOKING_NO')
            ->where('SLS_ORDER.DISPATCH_STATUS', '<', '40')
            ->whereNotNull('SLS_ORDER.GRACE_TIME')
            ->whereRaw('(SLS_NOTIFICATION.TYPE = "Default")')
            ;
            if ($agent_id > 0) {
                $dataSet->where('SLS_BOOKING.F_SHOP_NO',$agent_id);
            }
        if($request->id){
            if($request->type == 'customer'){
                $dataSet->where('SLS_ORDER.F_CUSTOMER_NO',$request->id);
            }elseif($request->type == 'seller'){
                $dataSet->where('SLS_ORDER.F_SHOP_NO',$request->id);
            }
        }
        if($request->dispatch){
            if($request->dispatch == 'rts'){
                $dataSet->whereIn('SLS_ORDER.DISPATCH_STATUS',[30,20])->where('SLS_ORDER.IS_SELF_PICKUP',0);

            }
            if($request->dispatch == 'cod_rtc'){
                $dataSet->where('IS_READY','!=',0)->where('SLS_ORDER.IS_SELF_PICKUP',1);
            }
        }
        $dataSet->orderBy('SLS_ORDER.PK_NO','DESC');

        return Datatables::of($dataSet)

        ->addColumn('created_at', function($dataSet){
            if ($dataSet->F_SHOP_NO == 19) {
                if($dataSet->IS_RETURN == 1){
                    $created_by = $dataSet->SHOP_NAME;
                }else{
                    $created_by = $dataSet->CUSTOMER_NAME;
                }
            }else{
                $created_by = $dataSet->CREATED_BY;
            }
            $created_at = '<div class="font-11">'.date('d-m-y h:i A',strtotime($dataSet->SS_CREATED_ON)).'</div><div>'.$created_by.'</div>';
            return $created_at;
        })
        ->addColumn('order_date', function($dataSet){
            if($dataSet->CONFIRM_TIME){
            $order_date = '<div>'.date('d-m-y',strtotime($dataSet->CONFIRM_TIME)).'</div>';
            }else{
                $order_date = '<div>'.date('d-m-y',strtotime($dataSet->SS_CREATED_ON)).'</div>';
            }
            return $order_date;
        })
        ->addColumn('order_id', function($dataSet){
            $order_id = '';
            $title = $dataSet->IS_BUNDLE_MATCHED == 1 ? 'The contains offer item' : '';
            $order_id .= '<a href="'.route("admin.booking.view", [$dataSet->SLS_BOOKING_PK_NO]).'" title="'.$title.'">ORD-'.$dataSet->BOOKING_NO.'</a>';
            if($dataSet->IS_BUNDLE_MATCHED == 1){
                $order_id .= '<i class="la la-gift pull-right text-azura"><i>';
            }
            return $order_id;
        })
        ->addColumn('customer_name', function($dataSet){

            if($dataSet->IS_RETURN == 1){
                $customer_name = '<a href="'.route("admin.seller.edit", [$dataSet->F_SHOP_NO]). '">'.$dataSet->SHOP_NAME.'</a>';
            }else{
                $customer_name = '<a href="'.route('admin.customer.view', [$dataSet->F_CUSTOMER_NO]).'">'.$dataSet->CUSTOMER_NAME.'</a>';
            }
            return $customer_name;
        })
       ->addColumn('item_type', function($dataSet){
            $booking_no = $dataSet->F_BOOKING_NO;
            $item = 0;
            $item_type = '';

            $query = DB::SELECT("SELECT SLS_BOOKING_DETAILS.F_BOOKING_NO,INV_STOCK.F_PRD_VARIANT_NO, COUNT(*) AS ITEM_QTY  FROM SLS_BOOKING_DETAILS LEFT JOIN INV_STOCK ON INV_STOCK.PK_NO = SLS_BOOKING_DETAILS.F_INV_STOCK_NO WHERE SLS_BOOKING_DETAILS.F_BOOKING_NO = $booking_no GROUP BY INV_STOCK.F_PRD_VARIANT_NO ");
            if(!empty($query)){
                foreach($query as $variant){
                    $item +=  $variant->ITEM_QTY;
                }
            }

            $item_type_qty = count($query) ?? 0;
            if($item_type_qty > 1){
                $item_type ='<div title="Total Quantity/Total Item">'.$item.'/'.$item_type_qty.'</div>';
            }else{
                $item_type ='<div >'.$item_type_qty.'</div>';
            }

            return $item_type;
        })
        ->addColumn('price_after_dis', function($dataSet){

            $price_after_dis = number_format(($dataSet->TOTAL_PRICE) - $dataSet->DISCOUNT,2);

            return $price_after_dis;
        })
        ->addColumn('payment', function($dataSet){
            $payment = '';
            if($dataSet->ORDER_ACTUAL_TOPUP > 0 ){
                $payment .= '<div class="badge badge-success d-block" title="PAID AND VERIFIED">'.number_format($dataSet->ORDER_ACTUAL_TOPUP,2).'</div>';
            }

            if($dataSet->ORDER_BUFFER_TOPUP - $dataSet->ORDER_ACTUAL_TOPUP > 0 ){
                $payment .= '<div class="badge badge-warning d-block" title="PAID BUT NOT VERIFIED">'.number_format($dataSet->ORDER_BUFFER_TOPUP - $dataSet->ORDER_ACTUAL_TOPUP,2).'</div>';
            }
            if(($dataSet->TOTAL_PRICE) - $dataSet->DISCOUNT  - $dataSet->ORDER_BUFFER_TOPUP > 0 ){
                $payment .= '<div class="badge badge-danger d-block" title="DUE" >'.number_format(($dataSet->TOTAL_PRICE) - $dataSet->ORDER_BUFFER_TOPUP,2).'</div>';
            }
            return $payment;
        })
        ->addColumn('avaiable', function($dataSet){
            $avaiable = '';
            $zones = '';
            $shelve_zones = DB::SELECT("SELECT GROUP_CONCAT(IFNULL(INV_STOCK.F_INV_ZONE_NO,0)) AS ZONES from SLS_BOOKING_DETAILS join INV_STOCK on INV_STOCK.PK_NO = SLS_BOOKING_DETAILS.F_INV_STOCK_NO where SLS_BOOKING_DETAILS.F_BOOKING_NO = $dataSet->F_BOOKING_NO GROUP BY SLS_BOOKING_DETAILS.F_BOOKING_NO ");

            if($dataSet->IS_READY == 0){
                $avaiable = '<div class="badge badge-primary d-block" title="NOT READY">Intransit</div>';
            }elseif($dataSet->IS_READY == 1){
                $avaiable = '<div class="badge badge-success d-block" title="READY">Ready</div>';
                if(!empty($shelve_zones)){
                    $zones  = $shelve_zones[0]->ZONES;
                    $zones_arr = explode(',', $zones);
                    if(in_array(0,$zones_arr)){
                        $avaiable = '<div class="badge badge-warning d-block " title="READY (Need to Shelve)">Ready</div>';
                    }
                }
            }elseif($dataSet->IS_READY == 2){
                $avaiable = '<div class="badge badge-warning d-block" title="PARTIALLY READY">Partially Ready</div>';
                if(!empty($shelve_zones)){
                    $zones  = $shelve_zones[0]->ZONES;
                    $zones_arr = explode(',', $zones);
                    if(in_array(0,$zones_arr)){
                        $avaiable = '<div class="badge badge-warning d-block  (Need to Shelve)" title="PARTIALLY READY">Partially</div>';
                    }
                }
            }
            return $avaiable;
        })
        ->addColumn('status', function($dataSet){

            $status = '';
            if($dataSet->IS_ADMIN_HOLD == 0){
                /*NO ACTION BY ADMIN*/
                $assigned_user = DB::SELECT("SELECT RTS_COLLECTION_USER_ID FROM SLS_BOOKING_DETAILS WHERE F_BOOKING_NO = $dataSet->F_BOOKING_NO");
                $assigned_user = count($assigned_user) ?? 0;
                if ($dataSet->dispatch_type == 'rts' || $dataSet->dispatch_type == 'cod_rtc') {
                    $rts_link = '<a href="'.route("admin.order.dispatch",[$dataSet->F_BOOKING_NO]).'?type=rts">RTS</a>';
                }else{
                    $rts_link = '<a href="javascript:void(0)">RTS</a>';
                }
                if($dataSet->DISPATCH_STATUS == '40'){
                    $status = '<div class="badge badge-success d-block" title="DISPACTHED">Dispacthed</div>';
                }elseif($dataSet->DISPATCH_STATUS == '30'){
                    $status = '<div class="badge badge-success d-block" title="READY TO SHIP">'.$rts_link.'</div>';
                }elseif($dataSet->DISPATCH_STATUS == '20'){
                    $status = '<div class="badge badge-success d-block" title="READY TO COLLECT (Partially)"><a href="'.route("admin.order.dispatch",[$dataSet->F_BOOKING_NO]).'?type=rts">RTS(H)</a></div>';
                }elseif($dataSet->DISPATCH_STATUS == '10'){
                    $status = '<div class="badge badge-success d-block" title="DISPACTHED (Partially)">Dispacthed(H)</div>';
                }
            }else{
                /*ALL ADMIN ACTION*/
                if($dataSet->IS_ADMIN_HOLD == 1){
                    $status = '<div class="badge badge-warning d-block" title="HOLD">HOLD</div>';
                }
            }

            if($dataSet->IS_CANCEL == '1'){
                $status .= '<div class="badge badge-warning d-block" title="Canceled">Canceled</div>';
            }elseif($dataSet->IS_CANCEL == '2'){
                $status .= '<div class="badge badge-warning d-block" title="Cancele Request Pending">CR</div>';
            }

            if($dataSet->IS_SELF_PICKUP == 1){

                $due_amt = ($dataSet->TOTAL_PRICE) - $dataSet->DISCOUNT - $dataSet->ORDER_BUFFER_TOPUP;
                if ($dataSet->dispatch_type == 'rts' || $dataSet->dispatch_type == 'cod_rtc') {
                    $cod_link = route("admin.order.dispatch",[$dataSet->F_BOOKING_NO]).'?type=cod';
                }else{
                    $cod_link = 'javascript:void(0)';
                }
                if($due_amt > 0 ){
                    $status = '<div class="badge badge-warning d-block" title="CASH ON DELIVERY"><a href="'.$cod_link.'">COD</a></div>';
                }else{
                    $status = '<div class="badge badge-warning d-block" title="READY TO SELF PICKUP BY CUSTOMER"><a href="'.$cod_link.'">RTC</a></div>';
                }

            }
            if($status == ''){
                if($dataSet->IS_SYSTEM_HOLD == 1)
                    {
                        $status = '<div class="badge badge-default d-block" title="In Processing"><i class="la la-spinner spinner"></i></div>';
                    }
            }
            if ($dataSet->IS_ADMIN_APPROVAL == 1) {
                $status .= '<div class="badge badge-danger d-block" title="DATA IS ALTERED NEED ADMIN APPROVAL">ALTERED</div>';
            }
            return $status;
        })
        ->addColumn('admin_hold', function($dataSet){
            $roles = userRolePermissionArray();
            $admin_hold = '';
            if (hasAccessAbility('edit_booking', $roles)) {
                if($dataSet->IS_ADMIN_HOLD == 0){
                    $admin_hold = '<label title=""><input type="checkbox" class="is_admin_hold" data-booking_id="'.$dataSet->F_BOOKING_NO.'" /></label>';
                }elseif($dataSet->IS_ADMIN_HOLD == 1)
                {
                    $admin_hold = '<label title=""><input type="checkbox" class="is_admin_hold"  data-booking_id="'.$dataSet->F_BOOKING_NO.'" checked/></label>';
                }
            }else{
                if($dataSet->IS_ADMIN_HOLD == 0){
                    $admin_hold = '<label title=""><input type="checkbox" class="is_admin_hold" data-booking_id="'.$dataSet->F_BOOKING_NO.'" disabled /></label>';
                }elseif($dataSet->IS_ADMIN_HOLD == 1)
                {
                    $admin_hold = '<label title=""><input type="checkbox" class="is_admin_hold"  data-booking_id="'.$dataSet->F_BOOKING_NO.'" checked disabled/></label>';
                }
            }
            return $admin_hold;
        })
        ->addColumn('self_pickup', function($dataSet){
            $roles = userRolePermissionArray();
            $self_pickup = '';

            if (hasAccessAbility('edit_booking', $roles)) {
                if($dataSet->IS_SELF_PICKUP == 0){
                    $self_pickup = '<button type="button" title="IS SELF PICKUP" class="btn btn-xs btn-success mb-05 mr-05 self_pick" data-booking_id="'.$dataSet->F_BOOKING_NO.'" data-toggle="modal" data-target="#self_pick_modal">SP</button>';

                }elseif($dataSet->IS_SELF_PICKUP == 1)
                {
                    $rtc = OrderRtc::select('BANK_ACC_NAME','F_ACC_PAYMENT_BANK_NO','IS_REQUEST_PENDING')->where('F_BOOKING_NO',$dataSet->F_BOOKING_NO)->first();
                    $bank_acc_name = $rtc->BANK_ACC_NAME ?? '';
                    $bank_acc_no = $rtc->F_ACC_PAYMENT_BANK_NO ?? '';

                    if($rtc){
                        if($rtc->IS_REQUEST_PENDING == 1){
                            $btn_class = 'btn-warning';
                            $title = 'SELF PICKUP (PENDING FOR DISPATCH MANAGER APPROVAL)';
                        }else{
                            $btn_class = 'btn-success';
                            $title = 'SELF PICKUP';

                        }
                        if(($rtc->IS_CONFIRM_HOLDER == 0) && ($rtc->IS_REQUEST_PENDING == 0)){
                            $title = 'SELF PICKUP (PENDING FOR ORDER ITEM RECEIVED BY AGENT)';
                        }
                    }else{
                        $btn_class = "";
                        $title = "";
                    }

                    $self_pickup = '<button type="button" title="'.$title.'" class="btn btn-xs '.$btn_class.' mb-05 mr-05 self_pick" data-booking_id="'.$dataSet->F_BOOKING_NO.'" data-rtc_no="'.$bank_acc_no.'" data-toggle="modal" data-target="#self_pick_modal">'.$bank_acc_name.'</button>';

                }
            }else{
                if($dataSet->IS_SELF_PICKUP == 0){
                    $self_pickup = '<button type="button" title="IS SELF PICKUP" class="btn btn-xs btn-info mb-05 mr-05 self_pick" data-booking_id="'.$dataSet->F_BOOKING_NO.'" data-toggle="modal" data-target="#self_pick_modal" disabled>SP</button>';
                }elseif($dataSet->IS_SELF_PICKUP == 1)
                {
                    $rtc = OrderRtc::select('BANK_ACC_NAME','F_ACC_PAYMENT_BANK_NO')->where('F_BOOKING_NO',$dataSet->F_BOOKING_NO)->first();
                    $bank_acc_name = $rtc->BANK_ACC_NAME ?? '';
                    $bank_acc_no = $rtc->F_ACC_PAYMENT_BANK_NO ?? '';
                    $self_pickup = '<button type="button" title="IS SELF PICKUP" class="btn btn-xs btn-success mb-05 mr-05 self_pick" data-booking_id="'.$dataSet->F_BOOKING_NO.'" data-rtc_no="'.$bank_acc_no.'" data-toggle="modal" data-target="#self_pick_modal" disabled>'.$bank_acc_name.'</button>';
                }
            }

            return $self_pickup;
        })

        ->addColumn('action', function($dataSet){
            $roles = userRolePermissionArray();
            $action = '';
            if (hasAccessAbility('view_booking', $roles)) {
            $action .=' <a href="'.route("admin.booking.view", [$dataSet->F_BOOKING_NO]).'" class="btn btn-xs btn-primary mb-05 mr-05" title="View order"><i class="la la-eye"></i></a>';
            }

            if (hasAccessAbility('edit_booking', $roles)) {
                $action .=' <a href="'.route('admin.booking.edit',$dataSet->F_BOOKING_NO).'" class="btn btn-xs btn-info mb-05 mr-05" title="Edit"><i class="la la-edit"></i></a>';
            }
            $auth_id = Auth::user()->PK_NO;
            $role_id = AuthUserGroup::join('SA_USER','SA_USER.PK_NO','SA_USER_GROUP_USERS.F_USER_NO')
                                ->join('SA_USER_GROUP_ROLE','SA_USER_GROUP_ROLE.F_USER_GROUP_NO','SA_USER_GROUP_USERS.F_GROUP_NO')
                                ->select('F_ROLE_NO')->where('F_USER_NO',$auth_id)->first();

            if ($dataSet->IS_ADMIN_APPROVAL == 1 && $role_id->F_ROLE_NO == 1) {
                $action .= ' <a href="'.route('admin.booking_to_order.admin-approval',$dataSet->F_BOOKING_NO).'" class="btn btn-xs btn-azura mb-05 mr-05" ><i class="ft-help-circle"></i></a>';
            }
            $price_after_dis = ($dataSet->TOTAL_PRICE) - $dataSet->DISCOUNT;
            $order_payment = $dataSet->ORDER_BUFFER_TOPUP;

            if ((hasAccessAbility('delete_booking', $roles)) && ($price_after_dis <= 0 ) && ($order_payment <= 0 ) ) {
                $action .=' <a href="'.route('admin.order.delete',$dataSet->F_BOOKING_NO).'" class="btn btn-xs btn-danger mb-05 mr-05" onclick="return confirm('. "'" .'Are you sure you want to delete the order ?'. "'" .')"  ><i class="la la-trash"></i></a>';
                }

            if ($dataSet->IS_SEND == 0) {
                $action .= '<a href="'.route('admin.notify_sms.send', [$dataSet->sms_pk]).'" onclick="return confirm('. "'" .'Are you sure ?'. "'" .')" class="btn btn-xs btn-success" title="SEND SMS"><i class="la la-envelope"></i></a>';
            }elseif($dataSet->IS_SEND == 1){
                $action .= '<a href="#!" class="btn btn-xs btn-success" style="opacity: .5;" title="VIEW SMS" data-sms_pk="'.$dataSet->sms_pk.'"><i class="la la-envelope"></i></a>';
            }
            return $action;
        })
        ->addColumn('option_details', function($dataSet){
            if($dataSet->DEFAULT_TYPE == 1){
                $option = 'Air Option 1';
            }else if($dataSet->DEFAULT_TYPE == 2){
                $option = 'Air Option 2';
            }else if($dataSet->DEFAULT_TYPE == 3){
                $option = 'Sea Option 1';
            }else if($dataSet->DEFAULT_TYPE == 4){
                $option = 'Sea Option 2';
            }else if($dataSet->DEFAULT_TYPE == 5){
                $option = 'Ready Option 1';
            }else{
                $option = 'Ready Option 2';
            }
            return $option;
        })
        ->rawColumns(['created_at','order_date','order_id','customer_name','item_type','price_after_dis','payment','avaiable','status','admin_hold','self_pickup','action','option_details'])
        ->make(true);
    }

    public function getDatatableProduct($request)
    {
        /*
        // $house = $request->get('columns')[4]['search']['value'];

        // $count_not_boxed = Stock::selectRaw('(SELECT IFNULL(COUNT(IG_CODE),0) from INV_STOCK where IG_CODE = IG_CODE_ and F_INV_WAREHOUSE_NO = WAREHOUSE_NO and (F_BOX_NO IS NULL OR F_BOX_NO = 0) and (PRODUCT_STATUS IS NULL OR PRODUCT_STATUS = 0 OR PRODUCT_STATUS = 90))')->limit(1)->getQuery();

        // $count_boxed = Stock::selectRaw('(SELECT IFNULL(COUNT(IG_CODE),0) from INV_STOCK where IG_CODE = IG_CODE_ and F_INV_WAREHOUSE_NO = WAREHOUSE_NO and (F_BOX_NO IS NOT NULL))')->limit(1)->getQuery();

        // $count_shipped = Stock::selectRaw('(SELECT IFNULL(COUNT(IG_CODE),0) from INV_STOCK where IG_CODE = IG_CODE_ and F_INV_WAREHOUSE_NO = WAREHOUSE_NO and (F_SHIPPMENT_NO IS NOT NULL and F_BOX_NO IS NOT NULL))')->limit(1)->getQuery();

        // $count_shelved = Stock::selectRaw('(SELECT IFNULL(COUNT(IG_CODE),0) from INV_STOCK where IG_CODE = IG_CODE_ and F_INV_WAREHOUSE_NO = WAREHOUSE_NO and (F_INV_ZONE_NO IS NOT NULL))')->limit(1)->getQuery();

        // $count_not_shelved = Stock::selectRaw('(SELECT IFNULL(COUNT(IG_CODE),0) from INV_STOCK where IG_CODE = IG_CODE_ and F_INV_WAREHOUSE_NO = WAREHOUSE_NO and (F_INV_ZONE_NO IS NULL and F_BOX_NO IS NOT NULL and F_SHIPPMENT_NO IS NOT NULL and PRODUCT_STATUS = 60))')->limit(1)->getQuery();

        $dataSet = DB::table('INV_STOCK')
                ->select('PK_NO','SKUID','IG_CODE as IG_CODE_','BARCODE','PRD_VARINAT_NAME','PRD_VARIANT_IMAGE_PATH','INV_WAREHOUSE_NAME','F_INV_WAREHOUSE_NO as WAREHOUSE_NO'
                ,DB::raw('IFNULL(COUNT(SKUID),0) as COUNTET')
                ,DB::raw('(SELECT IFNULL(COUNT(IG_CODE),0) from INV_STOCK where IG_CODE = IG_CODE_ and F_INV_WAREHOUSE_NO = WAREHOUSE_NO and F_SHIPPMENT_NO IS NULL and F_BOX_NO IS NOT NULL) as BOXED_QTY')
                ,DB::raw('(SELECT IFNULL(COUNT(IG_CODE),0) from INV_STOCK where IG_CODE = IG_CODE_ and F_INV_WAREHOUSE_NO = WAREHOUSE_NO and (F_INV_ZONE_NO IS NULL and F_BOX_NO IS NOT NULL and F_SHIPPMENT_NO IS NOT NULL and PRODUCT_STATUS = 60)) as NOT_SHELVED_QTY')
                ,DB::raw('(SELECT IFNULL(COUNT(IG_CODE),0) from INV_STOCK where IG_CODE = IG_CODE_ and F_INV_WAREHOUSE_NO = WAREHOUSE_NO and (F_BOX_NO IS NULL OR F_BOX_NO = 0) and (PRODUCT_STATUS IS NULL OR PRODUCT_STATUS = 0 OR PRODUCT_STATUS = 90)) as YET_TO_BOXED_QTY')
                ,DB::raw('(SELECT IFNULL(COUNT(IG_CODE),0) from INV_STOCK where IG_CODE = IG_CODE_ and F_INV_WAREHOUSE_NO = WAREHOUSE_NO and (F_INV_ZONE_NO IS NOT NULL)) as SHELVED_QTY')
                ,DB::raw('(SELECT IFNULL(COUNT(IG_CODE),0) from INV_STOCK where IG_CODE = IG_CODE_ and F_INV_WAREHOUSE_NO = WAREHOUSE_NO and (F_SHIPPMENT_NO IS NOT NULL and F_BOX_NO IS NOT NULL and F_INV_ZONE_NO IS NULL)) as SHIPMENT_ASSIGNED_QTY')
                ,DB::raw('(SELECT IFNULL(COUNT(IG_CODE),0) from INV_STOCK where IG_CODE = IG_CODE_ and F_INV_WAREHOUSE_NO = WAREHOUSE_NO and BOOKING_STATUS between 10 and 79) as ORDERED')
                )
                // ->selectSub($count_boxed, 'boxed_qty')
                // ->selectSub($count_not_boxed, 'yet_to_boxed_qty')
                // ->selectSub($count_shipped, 'shipment_assigned_qty')
                // ->selectSub($count_shelved, 'shelved_qty')
                // ->selectSub($count_not_shelved, 'not_shelved_qty')
                // ->whereRaw('ORDER_STATUS IS NULL OR ORDER_STATUS < 80')
                ->groupBy('SKUID', 'F_INV_WAREHOUSE_NO')
                ->orderBy('PK_NO', 'DESC');  */

                // $stock = DB::SELECT(" SELECT PK_NO, SKUID, IG_CODE, BARCODE, PRD_VARINAT_NAME, PRD_VARIANT_IMAGE_PATH, INV_WAREHOUSE_NAME, F_INV_WAREHOUSE_NO,F_SHIPPMENT_NO, F_BOX_NO, F_INV_ZONE_NO, PRODUCT_STATUS, BOOKING_STATUS, ORDER_STATUS FROM INV_STOCK WHERE PRODUCT_STATUS IS NULL OR PRODUCT_STATUS != 420");

                $dataSet = DB::SELECT("SELECT PK_NO, SKUID, IG_CODE, BARCODE, PRD_VARINAT_NAME, PRD_VARIANT_IMAGE_PATH, INV_WAREHOUSE_NAME, F_INV_WAREHOUSE_NO AS WAREHOUSE_NO,F_PRD_VARIANT_NO
                FROM INV_STOCK
                WHERE PRODUCT_STATUS IS NULL OR PRODUCT_STATUS != 420
                GROUP BY SKUID, F_INV_WAREHOUSE_NO ORDER BY PK_NO DESC");

                if(!empty($dataSet) && count($dataSet)> 0){
                    foreach ($dataSet as $k => $value1) {
                        $boxed_qty              = 0;
                        $not_shelved_qty        = 0;
                        $yet_to_boxed_qty       = 0;
                        $shelved_qty            = 0;
                        $shipment_assigned_qty  = 0;
                        $ordered                = 0;
                        $dispatched             = 0;
                        $available              = 0;

                        // $stock = DB::SELECT("SELECT PK_NO, SKUID, IG_CODE, BARCODE, PRD_VARINAT_NAME, PRD_VARIANT_IMAGE_PATH, INV_WAREHOUSE_NAME, F_INV_WAREHOUSE_NO,F_SHIPPMENT_NO, F_BOX_NO, F_INV_ZONE_NO, PRODUCT_STATUS, BOOKING_STATUS, ORDER_STATUS FROM INV_STOCK WHERE IG_CODE='$value1->IG_CODE' AND F_INV_WAREHOUSE_NO=$value1->WAREHOUSE_NO AND ( PRODUCT_STATUS IS NULL OR PRODUCT_STATUS != 420)");
                        $stock = Stock::select('PK_NO', 'SKUID', 'IG_CODE', 'BARCODE', 'PRD_VARINAT_NAME', 'PRD_VARIANT_IMAGE_PATH', 'INV_WAREHOUSE_NAME', 'F_INV_WAREHOUSE_NO','F_SHIPPMENT_NO', 'F_BOX_NO', 'F_INV_ZONE_NO', 'PRODUCT_STATUS', 'BOOKING_STATUS', 'ORDER_STATUS')->where('IG_CODE',$value1->IG_CODE)->where('F_INV_WAREHOUSE_NO',$value1->WAREHOUSE_NO)->whereRaw('(PRODUCT_STATUS IS NULL OR PRODUCT_STATUS != 420)')->get();

                        if(!empty($stock)){

                            foreach ($stock as $l => $value2) {
                                if( ($value2->IG_CODE == $value1->IG_CODE) && ($value2->F_INV_WAREHOUSE_NO == $value1->WAREHOUSE_NO ) && ($value2->BOOKING_STATUS >= 10) && ($value2->BOOKING_STATUS <= 80) && ($value2->ORDER_STATUS < 80 OR $value2->ORDER_STATUS == null)){
                                    $ordered += 1;
                                }

                                if( ($value2->IG_CODE == $value1->IG_CODE) && ($value2->F_INV_WAREHOUSE_NO == $value1->WAREHOUSE_NO ) && ($value2->ORDER_STATUS < 80 OR $value2->ORDER_STATUS == null)){
                                    $available += 1;
                                }

                                if( ($value2->IG_CODE == $value1->IG_CODE) && ($value2->F_INV_WAREHOUSE_NO == $value1->WAREHOUSE_NO ) && ($value2->F_SHIPPMENT_NO == null) && ($value2->F_BOX_NO != null) && ($value2->ORDER_STATUS < 80 OR $value2->ORDER_STATUS == null)){
                                    $boxed_qty += 1;
                                }

                                if( ($value2->IG_CODE == $value1->IG_CODE) && ($value2->F_INV_WAREHOUSE_NO == $value1->WAREHOUSE_NO ) && ($value2->F_BOX_NO == null || $value2->F_BOX_NO == 0) && ($value2->PRODUCT_STATUS == null || $value2->PRODUCT_STATUS == 0 || $value2->PRODUCT_STATUS == 90 ) && ($value2->ORDER_STATUS < 80 OR $value2->ORDER_STATUS == null)){
                                    $yet_to_boxed_qty += 1;
                                }

                                if( ($value2->IG_CODE == $value1->IG_CODE) && ($value2->F_INV_WAREHOUSE_NO == $value1->WAREHOUSE_NO ) && ($value2->F_SHIPPMENT_NO != null) && ($value2->F_BOX_NO != null) && ($value2->F_INV_ZONE_NO == null) && ($value2->ORDER_STATUS < 80 OR $value2->ORDER_STATUS == null) && ($value2->PRODUCT_STATUS < 60)){
                                    $shipment_assigned_qty += 1;
                                }

                                if( ($value2->IG_CODE == $value1->IG_CODE) && ($value2->F_INV_WAREHOUSE_NO == $value1->WAREHOUSE_NO ) && ($value2->F_INV_ZONE_NO != null) && ($value2->ORDER_STATUS < 80 OR $value2->ORDER_STATUS == null)){
                                    $shelved_qty += 1;
                                }

                                if( ($value2->IG_CODE == $value1->IG_CODE) && ($value2->F_INV_WAREHOUSE_NO == $value1->WAREHOUSE_NO ) && ($value2->F_INV_ZONE_NO == null) && ($value2->ORDER_STATUS < 80 OR $value2->ORDER_STATUS == null) && ($value2->PRODUCT_STATUS >= 60)){
                                    $not_shelved_qty += 1;
                                }

                                if( ($value2->IG_CODE == $value1->IG_CODE) && ($value2->F_INV_WAREHOUSE_NO == $value1->WAREHOUSE_NO ) && ($value2->ORDER_STATUS >= 80)){
                                    $dispatched += 1;
                                }
                            }
                        }
                        $value1->BOXED_QTY              = $boxed_qty ;
                        $value1->NOT_SHELVED_QTY        = $not_shelved_qty ;
                        $value1->YET_TO_BOXED_QTY       = $yet_to_boxed_qty ;
                        $value1->SHELVED_QTY            = $shelved_qty ;
                        $value1->SHIPMENT_ASSIGNED_QTY  = $shipment_assigned_qty ;
                        $value1->ORDERED                = $ordered ;
                        $value1->DISPATCHED             = $dispatched ;
                        $value1->COUNTER                = $available ;
                    }
                }


                return Datatables::of($dataSet)
                ->addColumn('action', function($dataSet){
                    $roles = userRolePermissionArray();
                    $view = '';
                    if (hasAccessAbility('view_warehouse_stock_view', $roles)) {
                    $view = '<a href="'.route("admin.stock_price.view", [$dataSet->PK_NO]).'" class="btn btn-xs btn-success mb-05 mr-05" title="View Product"><i class="la la-eye"></i></a> <a href="'.route("admin.faulty.list", ['product',$dataSet->F_PRD_VARIANT_NO]).'" class="btn btn-xs btn-warning mb-05 mr-05" title="Mark Faulty"><i class="la la-warning"></i></a>';
                    }
                    return $view;
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function getDatatableUnshelved($request)
    {
        $house = $request->get('columns')[4]['search']['value'];

        $count_not_shelved = Stock::selectRaw('(SELECT IFNULL(COUNT(IG_CODE),0) from INV_STOCK where IG_CODE = ig_code_ and F_INV_WAREHOUSE_NO = warehouse_no and (F_INV_ZONE_NO IS NULL and PRODUCT_STATUS = 60 ))')->limit(1)->getQuery();

        $dataSet = DB::table('INV_STOCK')
                ->select('PK_NO','SKUID','PRD_VARINAT_NAME','BARCODE','PRD_VARIANT_IMAGE_PATH','INV_WAREHOUSE_NAME','IG_CODE as ig_code_','F_INV_WAREHOUSE_NO as warehouse_no')
                ->selectSub($count_not_shelved, 'count')
                ->whereNull('F_INV_ZONE_NO')
                ->whereNotNull('F_BOX_NO')
                ->whereNotNull('F_SHIPPMENT_NO')
                // ->where('PRODUCT_STATUS', '>=', 60)
                ->groupBy('F_INV_WAREHOUSE_NO','SKUID')
                ->orderBy('PK_NO', 'DESC');

                return Datatables::of($dataSet)
                ->addColumn('action', function($dataSet){
                    return '<a href="'.route("admin.unshelved.view", [$dataSet->PK_NO]).'" class="btn btn-xs btn-success mb-05 mr-05" title="View Product"><i class="la la-eye"></i></a>';
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function getDatatableBoxed($request)
    {
        $status = \Config::get('static_array.box_status');
        $dataSet = DB::table('SC_BOX')
                ->join('INV_WAREHOUSE', 'INV_WAREHOUSE.PK_NO', 'SC_BOX.F_INV_WAREHOUSE_NO')
                ->leftjoin('SC_SHIPMENT_BOX', 'SC_SHIPMENT_BOX.F_BOX_NO', 'SC_BOX.PK_NO')
                ->leftjoin('SC_SHIPMENT', 'SC_SHIPMENT.PK_NO', 'SC_SHIPMENT_BOX.F_SHIPMENT_NO')
                ->leftJoin('SLS_MERCHANT', 'SLS_MERCHANT.PK_NO','SC_BOX.F_MERCHANT_NO')
                ->select('SC_BOX.PK_NO','SC_BOX.BOX_NO','SC_BOX.USER_NAME','SC_BOX.ITEM_COUNT', 'INV_WAREHOUSE.NAME','SC_SHIPMENT.CODE','SC_BOX.BOX_STATUS','SC_BOX.WIDTH_CM','SC_BOX.LENGTH_CM','SC_BOX.HEIGHT_CM','SC_BOX.WEIGHT_KG','SC_BOX.PREFEX', DB::raw('(CASE WHEN SC_SHIPMENT_BOX.BOX_SERIAL IS NULL THEN "Box not assigned" ELSE SC_SHIPMENT_BOX.BOX_SERIAL END) AS BOX_SERIAL'), 'SLS_MERCHANT.NAME as MERCHANT_NAME');
                if($request->invoice_for == 'azuramart'){
                    $dataSet = $dataSet->where('SC_BOX.F_MERCHANT_NO',0);
                }else{
                    if(Auth::user()->F_MERCHANT_NO > 0){
                        $dataSet = $dataSet->where('SC_BOX.F_MERCHANT_NO', Auth::user()->F_MERCHANT_NO);
                    }else{
                        $dataSet = $dataSet->where('SC_BOX.F_MERCHANT_NO', '>', 0);
                    }
                }

                $dataSet = $dataSet->orderBy('SC_BOX.BOX_NO', 'DESC');
                return Datatables::of($dataSet)
                ->addColumn('action', function($dataSet) use ($request){
                    $roles = userRolePermissionArray();
                    $view = '';
                    $edit = '';
                    if (hasAccessAbility('view_box', $roles)) {
                        $view = '<a href="'.route("admin.box.view", ['id' => $dataSet->PK_NO, 'invoice_for' => $request->invoice_for]).'" class="btn btn-xs btn-success mb-05 mr-05" title="VIEW PRODUCTS"><i class="la la-eye"></i></a>';
                    }
                    if (hasAccessAbility('edit_box_label', $roles)) {
                        $edit = '<a href="javascript:void(0)" data-toggle="modal" id="box_label" data-target="#EditBoxLabel" title="EDIT BOX LABEL" data-url="'.route('admin.box_label.update').'" data-id="'.$dataSet->PK_NO.'" data-box_label="'.$dataSet->BOX_NO.'" class="btn btn-xs btn-info mb-05 mr-05" ><i class="la la-edit"></i></a>';
                    }
                    return $view.$edit;
                })
                ->addColumn('warehouse_status', function($dataSet) use ($status){

                    return $status[$dataSet->BOX_STATUS];
                })
                ->addColumn('box_for', function($dataSet) use ($request){
                   $box_for = '';
                   if($request->invoice_for == 'azuramart'){
                    $box_for = 'Azuramart';
                   }else{
                    $box_for = $dataSet->MERCHANT_NAME;
                   }
                    return $box_for;
                })
                ->addColumn('box_no', function($dataSet) use ($request){
                    $box_no = '('.$dataSet->PREFEX.') '.$dataSet->BOX_NO;
                    return $box_no;
                 })
                ->rawColumns(['box_no','warehouse_status', 'box_for','action'])
                ->make(true);
    }

    public function getDatatableShelved($request)
    {
    $dataSet = DB::table('INV_WAREHOUSE_ZONES')
            ->join('INV_WAREHOUSE', 'INV_WAREHOUSE.PK_NO', 'INV_WAREHOUSE_ZONES.F_INV_WAREHOUSE_NO')
            ->select('INV_WAREHOUSE_ZONES.*', 'INV_WAREHOUSE.NAME');
            if (isset($request->type) && $request->type == 'all') {
                $dataSet = $dataSet->where('ITEM_COUNT','>=',0);
            }else{
                $dataSet = $dataSet->where('ITEM_COUNT','!=',0);
            }
            $dataSet = $dataSet->groupBy('INV_WAREHOUSE_ZONES.PK_NO')
                                ->orderBy('INV_WAREHOUSE_ZONES.PK_NO', 'DESC');

            return Datatables::of($dataSet)
            ->addColumn('action', function($dataSet){
                return '<a href="'.route("admin.shelved.view", ['id' => $dataSet->PK_NO]).'" class="btn btn-xs btn-success mr-05" title="VIEW PRODUCT"><i class="la la-eye"></i></a><a href="'.route("admin.shelve.add", ['id'=>$dataSet->PK_NO]).'" class="btn btn-xs btn-info mr-05" title="EDIT SHELVE"><i class="la la-edit"></i></a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getDatatableNotBoxed($request)
    {
        if($request->invoice_for == 'merchant'){
            $dataSet = DB::table('MER_INV_STOCK')
            ->select('PK_NO','SKUID','PRD_VARINAT_NAME as VARINAT_NAME','PRD_VARIANT_IMAGE_PATH','INV_WAREHOUSE_NAME','IG_CODE as ig_code_','BARCODE',DB::raw('IFNULL(count(SKUID),0) as count'),  DB::raw(' "MERCHANT" as stock_for '))
            ->whereNull('F_BOX_NO')
            ->where('F_INV_WAREHOUSE_NO',1);
            if(Auth::user()->F_MERCHANT_NO > 0){
                $dataSet = $dataSet->where('F_MERCHANT_NO',Auth::user()->F_MERCHANT_NO);
            }
            $dataSet = $dataSet->orderBy('VARINAT_NAME', 'DESC')
            ->groupBy('F_INV_WAREHOUSE_NO','SKUID')
            ->get();
        }elseif($request->invoice_for == 'azuramart' && Auth::user()->F_MERCHANT_NO == 0){
            $dataSet = DB::table('INV_STOCK')
            ->select('PK_NO','SKUID','PRD_VARINAT_NAME as VARINAT_NAME','PRD_VARIANT_IMAGE_PATH','INV_WAREHOUSE_NAME','IG_CODE as ig_code_','BARCODE',DB::raw('IFNULL(count(SKUID),0) as count'), DB::raw(' "AMT" as stock_for '))
            ->whereNull('F_BOX_NO')
            ->Where('F_INV_WAREHOUSE_NO',1)
            ->orderBy('VARINAT_NAME', 'ASC')
            ->groupBy('F_INV_WAREHOUSE_NO','SKUID')
            ->get();
        }elseif($request->invoice_for == 'all' && Auth::user()->F_MERCHANT_NO == 0){
            $query1 = DB::table('INV_STOCK')
            ->select('INV_STOCK.PK_NO','INV_STOCK.SKUID','INV_STOCK.PRD_VARINAT_NAME as VARINAT_NAME','INV_STOCK.PRD_VARIANT_IMAGE_PATH','INV_STOCK.INV_WAREHOUSE_NAME','INV_STOCK.IG_CODE as ig_code_','INV_STOCK.BARCODE',DB::raw('IFNULL(count(INV_STOCK.SKUID),0) as count'),DB::raw(' "AMT" as stock_for ') )
            ->whereNull('INV_STOCK.F_BOX_NO')
            ->Where('INV_STOCK.F_INV_WAREHOUSE_NO',1)
            ->groupBy('INV_STOCK.F_INV_WAREHOUSE_NO','INV_STOCK.SKUID');
            // ->orderBy('INV_STOCK.PRD_VARINAT_NAME', 'DESC');

            $query2 = DB::table('MER_INV_STOCK')
            ->select('MER_INV_STOCK.PK_NO','MER_INV_STOCK.SKUID','MER_INV_STOCK.PRD_VARINAT_NAME as VARINAT_NAME','MER_INV_STOCK.PRD_VARIANT_IMAGE_PATH','MER_INV_STOCK.INV_WAREHOUSE_NAME','MER_INV_STOCK.IG_CODE as ig_code_','MER_INV_STOCK.BARCODE', DB::raw('IFNULL(count(MER_INV_STOCK.SKUID),0) as count'), DB::raw(' "MERCHANT" as stock_for '))
            ->whereNull('MER_INV_STOCK.F_BOX_NO')
            ->Where('MER_INV_STOCK.F_INV_WAREHOUSE_NO',1)
            ->groupBy('MER_INV_STOCK.F_INV_WAREHOUSE_NO','MER_INV_STOCK.SKUID');
            // ->orderBy('MER_INV_STOCK.PRD_VARINAT_NAME', 'DESC');

            $dataSet = $query1->union($query2);
            $dataSet = $dataSet->orderBy('VARINAT_NAME')->get();
            // ->orderBy('VARINAT_NAME')
            // ->groupBy('F_INV_WAREHOUSE_NO','SKUID')
            // ->get();
            // $dataSet = DB::SELECT("(select `INV_STOCK`.`PK_NO`, `INV_STOCK`.`SKUID`, `INV_STOCK`.`PRD_VARINAT_NAME`, `INV_STOCK`.`PRD_VARIANT_IMAGE_PATH`, `INV_STOCK`.`INV_WAREHOUSE_NAME`, `INV_STOCK`.`IG_CODE` as `ig_code_`, `INV_STOCK`.`BARCODE`, IFNULL(count(INV_STOCK.SKUID),0) as amt_count,  0 as mer_count from `INV_STOCK` where `INV_STOCK`.`F_BOX_NO` is null and `INV_STOCK`.`F_INV_WAREHOUSE_NO` = 1 group by `INV_STOCK`.`F_INV_WAREHOUSE_NO`, `INV_STOCK`.`SKUID`) union (select `MER_INV_STOCK`.`PK_NO`, `MER_INV_STOCK`.`SKUID`, `MER_INV_STOCK`.`PRD_VARINAT_NAME`, `MER_INV_STOCK`.`PRD_VARIANT_IMAGE_PATH`, `MER_INV_STOCK`.`INV_WAREHOUSE_NAME`, `MER_INV_STOCK`.`IG_CODE` as `ig_code_`, `MER_INV_STOCK`.`BARCODE`, 0 as amt_count, IFNULL(count(MER_INV_STOCK.SKUID),0) as mer_count from `MER_INV_STOCK` where `MER_INV_STOCK`.`F_BOX_NO` is null and `MER_INV_STOCK`.`F_INV_WAREHOUSE_NO` = 1 group by `MER_INV_STOCK`.`F_INV_WAREHOUSE_NO`, `MER_INV_STOCK`.`SKUID`) order by `PK_NO` desc");
        }
        return Datatables::of($dataSet,$request)
            // ->addColumn('action', function($dataSet,$request){
            //     return '<a href="'.route("admin.not_boxed.view", [$dataSet->PK_NO,'invoice_for='.$request->invoice_for.'']).'" class="btn btn-xs btn-success mb-05 mr-05" title="View Product"><i class="la la-eye"></i></a>';
            // })
            // ->rawColumns(['action'])
            ->make(true);
    }

    public function getDatatableSalesComission($request)
    {
        $date           = $request->get('columns')[4]['search']['value'];
        $agent          = Auth::user()->F_AGENT_NO;
        $now            = Carbon::now();
        $current_year   = $now->year;
        $current_month  = $now->month;

        $dataSet = DB::table('SLS_BOOKING as b')
                ->select('a.NAME','a.EMAIL','a.MOBILE_NO','b.CONFIRM_TIME','a.PK_NO'
                ,DB::raw('(IFNULL(SUM(bd.COMISSION),0)) as comission')
                )
                ->join('SLS_BOOKING_DETAILS as bd','bd.F_BOOKING_NO','b.PK_NO')
                ->join('SLS_ORDER as o','o.F_BOOKING_NO','b.PK_NO')
                ->rightjoin('SLS_AGENTS as a','a.PK_NO','b.F_SHOP_NO')
                ->where('a.IS_ACTIVE',1);
                if ($agent > 0) {
                    $dataSet = $dataSet->where('a.PK_NO',$agent);
                }
                if ($date != '') {
                    $current_year   = date('Y', strtotime($date));
                    $current_month  = date('n', strtotime($date));
                } else {
                    $current_year   = $now->year;
                    $current_month  = $now->month;
                }

                $dataSet = $dataSet->whereYear('b.SS_CREATED_ON',$current_year);
                $dataSet = $dataSet->whereMonth('b.SS_CREATED_ON',$current_month);

                $dataSet = $dataSet->orderBy('a.PK_NO','DESC')
                ->groupBy('b.F_SHOP_NO')->get();

                foreach ($dataSet as $key => $value) {

                    $data['cancelled_later'] = DB::table('SLS_BOOKING as b')
                    ->select(DB::raw('(IFNULL(SUM(bda.COMISSION),0)) as c_current_comission')
                    )
                    ->join('SLS_ORDER as o','o.F_BOOKING_NO','b.PK_NO')
                    ->join('SLS_BOOKING_DETAILS_AUD as bda','bda.F_BOOKING_NO','b.PK_NO')
                    ->whereYear('b.SS_CREATED_ON',$current_year)
                    ->whereMonth('b.SS_CREATED_ON',$current_month)
                    ->where('b.F_SHOP_NO',$value->PK_NO)
                    ->whereRaw('(bda.CHANGE_TYPE = "ORDER_CANCEL")')
                    ->groupBy('b.F_SHOP_NO')
                    ->first();

                    $data['cancelled_now'] = DB::table('SLS_BOOKING as b')
                    ->select(DB::raw('(IFNULL(SUM(bda.COMISSION),0)) as c_current_comission')
                    )
                    ->join('SLS_ORDER as o','o.F_BOOKING_NO','b.PK_NO')
                    ->join('SLS_BOOKING_DETAILS_AUD as bda','bda.F_BOOKING_NO','b.PK_NO')
                    ->whereYear('b.CANCELED_AT',$current_year)
                    ->whereMonth('b.CANCELED_AT',$current_month)
                    ->where('b.F_SHOP_NO',$value->PK_NO)
                    ->whereRaw('(bda.CHANGE_TYPE = "ORDER_CANCEL")')
                    ->groupBy('b.F_SHOP_NO')
                    ->first();

                    $data['return_later'] = DB::table('SLS_BOOKING as b')
                    ->select(DB::raw('(IFNULL(SUM(bda.COMISSION),0)) as c_current_comission')
                    )
                    ->join('SLS_ORDER as o','o.F_BOOKING_NO','b.PK_NO')
                    ->join('SLS_BOOKING_DETAILS_AUD as bda','bda.F_BOOKING_NO','b.PK_NO')
                    ->whereYear('b.SS_CREATED_ON',$current_year)
                    ->whereMonth('b.SS_CREATED_ON',$current_month)
                    ->where('b.F_SHOP_NO',$value->PK_NO)
                    ->whereRaw('(bda.CHANGE_TYPE = "ORDER_RETURN")')
                    ->whereIn('bda.RETURN_TYPE',[1,2,4])
                    ->groupBy('b.F_SHOP_NO')
                    ->first();

                    $data['return_now'] = DB::table('SLS_BOOKING as b')
                    ->select(DB::raw('(IFNULL(SUM(bda.COMISSION),0)) as c_current_comission')
                    )
                    ->join('SLS_ORDER as o','o.F_BOOKING_NO','b.PK_NO')
                    ->join('SLS_BOOKING_DETAILS_AUD as bda','bda.F_BOOKING_NO','b.PK_NO')
                    ->whereYear('bda.RETURN_DATE',$current_year)
                    ->whereMonth('bda.RETURN_DATE',$current_month)
                    ->where('b.F_SHOP_NO',$value->PK_NO)
                    ->whereRaw('(bda.CHANGE_TYPE = "ORDER_RETURN")')
                    ->whereIn('bda.RETURN_TYPE',[1,2,3,6])
                    ->groupBy('b.F_SHOP_NO')
                    ->first();

                    $value->comission += $data['cancelled_later']->c_current_comission ?? 0;
                    $value->comission += $data['return_later']->c_current_comission ?? 0;
                    $value->comission -= $data['cancelled_now']->c_current_comission ?? 0;
                    $value->comission -= $data['return_now']->c_current_comission ?? 0;
                }

                return Datatables::of($dataSet)
                ->addColumn('action', function($dataSet){
                    return '<a href="'.route('admin.sales_report.list-item',[$dataSet->PK_NO]).'" type="button" class="btn btn-xs btn-info mr-1 " title="VIEW">
                    <i class="la la-eye"></i></a>';
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function getDatatableSalesComissionList($request)
    {
        $date           = $request->get('columns')[9]['search']['value'];
        $now            = Carbon::now();

        $return_later = DB::table('SLS_BOOKING as b')
        ->select('b.BOOKING_TIME','b.CONFIRM_TIME','b.BOOKING_NO','s.PRD_VARINAT_NAME','b.CUSTOMER_NAME','b.SHOP_NAME','bda.CURRENT_IS_REGULAR','bda.CURRENT_REGULAR_PRICE','bda.CURRENT_INSTALLMENT_PRICE','bda.F_INV_STOCK_NO','a.NAME','b.PK_NO','b.SS_CREATED_ON','bda.F_BUNDLE_NO','bda.BUNDLE_SEQUENC','SLS_BUNDLE.BUNDLE_NAME_PUBLIC','CHANGE_TYPE'
        ,DB::raw('CONCAT("",bda.COMISSION) AS COMISSION')
        )
        ->leftjoin('SA_USER as a','a.PK_NO','b.F_SS_CREATED_BY')
        ->join('SLS_ORDER as o','o.F_BOOKING_NO','b.PK_NO')
        ->leftjoin('SLS_BOOKING_DETAILS_AUD as bda','bda.F_BOOKING_NO','b.PK_NO')
        ->leftjoin('INV_STOCK as s','s.PK_NO','bda.F_INV_STOCK_NO')
        ->leftjoin('SLS_BUNDLE','SLS_BUNDLE.PK_NO','bda.F_BUNDLE_NO')
        ->where('b.F_SHOP_NO',$request->segment)
        ->where('bda.CHANGE_TYPE','ORDER_RETURN')
        ->whereIn('bda.RETURN_TYPE',[1,2,4]);
        if ($date != '') {
            $current_year   = date('Y', strtotime($date));
            $current_month  = date('n', strtotime($date));
        } else {
            $current_year   = $now->year;
            $current_month  = $now->month;
        }
        $return_later = $return_later->whereYear('b.SS_CREATED_ON',$current_year);
        $return_later = $return_later->whereMonth('b.SS_CREATED_ON',$current_month);

        $return_now = DB::table('SLS_BOOKING as b')
        ->select('b.BOOKING_TIME','b.CONFIRM_TIME','b.BOOKING_NO','s.PRD_VARINAT_NAME','b.CUSTOMER_NAME','b.SHOP_NAME','bda.CURRENT_IS_REGULAR','bda.CURRENT_REGULAR_PRICE','bda.CURRENT_INSTALLMENT_PRICE','bda.F_INV_STOCK_NO','a.NAME','b.PK_NO','b.SS_CREATED_ON','bda.F_BUNDLE_NO','bda.BUNDLE_SEQUENC','SLS_BUNDLE.BUNDLE_NAME_PUBLIC','CHANGE_TYPE'
        ,DB::raw('CONCAT("-",bda.COMISSION) AS COMISSION')
        )
        ->leftjoin('SA_USER as a','a.PK_NO','b.F_SS_CREATED_BY')
        ->join('SLS_ORDER as o','o.F_BOOKING_NO','b.PK_NO')
        ->leftjoin('SLS_BOOKING_DETAILS_AUD as bda','bda.F_BOOKING_NO','b.PK_NO')
        ->leftjoin('INV_STOCK as s','s.PK_NO','bda.F_INV_STOCK_NO')
        ->leftjoin('SLS_BUNDLE','SLS_BUNDLE.PK_NO','bda.F_BUNDLE_NO')
        ->where('b.F_SHOP_NO',$request->segment)
        ->where('bda.CHANGE_TYPE','ORDER_RETURN')
        ->whereIn('bda.RETURN_TYPE',[1,2,3,6]);
        if ($date != '') {
            $current_year   = date('Y', strtotime($date));
            $current_month  = date('n', strtotime($date));
        } else {
            $current_year   = $now->year;
            $current_month  = $now->month;
        }
        $return_now = $return_now->whereYear('bda.RETURN_DATE',$current_year);
        $return_now = $return_now->whereMonth('bda.RETURN_DATE',$current_month);

        $canceled_later = DB::table('SLS_BOOKING as b')
                    ->select('b.BOOKING_TIME','b.CONFIRM_TIME','b.BOOKING_NO','s.PRD_VARINAT_NAME','b.CUSTOMER_NAME','b.SHOP_NAME','bda.CURRENT_IS_REGULAR','bda.CURRENT_REGULAR_PRICE','bda.CURRENT_INSTALLMENT_PRICE','bda.F_INV_STOCK_NO','a.NAME','b.PK_NO','b.SS_CREATED_ON','bda.F_BUNDLE_NO','bda.BUNDLE_SEQUENC','SLS_BUNDLE.BUNDLE_NAME_PUBLIC','CHANGE_TYPE'
                    ,DB::raw('CONCAT("",bda.COMISSION) AS COMISSION')
                    )
                    ->leftjoin('SA_USER as a','a.PK_NO','b.F_SS_CREATED_BY')
                    ->join('SLS_ORDER as o','o.F_BOOKING_NO','b.PK_NO')
                    ->leftjoin('SLS_BOOKING_DETAILS_AUD as bda','bda.F_BOOKING_NO','b.PK_NO')
                    // ->join('SLS_BOOKING_DETAILS as bd','bd.F_BOOKING_NO','b.PK_NO')
                    ->leftjoin('INV_STOCK as s','s.PK_NO','bda.F_INV_STOCK_NO')
                    ->leftjoin('SLS_BUNDLE','SLS_BUNDLE.PK_NO','bda.F_BUNDLE_NO')
                    // ->orderBy('bda.F_BOOKING_NO','DESC')
                    // ->orderBy('bda.F_BUNDLE_NO','DESC')
                    // ->orderBy('bda.BUNDLE_SEQUENC','ASC')
                    // ->groupBy('bda.PK_NO')
                    ->where('b.F_SHOP_NO',$request->segment)
                    ->where('bda.CHANGE_TYPE','ORDER_CANCEL');
                    if ($date != '') {
                        $current_year   = date('Y', strtotime($date));
                        $current_month  = date('n', strtotime($date));
                    } else {
                        $current_year   = $now->year;
                        $current_month  = $now->month;
                    }
                    $canceled_later = $canceled_later->whereYear('b.SS_CREATED_ON',$current_year);
                    $canceled_later = $canceled_later->whereMonth('b.SS_CREATED_ON',$current_month);

                    // $canceled_later = $canceled_later->orderBy('o.PK_NO','DESC');

        $canceled_now = DB::table('SLS_BOOKING as b')
                    ->select('b.BOOKING_TIME','b.CONFIRM_TIME','b.BOOKING_NO','s.PRD_VARINAT_NAME','b.CUSTOMER_NAME','b.SHOP_NAME','bda.CURRENT_IS_REGULAR','bda.CURRENT_REGULAR_PRICE','bda.CURRENT_INSTALLMENT_PRICE','bda.F_INV_STOCK_NO','a.NAME','b.PK_NO','b.SS_CREATED_ON','bda.F_BUNDLE_NO','bda.BUNDLE_SEQUENC','SLS_BUNDLE.BUNDLE_NAME_PUBLIC','CHANGE_TYPE'
                    // ,DB::raw('(concat("-" , bda.COMISSION) as COMISSION) ')
                    ,DB::raw('CONCAT("-",bda.COMISSION) AS COMISSION')
                    )
                    ->leftjoin('SA_USER as a','a.PK_NO','b.F_SS_CREATED_BY')
                    ->join('SLS_ORDER as o','o.F_BOOKING_NO','b.PK_NO')
                    ->leftjoin('SLS_BOOKING_DETAILS_AUD as bda','bda.F_BOOKING_NO','b.PK_NO')
                    // ->join('SLS_BOOKING_DETAILS as bd','bd.F_BOOKING_NO','b.PK_NO')
                    ->leftjoin('INV_STOCK as s','s.PK_NO','bda.F_INV_STOCK_NO')
                    ->leftjoin('SLS_BUNDLE','SLS_BUNDLE.PK_NO','bda.F_BUNDLE_NO')
                    // ->orderBy('bda.F_BOOKING_NO','DESC')
                    // ->orderBy('bda.F_BUNDLE_NO','DESC')
                    // ->orderBy('bda.BUNDLE_SEQUENC','ASC')
                    // ->groupBy('bda.PK_NO')
                    ->where('b.F_SHOP_NO',$request->segment)
                    ->where('bda.CHANGE_TYPE','ORDER_CANCEL');
                    if ($date != '') {
                        $current_year   = date('Y', strtotime($date));
                        $current_month  = date('n', strtotime($date));
                    } else {
                        $current_year   = $now->year;
                        $current_month  = $now->month;
                    }
                    $canceled_now = $canceled_now->whereYear('b.CANCELED_AT',$current_year);
                    $canceled_now = $canceled_now->whereMonth('b.CANCELED_AT',$current_month);

                    // $canceled_now = $canceled_now->orderBy('o.PK_NO','DESC');

        $dataSet = DB::table('SLS_BOOKING as b')
                    ->select('b.BOOKING_TIME','b.CONFIRM_TIME','b.BOOKING_NO','s.PRD_VARINAT_NAME','b.CUSTOMER_NAME','b.SHOP_NAME','bd.CURRENT_IS_REGULAR','bd.CURRENT_REGULAR_PRICE','bd.CURRENT_INSTALLMENT_PRICE','bd.F_INV_STOCK_NO','a.NAME','b.PK_NO','b.SS_CREATED_ON','bd.F_BUNDLE_NO','bd.BUNDLE_SEQUENC','SLS_BUNDLE.BUNDLE_NAME_PUBLIC'
                    ,DB::raw('( 0 ) as CHANGE_TYPE')
                    ,DB::raw('CONCAT("",bd.COMISSION) AS COMISSION')
                    )
                    ->leftjoin('SA_USER as a','a.PK_NO','b.F_SS_CREATED_BY')
                    ->join('SLS_ORDER as o','o.F_BOOKING_NO','b.PK_NO')
                    // ->leftjoin('SLS_BOOKING_DETAILS_AUD as bda','bda.F_BOOKING_NO','b.PK_NO')
                    ->join('SLS_BOOKING_DETAILS as bd','bd.F_BOOKING_NO','b.PK_NO')
                    ->leftjoin('INV_STOCK as s','s.PK_NO','bd.F_INV_STOCK_NO')
                    ->leftjoin('SLS_BUNDLE','SLS_BUNDLE.PK_NO','bd.F_BUNDLE_NO')
                    // ->orderBy('bd.F_BOOKING_NO','DESC')
                    // ->orderBy('bd.F_BUNDLE_NO','DESC')
                    // ->orderBy('bd.BUNDLE_SEQUENC','ASC')
                    // ->groupBy('bd.PK_NO')
                    ->where('b.F_SHOP_NO',$request->segment);
                    if ($date != '') {
                        $current_year   = date('Y', strtotime($date));
                        $current_month  = date('n', strtotime($date));
                    } else {
                        $current_year   = $now->year;
                        $current_month  = $now->month;
                    }
                    $dataSet = $dataSet->whereYear('b.SS_CREATED_ON',$current_year);
                    $dataSet = $dataSet->whereMonth('b.SS_CREATED_ON',$current_month)

                    // $dataSet = $dataSet->orderBy('o.PK_NO','DESC')
                    ->union($canceled_now)
                    ->union($canceled_later)
                    ->union($return_later)
                    ->union($return_now);
                    // ->orderBy('F_BUNDLE_NO','DESC')
                    // ->orderBy('BUNDLE_SEQUENC','ASC')
                    $query = $dataSet->toSql();
                    $dataSet = DB::table(DB::raw("($query order by PK_NO desc) as a"))->mergeBindings($dataSet);
                return Datatables::of($dataSet)
                ->addColumn('order', function($dataSet){
                    return '<a href="'.route("admin.booking.view", [$dataSet->PK_NO]).'" title="VIEW ORDER" target="_blank">ORD-'.$dataSet->BOOKING_NO.'</a>';
                })
                ->rawColumns(['order'])
                ->make(true);
    }

    public function getDatatableOrderCollection($request)
    {
        $agent_id            = Auth::user()->F_AGENT_NO;

        $dataSet = DB::table("SLS_ORDER")
            ->select('SLS_ORDER.PK_NO','SLS_ORDER.F_BOOKING_NO','SLS_ORDER.F_CUSTOMER_NO','SLS_ORDER.F_SHOP_NO','SLS_ORDER.CUSTOMER_NAME','SLS_ORDER.IS_READY','SLS_BOOKING.SS_CREATED_ON','SA_USER.NAME as CREATED_BY','SLS_BOOKING.SHOP_NAME','SLS_BOOKING.CONFIRM_TIME as ORDER_DATE','SLS_BOOKING.BOOKING_NO','SLS_BOOKING.SHOP_NAME','SLS_BOOKING.TOTAL_PRICE','SLS_BOOKING.DISCOUNT','SLS_BOOKING.PK_NO as  SLS_BOOKING_PK_NO','SLS_BOOKING.IS_RETURN','SLS_ORDER.ORDER_BUFFER_TOPUP','SLS_ORDER.ORDER_ACTUAL_TOPUP','SLS_ORDER.IS_SYSTEM_HOLD','SLS_ORDER.IS_ADMIN_HOLD','SLS_ORDER.DISPATCH_STATUS','SLS_ORDER.IS_CANCEL','SLS_BOOKING.CANCEL_REQUEST_BY','SLS_BOOKING.CANCEL_REQUEST_AT','SLS_ORDER.IS_SELF_PICKUP','SLS_BATCH_LIST.RTS_BATCH_NO','SLS_BOOKING.PENALTY_FEE','SLS_BOOKING.F_SHOP_NO'
            ,DB::raw('(select ifnull(count(PK_NO),0) from SLS_BOOKING_DETAILS where F_BOOKING_NO = SLS_BOOKING_PK_NO) as total_tobe_picked')
            )
            ->leftJoin('SLS_BOOKING','SLS_ORDER.F_BOOKING_NO','SLS_BOOKING.PK_NO')
            ->leftJoin('SA_USER','SLS_BOOKING.F_SS_CREATED_BY','SA_USER.PK_NO')
            ->join('SLS_BATCH_LIST','SLS_BATCH_LIST.PK_NO','SLS_ORDER.PICKUP_ID')
            ->where('SLS_ORDER.DISPATCH_STATUS', '<', '40')
            // ->whereIn('SLS_ORDER.DISPATCH_STATUS',[30,20])
            ->where('SLS_ORDER.IS_SELF_PICKUP',0);


        if ($agent_id > 0) {
            $dataSet->where('SLS_BOOKING.F_SHOP_NO',$agent_id);
        }
        if ($request->id > 0) {
            $dataSet->where('SLS_BATCH_LIST.PK_NO',$request->id);
        }
        return Datatables::of($dataSet)

        ->addColumn('created_at', function($dataSet){
            if ($dataSet->REQUEST_FOR == 'WEB' ) {
                $created_by = $dataSet->CUSTOMER_NAME;
            }else{
                $created_by = $dataSet->SHOP_NAME;
            }
            $created_at = '<div class="font-11">'.date('d-m-y h:i A',strtotime($dataSet->SS_CREATED_ON)).'</div><div>'.$created_by.'</div>';
            return $created_at;
        })
        ->addColumn('order_date', function($dataSet){
            if($dataSet->ORDER_DATE){
            $order_date = '<div>'.date('d-m-y',strtotime($dataSet->ORDER_DATE)).'</div>';
            }else{
                $order_date = '<div>'.date('d-m-y',strtotime($dataSet->SS_CREATED_ON)).'</div>';
            }
            return $order_date;
        })
        ->addColumn('order_id', function($dataSet){

            $order_id = '<a href="'.route("admin.booking.view", [$dataSet->SLS_BOOKING_PK_NO]).'">ORD-'.$dataSet->BOOKING_NO.'</a>';

            return $order_id;
        })
        ->addColumn('customer_name', function($dataSet){

            $customer_name = '<a href="'.route('admin.customer.view', [$dataSet->F_CUSTOMER_NO]).'">'.$dataSet->CUSTOMER_NAME.'</a>';
            return $customer_name;
        })
        ->addColumn('item_type', function($dataSet){
            $booking_no = $dataSet->F_BOOKING_NO;

            $query = DB::SELECT("SELECT SLS_BOOKING_DETAILS.F_BOOKING_NO,INV_STOCK.F_PRD_VARIANT_NO  FROM SLS_BOOKING_DETAILS LEFT JOIN INV_STOCK ON INV_STOCK.PK_NO = SLS_BOOKING_DETAILS.F_INV_STOCK_NO WHERE SLS_BOOKING_DETAILS.F_BOOKING_NO = $booking_no GROUP BY INV_STOCK.F_PRD_VARIANT_NO");

            $item_type = count($query) ?? 0;

            return $item_type;
        })
        ->addColumn('item_count', function($dataSet){

            $booking_no = $dataSet->F_BOOKING_NO;
            $item_type = BookingDetails::where('F_BOOKING_NO',$booking_no)->count();

            return $item_type;
        })
        ->addColumn('avaiable', function($dataSet){
            $avaiable = '';
            $zones = '';
            $shelve_zones = DB::SELECT("SELECT GROUP_CONCAT(IFNULL(INV_STOCK.F_INV_ZONE_NO,0)) AS ZONES from SLS_BOOKING_DETAILS join INV_STOCK on INV_STOCK.PK_NO = SLS_BOOKING_DETAILS.F_INV_STOCK_NO where SLS_BOOKING_DETAILS.F_BOOKING_NO = $dataSet->F_BOOKING_NO GROUP BY SLS_BOOKING_DETAILS.F_BOOKING_NO");


            if($dataSet->IS_READY == 0){
                $avaiable = '<div class="badge badge-primary d-block" title="NOT READY">Intransit</div>';
            }elseif($dataSet->IS_READY == 1){
                $avaiable = '<div class="badge badge-success d-block" title="READY">Ready</div>';
                if(!empty($shelve_zones)){
                    $zones  = $shelve_zones[0]->ZONES;
                    $zones_arr = explode(',', $zones);
                    if(in_array(0,$zones_arr)){
                        $avaiable = '<div class="badge badge-warning d-block " title="READY (Need to Shelve)">Ready</div>';
                    }
                }
            }elseif($dataSet->IS_READY == 2){
                $avaiable = '<div class="badge badge-warning d-block" title="PARTIALLY READY">Partially Ready</div>';
                if(!empty($shelve_zones)){
                    $zones  = $shelve_zones[0]->ZONES;
                    $zones_arr = explode(',', $zones);
                    if(in_array(0,$zones_arr)){
                        $avaiable = '<div class="badge badge-warning d-block  (Need to Shelve)" title="PARTIALLY READY">Partially</div>';
                    }

                }
            }
            return $avaiable;
        })
        ->addColumn('status', function($dataSet){

            $status = '';
            if($dataSet->IS_ADMIN_HOLD == 0){

                $item_picked = DB::SELECT("SELECT IFNULL(COUNT(PK_NO),0) AS PICKED from SLS_BOOKING_DETAILS where F_BOOKING_NO = $dataSet->F_BOOKING_NO and IS_COLLECTED_FOR_RTS = 1");

                $link = route("admin.order.dispatch",[$dataSet->F_BOOKING_NO]).'?type=rts';
                if (isset($item_picked) && $item_picked[0]->PICKED == $dataSet->total_tobe_picked) {
                    $rts = $dataSet->DISPATCH_STATUS == '30' ?'RTS' : ($dataSet->DISPATCH_STATUS == '20' ? 'RTS(H)' : 'Dispacthed(H)' );
                }else{
                    // $link = 'javascript:void(0)';
                    $rts = 'Please Collect';
                }

                    // $link = 'javascript:void(0)'.$item_picked[0]->PICKED ?? 0;
                /*NO ACTION BY ADMIN*/
                if($dataSet->DISPATCH_STATUS == '30'){
                    $status = '<div class="badge badge-success d-block" title="READY TO SHIP"><a href="'.$link.'">'.$rts.'</a></div>';
                }elseif($dataSet->DISPATCH_STATUS == '20'){
                    $status = '<div class="badge badge-info d-block" title="READY TO COLLECT (Partially)"><a href="'.$link.'">'.$rts.'</a></div>';
                }elseif($dataSet->DISPATCH_STATUS == '10'){
                    $status = '<div class="badge badge-primary d-block" title="DISPACTHED (Partially)">'.$rts.'</div>';
                }

            }else{
                /*ALL ADMIN ACTION*/
                if($dataSet->IS_ADMIN_HOLD == 1){
                    $status = '<div class="badge badge-warning d-block" title="HOLD">HOLD</div>';
                }
            }




            if($status == ''){
                if($dataSet->IS_SYSTEM_HOLD == 1)
                    {
                        $status = '<div class="badge badge-default d-block" title="In Processing"><i class="la la-spinner spinner"></i></div>';
                    }
            }
            return $status;
        })
        ->addColumn('action', function($dataSet){
            $roles = userRolePermissionArray();
            $action = '';
            if (hasAccessAbility('view_booking', $roles)) {

            $action .=' <a href="'.route("admin.booking.view", [$dataSet->SLS_BOOKING_PK_NO]).'" class="btn btn-xs btn-success mb-05 mr-05" title="VIEW ORDER"><i class="la la-eye"></i></a> <a href="'.route("admin.item_revert.batch", [$dataSet->SLS_BOOKING_PK_NO]).'" class="btn btn-xs btn-info" title="REVERT BACK" onclick="return confirm('. "'" .'Are you sure?'. "'" .')"><i class="la la-exchange"></i></a>';
            }
            return $action;
        })
        ->rawColumns(['created_at','order_date','order_id','customer_name','item_type','item_count','avaiable','status','action'])
        ->make(true);
    }

    public function getDatatableItemCollection($request)
    {
        $dataSet = DB::table("INV_STOCK")
            ->select('INV_STOCK.PK_NO','INV_STOCK.INV_ZONE_BARCODE','INV_STOCK.BOX_BARCODE','INV_STOCK.PRODUCT_STATUS','INV_STOCK.PRD_VARIANT_IMAGE_PATH','INV_STOCK.F_BOOKING_NO','INV_STOCK.PRD_VARINAT_NAME','SLS_BATCH_LIST.RTS_BATCH_NO','INV_STOCK.SKUID','SLS_BOOKING_DETAILS.RTS_COLLECTION_USER_ID','SLS_BATCH_LIST.RTS_BATCH_NO as batch_no'
            )
            ->leftJoin('SLS_BOOKING_DETAILS','INV_STOCK.PK_NO','SLS_BOOKING_DETAILS.F_INV_STOCK_NO')
            ->leftJoin('SLS_ORDER','SLS_ORDER.F_BOOKING_NO','SLS_BOOKING_DETAILS.F_BOOKING_NO')
            ->join('SLS_BATCH_LIST','SLS_BATCH_LIST.PK_NO','SLS_ORDER.PICKUP_ID')
            ->where('SLS_ORDER.DISPATCH_STATUS', '<', '40')
            // ->whereIn('SLS_ORDER.DISPATCH_STATUS',[30,20])
            // ->where('SLS_ORDER.IS_SELF_PICKUP',0)
            // ->where('INV_STOCK.PRODUCT_STATUS','>=',60)
            ->where('SLS_BOOKING_DETAILS.IS_COLLECTED_FOR_RTS',0)
            ->where('SLS_BATCH_LIST.RTS_BATCH_NO',$request->id)
            ->groupBy('INV_STOCK.IG_CODE')
            ->orderBy('SLS_ORDER.PICKUP_ID','ASC');

        return Datatables::of($dataSet)
        ->addColumn('image', function($dataSet){
            return '<img src="'.asset($dataSet->PRD_VARIANT_IMAGE_PATH).'" class="w100" alt="Image">';
        })
        ->addColumn('assign_user', function($dataSet){
            $user = \App\Models\Auth::select('NAME')->where('PK_NO',$dataSet->RTS_COLLECTION_USER_ID)->first();
            if (empty($user->NAME)) {
                $user   = 'Unassigned';
                $class  = 'btn-warning';
            }else{
                $user = $user->NAME;
                $class  = 'btn-success';
            }
            $assign_user = '<button type="button" title="ASSIGN USER" id="assign_logistic" class="btn btn-xs '.$class.' mb-05 mr-05" data-batch_id="'.$dataSet->batch_no.'" data-sku_id="'.$dataSet->SKUID.'" data-user_id="'.$dataSet->RTS_COLLECTION_USER_ID.'" data-toggle="modal" data-target="#_modal">'.$user.'</button>';
            return $assign_user;
        })
        ->addColumn('position', function($dataSet){
            $return = '';
            $in_landing = DB::SELECT("SELECT INV_STOCK.PK_NO
            from INV_STOCK
            inner join SLS_BOOKING_DETAILS on INV_STOCK.PK_NO = SLS_BOOKING_DETAILS.F_INV_STOCK_NO
            inner join SLS_ORDER  on SLS_ORDER.F_BOOKING_NO = SLS_BOOKING_DETAILS.F_BOOKING_NO
            inner join SLS_BATCH_LIST  on SLS_BATCH_LIST.PK_NO = SLS_ORDER.PICKUP_ID
            where SLS_ORDER.DISPATCH_STATUS < 40
            and SLS_BATCH_LIST.RTS_BATCH_NO = $dataSet->batch_no
            and  INV_STOCK.F_INV_ZONE_NO IS NULL
            and INV_STOCK.SKUID = $dataSet->SKUID
            and SLS_BOOKING_DETAILS.IS_COLLECTED_FOR_RTS = 0
            group by INV_STOCK.PK_NO");
            $in_landing = count($in_landing) ?? 0;

            // $in_shelve = DB::SELECT("SELECT INV_STOCK.INV_ZONE_BARCODE from SLS_ORDER left join SLS_BOOKING_DETAILS on SLS_ORDER.F_BOOKING_NO = SLS_BOOKING_DETAILS.F_BOOKING_NO inner join INV_STOCK on INV_STOCK.F_BOOKING_NO = SLS_BOOKING_DETAILS.F_BOOKING_NO where SLS_ORDER.DISPATCH_STATUS < 40 and SLS_ORDER.PICKUP_ID = $dataSet->PICKUP_ID and INV_STOCK.PRODUCT_STATUS >= 60 and  INV_STOCK.F_INV_ZONE_NO IS NOT NULL and INV_STOCK.SKUID = $dataSet->SKUID group by INV_STOCK.PK_NO");
            $in_shelve = DB::SELECT("SELECT INV_STOCK.INV_ZONE_BARCODE,INV_WAREHOUSE_ZONES.DESCRIPTION,COUNT(*) as count
            from INV_STOCK
            left join SLS_BOOKING_DETAILS on INV_STOCK.PK_NO = SLS_BOOKING_DETAILS.F_INV_STOCK_NO
            left join SLS_ORDER on SLS_ORDER.F_BOOKING_NO = SLS_BOOKING_DETAILS.F_BOOKING_NO
            inner join SLS_BATCH_LIST  on SLS_BATCH_LIST.PK_NO = SLS_ORDER.PICKUP_ID
            left join INV_WAREHOUSE_ZONES on INV_WAREHOUSE_ZONES.ZONE_BARCODE = INV_STOCK.INV_ZONE_BARCODE
            where INV_STOCK.F_INV_ZONE_NO IS NOT NULL
            and SLS_BATCH_LIST.RTS_BATCH_NO = $dataSet->batch_no
            and INV_STOCK.SKUID = $dataSet->SKUID
            and SLS_BOOKING_DETAILS.IS_COLLECTED_FOR_RTS = 0
            and SLS_ORDER.DISPATCH_STATUS < 40
            group by INV_STOCK.INV_ZONE_BARCODE");
            // $in_shelve_count = count($in_shelve) ?? 0;

            if ($in_landing > 0) {
                $return .= ' Item Is In Landing Area '.' ('.$in_landing.')<br>';
            }
            if (!empty($in_shelve)) {
                foreach ($in_shelve as $key => $value) {
                    $return .= ' Item Is In Shelve - '.$value->INV_ZONE_BARCODE.' ('.$value->count.')'
                                    .'<br><strong>Description: </strong>'.$value->DESCRIPTION.'<br>';
                }
            }
            return $return;
        })
        ->addColumn('total_count', function($dataSet){
            $return = '';

            $in_landing = DB::SELECT("SELECT INV_STOCK.PK_NO
            from INV_STOCK
            inner join SLS_BOOKING_DETAILS on INV_STOCK.PK_NO = SLS_BOOKING_DETAILS.F_INV_STOCK_NO
            inner join SLS_ORDER  on SLS_ORDER.F_BOOKING_NO = SLS_BOOKING_DETAILS.F_BOOKING_NO
            inner join SLS_BATCH_LIST  on SLS_BATCH_LIST.PK_NO = SLS_ORDER.PICKUP_ID
            where SLS_ORDER.DISPATCH_STATUS < 40
            and SLS_BATCH_LIST.RTS_BATCH_NO = $dataSet->batch_no
            and  INV_STOCK.F_INV_ZONE_NO IS NULL
            and INV_STOCK.SKUID = $dataSet->SKUID
            and SLS_BOOKING_DETAILS.IS_COLLECTED_FOR_RTS = 0
            group by INV_STOCK.PK_NO");
            $in_landing = count($in_landing) ?? 0;

            $in_shelve = DB::SELECT("SELECT INV_STOCK.PK_NO
            from INV_STOCK
            left join SLS_BOOKING_DETAILS on INV_STOCK.PK_NO = SLS_BOOKING_DETAILS.F_INV_STOCK_NO
            left join SLS_ORDER on SLS_ORDER.F_BOOKING_NO = SLS_BOOKING_DETAILS.F_BOOKING_NO
            inner join SLS_BATCH_LIST  on SLS_BATCH_LIST.PK_NO = SLS_ORDER.PICKUP_ID
            left join INV_WAREHOUSE_ZONES on INV_WAREHOUSE_ZONES.ZONE_BARCODE = INV_STOCK.INV_ZONE_BARCODE
            where INV_STOCK.F_INV_ZONE_NO IS NOT NULL
            and SLS_BATCH_LIST.RTS_BATCH_NO = $dataSet->batch_no
            and INV_STOCK.SKUID = $dataSet->SKUID
            and SLS_BOOKING_DETAILS.IS_COLLECTED_FOR_RTS = 0
            and SLS_ORDER.DISPATCH_STATUS < 40");
            $in_shelve = count($in_shelve) ?? 0;

            return $in_landing + $in_shelve;
        })
        ->rawColumns(['image','assign_user','position','total_count'])
        ->make(true);
    }

    public function getDatatableItemCollectedList($request)
    {
        $dataSet = DB::table("INV_STOCK")
            ->select('INV_STOCK.PK_NO','INV_STOCK.BARCODE','INV_STOCK.INV_ZONE_BARCODE','INV_STOCK.BOX_BARCODE','INV_STOCK.PRODUCT_STATUS','INV_STOCK.PRD_VARIANT_IMAGE_PATH','INV_STOCK.F_BOOKING_NO','INV_STOCK.PRD_VARINAT_NAME','SLS_BATCH_LIST.RTS_BATCH_NO','INV_STOCK.SKUID','SLS_BOOKING_DETAILS.RTS_COLLECTION_USER_ID','SLS_BATCH_LIST.PK_NO as batch_pk'
            )
            ->leftJoin('SLS_BOOKING_DETAILS','INV_STOCK.PK_NO','SLS_BOOKING_DETAILS.F_INV_STOCK_NO')
            ->leftJoin('SLS_ORDER','SLS_ORDER.F_BOOKING_NO','SLS_BOOKING_DETAILS.F_BOOKING_NO')
            ->leftjoin('SLS_BATCH_LIST','SLS_BATCH_LIST.PK_NO','SLS_ORDER.PICKUP_ID')
            ->leftJoin('SC_ORDER_DISPATCH','SC_ORDER_DISPATCH.F_ORDER_NO','SLS_ORDER.PK_NO')
            ->where('SLS_ORDER.DISPATCH_STATUS', '<', '40')
            // ->where('SC_ORDER_DISPATCH.IS_DISPATHED', '!=', 1)
            ->where('SLS_ORDER.IS_SELF_PICKUP',0)
            // ->where('INV_STOCK.PRODUCT_STATUS','>=',60)
            // ->where('SLS_BOOKING_DETAILS.IS_COLLECTED_FOR_RTS',0)
            ->where('SLS_ORDER.PICKUP_ID',$request->id)
            ->groupBy('INV_STOCK.IG_CODE')
            ->orderBy('SLS_ORDER.PICKUP_ID','ASC');

        return Datatables::of($dataSet)
        ->addColumn('image', function($dataSet){
            return '<img src="'.asset($dataSet->PRD_VARIANT_IMAGE_PATH).'" class="w100" alt="Image">';
        })
        ->addColumn('assign_user', function($dataSet){
            $user = \App\Models\Auth::select('NAME')->where('PK_NO',$dataSet->RTS_COLLECTION_USER_ID)->first();
            if (empty($user->NAME)) {
                $user   = 'Unassigned';
                $class  = 'btn-warning';
            }else{
                $user = $user->NAME;
                $class  = 'btn-success';
            }
            $assign_user = '<button type="button" title="ASSIGN USER" id="assign_logistic" class="btn btn-xs '.$class.' mb-05 mr-05" data-batch_id="'.$dataSet->batch_pk.'" data-sku_id="'.$dataSet->SKUID.'" data-user_id="'.$dataSet->RTS_COLLECTION_USER_ID.'" data-toggle="modal" data-target="#_modal">'.$user.'</button>';
            return $assign_user;
        })
        ->addColumn('bulk_assign', function($dataSet){
            $bulk_assign = '<input type="checkbox" name="record_check" value='.$dataSet->SKUID.' class="mr-1 record_check c-p" style="float:right">';
            return $bulk_assign;
        })
        ->addColumn('position', function($dataSet){
            $return = '';

            $in_landing = DB::SELECT("SELECT INV_STOCK.PK_NO
            from INV_STOCK
            inner join SLS_BOOKING_DETAILS on INV_STOCK.PK_NO = SLS_BOOKING_DETAILS.F_INV_STOCK_NO
            inner join SLS_ORDER  on SLS_ORDER.F_BOOKING_NO = SLS_BOOKING_DETAILS.F_BOOKING_NO
            inner join SLS_BATCH_LIST  on SLS_BATCH_LIST.PK_NO = SLS_ORDER.PICKUP_ID
            where SLS_ORDER.DISPATCH_STATUS < 40
            and SLS_BATCH_LIST.RTS_BATCH_NO = $dataSet->RTS_BATCH_NO
            and  INV_STOCK.F_INV_ZONE_NO IS NULL
            and INV_STOCK.SKUID = $dataSet->SKUID
            group by INV_STOCK.PK_NO");
            $in_landing = count($in_landing) ?? 0;

            $in_landing_collected = DB::SELECT("SELECT INV_STOCK.PK_NO
            from INV_STOCK
            inner join SLS_BOOKING_DETAILS on INV_STOCK.PK_NO = SLS_BOOKING_DETAILS.F_INV_STOCK_NO
            inner join SLS_ORDER  on SLS_ORDER.F_BOOKING_NO = SLS_BOOKING_DETAILS.F_BOOKING_NO
            inner join SLS_BATCH_LIST  on SLS_BATCH_LIST.PK_NO = SLS_ORDER.PICKUP_ID
            where SLS_ORDER.DISPATCH_STATUS < 40
            and SLS_BATCH_LIST.RTS_BATCH_NO = $dataSet->RTS_BATCH_NO
            and  INV_STOCK.F_INV_ZONE_NO IS NULL
            and INV_STOCK.SKUID = $dataSet->SKUID
            -- and SLS_BOOKING_DETAILS.IS_COLLECTED_FOR_RTS = 0
            and SLS_BOOKING_DETAILS.IS_COLLECTED_FOR_RTS = 1
            group by INV_STOCK.PK_NO");
            $in_landing_collected = count($in_landing_collected) ?? 0;

            $in_shelve = DB::SELECT("SELECT INV_STOCK.INV_ZONE_BARCODE,INV_WAREHOUSE_ZONES.DESCRIPTION,F_INV_ZONE_NO as w_zone,COUNT(*) as count,
            (SELECT IFNULL(COUNT(*),0)
             from INV_STOCK
             left join SLS_BOOKING_DETAILS on INV_STOCK.PK_NO = SLS_BOOKING_DETAILS.F_INV_STOCK_NO
             left join SLS_ORDER on SLS_ORDER.F_BOOKING_NO = SLS_BOOKING_DETAILS.F_BOOKING_NO
             inner join SLS_BATCH_LIST  on SLS_BATCH_LIST.PK_NO = SLS_ORDER.PICKUP_ID
             left join INV_WAREHOUSE_ZONES on INV_WAREHOUSE_ZONES.ZONE_BARCODE = INV_STOCK.INV_ZONE_BARCODE
             where INV_STOCK.F_INV_ZONE_NO IS NOT NULL
             and SLS_BATCH_LIST.RTS_BATCH_NO = $dataSet->RTS_BATCH_NO
              and INV_STOCK.SKUID = $dataSet->SKUID
             and SLS_BOOKING_DETAILS.IS_COLLECTED_FOR_RTS = 1
             and SLS_ORDER.DISPATCH_STATUS < 40
             and F_INV_ZONE_NO = w_zone
             LIMIT 1 ) as count_collected
            from INV_STOCK
            left join SLS_BOOKING_DETAILS on INV_STOCK.PK_NO = SLS_BOOKING_DETAILS.F_INV_STOCK_NO
            left join SLS_ORDER on SLS_ORDER.F_BOOKING_NO = SLS_BOOKING_DETAILS.F_BOOKING_NO
            inner join SLS_BATCH_LIST  on SLS_BATCH_LIST.PK_NO = SLS_ORDER.PICKUP_ID
            left join INV_WAREHOUSE_ZONES on INV_WAREHOUSE_ZONES.ZONE_BARCODE = INV_STOCK.INV_ZONE_BARCODE
            where INV_STOCK.F_INV_ZONE_NO IS NOT NULL
            and SLS_BATCH_LIST.RTS_BATCH_NO = $dataSet->RTS_BATCH_NO
            and INV_STOCK.SKUID = $dataSet->SKUID
            -- and SLS_BOOKING_DETAILS.IS_COLLECTED_FOR_RTS = 0
            and SLS_ORDER.DISPATCH_STATUS < 40
            group by INV_STOCK.INV_ZONE_BARCODE");

            if ($in_landing > 0) {
                $return .= '<span title="COLLECTED-'.$in_landing_collected.'TOTAL-'.$in_landing.'"> Item Is In Landing Area '.' ('.$in_landing_collected.' / '.$in_landing.')</span><br>';
            }
            if (!empty($in_shelve)) {
                foreach ($in_shelve as $key => $value) {
                    $return .= ' <span title="COLLECTED-'.$value->count_collected.'TOTAL-'.$value->count.' ">Item Is In Shelve - '.$value->INV_ZONE_BARCODE.' ('.$value->count_collected.' / '.$value->count.')'
                                    .'<br><strong>Description: </strong>'.$value->DESCRIPTION.'</span><br>';
                }
            }
            return $return;
        })
        ->addColumn('total_count', function($dataSet){
            $return = '';

            $in_landing = DB::SELECT("SELECT INV_STOCK.PK_NO
            from INV_STOCK
            inner join SLS_BOOKING_DETAILS on INV_STOCK.PK_NO = SLS_BOOKING_DETAILS.F_INV_STOCK_NO
            inner join SLS_ORDER  on SLS_ORDER.F_BOOKING_NO = SLS_BOOKING_DETAILS.F_BOOKING_NO
            inner join SLS_BATCH_LIST  on SLS_BATCH_LIST.PK_NO = SLS_ORDER.PICKUP_ID
            where SLS_ORDER.DISPATCH_STATUS < 40
            and SLS_BATCH_LIST.RTS_BATCH_NO = $dataSet->RTS_BATCH_NO
            and  INV_STOCK.F_INV_ZONE_NO IS NULL
            and INV_STOCK.SKUID = $dataSet->SKUID
            -- and SLS_BOOKING_DETAILS.IS_COLLECTED_FOR_RTS = 0
            group by INV_STOCK.PK_NO");
            $in_landing = count($in_landing) ?? 0;

            $in_landing_collected = DB::SELECT("SELECT INV_STOCK.PK_NO
            from INV_STOCK
            inner join SLS_BOOKING_DETAILS on INV_STOCK.PK_NO = SLS_BOOKING_DETAILS.F_INV_STOCK_NO
            inner join SLS_ORDER  on SLS_ORDER.F_BOOKING_NO = SLS_BOOKING_DETAILS.F_BOOKING_NO
            inner join SLS_BATCH_LIST  on SLS_BATCH_LIST.PK_NO = SLS_ORDER.PICKUP_ID
            where SLS_ORDER.DISPATCH_STATUS < 40
            and SLS_BATCH_LIST.RTS_BATCH_NO = $dataSet->RTS_BATCH_NO
            and  INV_STOCK.F_INV_ZONE_NO IS NULL
            and INV_STOCK.SKUID = $dataSet->SKUID
            and SLS_BOOKING_DETAILS.IS_COLLECTED_FOR_RTS = 1
            group by INV_STOCK.PK_NO");
            $in_landing_collected = count($in_landing_collected) ?? 0;

            $in_shelve = DB::SELECT("SELECT INV_STOCK.PK_NO
            from INV_STOCK
            left join SLS_BOOKING_DETAILS on INV_STOCK.PK_NO = SLS_BOOKING_DETAILS.F_INV_STOCK_NO
            left join SLS_ORDER on SLS_ORDER.F_BOOKING_NO = SLS_BOOKING_DETAILS.F_BOOKING_NO
            inner join SLS_BATCH_LIST  on SLS_BATCH_LIST.PK_NO = SLS_ORDER.PICKUP_ID
            left join INV_WAREHOUSE_ZONES on INV_WAREHOUSE_ZONES.ZONE_BARCODE = INV_STOCK.INV_ZONE_BARCODE
            where INV_STOCK.F_INV_ZONE_NO IS NOT NULL
            and SLS_BATCH_LIST.RTS_BATCH_NO = $dataSet->RTS_BATCH_NO
            and INV_STOCK.SKUID = $dataSet->SKUID
            -- and SLS_BOOKING_DETAILS.IS_COLLECTED_FOR_RTS = 1
            and SLS_ORDER.DISPATCH_STATUS < 40");
            $in_shelve = count($in_shelve) ?? 0;

            $in_shelve_collected = DB::SELECT("SELECT INV_STOCK.PK_NO
            from INV_STOCK
            left join SLS_BOOKING_DETAILS on INV_STOCK.PK_NO = SLS_BOOKING_DETAILS.F_INV_STOCK_NO
            left join SLS_ORDER on SLS_ORDER.F_BOOKING_NO = SLS_BOOKING_DETAILS.F_BOOKING_NO
            inner join SLS_BATCH_LIST  on SLS_BATCH_LIST.PK_NO = SLS_ORDER.PICKUP_ID
            left join INV_WAREHOUSE_ZONES on INV_WAREHOUSE_ZONES.ZONE_BARCODE = INV_STOCK.INV_ZONE_BARCODE
            where INV_STOCK.F_INV_ZONE_NO IS NOT NULL
            and SLS_BATCH_LIST.RTS_BATCH_NO = $dataSet->RTS_BATCH_NO
            and INV_STOCK.SKUID = $dataSet->SKUID
            and SLS_BOOKING_DETAILS.IS_COLLECTED_FOR_RTS = 1
            and SLS_ORDER.DISPATCH_STATUS < 40");
            $in_shelve_collected = count($in_shelve_collected) ?? 0;

            return '<span>'.($in_landing_collected+$in_shelve_collected).' / '.($in_landing+$in_shelve).'</span>';
        })
        ->rawColumns(['image','assign_user','position','bulk_assign','total_count'])
        ->make(true);
    }

    public function customerRefundlist($request)
    {
        $dataSet = DB::table("SLS_CUSTOMERS as c")
        ->select('c.PK_NO AS CUSTOMER_PK_NO','c.CUSTOMER_NO','c.NAME as CUSTOMER_NAME','c.MOBILE_NO as CUSTOMER_MOBILE_NO',
        'c.CUM_BALANCE AS CUSTOMER_CUM_BALANCE')
        ->where('c.CUM_BALANCE','>' ,0)
      //  ->whereIn('c.PK_NO',[1441,1362,1036,1068,604,1169,1821,1666,1760,1646,284,1266,1841,1046,318,533])
        ->orderBy('c.NAME', 'ASC');

        return Datatables::of($dataSet)
        ->addColumn('customer_no', function($dataSet){
            $customer_no = '';
            $customer_no = '<a href="#" class="" title="Customer No">'.$dataSet->CUSTOMER_NO.'</a>';
            return $customer_no;
        })
        ->addColumn('customer_name', function($dataSet){
            $customer_name = '';
            $customer_name = '<a href="'.route("admin.customer.view", [$dataSet->CUSTOMER_PK_NO]). '" class="" title="Customer name">'.$dataSet->CUSTOMER_NAME.'</a>';
            return $customer_name;

        })
        ->addColumn('mobile', function($dataSet){
            $mobile = $dataSet->CUSTOMER_MOBILE_NO;
            return $mobile;
        })
        ->addColumn('balance', function($dataSet){
            $total_pay = '';
            $total_used = '';
            $balance = '';
            $balance1 = '';
            $balance2 = '';
            $request_amt_txt = '';
            $request_amt = DB::table('ACC_CUST_RES_REFUND_REQUEST')->where('STATUS', 0)->where('F_CUSTOMER_NO',$dataSet->CUSTOMER_PK_NO)->sum('MR_AMOUNT');
            $balance = '<p style="margin-bottom: 1px;">Credit : <small></small> <strong>'.number_format($dataSet->CUSTOMER_CUM_BALANCE,2).'</strong> </p>';
            if($request_amt > 0 ){

                $request_amt_txt = ' <p style="margin-bottom: 1px;"> Request : <small></small> <strong>'.number_format($request_amt,2).'</strong></p>';
            }

            return $balance.$request_amt_txt.$total_pay.$total_used.$balance1.$balance2;
        })
        ->addColumn('action', function($dataSet){
            $role = $this->getMyRole();
            $refund = '';
            if($role->ROLE_NO == 1){
                $refund = ' <a href="'.route('admin.payment.refund', ['id' => $dataSet->CUSTOMER_PK_NO, 'type' => 'customer' ]).'" class="btn btn-xs btn-primary mb-05 mr-05" title="Direct refund by admin">R</a>';
            }


            $request = ' <button data-customer_no="'.$dataSet->CUSTOMER_PK_NO.'" data-name="'.$dataSet->CUSTOMER_NAME.'" data-balance="'.$dataSet->CUSTOMER_CUM_BALANCE.'" class="btn btn-xs btn-primary mb-05 mr-05 refundRequest" data-toggle="modal" data-target="#refundRequestModal"  title="Refud request"><i class="la la-plus"></i></button>';

            return $refund .$request;

        })
        ->rawColumns(['customer_no','customer_name','mobile', 'balance','action'])
        ->make(true);
    }


    public function resellerRefundlist($request)
    {
        $dataSet = DB::table("SLS_SELLERS as c")
        ->select('c.PK_NO AS SELLER_PK_NO','c.SELLER_NO','c.NAME as SHOP_NAME','c.MOBILE_NO as SELLER_MOBILE_NO','c.CUM_BALANCE AS SELLER_CUM_BALANCE','r.DIAL_CODE','c.F_COUNTRY_NO')
        ->leftjoin('SS_COUNTRY as r', 'r.PK_NO','c.F_COUNTRY_NO')
        ->where('c.CUM_BALANCE','>' ,0)
        ->orderBy('c.NAME', 'ASC');

        return Datatables::of($dataSet)
        ->addColumn('reseller_no', function($dataSet){
            $seller_no = '';
            $seller_no = '<a href="#" class="" title="SELLER No">'.$dataSet->SELLER_NO.'</a>';
            return $seller_no;
        })
        ->addColumn('SHOP_NAME', function($dataSet){
            $SHOP_NAME = '';
            $SHOP_NAME = '<a href="'.route("admin.seller.view", [$dataSet->SELLER_PK_NO]). '" class="" title="seller name">'.$dataSet->SHOP_NAME.'</a>';
            return $SHOP_NAME;

        })
        ->addColumn('mobile', function($dataSet){
            $mobile = $dataSet->DIAL_CODE.' '.$dataSet->SELLER_MOBILE_NO;
            return $mobile;
        })
        ->addColumn('balance', function($dataSet){
            $total_pay = '';
            $total_used = '';
            $balance = '';
            $balance1 = '';
            $balance2 = '';
            $request_amt_txt = '';
            $request_amt = DB::table('ACC_CUST_RES_REFUND_REQUEST')->where('STATUS', 0)->where('F_SHOP_NO',$dataSet->SELLER_PK_NO)->sum('MR_AMOUNT');
            $balance = '<p style="margin-bottom: 1px;">Credit : <small></small> <strong>'.number_format($dataSet->SELLER_CUM_BALANCE,2).'</strong> </p>';
            if($request_amt > 0 ){

                $request_amt_txt = ' <p style="margin-bottom: 1px;"> Request : <small></small> <strong>'.number_format($request_amt,2).'</strong></p>';
            }

            return $balance.$request_amt_txt.$total_pay.$total_used.$balance1.$balance2;
        })
        ->addColumn('action', function($dataSet){
            $role = $this->getMyRole();
            $refund = '';
            if($role->ROLE_NO == 1){
                $refund = ' <a href="'.route('admin.payment.refund.seller', ['id' => $dataSet->SELLER_PK_NO, 'type' => 'seller' ]).'" class="btn btn-xs btn-primary mb-05 mr-05" title="Direct refund by admin">R</a>';
            }

            $request = ' <button data-SELLER_no="'.$dataSet->SELLER_PK_NO.'" data-name="'.$dataSet->SHOP_NAME.'" data-balance="'.$dataSet->SELLER_CUM_BALANCE.'" class="btn btn-xs btn-primary mb-05 mr-05 refundRequest" data-toggle="modal" data-target="#refundRequestModal"  title="Refud request"><i class="la la-plus"></i></button>';

            return $refund.$request;

        })
        ->rawColumns(['seller_no','SHOP_NAME','mobile', 'balance','action'])
        ->make(true);
    }

    public function customerRefunded($request)
    {
        $dataSet = DB::table("ACC_CUSTOMER_PAYMENTS as p")
        ->select('p.F_CUSTOMER_NO AS CUSTOMER_PK_NO','p.PAYMENT_NOTE','p.PAYMENT_DATE','p.CUSTOMER_NAME as CUSTOMER_NAME','p.PAYMENT_ACCOUNT_NAME','p.CUSTOMER_NO','p.ATTACHMENT_PATH','p.PAY_AMOUNT','r.REQUEST_NOTE','r.REQ_BANK_NAME','r.REQ_BANK_ACC_NAME','r.REQ_BANK_ACC_NO','r.REFUNDED_BANK_NAME','r.REFUNDED_BANK_ACC_NAME','r.REFUNDED_BANK_ACC_NO')
        ->leftJoin('ACC_CUST_RES_REFUND_REQUEST as r','r.PK_NO','p.F_ACC_CUST_RES_REFUND_REQUEST_NO')
        ->where('p.PAYMENT_TYPE',2)
        ->orderBy('p.PAYMENT_DATE', 'ASC');

        return Datatables::of($dataSet)
        ->addColumn('date', function($dataSet){
            $date = '';
            $date = date('d M, Y',strtotime($dataSet->PAYMENT_DATE));
            return $date;
        })
        ->addColumn('reason', function($dataSet){
            $reason = '';
            if($dataSet->REQUEST_NOTE == $dataSet->PAYMENT_NOTE){
                $reason .= '<div class="">'.$dataSet->REQUEST_NOTE.'</div>';
            }else{
                $reason .= '<div class=""><span class="sub_lbl">Request</span>: '.$dataSet->REQUEST_NOTE.'</div>';
                $reason .= '<div class=""><span class="sub_lbl">Refund</span>: '.$dataSet->PAYMENT_NOTE.'</div>';
            }
            return $reason;
        })
        ->addColumn('account', function($dataSet){
            $account = '';
            $account = $dataSet->PAYMENT_ACCOUNT_NAME;
            return $account;
        })
        ->addColumn('customer_no', function($dataSet){
            $customer_no = '';
            $customer_no = $dataSet->CUSTOMER_NO;
            return $customer_no;
        })
        ->addColumn('customer_name', function($dataSet){
            $customer_name = '';
            $customer_name = '<a href="'.route("admin.customer.view", [$dataSet->CUSTOMER_PK_NO]). '" class="" title="Customer name">'.$dataSet->CUSTOMER_NAME.'</a>';
            return $customer_name;

        })
        ->addColumn('req_bank_name', function($dataSet){
            $req_bank_name = '';
            $req_bank_name .= '<div class=""><span class="sub_lbl">Bank </span>: '.$dataSet->REQ_BANK_NAME.'</div>';
            $req_bank_name .= '<div class=""><span class="sub_lbl">Acc Name</span>: '.$dataSet->REQ_BANK_ACC_NAME.'</div>';
            $req_bank_name .= '<div class=""><span class="sub_lbl">Acc No</span>: '.$dataSet->REQ_BANK_ACC_NO.'</div>';
            // $req_bank_name .= '<a href="" class="" title="Customer name">'.$dataSet->REQ_BANK_NAME.'</a>';
            return $req_bank_name;
        })
        ->addColumn('refunded_bank_name', function($dataSet){
            $refunded_bank_name = '';
            $refunded_bank_name .= '<div class=""><span class="sub_lbl">Bank </span>: '.$dataSet->REFUNDED_BANK_NAME.'</div>';
            $refunded_bank_name .= '<div class=""><span class="sub_lbl">Acc Name</span>: '.$dataSet->REFUNDED_BANK_ACC_NAME.'</div>';
            $refunded_bank_name .= '<div class=""><span class="sub_lbl">Acc No</span>: '.$dataSet->REFUNDED_BANK_ACC_NO.'</div>';
            return $refunded_bank_name;
        })
        ->addColumn('image', function($dataSet){
            if($dataSet->ATTACHMENT_PATH){
                $path_info = pathinfo($dataSet->ATTACHMENT_PATH);
                $extension = $path_info['extension'];
                if($extension == 'pdf'){
                    $image = '<a href="'.$dataSet->ATTACHMENT_PATH.'" target="_blank">Show PDF</a>';
                }else{
                    $image = '<img src="'.$dataSet->ATTACHMENT_PATH.'" width="50" >';
                }
            }else{
                $image = '';
            }
            return $image;
        })
        ->addColumn('amount', function($dataSet){
            $amount = number_format(abs($dataSet->PAY_AMOUNT),2);
            return $amount;
        })
        ->rawColumns(['date','reason','account','customer_no','customer_name','req_bank_name','refunded_bank_name','image','amount'])
        ->make(true);

    }


    // public function resellerRefunded($request)
    // {
    //     $dataSet = DB::table("ACC_SELLER_PAYMENTS as p")
    //     ->select('p.F_SHOP_NO AS SELLER_PK_NO','p.PAYMENT_NOTE','p.PAYMENT_DATE','p.SHOP_NAME as SHOP_NAME','p.PAYMENT_ACCOUNT_NAME','p.SELLER_NO','p.ATTACHMENT_PATH','p.PAY_AMOUNT','r.REQUEST_NOTE','r.REQ_BANK_NAME','r.REQ_BANK_ACC_NAME','r.REQ_BANK_ACC_NO','r.REFUNDED_BANK_NAME','r.REFUNDED_BANK_ACC_NAME','r.REFUNDED_BANK_ACC_NO')
    //     ->leftJoin('ACC_CUST_RES_REFUND_REQUEST as r','r.PK_NO','p.F_ACC_CUST_RES_REFUND_REQUEST_NO')
    //     ->where('p.PAYMENT_TYPE',2)
    //     ->orderBy('p.PAYMENT_DATE', 'ASC');
    //     return Datatables::of($dataSet)
    //     ->addColumn('date', function($dataSet){
    //         $date = '';
    //         $date = date('d M, Y',strtotime($dataSet->PAYMENT_DATE));
    //         return $date;
    //     })
    //     ->addColumn('reason', function($dataSet){
    //         $reason = '';
    //         if($dataSet->REQUEST_NOTE == $dataSet->PAYMENT_NOTE){
    //             $reason .= '<div class="">'.$dataSet->REQUEST_NOTE.'</div>';
    //         }else{
    //             $reason .= '<div class=""><span class="sub_lbl">Request</span>: '.$dataSet->REQUEST_NOTE.'</div>';
    //             $reason .= '<div class=""><span class="sub_lbl">Refund</span>: '.$dataSet->PAYMENT_NOTE.'</div>';
    //         }
    //         return $reason;
    //     })
    //     ->addColumn('account', function($dataSet){
    //         $account = '';
    //         $account = $dataSet->PAYMENT_ACCOUNT_NAME;
    //         return $account;
    //     })
    //     ->addColumn('seller_no', function($dataSet){
    //         $seller = '';
    //         $seller = $dataSet->SELLER_NO;
    //         return $seller;
    //     })
    //     ->addColumn('SHOP_NAME', function($dataSet){
    //         $SHOP_NAME = '';
    //         $SHOP_NAME = '<a href="'.route("admin.seller.view", [$dataSet->SELLER_PK_NO]). '" class="" title="seller name">'.$dataSet->SHOP_NAME.'</a>';
    //         return $SHOP_NAME;
    //     })
    //     ->addColumn('req_bank_name', function($dataSet){
    //         $req_bank_name = '';
    //         $req_bank_name .= '<div class=""><span class="sub_lbl">Bank </span>: '.$dataSet->REQ_BANK_NAME.'</div>';
    //         $req_bank_name .= '<div class=""><span class="sub_lbl">Acc Name</span>: '.$dataSet->REQ_BANK_ACC_NAME.'</div>';
    //         $req_bank_name .= '<div class=""><span class="sub_lbl">Acc No</span>: '.$dataSet->REQ_BANK_ACC_NO.'</div>';
    //         // $req_bank_name .= '<a href="" class="" title="Customer name">'.$dataSet->REQ_BANK_NAME.'</a>';
    //         return $req_bank_name;
    //     })
    //     ->addColumn('refunded_bank_name', function($dataSet){
    //         $refunded_bank_name = '';
    //         $refunded_bank_name .= '<div class=""><span class="sub_lbl">Bank </span>: '.$dataSet->REFUNDED_BANK_NAME.'</div>';
    //         $refunded_bank_name .= '<div class=""><span class="sub_lbl">Acc Name</span>: '.$dataSet->REFUNDED_BANK_ACC_NAME.'</div>';
    //         $refunded_bank_name .= '<div class=""><span class="sub_lbl">Acc No</span>: '.$dataSet->REFUNDED_BANK_ACC_NO.'</div>';
    //         return $refunded_bank_name;
    //     })
    //     ->addColumn('image', function($dataSet){
    //         if($dataSet->ATTACHMENT_PATH){
    //             $path_info = pathinfo($dataSet->ATTACHMENT_PATH);
    //             $extension = $path_info['extension'];
    //             if($extension == 'pdf'){
    //                 $image = '<a href="'.$dataSet->ATTACHMENT_PATH.'" target="_blank">Show PDF</a>';
    //             }else{
    //                 $image = '<img src="'.$dataSet->ATTACHMENT_PATH.'" width="50" >';
    //             }
    //         }else{
    //             $image = '';
    //         }
    //         return $image;
    //     })
    //     ->addColumn('amount', function($dataSet){
    //         $amount = number_format(abs($dataSet->MR_AMOUNT),2);
    //         return $amount;
    //     })
    //     ->rawColumns(['date','reason','account','seller_no','SHOP_NAME','req_bank_name','refunded_bank_name','image','amount'])
    //     ->make(true);
    // }



    public function customerRefundedRequestList($request)
    {
        $dataSet = DB::table("ACC_CUST_RES_REFUND_REQUEST as p")
        ->select('p.PK_NO as REQUEST_PK_NO','p.F_CUSTOMER_NO','p.REQUEST_DATE','p.REQUEST_BY_NAME','c.CUSTOMER_NO','c.NAME as CUSTOMER_NAME','p.MR_AMOUNT','c.CUM_BALANCE','p.STATUS','p.REQUEST_NOTE','p.REQ_BANK_NAME','p.REQ_BANK_ACC_NAME','p.REQ_BANK_ACC_NO','p.REFUNDED_BANK_NAME','p.REFUNDED_BANK_ACC_NAME','p.REFUNDED_BANK_ACC_NO')
        ->leftJoin('SLS_CUSTOMERS AS c','c.PK_NO','p.F_CUSTOMER_NO')
        ->where('p.STATUS',0)
        ->where('p.IS_CUSTOMER',1)
        ->orderBy('p.REQUEST_DATE', 'ASC');

        return Datatables::of($dataSet)
        ->addColumn('date', function($dataSet){
            $date = '';
            $date = date('d M, Y',strtotime($dataSet->REQUEST_DATE));
            return $date;
        })
        ->addColumn('request_by', function($dataSet){
            $request_by = '';
            $request_by = $dataSet->REQUEST_BY_NAME;
            return $request_by;
        })
        ->addColumn('request_note', function($dataSet){
            return $dataSet->REQUEST_NOTE;
        })
        ->addColumn('customer_no', function($dataSet){
            $customer_no = '';
            $customer_no = $dataSet->CUSTOMER_NO;
            return $customer_no;
        })
        ->addColumn('customer_name', function($dataSet){
            $customer_name = '';
            $customer_name = '<a href="'.route("admin.customer.view", [$dataSet->F_CUSTOMER_NO]). '" class="" title="Customer name">'.$dataSet->CUSTOMER_NAME.'</a>';
            return $customer_name;

        })
        ->addColumn('req_bank_name', function($dataSet){
            $req_bank_name = '';
            $req_bank_name .= '<div class=""><span class="sub_lbl">Bank </span>: '.$dataSet->REQ_BANK_NAME.'</div>';
            $req_bank_name .= '<div class=""><span class="sub_lbl">Acc Name</span>: '.$dataSet->REQ_BANK_ACC_NAME.'</div>';
            $req_bank_name .= '<div class=""><span class="sub_lbl">Acc No</span>: '.$dataSet->REQ_BANK_ACC_NO.'</div>';
            // $req_bank_name .= '<a href="" class="" title="Customer name">'.$dataSet->REQ_BANK_NAME.'</a>';
            return $req_bank_name;

        })

        ->addColumn('balance', function($dataSet){
            $balance = '';
            $request_amt = '';
            $balance = '<p style="margin-bottom: 1px;">Credit : <small>(RM)</small> <strong>'.number_format($dataSet->CUM_BALANCE,2).'</strong> </p>';
            $request_amt = ' <p style="margin-bottom: 1px;"> Request : <small>(RM)</small> <strong>'.number_format($dataSet->MR_AMOUNT,2).'</strong></p>';
            return $balance.$request_amt;
        })
        ->addColumn('status', function($dataSet){
            $role = $this->getMyRole();
            $status = '';

            if($dataSet->STATUS  == 0 ){
                if($role->ROLE_NO == 1){
                    $status = '<button class="btn btn-sm btn-warning">Pending</button>';
                }
            }else{
                $status = '';
            }
            return $status;
        })
        ->addColumn('action', function($dataSet){
            $role = $this->getMyRole();
            $accept = '';
            if($role->ROLE_NO == 1){
                $accept = '<a href="'.route('admin.payment.refund', ['id' => $dataSet->F_CUSTOMER_NO, 'type' => 'customer','request_no' => $dataSet->REQUEST_PK_NO ]).'" class="btn btn-xs btn-primary mb-05 mr-05" title="Refund request accept"><i class="la la-check"></i></a>';
            }

            $deny = ' <a href="'.route('admin.customer.refundrequest_deny', ['id' => $dataSet->REQUEST_PK_NO]).'" class="btn btn-xs btn-primary mb-05 mr-05" title="Request Deny" onclick="return confirm('. "'" .'Are you sure you want to deny the request?'. "'" .')"><i class="la la-undo"></i></a>';

            return $accept.$deny;

        })
        ->rawColumns(['date','request_by','customer_no','customer_name','req_bank_name','balance', 'status','action'])
        ->make(true);
    }


    // public function resellerRefundedRequestList($request)
    // {
    //     $dataSet = DB::table("ACC_CUST_RES_REFUND_REQUEST as p")
    //     ->select('p.PK_NO as REQUEST_PK_NO','p.F_SHOP_NO','p.REQUEST_DATE','p.REQUEST_BY_NAME','c.SELLER_NO','c.NAME as SHOP_NAME','p.MR_AMOUNT','c.CUM_BALANCE','p.STATUS','p.REQUEST_NOTE','p.REQ_BANK_NAME','p.REQ_BANK_ACC_NAME','p.REQ_BANK_ACC_NO','p.REFUNDED_BANK_NAME','p.REFUNDED_BANK_ACC_NAME','p.REFUNDED_BANK_ACC_NO')
    //     ->leftJoin('SLS_SELLERS AS c','c.PK_NO','p.F_SHOP_NO')
    //     ->where('p.STATUS',0)
    //     ->where('p.IS_CUSTOMER',0)
    //     ->orderBy('p.REQUEST_DATE', 'ASC')
    //     ->get();
    //     return Datatables::of($dataSet)
    //     ->addColumn('date', function($dataSet){
    //         $date = '';
    //         $date = date('d M, Y',strtotime($dataSet->REQUEST_DATE));
    //         return $date;
    //     })
    //     ->addColumn('request_by', function($dataSet){
    //         $request_by = '';
    //         $request_by = $dataSet->REQUEST_BY_NAME;
    //         return $request_by;
    //     })
    //     ->addColumn('request_note', function($dataSet){
    //         return $dataSet->REQUEST_NOTE;
    //     })
    //     ->addColumn('seller_no', function($dataSet){
    //         $seller_no = '';
    //         $seller_no = $dataSet->SELLER_NO;
    //         return $seller_no;
    //     })
    //     ->addColumn('SHOP_NAME', function($dataSet){
    //         $SHOP_NAME = '';
    //         $SHOP_NAME = '<a href="'.route("admin.seller.view",12). '" class="" title="seller name">'.$dataSet->SHOP_NAME.'</a>';
    //         return $SHOP_NAME;
    //     })
    //     ->addColumn('req_bank_name', function($dataSet){
    //         $req_bank_name = '';
    //         $req_bank_name .= '<div class=""><span class="sub_lbl">Bank </span>: '.$dataSet->REQ_BANK_NAME.'</div>';
    //         $req_bank_name .= '<div class=""><span class="sub_lbl">Acc Name</span>: '.$dataSet->REQ_BANK_ACC_NAME.'</div>';
    //         $req_bank_name .= '<div class=""><span class="sub_lbl">Acc No</span>: '.$dataSet->REQ_BANK_ACC_NO.'</div>';
    //         return $req_bank_name;
    //     })
    //     ->addColumn('balance', function($dataSet){
    //         $balance = '';
    //         $request_amt = '';
    //         $balance = '<p style="margin-bottom: 1px;">Credit : <small>(RM)</small> <strong>'.number_format($dataSet->CUM_BALANCE,2).'</strong> </p>';
    //         $request_amt = ' <p style="margin-bottom: 1px;"> Request : <small>(RM)</small> <strong>'.number_format($dataSet->MR_AMOUNT,2).'</strong></p>';
    //         return $balance.$request_amt;
    //     })
    //     ->addColumn('status', function($dataSet){
    //         $role = $this->getMyRole();
    //         $status = '';
    //         if($dataSet->STATUS  == 0 ){
    //             if($role->ROLE_NO == 1){
    //                 $status = '<button class="btn btn-sm btn-warning">Pending</button>';
    //             }
    //         }else{
    //             $status = '';
    //         }
    //         return $status;
    //     })
    //     ->addColumn('action', function($dataSet){
    //         $role = $this->getMyRole();
    //         $accept = '';
    //         if($role->ROLE_NO == 1){
    //             $accept = '<a href="'.route('admin.payment.refund.seller', ['id' => $dataSet->F_SHOP_NO, 'type' => 'seller','request_no' => $dataSet->REQUEST_PK_NO ]).'" class="btn btn-xs btn-primary mb-05 mr-05" title="Refund request accept"><i class="la la-check"></i></a>';
    //         }
    //         $deny = ' <a href="'.route('admin.seller.refundrequest_deny', ['id' => $dataSet->REQUEST_PK_NO]).'" class="btn btn-xs btn-primary mb-05 mr-05" title="Request Deny" onclick="return confirm('. "'" .'Are you sure you want to deny the request?'. "'" .')"><i class="la la-undo"></i></a>';
    //         return $accept.$deny;
    //     })
    //     ->rawColumns(['date','request_by','seller_no','SHOP_NAME','req_bank_name','balance', 'status','action'])
    //     ->make(true);
    // }


    public function getTopSell($request){
        $dataSet = DB::table("PRD_BEST_SELL_MASTER")
        ->select('PK_NO','FROM_DATE','TO_DATE','PDF_PATH','MAX_VARIANT','HAS_CHILD','F_SS_CREATED_BY', 'SHOP_NAME')
        ->orderBy('PK_NO', 'DESC');

        return Datatables::of($dataSet)
        ->addColumn('to_date', function($dataSet){
            $to_date = date('d M, Y',strtotime($dataSet->TO_DATE));
            return $to_date;
        })
        ->addColumn('from_date', function($dataSet){
            $from_date = date('d M, Y',strtotime($dataSet->FROM_DATE));
            return $from_date;
        })
        ->addColumn('pdf_path', function($dataSet){
            $roles = userRolePermissionArray();
            $pdf_path = '';
            if ($dataSet->PDF_PATH && hasAccessAbility('view_top_sell', $roles)) {
                $pdf_path = '<a href="'.asset(($dataSet->PDF_PATH)).'" target="_blank">View PDF</a>';
            }
            return $pdf_path;
        })

        ->addColumn('action', function($dataSet){
            $roles = userRolePermissionArray();
            $view = '';
            $pdf = '';
            if (hasAccessAbility('view_top_sell', $roles)) {
                $view = ' <a href="'.route("admin.top_sell.view", [$dataSet->PK_NO]). '" class="btn btn-xs btn-success mb-05 mr-05" title="VIEW"><i class="la la-eye"></i></a>';
            }
            if (hasAccessAbility('view_top_sell', $roles)) {
                $pdf = '';
                // if ($dataSet->PDF_PATH) {
                //     $pdf = ' <a href="javascript:void(0)" class="btn btn-xs btn-danger mb-05 mr-05" title="Already Generated"><i class="la la-download"></i></a>';
                // }else{
                //     $pdf = ' <a href="'.route("admin.top_sell.pdf", [$dataSet->PK_NO]). '" class="btn btn-xs btn-success mb-05 mr-05" title="Generate PDF"><i class="la la-download"></i></a>';
                // }
            }
            return $view.$pdf;

        })
        ->rawColumns(['to_date','from_date','pdf_path','action'])
        ->make(true);
    }

    public function getTopSellView($request,$id){

        $dataSet = DB::table("PRD_BEST_SELL_MASTER_DETAIL as p")
        ->select('p.PK_NO','p.F_BEST_SELL_MASTER_NO','p.F_PRD_MASTER_SETUP_NO','p.QTY','p.SELL_AMOUNT','p.ORDER_ID', 'p.IS_MANUAL','PRD_MASTER_SETUP.DEFAULT_NAME', 'p.TOTAL_BEST_SELL_VARIANT', 'p.SHOP_NAME')
        ->leftJoin('PRD_MASTER_SETUP','PRD_MASTER_SETUP.PK_NO','p.F_PRD_MASTER_SETUP_NO')
        ->where('p.F_BEST_SELL_MASTER_NO',$id)
        ->orderBy('p.ORDER_ID', 'DESC');

        return Datatables::of($dataSet)
        ->addColumn('master_name', function($dataSet){
            $master_name = '<a href="'.route('admin.top_sell_variant.list',$dataSet->PK_NO).'">'.$dataSet->DEFAULT_NAME.'</a>';
            return $master_name;
        })
        ->addColumn('qty', function($dataSet){
            $qty = '<a href="'.route('admin.top_sell_variant.list',$dataSet->PK_NO).'">'.$dataSet->QTY.'</a>';
            return $qty;
        })
        ->addColumn('variant_count', function($dataSet){
            if($dataSet->TOTAL_BEST_SELL_VARIANT > 0 ){
                $variant_count = $dataSet->TOTAL_BEST_SELL_VARIANT;
            }else{
                $variant_count = '<span class="text-danger">No variant</span>';
            }

            return $variant_count;
        })
        ->addColumn('is_manual', function($dataSet){
            $is_manual = $dataSet->IS_MANUAL == 1 ? 'Manual' : 'Auto';
            return $is_manual;
        })
        ->addColumn('total_sell', function($dataSet){
            $total_sell = number_format($dataSet->SELL_AMOUNT,2);
            return $total_sell;
        })
        ->addColumn('avg_price', function($dataSet){
            if($dataSet->QTY > 0 ){
                $avg_price = number_format($dataSet->SELL_AMOUNT/$dataSet->QTY,2);
            }else{
                $avg_price = number_format($dataSet->SELL_AMOUNT,2);
            }
            return $avg_price;
        })
        ->addColumn('order_id', function($dataSet){
            $order_id = '';
            $order_id .= ' <form method="post" action="'.route('admin.top_sell.orderid_update').'" class="edit_order_id form form-inline">'.csrf_field().'<input type="hidden" name="pk_no" value="'.$dataSet->PK_NO.'"><div class="form-group"><input type="number" required="" name="order_id" class="form-control order_id" title="Credit price" value="'.$dataSet->ORDER_ID.'"></div><div class="form-group"><button type="button" class="btn btn-sm btn-danger order_id_close" data-pk_no="2163"><i class="fa fa-times"></i></button><button type="submit" class="btn btn-sm btn-success">Update</button></div></form>';
            $order_id .= '<a href="javascript:void(0)" title="Click for edit" class="order_id_show">'.$dataSet->ORDER_ID.'</a>';
            return $order_id;
        })

        ->addColumn('action', function($dataSet){
            $roles = userRolePermissionArray();
            $view = '';
            if (hasAccessAbility('edit_top_sell', $roles)) {
                $view = '<input type="checkbox" name="record_check" value="'.$dataSet->PK_NO.'" class="record_check" >';
            }
            return $view;
        })
        ->rawColumns(['master_name','qty','variant_count','is_manual','total_sell','avg_price','order_id','action'])
        ->make(true);
    }


    public function getTopSellVariantView($request,$id){
        $top_sell_master = DB::table('PRD_BEST_SELL_MASTER_DETAIL')->where('PK_NO',$id)->first();
        $dataSet = DB::table("PRD_BEST_SELL_VARIANT_DETAIL")
        ->select('PK_NO','F_BEST_SELL_MASTER_NO','F_PRD_VARIANT_NO','QTY','SELL_AMOUNT','ORDER_ID', 'IS_MANUAL','VARIANT_NAME','SHOP_NAME','F_SHOP_NO')
        ->where('F_BEST_SELL_MASTER_NO',$top_sell_master->F_BEST_SELL_MASTER_NO)
        ->where('F_PRD_MASTER_SETUP_NO',$top_sell_master->F_PRD_MASTER_SETUP_NO)
        ->orderBy('ORDER_ID', 'DESC');
        return Datatables::of($dataSet)
        ->addColumn('qty', function($dataSet){
            $qty = '<a href="#">'.$dataSet->QTY.'</a>';
            return $qty;
        })
        ->addColumn('is_manual', function($dataSet){
            $is_manual = $dataSet->IS_MANUAL == 1 ? 'Manual' : 'Auto';
            return $is_manual;
        })
        ->addColumn('total_sell', function($dataSet){
            $total_sell = number_format($dataSet->SELL_AMOUNT,2);
            return $total_sell;
        })
        ->addColumn('avg_price', function($dataSet){
            if($dataSet->QTY > 0 ){
                $avg_price = number_format($dataSet->SELL_AMOUNT/$dataSet->QTY,2);
            }else{
                $avg_price = number_format($dataSet->SELL_AMOUNT,2);
            }
            return $avg_price;
        })
        ->addColumn('order_id', function($dataSet){
            $order_id = '';
            $order_id .= ' <form method="post" action="'.route('admin.top_sell_variant.orderid_update').'" class="edit_order_id form form-inline">'.csrf_field().'<input type="hidden" name="pk_no" value="'.$dataSet->PK_NO.'"><div class="form-group"><input type="number" required="" name="order_id" class="form-control order_id" title="Credit price" value="'.$dataSet->ORDER_ID.'"></div><div class="form-group"><button type="button" class="btn btn-sm btn-danger order_id_close" data-pk_no="2163"><i class="fa fa-times"></i></button><button type="submit" class="btn btn-sm btn-success">Update</button></div></form>';
            $order_id .= '<a href="javascript:void(0)" title="Click for edit" class="order_id_show">'.$dataSet->ORDER_ID.'</a>';
            return $order_id;
        })
        ->addColumn('action', function($dataSet){
            $roles = userRolePermissionArray();
            $view = '';
            if (hasAccessAbility('view_top_sell', $roles)) {
                $view = '<input type="checkbox" name="record_check" value="'.$dataSet->PK_NO.'" class="record_check" >';
            }
            return $view;
        })
        ->rawColumns(['qty','is_manual','total_sell','avg_price','order_id','action'])
        ->make(true);
    }

    public function getAllProduct($request)
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
        $keyword =  $request->keyword;
        $brand =  $request->brand;
        $is_active =  $request->is_active;
        if(Auth::user()->USER_TYPE == 10){
            $dataSet = Product::select('PRD_MASTER_SETUP.PK_NO','PRD_SHOP_MASTER_MAP.F_SHOP_NO','PRIMARY_IMG_RELATIVE_PATH','PRD_MASTER_SETUP.DEFAULT_NAME','PRD_MASTER_SETUP.DEFAULT_NAME_BN','PRD_MASTER_SETUP.F_PRD_CATEGORY_ID','PRD_MASTER_SETUP.F_SS_CREATED_BY','PRD_MASTER_SETUP.F_SS_MODIFIED_BY','PRD_MASTER_SETUP.SS_MODIFIED_ON','PRD_MASTER_SETUP.SS_CREATED_ON');
            if($request->product == 'all'){
                $dataSet->leftJoin('PRD_SHOP_MASTER_MAP', function($join)
                {
                    $join->on('PRD_MASTER_SETUP.PK_NO', '=', 'PRD_SHOP_MASTER_MAP.F_PRD_MASTER_SETUP_NO');
                    $join->where('PRD_SHOP_MASTER_MAP.F_SHOP_NO', '=', Auth::user()->SHOP_ID);
                });
            }else{
                $dataSet->join('PRD_SHOP_MASTER_MAP', function($join)
                {
                    $join->on('PRD_MASTER_SETUP.PK_NO', '=', 'PRD_SHOP_MASTER_MAP.F_PRD_MASTER_SETUP_NO');
                    $join->where('PRD_SHOP_MASTER_MAP.F_SHOP_NO', '=', Auth::user()->SHOP_ID);
                });
            }
        }
        else{
            $dataSet = Product::select('PRD_MASTER_SETUP.PK_NO','PRD_MASTER_SETUP.PRIMARY_IMG_RELATIVE_PATH','PRD_MASTER_SETUP.DEFAULT_NAME','PRD_MASTER_SETUP.DEFAULT_NAME_BN','PRD_MASTER_SETUP.F_SS_CREATED_BY','PRD_MASTER_SETUP.F_SS_MODIFIED_BY','PRD_MASTER_SETUP.SS_MODIFIED_ON','PRD_MASTER_SETUP.SS_CREATED_ON','PRD_MASTER_CATEGORY_MAP.F_PRD_CATEGORY_ID');
        }
        $dataSet->leftJoin('PRD_MASTER_CATEGORY_MAP','PRD_MASTER_CATEGORY_MAP.F_PRD_MASTER_SETUP_NO','PRD_MASTER_SETUP.PK_NO')->groupBy('PRD_MASTER_SETUP.PK_NO')->orderBy('F_PRD_CATEGORY_ID', 'ASC');
        // ->where('IS_SELECTED',1);
        if(!empty($is_active)){
            $dataSet->where('PRD_MASTER_SETUP.IS_ACTIVE',$is_active);
        }
        else{
            $dataSet->whereIn('PRD_MASTER_SETUP.IS_ACTIVE',[0,1]);
            // ->orderBy('F_PRD_CATEGORY_ID', 'ASC');
            }
        if($category_id){
            $dataSet =  $dataSet->where('PRD_MASTER_CATEGORY_MAP.F_PRD_CATEGORY_ID','=',$category_id);
        }
        if(!empty($keyword)){
            $dataSet->where(function ($query) use($keyword) {
                $query->where('PRD_MASTER_SETUP.DEFAULT_NAME', 'like', '%' . $keyword . '%');
                $query->orWhere('PRD_MASTER_SETUP.DEFAULT_NAME_BN', 'like', '%' . $keyword . '%');
            });
        }
        if(!empty($brand)){
            $dataSet = $dataSet->leftJoin('PRD_MASTER_ATTRIBUTE_RELATIONS','PRD_MASTER_ATTRIBUTE_RELATIONS.F_PRD_MASTER_SETUP_NO','=','PRD_MASTER_SETUP.PK_NO')
            // ->leftJoin('PRD_ATTRIBUTE_CHILD as ATTR_CHILD','ATTR_CHILD.PK_NO','=','PRD_MASTER_ATTRIBUTE_RELATIONS.F_ATTRIBUTE_CHILD')
            ->where('PRD_MASTER_ATTRIBUTE_RELATIONS.F_ATTRIBUTE_MASTER',38)
            ->where('PRD_MASTER_ATTRIBUTE_RELATIONS.F_ATTRIBUTE_CHILD',$brand);
        }
        $shop_no = Auth::user()->SHOP_ID;
        return Datatables::of($dataSet,$request,$shop_no)
        ->addColumn('category', function($dataSet){
            $category = '';
            // $category .= '<span>'.$dataSet->category_map->NAME ?? NULL.'</span>';
            // $category .= '<span>'.$dataSet->category_map->NAME.'<br>->'.$dataSet->subcategory ?? 'asdf'.'</span>';
            return getCategoryChain($dataSet->PK_NO);
        })
        ->addColumn('product_name', function($dataSet){
            $product_name = '';
            $product_name .= '<p class="mb-0">'.$dataSet->DEFAULT_NAME ?? null.'</p>';
            $product_name .= '<p class="mb-0">'.$dataSet->DEFAULT_NAME_BN ?? null.'</p>';
            return $product_name;

        })
        ->addColumn('image', function($dataSet){
            if(isset($dataSet->firstVariantProduct->THUMB_PATH)){
                $image = fileExit($dataSet->firstVariantProduct->THUMB_PATH);
            }else{
                $image = asset('assets/images/no-image.jpeg');
            }
            $image = '<img src="'.$image.'" class="img-fluid" style="height: 50px;">';
            return $image;
        })
        ->addColumn('entry_by', function($dataSet){
            $entry_by = '';
            $entry_by .= '<p class="mb-0">Entry By: '.$dataSet->entryBy->NAME ?? null.'</p>';
            $entry_by .= '<p class="mb-0">Entry At: '.$dataSet->SS_CREATED_ON ?? null.'</p>';
            if($dataSet->F_SS_MODIFIED_BY){
                $entry_by .= ' <p class="mb-0">Last Modifyed By: '.$dataSet->modifyBy->NAME ?? null.'</p>';
                $entry_by .= ' <p class="mb-0">Last Modifyed At: '.$dataSet->SS_MODIFIED_ON ?? null.'</p>';
            }
            return $entry_by;
        })

        ->addColumn('total_variant', function($dataSet){
            $total_variant = '<a href="'.route('admin.product.view', [$dataSet->PK_NO]).'" class="" title="Click for view">'.$dataSet->totalVariantsProduct().'</a>';
            return $total_variant;
        })

        ->addColumn('action', function($dataSet) use($request) {
            $edit = $view = $delete = $check = $view_master_variant = '';
            $roles = userRolePermissionArray();
            if($request->status == 'pending'){
                if(hasAccessAbility('edit_product', $roles)){
                    $edit = '<a href="'.route('admin.product.edit', ['id' => $dataSet->PK_NO, 'status' => 'pending']).'" class="btn btn-xs  btn-info" title="EDIT" target="_blank"><i class="la la-edit"></i></a>';
                }
            }else{
                if(Auth::user()->USER_TYPE == 10){
                    if(isset($dataSet->F_SHOP_NO)){
                        $check = ' <select name="product_check" id="product_check" class="custom-select" style="width:66px" data-product_id="'.$dataSet->PK_NO.'"> ><option value="1" selected >Yes</option><option value="0">No</option';
                    }else{
                        $check = ' <select name="product_check" id="product_check" class="custom-select" style="width:66px" data-product_id="'.$dataSet->PK_NO.'"><option value="0">No</option><option value="1">Yes</option>';
                    }
                    if(hasAccessAbility('view_product', $roles)){
                        // $view = ' <a href="'.route('admin.product.view', [$dataSet->PK_NO]).'" class="btn btn-xs  btn-success text-white" title="VIEW"><i class="la la-eye"></i></a>';
                        $view_master_variant = ' <a href="'.route('seller.product.variant.store.index', [$dataSet->PK_NO]).'" class="btn btn-xs btn-info text-white" title="VIEW VARIANTS"><i class="la la-eye"></i></a>';
                    }
                }else{
                    if(hasAccessAbility('edit_product', $roles)){
                        $edit = '<a href="'.route('admin.product.edit', [$dataSet->PK_NO]).'" class="btn btn-xs btn-info" title="EDIT"><i class="la la-edit"></i></a>';
                    }
                    if(hasAccessAbility('delete_product', $roles)){
                        $delete = ' <a href="'.route('admin.product.delete', [$dataSet->PK_NO]).'" class="btn btn-xs btn-danger text-white" onclick="return confirm(\'Are you sure you want to delete the product with it\'s variant product ?\')" title="DELETE"><i class="la la-trash"></i></a>';
                    }
                }
                if(hasAccessAbility('view_product', $roles)){
                    // $view = ' <a href="'.route('admin.product.view', [$dataSet->PK_NO]).'" class="btn btn-xs  btn-success text-white" title="VIEW"><i class="la la-eye"></i></a>';
                }
            }
            return $edit.$view.$view_master_variant.$delete.$check;
        })
        ->rawColumns(['category','product_name','image','entry_by','total_variant','action'])
        ->make(true);
    }

    public function getProductVariantStore($request)
    {
        if(Auth::user()->USER_TYPE == 10){
            $dataSet = ProductVariant::select('PRD_VARIANT_SETUP.PK_NO','F_PRD_MASTER_SETUP_NO','VARIANT_NAME','PRD_SHOP_VARIANT_MAP.F_SHOP_NO','THUMB_PATH','BRAND_NAME','MODEL_NAME','F_PRD_CATEGORY_ID','F_PRD_SUB_CATEGORY_ID','PRD_VARIANT_SETUP.F_SS_CREATED_BY','PRD_VARIANT_SETUP.F_SS_MODIFIED_BY');
            $dataSet->leftjoin('PRD_SHOP_VARIANT_MAP', function($join)
            {
                $join->on('PRD_VARIANT_SETUP.PK_NO', '=', 'PRD_SHOP_VARIANT_MAP.F_PRD_VARIANT_NO');
                $join->where('PRD_SHOP_VARIANT_MAP.F_SHOP_NO', '=', Auth::user()->SHOP_ID);
            });

        }else{
            $dataSet = ProductVariant::select('PRD_VARIANT_SETUP.PK_NO','F_PRD_MASTER_SETUP_NO','VARIANT_NAME','THUMB_PATH','BRAND_NAME','MODEL_NAME','F_PRD_CATEGORY_ID','F_PRD_SUB_CATEGORY_ID','PRD_VARIANT_SETUP.F_SS_CREATED_BY','PRD_VARIANT_SETUP.F_SS_MODIFIED_BY');
        }
        $dataSet->join('PRD_MASTER_SETUP','PRD_MASTER_SETUP.PK_NO','PRD_VARIANT_SETUP.F_PRD_MASTER_SETUP_NO');
        $dataSet->where('F_PRD_MASTER_SETUP_NO',$request->product_master);
        if($request->status == 'pending' ){
            $dataSet->where('PRD_VARIANT_SETUP.IS_ACTIVE',2)->orderBy('VARIANT_NAME', 'ASC');
        }else{
            $dataSet->whereIn('PRD_VARIANT_SETUP.IS_ACTIVE',[0,1])
            ->orderBy('F_PRD_CATEGORY_ID', 'ASC')
            ->orderBy('VARIANT_NAME', 'ASC');
        }
        $dataSet->get();

        return Datatables::of($dataSet,$request)
        ->addColumn('category', function($dataSet){
            $category = '';
            $category .= '<span>'.$dataSet->master->category->NAME.'</span>';
            return $category;
        })
        ->addColumn('image', function($dataSet){
            $image = '';
           $image = '<img src="'.asset($dataSet->THUMB_PATH).'" class="img-fluid" style="height: 50px;">';
            return $image;
        })
        ->addColumn('entry_by', function($dataSet){
            $entry_by = '';
            $entry_by .= '<p>Entry By: '.$dataSet->entryBy->NAME ?? null.'</p>';
            if($dataSet->F_SS_MODIFIED_BY){
                $entry_by .= ' <p>Last Modifyed By: '.$dataSet->modifyBy->NAME ?? null.'</p>';
            }
            return $entry_by;
        })
        ->addColumn('action', function($dataSet) use($request) {
            $edit = $view = $delete = $seller_prod = '';
            $roles = userRolePermissionArray();
            if($request->status == 'pending'){
                if(hasAccessAbility('edit_product', $roles)){
                    $edit = '<a href="'.route('admin.product.edit', ['id' => $dataSet->F_PRD_MASTER_SETUP_NO, 'status' => 'pending']).'" class="btn btn-xs  btn-info" title="EDIT" target="_blank"><i class="la la-edit"></i></a>';
                }
            }else{
                if(Auth::user()->USER_TYPE == 10){
                    // if(hasAccessAbility('view_product', $roles)){
                        $view = ' <a href="'.route('seller.product.view', [$dataSet->F_PRD_MASTER_SETUP_NO]).'" class="btn btn-xs  btn-success text-white" title="VIEW"><i class="la la-eye"></i></a>';

                        // $seller_prod = ' <a href="'.route('admin.product.view', [$dataSet->PK_NO]).'" class="btn btn-xs  btn-success text-white" title="VIEW"><i class="la la-eye"></i></a>';
                    // }
                    if(isset($dataSet->F_SHOP_NO)){
                        $check = ' <select name="product_check" id="product_check" class="custom-select" style="width:66px" data-variant_id="'.$dataSet->PK_NO.'">><option value="1">Yes</option><option value="0">No</option';
                    }else{
                        $check = ' <select name="product_check" id="product_check" class="custom-select" style="width:66px" data-variant_id="'.$dataSet->PK_NO.'"><option value="0">No</option><option value="1">Yes</option>';
                    }
                }else{
                    $check = '';
                    // if(hasAccessAbility('view_product', $roles)){
                    //     $view = ' <a href="'.route('admin.product.view', [$dataSet->PK_NO]).'" class="btn btn-xs  btn-success text-white" title="VIEW"><i class="la la-eye"></i></a>';
                    // }
                    // if(hasAccessAbility('edit_product', $roles)){
                    //     $edit = '<a href="'.route('admin.product.edit', [$dataSet->PK_NO]).'" class="btn btn-xs  btn-info" title="EDIT"><i class="la la-edit"></i></a>';
                    // }
                    // if(hasAccessAbility('delete_product', $roles)){
                    //     $delete = ' <a href="'.route('admin.product.delete', [$dataSet->PK_NO]).'" class="btn btn-xs btn-danger text-white" onclick="return confirm(\'Are you sure you want to delete the product with it\'s variant product ?\')" title="DELETE"><i class="la la-trash"></i></a>';
                    // }
                }
            }
            return $edit.$view.$delete.$seller_prod.$check;
        })
        ->rawColumns(['category','image','entry_by','action'])
        ->make(true);
    }

    public function getNotificationList($request)
    {
        if($request->status == 'success'){
            $dataSet = $this->notifySms->orderBy('F_BOOKING_NO', 'DESC')->where('IS_SEND',1)->get();
        }else{
            $dataSet = $this->notifySms
            ->where('IS_SEND',0)
            ->orderBy('PK_NO', 'DESC')
            ->get();

        }

        return Datatables::of($dataSet,$request)
        ->addColumn('type', function($dataSet){
            $type = '';
            $type .= '<span>'.$dataSet->TYPE.'</span>';
            return $type;
        })
        ->addColumn('name', function($dataSet){
            $name = '';
            if (isset($dataSet->customer->NAME)) {
                $name .= '<a href="'.route('admin.customer.view',$dataSet->customer->PK_NO).'">'.$dataSet->customer->NAME.'</a>';
            }
            if (isset($dataSet->seller->NAME)) {
                $name .= '<a href="'.route('admin.seller.edit',$dataSet->seller->PK_NO).'">'.$dataSet->seller->NAME.'</a>';
            }
            return $name;
        })
        ->addColumn('ORDER_ID', function($dataSet){
            $order_id = '';
            if ($dataSet->booking) {
                $order_id .= '<a href="'.route('admin.booking.view',$dataSet->booking->PK_NO ?? 0).'">'.'#ORD-'.$dataSet->booking->BOOKING_NO ?? 0 .'</a>';
            }
            return $order_id;
        })
        ->addColumn('SMS', function($dataSet){
            $sms = '';
            $sms .= '<span>'.$dataSet->BODY ?? ''.'</span>';
            return $sms;
        })
        ->addColumn('MOBILE', function($dataSet){
            $mobile = '';
            $mobile .= '<span>'.$dataSet->MOBILE_NO.'</span>';
            return $mobile;
        })
        ->addColumn('IS_SEND', function($dataSet){
            $IS_SEND = $dataSet->IS_SEND == 1 ? 'Yes' : 'NO';
            // $IS_SEND .= '<span>'.$dataSet->IS_SEND == 1 ? 'Yes' : 'NO' .'</span>';
            return $IS_SEND;
        })
        ->addColumn('time', function($dataSet){
            $time = '';
            if ($dataSet->SS_CREATED_ON) {
                $time .= '<div title="Generated">'.date('d-m-y h:i A',strtotime($dataSet->SS_CREATED_ON)).'</div>';
            }
            if ($dataSet->SEND_AT) {
                $time .= '<div style="border-top: 1px solid #eee;" title="Sent At">'.date('d-m-y h:i A',strtotime($dataSet->SEND_AT)).'</div>';
            }
            return $time;
        })
        ->addColumn('active', function($dataSet){
            $active = '';
            $roles = userRolePermissionArray();
            if ($dataSet->IS_SEND == 0) {
                if (hasAccessAbility('send_notify_sms',$roles)) {
                    $active .= '<a title="SEND SMS" class="btn btn-xs btn-primary mr-05" href="'.route('admin.notify_sms.send',$dataSet->PK_NO).'">'.'<i class="la la-send">'.'</i>'.'</a>';
                }
            }else{
                $active .= 'Sent';
            }

            return $active;
        })
        ->rawColumns(['type','name','ORDER_ID','SMS','MOBILE','IS_SEND','time','active'])
        ->make(true);

    }

    public function getEmailList($request)
    {
        if($request->status == 'success'){
            $dataSet = DB::table('SLS_NOTIFICATION_EMAIL')->leftjoin('SLS_BOOKING','SLS_BOOKING.PK_NO','SLS_NOTIFICATION_EMAIL.F_BOOKING_NO')->select('SLS_NOTIFICATION_EMAIL.*','SLS_BOOKING.CUSTOMER_NAME','SLS_BOOKING.F_CUSTOMER_NO','SLS_BOOKING.F_SHOP_NO','SLS_BOOKING.SHOP_NAME','SLS_BOOKING.BOOKING_NO')->where('IS_SEND',1)->where('TYPE',$request->filter)->orderBy('SLS_NOTIFICATION_EMAIL.PK_NO', 'DESC')->get();
        }else{
            $dataSet = DB::table('SLS_NOTIFICATION_EMAIL')->leftjoin('SLS_BOOKING','SLS_BOOKING.PK_NO','SLS_NOTIFICATION_EMAIL.F_BOOKING_NO')->select('SLS_NOTIFICATION_EMAIL.*','SLS_BOOKING.CUSTOMER_NAME','SLS_BOOKING.F_CUSTOMER_NO','SLS_BOOKING.F_SHOP_NO','SLS_BOOKING.SHOP_NAME','SLS_BOOKING.BOOKING_NO')->where('IS_SEND',0)->where('TYPE',$request->filter)->orderBy('SLS_NOTIFICATION_EMAIL.PK_NO', 'DESC')->get();
        }
        return Datatables::of($dataSet,$request)
        ->addColumn ('type', function($dataSet){
            $type = '';
            $type .= '<span>'.$dataSet->TYPE.'</span>';
            return $type;
        })
        ->addColumn('name', function($dataSet){
            $name = '';
            if (isset($dataSet->CUSTOMER_NAME)) {
                $name .= '<a href="'.route('admin.customer.view',$dataSet->F_CUSTOMER_NO).'">'.$dataSet->CUSTOMER_NAME.'</a>';
            }
            if (isset($dataSet->SHOP_NAME)) {
                $name .= '<a href="'.route('admin.seller.edit',$dataSet->F_SHOP_NO).'">'.$dataSet->SHOP_NAME.'</a>';
            }
            return $name;
        })
        ->addColumn ('email', function($dataSet){
            $email = '';
            $email .= '<span>'.$dataSet->EMAIL.'</span>';
            return $email;
        })
        ->addColumn('ORDER_ID', function($dataSet){
            if ($dataSet->BOOKING_NO) {
                $order_id = '<a href="'.route('admin.booking.view',$dataSet->F_BOOKING_NO ?? 0).'">'.'#ORD-'.$dataSet->BOOKING_NO ?? 0 .'</a>';
            }else{
                $order_id = '<span>--------</span>';
            }
            return $order_id;
        })
        ->addColumn ('MOBILE', function($dataSet){
            $mobile = '';
            $mobile .= '<span>'.$dataSet->MOBILE_NO.'</span>';
            return $mobile;
        })
        ->addColumn('IS_SEND', function($dataSet){
            $IS_SEND = $dataSet->IS_SEND == 1 ? 'Yes' : 'NO';
            // $IS_SEND .= '<span>'.$IS_SEND.'</span>';
            return $IS_SEND;
        })
        ->addColumn('time', function($dataSet){
            $time = '';
            if ($dataSet->SS_CREATED_ON) {
                $time .= '<div title="Generated">'.date('d-m-y h:i A',strtotime($dataSet->SS_CREATED_ON)).'</div>';
            }
            if ($dataSet->SEND_AT) {
                $time .= '<div style="border-top: 1px solid #eee;" title="Sent At">'.date('d-m-y h:i A',strtotime($dataSet->SEND_AT)).'</div>';
            }
            return $time;
        })
        ->addColumn('active', function($dataSet){
            $active = '';
            $active .= '<a title="VIEW EMAIL" class="btn btn-xs btn-primary mr-05" href="'.route('admin.notify_email.body',$dataSet->PK_NO).'">'.'<i class="la la-eye">'.'</i>'.'</a>';
            $active .= '<a title="SEND EMAIL" class="btn btn-xs btn-primary mr-05" href="'.route('admin.notify_email.send',$dataSet->PK_NO).'">'.'<i class="la la-send">'.'</i>'.'</a>';

            return $active;
        })
        ->rawColumns(['type','name','email','ORDER_ID','MOBILE','IS_SEND','time','active'])
        ->make(true);

    }

    public function getNewArival($request){
        $dataSet = DB::table("PRD_NA_MASTER")
        ->select('PK_NO','FROM_DATE','TO_DATE','PDF_PATH','MAX_VARIANT','HAS_CHILD','F_SS_CREATED_BY','SHOP_NAME')
        ->orderBy('PK_NO', 'DESC');

        return Datatables::of($dataSet)
        ->addColumn('to_date', function($dataSet){
            $to_date = date('d M, Y',strtotime($dataSet->TO_DATE));
            return $to_date;
        })
        ->addColumn('from_date', function($dataSet){
            $from_date = date('d M, Y',strtotime($dataSet->FROM_DATE));
            return $from_date;
        })
        ->addColumn('pdf_path', function($dataSet){
            if ($dataSet->PDF_PATH) {
                $pdf_path = '<a href="'.asset(($dataSet->PDF_PATH)).'" target="_blank">View PDF</a>';
            }else {
                $pdf_path = '';
            }
            return $pdf_path;
        })
        ->addColumn('action', function($dataSet){
            $roles = userRolePermissionArray();
            $view = '';
            if (hasAccessAbility('view_newarival', $roles)) {
                $view = ' <a href="'.route("admin.newarival.view", [$dataSet->PK_NO]). '" class="btn btn-xs btn-success mb-05 mr-05" title="VIEW"><i class="la la-eye"></i></a>';
            }
            return $view;
        })
        ->rawColumns(['to_date','from_date','pdf_path','action'])
        ->make(true);
    }

    public function getNewAriavalView($request,$id){
        $dataSet = DB::table("PRD_NA_MASTER_DETAIL as p")
        ->select('p.PK_NO','p.F_NA_MASTER_NO','p.F_PRD_MASTER_SETUP_NO','p.ORDER_ID', 'p.IS_MANUAL','PRD_MASTER_SETUP.DEFAULT_NAME', 'p.TOTAL_NA_VARIANT','p.SHOP_NAME')
        ->leftJoin('PRD_MASTER_SETUP','PRD_MASTER_SETUP.PK_NO','p.F_PRD_MASTER_SETUP_NO')
        ->where('p.F_NA_MASTER_NO',$id)
        ->orderBy('p.ORDER_ID', 'DESC');

        return Datatables::of($dataSet)
        ->addColumn('master_name', function($dataSet){
            $master_name = '<a href="'.route('admin.newarival_variant.list',$dataSet->PK_NO).'">'.$dataSet->DEFAULT_NAME.'</a>';
            return $master_name;
        })

        ->addColumn('variant_count', function($dataSet){
            if($dataSet->TOTAL_NA_VARIANT > 0 ){
                $variant_count = $dataSet->TOTAL_NA_VARIANT;
            }else{
                $variant_count = '<span class="text-danger">No variant</span>';
            }

            return $variant_count;
        })
        ->addColumn('is_manual', function($dataSet){
            $is_manual = $dataSet->IS_MANUAL == 1 ? 'Manual' : 'Auto';
            return $is_manual;
        })

        ->addColumn('order_id', function($dataSet){
            $order_id = '';
            $order_id .= ' <form method="post" action="'.route('admin.newarival.orderid_update').'" class="edit_order_id form form-inline">'.csrf_field().'<input type="hidden" name="pk_no" value="'.$dataSet->PK_NO.'"><div class="form-group"><input type="number" required="" name="order_id" class="form-control order_id" title="Credit price" value="'.$dataSet->ORDER_ID.'"></div><div class="form-group"><button type="button" class="btn btn-sm btn-danger order_id_close" data-pk_no="2163"><i class="fa fa-times"></i></button><button type="submit" class="btn btn-sm btn-success">Update</button></div></form>';
            $order_id .= '<a href="javascript:void(0)" title="Click for edit" class="order_id_show">'.$dataSet->ORDER_ID.'</a>';
            return $order_id;
        })

        ->addColumn('action', function($dataSet){
            $roles = userRolePermissionArray();
            $view = '';
            if (hasAccessAbility('edit_newarival', $roles)) {
                $view = '<input type="checkbox" name="record_check" value="'.$dataSet->PK_NO.'" class="record_check" >';
            }
            return $view;

        })
        ->rawColumns(['master_name','variant_count','is_manual','order_id','action'])
        ->make(true);
    }

    public function getNewArivalVariantView($request,$id){
        $top_sell_master = DB::table('PRD_NA_MASTER_DETAIL')->where('PK_NO',$id)->first();

        $dataSet = DB::table("PRD_NA_VARIANT_DETAIL")
        ->select('PK_NO','F_NA_MASTER_NO','F_PRD_VARIANT_NO','QTY','SELL_AMOUNT','ORDER_ID', 'IS_MANUAL','VARIANT_NAME', 'SHOP_NAME')
        ->where('F_NA_MASTER_NO',$top_sell_master->F_NA_MASTER_NO)
        ->where('F_PRD_MASTER_SETUP_NO',$top_sell_master->F_PRD_MASTER_SETUP_NO)
        ->orderBy('ORDER_ID', 'DESC');

        return Datatables::of($dataSet)
        ->addColumn('qty', function($dataSet){
            $qty = '<a href="#">'.$dataSet->QTY.'</a>';
            return $qty;
        })
        ->addColumn('is_manual', function($dataSet){
            $is_manual = $dataSet->IS_MANUAL == 1 ? 'Manual' : 'Auto';
            return $is_manual;
        })
        ->addColumn('total_sell', function($dataSet){
            $total_sell = number_format($dataSet->SELL_AMOUNT,2);
            return $total_sell;
        })
        ->addColumn('avg_price', function($dataSet){
            if($dataSet->QTY > 0 ){
                $avg_price = number_format($dataSet->SELL_AMOUNT/$dataSet->QTY,2);
            }else{
                $avg_price = number_format($dataSet->SELL_AMOUNT,2);
            }
            return $avg_price;
        })
        ->addColumn('order_id', function($dataSet){
            $order_id = '';
            $order_id .= ' <form method="post" action="'.route('admin.na_variant.orderid_update').'" class="edit_order_id form form-inline">'.csrf_field().'<input type="hidden" name="pk_no" value="'.$dataSet->PK_NO.'"><div class="form-group"><input type="number" required="" name="order_id" class="form-control order_id" title="Credit price" value="'.$dataSet->ORDER_ID.'"></div><div class="form-group"><button type="button" class="btn btn-sm btn-danger order_id_close" data-pk_no="2163"><i class="fa fa-times"></i></button><button type="submit" class="btn btn-sm btn-success">Update</button></div></form>';
            $order_id .= '<a href="javascript:void(0)" title="Click for edit" class="order_id_show">'.$dataSet->ORDER_ID.'</a>';
            return $order_id;
        })
        ->addColumn('action', function($dataSet){
            $roles = userRolePermissionArray();
            $view = '';
            if (hasAccessAbility('edit_newarival', $roles)) {
                $view = '<input type="checkbox" name="record_check" value="'.$dataSet->PK_NO.'" class="record_check" >';
            }
            return $view;
        })
        ->rawColumns(['qty','is_manual','total_sell','avg_price','order_id','action'])
        ->make(true);
    }

    public function getPendingVarint($request){
        $dataSet = DB::table('PRD_VARIANT_SETUP as p')->select('p.PK_NO', 'p.MRK_ID_COMPOSITE_CODE','p.BARCODE','p.COMPOSITE_CODE','p.SIZE_NAME','p.COLOR','p.LOCAL_POSTAGE','p.INTER_DISTRICT_POSTAGE','p.AIR_FREIGHT_CHARGE','p.SEA_FREIGHT_CHARGE','p.REGULAR_PRICE','p.INSTALLMENT_PRICE','p.VARIANT_NAME','p.PRIMARY_IMG_RELATIVE_PATH','m.BRAND_NAME', 'm.MODEL_NAME','c.NAME as CATEGORY_NAME', 's.NAME as SUB_CATEGORY_NAME','p.IS_ACTIVE','p.THUMB_PATH')
        ->leftJoin('PRD_MASTER_SETUP as m','m.PK_NO','p.F_PRD_MASTER_SETUP_NO')
        ->leftJoin('PRD_CATEGORY as c','c.PK_NO','m.F_PRD_CATEGORY_ID')
        ->leftJoin('PRD_SUB_CATEGORY as s','s.PK_NO','m.F_PRD_SUB_CATEGORY_ID')
        ->where('p.IS_ACTIVE', 2)
        ->get();

        return Datatables::of($dataSet)
        ->addColumn('photo', function($dataSet){
            $photo = '<a href="'.asset($dataSet->PRIMARY_IMG_RELATIVE_PATH).'" target="_blank"><img src="'.asset($dataSet->THUMB_PATH).'" width="60" /></a>';
            return $photo;
        })
        ->addColumn('status', function($dataSet){
            $status = 'Pending';
            return $status;
        })
        ->addColumn('code', function($dataSet){
            $code = '';
            $code = '<div style="display:block;"><span style="width: 70px; display: inline-block">IG </span>: '.$dataSet->MRK_ID_COMPOSITE_CODE.'</div><div style="display:block;"><span style="width: 70px; display: inline-block">BARCODE </span>: '.$dataSet->BARCODE.'</div><div style="display:block;"><span style="width: 70px; display: inline-block">SKU </span>: '.$dataSet->COMPOSITE_CODE.'</div>';
            return $code;
        })
        ->addColumn('color_size', function($dataSet){
            $color_size = '<div>'.$dataSet->SIZE_NAME.'</div><div>'.$dataSet->COLOR.'</div>';
            return $color_size;
        })
        ->addColumn('brand_model', function($dataSet){
            $brand_model = '<div style="font-size :10px;" title="Brand Name / Model Name">'.$dataSet->BRAND_NAME.'<br>&nbsp;&nbsp;'.$dataSet->MODEL_NAME.'</div>';
            return $brand_model;
        })
        ->addColumn('category', function($dataSet){
            $category = '';
            $category = '<div style="font-size :10px;" title="Category Name / Sub Category Name">'.$dataSet->CATEGORY_NAME.'<br>&nbsp;&nbsp;'.$dataSet->SUB_CATEGORY_NAME.'</div>';
            return $category;
        })
        ->addColumn('postage', function($dataSet){
            $postage = '';
            $postage = '<span>'.number_format($dataSet->LOCAL_POSTAGE,2).'/'.number_format($dataSet->INTER_DISTRICT_POSTAGE,2).'</span><br><span>'.number_format($dataSet->AIR_FREIGHT_CHARGE,2).'/'.number_format($dataSet->SEA_FREIGHT_CHARGE,2).'</span>';
            return $postage;
        })
        ->addColumn('price', function($dataSet){
            $price = '';
            $price = '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="bottom" data-html="true" class="w-tooltip" data-title="" data-original-title="" title="" data-popup="tooltip-custom"  data-bg-color="white">'. number_format($dataSet->REGULAR_PRICE,2).'/'. number_format($dataSet->INSTALLMENT_PRICE,2).'</a>';
            return $price;
        })

        ->addColumn('action', function($dataSet){
            $roles = $this->getMyRole();
            $edit = '';
            if (hasAccessAbility('edit_pending_varint', $roles)) {
                $edit = '<a href="'.route('admin.pending_varint.edit',$dataSet->PK_NO).'"  target="_blank" class="btn btn-xs btn-info mr-05"><i class="la la-edit" title="Edit product variant"></i></a>';
            }
            return $edit;

        })
        ->rawColumns(['photo','status','code','color_size','brand_model','category','postage','price','action'])
        ->make(true);

    }

    public function getMyOrders($request)
    {
        $user_id = $request->customer_id;
         $dataSet = DB::table("SLS_BOOKING")
                ->select('SLS_BOOKING.PK_NO','SLS_BOOKING.PK_NO as F_BOOKING_NO',
                'SLS_BOOKING.F_CUSTOMER_NO','SLS_BOOKING.F_SHOP_NO','SLS_BOOKING.CUSTOMER_NAME',
                'SLS_BOOKING.SS_CREATED_ON','SA_USER.NAME as CREATED_BY',
                'SLS_BOOKING.SHOP_NAME','SLS_BOOKING.CONFIRM_TIME as ORDER_DATE','SLS_BOOKING.BOOKING_NO',
                'SLS_BOOKING.PK_NO as  SLS_BOOKING_PK_NO',
                'SLS_BOOKING.IS_SYSTEM_HOLD','SLS_BOOKING.IS_ADMIN_HOLD','SLS_BOOKING.DISPATCH_STATUS',
                'SLS_BOOKING.CANCEL_REQUEST_BY','SLS_BOOKING.CANCEL_REQUEST_AT',
                'SLS_BOOKING.IS_SELF_PICKUP','SLS_BOOKING.IS_ADMIN_APPROVAL','SLS_BOOKING.BOOKING_NOTES',
                'SLS_BOOKING.CONFIRM_TIME','SLS_BOOKING.TOTAL_PRICE','SLS_BOOKING.DISCOUNT')
                ->leftJoin('SA_USER','SLS_BOOKING.F_SS_CREATED_BY','SA_USER.PK_NO');

        $dataSet->where('SLS_BOOKING.F_CUSTOMER_NO',$user_id);

        $dataSet->orderBy('SLS_BOOKING.PK_NO','DESC');
        if($request->limit_order == 1){
            $dataSet->take(5);
        }
        $dataSet->get();
        return Datatables::of($dataSet)
        ->addColumn('created_at', function($dataSet){
            $created_at = '<div class="font-11">'.date('d-m-y h:i A',strtotime($dataSet->SS_CREATED_ON)).'</div><div>'.$dataSet->CREATED_BY.'</div>';
            return $created_at;
        })
        ->addColumn('order_date', function($dataSet){
            if($dataSet->CONFIRM_TIME){
            $order_date = '<div>'.date('d-m-y',strtotime($dataSet->CONFIRM_TIME)).'</div>';
            }else{
                $order_date = '<div>'.date('d-m-y',strtotime($dataSet->SS_CREATED_ON)).'</div>';
            }
            return $order_date;
        })
        ->addColumn('order_id', function($dataSet){
            $order_id = null;
            $order_id .= '<a href="'.route('admin.booking.view',$dataSet->SLS_BOOKING_PK_NO).'">ORD-'.$dataSet->BOOKING_NO.'</a>';
            return $order_id;
        })
        ->addColumn('customer_name', function($dataSet){
                $customer_name = '<a href="#!">'.$dataSet->CUSTOMER_NAME.'</a>';
            return $customer_name;
        })
        ->addColumn('item_type', function($dataSet){
            $booking_no = $dataSet->F_BOOKING_NO;
            $item = 0;
            $item_type = '';
            $query = DB::SELECT("SELECT SLS_BOOKING_DETAILS.F_BOOKING_NO, COUNT(*) AS ITEM_QTY  FROM SLS_BOOKING_DETAILS  WHERE SLS_BOOKING_DETAILS.F_BOOKING_NO = $booking_no");
            if(!empty($query)){
                foreach($query as $variant){
                    $item +=  $variant->ITEM_QTY;
                }
            }
            $item_type_qty = count($query) ?? 0;
            if($item_type_qty > 1){
                $item_type ='<div title="Total Quantity/Total Item">'.$item.'/'.$item_type_qty.'</div>';
            }else{
                $item_type ='<div >'.$item_type_qty.'</div>';
            }
            return $item_type;
        })
        ->addColumn('price_after_dis', function($dataSet){
            $price_after_dis = number_format($dataSet->TOTAL_PRICE - $dataSet->DISCOUNT,2);
            return $price_after_dis;
        })
        ->addColumn('payment', function($dataSet){
            $payment = '';


            if(($dataSet->TOTAL_PRICE) - $dataSet->DISCOUNT > 0 ){
                $payment .= '<div class="badge badge-danger" title="DUE" >'.number_format(($dataSet->TOTAL_PRICE)  - $dataSet->DISCOUNT,2).'</div>';
            }
            return $payment;
        })
        ->addColumn('avaiable', function($dataSet){
            $avaiable = '';

            return $avaiable;
        })
        ->addColumn('status', function($dataSet){
            $status = '';
            if($status == ''){
                if($dataSet->IS_SYSTEM_HOLD == 1)
                    {
                        $status = '<div class="badge badge-default" title="In Processing"><i class="la la-spinner fa-spin fa-3x fa-fw font-size20"></i></div>';
                    }
            }
            return $status;
        })
        ->addColumn('action', function($dataSet){
            $action = '';
               $action .= '<a href="'.route('admin.booking.view',[$dataSet->SLS_BOOKING_PK_NO ?? 0]).'" class="btn btn-xs btn-primary mb-05 mr-05"><i class="la la-eye font-size11"></i></a>';
            return $action;
        })
        ->addColumn('altered', function($dataSet){
            if ($dataSet->IS_ADMIN_APPROVAL == 1) {
                return 'Altered';
            }else{
                return '';
            }
        })
        ->rawColumns(['created_at','order_date','order_id','customer_name','item_type','price_after_dis','payment','avaiable','status','action','altered'])
        ->make(true);
    }

    public function invoiceProcessingList($request)
    {
        // dd($request->all());

        $branch_id = $request->branch_id;

        $invoice_for = $request->segment(1) == 'seller' ? 'seller' : 'admin';
        $dataSet = Invoice::select(['PRC_STOCK_IN.*',DB::raw('count(1) AS total_child')])
        ->join('PRC_STOCK_IN_DETAILS', 'PRC_STOCK_IN_DETAILS.F_PRC_STOCK_IN', '=', 'PRC_STOCK_IN.PK_NO')
        ->groupBy('PRC_STOCK_IN.PK_NO')
        ->havingRaw('total_child > 0')
        ->where('PRC_STOCK_IN.IS_ACTIVE',1);
        if($invoice_for == 'seller'){
            $dataSet->where('PRC_STOCK_IN.F_SHOP_NO',Auth::user()->SHOP_ID);
        }
        if(isset($request->order[0]['dir']) && $request->order[0]['column'] == 12){
            $dataSet->orderBy('PRC_STOCK_IN.INV_STOCK_RECORD_GENERATED', $request->order[0]['dir']);
        }else{
            $dataSet->orderBy('PRC_STOCK_IN.INVOICE_DATE', 'desc');
        }
        if(!empty($branch_id)){

            // dd($branch_id);

            $dataSet = $dataSet->where('PRC_STOCK_IN.F_SHOP_NO', $branch_id);
        }

        return Datatables::of($dataSet)
        ->addColumn('date', function($dataSet){
            return '<span>'.$dataSet->INVOICE_DATE.'</span>';
        })
        ->addColumn('vendor', function($dataSet){
            return '<span>'.$dataSet->VENDOR_NAME .'</span>' ;
        })
        ->addColumn('acc_info', function($dataSet){
            return $acc_info = '<div><span>'. $dataSet->PAYMENT_SOURCE_NAME. '</span>/<span>'.$dataSet->PAYMENT_ACC_NAME. '</span>/<span>'.$dataSet->PAYMENT_METHOD_NAME.'</span></div>';
        })
        ->addColumn('reciept_no', function($dataSet){
            return $reciept_no = '<span>'.$dataSet->INVOICE_NO.'</span>';
        })
        ->addColumn('cal_value', function($dataSet){
            $cal_value = '';
            $cal_value .= '<span style="font-size: 10px; color: #000">('. $dataSet->INVOICE_CURRENCY .')</span>';
            $cal_val = $dataSet->INVOICE_REC_TOTAL_ACTUAL_AC_WITH_VAT + $dataSet->INVOICE_POSTAGE_ACTUAL_AC;
            if(number_format($cal_val,2) != number_format($dataSet->INVOICE_EXACT_VALUE,2) ){
                $cal_value .= ' <span title="CALCULATED VALUE & RECIEPT VALUE NOT SAME">'.number_format($cal_val,2). '/' .number_format($dataSet->INVOICE_EXACT_VALUE,2) .'</span>';
            }else{
                $cal_value .= ' <span title="CALCULATED VALUE & RECIEPT VALUE SAME">'. number_format($dataSet->INVOICE_EXACT_VALUE,2) .'</span>';
            }
            return $cal_value;
        })
        ->addColumn('cal_qty', function($dataSet){
            $cal_qty = '';
            $cal_qty .= '<span>'.$dataSet->RECIEVED_QTY .'</span>';

            if($dataSet->FAULTY_QTY > 0 ){
                $cal_qty .= ' <span>('.$dataSet->FAULTY_QTY .')</span>';
            }
            $cal_qty .= ' <span>/'.(($dataSet->TOTAL_QTY)+($dataSet->FAULTY_QTY)) .'</span>';
            return $cal_qty;
        })
        ->addColumn('loyalty', function($dataSet) use ($request) {
            $roles = userRolePermissionArray();
            $loyalty = '';
            $invoice_for = $request->segment(1) == 'seller' ? 'seller' : 'admin';
            if($dataSet->HAS_LOYALTY == 1){
                $loyalty_claimed = $dataSet->LOYALTY_CLAIMED == 1 ? 'YES' : 'NO';
                $textwhite = $dataSet->LOYALTY_CLAIMED != 1 ? 'text-white' : '';
                $loyalty .= '<div class="btn-group"><button type="button" class="btn btn-info btn-sm dropdown-toggle text-white '.$textwhite.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$loyalty_claimed.'</button>';
                if($dataSet->LOYALTY_CLAIMED != 1 && hasAccessAbility('edit_invoice', $roles)){
                    $loyalty .= ' <div class="dropdown-menu dropdown-menu-sm" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 40px, 0px);"> <a class="dropdown-item btn-danger" href="'.route($invoice_for.'.loyalty-claime',['id' => $dataSet->PK_NO, 'invoice_for' => $invoice_for ] ) . '"  onclick="return confirm(\'Are you sure?\')">YES</a></div>';
                }
                $loyalty .= ' </div>';
            }else{
                $loyalty .= '<span>N/A</span>';
            }
            return $loyalty;
        })
        ->addColumn('vat_claim', function($dataSet){
            $vat_amt = 0;
            $vat_claim = '';
            $vat_amt = $dataSet->INVOICE_REC_TOTAL_ACTUAL_AC_ONLY_VAT;
            $vat_amt1 = number_format($vat_amt,2);
            if($vat_amt != 0 ){
                if($dataSet->VAT_CLAIMED == 1){
                    $vat_claim .= '<span>YES</span>';
                }else{
                    $vat_claim .= '<span>NO ('.$vat_amt1.')</span>';
                }

            }else{
                $vat_claim .= '<span>N/A</span>' ;
            }
            return $vat_claim;
        })
        ->addColumn('ext_vat', function($dataSet){
            $ext_vat = '<span>'. number_format($dataSet->INVOICE_EXACT_VAT,2).'</span>';
            return $ext_vat;
        })
        ->addColumn('stock_gen', function($dataSet) use ($request) {
            $roles = userRolePermissionArray();
            $stock_gen = '';

            $inv_stock_record_generated = $dataSet->INV_STOCK_RECORD_GENERATED == 1 ? "YES" : "NO";
            $inv_stock_record_generated_cls = $dataSet->INV_STOCK_RECORD_GENERATED != 1 ? 'btn-danger' : 'btn-info';
            $stock_gen .= ' <div class="btn-group invoice-no-'.$dataSet->INVOICE_NO.'"><button type="button" class="dropdown-toggle btn  btn-sm '.$inv_stock_record_generated_cls.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$inv_stock_record_generated.'</button>';

            if($dataSet->INV_STOCK_RECORD_GENERATED != 1){
                $stock_gen .= ' <div class="dropdown-menu dropdown-menu-sm" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 40px, 0px);">';
                if(hasAccessAbility('new_stock', $roles)){
                    $stock_gen .= ' <button class="dropdown-item stockGenerate" title="STOCK GENERATE"  data-invoice_id="'.$dataSet->INVOICE_NO .'" data-pk_no="'.$dataSet->PK_NO .'" data-vendor_no="'.$dataSet->F_VENDOR_NO.'">YES</button>';
                }
                $stock_gen .= ' </div>';
            }
            $stock_gen .= ' </div>';

            return $stock_gen;
        })
        ->addColumn('action', function($dataSet) use ($request) {
            $action = '';
            $roles = userRolePermissionArray();
            $invoice_for = $request->segment(1) == 'seller' ? 'seller' : 'admin' ?? 'azuramart';

            if(hasAccessAbility('edit_vendor', $roles)){
                $action .= '<a href="'.route($invoice_for.'.invoice-details',['id' => $dataSet->PK_NO ]) .'" title="VIEW INVOICE DETAILS" class="btn btn-xs btn-success" ><i class="la la-eye"></i></a>';
            }
            if(hasAccessAbility('delete_vendor', $roles)){
                $action .= '<a href="'.route($invoice_for.'.stock.delete', ['id' => $dataSet->PK_NO ]).'" class="btn btn-xs btn-danger" onclick="return confirm(\'Are You Sure?\')" title="DELETE ALL STOCKS"><i class="la la-trash"></i> </a>';
            }
            $action .= '<a href="'.route($invoice_for.'.invoice-product-details.get-product',['id'=> $dataSet->PK_NO,'type' => 'stock-processing']) .'" class="btn btn-xs btn-success" title="VIEW PRODUCT POSITION"><i class="la la-eye"></i> </a>';
            return $action;
        })
        ->rawColumns(['date','vendor','acc_info','reciept_no','cal_value','cal_qty','loyalty','vat_claim','ext_vat','stock_gen','action'])
        ->make(true);

    }

    public function invoiceList($request)
    {
        $dataSet = $this->invoice->where('IS_ACTIVE',1)
                ->orderBy('INVOICE_DATE', 'DESC');
        $shop_id = null;

        if(Auth::user()->USER_TYPE == 10){
            $shop_id = Auth::user()->SHOP_ID;
        }else{
            $shop_id = $request->branch_id;
        }

        if($shop_id){
            $dataSet->where('F_SHOP_NO',$shop_id);
        }
        // dd($shop_id);
        $dataSet = $dataSet->get();
                // dd($dataSet);

        return Datatables::of($dataSet, $request)
        ->addColumn('date', function($dataSet){
            $date = '';
            $date .= '<span>'.date('d-m-Y',strtotime($dataSet->INVOICE_DATE)).'</span>';
            return $date;
        })
        ->addColumn('vendor', function($dataSet){
            $vendor = '';
            $vendor .= '<span>'.$dataSet->VENDOR_NAME.'</span>';
            return $vendor;
        })
        ->addColumn('shop', function($dataSet){
            $shop = '';
            $shop .= '<span>'.$dataSet->SHOP_NAME.'</span>';
            return $shop;
        })



        ->addColumn('reciept_no', function($dataSet){
            $reciept_no = '';
            $reciept_no .= '<span>'.$dataSet->INVOICE_NO.'</span>';
            return $reciept_no;
        })
        ->addColumn('cal_value', function($dataSet) use ($request) {
            $cal_value = '';
            $cal_val = $dataSet->INVOICE_REC_TOTAL_ACTUAL_AC_WITH_VAT + $dataSet->INVOICE_POSTAGE_ACTUAL_AC;
            if (number_format($cal_val,2) != number_format($dataSet->INVOICE_EXACT_VALUE,2)) {
                $cal_value .= '<span title="CALCULATED VALUE & RECIEPT VALUE NOT SAME">'.number_format($cal_val,2). '/'.number_format($dataSet->INVOICE_EXACT_VALUE,2) .'</span>';
            }else{
                $cal_value .= '<span>'.number_format($dataSet->INVOICE_EXACT_VALUE,2).'</span>';
            }
            return $cal_value;
        })
        ->addColumn('cal_qty', function($dataSet){
            $qty = '';
            $qty     .= $dataSet->RECIEVED_QTY ?? 0;
            if ($dataSet->FAULTY_QTY > 0) {
                $faulty = $dataSet->FAULTY_QTY == null ? 0 : $dataSet->FAULTY_QTY;
                $qty .= ' ('.$faulty.') ';
            }
            $total = $dataSet->TOTAL_QTY == null ? 0 : $dataSet->TOTAL_QTY;
            $qty .= ' / '.$total ;

            return $qty;
        })
        ->addColumn('vat', function($dataSet){
            $vat = '';
                $vat .= '<span>'.number_format($dataSet->INVOICE_REC_TOTAL_ACTUAL_AC_ONLY_VAT,2).'</span>';
            return $vat;
        })
        ->addColumn('action', function($dataSet) use ($request){
            $action = '';
            $roles = userRolePermissionArray();
            if ($dataSet->INV_STOCK_RECORD_GENERATED != 1) {
                if (hasAccessAbility('new_invoice', $roles)) {
                    $action .= '<a href="'.route('admin.invoice-details.new',['id' => $dataSet->PK_NO ]).'" title="ADD LINE ITEM">'.'<button type="button" class="btn btn-xs btn-info mr-05">'.'<i class="la la-plus" ></i>'.'</button>'. '</a>';
                }
            }

            if ($dataSet->INV_STOCK_RECORD_GENERATED != 1) {
                if (hasAccessAbility('edit_invoice', $roles)) {
                    $action .= '<a href="'.route('admin.invoice.edit',['id' => $dataSet->PK_NO ]).'" title="INVOICE EDIT">'.'<button type="button" class="btn btn-xs btn-info mr-05">'.'<i class="la la-pencil"></i>'.'</button>'. '</a>';
                }
            }

            if (hasAccessAbility('view_invoice', $roles)) {
                $action .= '<a href="'.route('admin.invoice-details',['id' => $dataSet->PK_NO ]).'" title="VIEW INVOICE DETAILS">'.'<button type="button" class="btn btn-xs btn-info mr-05">'.'<i class="la la-eye"></i>'.'</button>'. '</a>';
            }

            if ($dataSet->F_CHILD_PRC_STOCK_IN > 0 ) {
                if (hasAccessAbility('view_invoice', $roles)) {
                    $action .= '<a href="'.route('admin.invoice-details',['id' => $dataSet->F_CHILD_PRC_STOCK_IN ]).'" title="VIEW CHILD INVOICE" class="btn btn-xs btn-success mr-05">'.'&nbsp;C&nbsp;'.'</a>';
                }
            }else{
                if (hasAccessAbility('new_invoice', $roles)) {
                    $action .= '<a href="'.route('admin.invoice.new',['type' => 'child', 'parent' => $dataSet->PK_NO]).'" title="ADD CHILD INVOICE UNDER THE INVOICE" class="btn btn-xs btn-primary mr-05">'.'  <i class="la la-plus" ></i>'.'</a>';
                }
            }

            if ($dataSet->F_PARENT_PRC_STOCK_IN > 0 ) {
                if (hasAccessAbility('view_invoice', $roles)) {
                    $action .= '<a href="'.route('admin.invoice-details',[$dataSet->F_PARENT_PRC_STOCK_IN]).'" title="VIEW PARENT INVOICE" class="btn btn-xs btn-primary mr-05">'.'&nbsp;P&nbsp;'.'</a>';
                }
            }

            if ($dataSet->INV_STOCK_RECORD_GENERATED != 1 ) {
                if (hasAccessAbility('delete_invoice', $roles)) {
                    $action .= '<a href="'.route('admin.invoice.delete',['id' => $dataSet->PK_NO ]).'" onclick="return confirm("Are You Sure?")"  title="INVOICE DELETE">'.'<button type="button" class="btn btn-xs btn-danger mr-05">'.'<i class="la la-trash"></i>'.'</button>'. '</a>';
                }
            }

            // if (Auth::user()->F_MERCHANT_NO == 0 && $request->invoice_for == 'merchant') {
            //     if (hasAccessAbility('view_invoice', $roles)) {
            //         if($dataSet->INVOICE_PHOTO_SHOW_MERCHANT == 1){
            //             $checked = 'checked';
            //         }else{
            //             $checked = '';
            //         }
            //         $action .= '<input type="checkbox" title="CHECK TO ALLOW PDF VIEW" id="merchant_invoice_view" name="merchant_invoice_view" data-merchant_id="'.$dataSet->F_MERCHANT_NO.'" data-invoice_pk="'.$dataSet->PK_NO.'" class="ml-1 c-p" '.$checked.'>';
            //     }
            // }
            return $action;
        })

        ->rawColumns(['date','vendor','shop','reciept_no','cal_value','cal_qty','vat','action'])
        ->make(true);
    }

    public function sellerInvoiceList($request)
    {
        $dataSet = $this->invoice->where('IS_ACTIVE',1)->where('F_SHOP_NO',Auth::user()->SHOP_ID)
                ->orderBy('INVOICE_DATE', 'DESC')->get();

        return Datatables::of($dataSet, $request)
        ->addColumn('date', function($dataSet){
            $date = '';
            $date .= '<span>'.date('d-m-Y',strtotime($dataSet->INVOICE_DATE)).'</span>';
            return $date;
        })
        ->addColumn('vendor', function($dataSet){
            $vendor = '';
            $vendor .= '<span>'.$dataSet->VENDOR_NAME.'</span>';
            return $vendor;
        })
        ->addColumn('reciept_no', function($dataSet){
            $reciept_no = '';
            $reciept_no .= '<span>'.$dataSet->INVOICE_NO.'</span>';
            return $reciept_no;
        })
        ->addColumn('cal_value', function($dataSet) use ($request) {
            $cal_value = '';
            $cal_val = $dataSet->INVOICE_REC_TOTAL_ACTUAL_AC_WITH_VAT + $dataSet->INVOICE_POSTAGE_ACTUAL_AC;
            if (number_format($cal_val,2) != number_format($dataSet->INVOICE_EXACT_VALUE,2)) {
                $cal_value .= '<span title="CALCULATED VALUE & RECIEPT VALUE NOT SAME">'.number_format($cal_val,2). '/'.number_format($dataSet->INVOICE_EXACT_VALUE,2) .'</span>';
            }else{
                $cal_value .= '<span>'.number_format($dataSet->INVOICE_EXACT_VALUE,2).'</span>';
            }
            return $cal_value;
        })
        ->addColumn('cal_qty', function($dataSet){
            $qty = '';
            $qty     .= $dataSet->RECIEVED_QTY ?? 0;
            if ($dataSet->FAULTY_QTY > 0) {
                $faulty = $dataSet->FAULTY_QTY == null ? 0 : $dataSet->FAULTY_QTY;
                $qty .= ' ('.$faulty.') ';
            }
            $total = $dataSet->TOTAL_QTY == null ? 0 : $dataSet->TOTAL_QTY;
            $qty .= ' / '.$total ;

            return $qty;
        })
        ->addColumn('vat', function($dataSet){
            $vat = '';
                $vat .= '<span>'.number_format($dataSet->INVOICE_REC_TOTAL_ACTUAL_AC_ONLY_VAT,2).'</span>';
            return $vat;
        })
        ->addColumn('action', function($dataSet) use ($request){
            $action = '';
            $roles = userRolePermissionArray();
            if ($dataSet->INV_STOCK_RECORD_GENERATED != 1) {
                if (hasAccessAbility('new_invoice', $roles)) {
                    $action .= '<a href="'.route('seller.invoice-details.new',['id' => $dataSet->PK_NO ]).'" title="ADD LINE ITEM">'.'<button type="button" class="btn btn-xs btn-info mr-05">'.'<i class="la la-plus" ></i>'.'</button>'. '</a>';
                }
            }

            if ($dataSet->INV_STOCK_RECORD_GENERATED != 1) {
                if (hasAccessAbility('edit_invoice', $roles)) {
                    $action .= '<a href="'.route('seller.invoice.edit',['id' => $dataSet->PK_NO ]).'" title="INVOICE EDIT">'.'<button type="button" class="btn btn-xs btn-info mr-05">'.'<i class="la la-pencil"></i>'.'</button>'. '</a>';
                }
            }

            if (hasAccessAbility('view_invoice', $roles)) {
                $action .= '<a href="'.route('seller.invoice-details',['id' => $dataSet->PK_NO ]).'" title="VIEW INVOICE DETAILS">'.'<button type="button" class="btn btn-xs btn-info mr-05">'.'<i class="la la-eye"></i>'.'</button>'. '</a>';
            }

            if ($dataSet->F_CHILD_PRC_STOCK_IN > 0 ) {
                if (hasAccessAbility('view_invoice', $roles)) {
                    $action .= '<a href="'.route('seller.invoice-details',['id' => $dataSet->F_CHILD_PRC_STOCK_IN ]).'" title="VIEW CHILD INVOICE" class="btn btn-xs btn-success mr-05">'.'&nbsp;C&nbsp;'.'</a>';
                }
            }else{
                if (hasAccessAbility('new_invoice', $roles)) {
                    $action .= '<a href="'.route('seller.invoice.new',['type' => 'child', 'parent' => $dataSet->PK_NO]).'" title="ADD CHILD INVOICE UNDER THE INVOICE" class="btn btn-xs btn-primary mr-05">'.'  <i class="la la-plus" ></i>'.'</a>';
                }
            }

            if ($dataSet->F_PARENT_PRC_STOCK_IN > 0 ) {
                if (hasAccessAbility('view_invoice', $roles)) {
                    $action .= '<a href="'.route('seller.invoice-details',[$dataSet->F_PARENT_PRC_STOCK_IN]).'" title="VIEW PARENT INVOICE" class="btn btn-xs btn-primary mr-05">'.'&nbsp;P&nbsp;'.'</a>';
                }
            }

            if ($dataSet->INV_STOCK_RECORD_GENERATED != 1 ) {
                if (hasAccessAbility('delete_invoice', $roles)) {
                    $action .= '<a href="'.route('seller.invoice.delete',['id' => $dataSet->PK_NO ]).'" onclick="return confirm("Are You Sure?")"  title="INVOICE DELETE">'.'<button type="button" class="btn btn-xs btn-danger mr-05">'.'<i class="la la-trash"></i>'.'</button>'. '</a>';
                }
            }

            // if (Auth::user()->F_MERCHANT_NO == 0 && $request->invoice_for == 'merchant') {
            //     if (hasAccessAbility('view_invoice', $roles)) {
            //         if($dataSet->INVOICE_PHOTO_SHOW_MERCHANT == 1){
            //             $checked = 'checked';
            //         }else{
            //             $checked = '';
            //         }
            //         $action .= '<input type="checkbox" title="CHECK TO ALLOW PDF VIEW" id="merchant_invoice_view" name="merchant_invoice_view" data-merchant_id="'.$dataSet->F_MERCHANT_NO.'" data-invoice_pk="'.$dataSet->PK_NO.'" class="ml-1 c-p" '.$checked.'>';
            //     }
            // }
            return $action;
        })

        ->rawColumns(['date','vendor','reciept_no','cal_value','cal_qty','vat','action'])
        ->make(true);
    }

    public function getVatProcessing($request){
        if($request->invoice_for == 'merchant'){
            $dataSet = $this->merInvoice;
        }else{
            $dataSet = $this->invoice;
        }

        $dataSet = $dataSet->where('IS_ACTIVE',1)->where('F_SS_CURRENCY_NO',1)->orderBy('INVOICE_DATE', 'desc')->orderBy('PK_NO', 'desc')->get();

        return Datatables::of($dataSet, $request)
        ->addColumn('date', function($dataSet){
            $date = '';
            $date .= '<span>'.date('d-m-Y',strtotime($dataSet->INVOICE_DATE)).'</span>';
            return $date;
        })
        ->addColumn('vendor', function($dataSet){
            $vendor = '';
            $vendor .= '<span>'.$dataSet->VENDOR_NAME.'</span>';
            return $vendor;
        })
        ->addColumn('invoice_for', function($dataSet) use ($request){
            $invoice_for = '';
            if($request->invoice_for == 'merchant'){
                $merchant = DB::table('SLS_MERCHANT')->select('NAME')->where('PK_NO',$dataSet->F_MERCHANT_NO)->first();
                $invoice_for .= '<span>'.$merchant->NAME.'</span>';
            }else{
                $invoice_for .= '<span>AzuramartMart</span>';
            }
            return $invoice_for;
        })
        ->addColumn('acc_info', function($dataSet){
            $acc_info = '';
            $acc_info .= '<div style="font-size: 12px;">'.$dataSet->PAYMENT_SOURCE_NAME .'/ '.$dataSet->PAYMENT_ACC_NAME.' /'.$dataSet->PAYMENT_METHOD_NAME.'</div>';
            return $acc_info;
        })



        ->addColumn('reciept_no', function($dataSet){
            $reciept_no = '';
            $reciept_no .= '<span>'.$dataSet->INVOICE_NO.'</span>';
            return $reciept_no;
        })

        ->addColumn('cal_value', function($dataSet){
            $cal_value = '';
            $cal_val = $dataSet->INVOICE_REC_TOTAL_ACTUAL_AC_WITH_VAT + $dataSet->INVOICE_POSTAGE_ACTUAL_AC;

        if (number_format($cal_val,2) != number_format($dataSet->INVOICE_EXACT_VALUE,2)) {
                $cal_value .= '<span title="CALCULATED VALUE & RECIEPT VALUE NOT SAME">'.number_format($cal_val,2). '/'.number_format($dataSet->INVOICE_EXACT_VALUE,2) .'</span>';
            }else{
                $cal_value .= '<span>'.number_format($dataSet->INVOICE_EXACT_VALUE,2).'</span>';
            }
            return $cal_value;

        })
        ->addColumn('cal_qty', function($dataSet){
            $qty = '';
            $qty     .= $dataSet->RECIEVED_QTY ?? 0;
            if ($dataSet->FAULTY_QTY > 0) {
                $faulty = $dataSet->FAULTY_QTY == null ? 0 : $dataSet->FAULTY_QTY;
                $qty .= ' ('.$faulty.') ';
            }
            $total = $dataSet->TOTAL_QTY == null ? 0 : $dataSet->TOTAL_QTY;
            $qty .= ' / '.$total ;

            return $qty;
        })

        ->addColumn('vat_calim', function($dataSet) use ($request){
            $vat_calim = '';
            $vat_amt = 0;
            $vat_amt = $dataSet->INVOICE_REC_TOTAL_ACTUAL_AC_ONLY_VAT;
            $vat_amt = number_format($vat_amt,2);

            $class = $dataSet->VAT_CLAIMED != 1 ? 'text-white' : '';
            $btn_txt = $dataSet->VAT_CLAIMED == 1 ? 'YES' : 'NO ('.$vat_amt.')';
            $vat_calim .= '<div class="btn-group"><button type="button" class="btn btn-info btn-sm dropdown-toggle '.$class.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$btn_txt.'</button>';
            if($dataSet->VAT_CLAIMED != 1){
                $vat_calim .=' <div class="dropdown-menu dropdown-menu-sm" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 40px, 0px);">
                <a class="dropdown-item" href="'.route('admin.vat-claime', ['id' => $dataSet->PK_NO, 'invoice_for' => $request->invoice_for]) .'"  onclick="return confirm(\'Are you sure?\')">YES</a></div>';
            }
            $vat_calim .= ' </div>';
            return $vat_calim;
        })


        ->addColumn('vat', function($dataSet){
            $vat = '';
            $vat .= number_format($dataSet->INVOICE_EXACT_VAT,2);
            return $vat;
        })

        ->addColumn('action', function($dataSet) use ($request){
            $action = '';
            $roles = userRolePermissionArray();
            if($request->invoice_for == 'merchant'){
                $invoice_for = 'merchant';
            }else{
                $invoice_for = 'azuramart';
            }
            if(hasAccessAbility('view_vat_processing', $roles)){
                $action .= '<a href="'.route('admin.invoice-details', ['id' => $dataSet->PK_NO, 'invoice_for' => $request->invoice_for ]).'" title="VIEW INVOICE DETAILS" class="btn btn-xs btn-success mr-1" ><i class="la la-eye"></i></a>';

            if($dataSet->allPhotos && count($dataSet->allPhotos) > 0 ){
                foreach($dataSet->allPhotos as $ck => $photo ){
                    $action .= ' <a href="'.asset($photo->RELATIVE_PATH) .'" target="_blank" class="btn btn-xs btn-azura" style="" title="VIEW INVOICE"><i class="la la-cloud-download"></i></a>';
                }
            }

            $action .= ' <a href="'.route('admin.invoice-product-details.get-product',['id' => $dataSet->PK_NO, 'invoice_for' => $request->invoice_for,'type'=>'vat-processing']) .'" class="btn btn-xs btn-info" title="VIEW PRODUCT POSITION"><i class="la la-eye"></i> </a>';
            }

            return $action;
        })

        ->rawColumns(['date','vendor','invoice_for','acc_info', 'reciept_no','currency','cal_value','cal_qty','vat_calim','vat','action'])
        ->make(true);
    }


    // public function getDatatableReseller()
    // {
    //     $dataSet = DB::table("SLS_SELLERS as r")
    //     ->join('SS_COUNTRY as c','c.PK_NO','r.F_COUNTRY_NO')
    //     ->select('r.PK_NO','r.SELLER_NO','r.NAME','r.EMAIL','r.MOBILE_NO','r.CUM_BALANCE_BUFFER','r.CUM_BALANCE_ACTUAL','r.CUM_BALANCE','c.DIAL_CODE')
    //     ->where('r.IS_ACTIVE', 1)
    //     ->orderBy('r.SELLER_NO', 'ASC');
    //     return Datatables::of($dataSet)
    //                 ->addColumn('action', function($dataSet){
    //                     $roles = userRolePermissionArray();
    //                     $edit = '';
    //                     $view = '';
    //                     $delete = '';
    //                     $payment = '';
    //                     $balance_trans = '';
    //                     $add_booking = '';
    //                     $view_booking = '';
    //                     $view_booking = '';
    //                     $view_payment = '';
    //                     if (hasAccessAbility('edit_reseller', $roles)) {
    //                         $edit = '<a href="'.route("admin.seller.edit", [$dataSet->PK_NO]).'" class="btn btn-xs btn-info mb-05 mr-05" title="EDIT"><i class="la la-edit"></i></a>';
    //                     }
    //                     if (hasAccessAbility('view_reseller', $roles)) {
    //                         $view = ' <a href="'.route("admin.seller.view", [$dataSet->PK_NO]). '" class="btn btn-xs btn-success mb-05 mr-05" title="VIEW"><i class="la la-eye"></i></a>';
    //                     }
    //                     if (hasAccessAbility('delete_reseller', $roles)) {
    //                         $delete = ' <a href="'.route('admin.seller.delete', [$dataSet->PK_NO]).'" class="btn btn-xs btn-danger mb-05" onclick="return confirm('. "'" .'Are you sure you want to delete the seller ?'. "'" .')" title="DELETE"><i class="la la-trash"></i></a>';
    //                     }
    //                     if (hasAccessAbility('new_payment', $roles)) {
    //                         $payment = ' <a href="'.route('admin.payment.create', [$dataSet->PK_NO, 'seller' ]).'" class="btn btn-xs btn-primary mb-05 mr-05" title="Add new payment"><i class="la la-usd"></i></a>';
    //                     }
    //                     if (hasAccessAbility('new_booking', $roles)) {
    //                         $add_booking = ' <a href="'.route("admin.booking.create", ['id'=>$dataSet->PK_NO,'type'=>'seller']). '" class="btn btn-xs btn-primary mb-05 mr-05" title="ADD BOOKING"><i class="la la-plus"></i></a>';
    //                     }

    //                     if (hasAccessAbility('view_booking', $roles)) {
    //                         $view_booking = ' <a href="'.route("admin.booking.list", ['id' => $dataSet->PK_NO,'type'=>'seller']). '" class="btn btn-xs btn-success mb-05 mr-05" title="ALL BOOKING LIST">&nbsp;B&nbsp;</a>';
    //                     }
    //                     if (hasAccessAbility('view_booking', $roles)) {
    //                         $view_booking = ' <a href="'.route("admin.booking.list", ['id' => $dataSet->PK_NO,'type'=>'seller']). '" class="btn btn-xs btn-success mb-05 mr-05" title="ALL ORDER LIST">&nbsp;O&nbsp;</a>';
    //                     }
    //                     if (hasAccessAbility('view_payment', $roles)) {
    //                         $view_payment = ' <a href="'.route("admin.payment.list", ['id' => $dataSet->PK_NO,'type'=>'seller']). '" class="btn btn-xs btn-success mb-05 mr-05" title="ALL PAYMENTS LIST">&nbsp;P&nbsp;</a>';
    //                     }

    //                     if (hasAccessAbility('view_payment', $roles)) {
    //                         $view_history = ' <a href="'.route("admin.seller.history", ['id' => $dataSet->PK_NO]). '" class="btn btn-xs btn-success mb-05 mr-05" title="ALL HISTORY">&nbsp;H&nbsp;</a>';
    //                     }


    //                     return $edit.$view.$payment.$balance_trans.$add_booking.$view_booking.$view_booking.$view_payment.$view_history;
    //                 })

    //                 ->addColumn('due', function($dataSet){

    //                     $due = '0';
    //                     $seller_due = DB::SELECT("SELECT
    //                     SLS_BOOKING.PK_NO as BOOKING_PK_NO,
    //                     SLS_BOOKING.F_SHOP_NO AS SELLER_PK_NO,
    //                     SUM(SLS_BOOKING.TOTAL_PRICE) AS TOTAL_PRICE,
    //                     IFNULL(SLS_ORDER.ORDER_BUFFER_TOPUP,0) AS ORDER_BUFFER_TOPUP,
    //                     SUM(IFNULL(SLS_BOOKING.TOTAL_PRICE,0) - (IFNULL(SLS_ORDER.ORDER_BUFFER_TOPUP,0))) AS DUE_PRICE

    //                     from SLS_BOOKING, SLS_ORDER
    //                     where SLS_BOOKING.F_SHOP_NO = $dataSet->PK_NO
    //                     AND SLS_BOOKING.PK_NO = SLS_ORDER.F_BOOKING_NO");
    //                     if(!empty($seller_due)){
    //                         $due = number_format($seller_due[0]->DUE_PRICE,2);
    //                     }
    //                     return $due;

    //                 })
    //                 ->addColumn('credit', function($dataSet){
    //                     $roles = userRolePermissionArray();
    //                     $credit = '';
    //                     if($dataSet->CUM_BALANCE > 0 ){
    //                         if (hasAccessAbility('new_payment', $roles)) {
    //                             $credit = ' <a href="'.route('admin.payment.create', [$dataSet->PK_NO, 'seller' ]).'?payfrom=credit" class="link" title="seller actual credit balance (only verified)">'.number_format($dataSet->CUM_BALANCE,2).'</a>';
    //                         }
    //                     }else{
    //                         $credit = '<span>'.number_format($dataSet->CUM_BALANCE,2).'</span>';
    //                     }
    //                     return $credit;
    //                 })
    //                 ->addColumn('balance', function($dataSet){
    //                     $roles = userRolePermissionArray();
    //                     $balance = '';
    //                     if (hasAccessAbility('new_payment', $roles)) {
    //                         $buffer = $dataSet->CUM_BALANCE_BUFFER;
    //                         $actual = $dataSet->CUM_BALANCE_ACTUAL;
    //                         if($buffer == $actual){
    //                             $balance = '<span title="Actual balance & buffer balance is same (SUM)">'.number_format($dataSet->CUM_BALANCE_ACTUAL,2).'</span>';
    //                         }else{
    //                             $balance = '<span title="Actual balance (SUM)">'.number_format($dataSet->CUM_BALANCE_ACTUAL,2).'</span >/<span title="Buffer balance (SUM)">'. number_format($dataSet->CUM_BALANCE_BUFFER,2).'</span>';
    //                         }
    //                     }
    //                     return $balance;
    //                 })
    //                 ->addColumn('total_unverified', function($dataSet){
    //                     $roles = userRolePermissionArray();
    //                     $total_unverified = 0;
    //                     if (hasAccessAbility('new_payment', $roles)) {
    //                         $query = DB::table('ACC_SELLER_PAYMENTS')
    //                         ->select(DB::raw("sum(ACC_SELLER_PAYMENTS.MR_AMOUNT) as total_unverified"))
    //                         ->where('F_SHOP_NO',$dataSet->PK_NO)
    //                         ->where('PAYMENT_CONFIRMED_STATUS',0)
    //                         ->groupBy('ACC_SELLER_PAYMENTS.F_SHOP_NO')
    //                         ->first();
    //                         if($query){
    //                             $total_unverified = $query->total_unverified;
    //                         }
    //                         $total_unverified = number_format($total_unverified,2);
    //                     }
    //                     return $total_unverified;
    //                 })
    //                 ->addColumn('seller_no', function($dataSet){

    //                     $seller_no = '';
    //                         $seller_no = '<a href="#" class="" title="Customer No">'.$dataSet->SELLER_NO.'</a>';
    //                     return $seller_no;

    //                 })


    //                 ->rawColumns(['action','due', 'balance','seller_no','credit'])
    //                 ->make(true);
    // }






}
