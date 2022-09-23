<?php

namespace App\Models\Web;
use Auth;
use Illuminate\Database\Eloquent\Model;

class CustomLink extends Model
{
    protected $table        = 'WEB_CUSTOM_LINK_HIGHLIGHTER';
    protected $primaryKey   = 'PK_NO';
    public $timestamps      = false;
    const CREATED_AT        = 'CREATED_ON';
    const UPDATED_AT        = 'MODIFIED_ON';

    public static function boot()
    {
        parent::boot();
        static::creating(function($model)
        {
           $user = Auth::user();
           $model->CREATED_BY = $user->PK_NO;
        });

        static::updating(function($model)
        {
           $user = Auth::user();
           $model->MODIFIED_BY = $user->PK_NO;
        });
    }
}
