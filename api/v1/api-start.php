<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado (https://github.com/diomac)
 * Date: 08/07/2018
 * Time: 10:01
 */

use api\core\App;

$config = [
    'namespace' => ['api', 'v1'],
    'resources' => [
        'ExampleResource'
    ]
];

$app = new App($config);
$app->exec();
