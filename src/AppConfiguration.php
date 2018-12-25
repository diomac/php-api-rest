<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado - https://github.com/diomac
 * Date: 25/12/2018
 * Time: 10:56
 */

namespace Diomac\API;


class AppConfiguration
{
    /**
     * @var string[] $namespaceResources - Namespace of where the resource classes of your API
     */
    private $namespaceResources;

    /**
     * @var string[] $resources - Names of your API's resource classes
     */
    private $resources;

    /**
     * @var string[] $namespaceGuards - Namespace of where the guard classes of your API
     */
    private $namespaceGuards;

    /**
     * @var string $contentTypeExceptions - MIME default for exceptions of your API - Default: text/html
     */
    private $contentTypeExceptions;

    /**
     * @var boolean $useCache
     */
    private $useCache;

    /**
     * @var string $nameCache
     */
    private $nameCache;

    /**
     * @return string[]
     */
    public function getNamespaceResources(): array
    {
        if (!$this->namespaceResources) {
            return [];
        }
        return $this->namespaceResources;
    }

    /**
     * @param string[] $namespaceResources
     */
    public function setNamespaceResources(array $namespaceResources): void
    {
        $this->namespaceResources = $namespaceResources;
    }

    /**
     * @return string[]
     */
    public function getResources(): array
    {
        return $this->resources;
    }

    /**
     * @param string[] $resources
     */
    public function setResources(array $resources): void
    {
        $this->resources = $resources;
    }

    /**
     * @return string[]
     */
    public function getNamespaceGuards(): array
    {
        if (!$this->namespaceGuards) {
            return [];
        }
        return $this->namespaceGuards;
    }

    /**
     * @param string[] $namespaceGuards
     */
    public function setNamespaceGuards(array $namespaceGuards): void
    {
        $this->namespaceGuards = $namespaceGuards;
    }

    /**
     * @return string
     */
    public function getContentTypeExceptions(): string
    {
        if (!$this->contentTypeExceptions) {
            return 'text/html';
        }
        return $this->contentTypeExceptions;
    }

    /**
     * @param string $contentTypeExceptions
     */
    public function setContentTypeExceptions(string $contentTypeExceptions): void
    {
        $this->contentTypeExceptions = $contentTypeExceptions;
    }

    /**
     * @return bool
     */
    public function isUseCache(): bool
    {
        return $this->useCache;
    }

    /**
     * Set true if your API development is finished for more performance (require APC - Auternative PHP Cache) - Default: false
     * @param bool $useCache
     */
    public function setUseCache(bool $useCache): void
    {
        $this->useCache = $useCache;
    }

    /**
     * @return string
     */
    public function getNameCache(): string
    {
        return $this->nameCache;
    }

    /**
     * @param string $nameCache
     */
    public function setNameCache(string $nameCache): void
    {
        $this->nameCache = $nameCache;
    }
}