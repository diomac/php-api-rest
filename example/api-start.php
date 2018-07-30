<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado (https://github.com/diomac)
 * Date: 08/07/2018
 * Time: 10:01
 */

use Diomac\App;

$config = [
    'namespace' => ['example'],
    'resources' => [
        'ExampleResource'
    ]
];
$app = new App($config);
$app->exec();