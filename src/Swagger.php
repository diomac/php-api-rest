<?php
/**
 * Created by PhpStorm.
 * User: dioma
 * Date: 19/10/2018
 * Time: 15:45
 */

namespace Diomac\API;


Interface Swagger
{
    /**
     * @return array
     */
    public function info() : array;
    public function host() : string;
    public function basePath() : string;
    public function schemes() : array;
    public function definitions() : array;
    public function defaultResponsesDescription() : array;
}