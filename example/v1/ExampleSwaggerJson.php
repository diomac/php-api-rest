<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado - https://github.com/diomac
 * Date: 25/12/2018
 * Time: 15:12
 */

namespace example\v1;

use Diomac\API\Resource;
use example\v1\ExampleSwaggerDoc;

class ExampleSwaggerJson extends Resource
{
    /**
     * @method get
     * @route /swagger.json
     */
    function swaggerJson(){
        $this->response->setCode(Response::OK);
        $swagger = new ExampleSwaggerDoc();
        $this->response->setBodySwaggerJSON($swagger);
        return $this->response;
    }
}