<?php
/**
 * Created by PhpStorm.
 * User: dioma
 * Date: 19/10/2018
 * Time: 15:45
 */

namespace Diomac\API\swagger;


use Diomac\API\Response;

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
     * @var \JsonSerializable $parameters
     */
    protected $parameters;
    /**
     * @var \JsonSerializable $responses
     */
    protected $responses;
    /**
     * @var \JsonSerializable $securityDefinitions
     */
    protected $securityDefinitions;
    /**
     * @var object $security
     */
    protected $security;
    /**
     * @var object[] $tags
     *
     */
    protected $tags;
    /**
     * @var object $externalDocs
     * @externalDocs(
     *     description="A short description of the target documentation. GFM syntax can be used for rich text representation.",
     *     url="Required. The URL for the target documentation. Value MUST be in the format of a URL."
     * )
     */
    protected $externalDocs;

    /**
     * Swagger constructor.
     */
    public function __construct()
    {
        $this->info = $this->info();
        $this->host = $this->host();
        $this->schemes = $this->schemes();
        $this->definitions = $this->definitions();
        $this->securityDefinitions = $this->securityDefinitions();
        $this->security = $this->security();
        $this->externalDocs = $this->externalDocs();
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

    /**
     * @return array|null
     */
    public function getJsonSerializablePaths(): ?array
    {
        $jsonPaths = [];

        foreach ($this->paths as $path) {
            foreach ($path->getMethods() as $method) {
                $jsonPaths[$path->getRoute()][strtolower($method->getName())] = $method;
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
    public function getParameters(): ?\JsonSerializable
    {
        return $this->parameters;
    }

    /**
     * @param \JsonSerializable $parameters
     */
    public function setParameters(\JsonSerializable $parameters): void
    {
        $this->parameters = $parameters;
    }

    /**
     * @return \JsonSerializable
     */
    public function getResponses(): ?\JsonSerializable
    {
        return $this->responses;
    }

    /**
     * @param \JsonSerializable $responses
     */
    public function setResponses(\JsonSerializable $responses): void
    {
        $this->responses = $responses;
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

    /**
     * @return \JsonSerializable
     */
    public function getSecurity(): ?\JsonSerializable
    {
        return $this->security;
    }

    /**
     * @param \JsonSerializable $security
     */
    public function setSecurity(\JsonSerializable $security): void
    {
        $this->security = $security;
    }

    /**
     * @return object[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @param object[] $tags
     */
    public function setTags(array $tags): void
    {
        $this->tags = $tags;
    }

    /**
     * @return \JsonSerializable
     */
    public function getExternalDocs(): ?\JsonSerializable
    {
        return $this->externalDocs;
    }

    /**
     * @param \JsonSerializable $externalDocs
     */
    public function setExternalDocs(\JsonSerializable $externalDocs): void
    {
        $this->externalDocs = $externalDocs;
    }

    /**
     * Required. Provides metadata about the API. The metadata can be used by the clients if needed.
     *
     * https://github.com/OAI/OpenAPI-Specification/blob/master/versions/2.0.md#infoObject
     *
     * @return SwaggerInfo
     */
    public abstract function info(): SwaggerInfo;

    /**
     * The host (name or ip) serving the API. This MUST be the host only and does not include the scheme nor sub-paths.
     * It MAY include a port. If the host is not included, the host serving the documentation is to be used
     * (including the port). The host does not support path templating.
     *
     * https://github.com/OAI/OpenAPI-Specification/blob/master/versions/2.0.md#schema
     *
     * @return string
     */
    public abstract function host(): string;

    /**
     * The transfer protocol of the API. Values MUST be from the list: "http", "https", "ws", "wss". If the schemes
     * is not included, the default scheme to be used is the one used to access the Swagger definition itself.
     *
     * https://github.com/OAI/OpenAPI-Specification/blob/master/versions/2.0.md#schema
     *
     * @return string[]
     */
    public abstract function schemes(): array;

    /**
     * An object to hold data types produced and consumed by operations.
     *
     * https://github.com/OAI/OpenAPI-Specification/blob/master/versions/2.0.md#definitionsObject
     *
     * @return \JsonSerializable|null
     */
    public abstract function definitions(): ?\JsonSerializable;

    /**
     * An object to hold parameters that can be used across operations.
     * This property does not define global parameters for all operations.
     *
     * https://github.com/OAI/OpenAPI-Specification/blob/master/versions/2.0.md#parametersDefinitionsObject
     *
     * @return \JsonSerializable|null
     */
    public abstract function parametersDefinitions():?\JsonSerializable;

    /**
     * An object to hold responses that can be used across operations.
     * This property does not define global responses for all operations.
     *
     * https://github.com/OAI/OpenAPI-Specification/blob/master/versions/2.0.md#responsesDefinitionsObject
     *
     * @return \JsonSerializable|null
     */
    public abstract function responsesDefinitions():?\JsonSerializable;

    /**
     * Security scheme definitions that can be used across the specification.
     *
     * https://github.com/OAI/OpenAPI-Specification/blob/master/versions/2.0.md#securityDefinitionsObject
     *
     * @return \JsonSerializable|null
     */
    public abstract function securityDefinitions(): ?\JsonSerializable;

    /**
     * A declaration of which security schemes are applied for the API as a whole. The list of values describes
     * alternative security schemes that can be used (that is, there is a logical OR between the security requirements).
     * Individual operations can override this definition.
     *
     * https://github.com/OAI/OpenAPI-Specification/blob/master/versions/2.0.md#securityRequirementObject
     *
     * @return \JsonSerializable|null
     */
    public abstract function security(): ?\JsonSerializable;

    /**
     * Additional external documentation.
     *
     * https://github.com/OAI/OpenAPI-Specification/blob/master/versions/2.0.md#externalDocumentationObject
     *
     * @return \JsonSerializable|null
     */
    public abstract function externalDocs():?\JsonSerializable;

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
            'parameters' => 'getParameters',
            'responses' => 'getResponses',
            'securityDefinitions' => 'getSecurityDefinitions'
        ];
        return Response::jsonSerialize($this, $p);
    }
}
