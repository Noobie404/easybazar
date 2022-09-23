<?php

namespace App\Models;

use App\User;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class DeliveryBoy extends Model
{
    protected $table = 'SLS_DELIVERY_BOY';
    protected $primaryKey 	= 'PK_NO';
    public $timestamps 		= false;
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
        public function getEdit($id){
            DB::beginTransaction();
            try {
            $data['row']             = User::where('PK_NO',$id)->first();

            $html = view('admin.delivery_boy.edit')->with('data',$data)->render();
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return $this->successResponse($e->getCode(), 'Area not saved !', '', 0);
            }
            DB::commit();
            return $this->successResponse(200, 'Area sucessfully save!', $html, 1);
        }
        public function getCreate(){
            DB::beginTransaction();
            try {
            $data['countryCombo']   = Country::pluck('NAME', 'PK_NO');
            $data['stateCombo']     = State::pluck('STATE_NAME', 'PK_NO');
            $data['sellers']        = Seller::where('USER_TYPE',10)->pluck('NAME', 'PK_NO');
            $data = view('admin.delivery_boy.create')->withData($data)->render();
            } catch (\Exception $e) {
                dd($e->getMessage());
                DB::rollback();
                return $this->successResponse($e->getCode(), 'Area not saved !', '', 0);
            }
                DB::commit();
                return $this->successResponse(200, 'Area sucessfully save!', $data, 1);
        }

}
