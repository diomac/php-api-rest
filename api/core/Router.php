<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado (https://github.com/diomac)
 * Date: 08/07/2018
 * Time: 13:28
 */

namespace api\core;


class Router
{
    private $routes;

    /**
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * @param array $routes
     */
    public function setRoutes(array $routes)
    {
        $this->routes = $routes;
    }

    /**
     * Router constructor.
     * @param $config
     * @throws \ReflectionException
     */
    public function __construct($config)
    {
        $namespace = implode('\\', $config['namespace']);
        $this->routes = [];

        foreach ($config['resources'] as $resource) {
            $class = $namespace . '\\' . $resource;
            $rc = new \ReflectionClass($class);
            $methods = $rc->getMethods();
            $this->configRoutes($methods, $class);
        }
    }

    private function configRoutes($methods, $class)
    {

        foreach ($methods as $m) {
            $s = $m->getDocComment();
            $reqMethod = null;
            $route = null;
            $guard = null;
            preg_match('/@method (.*)/', $s, $reqMethod);
            preg_match('/@route (.*)/', $s, $route);
            preg_match('/@guard (.*)/', $s, $guard);
            if ($reqMethod && $route) {
                $this->routes[trim($route[1])][trim(strtoupper($reqMethod[1]))] = [
                     'guard' => $guard ? trim($guard[1]) : null,
                    'class' => trim($class),
                    'function' => trim($m->getName())
                ];
            }
        }
    }
}