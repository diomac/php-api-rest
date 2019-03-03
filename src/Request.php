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
        $baseUrl = $config->getBaseUrl();
        $this->getEnvironmentRoute($baseUrl);

        /**
         * Test required configuration
         */
        try {
            $this->getRoute();
        } catch (\Error $err) {
            $msg = $err->getMessage();

            if (strpos($msg, 'Diomac\API\Request::getRoute()') !== false) {
                throw new \Exception(
                    'Diomac\API\AppConfiguration::baseUrl is bad configured. 
                    Verify that the variable matches the resource folder.'
                );
            }
        }

        $this->getEnvironmentMethod();
        $this->getEnvironmentData();
        if ($routeData) {
            $this->getUriParams($routeData);
        }
    }

    /**
     * @param $routeData
     * @throws \Exception
     */
    private function getUriParams($routeData): void
    {
        $params = $_GET;
        $partsRouteData = explode('/', $routeData);
        $partsRoute = explode('/', $this->route);

        foreach ($partsRouteData as $key => $p) {
            if (preg_match('/({[^\/]+})/', $p)) {
                $pName = preg_replace('/({|})/', '', $p);
                if (isset($params[$pName])) {
                    throw new \Exception('Duplicate variables in the call.');
                }
                $params[$pName] = preg_replace('/\?(.*)/', '', $partsRoute[$key]);
            }
        }

        $this->params = $params;
    }

    /**
     * @param string $baseUrl
     */
    private function getEnvironmentRoute(string $baseUrl): void
    {
        list(, $this->route) = explode($baseUrl, $_SERVER['REQUEST_URI']);
    }

    private function getEnvironmentMethod(): void
    {
        $method = strtoupper($this->getHeader('requestMethod'));
        if (!$method) {
            $method = 'GET';
        }
        $this->method = $method;
    }

    private function getEnvironmentData(): void
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

    /**
     * @param string $name
     * @return string|null
     */
    private function getHeader(string $name): ?string
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
