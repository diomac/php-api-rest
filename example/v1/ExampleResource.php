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
use Diomac\API\UnauthorizedException;

class ExampleResource extends Resource
{
    /**
     * @method get
     * @route /example/api/value1/{value1}/value2/{value2}
     * @contentType application/json
     * @summary Recupera as credenciais do token
     * @description As credenciais mostram os acessos que o token permite
     * @operationId GETUSERDATA
     * @consumeType text/plain; charset=utf-8
     * @response(
     *     code=401,
     *     description="Unauthorized"
     * )
     * @guard(
     *     className="ExampleGuard",
     *     guardParameters={"operationId":"GETUSERDATA"}
     * )
     */
    function getUsrData()
    {
        $this->response->setCode(Response::OK);
        $this->response->setBodyJSON($this->request->getParams());
        return $this->response;
    }
}
