<?php

namespace App\Models;

use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class DeliverySchedule extends Model
{
    protected $table = 'SLS_DELIVERY_SCHEDULE';
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


    public function getCreate(){
        DB::beginTransaction();
        try {
        $data['sellers']        = Seller::where('USER_TYPE',10)->where('F_PARENT_USER_ID',0)->pluck('SHOP_NAME', 'PK_NO');
        $data = view('admin.delivery-schedule.create')->withData($data)->render();
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return $this->successResponse($e->getCode(), 'Area not saved !', '', 0);
        }
            DB::commit();
            return $this->successResponse(200, 'Area sucessfully save!', $data, 1);
    }

    public function postStore($request)
    {
        // dd($request->all());
        DB::begintransaction();
        try {

               if(!is_null($request->from_time[0])){
                $count = count($request->from_time);

                $data = array();
                for($i=0; $i<$count; $i++)
                {
                  if(!empty($request->from_time[$i])){
                    array_push($data, [
                      'SLOT_TITLE'      => $request->slot_title[$i],
                      'SLOT_FROM'       => date('H:i:s A',strtotime($request->from_time[$i])),
                      'SLOT_TO'         => date('H:i:s A',strtotime($request->to_time[$i])),
                      'SLOT_TYPE'       => 1,
                      'IS_ACTIVE'       => 1,
                      'F_SS_CREATED_BY' => Auth::user()->PK_NO,
                      'SS_CREATED_ON'   => date("Y-m-d h:i:s", time()),
                    ]);
                  }
                }
               DB::table('SLS_DELIVERY_SCHEDULE')->insert($data);
              }
            // $html = view('admin.address.city.view')->withRow($city)->render();
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return $this->successResponse($e->getCode(), 'Delivery schedule not saved!', '', 0);
        }
            DB::commit();
            return $this->successResponse(200, 'Delivery schedule sucessfully save!', $data, 1);
    }

    public function postGenerate($request)
    {
        $f_shop_no = $request->f_shop_no;
        $gen_date = $request->gen_date;
        $shop = Seller::find($f_shop_no);
        DB::begintransaction();
        try {

            $schedules = DB::table('SLS_DELIVERY_SCHEDULE')->where('F_SHOP_NO',$f_shop_no)->where('DELIVERY_DATE','=',date('Y-m-d'))->get();

            foreach ($schedules as $key => $schedule) {
                $data = new DeliverySchedule();
                $data->DELIVERY_DATE = date('Y-m-d',strtotime($gen_date));
                $data->F_SHOP_NO = $f_shop_no;
                $data->SHOP_NAME = $shop->SHOP_NAME;
                $data->SLOT_TITLE = $schedule->SLOT_TITLE;
                $data->SLOT_FROM = $schedule->SLOT_FROM;
                $data->SLOT_TO = $schedule->SLOT_TO;
                $data->SLOT_TYPE = $schedule->SLOT_TYPE;
                $data->IS_ACTIVE = 1;
                $data->F_SS_CREATED_BY = Auth::user()->PK_NO;
                $data->SS_CREATED_ON =date("Y-m-d h:i:s", time());
                $data->save();
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return $this->successResponse($e->getCode(), 'Delivery schedule not saved!', '', 0);
        }
            DB::commit();
            return $this->successResponse(200, 'Delivery schedule sucessfully save!', [], 1);
    }

    public function getDelete($request,$schedule_id){

        DB::begintransaction();
        try {
        $schedules = DB::table('SLS_DELIVERY_SCHEDULE')->where('PK_NO',$schedule_id)->delete();

        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return $this->successResponse(200, 'unable  delete!', '', 0);
        }
            DB::commit();
        return $this->successResponse(200, 'Delivery schedule deleted!',$schedules,1);
    }



}
