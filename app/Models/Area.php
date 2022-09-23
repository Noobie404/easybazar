<?php

namespace App\Models;
use DB;
use App\Traits\ApiResponse;
use App\Traits\RepoResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{

    protected $table = 'SS_AREA';
    protected $primaryKey 	= 'PK_NO';
    public $timestamps 		= false;
    use RepoResponse;
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

    public function getAreaList($request)
    {
        $data['area'] = Area::select('SS_AREA.*','c.NAME')
                    ->leftjoin('SS_COUNTRY as c','c.PK_NO','SS_AREA.F_COUNTRY_NO')
                    ->orderBy('STATE_NAME', 'ASC')
                    ->orderBy('CITY_NAME', 'ASC')
                    ->orderBy('AREA_NAME', 'ASC')
                    ->get();
        $data['countryCombo']   = Country::pluck('NAME', 'PK_NO');
        $data['stateCombo']     = State::pluck('STATE_NAME', 'PK_NO');
        return $this->formatResponse(true, 'Data Found', 'admin.address.area.index',$data);
    }

    public function postArea($request){
        DB::beginTransaction();
        try {
            $data = '';
            $area                 = new Area();
            $area->F_COUNTRY_NO   = 1;
            $area->AREA_NAME      = $request->area;
            if($request->city){
                $area->F_CITY_NO      = $request->city;
                $city = City::find($request->city);
                $area->CITY_NAME      = $city->CITY_NAME;
            }
            if($request->region){
                $area->F_STATE_NO     = $request->region;
                $state = State::find($request->region);
                $area->STATE_NAME     = $state->STATE_NAME;
            }
            $area->AREA_NAME_BN   = $request->bn_area;
            $area->LATITUDE       = $request->latitude;
            $area->LONGITUDE      = $request->longitude;
            $area->MIN_LAT        = $request->min_latitude;
            $area->MIN_LON        = $request->min_longitude;
            $area->MAX_LAT        = $request->max_latitude;
            $area->MAX_LON        = $request->max_longitude;
            $area->NW_LAT         = $request->nw_latitude;
            $area->NW_LON         = $request->nw_longitude;
            $area->SW_LAT         = $request->sw_latitude;
            $area->SW_LON         = $request->sw_longitude;
            $area->SE_LAT         = $request->se_latitude;
            $area->SE_LON         = $request->se_longitude;
            $area->NE_LAT         = $request->ne_latitude;
            $area->NE_LON         = $request->ne_longitude;
            $area->IS_ACTIVE      = $request->is_active ?? 1;
            $area->SS_CREATED_ON  = date('Y-m-d H:i:s');
            $area->F_SS_CREATED_BY= Auth::user()->PK_NO;
            $area->save();
            $data = view('admin.address.area.view')->withRow($area)->render();
    } catch (\Exception $e) {
        dd($e->getMessage());
        DB::rollback();
        return $this->successResponse($e->getCode(), 'Area not saved !', '', 0);
    }
        DB::commit();
        return $this->successResponse(200, 'Area sucessfully save!', $data, 1);
    }

        public function updateArea($request){
            $data = [];
            DB::beginTransaction();
            try {
                $area                   = Area::find($request->id);
                $area->F_COUNTRY_NO     = 1;
                $area->AREA_NAME        = $request->area;
                if($request->city){
                    $area->F_CITY_NO      = $request->city;
                    $city = City::find($request->city);
                    $area->CITY_NAME      = $city->CITY_NAME;
                }
                if($request->region){
                    $area->F_STATE_NO     = $request->region;
                    $city = State::find($request->region);
                    $area->STATE_NAME     = $city->STATE_NAME;
                }
                $area->AREA_NAME_BN  = $request->bn_area;
                $area->LATITUDE       = $request->latitude;
                $area->LONGITUDE      = $request->longitude;
                $area->MIN_LAT        = $request->min_latitude;
                $area->MIN_LON        = $request->min_longitude;
                $area->MAX_LAT        = $request->max_latitude;
                $area->MAX_LON        = $request->max_longitude;
                $area->NW_LAT         = $request->nw_latitude;
                $area->NW_LON         = $request->nw_longitude;
                $area->SW_LAT         = $request->sw_latitude;
                $area->SW_LON         = $request->sw_longitude;
                $area->SE_LAT         = $request->se_latitude;
                $area->SE_LON         = $request->se_longitude;
                $area->NE_LAT         = $request->ne_latitude;
                $area->NE_LON         = $request->ne_longitude;
                $area->IS_ACTIVE      = $request->is_active ?? 1;
                $area->SS_MODIFIED_ON    = date('Y-m-d H:i:s');
                $area->F_SS_MODIFIED_BY  = Auth::user()->PK_NO;
                $area->save();
                $data['area'] = $area;
                $data['html'] = view('admin.address.area.view')->withRow($area)->render();
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return $this->successResponse($e->getCode(), 'Area not saved !', '', 0);
        }
            DB::commit();
            return $this->successResponse(200, 'Area sucessfully save!', $data, 1);
        }

        public function getAreaEdit($id){
            DB::beginTransaction();
            try {
                $data['area']            = Area::find($id);
                $data['stateCombo']      = State::pluck('STATE_NAME', 'PK_NO');
                $data['city']            = City::where('PK_NO',$data['area']->F_CITY_NO)->pluck('CITY_NAME', 'PK_NO');
                $html = view('admin.address.area.edit')->with('data',$data)->render();
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return $this->successResponse($e->getCode(), 'Area not saved !', '', 0);
            }
            DB::commit();
            return $this->successResponse(200, 'Area sucessfully save!', $html, 1);
        }


        public function getAreaDelete($id){
            DB::beginTransaction();
            try {
                $check_sub_area = SubArea::where('F_AREA_NO',$id)->first();
                if($check_sub_area == null){
                    $area = Area::find($id);
                    $area->delete();
                }else{
                    return $this->successResponse(200, 'Not deleted, this area already used in subarea table!', '', 0);
                }
            } catch (\Exception $e) {
                dd($e->getMessage());
                DB::rollback();
                return $this->successResponse($e->getCode(), 'Area not Deleted !', '', 0);
            }
            DB::commit();
            return $this->successResponse(200, 'Area sucessfully Deleted!', $area, 1);
        }


        public function getAreaByCity($id)
        {
             $data = DB::table('SS_AREA')->select('PK_NO','AREA_NAME')->where('F_CITY_NO',$id)->get();
             $response = '';
                if ($data->count() > 0) {
                    $response = '<option value="">Select area</option>';
                    foreach ($data as $value) {
                        $response .= '<option value="'.$value->PK_NO.'">'.$value->AREA_NAME.'</option>';
                    }
                }else{
                    $response .= '<option value="">No sub area found</option>';
                }
            return $response;
        }

        public function getSubreaByArea($id)
        {
             $data = DB::table('SS_SUB_AREA')->select('PK_NO','SUB_AREA_NAME')->where('F_AREA_NO',$id)->get();
             $response = '';
                if ($data->count() > 0) {
                    $response = '<option value="">Select sub area</option>';
                    foreach ($data as $value) {
                        $response .= '<option value="'.$value->PK_NO.'">'.$value->SUB_AREA_NAME.'</option>';
                    }
                }else{
                    $response .= '<option value="">No sub area found</option>';
                }
            return $response;
        }


        

        public function getAreaCreate(){
            DB::beginTransaction();
            try {
                $data['countryCombo']   = Country::pluck('NAME', 'PK_NO');
                $data['stateCombo']     = State::where('IS_ACTIVE',1)->pluck('STATE_NAME', 'PK_NO');
                $data = view('admin.address.area.create')->withData($data)->render();
            } catch (\Exception $e) {
                dd($e->getMessage());
                DB::rollback();
                return $this->successResponse($e->getCode(), 'Area not saved !', '', 0);
            }
                DB::commit();
                return $this->successResponse(200, 'Area sucessfully save!', $data, 1);
        }


}
