 
 Can:
 1. construct: $this->response = new ApiResponse
 2. injection: ApiResponse $response

 1.
```php
 $this->response->setHeader([])->setOption(0);
 $this->response->success([1,2], status, code)->json();
 $this->response->error("WTF")->json();
```
 2.
```php
 $this->response->setHeader([])->setOption(0)->success(data, status, code)->json();
 $this->response->setHeader([])->setOption(0)->error("WTF", status, code)->json();
```

```json
 {
 	"success": true
 	"detail": {
 		"status": 200,
 		"code": "200",
 		"message": "ya~"
 	}
 	"data": {
 		// ~~~
 	},
 	"link": null,
 	"meta": null
 }


 {
 	"success": false
 	"detail": {
 		"status": 404,
 		"code": "404",
 		"message": "no~"
 	}
 	"error": {
      // ~~~
  },
 	"link": null,
 	"meta": null
 }
```
