<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado - https://github.com/diomac
 * Date: 04/03/2019
 * Time: 14:54
 */

namespace Diomac\API;


class SwaggerDefinitionProperty implements \JsonSerializable
{
    /**
     * @var string $name
     */
    private $name;
    /**
     * @var string $type
     */
    private $type;
    /**
     * @var string $format
     */
    private $format;

    /**
     * SwaggerDefinitionProperty constructor.
     * @param string $name
     * @param string $type
     * @param string $format
     */
    public function __construct(string $name, string $type, string $format = null)
    {
        $this->name = $name;
        $this->type = $type;
        $this->format = $format;
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
     * @return string|null
     */
    public function getFormat(): ?string
    {
        return $this->format;
    }

    /**
     * @param string $format
     */
    public function setFormat(string $format): void
    {
        $this->format = $format;
    }


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
            'name' => 'getName',
            'type' => 'getType',
            'format' => 'getFormat'
        ]);
    }
}
