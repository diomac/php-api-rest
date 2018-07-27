<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado (https://github.com/diomac)
 * Date: 08/07/2018
 * Time: 19:00
 */

namespace api\v2;

use api\core\Exception;
use api\core\ForbbidenException;
use api\core\Resource;
use api\core\Response;
use api\core\UnauthorizedException;

class Auth extends Resource
{
    /**
     * @method get
     * @route /auth/usr-data/id/{id}/id2/{id2}
     * @guard secure { "funcionalidade" : "USRDATA" }
     */
    function getUsrData()
    {
        $this->response->setCode(Response::OK);
        $this->response->setBodyJSON($this->request->getData());
        return $this->response;
    }

    function secure()
    {
        $func = $this->getGuardParam('funcionalidade');
        $access = \AutenticacaoToken::checkaAcesso($func);
        switch ($access) {
            case Response::OK:
                return true;
                break;
            case Response::UNAUTHORIZED:
                throw new UnauthorizedException();
                break;
            case Response::FORBIDDEN:
                throw new ForbbidenException();
                break;
            default:
                throw new Exception('Erro ao tentar autenticar usuário.', Response::INTERNAL_SERVER_ERROR);
        }
    }
}