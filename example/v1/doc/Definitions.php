<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado - https://github.com/diomac
 * Date: 04/03/2019
 * Time: 14:45
 */

namespace example\v1\doc;

use Diomac\API\Response;
use Exception;
use JsonSerializable;

class Definitions implements JsonSerializable
{
    /**
     * @var Pet $pet
     */
    private $pet;
    /**
     * @var NewPet $newPet
     */
    private $newPet;

    /**
     * @return Pet
     */
    public function getPet(): Pet
    {
        return $this->pet;
    }

    /**
     * @param Pet $pet
     */
    public function setPet(Pet $pet): void
    {
        $this->pet = $pet;
    }

    /**
     * @return NewPet
     */
    public function getNewPet(): NewPet
    {
        return $this->newPet;
    }

    /**
     * @param NewPet $newPet
     */
    public function setNewPet(NewPet $newPet): void
    {
        $this->newPet = $newPet;
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
        Response::jsonField('pet', $this->getPet());
        Response::jsonField('newPet', $this->getNewPet());

        return Response::jsonSerialize($this);
    }
}
