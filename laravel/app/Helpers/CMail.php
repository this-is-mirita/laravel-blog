<?php

namespace App\Helpers;

use Log;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class CMail
{
    public static function send($config)
    {
        Log::info('CMail config:', $config);
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 2; // Временно включи отладку
            $mail->Debugoutput = 'error_log'; // Покажи ошибки в логах Laravel
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host = config('services.mail.host');                     //Set the SMTP server to send through
            $mail->SMTPAuth = true;                                   //Enable SMTP authentication
            $mail->Username = config('services.mail.username');                     //SMTP username
            $mail->Password = config('services.mail.password');                               //SMTP password
            $mail->SMTPSecure = config('services.mail.encryption');            //Enable implicit TLS encryption
            $mail->Port = config('services.mail.port');                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom(
                isset($config['from_address']) ? $config['from_address'] : config('services.mail.from_address'),
                isset($config['from_name']) ? $config['from_name'] : config('services.mail.from_name')
            );
            if (!isset($config['recipient_address'])) {
                throw new \Exception('recipient_address is required');
            }

            $mail->addAddress(
                $config['recipient_address'],
                $config['recipient_name'] ?? null
            );

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->CharSet = 'UTF-8';
            $mail->Subject = $config['subject'];
            $mail->Body = $config['body'];
            if( !$mail->send()){
                return false;
            } else {
                return true;
            }
        } catch (Exception $e) {
            return false;
        }
    }
}

?>
