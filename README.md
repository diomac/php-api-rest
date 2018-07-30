PHP-API-REST
============
A PHP API REST Micro-Framework using annotations

### Prerequisites

* PHP >=7
* APC - Auternative PHP Cache - if use cache routes
* Use namespaces in your project

### Installing and using

##### Soon I will be available with Composer dependency management. But for now it follows:

* 1 - Copy the core folder to the root of your REST API;
* 2 - Set the namespaces if necessary (better keep the root of your REST API as "api");
* 3 - Create a folder where the resources of your REST API will be;
* 4 - Place an .htaccess file (Apache Servers) to to redirect all routes to the REST API initialization file:
```
RewriteEngine On
RewriteCond %{REQUEST_URI} !api-start\.php$
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule .* api-start.php [L,QSA]
```

* 5 - Use the api-start.php file to import the dependencies of your project, enter the namespace (each folder in an array key) and the list of resources of your REST API in the variable $config:
```
use api\core\App;
$config = [
    'namespace' => ['api', 'v1'],
    'resources' => [
        'ExampleResource'
    ]
];
$app = new App($config);
$app->exec();
```

* 6 - In the resource class, enter the inheritance of the Resource class:
```
namespace api\v1;

use api\core\Resource;
use api\core\Response;
use api\core\UnauthorizedException;

class ExampleResource extends Resource {...
```

* 7 - For each method of the resource class, enter PHP annotation to identify routes (@route), HTTP methods (@method) and if you need a function to protect the route (@guard):
```
/**
* @method get
* @route /auth/usr-data/id/{id}
* @guard secure
*/
function getUsrData()
{
  // ... your code
  $this->response->setCode(Response::OK); // set HTTP response code
  $this->response->setBodyJSON($ this->request->getData()); // set responde data
  return $this->response; // return response object
}

function secure(){
  //... check access
  //throw new UnauthorizedException();
  return true;
}
```
## Running a route

Whenever a route is executed, the class holding the route will be instantiated and inherit the following attributes:

A Request object with the methods:
```
$this->request->getParams() // returns the parameters of the URL and $_GET
$this->request->getData()   // returns an object sent by the front end
$this->request->getRoute()  // return the executed route
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
* @guard secure1
* @guard secure2WithJSONParam {"param1":"value1"}
*/
function getUsrData()
{
  // ... your code
  $this->response->setCode(Response::OK); // set HTTP response code
  $this->response->setBodyJSON($ this->request->getData()); // set responde data
  return $this->response; // return response object
}

function secure1(){
  //... check access
  //throw new UnauthorizedException();
  return true;
}

function secure2WithJSONParam(){
  $param1 = $this->getGuardParam('param1');
  //... check access
  //throw new UnauthorizedException();
  return true;
}
```
## Using cache (APC - Auternative PHP Cache)
```
use api\core\App;
$config = [
    'namespace' => ['api', 'v1'],
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

        
