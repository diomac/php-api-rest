<?php
/**
 * Created by PhpStorm.
 * User: dioma
 * Date: 19/10/2018
 * Time: 15:45
 */

namespace Diomac\API;


abstract class Swagger
{
    private static $version = '2.0';
    /**
     * @var SwaggerInfo $info
     */
    protected $info;
    /**
     * @var string $host
     */
    protected $host;
    /**
     * @var string $basePath
     */
    protected $basePath;
    /**
     * @var string[] $schemes
     */
    protected $schemes;
    /**
     * @var string[] $consumes
     */
    protected $consumes;
    /**
     * @var string[] $produces
     */
    protected $produces;
    /**
     * @var SwaggerPath[] $paths
     */
    protected $paths;
    /**
     * @var \JsonSerializable $definitions
     */
    protected $definitions;
    /**
     * Swagger constructor.
     */
    public function __construct()
    {
        $this->info = new SwaggerInfo();
    }

    /**
     * @return SwaggerInfo
     */
    public function getInfo(): SwaggerInfo
    {
        return $this->info;
    }

    /**
     * @param SwaggerInfo $info
     */
    public function setInfo(SwaggerInfo $info): void
    {
        $this->info = $info;
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
     * @return string
     */
    public function getBasePath(): string
    {
        return $this->basePath;
    }

    /**
     * @param string $basePath
     */
    public function setBasePath(string $basePath): void
    {
        $this->basePath = $basePath;
    }

    /**
     * @return string[]
     */
    public function getSchemes(): array
    {
        return $this->schemes;
    }

    /**
     * @param string[] $schemes
     */
    public function setSchemes(array $schemes): void
    {
        $this->schemes = $schemes;
    }

    /**
     * @return string[]
     */
    public function getConsumes(): array
    {
        return $this->consumes;
    }

    /**
     * @param string[] $consumes
     */
    public function setConsumes(array $consumes): void
    {
        $this->consumes = $consumes;
    }

    /**
     * @return string[]
     */
    public function getProduces(): array
    {
        return $this->produces;
    }

    /**
     * @param string[] $produces
     */
    public function setProduces(array $produces): void
    {
        $this->produces = $produces;
    }

    /**
     * @return SwaggerPath[]
     */
    public function getPaths(): array
    {
        return $this->paths;
    }

    /**
     * @param SwaggerPath[] $paths
     */
    public function setPaths(array $paths): void
    {
        $this->paths = $paths;
    }

    /**
     * @return \JsonSerializable
     */
    public function getDefinitions(): \JsonSerializable
    {
        return $this->definitions;
    }

    /**
     * @param \JsonSerializable $definitions
     */
    public function setDefinitions(\JsonSerializable $definitions): void
    {
        $this->definitions = $definitions;
    }

    /**
     * @return string
     */
    public static function getVersion(): string
    {
        return self::$version;
    }

    public abstract function info(): SwaggerInfo;

    public abstract function host(): string;

    public abstract function basePath(): string;

    public abstract function schemes(): array;

    public abstract function definitions(): \JsonSerializable;

    public abstract function securityDefinitions(): array;

    public abstract function defaultResponsesDescription(): array;
}
