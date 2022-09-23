<?php

namespace App\Models;
use Auth;
use Illuminate\Database\Eloquent\Model;

class StockGeneration extends Model
{
    protected $table = 'INV_STOCK_PRC_STOCK_IN_MAP';

    protected $primaryKey 	= 'PK_NO';
    protected $fillable 	= ['PK_NO','F_PRC_STOCK_IN_NO','F_SHOP_NO'];
    public $timestamps 		= false;

	const CREATED_AT        = 'SS_CREATED_ON';
    const UPDATED_AT        = 'SS_MODIFIED_ON';

    public static function boot()
    {
        parent::boot();
        static::creating(function($model)
        {
           $user = Auth::user();
           $model->F_SS_CREATED_BY  = $user->PK_NO;
           $model->SS_CREATED_ON    = date('Y-m-d H:i:s');
        });

        static::updating(function($model)
        {
           $user = Auth::user();
           $model->F_SS_MODIFIED_BY = $user->PK_NO;
           $model->SS_MODIFIED_ON   = date('Y-m-d H:i:s');
        });
    }
}
