<?php
namespace App\Http\Controllers\Admin;
use App\Models\Area;
use App\Models\City;
use App\Models\State;
use App\Models\Address;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\CustomerAddressRequest;
use App\Repositories\Admin\CustomerAddress\CustomerAddressInterface;

class CustomerAddressController extends BaseController
{
    protected $customer_add;
    protected $city;
    protected $state;
    protected $address;

    public function __construct(
        CustomerAddressInterface $customer_add,
        Country $country,
        State $state,
        City $city,
        Address $address
        )
    {
        $this->customer_add         = $customer_add;
        $this->country              = $country;
        $this->state                = $state;
        $this->city                 = $city;
        $this->address              = $address;
    }

    public function getIndex(Request $request)
    {
        $this->resp = $this->customer_add->getPaginatedList($request, 20);
        return view('admin.customer.index')->withRows($this->resp->data);
    }

    public function postStore(CustomerAddressRequest $request) {
        $this->resp = $this->customer_add->postStore($request);
        if($request->ajax()){
            return response()->json($this->resp, $this->resp->code);
        }
        return redirect()->route('admin.customer.view',$request->customer_id)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getEdit($id)
    {
        $customer_address   = $this->customer_add->getShow($id);
        $data['country']    = $this->country->getCountryComboWithCode();
        $data['state']      = $this->state->getStateCombo();
        $data['city']       = City::where('F_STATE_NO',$customer_address->data->F_STATE_NO)->pluck('CITY_NAME','PK_NO');
        $data['area']       = Area::where('F_CITY_NO',$customer_address->data->F_CITY_NO)->pluck('AREA_NAME','PK_NO');
        $data['subarea']    = AreaMap::where('F_AREA_NO',$customer_address->data->F_AREA_NO)->pluck('SUB_AREA_NAME','PK_NO');

        return view('admin.customer.address.edit')->withAddress($customer_address->data)->withData($data);
    }

    public function postUpdate(Request $request)
    {
        $this->resp = $this->customer_add->postUpdate($request);
        if($request->ajax()){
                return response()->json($this->resp, $this->resp->code);
        }

        return redirect()->route('admin.customer.view',$this->resp->data)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getDelete($id)
    {
        $this->resp = $this->customer_add->delete($id);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getAjaxDelete(Request $request)
    {
        $this->resp = $this->customer_add->getAjaxDelete($request);
        return response()->json($this->resp, $this->resp->code);
    }
     public function getCreate() {
        $addTypeCombo    = $this->address_type->getAddTypeCombo();
        $data['country'] = $this->country->getCountryComboWithCode();
        $data['state'] = $this->state->getStateCombo();
        return view('admin.customer.address.create')->withAddress($addTypeCombo)->withData($data);
    }

    public function getAjaxCreate(Request $request,$customer_id) {
        $response = $this->address->getAjaxCreate($customer_id);
        return response()->json($response, $response->code);
    }
    public function getAjaxEdit(Request $request,$address_id) {
        $response = $this->address->getAjaxEdit($address_id);
    
        return response()->json($response, $response->code);
    }


    public function getState($city_id)
    {
        $state_id = $this->state->getStateByCity($city_id);
        return response()->json($state_id);
    }

    public function getCity($post_code)
    {
        $city_id = $this->city->getCityByPostcode($post_code);
        return response()->json($city_id);
    }

    public function getCitybyState($state_id)
    {
        $city_id = $this->city->getCitybyState($state_id);
        return response()->json($city_id);
    }
}
