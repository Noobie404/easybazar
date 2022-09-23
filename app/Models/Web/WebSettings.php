<?php
namespace App\Models\Web;
use Illuminate\Support\Str;
use App\Traits\RepoResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Database\Eloquent\Model;
use File;
class WebSettings extends Model
{
    use RepoResponse;
    protected $table        = 'WEB_SETTINGS';
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
    public function getPaginatedList($request, int $per_page = 2000)
    {
        $data = $this->first();
        return $this->formatResponse(true, '', 'web.blog.article', $data);
    }
    public function getShow(int $id)
    {
        $data =  Article::find($id);
        if (!empty($data)) {
            return $this->formatResponse(true, 'Data found', 'admin.article.edit', $data);
        }
        return $this->formatResponse(false, 'Did not found data !', 'admin.article.list', null);
    }

    public function postStore($request)
    {
        DB::beginTransaction();
        try {
            if(!empty($request->id)){
                $setting                                       = WebSettings::find($request->id);
                $setting->TITLE                                = $request->title;
                $setting->DESCRIPTION                          = $request->description;
                $setting->PHONE_1                              = $request->phone_1;
                $setting->PHONE_2                              = $request->phone_2;
                $setting->EMAIL_1                              = $request->email_1;
                $setting->EMAIL_2                              = $request->email_2;
                $setting->HQ_ADDRESS                           = $request->address;
                $setting->FACEBOOK_URL                         = $request->facebook;
                $setting->TWITTER_URL                          = $request->twitter;
                $setting->INSTAGRAM_URL                        = $request->instagram;
                $setting->YOUTUBE_URL                          = $request->youtube;
                $setting->PINTEREST_URL                        = $request->pinterest;
                $setting->WHATS_APP                            = $request->whats_app;
                $setting->FB_APP_ID                            = $request->facebook_app;
                $setting->GOOGLE_MAP                           = $request->google_map;
                $setting->ANALYTIC_ID                          = $request->analytic_id;
                $setting->URL                                  = $request->web_url;
                $setting->MAX_LOGIN_ATTEMPT                    = $request->max_login_attempt;
                $setting->FACEBOOK_SECRET_ID                   = $request->facebook_app_secret;
                $setting->GOOGLE_APP_ID                        = $request->google_app;
                $setting->GOOGLE_CLIENT_SECRET                 = $request->google_app_secret;
                $setting->ANDROID_APP_LINK                     = $request->android_app_link;
                $setting->ANDROID_APP_VERSION                  = $request->android_app_version;
                $setting->IPHONE_APP_LINK                      = $request->iphone_app_link;
                $setting->IPHONE_APP_VERSION                   = $request->iphone_app_version;
                $setting->META_TITLE                           = $request->meta_title;
                $setting->LANGUAGE_ID                          = 1;
                $setting->META_KEYWARDS                        = $request->meta_keywards;
                $setting->META_DESCRIPTION                     = $request->meta_description;
                $setting->COPYRIGHT_TEXT                       = $request->copyright;
                $setting->SHIPPING_RETURN                      = $request->shipping_return;
                $setting->LATITUDE                             = $request->latitute;
                $setting->LONGITUDE                            = $request->longitute;
                $setting->INSTA_USERNAME_1                     = $request->insta_user_1;
                $setting->INSTA_USERNAME_2                     = $request->insta_user_2;
                $setting->INSTA_USERNAME_3                     = $request->insta_user_3;
                $setting->INSTA_TOKEN_1                        = $request->access_token_1;
                $setting->INSTA_TOKEN_2                        = $request->access_token_2;
                $setting->INSTA_TOKEN_3                        = $request->access_token_3;
                $setting->STYLE                                = $request->style;
                $setting->ANDROID_VERSION_NAME                 = $request->android_version_name;
                $setting->IPHONE_VERSION_NAME                  = $request->iphone_version_name;
                $setting->APP_UPDATE_MANDATORY                 = $request->app_update_mandatory;

                if ($request->hasFile('header_logo'))
                {
                if (File::exists(public_path($setting->HEADER_LOGO))) {
                    File::delete(public_path($setting->HEADER_LOGO));
                }
                $setting->HEADER_LOGO    = $this->uploadWithExtension($request->header_logo);
                }
                if ($request->hasFile('footer_logo'))
                {
                if (File::exists(public_path($setting->FOOTER_LOGO))) {
                    File::delete(public_path($setting->FOOTER_LOGO));
                }
                $setting->FOOTER_LOGO   = $this->uploadWithExtension($request->footer_logo);
                }
                if ($request->hasFile('app_logo'))
                {
                if (File::exists(public_path($setting->APP_LOGO))) {
                    File::delete(public_path($setting->APP_LOGO));
                }
                $setting->APP_LOGO    = $this->uploadWithExtension($request->app_logo);
                }
                if ($request->hasFile('meta_image'))
                {
                if (File::exists(public_path($setting->META_IMAGE))) {
                        File::delete(public_path($setting->META_IMAGE));
                }
                $setting->META_IMAGE    = $this->uploadImage($request->meta_image);
                }
                if ($request->hasFile('favicon'))
                {
                if (File::exists(public_path($setting->FAVICON))) {
                    File::delete(public_path($setting->FAVICON));
                }
                $setting->FAVICON    = $this->uploadWithExtension($request->favicon);
                }
                if ($request->hasFile('default_banner'))
                {
                if (File::exists(public_path($setting->DEFAULT_BANNER))) {
                    File::delete(public_path($setting->DEFAULT_BANNER));
                }
                $setting->DEFAULT_BANNER    = $this->uploadImage($request->default_banner);
                }

                if ($request->hasFile('cta_banner'))
                {
                if (File::exists(public_path($setting->CTA_BANNER))) {
                    File::delete(public_path($setting->CTA_BANNER));
                }
                $setting->CTA_BANNER        = $this->uploadImage($request->cta_banner);
                }

                if ($request->hasFile('playstore_icon'))
                {
                if (File::exists(public_path($setting->PLAYSTORE_ICON))) {
                    File::delete(public_path($setting->PLAYSTORE_ICON));
                }
                $setting->PLAYSTORE_ICON     = $this->uploadWithExtension($request->playstore_icon);
                }

                if ($request->hasFile('appstore_icon'))
                {
                if (File::exists(public_path($setting->APPSTORE_ICON))) {
                    File::delete(public_path($setting->APPSTORE_ICON));
                }
                $setting->APPSTORE_ICON  = $this->uploadWithExtension($request->appstore_icon);
                }

                if ($request->hasFile('payment_icon'))
                {
                if (File::exists(public_path($setting->FOOTER_PAYMENT_ICON))) {
                    File::delete(public_path($setting->FOOTER_PAYMENT_ICON));
                }
                $setting->FOOTER_PAYMENT_ICON  = $this->uploadWithExtension($request->payment_icon);
                }
                if ($request->hasFile('brand_banner'))
                {
                if (File::exists(public_path($setting->BRAND_BANNER))) {
                    File::delete(public_path($setting->BRAND_BANNER));
                }
                $setting->BRAND_BANNER   = $this->uploadImage($request->brand_banner);
                }
                if ($request->hasFile('offer_banner'))
                {
                if (File::exists(public_path($setting->OFFER_BANNER))) {
                    File::delete(public_path($setting->OFFER_BANNER));
                }
                $setting->OFFER_BANNER    = $this->uploadImage($request->offer_banner);
                }

                if ($request->hasFile('email_header_logo'))
                {
                if (File::exists(public_path($setting->EMAIL_HEADER_LOGO))) {
                    File::delete(public_path($setting->EMAIL_HEADER_LOGO));
                }
                $setting->EMAIL_HEADER_LOGO    = $this->uploadWithExtension($request->email_header_logo);
                }
                if ($request->hasFile('email_footer_logo'))
                {
                if (File::exists(public_path($setting->EMAIL_FOOTER_LOGO))) {
                    File::delete(public_path($setting->EMAIL_FOOTER_LOGO));
                }
                $setting->EMAIL_FOOTER_LOGO    = $this->uploadWithExtension($request->email_footer_logo);
                }

                if ($request->hasFile('azura_payplan_1'))
                {
                if (File::exists(public_path($setting->AZURA_PAYPLAN_1))) {
                    File::delete(public_path($setting->AZURA_PAYPLAN_1));
                }
                $setting->AZURA_PAYPLAN_1    = $this->uploadWithExtension($request->azura_payplan_1);
                }

                if ($request->hasFile('azura_payplan_2'))
                {
                if (File::exists(public_path($setting->AZURA_PAYPLAN_2))) {
                    File::delete(public_path($setting->AZURA_PAYPLAN_2));
                }
                $setting->AZURA_PAYPLAN_2    = $this->uploadWithExtension($request->azura_payplan_2);
                }

                if ($request->hasFile('hoolah_payplan'))
                {
                if (File::exists(public_path($setting->HOOLAH_PAYPLAN))) {
                    File::delete(public_path($setting->HOOLAH_PAYPLAN));
                }
                $setting->HOOLAH_PAYPLAN    = $this->uploadWithExtension($request->hoolah_payplan);
                }

                if ($request->hasFile('grab_payplan'))
                {
                if (File::exists(public_path($setting->GRAB_PAYPLAN))) {
                    File::delete(public_path($setting->GRAB_PAYPLAN));
                }
                $setting->GRAB_PAYPLAN    = $this->uploadWithExtension($request->grab_payplan);
                }
                if ($request->hasFile('billplz_payplan'))
                {
                if (File::exists(public_path($setting->BILLPLZ_PAYPLAN))) {
                    File::delete(public_path($setting->BILLPLZ_PAYPLAN));
                }
                $setting->BILLPLZ_PAYPLAN    = $this->uploadWithExtension($request->billplz_payplan);
                }
                $setting->update();
            }
            else{
                $setting                                       = new WebSettings();
                $setting->TITLE                                = $request->title;
                $setting->DESCRIPTION                          = $request->description;
                $setting->PHONE_1                              = $request->phone_1;
                $setting->PHONE_2                              = $request->phone_2;
                $setting->EMAIL_1                              = $request->email_1;
                $setting->EMAIL_2                              = $request->email_2;
                $setting->HQ_ADDRESS                           = $request->address;
                $setting->FACEBOOK_URL                         = $request->facebook;
                $setting->TWITTER_URL                          = $request->twitter;
                $setting->INSTAGRAM_URL                        = $request->instagram;
                $setting->YOUTUBE_URL                          = $request->youtube;
                $setting->PINTEREST_URL                        = $request->pinterest;
                $setting->FB_APP_ID                            = $request->facebook_app;
                $setting->WHATS_APP                            = $request->whats_app;
                $setting->GOOGLE_MAP                           = $request->google_map;
                $setting->ANALYTIC_ID                          = $request->analytic_id;
                $setting->URL                                  = $request->web_url;
                $setting->FACEBOOK_SECRET_ID                   = $request->facebook_app_secret;
                $setting->GOOGLE_APP_ID                        = $request->google_app;
                $setting->GOOGLE_CLIENT_SECRET                 = $request->google_app_secret;
                $setting->ANDROID_APP_LINK                     = $request->android_app_link;
                $setting->ANDROID_APP_VERSION                  = $request->android_app_version;
                $setting->IPHONE_APP_LINK                      = $request->iphone_app_link;
                $setting->IPHONE_APP_VERSION                   = $request->iphone_app_version;
                $setting->META_TITLE                           = $request->meta_title;
                $setting->LANGUAGE_ID                          = 1;
                $setting->META_KEYWARDS                        = $request->meta_keywards;
                $setting->META_DESCRIPTION                     = $request->meta_description;
                $setting->COPYRIGHT_TEXT                       = $request->copyright;
                $setting->SHIPPING_RETURN                      = $request->shipping_return;
                $setting->LATITUDE                             = $request->latitute;
                $setting->LONGITUDE                            = $request->longitute;
                $setting->STYLE                                = $request->style;
                $setting->ANDROID_VERSION_NAME                 = $request->android_version_name;
                $setting->IPHONE_VERSION_NAME                  = $request->iphone_version_name;
                $setting->APP_UPDATE_MANDATORY                 = $request->app_update_mandatory;
                if ($request->hasFile('header_logo'))
                {
                $setting->HEADER_LOGO   = $this->uploadWithExtension($request->header_logo);
                }
                if ($request->hasFile('footer_logo'))
                {
                $setting->FOOTER_LOGO   = $this->uploadWithExtension($request->footer_logo);
                }
                if ($request->hasFile('app_logo'))
                {
                $setting->APP_LOGO       = $this->uploadWithExtension($request->app_logo);
                }
                if ($request->hasFile('meta_image'))
                {
                $setting->META_IMAGE    = $this->uploadImage($request->meta_image);
                }
                if ($request->hasFile('favicon'))
                {
                $setting->FAVICON       = $this->uploadWithExtension($request->favicon);
                }
                if ($request->hasFile('default_banner'))
                {
                $setting->DEFAULT_BANNER   = $this->uploadImage($request->default_banner);
                }
                if ($request->hasFile('cta_banner'))
                {
                $setting->CTA_BANNER   = $this->uploadImage($request->cta_banner);
                }
                if ($request->hasFile('playstore_icon'))
                {
                $setting->PLAYSTORE_ICON  = $this->uploadWithExtension($request->playstore_icon);
                }
                if ($request->hasFile('appstore_icon'))
                {
                $setting->APPSTORE_ICON   = $this->uploadWithExtension($request->appstore_icon);
                }
                if ($request->hasFile('payment_icon'))
                {
                $setting->FOOTER_PAYMENT_ICON    = $this->uploadWithExtension($request->payment_icon);
                }
                if ($request->hasFile('brand_banner'))
                {
                $setting->BRAND_BANNER    = $this->uploadImage($request->brand_banner);
                }
                if ($request->hasFile('offer_banner'))
                {
                $setting->OFFER_BANNER    = $this->uploadImage($request->offer_banner);
                }
                if ($request->hasFile('email_header_logo'))
                {
                $setting->EMAIL_HEADER_LOGO    = $this->uploadWithExtension($request->email_header_logo);
                }
                if ($request->hasFile('email_footer_logo'))
                {
                $setting->EMAIL_FOOTER_LOGO    = $this->uploadWithExtension($request->email_footer_logo);
                }
                if ($request->hasFile('azura_payplan_1'))
                {
                if (File::exists(public_path($setting->AZURA_PAYPLAN_1))) {
                    File::delete(public_path($setting->AZURA_PAYPLAN_1));
                }
                $setting->AZURA_PAYPLAN_1    = $this->uploadWithExtension($request->azura_payplan_1);
                }

                if ($request->hasFile('azura_payplan_2'))
                {
                if (File::exists(public_path($setting->AZURA_PAYPLAN_2))) {
                    File::delete(public_path($setting->AZURA_PAYPLAN_2));
                }
                $setting->AZURA_PAYPLAN_2    = $this->uploadWithExtension($request->azura_payplan_2);
                }

                if ($request->hasFile('hoolah_payplan'))
                {
                if (File::exists(public_path($setting->HOOLAH_PAYPLAN))) {
                    File::delete(public_path($setting->HOOLAH_PAYPLAN));
                }
                $setting->HOOLAH_PAYPLAN    = $this->uploadWithExtension($request->hoolah_payplan);
                }

                if ($request->hasFile('grab_payplan'))
                {
                if (File::exists(public_path($setting->GRAB_PAYPLAN))) {
                    File::delete(public_path($setting->GRAB_PAYPLAN));
                }
                $setting->GRAB_PAYPLAN    = $this->uploadWithExtension($request->grab_payplan);
                }

                if ($request->hasFile('billplz_payplan'))
                {
                if (File::exists(public_path($setting->BILLPLZ_PAYPLAN))) {
                    File::delete(public_path($setting->BILLPLZ_PAYPLAN));
                }
                $setting->BILLPLZ_PAYPLAN    = $this->uploadWithExtension($request->billplz_payplan);
                }
                $setting->save();
            }
        } catch (\Exception $e) {

            dd($e);
            DB::rollback();
            return $this->formatResponse(false, 'Unable to create settings !', 'web.home.settings');
        }
        DB::commit();
        return $this->formatResponse(true, 'Settings has been created successfully !', 'web.home.settings',$setting->PK_NO);
    }

    public function uploadImage($image)
    {
        if (!is_null($image))
        {
        $image = $image;
        $extension = $image->getClientOriginalExtension();
        $path = 'media/images/logo';
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
        $base_name = preg_replace('/\..+$/', '', $image->getClientOriginalName());
        $base_name = explode(' ', $base_name);
        $base_name = implode('-', $base_name);
        $img = Image::make($image->getRealPath());
        $image = $base_name . "-" . uniqid().'.webp';
        Image::make($img)->save($path.'/'.$image);
        $image_name = '/'.$path .'/'. $image;
            return $image_name;
        }
    }

    public function uploadWithExtension($image){
        if (!is_null($image))
        {
        $image = $image;
        $extension = $image->getClientOriginalExtension();
        $path = 'media/images/logo';
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
        $base_name = preg_replace('/\..+$/', '', $image->getClientOriginalName());
        $base_name = explode(' ', $base_name);
        $base_name = implode('-', $base_name);
        $img = Image::make($image->getRealPath());
        $image = $base_name . "-" . uniqid().'.'.$extension;
        Image::make($img)->save($path.'/'.$image);
        $image_name = '/'.$path .'/'. $image;
            return $image_name;
        }


    }

}
