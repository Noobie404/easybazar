<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Models\Area;
use App\Models\City;
use App\Models\State;
use App\Models\AreaMap;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\AreaRequest;
use App\Http\Requests\Admin\CityRequest;
use App\Http\Requests\Admin\StateRequest;
use App\Http\Requests\Admin\AddressRequest;
use App\Repositories\Admin\Address\AddressInterface;


class AddressController extends BaseController
{
    protected $address;
    protected $state;
    protected $areaMap;

    public function __construct(
        AddressInterface $address,
        State            $state,
        City             $city,
        Area             $area,
        AreaMap          $areaMap
        )
    {
        $this->address  = $address;
        $this->state    = $state;
        $this->area     = $area;
        $this->city     = $city;
        $this->areaMap  = $areaMap;
    }

    // public function getIndex(Request $request)
    // {
    //     $this->address_resp = $this->address->getPaginatedList($request, 20);
    //     return view('admin.address-type.index')->withRows($this->address_resp->data);
    // }

    // public function getCreate() {
    //     return view('admin.address-type.create');
    // }

    // public function postStore(AddressRequest $request) {
    //     $this->resp = $this->address->postStore($request);
    //     return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    // }

    // public function getEdit(Request $request, $id){
    //     $this->resp = $this->address->findOrThrowException($id);
    //     return view('admin.address-type.edit')->withAddress($this->resp->data);
    // }

    // public function postUpdate(AddressRequest $request, $id)
    // {
    //     $this->resp = $this->address->postUpdate($request, $id);
    //     return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    // }

    // public function getDelete($id)
    // {
    //     $this->resp = $this->address->delete($id);
    //     return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    // }

    public function getCityAddress($id=null){
        $this->resp = $this->address->getCityAddress($id);
        return view('admin.customer-address.city_address')->withData($this->resp->data);
    }

    public function getPostageAddress($id=null){
        $this->resp = $this->address->getPostageAddress($id);
        return view('admin.customer-address.postage_address')->withData($this->resp->data);
    }
    public function getPostageList()
    {
        $this->address_resp = $this->address->getPostageList();
        return view('admin.customer-address.postcode_index')->withRows($this->address_resp->data);
    }

    public function ajaxStateByCountry($country)
    {
        $state = $this->state->getStateByCountry($country);
        return $state;
    }
    public function postPostageAddress(Request $request,$id)
    {
        $this->resp = $this->address->postPostageAddress($request,$id);
        return redirect()->back()->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getCityCreate(Request $request)
    {
        $response = $this->city->getCityCreate();
        return response()->json($response, $response->code);
    }

    public function getCityList()
    {
        $this->address_resp = $this->city->getCityList();
        return view('admin.address.city.index')->with('data',$this->address_resp->data);
    }

    public function postCity(CityRequest $request)
    {
        $response = $this->city->postCityAddress($request);
        return response()->json($response, $response->code);
    }

    public function getEditCity(Request $request,$id)
    {
        $response = $this->city->getEditCity($id);
        return response()->json($response, $response->code);
    }

    public function updateCity(CityRequest $request)
    {
        $response = $this->city->updateCity($request);
        return response()->json($response, $response->code);
    }

    public function getCityDelete(Request $request,$id)
    {
        $response = $this->city->getCityDelete($id);
        return response()->json($response, $response->code);
    }

    public function getRegionList(Request $request)
    {
        $this->address_resp = $this->state->getRegionList($request);
        return view('admin.address.region.index')->withData($this->address_resp->data);
    }

    public function getRegionCreate(Request $request)
    {
        $response = $this->state->getRegionCreate();
        return response()->json($response, $response->code);
    }

    public function postRegion(StateRequest $request)
    {
        $response = $this->state->postRegion($request);
        return response()->json($response, $response->code);
    }
    public function updateRegion(StateRequest $request)
    {
        $response = $this->state->updateRegion($request);
        return response()->json($response, $response->code);
    }

    public function getRegion(Request $request,$id)
    {
        $response = $this->state->getRegion($request,$id);
        return response()->json($response, $response->code);
    }
    public function getRegionDelete(Request $request,$id)
    {
        $response = $this->state->getRegionDelete($id);
        return response()->json($response, $response->code);
    }

    public function getAreaList(Request $request)
    {
        $this->resp = $this->area->getAreaList($request);
        return view('admin.address.area.index')->with('data',$this->resp->data);
    }

    public function getCityByRegion(Request $request,$id)
    {
        $response = $this->state->getStateByCity($id);
        return response()->json($response);
    }
    public function getAreaByCity(Request $request,$id)
    {
        $response = $this->area->getAreaByCity($id);
        return response()->json($response);
    }

    public function getSubreaByArea(Request $request,$id)
    {
        $response = $this->area->getSubreaByArea($id);
        return response()->json($response);
    }


    

    public function postArea(AreaRequest $request)
    {
        $response = $this->area->postArea($request);
        return response()->json($response, $response->code);
    }

    public function updateArea(AreaRequest $request)
    {
        $response = $this->area->updateArea($request);
        return response()->json($response, $response->code);
    }

    public function getAreaEdit(Request $request,$id)
    {
        $response = $this->area->getAreaEdit($id);
        return response()->json($response, $response->code);
    }

    public function getAreaDelete(Request $request,$id)
    {
        $response = $this->area->getAreaDelete($id);
        return response()->json($response, $response->code);
    }
    public function getAreaCreate(Request $request)
    {
        $response = $this->area->getAreaCreate();
        return response()->json($response, $response->code);
    }

    public function getCoordinator(Request $request)
    {
        $response = $this->address->getCoordinator($request);
        return response()->json($response);
    }


}
