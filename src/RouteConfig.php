<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado - https://github.com/diomac
 * Date: 05/03/2019
 * Time: 14:22
 */

namespace Diomac\API;


class RouteConfig
{
    /**
     * @var string $resourceClass
     */
    private $resourceClass;
    /**
     * @var RouteConfigGuard[] $guards
     */
    private $guards;
    /**
     * @var \ReflectionMethod $function
     */
    private $function;

    /**
     * @return string
     */
    public function getResourceClass(): string
    {
        return $this->resourceClass;
    }

    /**
     * @param string $resourceClass
     */
    public function setResourceClass(string $resourceClass): void
    {
        $this->resourceClass = $resourceClass;
    }

    /**
     * @return null|RouteConfigGuard[]
     */
    public function getGuards(): ?array
    {
        return $this->guards;
    }

    /**
     * @param RouteConfigGuard[] $guards
     */
    public function setGuards(array $guards): void
    {
        $this->guards = $guards;
    }

    /**
     * @return \ReflectionMethod
     */
    public function getFunction(): \ReflectionMethod
    {
        return $this->function;
    }

    /**
     * @param \ReflectionMethod $function
     */
    public function setFunction(\ReflectionMethod $function): void
    {
        $this->function = $function;
    }
}
