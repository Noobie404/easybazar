<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class AdminUser extends Model
{
    protected $table        = 'SA_USER';
    protected $primaryKey   = 'PK_NO';
    public $timestamps      = false;

    public function getUserCombo(){
        return AdminUser::select(
            DB::raw("CONCAT(first_name,' ',last_name) AS name"),'id'
        )
        -> pluck('name', 'id');
    }

    public function user_fullname($id)
    {
        $user_name = AdminUser::select("first_name","last_name", DB::raw("CONCAT(first_name,' ',last_name) AS full_name"))->first();
        return $user_name;
    }
}
