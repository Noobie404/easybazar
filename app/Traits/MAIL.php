<?php
namespace App\Traits;
use App\Models\Order;
trait MAIL
{
    public static function orderCreateEndEmail($mail_body, $customer_email) {
        try {
            require base_path("vendor/autoload.php");

            $mail = new \PHPMailer\PHPMailer\PHPMailer();
            // $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host = config('mail.host');
            $mail->SMTPAuth = true;
            $mail->Username = config('mail.username');
            $mail->Password = config('mail.password');
            $mail->SMTPSecure = config('mail.encryption');
            $mail->Port = config('mail.port');
            $mail->setFrom('admin@easybazar.com', 'easybazar');
            $mail->addAddress($customer_email);
            $mail->isHTML(true);

            // $mail_body = view('admin.Mail.order_place')
            // ->with('rows', $mail_body)
            // ->render();

            $mail->Subject = 'Your Order Has been Placed in easybazar';
            $mail->Body    = $mail_body;

            if(!$mail->Send()){
                return 0;
            }else{
                return 1;
            }
        } catch (\Exception $e) {
            // return $e->getMessage();
            return 0;
        }
    }

    public static function orderPaymentEmail($mail_body, $customer_email) {
        try {
            require base_path("vendor/autoload.php");

            $mail = new \PHPMailer\PHPMailer\PHPMailer();
            // $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host = config('mail.host');
            $mail->SMTPAuth = true;
            $mail->Username = config('mail.username');
            $mail->Password = config('mail.password');
            $mail->SMTPSecure = config('mail.encryption');
            $mail->Port = config('mail.port');
            $mail->setFrom('admin@easybazar.com', 'easybazar');
            $mail->addAddress($customer_email);
            $mail->isHTML(true);
            $mail->Subject = 'Payment Received in easybazar';
            $mail->Body    = $mail_body;

            if(!$mail->Send()){
                return 0;
            }else{
                return 1;
            }
        } catch (\Exception $e) {
            // return $e->getMessage();
            return 0;
        }
    }

    public static function orderPaymentConfirmationEmail($mail_body, $customer_email) {
        try {
            require base_path("vendor/autoload.php");

            $mail = new \PHPMailer\PHPMailer\PHPMailer();
            // $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host = config('mail.host');
            $mail->SMTPAuth = true;
            $mail->Username = config('mail.username');
            $mail->Password = config('mail.password');
            $mail->SMTPSecure = config('mail.encryption');
            $mail->Port = config('mail.port');
            $mail->setFrom('admin@easybazar.com', 'easybazar');
            $mail->addAddress($customer_email);
            $mail->isHTML(true);
            $mail->Subject = 'Payment Confirmed in easybazar';
            $mail->Body    = $mail_body;

            if(!$mail->Send()){
                return 0;
            }else{
                return 1;
            }
        } catch (\Exception $e) {
            // return $e->getMessage();
            return 0;
        }
    }

    public static function orderDispatchEmail($mail_body, $customer_email) {
        try {
            require base_path("vendor/autoload.php");

            $mail = new \PHPMailer\PHPMailer\PHPMailer();
            // $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host = config('mail.host');
            $mail->SMTPAuth = true;
            $mail->Username = config('mail.username');
            $mail->Password = config('mail.password');
            $mail->SMTPSecure = config('mail.encryption');
            $mail->Port = config('mail.port');
            $mail->setFrom('admin@easybazar.com', 'easybazar');
            $mail->addAddress($customer_email);
            $mail->isHTML(true);
            $mail->Subject  = 'Your Order has been dispatched';
            $mail->Body     = $mail_body;
            if(!$mail->Send()){
                return 0;
            }else{
                return 1;
            }
        } catch (\Exception $e) {
            // return $e->getMessage();
            return 0;
        }
    }

    public static function orderCancelEmail($mail_body, $customer_email) {
        try {
            require base_path("vendor/autoload.php");

            $mail = new \PHPMailer\PHPMailer\PHPMailer();
            // $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host = config('mail.host');
            $mail->SMTPAuth = true;
            $mail->Username = config('mail.username');
            $mail->Password = config('mail.password');
            $mail->SMTPSecure = config('mail.encryption');
            $mail->Port = config('mail.port');
            $mail->setFrom('admin@easybazar.com', 'easybazar');
            $mail->addAddress($customer_email);
            $mail->isHTML(true);

            // $mail_body = view('admin.Mail.order_cancel')
            // ->with('rows', $mail_body)
            // ->render();

            $mail->Subject = 'Your Order has been canceled';
            $mail->Body    = $mail_body;

            if(!$mail->Send()){
                return 0;
            }else{
                return 1;
            }
        } catch (\Exception $e) {
            // return $e->getMessage();
            return 0;
        }
    }

    public static function orderDefaultEmail($mail_body, $customer_email) {
        try {
            require base_path("vendor/autoload.php");

            $mail = new \PHPMailer\PHPMailer\PHPMailer();
            // $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host = config('mail.host');
            $mail->SMTPAuth = true;
            $mail->Username = config('mail.username');
            $mail->Password = config('mail.password');
            $mail->SMTPSecure = config('mail.encryption');
            $mail->Port = config('mail.port');
            $mail->setFrom('admin@easybazar.com', 'easybazar');
            $mail->addAddress($customer_email);
            $mail->isHTML(true);
            $mail->Subject = 'Your Order has been default';
            $mail->Body    = $mail_body;

            if(!$mail->Send()){
                return 0;
            }else{
                return 1;
            }
        } catch (\Exception $e) {
                return 0;
        }
    }

    public static function orderDefaultReminderEmail($mail_body, $customer_email) {
        try {
            require base_path("vendor/autoload.php");

            $mail = new \PHPMailer\PHPMailer\PHPMailer();
            // $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host = config('mail.host');
            $mail->SMTPAuth = true;
            $mail->Username = config('mail.username');
            $mail->Password = config('mail.password');
            $mail->SMTPSecure = config('mail.encryption');
            $mail->Port = config('mail.port');
            $mail->setFrom('admin@easybazar.com', 'easybazar');
            $mail->addAddress($customer_email);
            $mail->isHTML(true);
            $mail->Subject = 'Order Default Reminder';
            $mail->Body    = $mail_body;

            if(!$mail->Send()){
                return 0;
            }else{
                return 1;
            }
        } catch (\Exception $e) {
                return 0;
        }
    }

    public static function orderReturntEmail($mail_body, $customer_email) {
        try {
            require base_path("vendor/autoload.php");

            $mail = new \PHPMailer\PHPMailer\PHPMailer();
            // $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host = config('mail.host');
            $mail->SMTPAuth = true;
            $mail->Username = config('mail.username');
            $mail->Password = config('mail.password');
            $mail->SMTPSecure = config('mail.encryption');
            $mail->Port = config('mail.port');
            $mail->setFrom('admin@easybazar.com', 'easybazar');
            $mail->addAddress($customer_email);
            $mail->isHTML(true);

            // $mail_body = view('admin.Mail.order_return')
            // ->with('rows', $mail_body)
            // ->render();

            $mail->Subject = 'Your Order has been returned';
            $mail->Body    = $mail_body;

            if(!$mail->Send()){
                return 0;
            }else{
                return 1;
            }
        } catch (\Exception $e) {
            // return $e->getMessage();
            return 0;
        }
    }

    public static function orderArrivalEmail($mail_body, $customer_email) {
        try {
            require base_path("vendor/autoload.php");

            $mail = new \PHPMailer\PHPMailer\PHPMailer();
            // $mail->SMTPDebug = 4;
            $mail->isSMTP();
            $mail->Host = config('mail.host');
            $mail->SMTPAuth = true;
            $mail->Username = config('mail.username');
            $mail->Password = config('mail.password');
            $mail->SMTPSecure = config('mail.encryption');
            $mail->Port = config('mail.port');
            $mail->setFrom('admin@easybazar.com', 'easybazar');
            $mail->addAddress($customer_email);
            $mail->isHTML(true);

            // $mail_body = view('admin.Mail.order_arrive')
            // ->with('rows', $mail_body)
            // ->render();

            $mail->Subject = 'Your Order has been arrived';
            $mail->Body    = $mail_body;

            if(!$mail->Send()){
                return 0;
            }else{
                return 1;
            }
        } catch (\Exception $e) {
            // return $e->getMessage();
            return 0;
        }
    }

    public static function greetingEmail($cust_info) {
        try {
            require base_path("vendor/autoload.php");
            $customer_email = $cust_info->email;
            $mail = new \PHPMailer\PHPMailer\PHPMailer();
            // $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host = config('mail.host');
            $mail->SMTPAuth = true;
            $mail->Username = config('mail.username');
            $mail->Password = config('mail.password');
            $mail->SMTPSecure = config('mail.encryption');
            $mail->Port = config('mail.port');
            $mail->setFrom('admin@easybazar.com', 'easybazar');
            $mail->addAddress($customer_email);
            $mail->isHTML(true);

            $mail_body = view('admin.Mail.greeting')
            ->with('rows', $mail_body)
            ->render();

            $mail->Subject = 'Greetings from easybazar with customer link';
            $mail->Body    = $mail_body;

            if(!$mail->Send()){
                return 0;
            }else{
                return 1;
            }
        } catch (\Exception $e) {
            // return $e->getMessage();
            return 0;
        }
    }


}
