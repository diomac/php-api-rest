<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado (https://github.com/diomac)
 * Date: 31/07/2018
 * Time: 16:21
 */

namespace Diomac\API;

/**
 * Interface Guard
 * @package Diomac\API
 */
Interface Guard
{
    /**
     * @param object|null $params
     * @return bool
     * @throws UnauthorizedException
     * @throws ForbiddenException
     * @throws \Exception
     */
    public function guard(object $params = null) : bool;
}
