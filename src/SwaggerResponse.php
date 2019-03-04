<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado - https://github.com/diomac
 * Date: 04/03/2019
 * Time: 14:17
 */

namespace Diomac\API;


class SwaggerResponse
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
    public function getSchema(): Object
    {
        return $this->schema;
    }

    /**
     * @param Object $schema
     */
    public function setSchema(Object $schema): void
    {
        $this->schema = $schema;
    }
}
