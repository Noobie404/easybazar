<?php
namespace App\Repositories\Admin\SpCategory;
use Str;
use File;
use Image;
use App\Models\SpCategory;
use App\Traits\RepoResponse;
use Illuminate\Support\Facades\DB;
use App\Models\ProductVariantSpCategoryMap;

class SpCategoryAbstract implements SpCategoryInterface
{
    use RepoResponse;
    protected $sp_category;

    public function __construct(SpCategory $sp_category)
    {
        $this->sp_category = $sp_category;
    }

    public function getSlugByText($txt){
        $str = strtolower($txt);
        $slug = Str::slug($str);
        return $slug;
    }

    public function postStore($request)
    {
        DB::beginTransaction();
        try {
            $sp_category                           = new SpCategory();
            $sp_category->NAME                     = $request->name;
            $sp_category->BN_NAME                  = $request->bn_name;
            if(!empty($request->url_slug)){
                $sp_category->URL_SLUG             = $request->url_slug;
            }
            else {
                $sp_category->URL_SLUG             = $this->getSlugByText($request->name);
            }
            if(!is_null($request->file('thumbnail_image')))
            {
                $sp_category->THUMBNAIL_PATH       = $this->uploadImage($request->thumbnail_image,'thumb');
            }
            if(!is_null($request->file('banner_image')))
            {
                $sp_category->BANNER_PATH          = $this->uploadImage($request->banner_image,'banner');
            }
            if(!is_null($request->file('icon')))
            {
                $sp_category->ICON                 = $this->uploadImage($request->icon,'icon');
            }
            $sp_category->ORDER_ID                 = $request->order_id;
            $sp_category->META_TITLE               = $request->meta_title;
            $sp_category->META_KEYWARDS            = $request->meta_keywards;
            $sp_category->META_DESCRIPTION         = $request->meta_description;
            $sp_category->DESCRIPTION              = $request->description;
            $sp_category->IS_ACTIVE                = $request->is_active ?? 1;
            $sp_category->save();
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), 'product.spcategory.list');
        }
        DB::commit();
        return $this->formatResponse(true, 'Sub Category has been created successfully !', 'product.spcategory.list');
    }

    public function uploadImage($image,$type)
    {
        if($image){
            $filename = pathinfo($image->getClientOriginalName())['filename'];
            $filename = Str::slug(strtolower($filename));

            $destinationPath = 'media/images/spcategory/'.$type;
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $img = Image::make($image->getRealPath());
            $file_unique = $filename. '-' .time();
            $file_name = $file_unique. '.webp';
            Image::make($img)->save($destinationPath.'/'.$file_name);
            // $file_name = time().'-'.str_replace(' ', '', $image->getClientOriginalName());
            $imageUrl1 = '/'.$destinationPath .'/'. $file_name;
        }
        return $imageUrl1;
    }

    public function findOrThrowException($id)
    {
        $data = $this->sub_category->where('PK_NO', '=', $id)->first();
        if (!empty($data)) {
            return $this->formatResponse(true, 'Data found', 'admin.sub_category.edit', $data);
        }
        return $this->formatResponse(false, 'Did not found data !', 'product.spcategory.list', null);
    }

    public function postUpdate($request, $id)
    {
        DB::beginTransaction();
        try {
            $sp_category                    = SpCategory::find($id);
            $sp_category->NAME              = $request->name;
            $sp_category->BN_NAME           = $request->bn_name;
            if(!is_null($request->file('thumbnail_image')))
            {
                if (File::exists(public_path($sp_category->THUMBNAIL_PATH))) {
                    File::delete(public_path($sp_category->THUMBNAIL_PATH));
                }
                $sp_category->THUMBNAIL_PATH       = $this->uploadImage($request->thumbnail_image,'thumb');
            }
            if(!is_null($request->file('banner_image')))
            {
                if (File::exists(public_path($sp_category->BANNER_PATH))) {
                    File::delete(public_path($sp_category->BANNER_PATH));
                }
                $sp_category->BANNER_PATH          = $this->uploadImage($request->banner_image,'banner');
            }
            if(!is_null($request->file('icon')))
            {
                if (File::exists(public_path($sp_category->ICON))) {
                    File::delete(public_path($sp_category->ICON));
                }
                $sp_category->ICON                 = $this->uploadImage($request->icon,'icon');
            }
            $sp_category->ORDER_ID                 = $request->order_id;
            $sp_category->META_TITLE               = $request->meta_title;
            $sp_category->META_KEYWARDS            = $request->meta_keywards;
            $sp_category->META_DESCRIPTION         = $request->meta_description;
            $sp_category->DESCRIPTION              = $request->description;
            $sp_category->IS_ACTIVE                = $request->is_active ?? 1;
            $sp_category->update();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return $this->formatResponse(false, 'Unable to update special category !', 'product.spcategory.list');
        }
        DB::commit();
        return $this->formatResponse(true, 'Special category has been updated successfully !', 'product.spcategory.list');
    }

    public function postSlugUpdate($request)
    {
        DB::beginTransaction();
        try {
            $sp_category                    = SpCategory::find($request->spcategory);
            $sp_category->URL_SLUG          = $request->url_slug;
            $sp_category->IS_SLUG_UPDATED   = 1;
            $sp_category->update();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return $this->formatResponse(false, 'Unable to update special category !', 'product.spcategory.list');
        }
        DB::commit();
        return $this->formatResponse(true, 'Special category has been updated successfully !', 'product.spcategory.list');
    }

    public function getDelete($id)
    {
        DB::begintransaction();
        try {
            $SpCategory= SpCategory::find($id);

            if (File::exists(public_path($SpCategory->THUMBNAIL_PATH))) {
                File::delete(public_path($SpCategory->THUMBNAIL_PATH));
            }
            if (File::exists(public_path($SpCategory->BANNER_PATH))) {
                File::delete(public_path($SpCategory->BANNER_PATH));
            }
            if (File::exists(public_path($SpCategory->ICON))) {
                File::delete(public_path($SpCategory->ICON));
            }
            $SpCategory->delete();
            ProductVariantSpCategoryMap::where('F_PRD_SPCATEGORY',$id)->delete();

        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, 'Unable to delete this action !', 'product.spcategory.list');
        }
        DB::commit();
        return $this->formatResponse(true, 'Successfully delete this action !', 'product.spcategory.list');
    }

    public function getSpCategoryList($request, int $per_page = 10)
    {
        $data = DB::table('PRD_SPECIAL_CATEGORY')->select('PRD_SPECIAL_CATEGORY.*')->orderBy('PRD_SPECIAL_CATEGORY.ORDER_ID', 'DESC')->get();
        return $this->formatResponse(true, '', 'product.spcategory.list', $data);
    }


}
