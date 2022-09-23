<?php
namespace App\Repositories\Admin\BankState;
use DB;
use Auth;
use Importer;
use App\Traits\MAIL;
use App\Models\Customer;
use App\Models\Reseller;
use App\Models\AccBankTxn;
use App\Traits\RepoResponse;
use App\Models\BankStatement;
use App\Models\EmailNotification;
use App\Models\OrderPayment;

class BankStateAbstract implements BankStateInterface
{
    use RepoResponse;
    use MAIL;

    protected $statement;

    public function __construct(BankStatement $statement)
    {
        $this->statement = $statement;
    }

    public function getPaginatedList($request, int $per_page = 5)
    {
        if($request->status == 'draft'){
            $data = $this->statement->where('IS_DRAFT',1)->where('MARK_AS_USED',0)->orderBy('TXN_DATE', 'DESC')->get();
        }elseif($request->status == 'used'){
            $data = $this->statement->where('IS_DRAFT',0)
                    ->where('MARK_AS_USED',1)
                    ->orWhere('IS_MATCHED',1)
                    ->orderBy('TXN_DATE', 'DESC')->get();
        }else{
            $data = $this->statement->where('IS_DRAFT',0)
            ->where('IS_MATCHED',0)
            ->where('MARK_AS_USED',0)
            ->orderBy('TXN_DATE', 'DESC')
            ->get();

        }
        return $this->formatResponse(true, '', 'admin.account.list', $data);
    }


    public function postStore($request)
    {
        DB::beginTransaction();

        try {

            $importer = Importer::make('Csv');
            $filepath = $request->file('statement_file')->getRealPath();
            $importer->load($filepath);
            $collection = $importer->getCollection();
                if($collection){
                    foreach ($collection as $key => $value) {
                        if($key > 0 ){
                            $debit      = 0;
                            $credit     = 0;
                            $tran_date  = date('Y-m-d', strtotime($value[0]));

                            if($value[2] != ''){
                                $debit = filter_var($value[2], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                            }

                            if($value[3] != ''){
                                $credit = filter_var($value[3], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                            }

                            $insert_data[] = array(
                                'TXN_DATE'                  => $tran_date,
                                'NARRATION'                 => $value[1],
                                'DR_AMOUNT'                 => $debit,
                                'CR_AMOUNT'                 => $credit,
                                'SS_CREATED_ON'             => date('Y-m-d H:s:i'),
                                'F_SS_CREATED_BY'           => Auth::user()->PK_NO,
                                'F_ACC_BANK_PAYMENT_NO'     => $request->payment_acc_no,
                                'IS_MATCHED'                => 0,
                                'IS_DRAFT'                  => 1,
                                //'IS_VARIFIED'               => 0,
                            );
                        }
                    }
                    if(!empty($insert_data)){
                        BankStatement::insert($insert_data);
                    }

                }

            } catch (\Exception $e) {

                DB::rollback();
                return $this->formatResponse(false, $e->getMessage(), 'admin.bankstate.list');
        }
                DB::commit();

            return $this->formatResponse(true, 'Bank statement uploaded successfully !', 'admin.bankstate.list');

    }

    public function postDraftToSave($request)
    {
        DB::beginTransaction();
        try {
            $draft_decords_array = $request->draft;
            BankStatement::whereIn('PK_NO', $draft_decords_array)->update(['IS_DRAFT' => 0]);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), 'admin.bankstate.list');
        }
        DB::commit();
        return $this->formatResponse(true, 'Bank statements save from draft successfully !', 'admin.bankstate.list');


    }

    public function delete($PK_NO)
    {   DB::beginTransaction();
        try {
                BankStatement::where('PK_NO',$PK_NO)->where('IS_MATCHED',0)->delete();
            } catch (\Exception $e) {
                DB::rollback();
                return $this->formatResponse(false, $e->getMessage(), 'admin.bankstate.list');
            }
                DB::commit();
                return $this->formatResponse(true, 'Bank statement deleted successfully !', 'admin.bankstate.list');
    }

    public function postDeleteBulk($request)
    {
        DB::beginTransaction();
        try {
                BankStatement::whereIn('PK_NO',$request->pk_no)->where('IS_MATCHED',0)->delete();
            } catch (\Exception $e) {
                DB::rollback();
                return $this->formatResponse(false, $e->getMessage(), 'admin.bankstate.list');
            }
                DB::commit();
                return $this->formatResponse(true, 'Bank statement deleted successfully !', 'admin.bankstate.list');
    }


    public function postMarkAsUsed($request)
    {   DB::beginTransaction();
        try {
            $draft_decords_array = $request->draft;
            BankStatement::whereIn('PK_NO', $draft_decords_array)->update(['MARK_AS_USED' => 1]);

        } catch (\Exception $e) {

            DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), 'admin.bankstate.list');
        }
            DB::commit();

        return $this->formatResponse(true, 'Bank statements save from draft successfully !', 'admin.bankstate.list');


    }

    public function postVerify($request)
    {
        DB::beginTransaction();
        try {
            $bs_pk_bo   = $request->bs_pk_no;
            $cp_pk_bo   = $request->cp_pk_no;
            $payment    = AccBankTxn::where('PK_NO',$cp_pk_bo)->where('IS_MATCHED', 0)->first();
            $bank_state  = BankStatement::where('PK_NO',$bs_pk_bo)->where('IS_MATCHED', 0)->first();
            if ($payment != null && $bank_state != null ) {
                DB::statement('CALL PROC_CUSTOMER_PAYMENT_VERIFY(:cp_pk_bo, :bs_pk_bo );',array($cp_pk_bo,$bs_pk_bo));
                if (isset($payment->F_RESELLER_NO)) {
                    $order_payments = OrderPayment::where('F_ACC_RESELLER_PAYMENT_NO',$payment->F_RESELLER_PAYMENT_NO)->get();
                    $customer_add = Reseller::where('PK_NO',$payment->F_RESELLER_NO)->first();
                    $pay_pk_no = $payment->F_RESELLER_PAYMENT_NO;
                }else{
                    $order_payments = OrderPayment::where('F_ACC_CUSTOMER_PAYMENT_NO',$payment->F_CUSTOMER_PAYMENT_NO)->get();
                    $customer_add = Customer::where('PK_NO',$payment->F_CUSTOMER_NO)->first();
                    $pay_pk_no = $payment->F_CUSTOMER_PAYMENT_NO;
                }
                if(isset($order_payments) && !empty($order_payments)){
                    foreach ($order_payments as $key => $value) {
                        if($value->order->DELIVERY_EMAIL != '' && !empty($value->order->DELIVERY_EMAIL)){
                            $email = new EmailNotification();
                            $email->TYPE = 'Order Payment';
                            $email->F_SS_CREATED_BY = Auth::user()->PK_NO;
                            $email->MOBILE_NO = ($value->order->to_country->DIAL_CODE ?? '').($value->order->DELIVERY_MOBILE ?? '');
                            $email->EMAIL = $value->order->DELIVERY_EMAIL ?? '';
                            $email->F_BOOKING_NO = $value->order->F_BOOKING_NO;
                            if($value->order->IS_RESELLER == 0){
                                $email->CUSTOMER_NO = $value->order->F_CUSTOMER_NO;
                                $email->IS_RESELLER = 0;
                            }else{
                                $email->RESELLER_NO = $value->order->F_RESELLER_NO;
                                $email->IS_RESELLER = 1;
                            }
                            $email->save();
                            $mail_body = $this->getEmailBody($email,$pay_pk_no);
                            $mail_body = view('admin.Mail.order_payment')
                            ->with('rows', $mail_body)
                            ->render();
                            $email->BODY = $mail_body;
                            $email->save();
                        }
                    }
                }else{
                    if($customer_add->EMAIL != '' && !empty($customer_add->EMAIL)){
                        $email = new EmailNotification();
                        $email->TYPE = 'Payment Confirmation';
                        $email->F_SS_CREATED_BY = 1;
                        $email->MOBILE_NO = ($customer_add->country->DIAL_CODE ?? '').($customer_add->MOBILE_NO ?? '');
                        $email->EMAIL = $customer_add->EMAIL ?? '';
                        if(isset($payment->F_RESELLER_NO)){
                            $email->RESELLER_NO = $payment->F_RESELLER_NO;
                            $email->IS_RESELLER = 1;
                        }else{
                            $email->CUSTOMER_NO = $payment->F_CUSTOMER_NO;
                            $email->IS_RESELLER = 0;
                        }
                        $email->save();
                        if(isset($payment->F_RESELLER_NO)){
                            $mail_body = $this->getEmailBody($email,$payment->F_RESELLER_PAYMENT_NO);
                        }else{
                            $mail_body = $this->getEmailBody($email,$payment->F_CUSTOMER_PAYMENT_NO);
                        }
                        $mail_body = view('admin.Mail.payment_verified')
                        ->with('rows', $mail_body)
                        ->render();
                        $email->BODY = $mail_body;
                        $email->save();
                    }
                }
                $msg = 1;
            }else{
                $msg = 2;
            }

        } catch (\Exception $e) {
        DB::rollback();
            $msg = 0;
            dd($e);
            return $this->formatResponse(false, '', 'admin.bankstate.verification');
        }
        DB::commit();
        return $this->formatResponse(true, '', 'admin.bankstate.verification');
    }


    public function getUnVerify($id)
    {
        DB::beginTransaction();
        try {
            DB::statement('CALL PROC_CUSTOMER_PAYMENT_UNVERIFY(:bs_pk_bo );',array($id));
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), 'admin.bankstate.verification');
        }
        DB::commit();
        return $this->formatResponse(true, 'Bank statements Unverified successfully !', 'admin.bankstate.verification');
    }






}


