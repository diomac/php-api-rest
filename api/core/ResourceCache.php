<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado (https://github.com/diomac)
 * Date: 13/07/2018
 * Time: 12:54
 */

namespace api\core;

interface ResourceCache
{
    /**
     * @return boolean
     */
    public function isCached();

    /**
     * @return str[]
     */
    public function load();

    /**
     * @param  str[] $resources Resource metadata
     * @return boolean
     */
    public function save($resources);

    /**
     * @return mixed
     */
    public function clear();

    public function __toString();
}