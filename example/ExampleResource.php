<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado (https://github.com/diomac)
 * Date: 08/07/2018
 * Time: 19:00
 */

namespace example;

use Diomac\Resource;
use Diomac\Response;
use Diomac\UnauthorizedException;

class ExampleResource extends Resource
{
    /**
     * @method post
     * @route /auth/usr-data/id/{id}/id2/{id2}
     * @guard secure
     */
    function getUsrData()
    {
        $this->response->setCode(Response::OK);
        $this->response->setBodyJSON($this->request->getData());
        return $this->response;
    }
    /**
     * @method get
     * @route /auth/usr-data/id/{id}/id2/{id2}
     * @guard secure
     */
    function getUsrData2()
    {
        $this->response->setCode(Response::OK);
        $this->response->setBodyJSON($this->request->getData());
        return $this->response;
    }
    function secure(){
        //throw new UnauthorizedException();
        return true;
    }
}