<?php

namespace App\Http\Controllers\Web;
use Auth;
use App\Models\Web\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Http\Requests\Web\PageRequest;
use App\Repositories\Admin\Page\PageInterface;


class PageController extends Controller
{

    protected $page;
    protected $pageInt;

    public function __construct(Page $page,PageInterface $pageInt)
    {
        $this->page     = $page;
        $this->pageInt  = $pageInt;
    }

    public function getAllPage(Request $request){
        $this->resp = $this->page->getPaginatedList($request);
        $data['pages'] = $this->resp->data;
        return view('admin.web.page.index')->withData($data);
    }

    public function getHomeSetting(Request $request){
        $this->resp = $this->pageInt->getHomeSetting($request);
        return view('admin.web.page.home_page')->withData($this->resp->data);
    }

     public function getCreate(){
        return view('admin.web.page.create');
    }

    public function postStore(Request $request)
    {
        $this->resp = $this->page->postStore($request);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function postSettingUpdate(Request $request)
    {
        $this->resp = $this->pageInt->postSettingUpdate($request);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }
    public function sliderUpdate(Request $request)
    {
        $this->resp = $this->pageInt->sliderUpdate($request);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }





    public function getEdit(Request $request, $id)
    {
          $this->resp = $this->page->getShow($id);

        return view('admin.web.page.edit')->withData($this->resp->data);
    }

    public function postUpdate(Request $request, $id)
    {
        $this->resp = $this->page->postUpdate($request, $id);
        if (!$this->resp->status) {
            return redirect()->back()->with($this->resp->redirect_class, $this->resp->msg);
        }
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getOrderUp(Request $request, $id)
    {
        $this->resp = $this->page->getOrderUp($id);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getOrderDown(Request $request, $id)
    {
        $this->resp = $this->page->getOrderDown($id);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }


    // public function postEditorImageUpload(Request $request)
    // {
    //     $this->resp = $this->page->postUpdate($request, $id);
    //     if (!$this->resp->status) {
    //         return redirect()->back()->with($this->resp->redirect_class, $this->resp->msg);
    //     }
    //     return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    // }

    public function postEditorImageUpload(Request $request)
    {
        if (!is_null($request->file('image')))
        {
        $image = $request->file('image');
        $extension = $image->getClientOriginalExtension();
        $file_path = 'media/images/page';
        $base_name = preg_replace('/\..+$/', '', $image->getClientOriginalName());
        $base_name = explode(' ', $base_name);
        $base_name = implode('-', $base_name);
        $img = Image::make($image->getRealPath());
        $feature_image = $base_name . "-" . uniqid().'.webp';
        Image::make($img)->save($file_path.'/'.$feature_image);
        $image_name = $file_path .'/'. $feature_image;
            return   url('/').'/'.$image_name;
        }
    }

    public function getDelete($id)
    {
        $this->resp = $this->page->getDelete($id);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }
    public function changeActiveStatus(Request $request){

        $id                     = $request->id;
        $article                = Page::findOrFail($id);
        $page->IS_ACTIVE     = !$page->IS_ACTIVE;
        $page->MODIFIED_BY   = Auth::user()->PK_NO;
        $page->update();
        return response()->json($article);
    }

    public function changeFeatureStatus(Request $request){

        $id                     = $request->id;
        $article                = Page::findOrFail($id);
        $page->IS_FEATURE    = !$page->IS_FEATURE;
        $page->MODIFIED_BY   = Auth::user()->PK_NO;
        $page->update();
        return response()->json($article);
    }

}
