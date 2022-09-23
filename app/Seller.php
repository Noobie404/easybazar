<?php

namespace App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Seller extends Authenticatable
{
    protected $guard        = 'seller';
    protected $table        = 'SLS_SELLERS';
    protected $primaryKey   = 'PK_NO';
    const CREATED_AT        = 'SS_CREATED_ON';
    const UPDATED_AT        = 'SS_MODIFIED_ON';


    protected $fillable = [
        'NAME','EMAIL','PASSWORD'
    ];

    protected $hidden = [
        'PASSWORD', 'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->PASSWORD;
    }

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
}
