<?php
namespace App\Models\Web;
use Illuminate\Support\Str;
use App\Traits\RepoResponse;
use App\Models\Web\BlogCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Database\Eloquent\Model;
use File;

class Page extends Model
{
    use RepoResponse;
    protected $table        = 'WEB_PAGES';
    protected $primaryKey   = 'PK_NO';
    public $timestamps      = false;
    const CREATED_AT        = 'SS_CREATED_ON';
    const UPDATED_AT        = 'SS_MODIFIED_ON';

    public static function boot()
    {
        parent::boot();
        static::creating(function($model)
        {
           $user = Auth::user();
           $model->F_SS_CREATED_BY = $user->PK_NO;
        });

        static::updating(function($model)
        {
           $user = Auth::user();
           $model->F_SS_MODIFIED_BY = $user->PK_NO;
        });
    }
    public function getPaginatedList($request, int $per_page = 20)
    {
        $data = $this->orderBy('ORDER_ID','DESC')->paginate($per_page);

        return $this->formatResponse(true, '', 'web.page', $data);
    }
    public function getShow(int $id)
    {
        $data =  Page::find($id);
        if (!empty($data)) {
            return $this->formatResponse(true, 'Data found', 'web.page.edit', $data);
        }
        return $this->formatResponse(false, 'Did not found data !', 'web.page', null);
    }

    public function postStore($request)
    {
        DB::beginTransaction();
        try {
            $page                                       = new Page();
            $page->TITLE                                = $request->title;
            $str                                        = strtolower($request->title);
            $page->URL_SLUG                             = Str::slug($str);
            $page->SUB_TITLE                            = $request->subtitle;
            $page->BODY                                 = $request->body;
            $page->ICON                                 = $request->icon;
            $page->FOR_APP                              = $request->for_app ?? 0;
            $page->IS_ACTIVE                            = $request->is_active;
            $page->ORDER_ID                             = Page::max('ORDER_ID')+1;
            $page->META_KEYWARDS                        = $request->meta_keywards;
            $page->META_DESCRIPTION                     = $request->meta_description;
            $page->SECTION                              = $request->section;
            if ($request->hasFile('feature_image'))
            {
            $image              = $request->file('feature_image');
            $feature_path       = 'media/images/page';
            $base_name          = preg_replace('/\..+$/', '', $image->getClientOriginalName());
            $base_name          = explode(' ', $base_name);
            $base_name          = implode('-', $base_name);
            if (!file_exists($feature_path)) {
                mkdir($feature_path, 0755, true);
            }
            $img                = Image::make($image->getRealPath());
            $feature_image      = $base_name . "-" . uniqid().'.webp';
            Image::make($img)->save($feature_path.'/'.$feature_image);
            $page->FEATURE_IMAGE      = '/'.$feature_path .'/'. $feature_image;
            }

            if ($request->hasFile('banner_image'))
            {
            $image              = $request->file('banner_image');
            $banner_path       = 'media/images/page';
            $base_name          = preg_replace('/\..+$/', '', $image->getClientOriginalName());
            $base_name          = explode(' ', $base_name);
            $base_name          = implode('-', $base_name);
            if (!file_exists($banner_path)) {
                mkdir($banner_path, 0755, true);
            }
            $img                = Image::make($image->getRealPath());
            $banner_image      = $base_name . "-" . uniqid().'.webp';
            Image::make($img)->save($banner_path.'/'.$banner_image);
            $page->BANNER      = '/'.$banner_path .'/'. $banner_image;
            }
            $page->save();
        } catch (\Exception $e) {
            dd($e);
              DB::rollback();
            return $this->formatResponse(false, 'Unable to create page !', 'web.page.create');
        }
        DB::commit();
        return $this->formatResponse(true, 'page has been created successfully !', 'web.page',$page->PK_NO);
    }

     public function postUpdate($request)
    {
        DB::beginTransaction();
        try {
            $page                                       = Page::findOrFail($request->id);
            $page->TITLE                                = $request->title;
            $str                                        = strtolower($request->title);
            $page->URL_SLUG                             = Str::slug($str);
            $page->SUB_TITLE                            = $request->subtitle;
            $page->BODY                                 = $request->body;
            $page->ICON                                 = $request->icon;
            $page->FOR_APP                              = $request->for_app ?? 0;
            $page->IS_ACTIVE                            = $request->is_active;
           // $page->ORDER_ID                             = Page::max('ORDER_ID')+1;
            $page->META_KEYWARDS                        = $request->meta_keywards;
            $page->META_DESCRIPTION                     = $request->meta_description;
            $page->SECTION                              = $request->section;
            if ($request->hasFile('feature_image'))
            {
                if (File::exists(public_path($page->FEATURE_IMAGE))) {
                    File::delete(public_path($page->FEATURE_IMAGE));
                }
            $image              = $request->file('feature_image');
            $extension          = $image->getClientOriginalExtension();
            $feature_path       = 'media/images/page';
            $thumb_path         = 'media/images/page/thumb';
            $base_name          = preg_replace('/\..+$/', '', $image->getClientOriginalName());
            $base_name          = explode(' ', $base_name);
            $base_name          = implode('-', $base_name);
            // if (!file_exists($feature_path)) {
            //     mkdir($feature_path, 0755, true);
            // }
            $img                = Image::make($image->getRealPath());
            $feature_image      = $base_name . "-" . uniqid().'.webp';
            Image::make($img)->save($feature_path.'/'.$feature_image);
            $page->FEATURE_IMAGE      = '/'.$feature_path .'/'. $feature_image;
            }

            if ($request->hasFile('banner_image'))
            {
            if (File::exists(public_path($page->BANNER))) {
                File::delete(public_path($page->BANNER));
            }
            $image              = $request->file('banner_image');
            $extension          = $image->getClientOriginalExtension();
            $feature_path       = 'media/images/page';
            $thumb_path         = 'media/images/page/thumb';
            $base_name          = preg_replace('/\..+$/', '', $image->getClientOriginalName());
            $base_name          = explode(' ', $base_name);
            $base_name          = implode('-', $base_name);
            if (!file_exists($feature_path)) {
                mkdir($feature_path, 0755, true);
            }
            $img                = Image::make($image->getRealPath());
            $banner_image      = $base_name . "-" . uniqid().'.webp';
            Image::make($img)->save($feature_path.'/'.$banner_image);
            $page->BANNER      = '/'.$feature_path .'/'. $banner_image;
            }
            $page->save();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, 'Unable to create page !', 'web.page.edit',$request->id);
        }
        DB::commit();
        return $this->formatResponse(true, 'page has been created successfully !', 'web.page',$page->PK_NO);
    }

    public function getDelete(int $id)
    {
        DB::begintransaction();
        try {
            $page = Page::find($id)->delete();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, 'Unable to delete product !', 'web.page');
        }
        DB::commit();
        return $this->formatResponse(true, 'Successfully delete page !', 'web.page');
    }

    public function getOrderUp($id)
    {
      DB::begintransaction();

        try {
      $pages     = DB::table('WEB_PAGES')->select('ORDER_ID')->where('PK_NO', $id)->first();

      $maxOrderId   = DB::table('WEB_PAGES')->max('ORDER_ID');

      if($pages->ORDER_ID >= $maxOrderId)
      {
        return $this->formatResponse(true, 'Page Order Updated !', 'web.page');
      }
      else
      {
        $this->updatePageOrderId($pages->ORDER_ID + 1, 1);
        DB::table('WEB_PAGES')->where('PK_NO', $id)->update(['ORDER_ID'=> $pages->ORDER_ID + 1]);
      }
    } catch (\Exception $e) {
        dd($e);
        DB::rollback();
        return $this->formatResponse(false, 'Unable to Update Page Order!', 'web.page');
    }
    DB::commit();
    return $this->formatResponse(true, 'Page Order Updated !', 'web.page');
    }

    public function getOrderDown($id)
    {
        DB::begintransaction();
        try {
        $pages = DB::table('WEB_PAGES')->select('ORDER_ID')->where('PK_NO', $id)->first();
      if($pages->ORDER_ID != 1)
      {
        $this->updatePageOrderId($pages->ORDER_ID - 1, 0);
        DB::table('WEB_PAGES')->where('PK_NO', $id)->update(['ORDER_ID'=> $pages->ORDER_ID - 1]);
      }
    } catch (\Exception $e) {
        DB::rollback();
        return $this->formatResponse(false, 'Unable to Update Page Order!', 'web.page');
    }
    DB::commit();
    return $this->formatResponse(true, 'Page Order Updated !', 'web.page');
    }

    public function updatePageOrderId($orderId, $orderType)
    {
        $pages = DB::table('WEB_PAGES')->select('ORDER_ID')->where('ORDER_ID', $orderId)->first();
      if(!empty($pages))
      {
        if($orderType)
        {
            DB::table('WEB_PAGES')->where('ORDER_ID', $orderId)->update(['ORDER_ID'=>$orderId - 1]);
        }
        else
        {
            DB::table('WEB_PAGES')->where('ORDER_ID', $orderId)->update(['ORDER_ID'=>$orderId + 1]);
        }
      }
      return true;
    }

}
