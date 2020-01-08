<?php

namespace CHHW\ApiResponse;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class ApiResponse
{
    private $data = [];
    private $status = 200;
    private $headers = [];
    private $options = 0;

    public function __construct()
    {
        //
    }

    public function json($data = [])
    {
        // default: $data = [], $status = 200, array $headers = [], $options = 0
        return response()->json($this->setData($data), $this->status, $this->headers, $this->options);
    }

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

    private function setData($data)
    {
        $this->data = $data;

        if ($data instanceof LengthAwarePaginator) {
            return $this->formatPaginate();
        } else if ($data instanceof Paginator) {
            return $this->formatSimplePaginate();
        } else {
            return $this->format();
        }
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
}
