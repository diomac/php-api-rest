<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado (https://github.com/diomac)
 * Date: 09/07/2018
 * Time: 12:14
 */

namespace Diomac\API;

/**
 * Class UnauthorizedException
 * @package Diomac\API
 */
class UnauthorizedException extends \Exception
{
    protected $code = 401;
    protected $message = 'The request requires user authentication';
}