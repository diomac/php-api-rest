<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado (https://github.com/diomac)
 * Date: 08/07/2018
 * Time: 13:28
 */

namespace Diomac\API;

/**
 * Class Router
 * @package Diomac\API
 */
class Router
{
    private $routes;
    private $cache;

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
        $successCache = false;
        $nameCache = isset($config['nameCache']) ? $config['nameCache'] : null;
        $this->cache = new ResourceCacheAPC($nameCache);
        $useCache = isset($config['useCache']) ? $config['useCache'] : false;
        if($useCache){
            $successCache = $this->routes = $this->cache->load();
        }

        if(!$successCache){
            $namespace = implode('\\', $config['namespace']);
            $this->routes = [];
            foreach ($config['resources'] as $resource) {
                $class = $namespace . '\\' . $resource;
                $rc = new \ReflectionClass($class);
                $methods = $rc->getMethods();
                $this->configRoutes($methods, $class);
            }
            if($useCache){
                $this->cache->save($this->routes);
            }
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
            preg_match_all('/@guard (.*)/', $s, $guard);
            if ($reqMethod && $route) {
                $this->routes[trim($route[1])][trim(strtoupper($reqMethod[1]))] = [
                    'guards' => $guard ? $this->configGuards($guard[1]) : null,
                    'class' => trim($class),
                    'function' => trim($m->getName())
                ];
            }
        }
    }

    private function configGuards($guards){
        $configuredGuards = [];
        foreach ($guards as $g){
            $guard = [
                'function' => $g,
                'params' => []
            ];
            $params = null;
            $pregFunction = null;
            $pregParams = null;
            preg_match('/((.|\n)*?)(\ )/', $g, $pregFunction);
            if(!$pregFunction){
                $configuredGuards[] = $guard;
                continue;
            }
            $guard['function'] = $pregFunction[1];
            preg_match('/({[^\/]+})/', $g, $pregParams);

            if($pregParams){
                $guard['params'] = json_decode($pregParams[1]);
            }
            $configuredGuards[] = $guard;
        }
        return $configuredGuards;
    }
}