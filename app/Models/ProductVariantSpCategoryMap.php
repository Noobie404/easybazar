<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Auth;

class ProductVariantSpCategoryMap extends Model
{

    protected $table        = 'PRD_VARIANT_SPCATEGORY_MAP';
    protected $primaryKey   = 'PK_NO';
    const CREATED_AT        = 'SS_CREATED_ON';
    const UPDATED_AT        = 'SS_MODIFIED_ON';

    protected $fillable = [ 'NAME'];

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
