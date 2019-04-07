<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado (https://github.com/diomac)
 * Date: 13/07/2018
 * Time: 12:58
 */

namespace Diomac\API;

use function apc_cache_info;
use function apc_delete;
use function apc_exists;
use function apc_fetch;
use function apc_store;

/**
 * Class ResourceCacheAPC
 * @package Diomac\API
 */
class ResourceCacheAPC implements ResourceCache
{
    const DEFAULT_CACHE_NAME = 'diomac-api-rest';

    /**
     * @var string $cacheName
     */
    private $cacheName;

    public function __construct($cacheName = null)
    {
        if ($cacheName) {
            $this->cacheName = $cacheName;
        } else {
            $this->cacheName = self::DEFAULT_CACHE_NAME;
        }
    }

    /**
     * @return bool|string[]
     */
    public function isCached()
    {
        return apc_exists($this->cacheName);
    }

    /**
     * @return string[]|mixed
     */
    public function load()
    {
        return apc_fetch($this->cacheName);
    }

    /**
     * @param string[] $resources Resource
     * @return array|bool
     */
    public function save($resources)
    {
        return apc_store($this->cacheName, $resources);
    }

    public function clear()
    {
        apc_delete($this->cacheName);
    }

    public function __toString()
    {
        $info = apc_cache_info('user');
        return 'Metadata for ' . count($this->load()) . ' resources stored in APC at ' . date('r', $info['cache_list'][0]['creation_time']);
    }
}
