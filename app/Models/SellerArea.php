<?php

namespace App\Models;

use App\Models\State;
use App\Models\Country;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class SellerArea extends Model
{

    protected $table        = 'SS_SHOP_AREA_COVERAGE';
    protected $primaryKey   = 'PK_NO';
    const CREATED_AT        = 'SS_CREATED_ON';
    const UPDATED_AT        = 'SS_MODIFIED_ON';
    // use RepoResponse;
    use ApiResponse;

    public function getCoverageAreaForm($id){
        DB::beginTransaction();
        try {
            $data['seller']   = Seller::find($id);
            $data['seller']->area = DB::table('SS_SHOP_AREA_COVERAGE')->where('F_SHOP_NO',$data['seller']->PK_NO)->get();
            $data['countryCombo']   = Country::pluck('NAME', 'PK_NO');
            $data['stateCombo']     = State::where('IS_ACTIVE',1)->pluck('STATE_NAME', 'PK_NO');
            $data = view('admin.seller.coverage_area.create')->withData($data)->render();
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return $this->successResponse($e->getCode(), 'Area not saved !', '', 0);
        }
            DB::commit();
            return $this->successResponse(200, 'Area sucessfully save!', $data, 1);
    }



    public function getCoverageAreaDelete($id){
        DB::beginTransaction();
        try {
            $area = SellerArea::find($id);

            $area->delete();
    } catch (\Exception $e) {
        dd($e->getMessage());
        DB::rollback();
        return $this->successResponse($e->getCode(), 'Area not Deleted !', '', 0);
        }
        DB::commit();
        return $this->successResponse(200, 'Area sucessfully Deleted!', $area, 1);
    }


}
