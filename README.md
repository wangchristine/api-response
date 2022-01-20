# Laravel Api Response

> This package gives you an easier way to return RESTful API response.

# Installation

Install by composer

```bash
    $ composer require chhw/api-response
```

If you are under Laravel 5.5, please add this code in `config/app.php` below.

```php
    <?php
        'providers' => [
            CHHW\ApiResponse\ApiResponseServiceProvider::class,
        ],
    ?>
```

[Option] Get response config to customize debug message.

```bash
    $ php artisan vendor:publish --provider="CHHW\ApiResponse\ApiResponseServiceProvider"
```

## Also support Lumen now!!

In `bootstrap/app.php`, you should:
1. add `$app->register(CHHW\ApiResponse\ApiResponseServiceProvider::class);`

[Option] Get response config to customize debug message.

```bash
    $ cp vendor/chhw/api-response/src/config/response.php config/response.php
```

# Usage

> Should be used in your controller.

### Define:

You can choose what you prefer:

 1. construct: ```$this->response = new ApiResponse```
 2. injection: ```ApiResponse $response```

### Example:

> General
 
```php
 // You can set header and option in construct.
$this->response->setHeader(["lang" => "en"])->setOption(JSON_UNESCAPED_UNICODE);

// Basic usage.
return $this->response->success([1, 2])->json();
return $this->response->error("Oh no")->json();

// Custom status and code.
return $this->response->success([1, 2], 201, "code201")->json();
return $this->response->error("Oh no", 501, "code501")->json();
```

> Inline

```php
return $this->response->success([1, 2])->setHeader(["lang" => "en"])->setOption(JSON_UNESCAPED_UNICODE)->json();
return $this->response->error("Oh no", 501, "code501")->setHeader(["lang" => "en"])->setOption(JSON_UNESCAPED_UNICODE)->json();
```

### [Option] Custom debug message:

If you have custom code, by default it will match `config/response.php` settings for debug message:

```php
// Controller
return $this->response->error([1, 2], 500, 'custom500')->json();

// config/response.php
return [
    'code' => [
        'custom500' => 'Internal Server Error',
    ]
];
```

### Response:

> Success

```json
 {
    "success": true,
    "detail": {
        "status": 200,
        "code": "200",
        "message": "OK"
    },
    "data": {
        ...
    },
    "link": null,
    "meta": null
 }
```

> Error

```json
 {
    "success": false,
    "detail": {
        "status": 404,
        "code": "404",
        "message": "Something went wrong."
    },
    "error": {
        ...
    },
    "link": null,
    "meta": null
 }
```

# Supported methods

> $data can be array, string or object etc.

> $code for someone who want to custom internal http code. 

```php
public function success($data = [], $status = 200, $code = "200");
public function error($data = [], $status = 500, $code = "500");
public function setHeader($headers);
public function setOption($options);
```

# Log tracing

> Response header with an unique UUID4: `X-Trace-Id`


# Collection Paginator

> Collection Paginator usage just like model !

> You can use Api Response and Collection Paginator together.

### Example:

```php
collect([1,2,3,4,5])->paginate(10)
collect([1,2,3,4,5])->simplePaginate(15)
```

### Supported methods:

```php
paginate($perPage = 15, $pageName = 'page', $page = null);
simplePaginate($perPage = 15, $pageName = 'page', $page = null);
```
