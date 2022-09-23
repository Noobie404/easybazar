<?php

namespace App\Http\Controllers\Web;

use Auth;
use App\Models\Web\WhatsApp;
use Illuminate\Http\Request;
use App\Models\Web\WebSettings;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\SliderRequest;
use App\Repositories\Admin\Slider\SliderInterface;

class WebSettingsController extends Controller
{

    protected $settings;
    protected $whatsapp;

    public function __construct(WebSettings $settings,WhatsApp $whatsapp)
    {
        $this->settings  = $settings;
        $this->whatsapp  = $whatsapp;
    }


    public function getIndex(Request $request){
        $this->resp = $this->settings->getPaginatedList($request);
        $data['settings'] = $this->resp->data;
        return view('admin.web.settings.index')->withData($data);
    }

    public function postStore(Request $request)
    {
        $this->resp = $this->settings->postStore($request);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function postUpdate(Request $request, $id)
    {
        $this->resp = $this->settings->postUpdate($request, $id);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }


    public function getWhatsAppList(Request $request){
        $this->resp = $this->whatsapp->getPaginatedList($request);
        $data['whatsapp'] = $this->resp->data;
    return view('admin.web.whatsapp.index')->withData($data);
    }

    public function getOrderUp(Request $request, $id)
    {
        $this->resp = $this->whatsapp->getOrderUp($id);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getOrderDown(Request $request, $id)
    {
        $this->resp = $this->whatsapp->getOrderDown($id);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getWhatsAppCreate(){

        return view('admin.web.whatsapp.create');
    }

    public function whatsAppPostStore(Request $request)
    {   $this->resp = $this->whatsapp->postStore($request);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }
    public function getWhatsAppDelete(Request $request, $id)
    {        $this->resp = $this->whatsapp->getDelete($id);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }
    public function getEdit($id){
        $this->resp = $this->whatsapp->getWhatsApp($id);
        return view('admin.web.whatsapp.edit')->with($this->resp->redirect_class, $this->resp->msg)->withData($this->resp->data);
    }
    public function whatsAppPostUpdate(Request $request)
    {   $this->resp = $this->whatsapp->postUpdate($request);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }







}
