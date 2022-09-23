<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Auth;

class ProductMasterCategoryMap extends Model
{

    protected $table        = 'PRD_MASTER_CATEGORY_MAP';
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

    public function category() {
        return $this->hasOne('App\Models\Category', 'PK_NO','F_PRD_CATEGORY_ID');
    }

    public function productColor() {
        return $this->hasMany('App\Models\Color', 'F_BRAND')->where('IS_ACTIVE',1)->orderBy('NAME','ASC');
    }

    public function productSize() {
        return $this->hasMany('App\Models\ProductSize', 'F_BRAND_NO')->where('IS_ACTIVE',1)->orderBy('NAME','ASC');
    }
}
