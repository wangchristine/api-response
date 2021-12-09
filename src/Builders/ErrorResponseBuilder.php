<?php

namespace CHHW\ApiResponse\Builders;

class ErrorResponseBuilder extends ResponseBuilder
{
    public function __construct()
    {
        $this->dataKey = "error";
    }

    public function formatResponse($resource)
    {
        $data = $this->format($resource['data'], $this->dataKey);

        $format = [
            "success" => $resource['success'],
            "detail" => [
                "status" => $resource['status'],
                "code" => $resource['code'],
                "message" => config('response.code.' . $resource['code']) ?? "Something went wrong.",
            ]
        ];

        $format += $data;

        return $format;
    }
}
