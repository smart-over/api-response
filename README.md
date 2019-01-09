# api-response
## Lumen standard api responses for SmartOver microservices


### Install package
```
composer require smart-over/api-response
```
### Namespace
```
use SmartOver\ApiResponse\JsonResponse;
```
### Create your success response
```
$response = (new JsonResponse())->render();
```

### Create your error response
```
$response = (new JsonResponse('YOUR-ERROR-CODE', 500))->render();
```
