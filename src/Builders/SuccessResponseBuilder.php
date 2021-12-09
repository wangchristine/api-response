<?php

namespace CHHW\ApiResponse\Builders;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class SuccessResponseBuilder extends ResponseBuilder
{
    public function __construct()
    {
        $this->dataKey = "data";
    }

    public function formatResponse($resource)
    {
        $data = $this->formatData($resource['data'], $this->dataKey);

        $format = [
            "success" => $resource['success'],
            "detail" => [
                "status" => $resource['status'],
                "code" => $resource['code'],
                "message" => config('response.code.' . $resource['code']) ?? "OK",
            ]
        ];

        $format += $data;

        return $format;
    }

    private function formatData($data, $dataKey)
    {
        if ($data instanceof LengthAwarePaginator) {
            return $this->formatPaginate($data, $dataKey);
        } else if ($data instanceof Paginator) {
            return $this->formatSimplePaginate($data, $dataKey);
        } else {
            return $this->format($data, $dataKey);
        }
    }

    private function formatPaginate($data, $dataKey)
    {
        return [
            $dataKey => $data->toArray()['data'],
            "links" => [
                "first" => $data->toArray()['first_page_url'],
                "last" => $data->toArray()['last_page_url'],
                "prev" => $data->toArray()['prev_page_url'],
                "next" => $data->toArray()['next_page_url']
            ],
            "meta" => [
                "current_page" => $data->toArray()['current_page'],
                "from" => $data->toArray()['from'],
                "last_page" => $data->toArray()['last_page'],
                "path" => $data->toArray()['path'],
                "per_page" => $data->toArray()['per_page'],
                "to" => $data->toArray()['to'],
                "total" => $data->toArray()['total']
            ]
        ];
    }

    private function formatSimplePaginate($data, $dataKey)
    {
        return [
            $dataKey => $data->toArray()['data'],
            "links" => [
                "first" => $data->toArray()['first_page_url'],
                "prev" => $data->toArray()['prev_page_url'],
                "next" => $data->toArray()['next_page_url']
            ],
            "meta" => [
                "current_page" => $data->toArray()['current_page'],
                "from" => $data->toArray()['from'],
                "path" => $data->toArray()['path'],
                "per_page" => $data->toArray()['per_page'],
                "to" => $data->toArray()['to']
            ]
        ];
    }
}
