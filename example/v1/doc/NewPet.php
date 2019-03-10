<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado - https://github.com/diomac
 * Date: 04/03/2019
 * Time: 14:47
 */

namespace example\v1\doc;

/**
 * Class NewPet
 * @package example\v1\doc
 * @swaggerType object
 */
class NewPet extends \Diomac\API\swagger\SwaggerDefinition
{
    /**
     * @swaggerRequired
     * @var string $name
     */
    public $name;
    /**
     * @var string
     */
    public $tag;
}
