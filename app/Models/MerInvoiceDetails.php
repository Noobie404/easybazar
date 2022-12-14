<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Auth;

class MerInvoiceDetails extends Model
{


    protected $table = 'MER_PRC_STOCK_IN_DETAILS';

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

    public function invoice()
    {
        return $this->hasOne('App\Models\MerInvoice', 'PK_NO','F_PRC_STOCK_IN');
    }





}
