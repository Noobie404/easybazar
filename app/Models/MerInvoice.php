<?php

namespace App\Models;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class MerInvoice extends Model
{
    protected $table 		= 'MER_PRC_STOCK_IN';
	protected $primaryKey 	= 'PK_NO';
    const CREATED_AT     	= 'SS_CREATED_ON';
    const UPDATED_AT     	= 'SS_MODIFIED_ON';

    protected $fillable 	= ['PK_NO','CODE'];



    public static function boot()
    {
        parent::boot();
        static::creating(function($model)
        {
            $user = Auth::user();
            $model->F_SS_CREATED_BY = $user->PK_NO;
        });

        static::updating(function($model)
        {
            $user = Auth::user();
            $model->F_SS_MODIFIED_BY = $user->PK_NO;
        });
    }


    public function getInvoiceCombo(){
        return MerInvoice::pluck('INVOICE_NO', 'PK_NO')->where('IS_ACTIVE',1);
    }

    public function parentInvoice(){
        return $this->belongsTo('App\Models\MerInvoice', 'F_PARENT_PRC_STOCK_IN');
    }
    public function vendor(){
        return $this->belongsTo('App\Models\Vendor', 'F_VENDOR_NO');
    }
    public function user() {
        return $this->belongsTo('App\Models\Auth', 'F_SS_CREATED_BY');
    }

    public function merchant() {
        return $this->belongsTo('App\Models\Merchant', 'F_MERCHANT_NO');
    }

    public function allPhotos() {
        return $this->hasMany('App\Models\MerInvoiceImgLib', 'F_PRC_STOCK_IN_NO', 'PK_NO');
    }

    public function allPhotosShipInvoice() {
        return $this->hasMany('App\Models\MerInvoiceImgLib', 'F_PRC_STOCK_IN_NO', 'pkno');
    }

    public function get_account_name($source,$from_date,$to_date)
    {
        $data = MerInvoice::select('PAYMENT_ACC_NAME','F_PAYMENT_ACC_NO as account_no','INVOICE_CURRENCY'
        ,DB::raw('(select IFNULL(SUM(INVOICE_EXACT_VALUE),0)) as sub_total'))
        ->where('F_PAYMENT_SOURCE_NO',$source)
        ->whereBetween('INVOICE_DATE',[$from_date,$to_date])
        ->groupBy('F_PAYMENT_ACC_NO')->get();
        return json_decode($data);
    }

    public function get_payment_method($source,$account,$from_date,$to_date)
    {
        $data = MerInvoice::select('PAYMENT_METHOD_NAME','INVOICE_CURRENCY'
        ,DB::raw('(select IFNULL(SUM(INVOICE_EXACT_VALUE),0)) as amount'))
        ->where('F_PAYMENT_SOURCE_NO',$source)
        ->where('F_PAYMENT_ACC_NO',$account)
        ->whereBetween('INVOICE_DATE',[$from_date,$to_date])
        ->groupBy('F_PAYMENT_METHOD_NO')
        ->get();
        return json_decode($data);
    }

}
