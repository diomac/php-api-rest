# Simple-API-REST
### PHP Simple API REST using annotations

### Prerequisites

* PHP 7 or >
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
  $this->response->setCode(Response::OK);
  $this->response->setBodyJSON($ this->request->getData());
  return $this->response;
}
        
