<?php

namespace CHHW\ApiResponse;

use CHHW\ApiResponse\Builders\ErrorResponseBuilder;
use CHHW\ApiResponse\Builders\SuccessResponseBuilder;

abstract class ApiResponseBase
{
    protected $data = [];
    protected $status = 200;
    protected $headers = [];
    protected $options = 0;
    protected $success = true;
    protected $code = "200";

    public function json()
    {
        $builder = $this->success ? new SuccessResponseBuilder() : new ErrorResponseBuilder();
        return response()->json(
            $builder->formatResponse([
                'data' => $this->data,
                'status' => $this->status,
                'success' => $this->success,
                'code' => $this->code
            ]),
            $this->status,
            $this->headers,
            $this->options
        );
    }

    public function setHeader($headers)
    {
        $this->headers = $headers;
        return $this;
    }

    public function setOption($options)
    {
        $this->options = $options;
        return $this;
    }

}
