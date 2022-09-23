<?php
namespace App\Models;
use App\Models\State;
use App\Models\AreaMap;
use App\Models\Country;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
class Address extends Model
{
    use ApiResponse;
    protected $table        = 'SLS_CUSTOMERS_ADDRESS';
    protected $primaryKey   = 'PK_NO';
    public $timestamps      = false;

    protected $fillable = [
        'CODE', 'NAME'
    ];

    public $sortable = ['PK_NO', 'NAME'];

    public function getAjaxCreate($customer_id){
        DB::beginTransaction();
        try {
            $data['country']   = Country::pluck('NAME', 'PK_NO');
            $data['state']     = State::pluck('STATE_NAME', 'PK_NO');
            $data['addTypeCombo']    = [];

            $data['customer'] = DB::table('SLS_CUSTOMERS')->where('PK_NO',$customer_id)->first();

            $data['customer_id'] = $customer_id;
            $data = view('admin.customer.address._create_modal_body')->withData($data)->render();
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return $this->successResponse($e->getCode(), 'Data not found !', '', 0);
        }
            DB::commit();
            return $this->successResponse(200, 'Data found !', $data, 1);
    }

    public function getAjaxEdit($address_id){
        DB::beginTransaction();
        try {
            $data['address']   = Address::find($address_id);
            $data['country']   = Country::pluck('NAME', 'PK_NO');
            $data['addTypeCombo']    = [];
            $data['state']= State::pluck('STATE_NAME', 'PK_NO');
            $data['city']      = City::where('F_STATE_NO',$data['address']->F_STATE_NO)->pluck('CITY_NAME', 'PK_NO');
            $data['area']      = Area::where('F_CITY_NO',$data['address']->F_CITY_NO)->pluck('AREA_NAME', 'PK_NO');
            $data['subarea']    = AreaMap::where('F_AREA_NO',$data['address']->F_AREA_NO)->pluck('SUB_AREA_NAME','PK_NO');

            $html = view('admin.customer.address._edit_modal_body')->withData($data)->render();

    } catch (\Exception $e) {
        dd($e->getMessage());
        DB::rollback();
        return $this->successResponse($e->getCode(), 'Data not found  !', '', 0);
        }
        DB::commit();
        return $this->successResponse(200, 'Data found !', $html, 1);
    }







}
