<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado - https://github.com/diomac
 * Date: 05/03/2019
 * Time: 14:24
 */

namespace Diomac\API;

use stdClass;

class RouteConfigGuard
{
    /**
     * @var string $guardClass
     */
    private $guardClass;
    /**
     * @var stdClass $guardParams
     */
    private $guardParams;

    /**
     * @return string
     */
    public function getGuardClass(): string
    {
        return $this->guardClass;
    }

    /**
     * @param string $guardClass
     */
    public function setGuardClass(string $guardClass): void
    {
        $this->guardClass = $guardClass;
    }

    /**
     * @return stdClass
     */
    public function getGuardParams(): ?stdClass
    {
        return $this->guardParams;
    }

    /**
     * @param null|stdClass $guardParams
     */
    public function setGuardParams(stdClass $guardParams = null): void
    {
        $this->guardParams = $guardParams;
    }
}
