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
     * @var Request $request
     */
    protected $request;
    /**
     * @var Response $response
     */
    protected $response;
    /**
     * @var Router $router
     */
    protected $router;
    /**
     * @var Resource $resource
     */
    private $resource;
    /**
     * @var AppConfiguration $config
     */
    private static $config;

    /**
     * App constructor.
     * @param $config
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function __construct(AppConfiguration $config)
    {
        /**
         * Test required configuration
         */
        try {
            $config->getBaseUrl();
            $config->getResourceNames();
        } catch (\Error $err) {
            $msg = $err->getMessage();

            if (strpos($msg, 'Diomac\API\AppConfiguration::getBaseUrl()') !== false) {
                throw new \Exception('Diomac\API\AppConfiguration::baseUrl is required.');
            }

            if (strpos($msg, 'Diomac\API\AppConfiguration::getResourceNames()') !== false) {
                throw new \Exception('Resources not configured.');
            }
        }

        /**
         * Init routes and request configuration
         */
        self::$config = $config;
        $this->router = new Router($config);
        $this->request = new Request($config);

        $this->response = new Response($this->router->getRoutes(), $this->router->getTags());
    }

    /**
     * start api-rest
     */
    public function exec()
    {
        try {
            $this->init();
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
     * @throws UnauthorizedException
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @throws \Exception
     */
    private function init()
    {
        $currentRoute = null;
        $routes = $this->router->getRoutes();

        foreach ($routes as $swaggerPath) {
            $patternRoute = $this->configPatternRoute($swaggerPath->getRoute());
            if (preg_match($patternRoute, explode('?', $this->request->getRoute())[0])) {
                $currentRoute = $swaggerPath;
                break;
            }
        }

        if (!$currentRoute) {
            throw new NotFoundException();
        }

        $routePath = $currentRoute->getRoute();

        $this->request = new Request(self::$config, $routePath);
        $method = $this->request->getMethod();

        if (!in_array($method, $currentRoute->getAllowedMethods())) {
            $this->resource = new Resource($currentRoute->getRoute());
            $this->resource->setAllowedMethods($currentRoute->getAllowedMethods());
            throw new MethodNotAllowedException();
        }


        $swaggerMethod = $currentRoute->getMethodByName($method);
        $class = $swaggerMethod->getRouteConfig()->getResourceClass();

        $this->resource = Resource::createResource($class, $currentRoute->getRoute());
        $this->resource->setParams($this->request->getParams());
        $this->resource->setRequest($this->request);
        $this->resource->setResponse($this->response);
        $function = $swaggerMethod->getRouteConfig()->getFunction();

        if ($swaggerMethod->getRouteConfig()->getGuards()) {
            $authorized = $this->execGuards($swaggerMethod->getRouteConfig()->getGuards());
            if ($authorized) {
                $this->response = $function->invoke($this->resource);
            }
        } else {
            $this->response = $function->invoke($this->resource);
        }
    }

    /**
     * @param $guards
     * @return bool
     * @throws UnauthorizedException
     * @throws ForbiddenException
     * @throws \Exception
     */
    private function execGuards($guards): bool
    {
        foreach ($guards as $g) {
            if (!$g->className) {
                throw new \Exception('Guard bad configured. ClassName is required.');
            }
            $guard = Request::createGuard($g->className);
            try {
                $guard->guard($g->guardParameters);
            } catch (UnauthorizedException $ex) {
                throw $ex;
            } catch (ForbiddenException $ex) {
                throw $ex;
            } catch (\Exception $ex) {
                throw $ex;
            }
        }
        return true;
    }

    /**
     * @param $route
     * @return string
     */
    private function configPatternRoute($route): string
    {
        return '|^' . preg_replace('/({[^\/]+})/', '[^\/]+', $route) . '$|';
    }

    /**
     * @param \Exception $ex
     */
    private function exceptionMessage(\Exception $ex): void
    {
        $contentType = self::$config->getContentTypeExceptions();

        $this->response->setCode($ex->getCode());

        if ($contentType === 'application/json') {
            $json = json_decode($ex->getMessage());
            $this->response->setBodyJSON($json);
        } else {
            $this->response->setContentType($contentType);
            $this->response->setBody($ex->getMessage());
        }

        if ($ex instanceof MethodNotAllowedException) {
            $this->response->setContentType('text/html');
            if (!$this->resource) {
                $this->resource = Resource::createResource(Resource::class, '');
            }
            $allow = implode(", ", array_keys($this->resource->getAllowedMethods()));
            $this->response->setHeader('AllowedMethods', $allow);
            $this->response->setBody($ex->getMessage());
        }
    }
}
