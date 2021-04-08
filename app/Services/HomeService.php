<?php

namespace App\Services;

use App\Services\EmailService;
use App\Services\ZipFilesService;

use CodeIgniter\HTTP\IncomingRequest;

final class HomeService
{
    /**
     * Undocumented function
     *
     * @param IncomingRequest $request
     * @return mixed string|array
     */
    public static function create(IncomingRequest $request)
    {

        $emailFrom = $request->getPost('emailFrom', FILTER_SANITIZE_EMAIL);
        $emailTo = $request->getPost('emailTo', FILTER_SANITIZE_EMAIL);
        $message = $request->getPost('message', FILTER_SANITIZE_STRING);
        $files = $_FILES;

        $validations = self::validateFields($emailFrom, $emailTo, $files);

        if ($validations) {
            return $validations;
        }

        $email = new EmailService(
            $emailFrom,
            $emailTo,
            $message,
            ZipFilesService::zip($files['files'])
        );

        return $email->send();
    }

    /**
     * validateFields
     *
     * @param string $emailFrom
     * @param string $emailTo
     * @param array $files
     * @return array
     */
    private static function validateFields(
        string $emailFrom,
        string $emailTo,
        array $files
    ): array {
        $validations = [];

        if (!filter_var($emailFrom, FILTER_VALIDATE_EMAIL)) {
            $validations[] = "E-mail from is not valid.";
        }

        if (!filter_var($emailTo, FILTER_VALIDATE_EMAIL)) {
            $validations[] = "E-mail to is not valid.";
        }

        if (count($files) <= 0) {
            $validations[] = "You must select a file.";
        }

        return $validations;
    }
}
