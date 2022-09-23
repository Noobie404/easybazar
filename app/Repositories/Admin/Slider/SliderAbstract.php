<?php
namespace App\Repositories\Admin\Slider;
use DB;
use Auth;
use Image;
use App\Models\Web\Slider;
use App\Traits\RepoResponse;
use App\Models\Web\CustomLink;
use App\Models\Web\SliderPhoto;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;

class SliderAbstract implements SliderInterface
{
    use RepoResponse;

    protected $slider;
    protected $customLink;

    public function __construct(Slider $slider, CustomLink $customLink)
    {
        $this->slider     = $slider;
        $this->customLink = $customLink;
    }

    public function getPaginatedList($request, int $per_page = 20)
    {
        $data = $this->slider->orderBy('ORDER_BY', 'DESC')->get();
        return $this->formatResponse(true, '', 'web.home.slider', $data);
    }



    public function postStore($request)
    {
        DB::beginTransaction();
        try {
            $slider                  = new Slider();
            $slider->TITLE           = $request->title;
            $slider->IS_ACTIVE       = $request->is_active;
            $slider->IS_SLIDER       = $request->is_slider;
            $slider->save();
            if(!is_null($request->file('feature_image'))){
                $count = count($request->file('feature_image'));
                for($i=0; $i<$count; $i++)
                {
                  if(!empty($request->file('feature_image')[$i])){
                    $image                      = $request->file('feature_image')[$i];
                    $mobile_path                = $request->file('mobile_image')[$i] ?? NULL;
                    $caption                    = $request->caption[$i] ?? NULL;
                    $custom_link                = $request->custom_link[$i] ?? NULL;
                    $slider_photo                    = new SliderPhoto();
                    $slider_photo->SLIDER_ID         = $slider->PK_NO;
                    $slider_photo->CUSTOM_LINK       = $custom_link;
                    $slider_photo->CAPTION           = $caption;
                    $slider_photo->RELATIVE_PATH     = $this->uploadImage($image);
                    if(!empty($request->file('mobile_image')[$i])){
                        $slider_photo->MOBILE_BANNER   = $this->uploadImage($mobile_path);
                    }
                    $slider_photo->save();
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
        // dd($request->all());
        DB::beginTransaction();
        try {
            $slider                  = Slider::find($id);
            $slider->TITLE           = $request->title;
            $slider->IS_ACTIVE       = $request->is_active;
            $slider->IS_SLIDER       = $request->is_slider;
            $slider->MODIFIED_BY     = Auth::user()->PK_NO;
            $slider->MODIFIED_ON     = date("Y-m-d h:i:s", time());
            $slider->update();

        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return $this->formatResponse(false, 'Unable to update Slider !', 'web.slider');
        }
        DB::commit();
        return $this->formatResponse(true, 'Slider has been updated successfully !', 'web.slider');
    }

    public function updateSliderPhotos($request,$id)
    {
        DB::beginTransaction();
        try {
        $slider_photo = SliderPhoto::find($id);
        if(!is_null($request->file('feature_image'))){
            if (File::exists(public_path($slider_photo->RELATIVE_PATH))) {
                File::delete(public_path($slider_photo->RELATIVE_PATH));
            }
        $feature_image                  = $request->file('feature_image');
        $slider_photo->RELATIVE_PATH    = $this->uploadImage($feature_image);
        }
        if(!is_null($request->file('mobile_image'))){
            if (File::exists(public_path($slider_photo->MOBILE_BANNER))) {
                File::delete(public_path($slider_photo->MOBILE_BANNER));
            }
        $mobile_image                   = $request->file('mobile_image');
        $slider_photo->MOBILE_BANNER    = $this->uploadImage($mobile_image);
        }
        $slider_photo->CAPTION          = $request->caption;
        $slider_photo->CUSTOM_LINK      = $request->custom_link;
        $slider_photo->F_SS_MODIFIED_BY = Auth::user()->PK_NO;
        $slider_photo->update();
    } catch (\Exception $e) {
        dd($e->getMessage());
        DB::rollback();
        return $this->formatResponse(false, 'Unable to update Slider !', 'web.slider');
    }
    DB::commit();
    return $this->formatResponse(true, 'Slider has been updated successfully !', 'web.slider');
    }

    public function postAddPhotos($request)
    {
        DB::beginTransaction();
        try {
            if(!is_null($request->file('feature_image'))){
                $count = count($request->file('feature_image'));
                for($i=0; $i<$count; $i++)
                {
                  if(!empty($request->file('feature_image')[$i])){
                    $image                      = $request->file('feature_image')[$i];
                    $mobile_path                = $request->file('mobile_image')[$i] ?? NULL;
                    $caption                    = $request->caption[$i] ?? NULL;
                    $custom_link                = $request->custom_link[$i] ?? NULL;
                    $slider_photo                    = new SliderPhoto();
                    $slider_photo->SLIDER_ID         = $request->id;
                    $slider_photo->CUSTOM_LINK       = $custom_link;
                    $slider_photo->CAPTION           = $caption;
                    $slider_photo->RELATIVE_PATH     = $this->uploadImage($image);
                    if(!empty($request->file('mobile_image')[$i])){
                        $slider_photo->MOBILE_BANNER   = $this->uploadImage($mobile_path);
                    }
                    $slider_photo->save();
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

    public function getShow(int $id)
    {
        $data['slider']         = Slider::find($id);
        $data['slider_photo']   = SliderPhoto::where('SLIDER_ID',$id)->get();
        if (!empty($data)) {
            return $this->formatResponse(true, 'Data found', 'web.slider.edit', $data);
        }
        return $this->formatResponse(false, 'Did not found data !', 'web.slider', null);
    }

    public function delete($id)
    {
        DB::begintransaction();
        try {
            $category = Slider::find($id)->delete();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, 'Unable to delete this Slider !', 'web.slider');
        }
        DB::commit();
        return $this->formatResponse(true, 'Successfully delete this Slider !', 'web.slider');
    }


    public function getDeleteSlider($id)
    {
        DB::begintransaction();
        try {
            $slider = SliderPhoto::find($id);
            if (File::exists(public_path($slider->RELATIVE_PATH))) {
                File::delete(public_path($slider->RELATIVE_PATH));
            }
            if (File::exists(public_path($slider->MOBILE_BANNER))) {
                File::delete(public_path($slider->MOBILE_BANNER));
            }
            $slider->delete();

        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, 'Unable to delete this Slider !', 'web.slider');
        }
        DB::commit();
        return $this->formatResponse(true, 'Successfully delete this Slider !', 'web.slider');
    }


    // public function getDeleteImage($id){

    //     DB::begintransaction();
    //     try {
    //         $slider = SliderPhoto::find($id);
    //         if (File::exists(public_path($slider->RELATIVE_PATH))) {
    //             File::delete(public_path($slider->RELATIVE_PATH));
    //         }
    //         if (File::exists(public_path($slider->MOBILE_BANNER))) {
    //             File::delete(public_path($slider->MOBILE_BANNER));
    //         }
    //         $slider->delete();

    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         return $this->formatResponse(false, 'Unable to delete this Slider !', 'web.slider');
    //     }
    //     DB::commit();
    //     return $this->formatResponse(true, 'Successfully delete this Slider !', 'web.slider');

    // }

     /**
     * Up the order of an slider
     */

    public function getOrderUp($id)
    {
      DB::begintransaction();
        try {
      $slider = Slider::select('ORDER_BY')->where('PK_NO', $id)->first();
      $maxOrderId = Slider::max('ORDER_BY');
      if($slider->ORDER_BY >= $maxOrderId)
      {
        return $this->formatResponse(true, 'Slider Order Updated !', 'web.slider');
      }
      else
      {
        $this->updateSliderOrderId($slider->ORDER_BY + 1, 1);
        Slider::where('PK_NO', $id)->update(['ORDER_BY'=> $slider->ORDER_BY + 1]);
      }
    } catch (\Exception $e) {
        DB::rollback();
        return $this->formatResponse(false, 'Unable to Update Slider Order!', 'web.slider');
    }
    DB::commit();
    return $this->formatResponse(true, 'Slider Order Updated !', 'web.slider');

    }


    /**
     * Down the order of an slider
     */

    public function getOrderDown($id)
    {
        DB::begintransaction();

        try {

        $slider = Slider::select('ORDER_BY')->where('PK_NO', $id)->first();

      if($slider->ORDER_BY != 1)
      {
        $this->updateSliderOrderId($slider->ORDER_BY - 1, 0);

        Slider::where('PK_NO', $id)->update(['ORDER_BY'=> $slider->ORDER_BY - 1]);
      }

    } catch (\Exception $e) {
        DB::rollback();
        return $this->formatResponse(false, 'Unable to Update Slider Order!', 'web.slider');
    }

    DB::commit();

    return $this->formatResponse(true, 'Slider Order Updated !', 'web.slider');
    }

     /**
     * Return the slider from an OrderId
     */

    public function updateSliderOrderId($orderId, $orderType)
    {

        $slider = Slider::select('ORDER_BY')->where('ORDER_BY', $orderId)->first();
      if(!empty($slider))
      {
        if($orderType)
        {
            Slider::where('ORDER_BY', $orderId)->update(['ORDER_BY'=>$orderId - 1]);
        }
        else
        {
            Slider::where('ORDER_BY', $orderId)->update(['ORDER_BY'=>$orderId + 1]);
        }
      }

      return true;

    }


    public function getCustomLinks($request, int $per_page = 20)
    {
        $data = $this->customLink->orderBy('PK_NO', 'DESC')->get();
        return $this->formatResponse(true, '', 'web.home.slider', $data);
    }


    public function postCustomLinkStore($request)
    {
        DB::beginTransaction();
        try {
            $link_highlighter                  = new CustomLink();
            $link_highlighter->TITLE           = $request->title;
            $link_highlighter->URL_LINK        = $request->url_link;
            $link_highlighter->TITLE_SOURCE    = $request->source;
            $link_highlighter->IS_ACTIVE       = $request->is_active;
            $link_highlighter->F_TITLE_NO      = $request->title_id;
            $link_highlighter->CREATED_BY      = Auth::user()->PK_NO;
            $link_highlighter->CREATED_ON      = date("Y-m-d h:i:s", time());
            $link_highlighter->START_DATE      = date("Y-m-d", strtotime($request->validity_from));
            $link_highlighter->END_DATE        = date("Y-m-d", strtotime($request->validity_to));

            if($request->file('banner')){
                $path1      = 'media/images/link_highlighter';
                if (!file_exists($path1)) {
                    mkdir($path1, 0755, true);
                }
                $image = $request->file('banner');
                $file_name = 'link_'. date('dmY'). '_' .uniqid(). '.' . $image->getClientOriginalExtension();
                $link_highlighter->IMAGE_NAME     = '/media/images/link_highlighter/'.$file_name;
                $image->move(public_path().'/media/images/link_highlighter/', $file_name);
            }
            $link_highlighter->save();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return $this->formatResponse(false, $e->getMessage(), 'web.home.custom_link');
        }
        DB::commit();

        return $this->formatResponse(true, 'Link highlighter has been created successfully !', 'web.home.custom_link');
    }

    public function postCustomLinkUpdate($request, $id)
    {
        DB::beginTransaction();
        try {

            $link_highlighter                  = CustomLink::find($id);
            $link_highlighter->TITLE           = $request->title;
            $link_highlighter->URL_LINK        = $request->url_link;
            $link_highlighter->TITLE_SOURCE    = $request->source;
            $link_highlighter->IS_ACTIVE       = $request->is_active;
            $link_highlighter->F_TITLE_NO      = $request->title_id;
            $link_highlighter->START_DATE      = date("Y-m-d", strtotime($request->validity_from));
            $link_highlighter->END_DATE        = date("Y-m-d", strtotime($request->validity_to));
            $link_highlighter->MODIFIED_BY     = Auth::user()->PK_NO;
            $link_highlighter->MODIFIED_ON     = date("Y-m-d h:i:s", time());

            if($request->file('banner')){
                $path1      = 'media/images/link_highlighter';
                if (!file_exists($path1)) {
                    mkdir($path1, 0755, true);
                }
                if (File::exists(public_path($link_highlighter->IMAGE_NAME))) {
                    File::delete(public_path($link_highlighter->IMAGE_NAME));
                }
                $image  = $request->file('banner');
                $file_name = 'link_'. date('dmY'). '_' .uniqid(). '.' . $image->getClientOriginalExtension();
                $link_highlighter->IMAGE_NAME     = '/media/images/link_highlighter/'.$file_name;
                $image->move(public_path().'/media/images/link_highlighter/', $file_name);
            }
            $link_highlighter->update();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, 'Unable to update link highlighter !', 'web.home.custom_link');
        }
        DB::commit();
        return $this->formatResponse(true, 'Link highlighter has been updated successfully !', 'web.home.custom_link');
    }

    public function getCustomLinkDelete($id)
    {
        DB::begintransaction();
        try {
            $link_highlighter = CustomLink::find($id);
            if (File::exists(public_path($link_highlighter->IMAGE_NAME))) {
                File::delete(public_path($link_highlighter->IMAGE_NAME));
            }
            $link_highlighter->delete();

        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, 'Unable to delete this link highlighter !', 'web.home.custom_link');
        }
        DB::commit();
        return $this->formatResponse(true, 'Successfully delete this link highlighter !', 'web.home.custom_link');
    }



}
