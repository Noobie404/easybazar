<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class PermissionGroup extends Model
{
    protected $table = 'SA_PERMISSION_GROUP';
    protected $primaryKey   = 'PK_NO';

    const CREATED_AT        = 'CREATED_AT';
    const UPDATED_AT        = 'UPDATED_AT';

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
            $model->UPDATED_BY = $user->PK_NO;
        });
    }
    public function permissions() {
        return $this->hasMany('App\Models\Permission','F_PERMISSION_GROUP_NO','PK_NO');
    }
}
