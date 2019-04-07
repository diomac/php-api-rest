<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado - https://github.com/diomac
 * Date: 04/03/2019
 * Time: 14:54
 */

namespace Diomac\API\swagger;


use Diomac\API\Response;
use Exception;
use JsonSerializable;

class SwaggerDefinitionProperty implements JsonSerializable
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
     * @param string $docComment
     */
    public function __construct(string $docComment)
    {
        preg_match('/@var ([A-Za-z]+)/', $docComment, $match);

        if($match){
            $this->type = $match[1];
        }

        $match = null;

        preg_match('/@swaggerFormat ([A-Za-z0-9]+)/', $docComment, $match);

        if($match){
            $this->format = $match[1];
        }
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
     * @throws Exception
     */
    public function jsonSerialize()
    {
        $p = [
            'type' => 'getType'
        ];

        if($this->format){
            $p['format'] = 'getFormat';
        }

        return Response::jsonSerialize($this, $p);
    }
}
