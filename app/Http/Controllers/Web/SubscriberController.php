<?php

namespace App\Http\Controllers\Web;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Web\Subscriber;
class SubscriberController extends Controller
{

    protected $subscriber;

    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber     = $subscriber;
    }

    public function getIndex(Request $request){
        $this->resp = $this->subscriber->getPaginatedList($request);
        return view('admin.web.subscriber.index')->withData($this->resp->data);
    }

     public function getCreate(){
        return view('admin.web.subscriber.create');
    }

    public function postStore(Request $request)
    {
        $this->resp = $this->subscriber->postStore($request);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getEdit(Request $request, $id)
    {
          $this->resp = $this->subscriber->getShow($id);

        return view('admin.web.subscriber.edit')->withData($this->resp->data);
    }

    public function postUpdate(Request $request, $id)
    {
        $this->resp = $this->subscriber->postUpdate($request, $id);
        if (!$this->resp->status) {
            return redirect()->back()->with($this->resp->redirect_class, $this->resp->msg);
        }
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }



}
