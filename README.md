PHP-API-REST
============
A PHP API REST Micro-Framework using annotations

Prerequisites
=============

* PHP >=7.2

Installing
==========
Use composer to manage your dependencies and download PHP-API-REST:

```bash
composer require diomac/php-api-rest
```
Using
=====
* 1 - Place an .htaccess file (Apache Servers) to redirect all routes to the REST API initialization file:
```
RewriteEngine On
RewriteCond %{REQUEST_URI} !api-start\.php$
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule .* api-start.php [L,QSA]
```

* 2 - Use the api-start.php file to import the dependencies of your project, enter the namespace (each folder in an array key) and the list of resources of your REST API in the variable $config:
```
use Diomac\API\App;
$config = [
    'namespaceResources' => ['api', 'v1'],
    'resources' => [
        'ExampleResource'
    ]
];
$app = new App($config);
$app->exec();
```

* 3 - In the resource class, enter the inheritance of the Resource class:
```
namespace example;

use Diomac\API\Resource;
use Diomac\API\Response;
use Diomac\API\UnauthorizedException;

class ExampleResource extends Resource {...
```

* 4 - For each method of the resource class, enter PHP annotation to identify routes (@route), HTTP methods (@method) and if you need a Class implementing Guard Interface to protect the route (@guard):
```
/**
* @method get
* @route /auth/usr-data/id/{id}
* @guard AuthGuard
*/
function getUsrData()
{
  // ... your code
  $this->response->setCode(Response::OK); // set HTTP response code
  $this->response->setBodyJSON($ this->request->getData()); // set responde data
  return $this->response; // return response object
}
```
## Running a route

Whenever a route is executed, the class holding the route will be instantiated and inherit the following attributes:

A Request object with the methods:
```
$this->request->getParams() // returns the parameters of the URL and $_GET
$this->request->getData()   // returns an object sent by the front end
$this->request->getRoute()  // returns the executed route
$this->request->getMethod() // returns the executed HTTP method
```
A Response object with the methods:
```
$this->response->setHeader('name', 'value'); // set HTTP header response
$this->response->setCode(Response::BAD_REQUEST); // set HTTP response code
$this->response->setBody('string'); // set response body
$this->response->setBodyJSON([]); // set response body to convert in JSON
$this->response->setContentType(''); // set content type response (for setBodyJSON not needed)
```
And it inherits methods from the Resource class:
```
$this->getRoute(); // returns the configured route
$this->getParams(); // returns the parameters of the URL and $_GET
$this->getParam('name'); // returns a parameter by name
```
For the output simply return the response object:
```
return $this->response;
```
## Using 1 or more route guards
```
/**
* @method get
* @route /auth/usr-data/id/{id}
* @guard AuthGuard
* @guard AuthGuard2WithJSONParam {"param1":"value1"}
*/
function getUsrData()
{
  // ... your code
  $this->response->setCode(Response::OK); // set HTTP response code
  $this->response->setBodyJSON($ this->request->getData()); // set responde data
  return $this->response; // return response object
}
```
## Implementing a Guard Class
```
namespace api\secure;

use Diomac\API\Exception;
use Diomac\API\ForbiddenException;
use Diomac\API\UnauthorizedException;
use Diomac\API\Response;
use Diomac\API\Guard;

/**
 * Class AuthGuard
 * @package api\secure
 */
class AuthGuard implements Guard
{
    /**
     * @param object|null $guardParams
     * @return bool
     * @throws Exception
     * @throws ForbiddenException
     * @throws UnauthorizedException
     */
    public function guard(object $guardParams = null) : bool
    {
        $func = $guardParams->func;
        $access = checkAccess($func);
        switch ($access) {
            case Response::OK:
                return true;
                break;
            case Response::UNAUTHORIZED:                
                throw new UnauthorizedException();
                break;
            case Response::FORBIDDEN:                
                throw new ForbiddenException();
                break;
            default:               
                throw new Exception('Server Error!', Response::INTERNAL_SERVER_ERROR);
        }
    }
}
```
## Config App options
|Option|Type|Default|Description|
|------|----|-------|-----------|
|contentTypeExceptions|string|'text/html'|(Optional) Set content type response when throw exceptions.|
|namespaceGuards|array|null|(Optional) Set namespace of guard Classes. (If the '@guard' annotation contains only the class name, you will need to set this option.)|
|namespaceResources|array|Not default|(Mandatory) Set namespace of resource Classes.|
|resources|array|Not default|(Mandatory) Set resource Classes list.|
|useCache|boolean|false|(Optional) Set use cache routes with APC -  Auternative PHP Cache.|
## Using cache (APC - Auternative PHP Cache)
```
use Diomac\API\App;
$config = [
    'namespaceResources' => ['api', 'v1'],
    'useCache' => true, // Stores the routes cached.
    'resources' => [
        'ExampleResource'
    ]
];
$app = new App($config);
$app->exec();
```
## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details

        
