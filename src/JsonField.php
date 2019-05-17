<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel R. S. M.
 * GitHub: https://github.com/diomac
 * Date: 17/05/19
 * Time: 09:43
 */

namespace Diomac\API;


class JsonField
{
    /**
     * @var string $name
     */
    private $name;
    /**
     * @var mixed $value
     */
    private $value;

    /**
     * JsonField constructor.
     * @param string $name
     * @param mixed $value
     */
    public function __construct(string $name, $value)
    {
        $this->name = $name;
        $this->value = $value;
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
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }
}
