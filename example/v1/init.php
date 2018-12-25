<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado (https://github.com/diomac)
 * Date: 08/07/2018
 * Time: 10:01
 */

use Diomac\API\App;
use Diomac\API\AppConfiguration;

$config = new AppConfiguration();
$config->setNamespaceResources(['example', 'v1']);
$config->setResources(['ExampleResource']);
$config->setNamespaceGuards(['api', 'secure']);
$config->setContentTypeExceptions('application/json');
$config->setUseCache(false);

$app = new App($config);
$app->exec();
