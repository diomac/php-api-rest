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
    const DEFAULT_NAME_CACHE = 'DiomacApiCache';
    const DEFAULT_CONTENT_TYPE_EXCEPTIONS = 'text/html';

    /**
     * @var string[] $resourceNames - Names of your API's resource classes
     */
    private $resourceNames;

    /**
     * @var string $baseUrl - Base url of your API
     */
    private $baseUrl;

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
     * AppConfiguration constructor.
     */
    public function __construct()
    {
        $this->nameCache = self::DEFAULT_NAME_CACHE;
        $this->contentTypeExceptions = self::DEFAULT_NAME_CACHE;
    }

    /**
     * @return string[]
     */
    public function getResourceNames(): array
    {
        return $this->resourceNames;
    }

    /**
     * @param string $resourceName - Name of class resource
     */
    public function addResource(string $resourceName): void
    {
        $this->resourceNames[] = $resourceName;
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * @param string $baseUrl - Base url of your API
     */
    public function setBaseUrl(string $baseUrl): void
    {
        $this->baseUrl = $baseUrl;
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
