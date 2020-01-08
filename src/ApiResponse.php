<?php

namespace CHHW\ApiResponse;

use Illuminate\Pagination\AbstractPaginator;

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
        // dd($this->data->toArray());
        return [
            "data" => $this->data->toArray()['data'],
            "links" => [
                "first" => $this->data->toArray()['first_page_url'],
                "last" => $this->data->toArray()['last_page_url'],   // optional
                "prev" => $this->data->toArray()['prev_page_url'],
                "next" => $this->data->toArray()['next_page_url']
            ],
            "meta" => [
                "current_page" => $this->data->toArray()['current_page'],
                "from" => $this->data->toArray()['from'],
                "last_page" => $this->data->toArray()['last_page'],  // optional
                "path" => $this->data->toArray()['path'],
                "per_page" => $this->data->toArray()['per_page'],
                "to" => $this->data->toArray()['to'],
                "total" => $this->data->toArray()['total']    // optional
            ]
        ];

        // return $this->data;
    }

    private function setData($data)
    {
        $this->data = $data;

        if ($data instanceof AbstractPaginator) {
            return $this->formatPaginate();
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
