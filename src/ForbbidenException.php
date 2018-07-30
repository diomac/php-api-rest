<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado (https://github.com/diomac)
 * Date: 09/07/2018
 * Time: 12:23
 */

namespace Diomac\API;

/**
 * Class ForbbidenException
 * @package Diomac\API
 */
class ForbbidenException extends \Exception
{
    protected $code = 403;
    protected $message = 'Access Denied.';
}