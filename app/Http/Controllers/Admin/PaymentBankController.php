<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Models\PaymentBankAcc;
use App\Http\Controllers\BaseController;
use App\Repositories\Admin\PaymentBank\PaymentBankInterface;

class PaymentBankController extends BaseController
{
    protected $paymentbank;
    public function __construct(PaymentBankInterface  $paymentbank )
    {
        $this->paymentbank         = $paymentbank;

    }

    public function getIndex(Request $request)
    {
        $this->resp = $this->paymentbank->getPaginatedList($request, 50);
        return view('admin.accounts.index')->withRows($this->resp->data);
    }

    /*
    public function bankBalance(Request $request)
    {
        $this->resp = $this->paymentbank->getPaginatedList($request, 50);
        return view('admin.accounts.balance')->withRows($this->resp->data);
    }
    */

    /*
    public function addBalance(Request $request)
    {
        $this->resp = $this->paymentbank->getPaginatedList($request, 50);
        return view('admin.accounts.add_balance')->withRows($this->resp->data);
    }
    */

    public function balanceTransfer(Request $request)
    {
        $this->resp = $this->paymentbank->getPaginatedList($request, 50);
        return view('admin.accounts.balance_transfer')->withRows($this->resp->data);
    }

    public function balanceTransferCreate(Request $request)
    {
        $this->resp = $this->paymentbank->getPaginatedList($request, 50);
        return view('admin.accounts.balance_transfer_create')->withRows($this->resp->data);
    }


    public function balanceHistory(Request $request)
    {
        $this->resp = $this->paymentbank->getPaginatedList($request, 50);
        return view('admin.accounts.balance_history')->withRows($this->resp->data);
    }

    public function paymentPurchase(Request $request)
    {
        $this->resp = $this->paymentbank->getPaginatedList($request, 50);
        return view('admin.accounts.payment_purchase')->withRows($this->resp->data);
    }

    public function paymentPurchaseCreate(Request $request)
    {
        $this->resp = $this->paymentbank->getPaginatedList($request, 50);
        return view('admin.accounts.payment_purchase_create')->withRows($this->resp->data);
    }

    public function paymentNonPurchase(Request $request)
    {
        $this->resp = $this->paymentbank->getPaginatedList($request, 50);
        return view('admin.accounts.payment_non_purchase')->withRows($this->resp->data);
    }




    public function getTransaction($id)
    {

        // $this->resp = $this->paymentbank->getTransaction($id);
        return view('admin.accounts.transaction');
    }


    public function getCreate()
    {
        // 0=admin, 20=delivery boy
        $cod_users = User::select('SA_USER.*','ACC_PAYMENT_BANK_ACC.F_USER_NO')
        ->whereIn('SA_USER.USER_TYPE', ['0','20'])
        ->leftJoin('ACC_PAYMENT_BANK_ACC','ACC_PAYMENT_BANK_ACC.F_USER_NO', '=',  'SA_USER.PK_NO')
        ->whereNull('ACC_PAYMENT_BANK_ACC.F_USER_NO')
        ->orderBy('SA_USER.NAME','ASC')
        ->get();
        // dd($cod_users);
        return view('admin.accounts.create')->withCodUser($cod_users);
    }
    public function getEdit($id)
    {
        $row = PaymentBankAcc::find($id);
        return view('admin.accounts.edit')->withRow($row);
    }

    public function postEdit(Request $request,$id)
    {
        $this->resp = $this->paymentbank->postEdit($request,$id);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function postStore(Request $request)
    {
        $this->resp = $this->paymentbank->postStore($request);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    // public function putUpdate(AccountRequest $request, $PK_NO) {

    //     $this->resp = $this->account->postUpdate($request, $PK_NO);

    //     return redirect()->back()->with($this->resp->redirect_class, $this->resp->msg);
    // }

    // public function getDelete($PK_NO) {

    //     $this->resp = $this->account->delete($PK_NO);

    //     return redirect()->back()->with($this->resp->redirect_class, $this->resp->msg);
    // }

}
