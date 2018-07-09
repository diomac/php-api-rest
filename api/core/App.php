<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado (https://github.com/diomac)
 * Date: 08/07/2018
 * Time: 10:09
 */

namespace api\core;

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
     * App constructor.
     * @param $config
     * @throws \ReflectionException
     */
    public function __construct($config)
    {
        $this->router = new Router($config);
        $this->request = new Request($config);
        $this->response = new Response();
    }

    public function exec()
    {
        try {
            $this->ini();
        } catch (NotFoundException $e) {
            $this->response->setCode($e->getCode());
            $this->response->setBody($e->getMessage());
        } catch (UnauthorizedException $e) {
            $this->response->setCode($e->getCode());
            $this->response->setBody($e->getMessage());
        } catch (ForbbidenException $e) {
            $this->response->setCode($e->getCode());
            $this->response->setBody($e->getMessage());
        } catch (MethodNotAllowedException $e) {
            $this->response->setCode($e->getCode());
            $this->response->setBody($e->getMessage());
            $allow = implode(", ", array_keys($this->resource->getAllowedMethods()));
            $this->response->setHeader('AllowedMethods', $allow);
        } catch (\Exception $e) {
            $this->response->setCode($e->getCode());
            $this->response->setBody($e->getMessage());
        }

        $this->response->output();
    }

    private function ini()
    {
        $currentRouteData = null;
        $currentRoute = null;
        $routes = $this->router->getRoutes();

        foreach ($routes as $route => $data) {
            $patternRoute = $this->configPatternRoute($route);
            if (preg_match($patternRoute, $this->request->getRoute())) {
                $currentRouteData = $data;
                $currentRoute = $route;
                break;
            }
        }

        if (!$currentRoute) {
            throw new NotFoundException();
        }

        if (!array_key_exists($this->request->getMethod(),  $currentRouteData)) {
            $this->resource = new Resource($currentRoute);
            $this->resource->setAllowedMethods($currentRouteData);
            throw new MethodNotAllowedException();
        }

        $method = $this->request->getMethod();
        $class = $currentRouteData[$method]['class'];
        $this->resource = new $class($currentRoute);
        $this->resource->setParams($this->request->getParams($currentRoute));
        $this->resource->setRequest($this->request);
        $this->resource->setResponse($this->response);
        $function = $currentRouteData[$method]['function'];

        if ($currentRouteData[$method]['guard']) {
            $guard = $currentRouteData[$method]['guard'];
            if ($this->resource->$guard()) {
                $this->response = $this->resource->$function();
            }
        } else {
            $this->response = $this->resource->$function();
        }
    }

    private function configPatternRoute($route)
    {
        return '|^' . preg_replace('/({[^\/]+})/', '[^\/]+', $route) . '$|';
    }

}