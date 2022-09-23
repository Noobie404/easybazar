<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Models\DeliverySchedule;
use App\Http\Controllers\Controller;


class DeliveryScheduleController extends Controller
{
    protected $deliverySchedule;
    public function __construct(
         DeliverySchedule      $deliverySchedule
        )
        {
            $this->deliverySchedule  = $deliverySchedule;
        }

    public function getIndex(Request $request)
    {
        $rows = DeliverySchedule::orderBy('PK_NO','ASC')->get();
        return view('admin.delivery-schedule.index')->with('rows',$rows);
    }


    public function getCreate(Request $request)
    {
        $response = $this->deliverySchedule->getCreate();
        return response()->json($response, $response->code);
    }

    public function postStore(Request $request)
    {
        $response = $this->deliverySchedule->postStore($request);
        return response()->json($response, $response->code);
    }
    public function postGenerate(Request $request)
    {
        $response = $this->deliverySchedule->postGenerate($request);
        return response()->json($response, $response->code);
    }

    public function postUpdate(Request $request)
    {
        $response = $this->deliverySchedule->postUpdate($request);
        return response()->json($response, $response->code);
    }
    public function getDelete(Request $request,$schedule_id)
    {
        $response = $this->deliverySchedule->getDelete($request,$schedule_id);
        return response()->json($response, $response->code);
    }



}
