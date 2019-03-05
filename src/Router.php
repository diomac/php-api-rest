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
    /**
     * @var SwaggerPath[]
     */
    private $routes;
    private $tags;
    private $cache;

    /**
     * @return SwaggerPath[]
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * @param SwaggerPath[] $routes
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
            $this->routes = [];
            $this->tags = [];
            foreach ($config->getResourceNames() as $class) {
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

    /**
     * @param $doc
     * @return array|null
     * @throws \ReflectionException
     * @throws \Exception
     */
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

    /**
     * @param \ReflectionMethod[] $methods
     * @param string $class
     * @param array|null $tag
     * @throws \ReflectionException
     * @throws \Exception
     */
    private function configRoutes(array $methods, string $class, array $tag = null)
    {
        $annotation = new Annotation();
        $infoRoutes = [];

        foreach ($methods as $m) {
            $s = $m->getDocComment();
            $reqMethod = $annotation->simpleAnnotationToString($s, 'method');
            $route = $annotation->simpleAnnotationToString($s, 'route');
            $guards = $annotation->complexAnnotationToArrayJSON($s, 'guard');

            if (!$reqMethod || !$route) {
                continue;
            }

            $r = [
                'guards' => $guards,
                'class' => trim($class),
                'function' => $m,
                'annotation' => $s,
                'tag' => $tag['name'],
                'code' => $annotation->getCodeFunctionString($m)
            ];

            $infoRoutes[$route][strtoupper($reqMethod)] = $r;
        }

        foreach ($infoRoutes as $strPath => $path) {

            $swaggerPath = new SwaggerPath();
            $swaggerPath->setRoute($strPath);
            $listMethods = [];
            $allowedHttpMethods = [];

            foreach ($path as $strMethod => $method) {
                $allowedHttpMethods[] = $strMethod;

                $sm = new SwaggerMethod();

                $sm->setName($strMethod);
                $sm->setOperationId('');
                $sm->setParameters([]);
                $sm->setResponses([]);
                $sm->setConsumes('');
                $sm->setProduces('');
                $sm->setSummary('');
                $sm->setDescription('');
                $sm->setTags([]);

                $routeConfig = new RouteConfig();
                $routeConfig->setFunction($method['function']);
                $routeConfig->setResourceClass($method['class']);

                $listGuards = [];

                foreach ($method['guards'] as $g) {
                    $rcg = new RouteConfigGuard();
                    $rcg->setGuardClass($g->className);
                    $rcg->setGuardParams($g->guardParameters);
                    $listGuards[] = $rcg;
                }

                $routeConfig->setGuards($listGuards);
                $sm->setRouteConfig($routeConfig);

                $listMethods[] = $sm;
            }

            $swaggerPath->setMethods($listMethods);
            $swaggerPath->setAllowedMethods($allowedHttpMethods);

            $this->routes[] = $swaggerPath;
        }
    }
}
