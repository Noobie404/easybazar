<?php

namespace App\Models;

use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'SS_CITY';
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
    public function getCityCombo(){
        return City::pluck('CITY_NAME', 'PK_NO');
    }

    public function PoCode() {
        return $this->hasOne('App\Models\PoCode', 'F_CITY_NO', 'PK_NO');
    }

    public function getCityByPostcode($post_code)
    {
         $data = PoCode::select('F_CITY_NO','CITY_NAME')->where('PO_CODE',$post_code)->get();
         $response = '<option value="">Select city</option>';
            if ($data->count() > 0) {
                foreach ($data as $value) {
                    $response .= '<option value="'.$value->F_CITY_NO.'">'.$value->CITY_NAME.'</option>';
                }
            }else{
                $response .= '<option value="">No state found</option>';
            }
        return $response;
    }

    public function getCitybyState($state_id)
    {
         $data = City::select('PK_NO','CITY_NAME')->where('F_STATE_NO',$state_id)->get();
         $response = null;

        if ($data->count() > 0) {
            foreach ($data as $value) {
                $response .= '<option value="'.$value->PK_NO.'">'.$value->CITY_NAME.'</option>';
            }
        }else{
            $response = '<option value="">No city found</option>';
        }
        return $response;
    }


    public function postCityAddress($request)
    {
        DB::begintransaction();
        try {
            $state = State::select('STATE_NAME')->where('PK_NO',$request->region)->first();
            $city                 = new City();
            $city->CITY_NAME      = $request->city;
            if(!empty($state)){
                $city->F_STATE_NO     = $request->region;
                $city->STATE_NAME     = $state->STATE_NAME;
            }
            $city->CITY_NAME_BN   = $request->bn_city;
            $city->LATITUDE       = $request->latitude;
            $city->LONGITUDE      = $request->longitude;
            $city->MIN_LAT        = $request->min_latitude;
            $city->MIN_LON        = $request->min_longitude;
            $city->MAX_LAT        = $request->max_latitude;
            $city->MAX_LON        = $request->max_longitude;
            $city->NW_LAT         = $request->nw_latitude;
            $city->NW_LON         = $request->nw_longitude;
            $city->SW_LAT         = $request->sw_latitude;
            $city->SW_LON         = $request->sw_longitude;
            $city->SE_LAT         = $request->se_latitude;
            $city->SE_LON         = $request->se_longitude;
            $city->NE_LAT         = $request->ne_latitude;
            $city->NE_LON         = $request->ne_longitude;
            $city->F_COUNTRY_NO   = $request->country ?? 1;
            $city->IS_ACTIVE      = $request->is_active ?? 1;
            $city->SS_CREATED_ON  = date('Y-m-d H:i:s');
            $city->F_SS_CREATED_BY= Auth::user()->PK_NO;
            $city->save();
            $html = view('admin.address.city.view')->withRow($city)->render();
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return $this->successResponse($e->getCode(), 'Area not saved !', '', 0);
        }
            DB::commit();
            return $this->successResponse(200, 'Area sucessfully save!', $html, 1);
    }

    public function getCityList()
    {
        DB::begintransaction();
        try {
        $data['city'] = City::select('SS_CITY.*','c.NAME')
                    ->leftjoin('SS_COUNTRY as c','c.PK_NO','SS_CITY.F_COUNTRY_NO')
                    ->get();
        $data['stateCombo']      = State::pluck('STATE_NAME', 'PK_NO');
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return $this->successResponse($e->getCode(), 'Area not saved !', '', 0);
        }
            DB::commit();
            return $this->successResponse(200, 'Area sucessfully save!', $data, 1);
        }
        public function getEditCity($id){
            DB::beginTransaction();
            try {
            $data['city']            = City::find($id);
            $data['stateCombo']      = State::pluck('STATE_NAME', 'PK_NO');
            $html = view('admin.address.city.edit')->with('data',$data)->render();
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return $this->successResponse($e->getCode(), 'Area not saved !', '', 0);
            }
            DB::commit();
            return $this->successResponse(200, 'Area sucessfully save!', $html, 1);
        }

        public function updateCity($request){
            $data = [];
            DB::beginTransaction();
            try {
                $state = State::select('STATE_NAME')->where('PK_NO',$request->region)->first();
                $city                 = City::find($request->id);
                $city->CITY_NAME      = $request->city;
                if(!empty($state)){
                    $city->F_STATE_NO     = $request->region;
                    $city->STATE_NAME     = $state->STATE_NAME;
                }
                $city->CITY_NAME_BN   = $request->bn_city;
                $city->LATITUDE       = $request->latitude;
                $city->LONGITUDE      = $request->longitude;
                $city->MIN_LAT        = $request->min_latitude;
                $city->MIN_LON        = $request->min_longitude;
                $city->MAX_LAT        = $request->max_latitude;
                $city->MAX_LON        = $request->max_longitude;
                $city->NW_LAT         = $request->nw_latitude;
                $city->NW_LON         = $request->nw_longitude;
                $city->SW_LAT         = $request->sw_latitude;
                $city->SW_LON         = $request->sw_longitude;
                $city->SE_LAT         = $request->se_latitude;
                $city->SE_LON         = $request->se_longitude;
                $city->NE_LAT         = $request->ne_latitude;
                $city->NE_LON         = $request->ne_longitude;
                $city->F_COUNTRY_NO   = $request->country ?? 1;
                $city->IS_ACTIVE      = $request->is_active ?? 1;
                $city->SS_MODIFIED_ON    = date('Y-m-d H:i:s');
                $city->F_SS_MODIFIED_BY  = Auth::user()->PK_NO;
                $city->update();
                $data['city'] = $city;
                $data['html'] = view('admin.address.city.view')->withRow($city)->render();
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return $this->successResponse($e->getCode(), 'City not updated !', '', 0);
        }
            DB::commit();
            return $this->successResponse(200, 'City sucessfully updated!', $data, 1);
        }

        public function getCityDelete($id){
            DB::beginTransaction();
            try {
                $city            = City::find($id);
                $city->delete();
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return $this->successResponse($e->getCode(), 'City not Deleted !', '', 0);
            }
            DB::commit();
            return $this->successResponse(200, 'City sucessfully Deleted!', $city, 1);
        }

        public function getCityCreate(){
            DB::beginTransaction();
            try {
            $data['countryCombo']   = Country::pluck('NAME', 'PK_NO');
            $data['stateCombo']     = State::pluck('STATE_NAME', 'PK_NO');
            $data = view('admin.address.city.create')->withData($data)->render();
            } catch (\Exception $e) {
                dd($e->getMessage());
                DB::rollback();
                return $this->successResponse($e->getCode(), 'Area not saved !', '', 0);
            }
                DB::commit();
                return $this->successResponse(200, 'Area sucessfully save!', $data, 1);
        }


}
