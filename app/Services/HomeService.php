<?php 

namespace App\Services;

use App\Services\EmailService;
use App\Services\ZipFilesService;

final class HomeService 
{

    public static function handle(string $emailFrom, string $emailTo, string $message, array $files) {

        if (empty($emailFrom) || !filter_var($emailFrom, FILTER_VALIDATE_EMAIL)) {
			return "E-mail from is invalid";
        }
        
        if (empty($emailTo) || !filter_var($emailTo, FILTER_VALIDATE_EMAIL)) {
			return "E-mail to is invalid";
		}

		if (count($files) <= 0) {	
			return "Files is required";
        }

        $email = new EmailService($emailFrom, $emailTo, $message, ZipFilesService::zip($files));
        
        return $email->send();
    }
}