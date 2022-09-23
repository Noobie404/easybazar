<?php
namespace App\Repositories\Admin\CustomerAddress;

use DB;
use App\Models\Area;
use App\Models\AreaMap;
use App\Models\City;
use App\Models\State;
use App\Traits\ApiResponse;
use App\Traits\RepoResponse;
use App\Models\CustomerAddress;

class CustomerAddressAbstract implements CustomerAddressInterface
{
    use RepoResponse;
    use ApiResponse;

    public function __construct(CustomerAddress $customer_add)
    {
        $this->customer_add = $customer_add;
    }

    public function getPaginatedList($request, int $per_page = 5)
    {
        $data = $this->customer_add->where('IS_ACTIVE',1)->orderBy('NAME', 'ASC')->get();
        return $this->formatResponse(true, '', 'admin.customer.index', $data);
    }

    public function getShow(int $id)
    {
        $data =  CustomerAddress::find($id);

        if (!empty($data)) {
            return $this->formatResponse(true, 'Data found', 'admin.customer-address.edit', $data);
        }

        return $this->formatResponse(false, 'Did not found data !', 'admin.customer.view', null);
    }

    public function postStore($request)
    {
        DB::beginTransaction();
        try {
            $address                           = new CustomerAddress();
            $address->NAME                     = $request->name;
            $address->MOBILE_NO                   = $request->mobile_no;
            $address->ADDRESS_LINE_1           = $request->ad_1;
            $address->ADDRESS_LINE_2           = $request->ad_2;
            $address->F_COUNTRY_NO             = $request->country ?? 1;
            $address->COUNTRY                  = $request->country_name ?? 'Bangladesh';
            if($request->region){
                $state = State::find($request->region);
                $address->STATE_NAME           = $state->STATE_NAME;
                $address->F_STATE_NO           = $request->region;
            }
            if($request->city){
                $state = City::find($request->city);
                $address->CITY_NAME           = $state->CITY_NAME;
                $address->F_CITY_NO           = $request->city;
            }
            if($request->area){
                $state = Area::find($request->area);
                $address->AREA_NAME           = $state->AREA_NAME;
                $address->F_AREA_NO           = $request->area;
            }
            if($request->subarea){
                $subarea = AreaMap::find($request->subarea);
                $address->SUB_AREA_NAME           = $subarea->SUB_AREA_NAME;
                $address->F_SUBAREA_NO           = $request->subarea;
            }

            $address->POST_CODE               = $request->post_code;
            $address->F_CUSTOMER_NO           = $request->customer_id;
            $address->ADDRESS_LABEL           = $request->address_label;
            $check_default = CustomerAddress::where('F_CUSTOMER_NO',$request->customer_id)->where('IS_DEFAULT',1)->first();
            if(empty($check_default)){
                $address->IS_DEFAULT = 1;
            }
            $address->IS_ACTIVE                = $request->is_active ?? 1;
            $address->save();
            $data = view('admin.customer.address._view_ajax')->withRow($address)->render();
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            if($request->ajax()){
                return $this->successResponse(200, 'Data not found !', '', 0);
            }
            else{
                return $this->formatResponse(false, $e->getMessage(), 'admin.customer.list');
            }
            }
            DB::commit();
            if($request->ajax()){
                return $this->successResponse(200, 'Customer Address has been created successfully !', $data, 1);
            }
            else{
                return $this->formatResponse(true, 'Customer Address has been created successfully !', 'admin.customer.view');
            }
    }

    public function postUpdate($request)
    {
        $data = [];
        DB::beginTransaction();
        try {
        $address = CustomerAddress::find($request->address_id);
        $address->NAME                     = $request->name;
        $address->MOBILE_NO                   = $request->mobile_no;
        $address->F_CUSTOMER_NO            = $request->customer_id;
        $address->ADDRESS_LINE_1           = $request->ad_1;
        $address->ADDRESS_LINE_2           = $request->ad_2;
        $address->F_COUNTRY_NO             = $request->country ?? 1;
        $address->COUNTRY                  = $request->country_name ?? 'Bangladesh';
        if($request->region){
            $state = State::find($request->region);
            $address->STATE_NAME           = $state->STATE_NAME;
            $address->F_STATE_NO               = $request->region;
        }
        if($request->city){
            $state = City::find($request->city);
            $address->CITY_NAME           = $state->CITY_NAME;
            $address->F_CITY_NO           = $request->city;
        }
        if($request->area){
            $state = Area::find($request->area);
            $address->AREA_NAME           = $state->AREA_NAME;
            $address->F_AREA_NO           = $request->area;
        }
        if($request->subarea){
            $subarea = AreaMap::find($request->subarea);
            $address->SUB_AREA_NAME       = $subarea->SUB_AREA_NAME;
            $address->F_SUBAREA_NO        = $request->subarea;
        }
        $address->POST_CODE               = $request->post_code;
        $address->ADDRESS_LABEL           = $request->address_label;
        $address->IS_ACTIVE               = $request->is_active;
        if($request->is_default==1){
            DB::table('SLS_CUSTOMERS_ADDRESS')->where('F_CUSTOMER_NO',$request->customer_id)->where('IS_DEFAULT',1)->whereNotIn('PK_NO',[$request->address_id])->update(['IS_DEFAULT'=>0]);
            $address->IS_DEFAULT = 1;
        }
        $address->update();
        $data['html'] = view('admin.customer.address._view_ajax')->withRow($address)->render();
        $data['address'] = $address;
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
        if($request->ajax()){
            return $this->successResponse(200, 'Unable to update Customer Address Information !', '', 0);
        }
        else{
            return $this->formatResponse(false, $e->getMessage(), 'admin.customer.view');
        }
        }
        DB::commit();
        if($request->ajax()){
           return $this->successResponse(200, 'Customer Address has been successfully update!', $data, 1);
        }
        else{
           return $this->formatResponse(true, 'Customer Address has been successfully update!', 'admin.customer.view');
        }
    }

    public function delete($PK_NO)
    {
        $customer = CustomerAddress::where('PK_NO',$PK_NO)->first();
        $customer->IS_ACTIVE = 0;
        if ($customer->update()) {
            return $this->formatResponse(true, 'Successfully deleted Customer Address', 'admin.customer.list');
        }
        return $this->formatResponse(false,'Unable to delete Customer Address','admin.customer.list');
    }

    public function getAjaxDelete($request){
        $data = [];
        DB::beginTransaction();
        try {

            DB::table('SLS_CUSTOMERS_ADDRESS')->where('PK_NO',$request->address_id)->delete();
            $address = CustomerAddress::where('F_CUSTOMER_NO',$request->customer_id)->where('IS_DEFAULT',1)->first();
            $data = view('admin.customer.address._view_ajax')->withRow($address)->render();

    } catch (\Exception $e) {
        dd($e->getMessage());
        DB::rollback();
        return $this->successResponse($e->getCode(), 'Unable to delete Customer Address !', '', 0);
        }
        DB::commit();
        return $this->successResponse(200, 'Successfully deleted Customer Address!', $data, 1);
    }


    public function getDefaultShippingAdd($request, $customer_id){
        $type = $request->type;
        if ($type=='customer') {
            $data = $this->customer_add->where('F_CUSTOMER_NO',$customer_id)->where('IS_DEFAULT',1)->where('IS_ACTIVE',1)->first();
        }
        if (!empty($data)) {
        return $this->formatResponse(true, 'Data found', 'customer.index', $data);
        }
        return $this->formatResponse(false, 'Did not found data !', 'customer.index', null);
    }

}
