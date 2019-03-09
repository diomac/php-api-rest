<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado - https://github.com/diomac
 * Date: 04/03/2019
 * Time: 14:17
 */

namespace Diomac\API;


class SwaggerResponse implements \JsonSerializable
{
    /**
     * @var integer $code
     */
    private $code;
    /**
     * @var string $description
     */
    private $description;
    /**
     * @var Object $schema
     */
    private $schema;

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @param int $code
     */
    public function setCode(int $code): void
    {
        $this->code = $code;
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

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize(): array
    {
        return Response::jsonSerialize($this, [
            'code' => 'getCode',
            'description' => 'getDescription',
            'schema' => 'getSchema'
        ]);
    }
}
