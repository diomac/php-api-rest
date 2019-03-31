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
use example\v1\doc\NewPet;
use example\v1\doc\Pet;
use Exception;

/**
 * Class ExampleResource
 * @package example\v1
 * @tag(
 *     name="Example API Doc Swagger",
 *     description="Example API Doc Swagger",
 *     @externalDocs(description="External docs example", url="http://example_php_api_rest.com")
 * )
 */
class ExampleResource extends Resource
{
    /**
     * @method post
     * @route /example/api/value1/{value1}/value2/{value2}
     * @contentType application/json
     * @contentType text/html
     * @summary Example api rest php
     * @description A example api rest php
     * @operationId GETUSERDATA
     * @consumeType text/plain; charset=utf-8
     * @tag More one tag
     * @response(
     *     code=401,
     *     description="Unauthorized"
     * )
     * @response(
     *     code=200,
     *     description="Success",
     *     @schema(
     *     type="array",
     *     @items($ref="#/definitions/pet")
     * )
     *)
     * @response(
     *     code="default",
     *     description="Internal Server Error",
     *     @schema(
     *     type="array",
     *     @items($ref="#/definitions/internalError")
     * )
     * )
     * @parameter(
     *     in="path",
     *     name="value1",
     *     description="example param",
     *     type="integer",
     *     format="int32",
     *     required=true
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
     *     className="example\core\secure\ExampleGuard",
     *     @parameters(operationId="GETUSERDATA")
     * )
     * @throws \Exception
     */
    function getUsrData(): Response
    {
        $doc = new ExampleSwaggerDoc();
        $data = $this->request->getData($doc, new NewPet());
        $pet = new Pet();
        $this->response->setCode(Response::OK);
        $this->response->setBodyJSON($pet);
        return $this->response;
    }

    /**
     * @method get
     * @route /example/v1/pet/{petId}
     *
     * @return Response
     * @throws Exception
     */
    function getPet(): Response
    {
        try {
            $petId = $this->getParam('petId');
            $pet = new Pet($petId);

            /**
             * API Rest best practices - selecting returned fields and aliases
             */
            $fields = $this->getParam('fields');

            if($fields){
                Response::setFields(explode(',', $fields), Pet::class);
            }

            $this->response->setCode(Response::OK);
            $this->response->setBodyJSON($pet);
        } catch (Exception $ex) {
            throw new Exception('Internal Server Error', Response::INTERNAL_SERVER_ERROR);
        }

        return $this->response;
    }
}
