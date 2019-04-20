<?php
/**
 * Created by PhpStorm.
 * User: diomac
 * Date: 24/03/19
 * Time: 18:21
 */

namespace Diomac\API\redis;


use Exception;
use Predis\Client;

abstract class RedisUtil
{
    /**
     * @var RedisConfig
     */
    private static $config;
    /**
     * @var Client
     */
    private static $predis;

    public static function init(RedisConfig $config)
    {
        self::$config = $config;
    }

    /**
     * @return Client
     * @throws Exception
     */
    public static function con(): Client
    {
        if (self::$predis) {
            return self::$predis;
        }

        if (!self::$config) {
            throw new Exception('Data source not configured.');
        }

        $parameters = [
            'scheme' => self::$config->getScheme(),
            'host' => self::$config->getHost(),
            'port' => self::$config->getPort()
        ];

        $predis = new Client($parameters, ['prefix' => self::$config->getDsn() . ':']);

        if (self::$config->getAuth()) {
            $predis->auth(self::$config->getAuth());
        }
        self::$predis = $predis;
        return $predis;
    }
}
