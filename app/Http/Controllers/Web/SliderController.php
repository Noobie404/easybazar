<?php

namespace App\Http\Controllers\Web;

use DB;
use Auth;
use App\Models\Web\Slider;
use Illuminate\Http\Request;
use App\Models\Web\CustomLink;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\SliderRequest;
use App\Repositories\Admin\Slider\SliderInterface;

class SliderController extends Controller
{

    protected $slider;
    protected $sliderInt;

    public function __construct(SliderInterface $sliderInt, Slider $slider)
    {
        $this->slider  = $slider;
        $this->sliderInt  = $sliderInt;
    }

    public function getAllSlider(Request $request){

        $this->resp = $this->sliderInt->getPaginatedList($request);

        $data['slider'] = $this->resp->data;

        return view('admin.web.slider.index')->withData($data);
    }

    public function getCustomLinks(Request $request){

        $this->resp = $this->sliderInt->getCustomLinks($request);
        $data = $this->resp->data;
        return view('admin.web.slider.custom_link')->withData($data);
    }

     public function createSlider(){
        return view('admin.web.slider.create');
    }

    public function createCustomLink(){
        return view('admin.web.slider.customLink_create');
    }

    public function getCustomLinkSearch(Request $request)
    {
        if($request->get('type') == 0){
            $result = DB::table('PRD_CATEGORY')->select('PK_NO','NAME')
            ->where('IS_ACTIVE',1);

            if($request->get('title')){
                $pieces = explode(" ", $request->get('title'));
                if($pieces){
                    foreach ($pieces as $key => $piece) {
                        $result->where('NAME', 'LIKE', '%' . $piece . '%');
                    }
                }
            }
            $result =  $result->get();
            return $result;
        }elseif($request->get('type') == 1){
            $result = DB::table('PRD_BRAND')->select('PK_NO','NAME')
            ->where('IS_ACTIVE',1);

            if($request->get('title')){
                $pieces = explode(" ", $request->get('title'));
                if($pieces){
                    foreach ($pieces as $key => $piece) {
                        $result->where('NAME', 'LIKE', '%' . $piece . '%');
                    }
                }
            }
            $result =  $result->get();
            return $result;
        }
    }

    public function postStore(Request $request)
    {
        $this->resp = $this->sliderInt->postStore($request);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);

    }

    public function postCustomLinkStore(SliderRequest $request)
    {
        $this->resp = $this->sliderInt->postCustomLinkStore($request);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);

    }

    public function getEdit(Request $request, $id)
    {
        $data[] = '';
        $this->resp = $this->sliderInt->getShow($id);
        if (!$this->resp->status) {
            return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
        }
        return view('admin.web.slider.edit')->withData($this->resp->data);
    }

    public function getCustomLink($id)
    {
        $data = CustomLink::find($id);
        if (isset($data) && !empty($data)) {
            return view('admin.web.slider.custom_link_edit')->withData($data);
        }
        return redirect()->route('web.home.custom_link')->with('flashMessageError', 'Data not found !');
    }

    public function postUpdate(Request $request, $id)
    {
        $this->resp = $this->sliderInt->postUpdate($request, $id);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }


    public function updateSliderPhotos(Request $request, $id)
    {
        $this->resp = $this->sliderInt->updateSliderPhotos($request, $id);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function postAddPhotos(Request $request)
    {
        $this->resp = $this->sliderInt->postAddPhotos($request);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }







    public function postCustomLinkUpdate(SliderRequest $request, $id)
    {
        $this->resp = $this->sliderInt->postCustomLinkUpdate($request, $id);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }


    public function getDelete($id)
    {
        $this->resp = $this->sliderInt->delete($id);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getDeleteSliderImage($id)
    {
        $this->resp = $this->sliderInt->getDeleteSlider($id);
        return response()->json($this->resp);
    }


    public function getDeleteSlider($id)
    {
        $this->resp = $this->sliderInt->getDeleteSlider($id);

         return response()->json($this->resp);
    }




    public function getCustomLinkDelete($id)
    {
        $this->resp = $this->sliderInt->getCustomLinkDelete($id);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getOrderUp(Request $request, $id)
    {
        $this->resp = $this->sliderInt->getOrderUp($id);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getOrderDown(Request $request, $id)
    {
        $this->resp = $this->sliderInt->getOrderDown($id);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }









    public function changeFeatureStatus(Request $request){

        $id                   = $request->id;
        $slider               = Slider::findOrFail($id);
        $slider->IS_FEATURE   = !$slider->IS_FEATURE;
        $slider->MODIFIED_BY  = Auth::user()->PK_NO;
        $slider->update();
        return response()->json($slider);
    }

}
