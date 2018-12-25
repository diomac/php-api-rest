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
    private $tags;
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
    public function setRoutes(array $routes): void
    {
        $this->routes = $routes;
    }

    /**
     * @return mixed
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     */
    public function setTags(array $tags): void
    {
        $this->tags = $tags;
    }

    /**
     * Router constructor.
     * @param $config AppConfiguration
     * @throws \ReflectionException
     */
    public function __construct(AppConfiguration $config)
    {
        $successCache = false;

        if ($config->isUseCache()) {
            $this->cache = new ResourceCacheAPC($config->getNameCache());
            $successCache = $this->routes = $this->cache->load();
        }

        if (!$successCache) {
            $namespace = implode('\\', $config->getNamespaceResources());
            $this->routes = [];
            $this->tags = [];
            foreach ($config->getResources() as $resource) {
                $class = $namespace . '\\' . $resource;
                $rc = new Annotation($class);
                $tag = $this->configTag($rc->getDocComment());
                if ($tag) {
                    $this->tags[] = $tag;
                }
                $methods = $rc->getMethods();
                $this->configRoutes($methods, $class, $tag);
            }
            if ($config->isUseCache()) {
                $this->cache->save($this->routes);
            }
        }
    }

    private function configTag($doc)
    {
        if (!$doc) {
            return null;
        }
        $annotation = new Annotation();
        $name = $annotation->simpleAnnotationToString($doc, 'resourceName');
        $description = $annotation->simpleAnnotationToString($doc, 'resourceDescription');
        $externalDocs = $annotation->complexAnnotationToJSON($doc, 'externalDocs');

        if (!$name || !$description) {
            return null;
        }

        $tag = [
            'name' => $name,
            'description' => $description
        ];

        if ($externalDocs) {
            $tag['externalDocs'] = $externalDocs;
        }

        return $tag;
    }

    private function configRoutes($methods, $class, $tag)
    {
        $annotation = new Annotation();
        foreach ($methods as $m) {
            $s = $m->getDocComment();
            $reqMethod = $annotation->simpleAnnotationToString($s, 'method');
            $route = $annotation->simpleAnnotationToString($s, 'route');
            $guards = $annotation->complexAnnotationToArrayJSON($s, 'guard');

            if (!$reqMethod || !$route) {
                return;
            }

            $method = strtoupper($reqMethod);

            $r = [
                'guards' => $guards,
                'class' => trim($class),
                'function' => trim($m->getName()),
                'annotation' => $s,
                'tag' => $tag['name'],
                'code' => $annotation->getCodeFunctionString($m)
            ];

            $this->routes[$route][$method] = $r;

        }
    }
}