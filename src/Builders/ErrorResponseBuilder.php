<?php

namespace CHHW\ApiResponse\Builders;

class ErrorResponseBuilder extends ResponseBuilder
{
    public function formatResponse($resource)
    {
        return [
            "success" => $resource['success'],
            "detail" => [
                "status" => $resource['status'],
                "code" => $resource['code'],
                "message" => "no~"
            ],
            "error" => $resource['data'],
            "link" => null,
            "meta" => null
        ];
    }
}
