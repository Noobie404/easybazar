<?php
namespace App\Traits;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
trait Notification {

    public function sendNotification($encodedData)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $headers = [
            'Authorization: key=' . env('FIREBASE_AUTH_KEY'),
            'Content-Type: application/json',
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        // Close connection
        curl_close($ch);
        // FCM response
        $notification_res = json_decode($result, TRUE);
        return $notification_res;
    }

    public function sendBulkNotification($notice_text,$notice_title,$image){
        $notification_res = NULL;
        $dataArr                = ['click_action' => 'FLUTTER_NOTIFICATION_CLICK', 'status'=>"done"];
            $notification_data      = [
                'title' =>$notice_title,
                'text' => $notice_text,
                'image'=> $image,
                'sound' => 'default',
                'badge' => '1'
            ];
            $arrayToSend = [
                'to' => '/topics/all',
                'notification' => $notification_data,
                'data' => $dataArr,
                'priority'=>'high'
            ];
            $encodedData            = json_encode ($arrayToSend);
            $notification_res = $this->sendNotification($encodedData);
            if($notification_res['success'] > 0){
                if(!empty($notification_res['results']['0']['message_id'])){
                    $message_id       = $notification_res['results']['0']['message_id'];
                }
                DB::table('WEB_NOTIFICATION')->insert([
                    'TITLE' => $notice_title,
                    'BODY'  => $notice_text,
                    'IMAGE' => $image,
                    'NOTIFICATION_TYPE' => 'bulk',
                    'MESSAGE_ID' => $message_id ?? NULL,
                    'STATUS' => 1,
                    'F_USER_NO' => $user_id,
                    'F_SS_CREATED_BY' => Auth::user()->PK_NO,
                    'SS_CREATED_ON' => date('Y-m-d H:i:s'),
                ]);
            }
        return $notification_res;
    }

    public function sendCustomerBulkNotification($notice_text,$notice_title,$image){
        $notification_res = [];
        $devices  = NotificationDevice::whereNotNull('DEVICE_KEY')->pluck('DEVICE_KEY')->all();;
        if($devices){
            $data = [
                "registration_ids" => $devices,
                "notification"  => [
                    "title"     => $notice_title,
                    "body"      => $notice_text,
                    'image'     => $image
                ],
                'priority'     => 'high',
                'openURL'      =>'https://easybazar.com',
                'data' =>[
                    'troubleShootId' => 'delivery'
                ]
            ];
        $encodedData = json_encode($data);
        $notification_res = $this->sendNotification($encodedData);
        }
        if($notification_res['success'] > 0){
            if(!empty($notification_res['results']['0']['message_id'])){
                $message_id       = $notification_res['results']['0']['message_id'];
            }
            DB::table('WEB_NOTIFICATION')->insert([
                'TITLE' => $notice_title,
                'BODY'  => $notice_text,
                'IMAGE' => $image,
                'NOTIFICATION_TYPE' => 'delivery',
                'MESSAGE_ID' => $message_id ?? NULL,
                'STATUS' => 1,
                'F_USER_NO' => $user_id,
                'F_SS_CREATED_BY' => Auth::user()->PK_NO,
                'SS_CREATED_ON' => date('Y-m-d H:i:s'),
            ]);
        }
        return $notification_res;
    }

    public function sendCustomerNotification($customer_id,$notice_text,$notice_title,$image){
        $notification_res = [];
        $devices    = DB::table('WEB_NOTIFICATION_DEVICE')->whereNotNull('FCM_USER_TOKEN')->where('F_CUSTOMER_NO',$customer_id)->pluck('FCM_USER_TOKEN')->all();
        if($devices){
            $data = [
                "registration_ids" => $devices,
                "notification"  => [
                    "title"     => $notice_title,
                    "body"      => $notice_text,
                    'image'     => $image
                ],
                'priority'     => 'high',
                'openURL'      =>'https://easybazar.com',
                'data' =>[
                    'troubleShootId' => 'delivery'
                ]
            ];
        $encodedData = json_encode($data);
        $notification_res = $this->sendNotification($encodedData);
        }
        if($notification_res['success'] > 0){
            if(!empty($notification_res['results']['0']['message_id'])){
                $message_id       = $notification_res['results']['0']['message_id'];
            }
            DB::table('WEB_NOTIFICATION')->insert([
                'TITLE' => $notice_title,
                'BODY'  => $notice_text,
                'IMAGE' => $image,
                'F_CUSTOMER_NO' => $customer_id,
                'NOTIFICATION_TYPE' => 'delivery',
                'MESSAGE_ID' => $message_id ?? NULL,
                'STATUS' => 1,
                'F_SS_CREATED_BY' => Auth::user()->PK_NO,
                'SS_CREATED_ON' => date('Y-m-d H:i:s'),
            ]);
        }
        return $notification_res;
    }

    public function sendUserNotification($user_id,$notice_text,$notice_title,$image)
    {
        $notification_res = [];
        $url        = 'https://fcm.googleapis.com/fcm/send';
        $devices    = DB::table('SA_USER')->whereNotNull('FCM_USER_TOKEN')->where('PK_NO',$user_id)->pluck('FCM_USER_TOKEN')->all();
        if($devices){
            $data = [
                "registration_ids" => $notice_title,
                "notification"  => [
                    "title"     => 'Order assign',
                    "body"      => $notice_text,
                    'image'     => $image
                ],
                'priority'     => 'high',
                'openURL'      =>'https://easybazar.com',
                'data' =>[
                    'troubleShootId' => 'delivery'
                ]
            ];
        $encodedData = json_encode($data);
        $notification_res = $this->sendNotification($encodedData);
        }


        if($notification_res){
            if(!empty($notification_res['results']['0']['message_id'])){
                $message_id       = $notification_res['results']['0']['message_id'];
            }
            DB::table('SA_USER_NOTIFICATION')->insert([
                'TITLE' => $notice_title,
                'BODY'  => $notice_text,
                'IMAGE' => $image,
                'NOTIFICATION_TYPE' => 'delivery',
                'MESSAGE_ID' => $message_id ?? NULL,
                'STATUS' => 1,
                'F_USER_NO' => $user_id,
                'F_SS_CREATED_BY' => Auth::user()->PK_NO,
                'SS_CREATED_ON' => date('Y-m-d H:i:s'),
            ]);
        }
        return $notification_res;
    }

}
