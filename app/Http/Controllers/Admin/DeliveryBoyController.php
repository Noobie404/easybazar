<?php
namespace App\Http\Controllers\Admin;
use App\Models\Area;
use App\Models\City;
use App\Models\State;
use App\Models\AreaMap;
use App\Models\DeliveryBoy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DeliveryBoyRequest;
use App\Repositories\Admin\DeliveryBoy\DeliveryBoyInterface;

class DeliveryBoyController extends Controller
{

    protected $address;
    protected $state;
    protected $city;
    protected $area;
    protected $areamap;
    protected $deliveryBoy;
    protected $deliveryint;


    public function __construct(
        // AddressInterface $address,
        State            $state,
        City             $city,
        Area             $area,
        AreaMap          $areamap,
        DeliveryBoy      $deliveryBoy,
        DeliveryBoyInterface $deliveryBoyInt
        )
    {
        $this->state    = $state;
        $this->area     = $area;
        $this->city     = $city;
        $this->areamap  = $areamap;
        $this->deliveryBoy  = $deliveryBoy;
        $this->deliveryBoyInt  = $deliveryBoyInt;
    }
    public function getIndex(Request $request)
    {
        $this->resp = $this->deliveryBoyInt->getPaginatedList($request);
        return view('admin.delivery_boy.index')->with('rows',$this->resp->data);
    }
    public function postStore(DeliveryBoyRequest $request)
    {

        $response = $this->deliveryBoyInt->postStore($request);
        return response()->json($response, $response->code);
    }
    public function postUpdate(DeliveryBoyRequest $request)
    {
        $response = $this->deliveryBoyInt->postUpdate($request);
        return response()->json($response, $response->code);
    }

    public function getEdit(Request $request,$id)
    {
        $response = $this->deliveryBoy->getEdit($id);
        return response()->json($response, $response->code);
    }
    public function getDelete(Request $request,$id)
    {
        $response = $this->deliveryBoyInt->getDelete($id);
        return response()->json($response, $response->code);
    }

    public function getCreate(Request $request)
    {
        $response = $this->deliveryBoy->getCreate();
        return response()->json($response, $response->code);
    }

    public function getView(Request $request,$id)
    {
        $this->resp = $this->deliveryBoyInt->getView($id);
        // dd($this->resp);
        return view('admin.delivery_boy.dashboard')->with('row',$this->resp->data);
    }


    public function getDeliveryList(Request $request)
    {
        $this->resp = $this->deliveryBoyInt->getDeliveryList($request);
        return view('admin.delivery_boy.delivery_list')->with('row',$this->resp->data);
    }

    public function getCoverageArea(Request $request, $id){
        $this->resp = $this->deliveryBoyInt->getCoverageArea($request,$id);
        return response()->json($this->resp);
    }

    public function postCoverageArea(Request $request, $id){
        $response = $this->deliveryBoyInt->postCoverageArea($request,$id);
        return response()->json($response, $response->code);
    }
    public function deliveryAreaDelete($id){
        $response = DB::table('SS_DELIVERYBOY_AREA_COVERAGE')->where('PK_NO',$id)->delete();
        return response()->json($response);
    }

    public function getDeliveryManByShop($id){

        $sub_area = DB::table('SS_SHOP_AREA_COVERAGE')->where('F_SHOP_NO',$id)->groupBy('F_SUB_AREA_NO')->pluck('F_SUB_AREA_NO')->implode(',');
        $response = DB::table('SS_DELIVERYBOY_AREA_COVERAGE')
        ->whereIn('F_SUB_AREA_NO',[$sub_area])
        ->groupBy('F_USER_NO')
        ->pluck('USER_NAME','F_USER_NO');
        $data = view('admin.components._deliveryman_modal_body')->withRow($response)->render();
        return response()->json($data);
    }








}
