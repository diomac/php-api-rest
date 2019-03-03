<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado (https://github.com/diomac)
 * Date: 13/07/2018
 * Time: 12:54
 */

namespace Diomac\API;

/**
 * Interface ResourceCache
 * @package Diomac\API
 */
interface ResourceCache
{
    /**
     * @return boolean
     */
    public function isCached();

    /**
     * @return string[]
     */
    public function load();

    /**
     * @param  string[] $resources Resource metadata
     * @return boolean
     */
    public function save($resources);

    /**
     * @return mixed
     */
    public function clear();

    public function __toString();
}
