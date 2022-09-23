<?php
namespace App\Repositories\Admin\PaymentBank;

use App\Models\PaymentBankAcc;
use App\Traits\RepoResponse;
use DB;

class PaymentBankAbstract implements PaymentBankInterface
{
    use RepoResponse;

    protected $account;

    public function __construct(PaymentBankAcc $account)
    {
        $this->account = $account;
    }

    public function getPaginatedList($request, int $per_page = 5)
    {
        $data = $this->account->where('IS_ACTIVE',1)->orderBy('BANK_NAME', 'ASC')->get();
        //dd($data);
        return $this->formatResponse(true, '', 'admin.accounts.list', $data);
    }

    public function postStore($request)
    {


        DB::beginTransaction();

        try {
            if($request->is_cod == 1){
                $cod_user = $request->cod_user;
            }else{
                $cod_user = null;
            }
            $account                  = new PaymentBankAcc();
            $account->BANK_NAME       = $request->bank_name;
            $account->BRANCH_NAME     = $request->branch_name;
            $account->BANK_ACC_NAME   = $request->bank_acc_name;
            $account->BANK_ACC_NO     = $request->bank_acc_no;
            $account->IS_COD          = $request->is_cod;
            $account->F_USER_NO       = $cod_user;
            $account->START_DATE      = date('Y-m-d',strtotime($request->date));
            $account->IS_ACTIVE       = 1;
            $account->save();

        } catch (\Exception $e) {

            DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), 'admin.accounts.list');
        }
        DB::commit();

        return $this->formatResponse(true, 'Account has been created successfully !', 'admin.accounts.list');
    }

    public function postEdit($request, $PK_NO)
    {
        $account                  = PaymentBankAcc::find($PK_NO);
        $account->BANK_NAME       = $request->bank_name;
        $account->BRANCH_NAME     = $request->branch_name;
        $account->BANK_ACC_NAME   = $request->bank_acc_name;
        $account->BANK_ACC_NO     = $request->bank_acc_no;
        $account->START_DATE      = date('Y-m-d',strtotime($request->date));
        $account->IS_ACTIVE       = $request->status;

        if ($account->update()) {
            return $this->formatResponse(true, 'Account has been Updated successfully', 'admin.accounts.list');
        }

        return $this->formatResponse(false, 'Unable to update Account !', 'admin.accounts.list');
    }

    /*
    public function delete($PK_NO)
    {
        $accSource = AccountSource::where('PK_NO',$PK_NO)->first();
        $accSource->IS_ACTIVE = 0;
        if ($accSource->update()) {
            return $this->formatResponse(true, 'Successfully deleted Payment Source', 'admin.account.list');
        }
        return $this->formatResponse(false,'Unable to delete Payment Source','admin.account.list');
    }
    */
}
