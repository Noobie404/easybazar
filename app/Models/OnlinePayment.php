<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Auth;

class OnlinePayment extends Model
{

    protected $table        = 'ACC_ONLINE_PAYMENT_TXN';
    protected $primaryKey   = 'PK_NO';
    // public $timestamps      = false;
    const CREATED_AT     = 'SS_CREATED_ON';
    const UPDATED_AT     = 'SS_MODIFIED_ON';

    public function customerPayment() {
        return $this->hasOne('App\Models\PaymentCustomer', 'SLIP_NUMBER', 'TRANSACTION_ID');
    }

    public function resellerPayment() {
        return $this->hasOne('App\Models\PaymentReseller', 'SLIP_NUMBER', 'TRANSACTION_ID');
    }

    public function installmentPayment() {
        return $this->hasOne('App\Models\InstallmentRecord', 'ORDER_GROUP_ID', 'ORDER_GROUP_ID')->where('IS_PAID',0);
    }

    public function booking() {
        return $this->hasOne('App\Models\Booking', 'PK_NO', 'F_BOOKING_NO');
    }

    public function getOrder() {
        return $this->hasOne('App\Models\Order', 'ORDER_GROUP_ID', 'ORDER_GROUP_ID');
    }
}
