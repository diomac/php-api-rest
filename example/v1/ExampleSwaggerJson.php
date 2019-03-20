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
use example\v1\doc\ExampleSwaggerDoc;

class ExampleSwaggerJson extends Resource
{
    /**
     * @method get
     * @route /swagger.json
     * @summary Example api rest php
     * @description A example api rest php
     * @response(
     *     code="default",
     *     description="Internal Server Error"
     * )
     * @throws \Exception
     */
    function swaggerJson()
    {
        $this->response->setCode(Response::OK);
        $swagger = new ExampleSwaggerDoc();

        /**
         * JSON
         */
        $this->response->setBodySwaggerJSON($swagger);
        /**
         * Or YAML
         */
        //$this->response->setBodySwaggerYAML($swagger);
        return $this->response;
    }
}
