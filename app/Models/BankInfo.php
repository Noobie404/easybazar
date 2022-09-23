<?php

namespace App\Models;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class BankInfo extends Model
{
    protected $table        = 'SELLER_BANK_INFO';
    protected $primaryKey   = 'PK_NO';
    const CREATED_AT        = 'SS_CREATED_ON';
    const UPDATED_AT        = 'SS_MODIFIED_ON';

    protected $fillable = [
        'ACC_TITLE','ACC_NO','BANK_NAME'
    ];




//     public function getSellerCombo(){
//         return Seller::where('IS_ACTIVE', 1)->where('FK_PARENT_USER_NO',0)->pluck('NAME', 'PK_NO');
//     }

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
