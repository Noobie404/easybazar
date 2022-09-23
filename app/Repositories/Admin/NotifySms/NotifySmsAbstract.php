<?php
namespace App\Repositories\Admin\NotifySms;

use DB;
use Carbon\Carbon;
use App\Traits\SMS;
use Billplz\Client;
use App\Traits\MAIL;
use App\Models\Order;
use App\Models\Stock;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Dispatch;
use App\Models\Reseller;
use App\Models\NotifySms;
use App\Models\OrderPayment;
use App\Traits\RepoResponse;
use App\Models\OnlinePayment;
use App\Models\PaymentCustomer;
use App\Models\PaymentReseller;
use App\Models\SmsNotification;
use App\Models\EmailNotification;
use Http\Client\Common\HttpMethodsClient;
use Http\Adapter\Guzzle7\Client as GuzzleHttpClient;
use Http\Message\MessageFactory\GuzzleMessageFactory;

class NotifySmsAbstract implements NotifySmsInterface
{
    use RepoResponse;
    use SMS;
    use MAIL;

    protected $notifySms;
    protected $notifyEmail;

    public function __construct(NotifySms $notifySms,EmailNotification $notifyEmail)
    {
        $this->notifySms    = $notifySms;
        $this->notifyEmail  = $notifyEmail;
    }

    public function getPaginatedList($request, int $per_page = 5)
    {
        if($request->type == 'success'){
            $data = $this->notifySms->orderBy('F_BOOKING_NO', 'DESC')->where('IS_SEND',1)->get();
        }else{
            $data = $this->notifySms
            ->where('IS_SEND',0)
            ->orderBy('PK_NO', 'DESC')
            ->get();
            // ->orderBy('F_BOOKING_NO', 'ASC')
            // dd($data);
        }

        return $this->formatResponse(true, '', 'admin.notify_sms.list', $data);
    }

    public function getEmailIndex($request)
    {
        if($request->type == 'success'){
            $data = $this->notifyEmail->orderBy('F_BOOKING_NO', 'DESC')->where('IS_SEND',1)->get();
        }else{
            $data = $this->notifyEmail
            ->where('IS_SEND',0)
            ->orderBy('PK_NO', 'DESC')
            ->get();
        }
        return $this->formatResponse(true, '', 'admin.notify_sms.list', $data);
    }

    public function getSendSms($id){

        DB::beginTransaction();
        try {
            $noti       = NotifySms::find($id);
            $send_to    = ltrim($noti->MOBILE_NO,'+');
            $sms_body   = $noti->BODY;
            $smsRes = $this->sendsms($send_to, $sms_body);

            if($smsRes){
                NotifySms::where('PK_NO',$id)->update(['IS_SEND' => 1, 'SEND_AT' => date('Y-m-d H:i:s')]);
            }

        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), 'admin.notify_sms.list');
        }
        DB::commit();
        return $this->formatResponse(true, 'SMS has been send successfully !', 'admin.notify_sms.list');
    }

    public function getSendEmail($id){
        $emailRes = 0;
        DB::beginTransaction();
        try {
            $notis   = DB::table('SLS_NOTIFICATION_EMAIL')->where('IS_SEND',0)->whereNotNull('EMAIL')->where('PK_NO',$id)->first();
            if(isset($notis)){
                    // $mail_body = $this->getEmailBody($notis->PK_NO);
                    if($notis->TYPE == 'Arrival' && isset($notis->EMAIL)){
                        $emailRes   = $this->orderArrivalEmail($notis->BODY,$notis->EMAIL);
                        if($emailRes == 1){
                            DB::table('SLS_NOTIFICATION_EMAIL')->where('PK_NO',$notis->PK_NO)->update(['IS_SEND' => 1, 'SEND_AT' => date('Y-m-d H:i:s')]);
                        }
                    }elseif($notis->TYPE == 'Default' && isset($notis->EMAIL)){
                        $emailRes   = $this->orderDefaultEmail($notis->BODY,$notis->EMAIL);
                        if($emailRes == 1){
                            DB::table('SLS_NOTIFICATION_EMAIL')->where('PK_NO',$notis->PK_NO)->update(['IS_SEND' => 1, 'SEND_AT' => date('Y-m-d H:i:s')]);
                        }
                    }elseif($notis->TYPE == 'Dispatch' && isset($notis->EMAIL)){
                        $emailRes   = $this->orderDispatchEmail($notis->BODY,$notis->EMAIL);
                        if($emailRes == 1){
                            DB::table('SLS_NOTIFICATION_EMAIL')->where('PK_NO',$notis->PK_NO)->update(['IS_SEND' => 1, 'SEND_AT' => date('Y-m-d H:i:s')]);
                        }
                    }elseif($notis->TYPE == 'Cancel' && isset($notis->EMAIL)){
                        $emailRes   = $this->orderCancelEmail($notis->BODY,$notis->EMAIL);
                        if($emailRes == 1){
                            DB::table('SLS_NOTIFICATION_EMAIL')->where('PK_NO',$notis->PK_NO)->update(['IS_SEND' => 1, 'SEND_AT' => date('Y-m-d H:i:s')]);
                        }
                    }elseif($notis->TYPE == 'Order Create' && isset($notis->EMAIL)){
                        $emailRes   = $this->orderCreateEndEmail($notis->BODY,$notis->EMAIL);
                        if($emailRes == 1){
                            DB::table('SLS_NOTIFICATION_EMAIL')->where('PK_NO',$notis->PK_NO)->update(['IS_SEND' => 1, 'SEND_AT' => date('Y-m-d H:i:s')]);
                        }
                    }elseif($notis->TYPE == 'Return' && isset($notis->EMAIL)){
                        $emailRes   = $this->orderReturntEmail($notis->BODY,$notis->EMAIL);
                        if($emailRes == 1){
                            DB::table('SLS_NOTIFICATION_EMAIL')->where('PK_NO',$notis->PK_NO)->update(['IS_SEND' => 1, 'SEND_AT' => date('Y-m-d H:i:s')]);
                        }
                    }elseif($notis->TYPE == 'greeting' && isset($notis->EMAIL)){
                        $emailRes   = $this->greetingEmail($notis->BODY,$notis->EMAIL);
                        if($emailRes == 1){
                            DB::table('SLS_NOTIFICATION_EMAIL')->where('PK_NO',$notis->PK_NO)->update(['IS_SEND' => 1, 'SEND_AT' => date('Y-m-d H:i:s')]);
                        }
                    }elseif($notis->TYPE == 'Order Payment' && isset($notis->EMAIL)){
                        $emailRes   = $this->orderPaymentEmail($notis->BODY,$notis->EMAIL);
                        if($emailRes == 1){
                            DB::table('SLS_NOTIFICATION_EMAIL')->where('PK_NO',$notis->PK_NO)->update(['IS_SEND' => 1, 'SEND_AT' => date('Y-m-d H:i:s')]);
                        }
                    }elseif($notis->TYPE == 'Payment Confirmation' && isset($notis->EMAIL)){
                        $emailRes   = $this->orderPaymentConfirmationEmail($notis->BODY,$notis->EMAIL);
                        if($emailRes == 1){
                            DB::table('SLS_NOTIFICATION_EMAIL')->where('PK_NO',$notis->PK_NO)->update(['IS_SEND' => 1, 'SEND_AT' => date('Y-m-d H:i:s')]);
                        }
                    }
            }else{
                return $this->formatResponse(false, 'Invalid Email Address !', 'admin.notify_email.list');
            }
        } catch (\Exception $e) {
        DB::rollback();
        dd($e);
        return $this->formatResponse(false, $e->getMessage(), 'admin.notify_email.list');
        }
        DB::commit();

        if ($emailRes == 1) {
            return $this->formatResponse(true, 'Mail send successfully !', 'admin.notify_email.list');
        }
        return $this->formatResponse(false, 'Please try again !', 'admin.notify_email.list');
    }

    public function getSendAllSms($request){

        DB::beginTransaction();
        try {
            $notis   = NotifySms::where('IS_SEND',0)->get();
            if($notis){
                foreach ($notis as $key => $value) {
                    $send_to    = ltrim($value->MOBILE_NO,'+');
                    $sms_body   = $value->BODY;
                    $smsRes     = $this->sendsms($send_to, $sms_body);
                    if($smsRes){
                        NotifySms::where('PK_NO',$value->PK_NO)->update(['IS_SEND' => 1, 'SEND_AT' => date('Y-m-d H:i:s')]);
                    }
                }
            }
        } catch (\Exception $e) {
        DB::rollback();
        return $this->formatResponse(false, $e->getMessage(), 'admin.notify_sms.list');
        }
        DB::commit();
        return $this->formatResponse(true, 'SMS has been send successfully !', 'admin.notify_sms.list');
    }

    public function generateDefaultReminderSms($booking_id,$last_msg_noti,$daysAdd7)
    {
        DB::beginTransaction();
        try{
            $booking = Booking::select('PK_NO','BOOKING_NO','IS_RESELLER','F_CUSTOMER_NO','F_RESELLER_NO')->where('PK_NO',$booking_id)->first();
            if ($last_msg_noti) {
                $sms_body = "RM0.00 AZURAMART:#ORD-".$booking->BOOKING_NO." Arrival SMS sent on ".$last_msg_noti.", Please pay rest by ".$daysAdd7." to avoid default. For more please Whatsapp http://linktr.ee/azuramart";
                $email_body = "your order arrival SMS sent on ".$last_msg_noti.", Please pay rest by ".$daysAdd7." to avoid default.";
            }else{
                $sms_body = "RM0.00 AZURAMART:#ORD-".$booking->BOOKING_NO." Please pay rest by ".$daysAdd7." to avoid default. For more please Whatsapp http://linktr.ee/azuramart";
                $email_body = "your order is due, please pay rest by ".$daysAdd7." to avoid default.";
            }

            $noti = new SmsNotification();
            $noti->TYPE = 'Default Reminder';
            $noti->F_BOOKING_NO = $booking_id;
            $noti->BODY = $sms_body;
            $noti->F_SS_CREATED_BY = 1;
            if($booking->IS_RESELLER == 0){
                $noti->CUSTOMER_NO = $booking->F_CUSTOMER_NO;
                $noti->IS_RESELLER = 0;
            }else{
                $noti->RESELLER_NO = $booking->F_RESELLER_NO;
                $noti->IS_RESELLER = 1;
            }
            $noti->save();
            if($booking->getOrder->DELIVERY_EMAIL != '' && !empty($booking->getOrder->DELIVERY_EMAIL)){
                $email = new EmailNotification();
                $email->TYPE = 'Default Reminder';
                $email->F_BOOKING_NO = $booking_id;
                $email->F_SS_CREATED_BY = 1;
                if($booking->IS_RESELLER == 0){
                    $email->CUSTOMER_NO = $booking->F_CUSTOMER_NO;
                    $email->IS_RESELLER = 0;
                }else{
                    $email->RESELLER_NO = $booking->F_RESELLER_NO;
                    $email->IS_RESELLER = 1;
                }
                $email->save();
                $mail_body = $this->getEmailBody($email,$daysAdd7);
                $mail_body = view('admin.Mail.default_reminder')
                ->with('rows', $mail_body)
                ->with('content', $email_body)
                ->render();
                $email->BODY = $mail_body;
                $email->save();
            }
        } catch (\Exception $e) {
            DB::rollback();
            return 0;
        }
        DB::commit();
        return 1;
    }

    public function generateDefaultSms($booking_id)
    {
        DB::beginTransaction();
        try{
            $booking = Booking::select('PK_NO','BOOKING_NO','IS_RESELLER','F_CUSTOMER_NO','F_RESELLER_NO')->where('PK_NO',$booking_id)->first();
            $sms_body = "RM0.00 AZURAMART:#ORD-".$booking->BOOKING_NO." Your order has been default. For more please Whatsapp http://linktr.ee/azuramart";

            $noti = new SmsNotification();
            $noti->TYPE = 'Default';
            $noti->F_BOOKING_NO = $booking_id;
            $noti->BODY = $sms_body;
            $noti->F_SS_CREATED_BY = 1;
            if($booking->IS_RESELLER == 0){
                $noti->CUSTOMER_NO = $booking->F_CUSTOMER_NO;
                $noti->IS_RESELLER = 0;
            }else{
                $noti->RESELLER_NO = $booking->F_RESELLER_NO;
                $noti->IS_RESELLER = 1;
            }
            $noti->save();
            if($booking->getOrder->DELIVERY_EMAIL != '' && !empty($booking->getOrder->DELIVERY_EMAIL)){
                $email = new EmailNotification();
                $email->TYPE = 'Default';
                $email->F_BOOKING_NO = $booking_id;
                $email->F_SS_CREATED_BY = 1;
                if($booking->IS_RESELLER == 0){
                    $email->CUSTOMER_NO = $booking->F_CUSTOMER_NO;
                    $email->IS_RESELLER = 0;
                }else{
                    $email->RESELLER_NO = $booking->F_RESELLER_NO;
                    $email->IS_RESELLER = 1;
                }
                $email->save();
                $mail_body = $this->getEmailBody($email);
                $mail_body = view('admin.Mail.order_default')
                ->with('rows', $mail_body)
                ->render();
                $email->BODY = $mail_body;
                $email->save();
            }
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return 0;
        }
        DB::commit();
        return 1;
    }

    public function getOrderDefault($request){

        DB::beginTransaction();
        try {
            //////////////////DEFAULT START/////////////////////////
            $daysAdd7      = Carbon::now()->addDays(7)->format('d/m/Y');
            $weeksSub5     = Carbon::now()->subWeeks(4);
            $weeksSub13    = Carbon::now()->subWeeks(12);
            $weeksSub26    = Carbon::now()->subWeeks(25);
            $now           = Carbon::now();

            $data = Order::with('bookingDetails')
                        ->join('SLS_BOOKING as b','b.PK_NO','SLS_ORDER.F_BOOKING_NO')
                        ->select('F_BOOKING_NO','b.CONFIRM_TIME','ORDER_ACTUAL_TOPUP','ORDER_BUFFER_TOPUP')
                        ->where('DISPATCH_STATUS','<',40)
                        ->whereRaw('(ORDER_ACTUAL_TOPUP <> ORDER_BUFFER_TOPUP OR ORDER_ACTUAL_TOPUP = 0)')
                        ->where('IS_DEFAULT',0)
                        ->whereNull('DEFAULT_AT')
                        ->get();
            $data = [];
            if ($data) {
                foreach ($data as $key1 => $value1) {
                    $total_order_item_count = count($value1['bookingDetails']);
                    $air_option_1_count     = 0;
                    $air_option_2_count     = 0;
                    $sea_option_1_count     = 0;
                    $sea_option_2_count     = 0;
                    $ready_option_1_count   = 0;
                    $ready_option_2_count   = 0;

                    $last_msg = NotifySms::select('SEND_AT')
                                ->where('F_BOOKING_NO',$value1->F_BOOKING_NO)
                                ->whereRaw('(IS_SEND = 1)')
                                ->where('TYPE','Arrival')
                                ->orderBy('SEND_AT', 'DESC')
                                ->first();
                    $total_sms_sent = NotifySms::where('F_BOOKING_NO',$value1->F_BOOKING_NO)
                                ->whereRaw('(IS_SEND = 1 OR IS_SEND = 2)')
                                ->where('TYPE','Arrival')
                                ->count();

                    $last_msg_noti  = isset($last_msg) ? Carbon::parse($last_msg->SEND_AT)->format('d/m/Y') : null;
                    $last_msg       = isset($last_msg) ? Carbon::parse($last_msg->SEND_AT)->addWeeks(2) : null;

                    foreach ($value1['bookingDetails'] as $key2 => $value2) {

                        //AIR-OPTION1
                        if (($value1->CONFIRM_TIME < $weeksSub13) && isset($last_msg) && ($last_msg < $now) && ($total_sms_sent >= $total_order_item_count) && $value2->CURRENT_IS_REGULAR == 1 && ($value2->ARRIVAL_NOTIFICATION_FLAG == 0 || $value2->ARRIVAL_NOTIFICATION_FLAG == 1) && $value2->stock->FINAL_PREFFERED_SHIPPING_METHOD == 'AIR') {

                            $air_option_1_count++;
                        }
                        //AIR-OPTION2
                        if (($value1->CONFIRM_TIME < $weeksSub26) && isset($last_msg) && ($last_msg < $now) && ($total_sms_sent >= $total_order_item_count) && $value2->CURRENT_IS_REGULAR == 0 && ($value2->ARRIVAL_NOTIFICATION_FLAG == 0 || $value2->ARRIVAL_NOTIFICATION_FLAG == 1) && $value2->stock->FINAL_PREFFERED_SHIPPING_METHOD == 'AIR') {

                            $air_option_2_count++;
                        }
                        //SEA-OPTION1
                        if (($value1->CONFIRM_TIME < $weeksSub13) && isset($last_msg) && ($last_msg < $now) && ($total_sms_sent >= $total_order_item_count) && $value2->CURRENT_IS_REGULAR == 1 && ($value2->ARRIVAL_NOTIFICATION_FLAG == 0 || $value2->ARRIVAL_NOTIFICATION_FLAG == 1) && $value2->stock->FINAL_PREFFERED_SHIPPING_METHOD == 'SEA') {

                            $sea_option_1_count++;
                        }
                        //SEA-OPTION2
                        if (($value1->CONFIRM_TIME < $weeksSub26) && isset($last_msg) && ($last_msg < $now) && ($total_sms_sent >= $total_order_item_count) && $value2->CURRENT_IS_REGULAR == 0 && ($value2->ARRIVAL_NOTIFICATION_FLAG == 0 || $value2->ARRIVAL_NOTIFICATION_FLAG == 1) && $value2->stock->FINAL_PREFFERED_SHIPPING_METHOD == 'SEA') {

                            $sea_option_2_count++;
                        }
                        //READY-OPTION1
                        if (($value1->CONFIRM_TIME < $weeksSub13) && ($value2->ARRIVAL_NOTIFICATION_FLAG == 2) && ($value2->CURRENT_IS_REGULAR == 1)) {

                            $ready_option_1_count++;
                        }
                        //READY-OPTION2
                        if (($value1->CONFIRM_TIME < $weeksSub26) && ($value2->ARRIVAL_NOTIFICATION_FLAG == 2) && ($value2->CURRENT_IS_REGULAR == 0)) {

                            $ready_option_2_count++;
                        }
                    }
                    //ORDER IS DEFAULT
                    if (($total_order_item_count == $air_option_1_count) && ($total_order_item_count > 0)) {
                        Order::where('F_BOOKING_NO',$value1->F_BOOKING_NO)->update(['DEFAULT_AT'=>date('Y-m-d H:i:s', strtotime("+7 day")),'DEFAULT_TYPE' => 1]);
                        $this->generateDefaultReminderSms($value1->F_BOOKING_NO, $last_msg_noti, $daysAdd7);
                    }
                    if (($total_order_item_count == $air_option_2_count) && ($total_order_item_count > 0)) {
                        Order::where('F_BOOKING_NO',$value1->F_BOOKING_NO)->update(['DEFAULT_AT'=>date('Y-m-d H:i:s', strtotime("+7 day")),'DEFAULT_TYPE' => 2]);
                        $this->generateDefaultReminderSms($value1->F_BOOKING_NO, $last_msg_noti, $daysAdd7);
                    }
                    if (($total_order_item_count == $sea_option_1_count) && ($total_order_item_count > 0)) {
                        Order::where('F_BOOKING_NO',$value1->F_BOOKING_NO)->update(['DEFAULT_AT'=>date('Y-m-d H:i:s', strtotime("+7 day")),'DEFAULT_TYPE' => 3]);
                        $this->generateDefaultReminderSms($value1->F_BOOKING_NO, $last_msg_noti, $daysAdd7);
                    }
                    if (($total_order_item_count == $sea_option_2_count) && ($total_order_item_count > 0)) {
                        Order::where('F_BOOKING_NO',$value1->F_BOOKING_NO)->update(['DEFAULT_AT'=>date('Y-m-d H:i:s', strtotime("+7 day")),'DEFAULT_TYPE' => 4]);
                        $this->generateDefaultReminderSms($value1->F_BOOKING_NO, $last_msg_noti, $daysAdd7);
                    }
                    if (($total_order_item_count == $ready_option_1_count) && ($total_order_item_count > 0)) {
                        Order::where('F_BOOKING_NO',$value1->F_BOOKING_NO)->update(['DEFAULT_AT'=>date('Y-m-d H:i:s', strtotime("+7 day")),'DEFAULT_TYPE' => 5]);
                        $this->generateDefaultReminderSms($value1->F_BOOKING_NO, $last_msg_noti, $daysAdd7);
                    }
                    if (($total_order_item_count == $ready_option_2_count) && ($total_order_item_count > 0)) {
                        Order::where('F_BOOKING_NO',$value1->F_BOOKING_NO)->update(['DEFAULT_AT'=>date('Y-m-d H:i:s', strtotime("+7 day")),'DEFAULT_TYPE' => 6]);
                        $this->generateDefaultReminderSms($value1->F_BOOKING_NO, $last_msg_noti, $daysAdd7);
                    }
                }
            }
            $to_be_default = Order::select('PK_NO','DEFAULT_AT','F_BOOKING_NO')
            ->where('DISPATCH_STATUS','<',40)
            ->where('IS_DEFAULT',0)
            ->whereNotNull('DEFAULT_AT')
            ->get();
            foreach ($to_be_default as $key => $value) {
                if($value->DEFAULT_AT < $now){
                    DB::table('SLS_ORDER')->where('PK_NO',$value->PK_NO)->update(['IS_DEFAULT' => 1]);
                    $this->generateDefaultSms($value->F_BOOKING_NO);
                }
            }
            //////////////////DEFAULT END/////////////////////////

            // START DELETE DUE BILLS
            $lastday = Carbon::now()->subHour(24);
            $query = DB::table('ACC_ONLINE_PAYMENT_TXN')->select('BILL_ID','ORDER_GROUP_ID')->where('IS_PAID',0)->where('DUE_AT','<',$lastday)->get();
            if(isset($query) && !empty($query)){
                foreach ($query as $key => $value) {
                    $http = new HttpMethodsClient(
                        new GuzzleHttpClient(),
                        new GuzzleMessageFactory()
                    );
                    $billplz = new Client($http, env('BILLPLZ_CLIENT'));
                    $billplz->useVersion('v4');
                    $bill = $billplz->bill();
                    $bill_details = $bill->get($value->BILL_ID);
                    $bill_details = $bill_details->toArray();
                    if(isset($bill_details['state']) && $bill_details['state'] == 'due'){
                        // $bill_details = shell_exec("curl https://www.billplz.com/api/v3/bills/".$value->BILL_ID." \ -u ".env('BILLPLZ_CLIENT').":");
                        // $bill_details = json_decode($bill_details,true);
                        // shell_exec("curl -X DELETE https://www.billplz.com/api/v3/bills/".$value->BILL_ID." \ -u ".env('BILLPLZ_CLIENT').":");
                        $bill->destroy($value->BILL_ID);
                        DB::table('ACC_ONLINE_PAYMENT_TXN')->where('BILL_ID',$value->BILL_ID)->where('IS_PAID',0)->delete();
                    }
                }
            }
            // END DELETE DUE BILLS

            // START INSTALLMENT ADJUSTMENT
            $query = DB::table('ACC_INSTALLMENT_RECORD')->select('ORDER_GROUP_ID')->where('IS_PAID',0)->where('IS_EXPIRED',0)->groupBy('ORDER_GROUP_ID')->get();
            foreach ($query as $key => $value) {
                $ins = DB::table('ACC_INSTALLMENT_RECORD')->select('SS_CREATED_ON','CALCULATED_INSTALLMENT_AMOUNT','PK_NO','IS_MAIL_SEND','ORDER_GROUP_ID')->where('ORDER_GROUP_ID',$value->ORDER_GROUP_ID)->where('IS_PAID',0)->where('IS_EXPIRED',0)->get();
                $numItems = count($ins);
                $amount = 0;
                $processed = 0;
                foreach ($ins as $key2 => $value2) {

                    //START SEND MAIL
                    if ($value2->IS_MAIL_SEND == 0) {
                        if (Carbon::now()->addDays(7) >= $value2->SS_CREATED_ON) {
                            $orders = DB::table('SLS_ORDER as o')->join('SLS_BOOKING as b','o.F_BOOKING_NO','b.PK_NO')->select('o.F_BOOKING_NO','o.DELIVERY_EMAIL')->whereRaw('(o.ORDER_ACTUAL_TOPUP < b.TOTAL_PRICE-b.DISCOUNT)')->where('o.ORDER_GROUP_ID',$value2->ORDER_GROUP_ID)->get();
                            if (isset($orders) && !empty($orders)) {
                                require base_path("vendor/autoload.php");
                                foreach ($orders as $key => $value) {
                                    if(isset($value->DELIVERY_EMAIL) && !empty($value->DELIVERY_EMAIL)){
                                        $last_date = DB::table('ACC_INSTALLMENT_RECORD')->select('SS_CREATED_ON')->where('ORDER_GROUP_ID',$value2->ORDER_GROUP_ID)->orderBy('PK_NO','DESC')->first();
                                        $email = (object)array('TYPE'=>'Reminder','F_BOOKING_NO'=>$value->F_BOOKING_NO,'DUE_DATE'=>date("jS M Y", strtotime($value2->SS_CREATED_ON)),'last_date'=>date("jS M Y", strtotime($last_date->SS_CREATED_ON)));
                                        $mail_body = $this->getEmailBody($email);
                                        $mail_body = view('admin.Mail.reminder')
                                        ->with('rows', $mail_body)
                                        ->render();

                                        $mail = new \PHPMailer\PHPMailer\PHPMailer();
                                        // $mail->SMTPDebug = 2;
                                        $mail->isSMTP();
                                        $mail->Host = config('mail.host');
                                        $mail->SMTPAuth = true;
                                        $mail->Username = config('mail.username');
                                        $mail->Password = config('mail.password');
                                        $mail->SMTPSecure = config('mail.encryption');
                                        $mail->Port = config('mail.port');
                                        $mail->setFrom('admin@azuramart.com', 'AZURAMART');
                                        $mail->addAddress($value->DELIVERY_EMAIL);
                                        $mail->isHTML(true);
                                        $mail->Subject = 'Installment payment reminder of AZURAMART';
                                        $mail->Body    = $mail_body;
                                        if($mail->Send()){
                                            DB::table('ACC_INSTALLMENT_RECORD')->where('PK_NO',$value2->PK_NO)->update(['IS_MAIL_SEND' => 1]);
                                        }
                                    }
                                }
                            }
                        }
                    }
                    //END SEND MAIL

                    // start installment payment expired
                    if (Carbon::now() > $value2->SS_CREATED_ON && ($numItems - $key2 > 1)) {
                        $amount += $value2->CALCULATED_INSTALLMENT_AMOUNT;
                        DB::table('ACC_INSTALLMENT_RECORD')->where('PK_NO',$value2->PK_NO)->update(['CALCULATED_INSTALLMENT_AMOUNT' => 0,'IS_PAID' => 1,'IS_EXPIRED' => 1]);
                        $processed = 1;

                    }elseif($processed == 1){
                        DB::table('ACC_INSTALLMENT_RECORD')->where('PK_NO',$value2->PK_NO)->increment('CALCULATED_INSTALLMENT_AMOUNT',$amount);
                        $processed = 0;
                        $amount = 0;
                    }
                    // end installment payment expired
                }
            }
            // END INSTALLMENT ADJUSTMENT

        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), 'admin.notify_sms.list',0);
        }
        DB::commit();
        return $this->formatResponse(true, 'SMS has been send successfully !', 'admin.notify_sms.list',1);
    }

    public function getSendAllEmail($request)
    {
        DB::beginTransaction();
        try {
            $notis = DB::table('SLS_NOTIFICATION_EMAIL')->where('IS_SEND',0)->whereNotNull('EMAIL')->where('EMAIL','!=','')->orderBy('PK_NO', 'ASC')->limit(5)->get();
            if($notis){
                foreach ($notis as $key => $value) {
                    // $mail_body = $this->getEmailBody($value->PK_NO);
                    if($value->TYPE == 'Arrival' && isset($value->EMAIL)){
                        $emailRes   = $this->orderArrivalEmail($value->BODY,$value->EMAIL);
                        if($emailRes == 1){
                            DB::table('SLS_NOTIFICATION_EMAIL')->where('PK_NO',$value->PK_NO)->update(['IS_SEND' => 1, 'SEND_AT' => date('Y-m-d H:i:s')]);
                        }
                    }elseif($value->TYPE == 'Default Reminder' && isset($value->EMAIL)){
                        $emailRes   = $this->orderDefaultReminderEmail($value->BODY,$value->EMAIL);
                        if($emailRes == 1){
                            DB::table('SLS_NOTIFICATION_EMAIL')->where('PK_NO',$value->PK_NO)->update(['IS_SEND' => 1, 'SEND_AT' => date('Y-m-d H:i:s')]);
                        }
                    }elseif($value->TYPE == 'Default' && isset($value->EMAIL)){
                        $emailRes   = $this->orderDefaultEmail($value->BODY,$value->EMAIL);
                        if($emailRes == 1){
                            DB::table('SLS_NOTIFICATION_EMAIL')->where('PK_NO',$value->PK_NO)->update(['IS_SEND' => 1, 'SEND_AT' => date('Y-m-d H:i:s')]);
                        }
                    }elseif($value->TYPE == 'Dispatch' && isset($value->EMAIL)){
                        $emailRes   = $this->orderDispatchEmail($value->BODY,$value->EMAIL);
                        if($emailRes == 1){
                            DB::table('SLS_NOTIFICATION_EMAIL')->where('PK_NO',$value->PK_NO)->update(['IS_SEND' => 1, 'SEND_AT' => date('Y-m-d H:i:s')]);
                        }
                    }elseif($value->TYPE == 'Cancel' && isset($value->EMAIL)){
                        $emailRes   = $this->orderCancelEmail($value->BODY,$value->EMAIL);
                        if($emailRes == 1){
                            DB::table('SLS_NOTIFICATION_EMAIL')->where('PK_NO',$value->PK_NO)->update(['IS_SEND' => 1, 'SEND_AT' => date('Y-m-d H:i:s')]);
                        }
                    }elseif($value->TYPE == 'Order Create' && isset($value->EMAIL)){
                        $emailRes   = $this->orderCreateEndEmail($value->BODY,$value->EMAIL);
                        if($emailRes == 1){
                            DB::table('SLS_NOTIFICATION_EMAIL')->where('PK_NO',$value->PK_NO)->update(['IS_SEND' => 1, 'SEND_AT' => date('Y-m-d H:i:s')]);
                        }
                    }elseif($value->TYPE == 'Return' && isset($value->EMAIL)){
                        $emailRes   = $this->orderReturntEmail($value->BODY,$value->EMAIL);
                        if($emailRes == 1){
                            DB::table('SLS_NOTIFICATION_EMAIL')->where('PK_NO',$value->PK_NO)->update(['IS_SEND' => 1, 'SEND_AT' => date('Y-m-d H:i:s')]);
                        }
                    }elseif($value->TYPE == 'greeting' && isset($value->EMAIL)){
                        $emailRes   = $this->greetingEmail($value->BODY,$value->EMAIL);
                        if($emailRes == 1){
                            DB::table('SLS_NOTIFICATION_EMAIL')->where('PK_NO',$value->PK_NO)->update(['IS_SEND' => 1, 'SEND_AT' => date('Y-m-d H:i:s')]);
                        }
                    }elseif($value->TYPE == 'Order Payment' && isset($value->EMAIL)){
                        $emailRes   = $this->orderPaymentEmail($value->BODY,$value->EMAIL);
                        if($emailRes == 1){
                            DB::table('SLS_NOTIFICATION_EMAIL')->where('PK_NO',$value->PK_NO)->update(['IS_SEND' => 1, 'SEND_AT' => date('Y-m-d H:i:s')]);
                        }
                    }elseif($value->TYPE == 'Payment Confirmation' && isset($value->EMAIL)){
                        $emailRes   = $this->orderPaymentConfirmationEmail($value->BODY,$value->EMAIL);
                        if($emailRes == 1){
                            DB::table('SLS_NOTIFICATION_EMAIL')->where('PK_NO',$value->PK_NO)->update(['IS_SEND' => 1, 'SEND_AT' => date('Y-m-d H:i:s')]);
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), 'admin.notify_email.list',0);
        }
        DB::commit();
        return $this->formatResponse(true, 'success', 'admin.notify_email.list',1);
    }

    public function getBillplzNonpaidAssign($request)
    {
        DB::beginTransaction();
        try {
            //Non paid order from web
            $now = date('Y-m-d H:i:s',strtotime(date("Y-m-d H:i:s")." -8 minutes"));
            $orders = DB::table('SLS_BOOKING')->select('SLS_BOOKING.PK_NO','SLS_BOOKING.CONFIRM_TIME', 'SLS_BOOKING.TOTAL_PRICE', 'SLS_ORDER.ORDER_GROUP_ID')
            ->join('SLS_ORDER', 'SLS_ORDER.F_BOOKING_NO','SLS_BOOKING.PK_NO')
            ->where('SLS_BOOKING.F_SHOP_NO',19)
            ->where('SLS_BOOKING.IS_EXPAIRED','=',0)
            ->where('SLS_ORDER.ORDER_ACTUAL_TOPUP','=',0)
            ->where('SLS_BOOKING.CONFIRM_TIME','<',$now)
            ->get();
            if($orders){
                foreach ($orders as $key => $value) {
                    $payment = DB::table('ACC_ONLINE_PAYMENT_TXN')->select('BILL_ID')->where('ORDER_GROUP_ID',$value->ORDER_GROUP_ID)->where('IS_PAID', 0)->first();
                    if($payment){
                        // $bill_details = shell_exec("curl https://www.billplz.com/api/v3/bills/".$payment->BILL_ID." \ -u ".env('BILLPLZ_CLIENT').":");
                        // $bill_details = json_decode($bill_details,true);
                        $http = new HttpMethodsClient(
                            new GuzzleHttpClient(),
                            new GuzzleMessageFactory()
                        );
                        $billplz = new Client($http, env('BILLPLZ_CLIENT'));
                        $billplz->useVersion('v4');
                        $bill = $billplz->bill();
                        $bill_details = $bill->get($payment->BILL_ID);
                        $bill_details = $bill_details->toArray();
                        if(isset($bill_details['state']) && $bill_details['state'] == 'due'){
                            // $bill_details = shell_exec("curl https://www.billplz.com/api/v3/bills/".$value->BILL_ID." \ -u ".env('BILLPLZ_CLIENT').":");
                            // $bill_details = json_decode($bill_details,true);
                            // shell_exec("curl -X DELETE https://www.billplz.com/api/v3/bills/".$payment->BILL_ID." \ -u ".env('BILLPLZ_CLIENT').":");
                            $bill->destroy($payment->BILL_ID);

                            DB::table('ACC_ONLINE_PAYMENT_TXN')->where('ORDER_GROUP_ID',$value->ORDER_GROUP_ID)->where('IS_PAID',0)->delete();
                            DB::table('ACC_INSTALLMENT_RECORD')->where('ORDER_GROUP_ID',$value->ORDER_GROUP_ID)->where('IS_PAID',0)->delete();
                        }
                    }
                    DB::table('SLS_BOOKING')->where('PK_NO',$value->PK_NO)->update(['TOTAL_PRICE_BEFORE_RETURN' => $value->TOTAL_PRICE, 'IS_EXPAIRED' => 1 ]);
                    $booking_details = DB::table('SLS_BOOKING_DETAILS')->where('F_BOOKING_NO',$value->PK_NO)->get();
                    if($booking_details){
                        foreach($booking_details as $child){
                            DB::SELECT("INSERT INTO SLS_BOOKING_DETAILS_AUD (PK_NO, F_BOOKING_NO, F_INV_STOCK_NO, COMMENTS, IS_ACTIVE, F_SS_CREATED_BY, SS_CREATED_ON, F_DELIVERY_ADDRESS, F_SS_COMPANY_NO, IS_SYSTEM_HOLD, IS_ADMIN_HOLD, DISPATCH_STATUS, AIR_FREIGHT, SEA_FREIGHT, IS_FREIGHT, SS_COST, SM_COST, IS_SM, REGULAR_PRICE, INSTALLMENT_PRICE, IS_REGULAR, CURRENT_AIR_FREIGHT, CURRENT_SEA_FREIGHT, CURRENT_IS_FREIGHT, CURRENT_SS_COST, CURRENT_SM_COST, CURRENT_IS_SM, CURRENT_REGULAR_PRICE, CURRENT_INSTALLMENT_PRICE, CURRENT_IS_REGULAR, CURRENT_F_DELIVERY_ADDRESS, ORDER_STATUS, IS_SELF_PICKUP, IS_ADMIN_APPROVAL, IS_READY, ARRIVAL_NOTIFICATION_FLAG, DISPATCH_NOTIFICATION_FLAG, IS_COD_SHELVE_TRANSFER, COMISSION, RTS_COLLECTION_USER_ID, IS_COLLECTED_FOR_RTS, F_BUNDLE_NO, BUNDLE_SEQUENC, COD_RTC_ACK, LINE_PRICE, CHANGE_TYPE) VALUES ('$child->PK_NO', '$child->F_BOOKING_NO', '$child->F_INV_STOCK_NO', '$child->COMMENTS', '$child->IS_ACTIVE', '$child->F_SS_CREATED_BY', '$child->SS_CREATED_ON', '$child->F_DELIVERY_ADDRESS', '$child->F_SS_COMPANY_NO', '$child->IS_SYSTEM_HOLD', '$child->IS_ADMIN_HOLD', '$child->DISPATCH_STATUS', '$child->AIR_FREIGHT', '$child->SEA_FREIGHT', '$child->IS_FREIGHT', '$child->SS_COST', '$child->SM_COST', '$child->IS_SM', '$child->REGULAR_PRICE', '$child->INSTALLMENT_PRICE', '$child->IS_REGULAR', '$child->CURRENT_AIR_FREIGHT', '$child->CURRENT_SEA_FREIGHT', '$child->CURRENT_IS_FREIGHT', '$child->CURRENT_SS_COST', '$child->CURRENT_SM_COST', '$child->CURRENT_IS_SM', '$child->CURRENT_REGULAR_PRICE', '$child->CURRENT_INSTALLMENT_PRICE', '$child->CURRENT_IS_REGULAR', '$child->CURRENT_F_DELIVERY_ADDRESS', '$child->ORDER_STATUS', '$child->IS_SELF_PICKUP', '$child->IS_ADMIN_APPROVAL', '$child->IS_READY', '$child->ARRIVAL_NOTIFICATION_FLAG', '$child->DISPATCH_NOTIFICATION_FLAG', '$child->IS_COD_SHELVE_TRANSFER', '$child->COMISSION', '$child->RTS_COLLECTION_USER_ID', '$child->IS_COLLECTED_FOR_RTS', '$child->F_BUNDLE_NO', '$child->BUNDLE_SEQUENC', '$child->COD_RTC_ACK', '$child->LINE_PRICE', 'EXPAIRED' )");
                        }
                    }
                    DB::table('INV_STOCK')->where('F_BOOKING_NO',$value->PK_NO)->update(['BOOKING_STATUS' => null, 'F_BOOKING_NO' => null,'F_ORDER_NO' => null,'ORDER_STATUS' => null,'ORDER_PRICE' => null]);

                    DB::table('WEB_CART')->where('F_ORDER_GROUP_NO',$value->ORDER_GROUP_ID)->update(['IS_BOOKING' => 0, 'F_ORDER_GROUP_NO' => null]);
                    DB::table('SLS_BOOKING_DETAILS')->where('F_BOOKING_NO',$value->PK_NO)->delete();
                    DB::table('SLS_ORDER')->where('F_BOOKING_NO', $value->PK_NO)->delete();
                    DB::table('SLS_BOOKING')->where('PK_NO', $value->PK_NO)->delete();
                    DB::table('SLS_NOTIFICATION')->where('F_BOOKING_NO',$value->PK_NO)->delete();
                }
            }
            //End Non paid order from web

            // ASSIGN AMOUNT TO ORDERS
            $non_paid_bills = DB::table('ACC_ONLINE_PAYMENT_TXN as txn')->select('txn.BILL_ID')->where('txn.IS_PAID',0)->orderBy('txn.PK_NO','DESC')->get();
            if($non_paid_bills->count() > 0){
                $http = new HttpMethodsClient(
                    new GuzzleHttpClient(),
                    new GuzzleMessageFactory()
                );
                $billplz = new Client($http, env('BILLPLZ_CLIENT'));
                // $billplz = new Client($http, '665612e0-84b3-4971-8600-c47d95004e14');
                // $billplz->useSandbox();
                $billplz->useVersion('v4');
                $bill = $billplz->bill();
                $transaction = $billplz->transaction('v4');

                foreach ($non_paid_bills as $key => $value) {
                    $response = $bill->get($value->BILL_ID);
                    $response = $response->toArray();
                    if ($response['paid'] == 1) {
                        $response2 = $transaction->get($value->BILL_ID);
                        $response2 = $response2->toArray();
                        $transaction_id = $response2['transactions'][0]['id'];
                        $transaction_at = $response2['transactions'][0]['completed_at'];
                        $online_payment = OnlinePayment::where('BILL_ID',$value->BILL_ID)->first();

                        if ($online_payment->IS_PAYMENT_TO_BALANCE == 1) {
                            if($online_payment->IS_RESELLER == 0){
                                $customer_add = Customer::select('F_COUNTRY_NO','EMAIL','MOBILE_NO')->where('PK_NO',$online_payment->F_CUSTOMER_NO)->first();
                                $type                           = 'customer';
                                $payment                        = new PaymentCustomer();
                                $payment->F_CUSTOMER_NO         = $online_payment->F_CUSTOMER_NO;
                                $payment->PAID_BY               = $online_payment->CUSTOMER_NAME;
                            }else{
                                $customer_add = Reseller::select('F_COUNTRY_NO','EMAIL','MOBILE_NO')->where('PK_NO',$online_payment->F_RESELLER_NO)->first();
                                $type                           = 'reseller';
                                $payment                        = new PaymentReseller();
                                $payment->F_RESELLER_NO         = $online_payment->F_RESELLER_NO;
                                $payment->PAID_BY               = $online_payment->RESHOP_NAME;
                            }
                            $payment->F_PAYMENT_CURRENCY_NO     = 2;
                            $payment->PAYMENT_DATE              = date('Y-m-d H:i:s',strtotime($transaction_at));
                            $payment->MR_AMOUNT                 = $online_payment->PAYMENT_AMOUNT;
                            $payment->PAYMENT_REMAINING_MR      = $online_payment->PAYMENT_AMOUNT;
                            $payment->F_PAYMENT_ACC_NO          = 15;
                            $payment->SLIP_NUMBER               = $transaction_id;
                            $payment->PAYMENT_CONFIRMED_STATUS  = 1;
                            $payment->PAYMENT_TYPE              = 4;
                            $payment->save();
                            $pay_pk_no                          = $payment->PK_NO;

                            $online_payment->IS_PAID            = 1;
                            $online_payment->PAID_AT            = date('Y-m-d H:i:s',strtotime($transaction_at));
                            $online_payment->TRANSACTION_ID     = $transaction_id;
                            if($online_payment->IS_RESELLER == 0){
                                $online_payment->F_ACC_CUSTOMER_PAYMENT_NO  = $pay_pk_no;
                            }else{
                                $online_payment->F_ACC_RESELLER_PAYMENT_NO  = $pay_pk_no;
                            }
                            $online_payment->save();

                            DB::statement('CALL PROC_CUSTOMER_PAYMENT(?,?)',array( $pay_pk_no,$type));
                            if(isset($online_payment->getOrder->DELIVERY_EMAIL) && $online_payment->getOrder->DELIVERY_EMAIL != ''){
                                $email = new EmailNotification();
                                $email->TYPE = 'Payment Confirmation';
                                $email->F_SS_CREATED_BY = 1;
                                $email->MOBILE_NO = ($customer_add->country->DIAL_CODE ?? '').($customer_add->MOBILE_NO ?? '');
                                $email->EMAIL = $customer_add->EMAIL ?? '';
                                if($online_payment->IS_RESELLER == 0){
                                    $email->CUSTOMER_NO = $online_payment->F_CUSTOMER_NO;
                                    $email->IS_RESELLER = 0;
                                }else{
                                    $email->RESELLER_NO = $online_payment->F_RESELLER_NO;
                                    $email->IS_RESELLER = 1;
                                }
                                $email->save();
                                $mail_body = $this->getEmailBody($email,$pay_pk_no);
                                $mail_body = view('admin.Mail.payment_verified')
                                ->with('rows', $mail_body)
                                ->render();
                                $email->BODY = $mail_body;
                                $email->save();
                            }
                        }else{
                            $total_paid_amount = DB::table('ACC_ONLINE_PAYMENT_TXN')->where('ORDER_GROUP_ID',$online_payment->ORDER_GROUP_ID)->whereIn('PAYMENT_POSITION',array('billplz','azuramart-90','azuramart-180'))->where('IS_PAID',1)->sum('PAYMENT_AMOUNT');

                            DB::table('SLS_ORDER_GROUP')->where('PK_NO',$online_payment->ORDER_GROUP_ID)->update(['TOTAL_PAID'=>$total_paid_amount]);

                            $order = Order::select('PK_NO','IS_RESELLER','F_CUSTOMER_NO','CUSTOMER_NAME','F_RESELLER_NO','RESHOP_NAME','F_BOOKING_NO','ORDER_BUFFER_TOPUP')->where('ORDER_GROUP_ID',$online_payment->ORDER_GROUP_ID)->get();
                            $order_group_buffer = DB::table('SLS_ORDER')->where('ORDER_GROUP_ID',$online_payment->ORDER_GROUP_ID)->sum('ORDER_BUFFER_TOPUP');
                            $order_total_value = DB::table('SLS_ORDER_GROUP')->where('PK_NO',$online_payment->ORDER_GROUP_ID)->sum('TOTAL_PRICE');

                            if($order[0]->IS_RESELLER == 0){
                                $type                           = 'customer';
                                $payment                        = new PaymentCustomer();
                                $payment->F_CUSTOMER_NO         = $order[0]->F_CUSTOMER_NO;
                                $payment->PAID_BY               = $order[0]->CUSTOMER_NAME;
                            }else{
                                $type                           = 'reseller';
                                $payment                        = new PaymentReseller();
                                $payment->F_RESELLER_NO         = $order[0]->F_RESELLER_NO;
                                $payment->PAID_BY               = $order[0]->RESHOP_NAME;
                            }
                            $payment->F_PAYMENT_CURRENCY_NO     = 2;
                            $payment->PAYMENT_DATE              = date('Y-m-d H:i:s',strtotime($transaction_at));
                            $payment->MR_AMOUNT                 = $online_payment->PAYMENT_AMOUNT;
                            $payment->F_PAYMENT_ACC_NO          = 15;
                            $payment->SLIP_NUMBER               = $transaction_id;
                            $payment->PAYMENT_CONFIRMED_STATUS  = 1;
                            $payment->PAYMENT_TYPE              = 4;
                            $payment->save();
                            $pay_pk_no                          = $payment->PK_NO;

                            $online_payment->IS_PAID        = 1;
                            $online_payment->PAID_AT        = date('Y-m-d H:i:s',strtotime($transaction_at));
                            $online_payment->TRANSACTION_ID = $transaction_id;
                            if($order[0]->IS_RESELLER == 0){
                                $online_payment->F_ACC_CUSTOMER_PAYMENT_NO  = $pay_pk_no;
                            }else{
                                $online_payment->F_ACC_RESELLER_PAYMENT_NO  = $pay_pk_no;
                            }
                            $online_payment->save();
                            DB::statement('CALL PROC_CUSTOMER_PAYMENT(?,?)',array( $pay_pk_no,$type));

                            if ($online_payment->PAYMENT_POSITION == 'azuramart-90' || $online_payment->PAYMENT_POSITION == 'azuramart-180') {
                                $amount = 0;
                                $excess_paid = 0;
                                $flag = 0;
                                $paid_inst = $online_payment->PAYMENT_AMOUNT;   //240

                                $install_payment = DB::table('ACC_INSTALLMENT_RECORD')->where('ORDER_GROUP_ID',$online_payment->ORDER_GROUP_ID)->where('IS_PAID',0)->orderBy('PK_NO','ASC')->get();

                                if (isset($install_payment) && !empty($install_payment)) {

                                    foreach ($install_payment as $key => $value) {

                                        $inst_to_pay = $value->CALCULATED_INSTALLMENT_AMOUNT;  //119
                                        if ($inst_to_pay > 0 && $paid_inst > 0) {

                                            if($inst_to_pay < $paid_inst){
                                                $amount = $paid_inst-$excess_paid;
                                            }else{
                                                if ($inst_to_pay < $excess_paid) {
                                                    $amount = 0;
                                                }else{
                                                    $amount = $inst_to_pay-$excess_paid;
                                                }
                                            }
                                            if (($excess_paid > 0 || $flag == 0) && $inst_to_pay <= $paid_inst) {
                                                DB::table('ACC_INSTALLMENT_RECORD')->where('IS_PAID',0)->where('PK_NO',$value->PK_NO)->update(['CALCULATED_INSTALLMENT_AMOUNT'=>$amount,'IS_PAID'=>1,'F_ACC_CUSTOMER_PAYMENT_NO'=>$order[0]->IS_RESELLER == 0 ? $pay_pk_no : 0,'F_ACC_RESELLER_PAYMENT_NO'=>$order[0]->IS_RESELLER == 1 ? $pay_pk_no : 0]);
                                                $flag = 1;
                                            }else{
                                                DB::table('ACC_INSTALLMENT_RECORD')->where('IS_PAID',0)->where('PK_NO',$value->PK_NO)->update(['CALCULATED_INSTALLMENT_AMOUNT'=>$amount]);
                                            }
                                            if($inst_to_pay < $paid_inst){
                                                $excess_paid = $paid_inst - $inst_to_pay;   //2
                                                $paid_inst = $excess_paid;

                                            }else{
                                                $paid_inst = 0;
                                                $excess_paid = 0;
                                            }
                                        }
                                    }
                                }
                            }
                            if($order_group_buffer == 0 && $total_paid_amount == 0 && ($online_payment->PAYMENT_POSITION == 'azuramart-90' || $online_payment->PAYMENT_POSITION == 'azuramart-180')){ //ASSIGN DOWNPAYMENT

                                $payment                = $online_payment->PAYMENT_AMOUNT;
                                $amount                 = 0;
                                $order_to_pay           = 0;
                                $total_assigned_amount  = 0;
                                $len = count($order);
                                foreach ($order as $key => $value) {
                                    $order_to_pay = ($value->booking->TOTAL_PRICE - $value->booking->DISCOUNT - $value->ORDER_BUFFER_TOPUP);
                                    if ($order_to_pay > 0 && $payment > 0) {

                                        if ($key == $len - 1) {
                                            $amount = $payment-$total_assigned_amount;
                                        }else{
                                            $amount = ($payment/$order_total_value)*$order_to_pay;
                                            $amount = round($amount);
                                            $total_assigned_amount += $amount;
                                        }
                                        $order_pay                              = new OrderPayment();
                                        $order_pay->ORDER_NO                    = $value->PK_NO;
                                        if($value->IS_RESELLER == 0){
                                            $order_pay->CUSTOMER_NO             = $value->F_CUSTOMER_NO;
                                            $order_pay->IS_CUSTOMER             = 1;
                                            $order_pay->F_ACC_CUSTOMER_PAYMENT_NO = $pay_pk_no;
                                        }else{
                                            $order_pay->RESELLER_NO             = $value->F_RESELLER_NO;
                                            $order_pay->IS_CUSTOMER             = 0;
                                            $order_pay->F_ACC_RESELLER_PAYMENT_NO = $pay_pk_no;
                                        }
                                        $order_pay->PAYMENT_AMOUNT              = $amount;
                                        $order_pay->IS_PAYMENT_FROM_BALANCE     = 0;
                                        $order_pay->save();

                                        $single_order   = Order::select('F_BOOKING_NO','ORDER_ACTUAL_TOPUP','DELIVERY_EMAIL')->where('PK_NO',$value->PK_NO)->first();
                                        $order_value    = $single_order->booking->TOTAL_PRICE - $single_order->booking->DISCOUNT;

                                        if($single_order->ORDER_ACTUAL_TOPUP == $order_value){
                                            DB::table('INV_STOCK')->where('F_BOOKING_NO',$single_order->F_BOOKING_NO)->update(['ORDER_STATUS' => 60]);
                                            DB::table('SLS_BOOKING_DETAILS')->where('F_BOOKING_NO',$single_order->F_BOOKING_NO)->update(['ORDER_STATUS' => 60]);
                                        }
                                        if($single_order->DELIVERY_EMAIL != '' && !empty($single_order->DELIVERY_EMAIL)){
                                            $email = new EmailNotification();
                                            $email->TYPE = 'Order Payment';
                                            $email->F_BOOKING_NO = $value->F_BOOKING_NO;
                                            $email->F_SS_CREATED_BY = 1;
                                            if($value->IS_RESELLER == 0){
                                                $email->CUSTOMER_NO = $value->F_CUSTOMER_NO;
                                                $email->IS_RESELLER = 0;
                                            }else{
                                                $email->RESELLER_NO = $value->F_RESELLER_NO;
                                                $email->IS_RESELLER = 1;
                                            }
                                            $email->save();
                                            $mail_body = $this->getEmailBody($email);
                                            $mail_body = view('admin.Mail.order_payment')
                                            ->with('rows', $mail_body)
                                            ->render();
                                            $email->BODY = $mail_body;
                                            $email->save();
                                        }
                                    }
                                }
                            }else{
                                $amount = 0;
                                $order_to_pay = 0;
                                $payment = $online_payment->PAYMENT_AMOUNT;

                                foreach ($order as $key => $value) {
                                    $order_to_pay = ($value->booking->TOTAL_PRICE - $value->booking->DISCOUNT - $value->ORDER_BUFFER_TOPUP);
                                    if ($order_to_pay > 0 && $payment > 0) {

                                        if ($order_to_pay >= $payment) {
                                            $amount = $payment;
                                        }else if($order_to_pay < $payment){
                                            $amount = $order_to_pay;
                                        }
                                        $order_pay                              = new OrderPayment();
                                        $order_pay->ORDER_NO                    = $value->PK_NO;
                                        if($value->IS_RESELLER == 0){
                                            $order_pay->CUSTOMER_NO             = $value->F_CUSTOMER_NO;
                                            $order_pay->IS_CUSTOMER             = 1;
                                            $order_pay->F_ACC_CUSTOMER_PAYMENT_NO = $pay_pk_no;
                                        }else{
                                            $order_pay->RESELLER_NO             = $value->F_RESELLER_NO;
                                            $order_pay->IS_CUSTOMER             = 0;
                                            $order_pay->F_ACC_RESELLER_PAYMENT_NO = $pay_pk_no;
                                        }
                                        $order_pay->PAYMENT_AMOUNT              = $amount;
                                        $order_pay->IS_PAYMENT_FROM_BALANCE     = 0;
                                        $order_pay->save();

                                        $single_order   = Order::select('F_BOOKING_NO','ORDER_ACTUAL_TOPUP','DELIVERY_EMAIL')->where('PK_NO',$value->PK_NO)->first();
                                        $order_value    = $single_order->booking->TOTAL_PRICE - $single_order->booking->DISCOUNT;

                                        if($single_order->ORDER_ACTUAL_TOPUP == $order_value){
                                            DB::table('INV_STOCK')->where('F_BOOKING_NO',$single_order->F_BOOKING_NO)->update(['ORDER_STATUS' => 60]);
                                            DB::table('SLS_BOOKING_DETAILS')->where('F_BOOKING_NO',$single_order->F_BOOKING_NO)->update(['ORDER_STATUS' => 60]);
                                        }
                                        if ($order_to_pay >= $payment) {
                                            $payment = 0;
                                        }else if($order_to_pay < $payment){
                                            $payment = $payment - $order_to_pay;
                                        }
                                        if($single_order->DELIVERY_EMAIL != '' && !empty($single_order->DELIVERY_EMAIL)){
                                            $email = new EmailNotification();
                                            $email->TYPE = 'Order Payment';
                                            $email->F_BOOKING_NO = $value->F_BOOKING_NO;
                                            $email->F_SS_CREATED_BY = 1;
                                            if($value->IS_RESELLER == 0){
                                                $email->CUSTOMER_NO = $value->F_CUSTOMER_NO;
                                                $email->IS_RESELLER = 0;
                                            }else{
                                                $email->RESELLER_NO = $value->F_RESELLER_NO;
                                                $email->IS_RESELLER = 1;
                                            }
                                            $email->save();
                                            $mail_body = $this->getEmailBody($email);
                                            $mail_body = view('admin.Mail.order_payment')
                                            ->with('rows', $mail_body)
                                            ->render();
                                            $email->BODY = $mail_body;
                                            $email->save();
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

        } catch (\Exception $e) {
        DB::rollback();
        dd($e);
        return $this->formatResponse(false, $e->getMessage(), 'admin.notify_email.list',1);
        }
        DB::commit();
        return $this->formatResponse(true, '', 'admin.notify_email.list',1);
    }

    public function getBillplzDeleteExpired($request) //CRON JOB IS DISCONNECTED
    {
        DB::beginTransaction();
        try {
            // START DELETE DUE BILLS
            $lastday = Carbon::now()->subHour(24);
            $query = DB::table('ACC_ONLINE_PAYMENT_TXN')->select('BILL_ID','ORDER_GROUP_ID')->where('IS_PAID',0)->where('DUE_AT','<',$lastday)->get();
            if(isset($query) && !empty($query)){
                foreach ($query as $key => $value) {
                    $http = new HttpMethodsClient(
                        new GuzzleHttpClient(),
                        new GuzzleMessageFactory()
                    );
                    $billplz = new Client($http, env('BILLPLZ_CLIENT'));
                    $billplz->useVersion('v4');
                    $bill = $billplz->bill();
                    $bill_details = $bill->get($value->BILL_ID);
                    $bill_details = $bill_details->toArray();
                    if(isset($bill_details['state']) && $bill_details['state'] == 'due'){
                        // $bill_details = shell_exec("curl https://www.billplz.com/api/v3/bills/".$value->BILL_ID." \ -u ".env('BILLPLZ_CLIENT').":");
                        // $bill_details = json_decode($bill_details,true);
                        // shell_exec("curl -X DELETE https://www.billplz.com/api/v3/bills/".$value->BILL_ID." \ -u ".env('BILLPLZ_CLIENT').":");
                        $bill->destroy($value->BILL_ID);
                        DB::table('ACC_ONLINE_PAYMENT_TXN')->where('BILL_ID',$value->BILL_ID)->where('IS_PAID',0)->delete();
                    }
                }
            }
            // END DELETE DUE BILLS
            // START INSTALLMENT ADJUSTMENT

            $query = DB::table('ACC_INSTALLMENT_RECORD')->select('ORDER_GROUP_ID')->where('IS_PAID',0)->groupBy('ORDER_GROUP_ID')->get();
            foreach ($query as $key => $value) {
                $ins = DB::table('ACC_INSTALLMENT_RECORD')->select('SS_CREATED_ON','CALCULATED_INSTALLMENT_AMOUNT','PK_NO','IS_MAIL_SEND','ORDER_GROUP_ID')->where('ORDER_GROUP_ID',$value->ORDER_GROUP_ID)->where('IS_PAID',0)->where('IS_EXPIRED',0)->get();
                $numItems = count($ins);
                $amount = 0;
                $processed = 0;
                foreach ($ins as $key2 => $value2) {

                    //START SEND MAIL
                    if ($value2->IS_MAIL_SEND == 0) {
                        if (Carbon::now()->addDays(7) >= $value2->SS_CREATED_ON) {
                            $orders = DB::table('SLS_ORDER as o')->join('SLS_BOOKING as b','o.F_BOOKING_NO','b.PK_NO')->select('o.F_BOOKING_NO','o.DELIVERY_EMAIL')->whereRaw('(o.ORDER_ACTUAL_TOPUP < b.TOTAL_PRICE-b.DISCOUNT)')->where('o.ORDER_GROUP_ID',$value2->ORDER_GROUP_ID)->get();
                            if (isset($orders) && !empty($orders)) {
                                require base_path("vendor/autoload.php");
                                foreach ($orders as $key => $value) {
                                    if(isset($value->DELIVERY_EMAIL) && !empty($value->DELIVERY_EMAIL)){
                                        $last_date = DB::table('ACC_INSTALLMENT_RECORD')->select('SS_CREATED_ON')->where('ORDER_GROUP_ID',$value2->ORDER_GROUP_ID)->orderBy('PK_NO','DESC')->first();
                                        $email = (object)array('TYPE'=>'Reminder','F_BOOKING_NO'=>$value->F_BOOKING_NO,'DUE_DATE'=>date("jS M Y", strtotime($value2->SS_CREATED_ON)),'last_date'=>date("jS M Y", strtotime($last_date->SS_CREATED_ON)));
                                        $mail_body = $this->getEmailBody($email);
                                        $mail_body = view('admin.Mail.reminder')
                                        ->with('rows', $mail_body)
                                        ->render();

                                        $mail = new \PHPMailer\PHPMailer\PHPMailer();
                                        // $mail->SMTPDebug = 2;
                                        $mail->isSMTP();
                                        $mail->Host = config('mail.host');
                                        $mail->SMTPAuth = true;
                                        $mail->Username = config('mail.username');
                                        $mail->Password = config('mail.password');
                                        $mail->SMTPSecure = config('mail.encryption');
                                        $mail->Port = config('mail.port');
                                        $mail->setFrom('admin@azuramart.com', 'AZURAMART');
                                        $mail->addAddress($value->DELIVERY_EMAIL);
                                        $mail->isHTML(true);
                                        $mail->Subject = 'Installment payment reminder of AZURAMART';
                                        $mail->Body    = $mail_body;
                                        if($mail->Send()){
                                            DB::table('ACC_INSTALLMENT_RECORD')->where('PK_NO',$value2->PK_NO)->update(['IS_MAIL_SEND' => 1]);
                                        }
                                    }
                                }
                            }
                        }
                    }
                    //END SEND MAIL

                    // start installment payment expired
                    if (Carbon::now() > $value2->SS_CREATED_ON && ($numItems - $key2 > 1)) {
                        $amount += $value2->CALCULATED_INSTALLMENT_AMOUNT;
                        DB::table('ACC_INSTALLMENT_RECORD')->where('PK_NO',$value2->PK_NO)->update(['CALCULATED_INSTALLMENT_AMOUNT' => 0,'IS_PAID' => 1,'IS_EXPIRED' => 1]);
                        $processed = 1;

                    }elseif($processed == 1){
                        DB::table('ACC_INSTALLMENT_RECORD')->where('PK_NO',$value2->PK_NO)->increment('CALCULATED_INSTALLMENT_AMOUNT',$amount);
                        $processed = 0;
                        $amount = 0;
                    }
                    // end installment payment expired
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return $this->formatResponse(false, $e->getMessage(), 'admin.notify_email.list',1);
        }
        DB::commit();
        return $this->formatResponse(true, '', 'admin.notify_email.list',1);
    }
}
