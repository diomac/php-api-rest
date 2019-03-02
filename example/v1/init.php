<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado (https://github.com/diomac)
 * Date: 08/07/2018
 * Time: 10:01
 */

if (!@include('../../../autoload.php')) {
    die('Could not find autoloader');
}

use Diomac\API\App;
use Diomac\API\AppConfiguration;

$config = new AppConfiguration();
$config->setBaseUrl('/php-api-rest/vendor/example/v1');

$config->addResource(\example\v1\ExampleResource::class);
$config->addResource(\example\v1\ExampleSwaggerJson::class);

$config->setContentTypeExceptions('application/json');

$config->setUseCache(false);

try {
    $app = new App($config);
    $app->exec();
} catch (\Exception $ex) {
    dd($ex);
}
