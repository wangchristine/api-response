<?php

namespace CHHW\ApiResponse;

use CHHW\ApiResponse\Builders\ErrorResponseBuilder;
use CHHW\ApiResponse\Builders\SuccessResponseBuilder;

class ApiResponseBase
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

//    private function setData($data)
//    {
//        $this->data = $data;
//
//        if ($data instanceof LengthAwarePaginator) {
//            return $this->formatPaginate();
//        } else if ($data instanceof Paginator) {
//            return $this->formatSimplePaginate();
//        } else {
//            return $this->format();
//        }
//    }

    private function format()
    {
        return [
            "data" => $this->data,
            "links" => null,
            "meta" => null
        ];
    }

    private function formatPaginate()
    {
        return [
            "data" => $this->data->toArray()['data'],
            "links" => [
                "first" => $this->data->toArray()['first_page_url'],
                "last" => $this->data->toArray()['last_page_url'],
                "prev" => $this->data->toArray()['prev_page_url'],
                "next" => $this->data->toArray()['next_page_url']
            ],
            "meta" => [
                "current_page" => $this->data->toArray()['current_page'],
                "from" => $this->data->toArray()['from'],
                "last_page" => $this->data->toArray()['last_page'],
                "path" => $this->data->toArray()['path'],
                "per_page" => $this->data->toArray()['per_page'],
                "to" => $this->data->toArray()['to'],
                "total" => $this->data->toArray()['total']
            ]
        ];
    }

    private function formatSimplePaginate()
    {
        return [
            "data" => $this->data->toArray()['data'],
            "links" => [
                "first" => $this->data->toArray()['first_page_url'],
                "prev" => $this->data->toArray()['prev_page_url'],
                "next" => $this->data->toArray()['next_page_url']
            ],
            "meta" => [
                "current_page" => $this->data->toArray()['current_page'],
                "from" => $this->data->toArray()['from'],
                "path" => $this->data->toArray()['path'],
                "per_page" => $this->data->toArray()['per_page'],
                "to" => $this->data->toArray()['to']
            ]
        ];
    }

}
