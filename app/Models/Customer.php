<?php

namespace App\Models;
use App\Models\State;
use App\Models\Seller;
use App\Models\BankAccount;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
class Customer extends Model
{
    use ApiResponse;
    protected $table 		= 'SLS_CUSTOMERS';
    protected $primaryKey   = 'PK_NO';
    //public $timestamps      = false;
    const CREATED_AT        = 'SS_CREATED_ON';
    const UPDATED_AT        = 'SS_MODIFIED_ON';

    protected $fillable = ['NAME'];

    public function getCustomerCombo(){
        return Customer::where('IS_ACTIVE', 1)->pluck('NAME', 'PK_NO');
    }

    public function getCustomerCombo20(){
        return Customer::where('IS_ACTIVE', 1)->pluck('NAME', 'PK_NO')->take(5);
    }

    public function address() {
        return $this->hasMany('App\Models\CustomerAddress', 'F_CUSTOMER_NO', 'PK_NO');
    }

    public function agent() {
        return $this->belongsTo('App\Models\Agent', 'F_SALES_AGENT_NO', 'PK_NO')->orderBy('NAME','ASC');
    }

    public function reseller() {
        return $this->belongsTo('App\Models\Reseller', 'F_RESELLER_NO', 'PK_NO');
    }

    public function country() {
        return $this->hasOne('App\Models\Country', 'PK_NO', 'F_COUNTRY_NO');
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


   public function getCreate(){
    DB::beginTransaction();
    try {
        $data['seller_combo']= Seller::where('F_PARENT_USER_ID',0)->pluck('NAME', 'PK_NO');
        $html = view('admin.customer._create_modal_body')->with('data',$data)->render();
    } catch (\Exception $e) {
        dd($e->getMessage());
        DB::rollback();
        return $this->successResponse($e->getCode(), 'Customer not found !', '', 0);
        }
        DB::commit();
        return $this->successResponse(200, 'Customer found!', $html, 1);
    }




   public function getAjaxEdit($id){
    DB::beginTransaction();
    try {
        $row            = Customer::find($id);
        $data['seller_combo']= Seller::where('F_PARENT_USER_ID',0)->pluck('NAME', 'PK_NO');
        $html = view('admin.customer._edit_modal_body')->with('data',$data)->with('row',$row)->render();
    } catch (\Exception $e) {
        dd($e->getMessage());
        DB::rollback();
        return $this->successResponse($e->getCode(), 'Customer not found !', '', 0);
        }
        DB::commit();
        return $this->successResponse(200, 'Customer found!', $html, 1);
    }




}
