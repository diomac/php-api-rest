<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado (https://github.com/diomac)
 * Date: 08/07/2018
 * Time: 20:02
 */

namespace api\core;


class Resource
{
    /**
     * @var $params array
     */
    private $params;
    /**
     * @var $request Request
     */
    protected $request;
    /**
     * @var $response Response
     */
    protected $response;
    /**
     * @var $route string
     */
    protected $route;
    /**
     * @var $allowedMethods array
     */
    private $allowedMethods;
    /**
     * @var $guardParams \stdClass
     */
    private $guardParams;

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
     * @param \stdClass $guardParams
     */
    public function __construct(string $route, $guardParams = null)
    {
        $this->route = $route;
        if ($guardParams) {
            $this->guardParams = $guardParams;
        }
    }

    /**
     * @param $pName string
     * @return mixed
     */
    protected function getParam($pName)
    {
        if (isset($this->params[$pName])) {
            return $this->params[$pName];
        }
    }

    protected function getGuardParam($name)
    {
        if(!isset($this->guardParams->{$name})){
            return false;
        }
        return $this->guardParams->{$name};
    }
}