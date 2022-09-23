<?php
namespace App\Repositories\Admin\MerchantBill;

use DB;
use App\Models\Merchant;
use App\Models\MerchantBill;
use App\Traits\RepoResponse;
use App\Models\AuthUserGroup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MerchantBillAbstract implements MerchantBillInterface
{
    use RepoResponse;

    protected $merchant_bill;

    public function __construct(MerchantBill $merchant_bill)
    {
        $this->merchant_bill = $merchant_bill;
    }

    public function getPaginatedList($request, int $per_page = 5)
    {
        $data = $this->merchant_bill->select('SC_MERCHANT_BILL.*', 'SLS_MERCHANT.NAME as MERCHANT_NAME')->leftJoin('SLS_MERCHANT', 'SC_MERCHANT_BILL.F_MERCHANT_NO', 'SLS_MERCHANT.PK_NO')->orderBy('SC_MERCHANT_BILL.PK_NO', 'ASC')->get();
        return $this->formatResponse(true, '', 'merchant.list', $data);
    }



    public function postStore($request)
    {

        DB::beginTransaction();
        try {
            $item                  = new MerchantBill();
            $item->F_SHIPMENT_NO   = $request->shipment_no;
            $item->GENERATE_DATE   = date('Y-m-d H:i:s');
            $item->AMOUNT          = $request->amount;
            $item->DISCOUNT        = 0;
            $item->NET_AMOUNT      = $request->amount;
            $item->F_MERCHANT_NO   = $request->f_merchant_no;
            $item->SUBMIT_DATE     = null;
            $item->DUE_AMOUNT      = $request->amount;
            $item->PAID_AMOUNT      = 0;
            $item->STATUS          = 0;
            $item->TO_DATE         = date('Y-m-d', strtotime($request->to_date));
            $item->FROM_DATE       = date('Y-m-d', strtotime($request->from_date));
            $item->save();

            if($request->pk_no){
                foreach ($request->pk_no as $key => $value) {
                    DB::table('SC_MERCHANT_BILL_DETAILS')->insert(['F_MERCHANT_BILL_NO' => $item->PK_NO, 'F_MERCHANT_NO' => $request->f_merchant_no, 'F_MER_PRC_STOCK_IN_NO' => $value]);
                    DB::table('MER_PRC_STOCK_IN')->where('PK_NO', $value)->update(['IS_PAID' => 1]);
                }
            }


        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), 'admin.invoice');
        }
        DB::commit();
        return $this->formatResponse(true, 'Merchant bill has been created successfully !', 'admin.invoice');
    }


    public function postUpdate($request, $id)
    {
        DB::beginTransaction();
        try {
            if($request->pay_amount > 0){
                $created_by = Auth::id();
                $item       = MerchantBill::find($id);
                $merchant   = Merchant::find($item->F_MERCHANT_NO);

                if($merchant->CUM_BALANCE - $merchant->CUM_BALANCE_USED >= $request->pay_amount ){

                    $item->DISCOUNT        = $request->discount;
                    $item->NET_AMOUNT      = $item->AMOUNT - $request->discount;
                    $item->PAID_AMOUNT     = $item->PAID_AMOUNT + $request->pay_amount;
                    $item->DUE_AMOUNT      = $item->AMOUNT - $request->discount - ($item->PAID_AMOUNT + $request->pay_amount) ;
                    $item->STATUS          = 1;
                    $item->BILL_DATE       = date('Y-m-d', strtotime($request->invoice_date));
                    $item->update();

                    DB::table('ACC_MERCHANT_BILL_PAYMENT')->insert(['F_BILL_NO' => $id, 'PAYMENT_DATE' => NOW(), 'AMOUNT' =>  $request->pay_amount, 'F_MERCHANT_NO' => $item->F_MERCHANT_NO, 'F_SS_CREATED_BY' => $created_by, 'SS_CREATED_ON' => NOW() ]);

                    $merchant->CUM_BALANCE_USED = $merchant->CUM_BALANCE_USED + $request->pay_amount;
                    $merchant->update();
                }else{
                    return $this->formatResponse(false, 'Balance not available', 'admin.mer_bill.list');
                }

            }

        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), 'admin.mer_bill.list');
        }
        DB::commit();
        return $this->formatResponse(true, 'Merchant bill has been updated successfully !', 'admin.mer_bill.list');
    }



    public function getDelete($id)
    {
        $accSource = MerchantBill::where('PK_NO',$id)->first();
        if($accSource->STATUS > 0 ){
            return $this->formatResponse(false, 'Merchant bill already processed so delete not possible !', 'admin.mer_bill.list');
        }

        DB::beginTransaction();
        try {
            $bill_invoice = DB::table('SC_MERCHANT_BILL_DETAILS')->where('F_MERCHANT_BILL_NO',$id)->get();
            if($bill_invoice){
                foreach ($bill_invoice as $key => $value) {
                    DB::table('MER_PRC_STOCK_IN')->where('PK_NO', $value->F_MER_PRC_STOCK_IN_NO)->update(['IS_PAID' => 0]);
                    DB::table('SC_MERCHANT_BILL_DETAILS')->where('PK_NO',$value->PK_NO)->delete();

                }
            }
            MerchantBill::where('PK_NO',$id)->delete();

        } catch (\Exception $e) {

            DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), 'admin.mer_bill.list');
        }
        DB::commit();
        return $this->formatResponse(true,'Merchant bill deleted successfully !','admin.mer_bill.list');
    }


}
