<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado - https://github.com/diomac
 * Date: 04/03/2019
 * Time: 14:01
 */

namespace Diomac\API;


class SwaggerPath
{
    /**
     * @var string $route
     */
    private $route;
    /**
     * @var string $httpMethod
     */
    private $httpMethod;
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
     * @return string
     */
    public function getRoute(): string
    {
        return $this->route;
    }

    /**
     * @param string $route
     */
    public function setRoute(string $route): void
    {
        $this->route = $route;
    }

    /**
     * @return string
     */
    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    /**
     * @param string $httpMethod
     */
    public function setHttpMethod(string $httpMethod): void
    {
        $this->httpMethod = $httpMethod;
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
}
