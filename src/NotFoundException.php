<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado (https://github.com/diomac)
 * Date: 09/07/2018
 * Time: 12:08
 */

namespace Diomac\API;

/**
 * Class NotFoundException
 * @package Diomac\API
 */
class NotFoundException extends \Exception
{
    protected $code = 404;
    protected $message = 'The server has not found anything matching the Request-URI';
}