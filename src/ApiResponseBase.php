<?php

namespace CHHW\ApiResponse;

use CHHW\ApiResponse\Builders\ErrorResponseBuilder;
use CHHW\ApiResponse\Builders\SuccessResponseBuilder;
use Ramsey\Uuid\Uuid;

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
            array_merge($this->headers, $this->baseHeaders()),
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

    protected function baseHeaders()
    {
        return [
            "X-Trace-Id" => $this->getTraceId(),
        ];
    }

    protected function getTraceId()
    {
        defined('X_Trace_Id') || define('X_Trace_Id', Uuid::uuid4()->toString());
        
        return X_Trace_Id;
    }
}
