<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado - https://github.com/diomac
 * Date: 04/03/2019
 * Time: 14:47
 */

namespace example\v1\doc;

use Diomac\API\SwaggerDefinition;

/**
 * Class Pet
 * @package example\v1\doc
 * @swaggerType object
 * @swaggerAllOf newPet
 */
class Pet extends SwaggerDefinition
{
    /**
     * @swaggerRequired
     * @swaggerFormat int32
     * @var integer $id
     */
    public $id;
}
