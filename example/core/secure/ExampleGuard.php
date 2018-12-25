<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado - https://github.com/diomac
 * Date: 25/12/2018
 * Time: 10:59
 */

namespace example\core\secure;

use Diomac\API\Guard;

class ExampleGuard implements Guard
{
    public function guard(object $guardParams = null) : bool
    {
        return true;
    }
}