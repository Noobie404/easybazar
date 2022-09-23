<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Web\PushNotification;
use App\Repositories\Admin\Notification\NotificationInterface;

class PushNotificationController extends Controller
{

    protected $notification;
    protected $notificationInt;

    public function __construct(NotificationInterface $notificationInt, PushNotification $notification)
    {
        $this->notification  = $notification;
        $this->notificationInt  = $notificationInt;
    }

    public function getIndex(Request $request)
    {
        $this->resp = $this->notificationInt->getPaginatedList($request);

        return view('admin.web.notification.index')->withData($this->resp->data);
    }

    public function postAppBulkSend(Request $request){
        $this->resp = $this->notificationInt->postAppBulkSend($request);

        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getCreate()
    {
        return view('admin.web.notification.create');
    }

    public function getWebCreate()
    {
        return view('admin.web.notification.web-create');
    }

    public function getDeviceList(Request $request)
    {
        $this->resp = $this->notificationInt->getDeviceList($request);

        return view('admin.web.notification.device-list')->withData($this->resp->data);
    }

    public function postToken(Request $request)
    {
      $this->resp = $this->notificationInt->postToken($request);
       return response()->json([$this->resp->msg]);
    }

    public function postBulkToken(Request $request)
    {
      $this->resp = $this->notificationInt->postBulkToken($request);
       return response()->json([$this->resp->msg]);
    }


    public function sendWebNotification(Request $request)
    {
        $this->resp = $this->notificationInt->sendWebNotification($request);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function ajaxImageUpload(Request $request)
    {
        $data = $this->notificationInt->ajaxImageUpload($request);
          return response()->json($data);
    }


}
