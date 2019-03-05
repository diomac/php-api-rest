<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado - https://github.com/diomac
 * Date: 05/03/2019
 * Time: 14:53
 */

namespace Diomac\API;


class SwaggerMethod
{
    /**
     * @var string $name
     */
    private $name;
    /**
     * @var string $operationId
     */
    private $operationId;
    /**
     * @var SwaggerParameter[] $parameters
     */
    private $parameters;
    /**
     * @var SwaggerResponse[] $responses
     */
    private $responses;
    /**
     * @var string[] $tags
     */
    private $tags;
    /**
     * @var string $summary
     */
    private $summary;
    /**
     * @var string $description
     */
    private $description;
    /**
     * @var string $produces
     */
    private $produces;
    /**
     * @var string $consumes
     */
    private $consumes;
    /**
     * @var RouteConfig $routeConfig
     */
    private $routeConfig;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getOperationId(): string
    {
        return $this->operationId;
    }

    /**
     * @param string $operationId
     */
    public function setOperationId(string $operationId): void
    {
        $this->operationId = $operationId;
    }

    /**
     * @return SwaggerParameter[]
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @param SwaggerParameter[] $parameters
     */
    public function setParameters(array $parameters): void
    {
        $this->parameters = $parameters;
    }

    /**
     * @return SwaggerResponse[]
     */
    public function getResponses(): array
    {
        return $this->responses;
    }

    /**
     * @param SwaggerResponse[] $responses
     */
    public function setResponses(array $responses): void
    {
        $this->responses = $responses;
    }

    /**
     * @return string[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @param string[] $tags
     */
    public function setTags(array $tags): void
    {
        $this->tags = $tags;
    }

    /**
     * @return string
     */
    public function getSummary(): string
    {
        return $this->summary;
    }

    /**
     * @param string $summary
     */
    public function setSummary(string $summary): void
    {
        $this->summary = $summary;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getProduces(): string
    {
        return $this->produces;
    }

    /**
     * @param string $produces
     */
    public function setProduces(string $produces): void
    {
        $this->produces = $produces;
    }

    /**
     * @return string
     */
    public function getConsumes(): string
    {
        return $this->consumes;
    }

    /**
     * @param string $consumes
     */
    public function setConsumes(string $consumes): void
    {
        $this->consumes = $consumes;
    }

    /**
     * @return RouteConfig
     */
    public function getRouteConfig(): RouteConfig
    {
        return $this->routeConfig;
    }

    /**
     * @param RouteConfig $routeConfig
     */
    public function setRouteConfig(RouteConfig $routeConfig): void
    {
        $this->routeConfig = $routeConfig;
    }
}
