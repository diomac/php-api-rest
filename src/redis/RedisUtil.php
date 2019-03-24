<?php
/**
 * Created by PhpStorm.
 * User: diomac
 * Date: 24/03/19
 * Time: 18:21
 */

namespace Diomac\API\redis;


abstract class RedisUtil
{
    /**
     * @var array
     */
    private static $config;

    public static function init(array $config){
        self::$config = $config;
    }

    public static function con(){

    }
}
