<?php

namespace App\Models;

use DB;
use Auth;
use App\Models\Area;
use App\Models\City;
use App\Models\State;
use App\Models\Seller;
use App\Traits\ApiResponse;
use App\Traits\RepoResponse;
use Illuminate\Database\Eloquent\Model;

class AreaMap extends Model
{
    use RepoResponse;
    use ApiResponse;
    protected $table = 'SS_SUB_AREA';
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

    public function getPaginatedList($request){
        return AreaMap::where('IS_ACTIVE',1)->orderBy('STATE_NAME','ASC')
        ->orderBy('CITY_NAME','ASC')
        ->orderBy('SUB_AREA_NAME','ASC')
        ->paginate(500);
    }

    public function getCreate(){

        DB::beginTransaction();
        try {
            $states = State::where('IS_ACTIVE',1)->pluck('STATE_NAME', 'PK_NO');
            // $stores = Seller::where('FK_PARENT_USER_NO',0)->pluck('NAME','PK_NO');
            $stores = Seller::where('IS_ACTIVE',1)->where('USER_TYPE',10)->where('F_PARENT_USER_ID',0)->pluck('NAME','PK_NO');
            $data = view('admin.address.areamap.create')->withRow($states)->withStores($stores)->render();
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return $this->successResponse($e->getCode(), 'Area not saved !', '', 0);
        }
            DB::commit();
            return $this->successResponse(200, 'Area sucessfully save!', $data, 1);
    }


    public function postStore($request){

        DB::beginTransaction();
        try {

            $lat_values = [$request->nw_lat, $request->sw_lat, $request->se_lat, $request->ne_lat];
            $lon_values = [$request->nw_lon, $request->sw_lon, $request->se_lon, $request->ne_lon];
            $min_lat = min($lat_values);
            $min_lon = min($lon_values);
            $max_lat = max($lat_values);
            $max_lon = max($lon_values);
            $data = '';

            $areamap                   = new AreaMap();
            // $areamap->MIN_LAT          = $min_lat;
            // $areamap->MIN_LON          = $min_lon;
            // $areamap->MAX_LAT          = $max_lat;
            // $areamap->MAX_LON          = $max_lon;
            $areamap->F_COUNTRY_NO     = 1;
            $area = Area::find($request->area);
            $areamap->F_AREA_NO        = $request->area;
            $areamap->AREA_NAME        = $area->AREA_NAME;
            $areamap->F_CITY_NO        = $request->city;
            $city = City::find($request->city);
            $areamap->CITY_NAME        = $city->CITY_NAME;
            $areamap->F_STATE_NO       = $request->region;
            $city = State::find($request->region);
            $areamap->STATE_NAME       = $city->STATE_NAME;
            $areamap->SUB_AREA_NAME    = $request->subarea;
            $areamap->SUB_AREA_NAME_BN = $request->subarea_bn;
            $areamap->COORDINATE_XML   = $request->coordinates_xml;
            // $areamap->NW_LAT         = $request->nw_lat;
            // $areamap->NW_LON         = $request->nw_lon;
            // $areamap->SW_LAT         = $request->sw_lat;
            // $areamap->SW_LON         = $request->sw_lon;
            // $areamap->SE_LAT         = $request->se_lat;
            // $areamap->SE_LON         = $request->se_lon;
            // $areamap->NE_LAT         = $request->ne_lat;
            // $areamap->NE_LON         = $request->ne_lon;
            $areamap->IS_ACTIVE      = $request->is_active ?? 1;
            $areamap->SS_CREATED_ON  = date('Y-m-d H:i:s');
            $areamap->F_SS_CREATED_BY = Auth::user()->PK_NO;
            $areamap->save();

            $feed = simplexml_load_string(html_entity_decode($request->coordinates_xml, null, "UTF-8"));
            $feed_arr = json_decode(json_encode($feed), TRUE);

            $coors = $feed_arr['Document']['Placemark']['Polygon']['outerBoundaryIs']['LinearRing']['coordinates'] ?? null;
            $coors = preg_replace('/\s\s+/', ' ', $coors);
            $coors = trim(preg_replace('/\r|\n/', '', $coors));
            if(isset($coors) && ($coors != null)){
                $coors_arr = explode(",0",$coors);
                $data = array();
                foreach ($coors_arr as $key => $value) {

                    if($value){
                        $lat = $lon = null;
                        $lat_lon = explode(",",$value);
                        $lon = $lat_lon[0];
                        $lat = $lat_lon[1];
                        // $lat = $lat_lon[0];
                        // $lon = $lat_lon[1];

                        array_push($data, [
                            'F_SUB_AREA_NO'   => $areamap->PK_NO,
                            'LAT'             =>str_replace(' ','',$lat),
                            'LON'             => str_replace(' ','',$lon),
                            'F_STATE_NO'      => $request->region,
                            'STATE_NAME'      => $areamap->STATE_NAME,
                            'F_CITY_NO'       => $areamap->F_CITY_NO,
                            'CITY_NAME'       => $areamap->CITY_NAME,
                            'F_AREA_NO'       => $areamap->F_AREA_NO,
                            'AREA_NAME'       => $areamap->AREA_NAME,
                            'F_COUNTRY_NO'    => 1,
                          //   'IS_ACTIVE'       => 1,
                            'F_SS_CREATED_BY' => Auth::user()->PK_NO,
                            'SS_CREATED_ON'   => date("Y-m-d h:i:s", time()),
                          ]);
                    }
                }

               DB::table('SS_SUB_AREA_POLYGON')->insert($data);
              }

            $rows = AreaMap::get();
            $data = view('admin.address.areamap.view')->withRows($rows)->render();
    } catch (\Exception $e) {
        dd($e->getMessage());
        DB::rollback();
        return $this->successResponse($e->getCode(), 'Area not saved !', '', 0);
    }
        DB::commit();
        return $this->successResponse(200, 'Area sucessfully save!', $data, 1);
    }

        public function postUpdate($request){
            $data = [];
            DB::beginTransaction();
            try {


                $areamap = AreaMap::find($request->id);

                $areamap->F_COUNTRY_NO     = 1;
                $area = Area::find($request->area);
                $areamap->F_AREA_NO        = $request->area;
                $areamap->AREA_NAME        = $area->AREA_NAME;
                $areamap->F_CITY_NO        = $request->city;
                $city = City::find($request->city);
                $areamap->CITY_NAME        = $city->CITY_NAME;
                $areamap->F_STATE_NO       = $request->region;
                $city = State::find($request->region);
                $areamap->STATE_NAME       = $city->STATE_NAME;
                $areamap->SUB_AREA_NAME    = $request->subarea;
                $areamap->SUB_AREA_NAME_BN = $request->subarea_bn;
                $areamap->COORDINATE_XML   = $request->coordinates_xml;
                // $areamap->NW_LAT         = $request->nw_lat;
                // $areamap->NW_LON         = $request->nw_lon;
                // $areamap->SW_LAT         = $request->sw_lat;
                // $areamap->SW_LON         = $request->sw_lon;
                // $areamap->SE_LAT         = $request->se_lat;
                // $areamap->SE_LON         = $request->se_lon;
                // $areamap->NE_LAT         = $request->ne_lat;
                // $areamap->NE_LON         = $request->ne_lon;
                $areamap->IS_ACTIVE      = $request->is_active ?? 1;
                $areamap->SS_CREATED_ON  = date('Y-m-d H:i:s');
                $areamap->F_SS_CREATED_BY = Auth::user()->PK_NO;
                $areamap->update();
                DB::table('SS_SUB_AREA_POLYGON')->where('F_SUB_AREA_NO',$areamap->PK_NO)->delete();

                $feed = simplexml_load_string(html_entity_decode($request->coordinates_xml, null, "UTF-8"));
                $feed_arr = json_decode(json_encode($feed), TRUE);

                $coors = $feed_arr['Document']['Placemark']['Polygon']['outerBoundaryIs']['LinearRing']['coordinates'] ?? null;
                $coors = preg_replace('/\s\s+/', ' ', $coors);
                $coors = trim(preg_replace('/\r|\n/', '', $coors));
                if(isset($coors) && ($coors != null)){
                    $coors_arr = explode(",0",$coors);
                    $data = array();
                    foreach ($coors_arr as $key => $value) {
                        if($value){
                            $lat = $lon = null;
                            $lat_lon = explode(",",$value);
                            $lon = $lat_lon[0];
                            $lat = $lat_lon[1];
                            // $lat = $lat_lon[0];
                            // $lon = $lat_lon[1];

                            array_push($data, [
                                'F_SUB_AREA_NO'   => $areamap->PK_NO,
                                'LAT'             => str_replace(' ','',$lat),
                                'LON'             => str_replace(' ','',$lon),
                                // 'LAT'             => $lat,
                                // 'LON'             => $lon,
                                'F_STATE_NO'      => $request->region,
                                'STATE_NAME'      => $areamap->STATE_NAME,
                                'F_CITY_NO'       => $areamap->F_CITY_NO,
                                'CITY_NAME'       => $areamap->CITY_NAME,
                                'F_AREA_NO'       => $areamap->F_AREA_NO,
                                'AREA_NAME'       => $areamap->AREA_NAME,
                                'F_COUNTRY_NO'    => 1,
                              //   'IS_ACTIVE'       => 1,
                                'F_SS_CREATED_BY' => Auth::user()->PK_NO,
                                'SS_CREATED_ON'   => date("Y-m-d h:i:s", time()),
                              ]);
                        }
                    }

                   DB::table('SS_SUB_AREA_POLYGON')->insert($data);
                }



                $data['area'] = $areamap;
                $rows = AreaMap::get();
                $data['html'] = view('admin.address.areamap.view')->withRows($rows)->render();
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return $this->successResponse($e->getCode(), 'AreaMap not saved !', '', 0);
        }
            DB::commit();
            return $this->successResponse(200, 'AreaMap sucessfully save!', $data, 1);
        }

        public function getEdit($id){
            DB::beginTransaction();
            try {
                $data['areamap']   = AreaMap::find($id);
                $data['subarea_polygons']   = DB::table('SS_SUB_AREA_POLYGON')->where('F_SUB_AREA_NO',$id)->get();
                $data['stateCombo']= State::pluck('STATE_NAME', 'PK_NO');
                $data['city']      = City::where('F_STATE_NO',$data['areamap']->F_STATE_NO)->pluck('CITY_NAME', 'PK_NO');
                $data['area']      = Area::where('F_CITY_NO',$data['areamap']->F_CITY_NO)->pluck('AREA_NAME', 'PK_NO');
                $data['store']     = Seller::where('IS_ACTIVE',1)->where('USER_TYPE',10)->where('F_PARENT_USER_ID',0)->pluck('NAME', 'PK_NO');
                $html = view('admin.address.areamap.edit')->with('data',$data)->render();
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return $this->successResponse($e->getCode(), 'Area not saved !', '', 0);
            }
            DB::commit();
            return $this->successResponse(200, 'Area sucessfully save!', $html, 1);
        }

        public function getDelete($id){
            DB::beginTransaction();
            try {
                $check_area_use = DB::table('SS_SHOP_AREA_COVERAGE')->where('F_SUB_AREA_NO',$id)->first();
                if($check_area_use ==  null){
                    $area = AreaMap::find($id);
                    $area->delete();
                }else{
                    return $this->successResponse(200, 'Not deleted, Subarea alreay used in shop.',null, 0);
                }
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return $this->successResponse($e->getCode(), 'Areamap not Deleted !', '', 0);
            }
            DB::commit();
            return $this->successResponse(200, 'Areamap sucessfully Deleted!', $area, 1);
        }
        public function getPolygonDelete($id){
            DB::beginTransaction();
            try {
                $area = DB::table('SS_SUB_AREA_POLYGON')->where('PK_NO',$id)->delete();

        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return $this->successResponse($e->getCode(), 'Areamap not Deleted !', '', 0);
            }
            DB::commit();
            return $this->successResponse(200, 'Areamap sucessfully Deleted!', $area, 1);
        }


    public function getMap($request)
    {
        DB::beginTransaction();
        try {
        $mode           = $request->mode;
        $pk             = $request->id;
        $childmap       = $request->childmap;
        $childmaps      = null;
        if($mode == 'submap'){
            $result     = AreaMap::find($pk);
        }
        if($mode == 'area'){
            if($childmap){
                $childmaps = AreaMap::select('NW_LAT','NW_LON','SW_LAT','SW_LON','SE_LAT','SE_LON','NE_LAT','NE_LON','MIN_LAT','MIN_LON','MAX_LAT','MAX_LON','PK_NO as pk_no','ZONE_NO as mark_label')->where('F_AREA_NO',$pk)
                ->get();
                if ($childmaps) {
                    foreach ($childmaps as $key => $value) {
                        $value->mark_title = 'Zone'.$value->mark_label;
                    }
                }
            }
            $result = Area::find($pk);
        }
        if($mode == 'city'){
            if($childmap){
                $childmaps = Area::select('NW_LAT','NW_LON','SW_LAT','SW_LON','SE_LAT','SE_LON','NE_LAT','NE_LON','MIN_LAT','MIN_LON','MAX_LAT','MAX_LON','PK_NO as pk_no','AREA_NAME as mark_label','AREA_NAME as mark_title')->where('F_CITY_NO',$pk)
                ->get();
            }
            $result = City::find($pk);
        }
        if($mode == 'region'){
            if($childmap){
                $childmaps = City::select('SS_CITY.*','PK_NO as pk_no','CITY_NAME as mark_label','CITY_NAME as mark_title')->where('F_STATE_NO',$pk)
                ->get();
            }
            $result = State::find($pk);
        }
        $data['map'] = $result;
        $data['childmaps'] = $childmaps;
    } catch (\Exception $e) {
        DB::rollback();
        return $this->formatResponse(false, 'Data found !', 'admin.address.areamap.index',NULL);
    }
    DB::commit();
    return $this->formatResponse(true, 'Data not found !', 'admin.address.areamap.map',$data);
    }


    public function getAreaMapByArea($id)
    {
         $data = DB::table('SS_SUB_AREA')->select('PK_NO','ZONE_NO','SUB_AREA_NAME')->where('F_AREA_NO',$id)->get();
         $response = '';
            if ($data->count() > 0) {
                // $response = '<option value="">Select sub area</option>';
                foreach ($data as $value) {
                    $response .= '<option value="'.$value->PK_NO.'">'.$value->SUB_AREA_NAME.'</option>';
                }
            }else{
                $response .= '<option value="">No sub area found</option>';
            }
        return $response;
    }

 







}
