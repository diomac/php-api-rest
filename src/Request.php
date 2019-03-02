<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado (https://github.com/diomac)
 * Date: 08/07/2018
 * Time: 10:08
 */

namespace Diomac\API;

/**
 * Class Request
 * @package Diomac\API
 */
class Request
{
    /**
     * @var $route string
     */
    private $route;
    /**
     * @var $method string
     */
    private $method;
    /**
     * @var $data object
     */
    private $data;
    /**
     * @var $params array
     */
    private $params;

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return $this->route;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return object
     */
    public function getData(): object
    {
        return $this->data;
    }

    /**
     * @param $route string
     * @return array
     * @throws \Exception
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * Request constructor.
     * @param $config AppConfiguration
     * @param $routeData string
     * @throws \Exception
     */
    public function __construct(AppConfiguration $config, string $routeData = null)
    {
        $base = implode('/', $config->getNamespaceResources());
        $this->getEnvironmentRoute($base);
        $this->getEnvironmentMethod();
        $this->getEnvironmentData();
        if ($routeData) {
            $this->getUriParams($routeData);
        }
    }

    private function getUriParams($routeData)
    {
        $params = $_GET;
        $partsRouteData = explode('/', $routeData);
        $partsRoute = explode('/', $this->route);

        foreach ($partsRouteData as $key => $p) {
            if (preg_match('/({[^\/]+})/', $p)) {
                $pName = preg_replace('/({|})/', '', $p);
                if (isset($params[$pName])) {
                    throw new \Exception('Variáveis duplicadas na chamada.');
                }
                $params[$pName] = preg_replace('/\?(.*)/', '', $partsRoute[$key]);
            }
        }

        $this->params = $params;
    }

    private function getEnvironmentRoute($base)
    {
        list(, $this->route) = explode($base, $_SERVER['REQUEST_URI']);
    }

    private function getEnvironmentMethod()
    {
        $method = strtoupper($this->getHeader('requestMethod'));
        if (!$method) {
            $method = 'GET';
        }
        $this->method = $method;
    }

    private function getEnvironmentData()
    {
        $dataMethods = [
            'POST' => true,
            'PATCH' => true,
            'PUT' => true
        ];
        $data = file_get_contents('php://input');
        if ($data && isset($dataMethods[$this->method])) {
            $this->data = json_decode($data);
            if (!is_object($this->data)) {
                $this->data = new \stdClass();
            }
        } else {
            $this->data = new \stdClass();
        }
    }

    private function getHeader($name)
    {
        $name = strtoupper(preg_replace('/([A-Z])/', '_$1', $name));
        if (isset($_SERVER['HTTP_' . $name])) {
            return $_SERVER['HTTP_' . $name];
        } elseif (isset($_SERVER[$name])) {
            return $_SERVER[$name];
        } else {
            return null;
        }
    }

}
