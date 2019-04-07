<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado - https://github.com/diomac
 * Date: 04/03/2019
 * Time: 14:04
 */

namespace Diomac\API\swagger;


use Diomac\API\Response;
use Exception;
use JsonSerializable;

class SwaggerParameter implements JsonSerializable
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
     * @var boolean $allowEmptyValue
     */
    private $allowEmptyValue;
    /**
     * @var string $collectionFormat
     */
    private $collectionFormat;
    /**
     * @var object[] $items
     */
    private $items;
    /**
     * @var object $schema
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
     * @return bool
     */
    public function isAllowEmptyValue(): bool
    {
        return $this->allowEmptyValue;
    }

    /**
     * @param bool $allowEmptyValue
     */
    public function setAllowEmptyValue(bool $allowEmptyValue): void
    {
        $this->allowEmptyValue = $allowEmptyValue;
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
     * @return object[]
     */
    public function getItems(): ?array
    {
        return $this->items;
    }

    /**
     * @param object[] $items
     */
    public function setItems(array $items = null): void
    {
        $this->items = $items;
    }

    /**
     * @return object
     */
    public function getSchema(): ?object
    {
        return $this->schema;
    }

    /**
     * @param object $schema
     */
    public function setSchema(object $schema = null): void
    {
        $this->schema = $schema;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     * @throws Exception
     */
    public function jsonSerialize(): array
    {
        return Response::jsonSerialize($this, [
            'name' => 'getName',
            'in' => 'getIn',
            'description' => 'getDescription',
            'required' => 'isRequired',
            'type' => 'getType',
            'format' => 'getFormat',
            'allowEmptyValue' => 'getAllowEmptyValue',
            'collectionFormat' => 'getCollectionFormat',
            'items' => 'getItems',
            'schema' => 'getSchema'
        ]);
    }
}
