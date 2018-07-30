<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado (https://github.com/diomac)
 * Date: 12/07/2018
 * Time: 13:46
 */

namespace Diomac\API;

/**
 * Class BadRequestException
 * @package Diomac\API
 */
class BadRequestException extends \Exception
{
    protected $code = Response::BAD_REQUEST;
}