<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\ReturnOrderRequest;
use App\Repositories\Admin\Booking\BookingInterface;

class ReturnRequestController extends BaseController
{
    protected $bookingInt;
    public function __construct(
        BookingInterface $bookingInt
        )
    {
        $this->bookingInt      = $bookingInt;
    }

    public function getIndex(Request $request)
    {
        $this->resp = $this->bookingInt->getReturnRequestOrder($request);
        $data['rows'] =  $this->resp->data;
        $data['return_reason'] = DB::table('SLS_BOOKING_RETURN_REASON')->where('STATUS',1)->pluck('DESCRIPTION', 'CODE');
        return view('admin.return_request.index',compact('data'));
    }

    public function postReturnOrder(ReturnOrderRequest $request)
    {
        $response = $this->bookingInt->postReturnOrder($request);
        return response()->json($response, $response->code);
    }


    public function postConfirmReturnOrder(Request $request)
    {
        $response = $this->bookingInt->postConfirmReturnOrder($request);
        return response()->json($response, $response->code);
    }


    // public function postReturnRequest(Request $request){
    //     $this->resp = $this->order->postReturnRequest($request);
    //     return response()->json($this->resp);
    // }


}
