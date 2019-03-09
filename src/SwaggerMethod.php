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
     * @var string[] $produces
     */
    private $produces;
    /**
     * @var string[] $consumes
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
    public function getOperationId(): ?string
    {
        return $this->operationId;
    }

    /**
     * @param string $operationId
     */
    public function setOperationId(string $operationId = null): void
    {
        $this->operationId = $operationId;
    }

    /**
     * @return SwaggerParameter[]
     */
    public function getParameters(): ?array
    {
        return $this->parameters;
    }

    /**
     * @param SwaggerParameter[] $parameters
     */
    public function setParameters(array $parameters = null): void
    {
        $this->parameters = $parameters;
    }

    /**
     * @return SwaggerResponse[]
     */
    public function getResponses(): ?array
    {
        return $this->responses;
    }

    /**
     * @param SwaggerResponse[] $responses
     */
    public function setResponses(array $responses = null): void
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
     * @return string[]
     */
    public function getProduces(): ?array
    {
        return $this->produces;
    }

    /**
     * @param string[] $produces
     */
    public function setProduces(array $produces = null): void
    {
        $this->produces = $produces;
    }

    /**
     * @return string[]
     */
    public function getConsumes(): ?array
    {
        return $this->consumes;
    }

    /**
     * @param string[] $consumes
     */
    public function setConsumes(array $consumes = null): void
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

    /**
     * @param string $PHPDoc
     * @param Annotation $annotation
     * @return string|null
     */
    public function readPHPDocSummary(string $PHPDoc, Annotation $annotation): ?string
    {
        return $annotation->simpleAnnotationToString($PHPDoc, 'summary');
    }

    /**
     * @param string $PHPDoc
     * @param Annotation $annotation
     * @return string|null
     */
    public function readPHPDocDescription(string $PHPDoc, Annotation $annotation): ?string
    {
        return $annotation->simpleAnnotationToString($PHPDoc, 'description');
    }

    /**
     * @param string $PHPDoc
     * @param Annotation $annotation
     * @return string|null
     */
    public function readPHPDocOperationId(string $PHPDoc, Annotation $annotation): ?string
    {
        return $annotation->simpleAnnotationToString($PHPDoc, 'operationId');
    }

    /**
     * @param string $PHPDoc
     * @param Annotation $annotation
     * @return array
     * @throws \Exception
     */
    public function readPHPDocParameters(string $PHPDoc, Annotation $annotation): array
    {
        $parameters = [];
        foreach ($annotation->complexAnnotationToArrayJSON($PHPDoc, 'parameter') as $p) {
            $sp = new SwaggerParameter();
            $sp->setName($p->name);
            $sp->setIn($p->in);
            $sp->setDescription($p->description);
            $sp->setRequired($p->required);
            $sp->setType($p->type);
            $sp->setFormat($p->format);
            $sp->setCollectionFormat($p->collectionFormat);
            $sp->setItems($p->items);
            $sp->setSchema($p->schema);

            $parameters[] = $sp;
        }
        return $parameters;
    }

    /**
     * @param string $PHPDoc
     * @param Annotation $annotation
     * @return array
     * @throws \Exception
     */
    public function readPHPDocResponses(string $PHPDoc, Annotation $annotation): array
    {
        $responses = [];
        foreach ($annotation->complexAnnotationToArrayJSON($PHPDoc, 'response') as $r) {
            $sr = new SwaggerResponse();
            $sr->setCode($r->code);
            $sr->setDescription($r->description);
            $sr->setSchema($r->schema);

            $responses[] = $sr;
        }
        return $responses;
    }

    /**
     * @param string $PHPDoc
     * @param Annotation $annotation
     * @return array|null
     */
    public function readPHPDocConsumes(string $PHPDoc, Annotation $annotation): ?array
    {
        return $annotation->simpleAnnotationToArray($PHPDoc, 'consumeType');
    }

    /**
     * @param string $PHPDoc
     * @param Annotation $annotation
     * @return array|null
     */
    public function readPHPDocProduces(string $PHPDoc, Annotation $annotation): ?array
    {
        return $annotation->simpleAnnotationToArray($PHPDoc, 'contentType');
    }
}
