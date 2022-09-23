<?php

namespace App\Models;
use DB;
use App\Traits\ApiResponse;
use App\Traits\RepoResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class ShopVariant extends Model
{

    protected $table = 'PRD_SHOP_VARIANT_MAP';
    protected $primaryKey 	= 'PK_NO';
    public $timestamps 		= false;
    use RepoResponse;
    use ApiResponse;

    const CREATED_AT = 'SS_CREATED_ON';
    const UPDATED_AT = 'SS_MODIFIED_ON';

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
