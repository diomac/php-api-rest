<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado (https://github.com/diomac)
 * Date: 08/07/2018
 * Time: 19:00
 */

namespace example\v1;

use Diomac\API\Resource;
use Diomac\API\Response;

/**
 * Class ExampleResource
 * @package example\v1
 * @resourceName Example API Doc Swagger
 * @resourceDescription Example API Doc Swagger (tag)
 * @externalDocs(
 *     description="External docs example",
 *     url="http://example_php_api_rest.com"
 * )
 * @teste()
 */
class ExampleResource extends Resource
{
    /**
     * @method get
     * @route /example/api/value1/{value1}/value2/{value2}
     * @contentType application/json
     * @summary Example api rest php
     * @description A example api rest php
     * @operationId GETUSERDATA
     * @consumeType text/plain; charset=utf-8
     * @response(
     *     code=401,
     *     description="Unauthorized",
     *     @schema(
     *     type="array",
     *     @items(
     *     $ref="#/definitions/pet",
     *     @teste()
     * )
     * )
     * )
     * @response(
     *     code=200,
     *     description="Unauthorized"
     * )
     * @parameter(
     *     in="path",
     *     name="value1",
     *     description="example param",
     *     type="integer",
     *     format="int32",
     *     required=true
     * )
     * @guard(
     *     className="ExampleGuard0",
     *     @parameters(operationId="GETUSERDATA0")
     * )
     * @parameter(
     *     in="path",
     *     name="value2",
     *     description="example param",
     *     type="integer",
     *     format="int32",
     *     required=true
     * )
     * @guard(
     *     className="ExampleGuard",
     *     @parameters(operationId="GETUSERDATA")
     * )
     * @guard(
     *     className="ExampleGuard2",
     *     @parameters(operationId="GETUSERDATA2")
     * )
     */
    function getUsrData()
    {
        $this->response->setCode(Response::OK);
        $this->response->setBodyJSON($this->request->getParams());
        return $this->response;
    }
}
