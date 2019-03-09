<?php
/**
 * Created by PhpStorm.
 * User: dioma
 * Date: 19/10/2018
 * Time: 15:45
 */

namespace Diomac\API;


abstract class Swagger implements \JsonSerializable
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
     * @var \JsonSerializable $securityDefinitions
     */
    protected $securityDefinitions;

    /**
     * Swagger constructor.
     */
    public function __construct()
    {
        $this->info = $this->info();
        $this->host = $this->host();
        $this->basePath = $this->basePath();
        $this->schemes = $this->schemes();
//        $this->consumes = $this->configConsumes();
//        $this->produces
//        $this->tags
//        $this->paths
        $this->definitions = $this->definitions();
        $this->securityDefinitions = $this->securityDefinitions();
    }

    /**
     * @return string
     */
    public static function getVersion(): string
    {
        return self::$version;
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

    public function setConsumes(): void
    {
        $this->consumes = $this->configConsumes();
    }

    /**
     * @return string[]
     */
    public function getProduces(): array
    {
        return $this->produces;
    }

    public function setProduces(): void
    {
        $this->produces = $this->configProduces();
    }

    /**
     * @return SwaggerPath[]
     */
    public function getPaths(): array
    {
        return $this->paths;
    }

    public function getJsonSerializablePaths(): ?array
    {
        $jsonPaths = [];

        foreach ($this->paths as $path) {
            foreach ($path->getMethods() as $method) {
                $jsonPaths[$path->getRoute()][$method->getName()] = $method;
            }
        }

        return $jsonPaths;

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
     * @return \JsonSerializable
     */
    public function getSecurityDefinitions(): ?\JsonSerializable
    {
        return $this->securityDefinitions;
    }

    /**
     * @param \JsonSerializable $securityDefinitions
     */
    public function setSecurityDefinitions(\JsonSerializable $securityDefinitions): void
    {
        $this->securityDefinitions = $securityDefinitions;
    }

    public abstract function info(): SwaggerInfo;

    public abstract function host(): string;

    public abstract function basePath(): string;

    public abstract function schemes(): array;

    public abstract function definitions(): \JsonSerializable;

    public abstract function securityDefinitions(): ?array;

    public abstract function defaultResponsesDescription(): array;

    /**
     * @return string[]
     */
    private function configConsumes(): array
    {
        $consumes = [];
        foreach ($this->getPaths() as $path) {
            foreach ($path->getMethods() as $method) {
                $consumes = array_merge($consumes, $method->getConsumes() ?? []);
            }
        }
        return array_unique($consumes);
    }

    /**
     * @return string[]
     */
    private function configProduces(): array
    {
        $produces = [];
        foreach ($this->getPaths() as $path) {
            foreach ($path->getMethods() as $method) {
                $produces = array_merge($produces, $method->getProduces() ?? []);
            }
        }
        return array_unique($produces);
    }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        $p = [
            'swagger' => 'getVersion',
            'info' => 'getInfo',
            'host' => 'getHost',
            'basePath' => 'getBasePath',
            'schemes' => 'getSchemes',
            'consumes' => 'getConsumes',
            'produces' => 'getProduces',
            'tags' => 'getTags',
            'paths' => 'getJsonSerializablePaths',
            'definitions' => 'getDefinitions',
            'securityDefinitions' => 'getSecurityDefinitions'
        ];
        return Response::jsonSerialize($this, $p);
    }
}
