<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado (https://github.com/diomac)
 * Date: 08/07/2018
 * Time: 15:30
 */

namespace Diomac\API;

use Exception as ExceptionCore;
use JsonSerializable;

/**
 * Class Exception
 * @package Diomac\API
 */
class Exception extends ExceptionCore implements JsonSerializable
{
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     * @throws ExceptionCore
     */
    public function jsonSerialize(): array
    {
        Response::jsonField('code', $this->getCode());
        Response::jsonField('message', $this->getMessage());

        return Response::jsonSerialize($this, true);
    }
}
