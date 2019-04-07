<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado - https://github.com/diomac
 * Date: 04/03/2019
 * Time: 14:01
 */

namespace Diomac\API\swagger;


use Exception;

class SwaggerPath
{
    /**
     * @var string $route
     */
    private $route;
    /**
     * @var SwaggerMethod[] $methods
     */
    private $methods;
    /**
     * @var string[] $allowedMethods
     */
    private $allowedMethods;

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return $this->route;
    }

    /**
     * @param string $route
     */
    public function setRoute(string $route): void
    {
        $this->route = $route;
    }

    /**
     * @return SwaggerMethod[]
     */
    public function getMethods(): array
    {
        return $this->methods;
    }

    /**
     * @param SwaggerMethod[] $methods
     */
    public function setMethods(array $methods): void
    {
        $this->methods = $methods;
    }

    /**
     * @return string[]
     */
    public function getAllowedMethods(): array
    {
        return $this->allowedMethods;
    }

    /**
     * @param string[] $allowedMethods
     */
    public function setAllowedMethods(array $allowedMethods): void
    {
        $this->allowedMethods = $allowedMethods;
    }

    /**
     * @param string $name
     * @return SwaggerMethod
     * @throws Exception
     */
    public function getMethodByName(string $name): SwaggerMethod
    {
        $filter = array_filter($this->methods, function (SwaggerMethod $m) use ($name) {
            return $m->getName() === $name;
        });

        if ($filter){
            return $filter[0];
        }

        throw new Exception('Config routes error. Verify your resources class.');
    }
}
