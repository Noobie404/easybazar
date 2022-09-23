<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class CouponChild extends Model
{
    protected $table = 'SLS_COUPON_CHILD';

    protected $primaryKey   = 'PK_NO';
    const CREATED_AT        = 'SS_CREATED_ON';
    const UPDATED_AT        = 'SS_MODIFIED_ON';

    private $user_id;
    public static function boot()
        {
           parent::boot();
           static::creating(function($model)
           {
               $user = Auth::user();
               $model->F_SS_CREATED_BY = $user->PK_NO ?? $model->getsetApiAuthId();
           });

           static::updating(function($model)
           {
               $user = Auth::user();
               $model->F_SS_MODIFIED_BY = $user->PK_NO ?? $model->getsetApiAuthId();
           });
       }

    public function setApiAuthId( $user_id )
    {
        $this->user_id = $user_id;
    }

    public function getsetApiAuthId()
    {
        return $this->user_id;
    }

    public function entryBy()
    {
        return $this->belongsTo('App\Models\Auth', 'F_SS_CREATED_BY');
    }
}
