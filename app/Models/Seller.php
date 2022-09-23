<?php

namespace App\Models;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use Sortable;

    use Sortable;
    protected $table        = 'SA_USER';
    protected $primaryKey   = 'PK_NO';
    const CREATED_AT        = 'CREATED_AT';
    const UPDATED_AT        = 'UPDATED_AT';

    protected $fillable = ['NAME','EMAIL','PASSWORD', 'MOBILE_NO','USER_TYPE','F_USER_GROUP_NO'];
    protected $hidden = ['PASSWORD', 'remember_token'];
    public $sortable = ['CODE','NAME','EMAIL','MOBILE_NO','F_USER_GROUP_NO','STATUS'];


    public function getSellerCombo(){
        return Seller::where('IS_ACTIVE', 1)->where('USER_TYPE',10)->where('F_PARENT_USER_ID',0)->pluck('NAME', 'PK_NO');
    }

//     public function getSellerComboCustomer(Type $var = null)
//     {
//         $response = '';
//         $data =  Seller::select('NAME','PK_NO')->get();
//         if ($data) {
//             foreach ($data as $value) {
//                 $response .= '<option value="'.$value->PK_NO.'">'.$value->NAME.'</option>';
//             }
//         }else{
//             $response .= '<option value="">No data found</option>';
//         }
//         return $response;
//     }

//     public function customer() {
//         return $this->hasMany('App\Models\Customer', 'F_SHOP_NO', 'PK_NO');
//     }

//     public function agent() {
//         return $this->hasOne('App\Models\Agent','PK_NO', 'F_PREFERRED_AGENT_NO');
//     }

//     public function state() {
//         return $this->hasOne('App\Models\State', 'PK_NO', 'STATE');
//     }

//     public function city() {
//         return $this->hasOne('App\Models\City', 'PK_NO', 'CITY');
//     }

    public function BusinessInfo() {
        return $this->belongsTo('App\Models\BusinessInfo', 'PK_NO', 'SELLER_NO');
    }

    public function BankInfo() {
        return $this->belongsTo('App\Models\BankInfo', 'PK_NO', 'SELLER_NO');
    }

    public function WarehousInfo() {
        return $this->belongsTo('App\Models\WarehousInfo', 'PK_NO', 'SELLER_NO');
    }

    public function UserGroup() {
        return $this->hasOne('App\Models\UserGroup', 'PK_NO', 'F_USER_GROUP_NO');
    }


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

}
