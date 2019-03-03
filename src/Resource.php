<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado (https://github.com/diomac)
 * Date: 08/07/2018
 * Time: 20:02
 */

namespace Diomac\API;

/**
 * Class Resource
 * @package Diomac\API
 */
class Resource
{
    /**
     * @var array $params
     */
    private $params;
    /**
     * @var Request $request
     */
    protected $request;
    /**
     * @var Response $response
     */
    protected $response;
    /**
     * @var string $route
     */
    protected $route;
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
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param array $params
     */
    public function setParams(array $params)
    {
        $this->params = $params;
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param Response $response
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @return array
     */
    public function getAllowedMethods(): array
    {
        return $this->allowedMethods;
    }

    /**
     * @param array $allowedMethods
     */
    public function setAllowedMethods(array $allowedMethods)
    {
        $this->allowedMethods = $allowedMethods;
    }

    /**
     * Resource constructor.
     * @param string $route
     */
    public function __construct(string $route)
    {
        $this->route = $route;
    }

    /**
     * @param string $childClassName
     * @param string $route
     * @return Resource
     */
    public static function createResource(string $childClassName, string $route): Resource
    {
        return new $childClassName($route);
    }

    /**
     * @param $pName string
     * @return mixed|null
     */
    protected function getParam($pName)
    {
        if (isset($this->params[$pName])) {
            return $this->params[$pName];
        }
        return null;
    }
}
