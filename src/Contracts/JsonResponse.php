<?php

namespace CHHW\ApiResponse\Contracts;

interface JsonResponse {
    public function success($data = [], $status = 200, $code = "200");

    public function error($data = [], $status = 500, $code = "500");
}
