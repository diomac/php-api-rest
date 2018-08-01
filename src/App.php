<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado (https://github.com/diomac)
 * Date: 08/07/2018
 * Time: 10:09
 */

namespace Diomac\API;

/**
 * Class App
 * @package Diomac\API
 */
class App
{
    /**
     * @var $request Request
     */
    protected $request;
    /**
     * @var $response Response
     */
    protected $response;
    /**
     * @var $router Router
     */
    protected $router;
    /**
     * @var $resource Resource
     */
    private $resource;
    /**
     * @var $config array
     */
    private static $config;

    /**
     * App constructor.
     * @param $config
     * @throws \ReflectionException
     */
    public function __construct($config)
    {
        self::$config = $config;
        $this->router = new Router($config);
        $this->request = new Request($config);
        $this->response = new Response();
    }

    /**
     * start api-rest
     */
    public function exec()
    {
        try {
            $this->ini();
        } catch (NotFoundException $e) {
            $this->exceptionMessage($e);
        } catch (UnauthorizedException $e) {
            $this->exceptionMessage($e);
        } catch (ForbiddenException $e) {
            $this->exceptionMessage($e);
        } catch (MethodNotAllowedException $e) {
            $this->exceptionMessage($e);
        } catch (\Exception $e) {
            $this->exceptionMessage($e);
        }

        $this->response->output();
    }

    /**
     * init api-rest
     * @throws ForbiddenException
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     */
    private function ini()
    {
        $currentRouteData = null;
        $currentRoute = null;
        $routes = $this->router->getRoutes();

        foreach ($routes as $route => $data) {
            $patternRoute = $this->configPatternRoute($route);
            if (preg_match($patternRoute, explode('?', $this->request->getRoute())[0])) {
                $currentRouteData = $data;
                $currentRoute = $route;
                break;
            }
        }

        if (!$currentRoute) {
            throw new NotFoundException();
        }

        $this->request = new Request(self::$config, $currentRoute);

        if (!array_key_exists($this->request->getMethod(), $currentRouteData)) {
            $this->resource = new Resource($currentRoute);
            $this->resource->setAllowedMethods($currentRouteData);
            throw new MethodNotAllowedException();
        }

        $method = $this->request->getMethod();
        $class = $currentRouteData[$method]['class'];

        $this->resource = new $class($currentRoute);
        $this->resource->setParams($this->request->getParams());
        $this->resource->setRequest($this->request);
        $this->resource->setResponse($this->response);
        $function = $currentRouteData[$method]['function'];

        if ($currentRouteData[$method]['guards']) {
            $authorized = $this->execGuards($currentRouteData[$method]['guards']);
            if ($authorized) {
                $this->response = $this->resource->$function();
            } else {
                throw new ForbiddenException();
            }
        } else {
            $this->response = $this->resource->$function();
        }
    }

    /**
     * Execute route guards
     * @param $guards
     * @return bool
     */
    private function execGuards($guards)
    {
        $nameSpaceGuards = isset(self::$config['namespaceGuards'])
            ? implode('\\', self::$config['namespaceGuards']) : '';
        foreach ($guards as $g) {
            $guardClass = $nameSpaceGuards . '\\' . $g['class'];
            $guardParams = $g['params'];
            $guard = new $guardClass();
            if (!$guard->guard($guardParams)) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param $route
     * @return string
     */
    private function configPatternRoute($route)
    {
        return '|^' . preg_replace('/({[^\/]+})/', '[^\/]+', $route) . '$|';
    }

    /**
     * @param $ex
     */
    private function exceptionMessage($ex)
    {
        $contentType = isset(self::$config['contentTypeExceptions'])
            ? self::$config['typeExceptionMessages'] : 'text/html';

        $this->response->setCode($ex->getCode());

        if ($contentType === 'application/json') {
            $json = json_decode($ex->getMessage());
            $this->response->setBodyJSON($json);
        } else {
            $this->response->setContentType($contentType);
            $this->response->setBody($ex->getMessage());
        }

        if ($ex instanceof MethodNotAllowedException) {
            $allow = implode(", ", array_keys($this->resource->getAllowedMethods()));
            $this->response->setHeader('AllowedMethods', $allow);
        }
    }
}