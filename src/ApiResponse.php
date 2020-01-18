<?php

namespace CHHW\ApiResponse;

use CHHW\ApiResponse\Contracts\JsonResponse;

class ApiResponse extends ApiResponseBase implements JsonResponse
{
    public function success($data = [], $status = 200, $code = "200")
    {
        $this->success = true;
        $this->data = $data;
        $this->status = $status;
        $this->code = $code;

        return $this;
    }

    public function error($data = [], $status = 500, $code = "500")
    {
        $this->success = false;
        $this->data = $data;
        $this->status = $status;
        $this->code = $code;

        return $this;
    }

}
