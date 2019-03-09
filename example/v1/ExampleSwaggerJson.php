<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado - https://github.com/diomac
 * Date: 25/12/2018
 * Time: 15:12
 */

namespace example\v1;

use Diomac\API\Resource;
use Diomac\API\Response;

class ExampleSwaggerJson extends Resource
{
    /**
     * @method get
     * @route /swagger.json
     * @summary Example api rest php
     * @description A example api rest php
     * @throws \Exception
     */
    function swaggerJson()
    {
        $this->response->setCode(Response::OK);
        $swagger = new ExampleSwaggerDoc();
        $this->response->setBodySwaggerJSON($swagger);
        return $this->response;
    }
}
