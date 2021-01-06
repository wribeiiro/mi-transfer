<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class EmailService
{
    const SUBJECT = "MiTransfer";
    const IS_HTML = true;
    const SERVER_SETTINGS = [
        "host" => "mail.wribeiiro.com",
        "smtpAuth" => true,
        "username" => "dev@wribeiiro.com",
        "password" => "xbox360",
        "port" => 587
    ];

    private string $email_from;
    private string $email_to;
    private string $message;
    private string $attachment;

    /**
     *
     * @param string $emailFrom
     * @param string $emailTo
     * @param string $message
     * @param string $attachment
     */
    public function __construct(
        string $emailFrom, 
        string $emailTo, 
        string $message = "",
        string $attachment)
    {
        $this->email_from = $emailFrom;
        $this->email_to = $emailTo;
        $this->message = $message . ";";
        $this->attachment = $attachment;
    }

    public function send(): string {

        $mail = new PHPMailer(true);

        try {

            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                  
            $mail->isSMTP();    

            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true
                )
            );

            $mail->Host       = self::SERVER_SETTINGS['host'];                    
            $mail->SMTPAuth   = self::SERVER_SETTINGS['smtpAuth'];                                  
            $mail->Username   = self::SERVER_SETTINGS['username'];                     
            $mail->Password   = self::SERVER_SETTINGS['password'];   
            $mail->Port       = self::SERVER_SETTINGS['port'];                            
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;       
           
            $mail->setFrom($this->email_from, $this->email_from);
            $mail->addAddress($this->email_to);    
            $mail->addAttachment($this->attachment);  
            $mail->isHTML(self::IS_HTML);

            $mail->Subject = self::SUBJECT;
            $mail->Body    = $this->message;
            $mail->AltBody = $this->message;

            $result = "OK";
            
            if (!$mail->send()) {
                $result = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

        } catch (Exception $except) {
            $result = $except->getMessage();
        }

        return $result;
    }
}
