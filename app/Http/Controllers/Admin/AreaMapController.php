<?php
namespace App\Http\Controllers\Admin;
use App\Models\Area;
use App\Models\City;
use App\Models\State;
use App\Models\AreaMap;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AreaMapRequest;

class AreaMapController extends Controller
{

    protected $address;
    protected $state;
    protected $city;
    protected $area;
    protected $areamap;
    public function __construct(
        State            $state,
        City             $city,
        Area             $area,
        AreaMap          $areamap
        )
    {
        $this->state    = $state;
        $this->area     = $area;
        $this->city     = $city;
        $this->areamap  = $areamap;
    }
    public function getIndex(Request $request)
    {
        $states = $this->state->getStateCombo();
        $this->areamap = $this->areamap->getPaginatedList($request);
        return view('admin.address.areamap.index')->with('state',$states)->with('rows',$this->areamap);
    }
    public function postStore(AreaMapRequest $request)
    {
        $response = $this->areamap->postStore($request);
        return response()->json($response, $response->code);
    }
    public function postUpdate(AreaMapRequest $request)
    {
        $response = $this->areamap->postUpdate($request);
        return response()->json($response, $response->code);
    }

    public function getEdit(Request $request,$id)
    {
        $response = $this->areamap->getEdit($id);
        return response()->json($response, $response->code);
    }
    public function getDelete(Request $request,$id)
    {
        $response = $this->areamap->getDelete($id);
        return response()->json($response, $response->code);
    }
    public function getPolygonDelete(Request $request,$id)
    {
        $response = $this->areamap->getPolygonDelete($id);
        return response()->json($response, $response->code);
    }

    public function getCreate(Request $request)
    {
        $response = $this->areamap->getCreate();
        return response()->json($response, $response->code);
    }



    public function getMap(Request $request)
    {
        $this->areamap = $this->areamap->getMap($request);
        return view('admin.address.areamap.map')->with('data',$this->areamap->data);
    }

    public function getAreaMapByArea(Request $request,$id)
    {
        $response = $this->areamap->getAreaMapByArea($id);
        return response()->json($response);
    }



}
