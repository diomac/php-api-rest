PHP-API-REST
============
PHP API REST framework using annotations, and Swagger 2.0 support.

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
RewriteCond %{REQUEST_URI} !init\.php$
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule .* init.php [L,QSA]
```

* 2 - Use the initialization file to import the dependencies of your project and...
    * Instantiate a Diomac\API\AppConfiguration object;
    * Set the base url of your API;
    * Add the Resources Class Names of your API (See how implements Resources in item 3);
    * Instantiate a Diomac\API\App object using the configuration object;
    * Finally call exec method.
```
use Diomac\API\App;
use Diomac\API\AppConfiguration;

/**
 * Initializing API configuration
 */
$config = new AppConfiguration();
$config->setBaseUrl('/php-api-rest/vendor/example/v1');

/**
 * Adding resources classes
 */
$config->addResource(\example\v1\ExampleResource::class);
$config->addResource(\example\core\secure\ExampleGuard::class);

/**
 * Execute API
 */
try{
    $app = new App($config);
    $app->exec();
}catch (Exception $ex){
 ...
}
```

* 3 - In the resource class, enter the inheritance of the Resource class:
```
namespace example;

use Diomac\API\Resource;
use Diomac\API\Response;
use Diomac\API\UnauthorizedException;

class ExampleResource extends Resource {...
```

* 4 - For each method of the resource class, enter PHP annotation to identify routes (@route), HTTP methods (@method) and if you need a Class implementing Guard Interface to protect the route (@guard - See how implement guards in topic ["Implementing a Guard Class"](https://github.com/diomac/php-api-rest#implementing-a-guard-class) ):
```
/**
* @method get
* @route /auth/usr-data/id/{id}
* @guard(
*     className="example\core\secure\ExampleGuard",
*     @parameters(operationId="GETUSERDATA")
* )
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
$this->response->setBodyJSON(\JsonSerializable object); // set response body to convert in JSON
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
## Using one or more route guards
```
/**
* @method get
* @route /auth/usr-data/id/{id}
* @guard(
*     className="example\core\secure\ExampleGuard"
* )
* @guard(
*     className="example\core\secure\ExampleGuardWithParams",
*     @parameters(operationId="GETUSERDATA", operationName="GETUSERDATA")
* )
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
## Using cache (APC - Auternative PHP Cache)
```
**
 * Setting use cache for caching of annotations mapping
 */
$config->setUseCache(true);

/**
 * Execute API
 */
try{
    $app = new App($config);
    $app->exec();
}catch (Exception $ex){
    ...
}
```
## Swagger 2.0 support
@tag - Use @tag in PHPDoc Class to document your routes with [Swagger Tag Object](https://github.com/OAI/OpenAPI-Specification/blob/master/versions/2.0.md#tagObject).
```
/**
 * Class ExampleResource
 * @package example\v1
 * @tag(
 *     name="Example API Doc Swagger",
 *     description="Example API Doc Swagger",
 *     @externalDocs(description="External docs example", url="http://example_php_api_rest.com")
 * )
 */
class ExampleResource extends Resource
{
    ...
}
```
@contentType - Use @contentType in PHPDoc function to document your routes with [Swagger produces \[string\]](https://github.com/OAI/OpenAPI-Specification/blob/master/versions/2.0.md#operationObject).
```
/**
     * @method get
     * @route /example/api/value1/{value1}/value2/{value2}
     * @contentType application/json
     * @contentType text/html
     */
    function getUsrData(): Response
    {
        ...
    }
```
## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details

        
