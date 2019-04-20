<?php


namespace Diomac\API\redis;


class RedisConfig
{
    /**
     * @var string $dsn
     */
    private $dsn;
    /**
     * @var string $scheme
     */
    private $scheme;
    /**
     * @var string $host
     */
    private $host;
    /**
     * @var int $port
     */
    private $port;
    /**
     * @var string $auth
     */
    private $auth;

    /**
     * @return string
     */
    public function getDsn(): string
    {
        return $this->dsn;
    }

    /**
     * @param string $dsn
     */
    public function setDsn(string $dsn): void
    {
        $this->dsn = $dsn;
    }

    /**
     * @return string
     */
    public function getScheme(): string
    {
        return $this->scheme;
    }

    /**
     * @param string $scheme
     */
    public function setScheme(string $scheme): void
    {
        $this->scheme = $scheme;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param string $host
     */
    public function setHost(string $host): void
    {
        $this->host = $host;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @param int $port
     */
    public function setPort(int $port): void
    {
        $this->port = $port;
    }

    /**
     * @return string
     */
    public function getAuth(): ?string
    {
        return $this->auth;
    }

    /**
     * @param string $auth
     */
    public function setAuth(string $auth): void
    {
        $this->auth = $auth;
    }
}
