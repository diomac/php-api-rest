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
     * @var Annotation $annotation
     */
    private $annotation;
    /**
     * @var SwaggerDefinitionProperty[]
     */
    private $properties = [];

    /**
     * @return string
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function getType(): string
    {
        if (!$this->annotation) {
            $this->annotation = new Annotation(get_called_class());
        }

        preg_match('/@swaggerType ([A-Za-z]+)/', $this->annotation->getDocComment(), $match);

        if ($match) {
            return $match[1];
        }

        throw new \Exception('@swaggerType bad configured in "' . $this->annotation->getName() . '"');
    }

    /**
     * @return string[]
     * @throws \ReflectionException
     */
    public function getRequired(): ?array
    {
        if (!$this->annotation) {
            $this->annotation = new Annotation(get_called_class());
        }

        $properties = $this->annotation->getProperties();

        $r = [];

        foreach ($properties as $p) {
            $this->properties[$p->getName()] = new SwaggerDefinitionProperty($p->getDocComment());
            $match = null;
            preg_match('/@swaggerRequired/', $p->getDocComment(), $match);
            if ($match) {
                $r[] = $p->getName();
            }
        }

        return $r;
    }

    /**
     * @return SwaggerDefinitionProperty[]
     */
    public function getProperties(): array
    {
        return $this->properties;
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
            'type' => 'getType',
            'required' => 'getRequired',
            'properties' => 'getProperties'
        ]);
    }
}
