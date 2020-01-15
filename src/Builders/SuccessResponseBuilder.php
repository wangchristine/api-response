<?php

namespace CHHW\ApiResponse\Builders;

class SuccessResponseBuilder extends ResponseBuilder
{
    public function formatResponse($resource)
    {
        return [
            "success" => $resource['success'],
            "detail" => [
                "status" => $resource['status'],
                "code" => $resource['code'],
                "message" => "ya~"
            ],
            "data" => $resource['data'],
            "link" => null,
            "meta" => null
        ];
    }
}
