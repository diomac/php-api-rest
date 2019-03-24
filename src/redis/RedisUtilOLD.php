<?php

namespace Diomac\API\redis;

use Predis\Client;

class RedisUtilOLD
{
    /**
     * @var array
     */
    private static $confEnvironment;

    /**
     * @var Client[]
     */
    private static $predis;

    /**
     * @throws \Exception
     */
    public static function ini()
    {
        $conf = [
            'D' => [
                'diomac' => [
                    'parameters' => ['scheme' => 'tcp', 'host' => 'redis-server', 'port' => 6379],
                    'auth' => '',
                ],
            ]
        ];

        if (!isset($conf[ENVIRONMENT])) {
            throw new \Exception('Redis: configurações do ambiente inexistentes.');
        }
        self::$confEnvironment = $conf[ENVIRONMENT];
    }

    /**
     * @param $dsn string
     * @return Client
     * @throws \Exception configurações do ambiente inexistentes
     */
    public static function con($dsn = null): Client
    {
        if (isset(self::$predis[$dsn])) {
            return self::$predis[$dsn];
        }
        if (!$dsn) {
            $dsn = array_keys(self::$confEnvironment)[0];
        }
        if (!self::$confEnvironment[$dsn]) {
            throw new \Exception('Data source de redis não configurado.');
        }
        $conf = self::$confEnvironment[$dsn];
        $predis = new Client($conf['parameters'], ['prefix' => 'Diomac\\API:']);
        if ($conf['auth']) {
            $predis->auth($conf['auth']);
        }
        self::$predis[$dsn] = $predis;
        return $predis;
    }

    /**
     * @param $predis Client
     * @param $pattern
     */
    public static function delKeys($predis, $pattern)
    {
        $keys = $predis->keys($pattern);
        foreach ($keys as $key) {
            $k = str_replace('Diomac\\API:', '', $key);
            $predis->del($k);
        }
    }
}
