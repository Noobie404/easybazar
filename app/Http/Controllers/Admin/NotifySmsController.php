<?php
namespace App\Http\Controllers\Admin;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\EmailNotification;
use App\Http\Controllers\BaseController;
use App\Repositories\Admin\NotifySms\NotifySmsInterface;

class NotifySmsController extends BaseController
{

    protected $notifyInt;

    public function __construct(NotifySmsInterface $notifyInt )
    {
        $this->notifyInt  = $notifyInt;
    }

    public function getIndex(Request $request)
    {
        return view('admin.notify.smslist');
    }

    public function getEmailIndex(Request $request)
    {
        $this->resp = $this->notifyInt->getEmailIndex($request);
        return view('admin.notify.emaillist')->withRows($this->resp->data);
    }

    public function getEmailBody($id)
    {
        $data = EmailNotification::find($id);
        return $data->BODY;

        // if ($data->TYPE == 'Order Create') {
            // $order_info = $this->notifyInt->getEmailBody($data);
            // return view('admin.Mail.order_arrive')->withRows($order_info);
        // }elseif($data->TYPE == 'Arrival'){
        //     $order_info = $this->notifyInt->getEmailBody($data);
        //     return view('admin.Mail.order_arrive')->withRows($order_info);
        // }elseif($data->TYPE == 'Default'){
        //     $order_info = $this->notifyInt->getEmailBody($data);
        //     return view('admin.Mail.order_default')->withRows($order_info);
        // }elseif($data->TYPE == 'Dispatch'){
        //     $order_info = $this->notifyInt->getEmailBody($data);
        //     return view('admin.Mail.order_dispatch')->withRows($order_info);
        // }elseif($data->TYPE == 'Cancel'){
        //     $order_info = $this->notifyInt->getEmailBody($data);
        //     return view('admin.Mail.order_cancel')->withRows($order_info);
        // }elseif($data->TYPE == 'Return'){
        //     $order_info = $this->notifyInt->getEmailBody($data);
        //     return view('admin.Mail.order_return')->withRows($order_info);
        // }elseif($data->TYPE == 'greeting'){
        //     $order_info = $this->notifyInt->getEmailBody($data);
        //     return view('admin.Mail.greeting')->withRows($order_info);
        // }
    }

    public function getSendSms($id)
    {
        $this->resp = $this->notifyInt->getSendSms($id);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getSendEmail($id)
    {
        $this->resp = $this->notifyInt->getSendEmail($id);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getSendAllSms(Request $request)
    {
        //$this->resp = $this->notifyInt->getSendAllSms($request);
        return 1;
    }
}
