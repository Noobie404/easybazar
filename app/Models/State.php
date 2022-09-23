<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\RepoResponse;
use App\Traits\ApiResponse;
use DB;
use Auth;

class State extends Model
{
    use RepoResponse;
    use ApiResponse;
    protected $table = 'SS_STATE';
    protected $primaryKey 	= 'PK_NO';
    public $timestamps 		= false;
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

    public function getRegionList($request)
    {
        $data['countryCombo']   = Country::pluck('NAME', 'PK_NO');
        $data['stateCombo']     = State::pluck('STATE_NAME', 'PK_NO');
        $data['states'] = State::select('SS_STATE.*','c.NAME')->leftjoin('SS_COUNTRY as c','c.PK_NO','SS_STATE.F_COUNTRY_NO')->paginate(20);
        return $this->formatResponse(true, 'Data Found', 'admin.address.region.index',$data);
    }

    public function getStateCombo(){
        return State::pluck('STATE_NAME', 'PK_NO');
    }

    public function city() {
        return $this->hasOne('App\Models\City', 'F_STATE_NO', 'PK_NO');
    }

    public function getStateByCountry($id)
    {
         $data = State::where('F_COUNTRY_NO',$id)->get();
         $response = null;

            if ($data->count() > 0) {
                foreach ($data as $value) {
                    $response .= '<option value="'.$value->PK_NO.'">'.$value->STATE_NAME.'</option>';
                }
            }else{
                $response .= '<option value="">No state found</option>';
            }
        return $response;
    }

    public function getStateByCity($id)
    {
         $data = DB::table('SS_CITY')->select('PK_NO','CITY_NAME')->where('IS_ACTIVE',1)->where('F_STATE_NO',$id)->get();
         $response = '';
            if ($data->count() > 0) {
                $response = '<option value="">Select city</option>';
                foreach ($data as $value) {
                    $response .= '<option value="'.$value->PK_NO.'">'.$value->CITY_NAME.'</option>';
                }
            }else{
                $response .= '<option value="">No city found</option>';
            }
        return $response;
    }

    public function postRegion($request){
        $data = '';
        DB::beginTransaction();
        try {
        $region                 = new State();
        $region->STATE_NAME     = $request->region;
        $region->STATE_NAME_BN  = $request->bn_region;
        $region->LATITUDE       = $request->latitude;
        $region->LONGITUDE      = $request->longitude;
        $region->MIN_LAT        = $request->min_latitude;
        $region->MIN_LON        = $request->min_longitude;
        $region->MAX_LAT        = $request->max_latitude;
        $region->MAX_LON        = $request->max_longitude;
        $region->NW_LAT         = $request->nw_latitude;
        $region->NW_LON         = $request->nw_longitude;
        $region->SW_LAT         = $request->sw_latitude;
        $region->SW_LON         = $request->sw_longitude;
        $region->SE_LAT         = $request->se_latitude;
        $region->SE_LON         = $request->se_longitude;
        $region->NE_LAT         = $request->ne_latitude;
        $region->NE_LON         = $request->ne_longitude;
        $region->F_COUNTRY_NO   = $request->country ?? 1;
        $region->IS_ACTIVE      = $request->is_active ?? 1;
        $region->F_SS_CREATED_BY = Auth::user()->PK_NO;
        $region->SS_CREATED_ON  = date('Y-m-d H:i:s');
        $region->save();
        $data = view('admin.address.region.view')->withRow($region)->render();
    } catch (\Exception $e) {
        DB::rollback();
        return $this->successResponse($e->getCode(), 'Region not saved !', '', 0);
    }
        DB::commit();
        return $this->successResponse(200, 'Region sucessfully save!', $data, 1);
    }

    public function getRegion($request,$id){

        DB::beginTransaction();
        try {

        $data['region']         = State::find($id);
        $data['countryCombo']   = Country::pluck('NAME', 'PK_NO');

        $html = view('admin.address.region.edit')->withData($data)->render();

        } catch (\Exception $e) {
            DB::rollback();
            return $this->successResponse(200, 'Region not created !', null, 0);
        }
        DB::commit();
        return $this->successResponse(200, 'Region has been created successfully ! !', $html, 1);

    }


    public function updateRegion($request){
        $data = [];
        DB::beginTransaction();
        try {
            $region                 = State::find($request->id);
            $region->F_COUNTRY_NO   = $request->country ?? 1;
            $region->STATE_NAME     = $request->region;
            $region->STATE_NAME_BN  = $request->bn_region;
            $region->LATITUDE       = $request->latitude;
            $region->LONGITUDE      = $request->longitude;
            $region->MIN_LAT        = $request->min_latitude;
            $region->MIN_LON        = $request->min_longitude;
            $region->MAX_LAT        = $request->max_latitude;
            $region->MAX_LON        = $request->max_longitude;
            $region->NW_LAT         = $request->nw_latitude;
            $region->NW_LON         = $request->nw_longitude;
            $region->SW_LAT         = $request->sw_latitude;
            $region->SW_LON         = $request->sw_longitude;
            $region->SE_LAT         = $request->se_latitude;
            $region->SE_LON         = $request->se_longitude;
            $region->NE_LAT         = $request->ne_latitude;
            $region->NE_LON         = $request->ne_longitude;
            $region->IS_ACTIVE      = $request->is_active ?? 1;
            $region->F_SS_MODIFIED_BY = Auth::user()->PK_NO;
            $region->SS_MODIFIED_ON = date('Y-m-d H:i:s');
            $region->update();
            $data['region'] =$region;
            $data['html'] = view('admin.address.region.view')->withRow($region)->render();
     } catch (\Exception $e) {
        DB::rollback();
        return $this->successResponse($e->getCode(), 'State not saved !', '', 0);
    }
        DB::commit();
        return $this->successResponse(200, 'State sucessfully save!', $data, 1);
    }

    public function getRegionDelete($id){
        DB::beginTransaction();
        try {
            $region = State::find($id);
            $region->delete();

    } catch (\Exception $e) {
        DB::rollback();
        return $this->successResponse($e->getCode(), 'Area not Deleted !', '', 0);
        }
        DB::commit();
        return $this->successResponse(200, 'Area sucessfully Deleted!', $region, 1);
    }

    public function getRegionCreate(){
        DB::beginTransaction();
        try {
            $data['countryCombo']   = Country::pluck('NAME', 'PK_NO');
            $data['stateCombo']     = State::pluck('STATE_NAME', 'PK_NO');
            $data = view('admin.address.region.create')->withData($data)->render();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->successResponse($e->getCode(), 'Area not saved !', '', 0);
        }
            DB::commit();
        return $this->successResponse(200, 'Area sucessfully save!', $data, 1);
    }
}
