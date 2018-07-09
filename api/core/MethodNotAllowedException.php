<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado (https://github.com/diomac)
 * Date: 09/07/2018
 * Time: 12:31
 */

namespace api\core;


class MethodNotAllowedException extends \Exception
{
    protected $code = 405;
    protected $message = 'The HTTP method specified in the Request-Line is not allowed for the resource identified by the Request-URI';
}