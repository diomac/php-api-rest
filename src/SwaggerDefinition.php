<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado - https://github.com/diomac
 * Date: 04/03/2019
 * Time: 14:51
 */

namespace Diomac\API;


abstract class SwaggerDefinition implements \JsonSerializable
{
    /**
     * @var string $type
     */
    protected $type;
    /**
     * @var string[] $required
     */
    protected $required;
    /**
     * @var SwaggerDefinitionProperty[] $properties
     */
    protected $properties;

    /**
     * @return string
     */
    public abstract function getType(): string;

    /**
     * @return string[]
     */
    public abstract function getRequired(): array;

    /**
     * @return SwaggerDefinitionProperty[]
     */
    public abstract function getProperties(): array;

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return Response::jsonSerialize($this, [
            'type' => 'getType',
            'required' => 'getRequired',
            'properties' => 'getProperties'
        ]);
    }
}
