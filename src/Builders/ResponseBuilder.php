<?php

namespace CHHW\ApiResponse\Builders;

abstract class ResponseBuilder
{
    protected $dataKey;

    public function format($data, $dataKey)
    {
        return [
            $dataKey => $data,
            "links" => null,
            "meta" => null
        ];
    }

}
