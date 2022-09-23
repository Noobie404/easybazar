<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
class SpCategory extends Model
{
    protected $table        = 'PRD_SPECIAL_CATEGORY';
    protected $primaryKey   = 'PK_NO';
    const CREATED_AT        = 'SS_CREATED_ON';
    const UPDATED_AT        = 'SS_MODIFIED_ON';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'CODE', 'NAME', 'HS_PREFIX'
    ];

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

    public function getGallery() {
        return $this->hasMany('App\Models\Web\SliderPhoto', 'F_PRD_CATEGORY_ID');
    }
}
