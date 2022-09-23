<?php
namespace App\Repositories\Admin\Page;
use DB;
use Auth;
use Image;
use App\Models\Web\Page;
use App\Models\Web\Slider;
use App\Models\Category;
use App\Models\Brand;
use App\Models\HomeSetting;
use App\Traits\RepoResponse;
use Illuminate\Support\Facades\File;

class PageAbstract implements PageInterface
{
    use RepoResponse;

    protected $page;

    public function __construct(Page $page)
    {
        $this->slider     = $page;
    }

    public function getPaginatedList($request, int $per_page = 20)
    {
        $data = $this->slider->orderBy('ORDER_BY', 'DESC')->get();
        return $this->formatResponse(true, '', 'web.home.slider', $data);
    }

    public function getHomeSetting($request){
        $data = [];
        $data['sliders']    = Slider::where('IS_ACTIVE',1)->pluck('TITLE', 'PK_NO');
        $data['category']   = Category::where('IS_ACTIVE',1)->pluck('NAME', 'PK_NO');
        $data['brands']     = Brand::where('IS_ACTIVE',1)->pluck('NAME','PK_NO');
        return $this->formatResponse(true, '', 'web.home.slider', $data);

    }

    public function postSettingUpdate($request){

        DB::beginTransaction();
        try {
        $data = [];
        $home_settings = HomeSetting::where('SECTION_TYPE', $request->section_type)->first();
        if(!empty($home_settings)){
                $home_settings->SECTION_TITLE       = $request->section_title;
                $home_settings->SECTION_POSITION    = $request->section_position;
                $home_settings->SECTION_TITLE_BN    = $request->section_title_bn;
                $home_settings->IS_ACTIVE           = $request->is_active;
                // $home_settings->VALUE               = $request->value;
                if(gettype($request->value) == 'array'){
                    if(!is_null($request->value)){
                        for ($i=0; $i < count($request->value); $i++) {
                            if(!empty($request->value[$i])){
                            $item           = $request->value[$i];
                             array_push($data, $item);
                            }
                        }
                        }
                    $home_settings->VALUE = json_encode($data);
                }
                else {
                    $home_settings->VALUE           = $request->value;
                }
                $home_settings->update();
        }
        else{
                $home_settings                      = new HomeSetting();

                if(gettype($request->value) == 'array'){

                    if(!is_null($request->value)){
                        for ($i=0; $i < count($request->value); $i++) {
                            if(!empty($request->value[$i])){
                            $item           = $request->value[$i];
                             array_push($data, $item);
                            }
                        }
                        }
                    $home_settings->VALUE = json_encode($data);
                }
                else {
                    $home_settings->VALUE               = $request->value;
                }

                $home_settings->SECTION_TYPE        = $request->section_type;
                $home_settings->SECTION_TITLE       = $request->section_title;
                $home_settings->SECTION_TITLE_BN    = $request->section_title_bn;
                $home_settings->SECTION_POSITION    = $request->section_position;
                $home_settings->ORDER_ID            = HomeSetting::max('ORDER_ID')+1;
                $home_settings->IS_ACTIVE           = $request->is_active;

                $home_settings->save();
        }
        }
     catch (\Exception $e) {
          DB::rollback();
          dd($e->getMessage());
        return $this->formatResponse(false, $e->getMessage(), 'web.home.setting');
    }
    DB::commit();
    return $this->formatResponse(true, 'Home Setting has been created successfully !', 'web.home.setting');
    }

    public function sliderUpdate($request){
        // dd($request->all());
        DB::beginTransaction();
        try {
        $data = [];
        $home_settings = HomeSetting::where('SECTION_TYPE', $request->section_type)->first();
        // dd($home_settings);
        if(!empty($home_settings)){
                $home_settings->SECTION_TITLE       = 'Home Top Slider';
                $home_settings->SECTION_POSITION    = $request->section_position;
                $home_settings->VALUE               = $request->slider;
                $home_settings->IS_ACTIVE           = $request->is_active;
                $home_settings->update();
        }
        else{
                $home_settings                      = new HomeSetting();
                $home_settings->SECTION_TYPE        = $request->section_type;
                $home_settings->SECTION_POSITION    = $request->section_position;
                $home_settings->VALUE               = $request->slider;
                $home_settings->IS_ACTIVE           = $request->is_active;
                $home_settings->save();
        }

        }
     catch (\Exception $e) {
          DB::rollback();
          dd($e->getMessage());
        return $this->formatResponse(false, $e->getMessage(), 'web.home.setting');
    }
    DB::commit();
    return $this->formatResponse(true, 'Home Setting has been created successfully !', 'web.home.setting');

    }



    public function postStore($request)
    {
        DB::beginTransaction();
        try {
            $slider                  = new Slider();
            $slider->TITLE           = $request->title;
            $slider->save();
            if(!is_null($request->file('image'))){
                $count = count($request->file('image'));
                for($i=0; $i<$count; $i++)
                {
                  if(!empty($request->file('image')[$i])){
                    $image                      = $request->file('image')[$i];
                    $mobile_path                = $request->file('mobile_image')[$i] ?? NULL;
                    $caption                    = $request->caption[$i] ?? NULL;
                    $custom_link                = $request->custom_link[$i] ?? NULL;
                    $img_lib                    = new SliderPhoto();
                    $img_lib->SLIDER_ID         = $slider->PK_NO;
                    $img_lib->CUSTOM_LINK       = $custom_link;
                    $img_lib->CAPTION           = $caption;
                    $img_lib->RELATIVE_PATH     = $this->uploadImage($image);
                    if(!empty($request->file('mobile_image')[$i])){
                        $img_lib->MOBILE_BANNER   = $this->uploadImage($mobile_path);
                    }
                    $img_lib->save();
                  }
                }
             }
        } catch (\Exception $e) {
              DB::rollback();
              dd($e->getMessage());
            return $this->formatResponse(false, $e->getMessage(), 'web.slider');
        }
        DB::commit();
        return $this->formatResponse(true, 'Slider has been created successfully !', 'web.slider');
    }




    public function uploadImage($image)
    {
      if($image)
      {

        $path1      = 'media/images/slider';
        $img        = Image::make($image->getRealPath());
        if (!file_exists($path1)) {
            mkdir($path1, 0755, true);
        }
        $base_name  = preg_replace('/\..+$/', '', $image->getClientOriginalName());
        $base_name  = explode(' ', $base_name);
        $base_name  = implode('-', $base_name);
        $image_name = $base_name."-".uniqid().'.webp';
        Image::make($img)->save($path1.'/'.$image_name);
          $imageUrl1 = '/'.$path1 .'/'. $image_name;
      }
      return $imageUrl1;
    }

    public function postUpdate($request, $id)
    {

        DB::beginTransaction();
        try {
            $slider                  = Slider::find($id);
            $slider->TITLE           = $request->title;
            $slider->IS_FEATURE      = $request->is_feature;
            // $slider->POSITION        = $request->position;
            $slider->IS_ACTIVE       = $request->is_active;
            $slider->MODIFIED_BY     = Auth::user()->PK_NO;
            $slider->MODIFIED_ON     = date("Y-m-d h:i:s", time());
            $slider->update();

            if(!is_null($request->file('image'))){

                $count = count($request->file('image'));
                for($i=0; $i<$count; $i++)
                {
                  if(!empty($request->file('image')[$i])){
                    $image                      = $request->file('image')[$i];
                    $caption                    = $request->caption[$i] ?? NULL;
                    $custom_link                = $request->custom_link[$i] ?? NULL;
                    $img_lib                    = new SliderPhoto();
                    $img_lib->SLIDER_ID         = $slider->PK_NO;
                    $img_lib->CUSTOM_LINK       = $custom_link ?? NULL;
                    $img_lib->CAPTION           = $caption ?? NULL;
                    $img_lib->RELATIVE_PATH     = $this->uploadImage($image);
                    if(!empty($request->file('mobile_image')[$i])){

                        $mobile_path                = $request->file('mobile_image')[$i];
                        $img_lib->MOBILE_BANNER   = $this->uploadImage($mobile_path);
                    }
                    $img_lib->save();
                  }
                }
             }

        } catch (\Exception $e) {

            dd($e->getMessage());

            DB::rollback();
            return $this->formatResponse(false, 'Unable to update Slider !', 'web.slider');
        }
        DB::commit();
        return $this->formatResponse(true, 'Slider has been updated successfully !', 'web.slider');
    }

    public function getShow(int $id)
    {
        $data['slider'] =  Slider::find($id);
        $data['slider_photo'] =  SliderPhoto::where('SLIDER_ID',$id)->get();
        if (!empty($data)) {
            return $this->formatResponse(true, 'Data found', 'web.slider.edit', $data);
        }
        return $this->formatResponse(false, 'Did not found data !', 'web.slider', null);
    }

    // public function postSettingUpdate($request){
    //     DB::beginTransaction();
    //     try {
    //     $data = [];
    //     $home_settings = HomeSetting::where('SECTION_TYPE', $request->banner_type)->first();
    //     if(!empty($home_settings)){
    //         if(!is_null($request->file('feature_image'))){
    //             for ($i=0; $i < count($request->feature_image); $i++) {
    //                 if(!empty($request->file('feature_image')[$i])){
    //                 $image                  = $request->feature_image[$i];
    //                 $item['RELATIVE_PATH']  = $this->uploadImage($image) ?? NULL;
    //                 $item['TITLE']          = $request->title[$i];
    //                 $item['LINK']           = $request->link[$i];
    //                  array_push($data, $item);
    //                 }
    //             }
    //             }

    //             $home_settings->SECTION_TITLE       = $request->section_title;
    //             $home_settings->SECTION_POSITION    = $request->section_position;
    //             $home_settings->IS_ACTIVE           = $request->is_active;
    //             if(!empty($data)){
    //                 $home_settings->VALUE           = json_encode($data);
    //             }
    //             $home_settings->update();
    //     }
    //     else{
    //             $home_settings              = new HomeSetting();
    //         if(!is_null($request->file('feature_image'))){
    //             for ($i=0; $i < count($request->feature_image); $i++) {
    //                 if(!empty($request->file('feature_image')[$i])){
    //                 $image                  = $request->feature_image[$i];
    //                 $item['RELATIVE_PATH']  = $this->uploadImage($image) ?? NULL;
    //                 $item['TITLE']          = $request->title[$i];
    //                 $item['LINK']           = $request->link[$i];
    //                  array_push($data, $item);
    //                 }
    //             }
    //             }
    //             $home_settings->SECTION_TITLE       = $request->section_title;
    //             $home_settings->SECTION_POSITION    = $request->section_position;
    //             $home_settings->ORDER_ID            = HomeSetting::max('ORDER_ID')+1;
    //             $home_settings->IS_ACTIVE           = $request->is_active;
    //             if(!empty($data)){
    //                 $home_settings->VALUE               = json_encode($data);
    //             }
    //             $home_settings->save();
    //     }
    //     }
    //  catch (\Exception $e) {
    //       DB::rollback();
    //       dd($e->getMessage());
    //     return $this->formatResponse(false, $e->getMessage(), 'web.home.setting');
    // }
    // DB::commit();
    // return $this->formatResponse(true, 'Home Setting has been created successfully !', 'web.home.setting');
    // }



}
