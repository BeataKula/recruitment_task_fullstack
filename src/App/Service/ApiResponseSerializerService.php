<?php

namespace App\Service;

use App\Model\ApiResponse;


class ApiResponseSerializerService
{
    public function serializeToJson(ApiResponse $response): string
    {
        return json_encode($response);
    }
}
