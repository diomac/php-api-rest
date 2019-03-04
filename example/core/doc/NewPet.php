<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado - https://github.com/diomac
 * Date: 04/03/2019
 * Time: 14:47
 */

namespace example\core\doc;

use Diomac\API\SwaggerDefinitionProperty;

class NewPet extends \Diomac\API\SwaggerDefinition
{
    /**
     * @var integer $id
     */
    private $id;
    /**
     * @var string $name
     */
    private $name;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

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
    public function getType(): string
    {
        return 'object';
    }

    /**
     * @return string[]
     */
    public function getRequired(): array
    {
        return ['id'];
    }

    /**
     * @return \Diomac\API\SwaggerDefinitionProperty[]
     */
    public function getProperties(): array
    {
        return [
            new SwaggerDefinitionProperty('id', 'integer', 'int32'),
            new SwaggerDefinitionProperty('nome', 'string'),
        ];
    }
}
