<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado (https://github.com/diomac)
 * Date: 13/07/2018
 * Time: 12:58
 */

namespace Diomac\API;

/**
 * Class ResourceCacheAPC
 * @package Diomac\API
 */
class ResourceCacheAPC implements ResourceCache
{
    private $cacheName = 'diomac-simple-api-rest';

    public function __construct($cacheName = null)
    {
        if ($cacheName) {
            $this->cacheName = $cacheName;
        }
    }

    /**
     * @return bool|string[]
     */
    public function isCached()
    {
        return \apc_exists($this->cacheName);
    }

    /**
     * @return str[]|mixed
     */
    public function load()
    {
        return \apc_fetch($this->cacheName);
    }

    /**
     * @param str[] $resources Resource
     * @return array|bool
     */
    public function save($resources)
    {
        return \apc_store($this->cacheName, $resources);
    }

    public function clear()
    {
        \apc_delete($this->cacheName);
    }

    public function __toString()
    {
        $info = \apc_cache_info('user');
        return 'Metadata for ' . count($this->load()) . ' resources stored in APC at ' . date('r', $info['cache_list'][0]['creation_time']);
    }
}