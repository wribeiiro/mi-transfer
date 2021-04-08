<?php

declare(strict_types=1);

namespace App\Enum;

final class ResponseEnum
{

    // Success
    const HTTP_OK                    = 200;
    const HTTP_CREATED               = 201;
    const HTTP_NO_CONTENT            = 204;

    // Client Error
    const HTTP_BAD_REQUEST           = 400;
    const HTTP_UNAUTHORIZED          = 401;

    // Server Error
    const HTTP_INTERNAL_SERVER_ERROR = 500;
}
