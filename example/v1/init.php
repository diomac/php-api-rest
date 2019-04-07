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

if (!@include('../../vendor/autoload.php')) {
    die('Could not find autoloader');
}

use Diomac\API\App;
use Diomac\API\AppConfiguration;
use example\v1\ExampleResource;
use example\v1\ExampleSwaggerJson;

/**
 * Initializing API configuration
 */
$config = new AppConfiguration();
$config->setBaseUrl('/php-api-rest/vendor/example/v1');

/**
 * Adding resources classes
 */
$config->addResource(ExampleResource::class);

/**
 * Adding swagger doc class
 */
$config->setSwaggerResourceName(ExampleSwaggerJson::class);

/**
 * Setting contentType for Exceptions
 */
$config->setContentTypeExceptions('application/json');

/**
 * Setting use cache
 */
$config->setNameCache('MyProjectCacheRoutes');
$config->setUseCache(false);

/**
 * Execute API
 */
try{
    $app = new App($config);
    $app->exec();
}catch (Exception $ex){

}

