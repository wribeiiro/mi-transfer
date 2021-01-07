<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class EmailService
{
    const SUBJECT = "MiTransfer";
    const IS_HTML = false;

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

        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 0);
		ini_set('post_max_size', '2G');
		ini_set('upload_max_filesize', '2G');

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

            $mail->Host       = getenv('email.hostname');                    
            $mail->SMTPAuth   = getenv('email.smtpauth');                                  
            $mail->Username   = getenv('email.username');                     
            $mail->Password   = getenv('email.password');   
            $mail->Port       = getenv('email.port');                            
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  
            
            $mail->setFrom($this->email_from, self::SUBJECT);
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
