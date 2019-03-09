<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado - https://github.com/diomac
 * Date: 04/03/2019
 * Time: 14:04
 */

namespace Diomac\API;


class SwaggerParameter
{
    /**
     * @var string $name
     */
    private $name;
    /**
     * @var string $in
     */
    private $in;
    /**
     * @var string $description
     */
    private $description;
    /**
     * @var boolean $required
     */
    private $required;
    /**
     * @var string $type
     */
    private $type;
    /**
     * @var string $format
     */
    private $format;
    /**
     * @var string $collectionFormat
     */
    private $collectionFormat;
    /**
     * @var Object[] $items
     */
    private $items;
    /**
     * @var Object $schema
     */
    private $schema;

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
    public function getIn(): string
    {
        return $this->in;
    }

    /**
     * @param string $in
     */
    public function setIn(string $in): void
    {
        $this->in = $in;
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
     * @return bool
     */
    public function isRequired(): ?bool
    {
        return $this->required;
    }

    /**
     * @param bool $required
     */
    public function setRequired(bool $required = null): void
    {
        $this->required = $required;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getFormat(): ?string
    {
        return $this->format;
    }

    /**
     * @param string $format
     */
    public function setFormat(string $format = null): void
    {
        $this->format = $format;
    }

    /**
     * @return string
     */
    public function getCollectionFormat(): ?string
    {
        return $this->collectionFormat;
    }

    /**
     * @param string $collectionFormat
     */
    public function setCollectionFormat(string $collectionFormat = null): void
    {
        $this->collectionFormat = $collectionFormat;
    }

    /**
     * @return Object[]
     */
    public function getItems(): ?array
    {
        return $this->items;
    }

    /**
     * @param Object[] $items
     */
    public function setItems(array $items = null): void
    {
        $this->items = $items;
    }

    /**
     * @return Object
     */
    public function getSchema(): ?Object
    {
        return $this->schema;
    }

    /**
     * @param Object $schema
     */
    public function setSchema(Object $schema = null): void
    {
        $this->schema = $schema;
    }
}
