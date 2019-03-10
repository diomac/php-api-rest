<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado (https://github.com/diomac)
 * Date: 08/07/2018
 * Time: 10:08
 */

namespace Diomac\API;

use Diomac\API\swagger\Swagger;

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
     * @return array
     * @throws \Exception
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * Request constructor.
     * @param AppConfiguration $config
     * @param string $currentRoute
     * @throws \Exception
     */
    public function __construct(AppConfiguration $config, string $currentRoute = null)
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
        if ($currentRoute) {
            $this->getUriParams($currentRoute);
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

    /**
     * @param string $implementer
     * @return Guard
     */
    public static function createGuard(string $implementer): Guard
    {
        return new $implementer();
    }

    /**
     * Check request data using swagger 2.0 definitions
     *
     * @param \stdClass $definition
     * @param Swagger $swagger
     * @param \stdClass|null $data
     * @throws BadRequestException
     * @throws \Exception
     */
    private function checkData(\stdClass $definition, Swagger $swagger, \stdClass $data = null): void
    {
        if (!$data) {
            $data = $this->data;
        }

        if (!$definition->required) {
            $definition->required = [];
        }

        foreach ($definition->required as $p) {
            if (!isset($data->{$p})) {
                throw new BadRequestException('Required property "' . $p . '" not found.');
            } else {
                $this->checkDataType($data->{$p}, $p, $definition, $swagger);
            }
        }
    }

    /**
     * Check request data type using swagger 2.0 definitions
     *
     * @param $value
     * @param string $propertyName
     * @param \stdClass $definition
     * @param Swagger $swagger
     * @throws BadRequestException
     * @throws \Exception
     */
    private function checkDataType($value, string $propertyName, \stdClass $definition, Swagger $swagger): void
    {
        if (!$definition->properies) {
            throw new \Exception('Definition not contain field "properties"');
        }

        $strPath = $definition->properies->{$propertyName}->{'$ref'};

        if ($strPath) {
            $path = explode('/', str_replace('#/definition/', '', $strPath));

            $d = $swagger->definitions();

            foreach ($path as $p) {
                $d = $d[$p];
            }

            $refDefinition = json_decode(json_encode($d));

            $this->checkData($refDefinition, $swagger, $value);
        } else {
            $dType = $definition->properies->{$propertyName}->type;
            $pType = gettype($value);

            if ($pType !== $dType) {
                throw new BadRequestException(
                    'Property "' .
                    $propertyName .
                    '" type error. Must be ' .
                    $dType .
                    ', ' .
                    $pType .
                    ' given.'
                );
            }
        }
    }
}
