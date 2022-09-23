<?php
namespace App\Repositories\Admin\Address;
use DB;
use App\Models\Area;
use App\Models\City;
use App\Models\State;
use App\Models\PoCode;
use App\Models\Address;
use App\Models\Country;
use App\Traits\RepoResponse;


class AddressAbstract implements AddressInterface
{
    use RepoResponse;

    protected $address;
    protected $state;
    protected $city;
    protected $country;

    public function __construct(Address $address, Country $country, State $state, City $city)
    {
        $this->address     = $address;
        $this->state       = $state;
        $this->city        = $city;
        $this->country     = $country;

    }

    public function getPaginatedList($request, int $per_page = 20)
    {
        $data = $this->address->orderBy('NAME', 'ASC')->get();
        return $this->formatResponse(true, '', 'admin.address_type.list', $data);
    }





    public function postStore($request)
    {

        DB::beginTransaction();

        try {
            $address                  = new Address();
            $address->CODE            = $request->code;
            $address->NAME            = $request->name;
            $address->save();

        } catch (\Exception $e) {

            DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), 'admin.address_type.list');
        }
        DB::commit();

        return $this->formatResponse(true, 'Customer address type has been created successfully !', 'admin.address_type.list');
    }

    public function findOrThrowException($id)
    {
        $data = $this->address->where('PK_NO', '=', $id)->first();

        if (!empty($data)) {
            return $this->formatResponse(true, '', 'admin.address_type.edit', $data);
        }

        return $this->formatResponse(false, 'Did not found data !', 'admin.address_type.list', null);
    }


    public function postUpdate($request, $id)
    {

        DB::beginTransaction();

        try {

            $address = $this->address->where('PK_NO', $id)->first();

            $address->where('PK_NO', $id)->update(
                [
                    'CODE'          => (!empty($request->code) ?  $request->code : $id),
                    'NAME'          => $request->name

                ]
            );

        } catch (\Exception $e) {
            DB::rollback();

            return $this->formatResponse(false, 'Unable to update Address Type !', 'admin.address_type.list');
        }

        DB::commit();

        return $this->formatResponse(true, 'Address Type has been updated successfully !', 'admin.address_type.list');
    }

    public function delete($id)
    {

        DB::begintransaction();
        try {
            $this->address->where('PK_NO', $id)->delete();


        } catch (\Exception $e) {
            DB::rollback();

            return $this->formatResponse(false, 'Unable to delete this address type !', 'admin.address_type.list');
        }

        DB::commit();
        return $this->formatResponse(true, 'Successfully delete this  address type !', 'admin.address_type.list');
    }

    public function getCityAddress($id=null)
    {
        $data['city_details'] = null;
        if ($id != null) {
            $data['city_details'] = City::where('PK_NO', $id)->first();
        }
        $data['countryCombo']   = $this->country->getCountryCombo();
        $data['stateCombo']     = $this->state->getStateCombo();

        return $this->formatResponse(true, 'Data Found !', 'admin.address_type.list', $data);
    }

    public function getPostageAddress($id=null)
    {
        $data['postage_details'] = null;
        $data['countryCombo']   = $this->country->getCountryCombo();
        $data['stateCombo']     = $this->state->getStateCombo();

        if ($id != null) {
            $data['postage_details'] = PoCode::select('SS_PO_CODE.*','c.F_STATE_NO')
                                            ->join('SS_CITY as c','SS_PO_CODE.F_CITY_NO','c.PK_NO')
                                            ->where('SS_PO_CODE.PK_NO', $id)
                                            ->first();
           $data['cityCombo']   = $this->city->where('F_STATE_NO',$data['postage_details']->F_STATE_NO)->pluck('CITY_NAME','PK_NO');
        }else{
            $data['cityCombo']   = $this->city->where('F_STATE_NO',1)->pluck('CITY_NAME','PK_NO');
        }
        return $this->formatResponse(true, 'Data Found !', 'admin.address_type.list', $data);
    }

    public function postPostageAddress($request,$id)
    {
        DB::begintransaction();
        try {
            $city = City::select('CITY_NAME')->where('PK_NO',$request->city)->first();
            if ($id == 0) {
                $post_code               = new PoCode();
                $message = 'Post Code Created Successfully !';
            }else{
                $post_code = PoCode::find($id);
                $message = 'Post Code Updated Successfully !';
            }
            $post_code->PO_CODE         = $request->postage;
            $post_code->F_CITY_NO       = $request->city;
            $post_code->CITY_NAME       = $city->CITY_NAME;
            $post_code->F_COUNTRY_NO    = $request->country;
            $post_code->save();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), 'admin.address_type.list');
        }
        DB::commit();
        return $this->formatResponse(true, $message, 'admin.address_type.list');
    }


    public function getPostageList()
    {
        $data = PoCode::select('SS_PO_CODE.PK_NO','SS_PO_CODE.PO_CODE','SS_PO_CODE.CITY_NAME','SS_PO_CODE.CREATED_BY','c.NAME','city.STATE_NAME')
                    ->leftjoin('SS_COUNTRY as c','c.PK_NO','SS_PO_CODE.F_COUNTRY_NO')
                    ->leftjoin('SS_CITY as city','city.PK_NO','SS_PO_CODE.F_CITY_NO')
                    ->get();
        return $this->formatResponse(true, 'Data Found', 'admin.address_type.list',$data);
    }


    public function getCoordinator($request)
    {
        $lat = $request->latitude;
        $lon = $request->longitude;
        //  $polygons = DB::table('SS_SUB_AREA_POLYGON')->select('NODE_NO','LAT','LON')->orderBy('NODE_NO','ASC')->where('F_SUB_AREA_NO',$data->PK_NO)->get();
        //  $lat = 23.7933334;
        //  $lon = 90.4027869;
        //  DB::beginTransaction();
        //  try {
            // DB::statement('CALL PROC_CUSTOMER_AREA_RETRIEVE(:lat, :lon );',array($lat,$lon));
            $subareas = DB::table('SS_SUB_AREA')
                    // ->select('PK_NO','MIN_LAT','MIN_LON','MAX_LAT','MAX_LON','TOTAL_NODE')
                    ->where('MIN_LAT','<',$lat)
                    ->where('MIN_LON','<',$lon)
                    ->where('MAX_LAT','>',$lat)
                    ->where('MAX_LON','>',$lon)
                    ->get();
            // dd($subareas);

            // if(!empty($subareas) && $subareas->count() > 0){
            //     if($subareas->count() > 1){
                    foreach ($subareas as $key => $subarea) {

                        $dd = $this->is_in_subarea($lat,$lon,36,$subarea->TOTAL_NODE);
                        // $dd = $this->_is_in_subarea($lat,$lon,$subarea->PK_NO,$subarea->TOTAL_NODE);
              
                        if($dd){
                            $_subarea = DB::table('SS_SUB_AREA')
                            // ->select('PK_NO','MIN_LAT','MIN_LON','MAX_LAT','MAX_LON','TOTAL_NODE')
                            ->where('PK_NO',$subarea->PK_NO)
                            ->first();
                            // dd($_subarea);
                            echo '<pre>';
                            echo '======================<br>';
                            print_r($_subarea);
                            echo '<br>======================<br>';
                            exit();
                        }
                        else{

                      echo '<pre>';
                    echo '======================<br>';
                    print_r('outside');
                    echo '<br>======================<br>';
                    exit();
                        }
                    }
                // }
                // else{


                //     $subareas = DB::table('SS_SUB_AREA')
                //     // ->select('PK_NO','MIN_LAT','MIN_LON','MAX_LAT','MAX_LON','TOTAL_NODE')
                //     ->where('PK_NO',$subareas[0]->PK_NO)->get();

                //     echo '<pre>';
                //     echo '======================<br>';
                //     print_r($subareas);
                //     echo '<br>======================<br>';
                //     exit();
                // }
            // }
            // else{
            //     echo '<pre>';
            //         echo '======================<br>';
            //         print_r('outside');
            //         echo '<br>======================<br>';
            //         exit();
            //     //  return 'outside';
            // }

        // } catch (\Exception $e) {
        //     // DB::rollback();
        //         dd($e->getMessage());
        //         return 0;
        //     }
        //     // DB::commit();
        //     return 1;
        }
       public function  is_in_subarea($lat,$lon,$sub_area_id,$total_node){
          //  read node_count from sub_area_id;
         $node_list =  DB::table('SS_SUB_AREA_POLYGON')
        //  ->select(['STATE_NAME','CITY_NAME','AREA_NAME','LAT','LON'])
         ->where('F_SUB_AREA_NO',$sub_area_id)
         ->orderBy('PK_NO','ASC')
         ->get();
        //  dd($node_list);
         $node_list = $node_list->toArray();
         //(y - y0) (x1 - x0) - (x - x0) (y1 - y0)
         $data = array();
         
         for ($i=0; $i<$total_node-1; $i++){
             // x= lat 
            // y= lon
            //boss
            // x= lon 
            // y= lat
            //MY
            // $_node= ($lon-$node_list[$i]->LON)*($node_list[$i+1]->LAT-$node_list[$i]->LAT) - 
            // ($lat-$node_list[$i]->LAT)*($node_list[$i+1]->LON-$node_list[$i]->LON);
            $_node = ($lat - $node_list[$i]->LAT) *
                    ($node_list[$i+1]->LON - $node_list[$i]->LON) -
                    ($lon - $node_list[$i]->LON) *
                    ($node_list[$i+1]->LAT - $node_list[$i]->LAT);
                      
            if($_node < 0) {
                      array_push($data, [
                    'dd'=>  $_node, 
                   ]);

                //    dd($i);

                //    dd($_node);
               
                return 'outside';               
                return false;
            }
            // else{
            //     array_push($data, [
            //         'dd'=>  $_node, 
            //        ]);
            //     }
        }
        // return true;
    return 'inside';
        // dd($data);
            
    }


    public function  _is_in_subarea($lat,$lon,$sub_area_id,$total_node){

      $n_node =[
          '0'=>[
              'LON'=> 90.4098263508013,	'LAT' => 23.7936954917514,
          ],
          '1'=>[
              'LON'=> 90.4090755924678,	'LAT' =>23.7964949877169,
          ],
          '2'=>[
              'LON'=> 90.4075071986860,	'LAT' =>23.7977211123709,
          ],
          '3'=>[
              'LON'=> 90.4074068588548,	'LAT' => 23.7994303044283,
          ],
          '4'=>[
              'LON'=> 90.4072348062950,	'LAT' =>23.8004390816113,
          ],
          '5'=>[
              'LON'=> 90.4064699548057,	'LAT'=>23.8003192757962,
          ],
          '6'=>[
              'LON'=> 90.4057017465538,	'LAT'=>23.7987398368526,
          ],
          '7'=>[
              'LON'=> 90.4020122613500,	'LAT'=>23.7992425441589,
          ],
          '8'=>[
              'LON'=> 90.4010884702686,	'LAT'=>23.7946115471009,
          ],
          '9'=>[
              'LON'=> 90.3998109976468,	'LAT'=>23.7869684920607,
          ],
          '10'=>[
              'LON'=> 90.4019186843563,	'LAT'=>23.7864726331062,
          ],
          '11'=>[
              'LON'=> 90.4045258996221,	'LAT'=>23.7863301428068,
          ],
          '12'=>[
              'LON'=>  90.4063834924265,	'LAT'=>23.7887492390137,
          ],
          '13'=>[
              'LON'=> 90.4096404585073,	'LAT'=>23.7885048366660,
          ],
        ];

      $count = count($n_node);

      for ($i=0; $i<$count; $i++){
//         $_node = ($lon - $n_node[$i]['LON']) *
//         ($n_node[$i+1]['LAT'] - $n_node[$i]['LAT']) -
//         ($lat - $n_node[$i]['LAT']) *
//         ($n_node[$i+1]['LON'] - $n_node[$i]['LON']);
//   dd($lon. '---'.$n_node[$i]['LON']);
           $_node =  ($lat - $n_node[$i]['LAT']) * 
                ($n_node[$i+1]['LON'] - $n_node[$i]['LON']) -
                ($lon - $n_node[$i]['LON']) *
                ($n_node[$i+1]['LAT'] - $n_node[$i]['LAT']);
// dd($_node);
     
      if( $_node < 0 ){
          return false;
      }
      return true;
      }
    
  
  }
  
    


}
