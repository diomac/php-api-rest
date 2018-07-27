<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado (https://github.com/diomac)
 * Date: 08/07/2018
 * Time: 10:01
 */

include '../../inicia.php';

use api\core\App;

$config = [
    'namespace' => ['api', 'v2'],
    'resources' => [
        'Auth'
    ]
];

$app = new App($config);
$app->exec();
