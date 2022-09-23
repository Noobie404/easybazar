<?php

namespace App\Http\Controllers\Web;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Web\Subscriber;
class ContactController extends Controller
{

    protected $contact;

    public function __construct(Subscriber $contact)
    {
        $this->contact     = $contact;
    }

    public function getIndex(Request $request){
        $this->resp = $this->contact->getPaginatedList($request);
        return view('admin.web.contact.index')->withData($this->resp->data);
    }

     public function getCreate(){
        return view('admin.web.contact.create');
    }

    public function postStore(Request $request)
    {
        $this->resp = $this->contact->postStore($request);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getEdit(Request $request, $id)
    {
          $this->resp = $this->contact->getShow($id);

        return view('admin.web.contact.edit')->withData($this->resp->data);
    }

    public function postUpdate(Request $request, $id)
    {
        $this->resp = $this->contact->postUpdate($request, $id);
        if (!$this->resp->status) {
            return redirect()->back()->with($this->resp->redirect_class, $this->resp->msg);
        }
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }



}
