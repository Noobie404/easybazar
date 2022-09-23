<?php
namespace App\Repositories\Admin\OfferGroup;
use File;
use DB;
use Str;
use App\Models\Offer;
use App\Models\OfferGroup;
use App\Traits\RepoResponse;

class OfferGroupAbstract implements OfferGroupInterface
{
    use RepoResponse;
    protected $offerGroup;

    public function __construct(OfferGroup $offerGroup)
    {
        $this->offerGroup = $offerGroup;
    }

    public function getPaginatedList($request, int $per_page = 5)
    {
        $data = $this->offerGroup->orderBy('BUNDLE_NAME', 'ASC')->get();
        return $this->formatResponse(true, '', 'admin.offer.list', $data);
    }

    public function postStore($request)
    {

        DB::beginTransaction();
        try {
            $slug = Str::slug(strtolower($request->public_name));
            $check = OfferGroup::where('URL_SLUG', $slug)->first();
            if($check){
                $max_id = OfferGroup::max('PK_NO')+1;
                $slug = $slug."-".$max_id;
            }
            $offer = new OfferGroup();
            $offer->BUNDLE_NAME         = $request->name;
            $offer->BUNDLE_NAME_PUBLIC  = $request->public_name;
            $offer->URL_SLUG            = $slug;
            $offer->save() ;

            if($request->file('image')){
                $offer =  OfferGroup::find($offer->PK_NO);
                $image = $request->file('image');
                $file_name = 'bundle_'. date('dmY'). '_' .uniqid(). '.' . $image->getClientOriginalExtension();
                $offer->IMAGE     = '/media/images/bundlegroup/'.$offer->PK_NO.'/'.$file_name;
                $offer->update();
                $image->move(public_path().'/media/images/bundlegroup/'.$offer->PK_NO.'/', $file_name);
            }

            if($request->file('banner_image')){
                $offer =  OfferGroup::find($offer->PK_NO);
                if (File::exists(public_path($offer->BANNER_IMAGE))) {
                    File::delete(public_path($offer->BANNER_IMAGE));
                }
                $image = $request->file('banner_image');
                $file_name = 'bundle_'. date('dmY'). '_' .uniqid(). '.' . $image->getClientOriginalExtension();
                $offer->BANNER_IMAGE     = '/media/images/bundlegroup/'.$offer->PK_NO.'/'.$file_name;
                $offer->update();
                $image->move(public_path().'/media/images/bundlegroup/'.$offer->PK_NO.'/', $file_name);
            }


            if($request->offers){
                foreach ($request->offers as $key => $value) {
                   Offer::where('PK_NO',$value)->update(['F_BUNDLE_GROUP_NO' => $offer->PK_NO]);
                }
            }

        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            return $this->formatResponse(false, 'Offer group not created successfully !', 'admin.offergroup.list');
        }
        DB::commit();

        return $this->formatResponse(true, 'Offer group has been created successfully !', 'admin.offergroup.list');
    }

    public function postUpdate($request, $pk_no)
    {
        DB::beginTransaction();
        try {
            Offer::where('F_BUNDLE_GROUP_NO',$pk_no)->update(['F_BUNDLE_GROUP_NO' => null]);

            $slug   = Str::slug(strtolower($request->public_name));
            $check  = OfferGroup::where('PK_NO', '!=', $pk_no)->where('URL_SLUG', $slug)->first();
            if($check){
                $max_id = OfferGroup::max('PK_NO')+1;
                $slug = $slug."-".$max_id;
            }
            $offer = OfferGroup::find($pk_no);
            $offer->BUNDLE_NAME         = $request->name;
            $offer->BUNDLE_NAME_PUBLIC  = $request->public_name;
            $offer->URL_SLUG            = $slug;

            if($request->file('image')){
                $offer =  OfferGroup::find($offer->PK_NO);
                $image = $request->file('image');
                $file_name = 'bundle_'. date('dmY'). '_' .uniqid(). '.' . $image->getClientOriginalExtension();
                $offer->IMAGE     = '/media/images/bundlegroup/'.$offer->PK_NO.'/'.$file_name;
                $image->move(public_path().'/media/images/bundlegroup/'.$offer->PK_NO.'/', $file_name);
            }

            if($request->file('banner_image')){
                $offer =  OfferGroup::find($offer->PK_NO);
                $image = $request->file('banner_image');
                $file_name = 'bundle_'. date('dmY'). '_' .uniqid(). '.' . $image->getClientOriginalExtension();
                $offer->BANNER_IMAGE     = '/media/images/bundlegroup/'.$offer->PK_NO.'/'.$file_name;
                $image->move(public_path().'/media/images/bundlegroup/'.$offer->PK_NO.'/', $file_name);
            }

            $offer->update() ;

            if($request->offers){
                foreach ($request->offers as $key => $value) {
                   Offer::where('PK_NO',$value)->update(['F_BUNDLE_GROUP_NO' => $offer->PK_NO]);
                }
            }

        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, 'Offer group not updated successfully !', 'admin.offergroup.list');
        }
            DB::commit();
        return $this->formatResponse(true, 'Offer group has been updated successfully !', 'admin.offergroup.list');

    }

    public function delete($pk_no)
    {
        DB::beginTransaction();
        try {
            Offer::where('F_BUNDLE_GROUP_NO',$pk_no)->update(['F_BUNDLE_GROUP_NO' => null]);
            OfferGroup::where('PK_NO',$pk_no)->delete();

        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false,'Unable to delete offer group','admin.offergroup.list');
        }
            DB::commit();
            return $this->formatResponse(true, 'Successfully deleted offer group', 'admin.offergroup.list');

    }


}
