<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado (https://github.com/diomac)
 * Date: 08/07/2018
 * Time: 13:28
 */

namespace Diomac\API;

use Diomac\API\redis\RedisUtil;
use Diomac\API\swagger\SwaggerMethod;
use Diomac\API\swagger\SwaggerPath;
use Error;
use Exception;
use ReflectionException;
use ReflectionMethod;
use stdClass;

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
    /**
     * @var string[] $tags
     */
    private $tags;
    /**
     * @var ResourceCacheAPC $cache
     */
    private $cache;
    /**
     * @var AppConfiguration $appConfig
     */
    private $appConfig;

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
     * @throws ReflectionException
     * @throws Exception
     */
    public function __construct(AppConfiguration $config)
    {
        $this->appConfig = $config;

        $successCache = false;

        /**
         * Use cache
         */
        if ($config->isUseCache()) {
            if ($config->getRedisConf()) {
                RedisUtil::init($config->getRedisConf());
                $this->cache = RedisUtil::con();

                if ($this->cache->exists('DiomacAPI:routes')) {
                    $this->routes = unserialize($this->cache->get('DiomacAPI:routes'));
                    $successCache = true;
                }

                if ($this->cache->exists('DiomacAPI:tags')) {
                    $this->tags = unserialize($this->cache->get('DiomacAPI:tags'));
                } else {
                    $this->tags = [];
                }
            } else {
                $this->cache = new ResourceCacheAPC($config->getNameCache());
                try {
                    $successCache = $cacheAPC = $this->cache->load();
                    $this->routes = $cacheAPC['routes'];
                    $this->tags = $cacheAPC['tags'];
                } catch (Error $err) {
                    $msg = $err->getMessage();

                    if (strpos($msg, 'Call to undefined function apc_fetch()') !== false) {
                        throw new Exception(
                            'APC - Alternative PHP Cache is not configured.',
                            Response::INTERNAL_SERVER_ERROR
                        );
                    }
                }

            }
        }

        /**
         * No use cache or first call using cache
         */
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
                if ($config->getRedisConf()) {
                    $this->cache->set('DiomacAPI:routes', serialize($this->routes));
                    $this->cache->set('DiomacAPI:tags', serialize($this->tags));
                } else {
                    $cacheAPC = [
                        'routes' => $this->routes,
                        'tags' => $this->tags
                    ];
                    $this->cache->save($cacheAPC);
                }

            }
        }
    }

    /**
     * @param string|null $doc
     * @return stdClass|null
     * @throws ReflectionException
     * @throws Exception
     */
    private function configTag(string $doc = null): ?stdClass
    {
        if (!$doc) {
            return null;
        }
        if ($this->appConfig->getSwaggerResourceName()) {
            $annotation = new Annotation();
            return $annotation->complexAnnotationToJSON($doc, 'tag');
        }

        return null;
    }

    /**
     * @param ReflectionMethod[] $methods
     * @param string $class
     * @param stdClass|null $tag
     * @throws ReflectionException
     * @throws Exception
     */
    private function configRoutes(array $methods, string $class, stdClass $tag = null): void
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
                'tag' => $tag->name
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
                $listMethods[] = $this->buildConfigRoute($strMethod, $method, $annotation);
            }

            $swaggerPath->setMethods($listMethods);
            $swaggerPath->setAllowedMethods($allowedHttpMethods);

            $this->routes[] = $swaggerPath;
        }
    }

    /**
     * @param string $httpMethod
     * @param array $configMethod
     * @param Annotation $methodAnnotation
     * @return SwaggerMethod
     * @throws Exception
     */
    private function buildConfigRoute(
        string $httpMethod,
        array $configMethod,
        Annotation $methodAnnotation
    ): SwaggerMethod {

        $sm = new SwaggerMethod();
        if ($this->appConfig->getSwaggerResourceName()) {
            try {
                $sm->setName($httpMethod);
                $sm->setSummary($sm->readPHPDocSummary($configMethod['annotation'], $methodAnnotation));
                $sm->setDescription($sm->readPHPDocDescription($configMethod['annotation'], $methodAnnotation));
            } catch (Error $err) {
                if (strpos($err->getMessage(), 'Diomac\API\swagger\SwaggerMethod::set') !== false) {
                    throw new Exception(
                        'Swagger 2.0 require @method, @summary and @description in all the paths.',
                        Response::INTERNAL_SERVER_ERROR
                    );
                }
            }

            $sm->setOperationId($sm->readPHPDocOperationId($configMethod['annotation'], $methodAnnotation));
            $sm->setParameters($sm->readPHPDocParameters($configMethod['annotation'], $methodAnnotation));
            $sm->setResponses($sm->readPHPDocResponses($configMethod['annotation'], $methodAnnotation));
            $sm->setConsumes($sm->readPHPDocConsumes($configMethod['annotation'], $methodAnnotation));
            $sm->setProduces($sm->readPHPDocProduces($configMethod['annotation'], $methodAnnotation));
            $sm->setTags($sm->readPHPDocTags($configMethod['annotation'], $methodAnnotation));

            if ($configMethod['tag']) {
                $tags = $sm->getTags() ?? [];
                $tags[] = $configMethod['tag'];
                $sm->setTags($tags);
            }
        } else {
            $sm->setName($httpMethod);
        }

        $routeConfig = new RouteConfig();
        $routeConfig->setFunction($configMethod['function']);
        $routeConfig->setResourceClass($configMethod['class']);

        $listGuards = [];

        foreach ($configMethod['guards'] as $g) {
            $rcg = new RouteConfigGuard();
            $rcg->setGuardClass($g->className);
            $rcg->setGuardParams($g->guardParameters);
            $listGuards[] = $rcg;
        }

        $routeConfig->setGuards($listGuards);
        $sm->setRouteConfig($routeConfig);

        return $sm;
    }
}
