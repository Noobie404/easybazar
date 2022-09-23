<?php
namespace App\Repositories\Admin\Notification;
use DB;
use Image;
use App\User;
use App\Traits\Notification;
use App\Traits\RepoResponse;
use App\Models\Web\PushNotification;
use App\Models\Web\NotificationDevice;

class NotificationAbstract implements NotificationInterface
{
    use RepoResponse;
    use Notification;

    protected $notification;
    protected $server_key;

    public function __construct(PushNotification $notification)
    {
        $this->notification     = $notification;
        $this->server_key       = env('FIREBASE_AUTH_KEY');
    }

    public function getPaginatedList($request, int $per_page = 50)
    {
        $data = User::whereNotNull('FCM_USER_TOKEN')->pluck('FCM_USER_TOKEN')->all();

        //$this->notification->orderBy('PK_NO', 'DESC')->paginate($per_page);
        return $this->formatResponse(true, '', 'web.notification', $data);
    }

    public function getDeviceList($request, int $per_page = 500)
    {
        $data =User::whereNotNull('FCM_USER_TOKEN')->get();

        // DB::table('WEB_NOTIFICATION_DEVICE')->select('WEB_NOTIFICATION_DEVICE.*','SLS_CUSTOMERS.NAME')
        // ->leftJoin('SLS_CUSTOMERS','WEB_NOTIFICATION_DEVICE.CUSTOMER_ID','SLS_CUSTOMERS.PK_NO')
        // ->orderBy('PK_NO', 'DESC')
        // ->paginate($per_page);

        return $this->formatResponse(true, '', 'web.notification.device-list', $data);
    }

    public function postAppBulkSend($request)
    {
        DB::beginTransaction();
        try {
            $notice_text = $request->body;
            $notice_title = $request->title;
            $image = $request->image;
            $notification_res = $this->sendBulkNotification($notice_text,$notice_title,$image);
        } catch (\Exception $e) {
              DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), 'web.notification.create');
        }
        DB::commit();
        return $this->formatResponse(true, 'Notification has been created successfully !', 'web.notification');
    }

    public function sendWebNotification($request)
    {
        DB::beginTransaction();
        try {
            $notice_title    = $request->title;
            $notice_text     = $request->body;
            $image           = $request->image;
            $notification_res = $this->sendCustomerBulkNotification($notice_text,$notice_title,$image);
        } catch (\Exception $e) {
            dd($e);
              DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), 'web.web-notification.create');
        }
        DB::commit();
        return $this->formatResponse(true, 'Notification has been created successfully !', 'web.notification');
    }


    public function ajaxImageUpload($request){

        if (!is_null($request->file('image')))
        {
        $image              = $request->file('image');
        $extension          = $image->getClientOriginalExtension();
        $destinationPath1   = 'media/images/ads';
        if (!file_exists($destinationPath1)) {
            mkdir($destinationPath1, 0755, true);
        }
        $base_name          = preg_replace('/\..+$/', '', $image->getClientOriginalName());
        $base_name          = explode(' ', $base_name);
        $base_name          = implode('-', $base_name);
        $img                = Image::make($image->getRealPath());
        $feature_image      = $base_name . "-" . uniqid().'.webp';
        Image::make($img)->save($destinationPath1.'/'.$feature_image);
        $image_name         = url('/') . '/' .$destinationPath1 .'/'. $feature_image;
        return $image_name;
        }
    }

    public function postToken($request){

        DB::beginTransaction();
        try {
            $token               = $request->token;
            $user                = User::find(Auth::user()->PK_NO);
            $user->FCM_USER_TOKEN    = $token;
            $user->update();
            } catch (\Exception $e) {

                DB::rollback();
                return $this->formatResponse(false, 'something wrong !', '');
            }
            DB::commit();
            return $this->formatResponse(true, 'Token successfully Saved !','',$user);
    }

    public function postBulkToken($request){
        $msg = '';
        DB::beginTransaction();
        try {
            $notification = NotificationDevice::where('DEVICE_KEY',$request->token)->first();
            if(is_null($notification)){
                $token                      = $request->token;
                $notification               = new NotificationDevice();
                $notification->DEVICE_KEY   = $token;
                if(Auth::check()){
                $notification->CUSTOMER_ID   = Auth::user()->PK_NO;
                }
                $notification->save();
                $msg = 'Token successfully Saved !';
            }
            else{
                $msg = 'Token already exist !';
            }
            } catch (\Exception $e) {
                DB::rollback();
                return $this->formatResponse(false, 'something wrong !', '');
            }
            DB::commit();
            return $this->formatResponse(true,$msg,'',$notification);
    }


}
