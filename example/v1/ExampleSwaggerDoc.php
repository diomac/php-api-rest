<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado - https://github.com/diomac
 * Date: 25/12/2018
 * Time: 15:13
 */

namespace example\v1;

use Diomac\API\swagger\Swagger;
use Diomac\API\swagger\SwaggerInfo;
use example\v1\doc\Definitions;
use example\v1\doc\NewPet;
use example\v1\doc\Pet;

class ExampleSwaggerDoc extends Swagger
{
    public function info(): SwaggerInfo
    {
        $this->setInfo(new SwaggerInfo());
        $this->info->setVersion('1.0.0');
        $this->info->setTitle('Swagger Sample App');
        $this->info->setDescription('This is a sample server Petstore server.');
        $this->info->setTermsOfService('http://swagger.io/terms/');

        $this->info->getContact()->setName('API Support');
        $this->info->getContact()->setEmail('support@swagger.io');
        $this->info->getContact()->setUrl('http://swagger.io');

        $this->info->getLicense()->setName('Apache 2.0');
        $this->info->getLicense()->setUrl('http://www.apache.org/licenses/LICENSE-2.0.html');

        return $this->getInfo();
    }

    public function host(): string
    {
        return 'localhost';
    }

    public function schemes(): array
    {
        return ['http', 'https'];
    }

    /**
     * @return \JsonSerializable
     * @throws \Exception
     */
    public function definitions(): \JsonSerializable
    {
        $d = new Definitions();
        $d->setPet(new Pet());
        $d->setNewPet(new NewPet());
        return $d;
    }

    public function securityDefinitions(): ?\JsonSerializable
    {
        return null;
    }

    /**
     * A declaration of which security schemes are applied for the API as a whole. The list of values describes
     * alternative security schemes that can be used (that is, there is a logical OR between the security requirements).
     * Individual operations can override this definition.
     *
     * https://github.com/OAI/OpenAPI-Specification/blob/master/versions/2.0.md#securityRequirementObject
     *
     * @return \JsonSerializable|null
     */
    public function security(): ?\JsonSerializable
    {
        return null;
    }

    /**
     * An object to hold parameters that can be used across operations.
     * This property does not define global parameters for all operations.
     *
     * https://github.com/OAI/OpenAPI-Specification/blob/master/versions/2.0.md#parametersDefinitionsObject
     *
     * @return \JsonSerializable|null
     */
    public function parametersDefinitions(): ?\JsonSerializable
    {
        return null;
    }

    /**
     * An object to hold responses that can be used across operations.
     * This property does not define global responses for all operations.
     *
     * https://github.com/OAI/OpenAPI-Specification/blob/master/versions/2.0.md#responsesDefinitionsObject
     *
     * @return \JsonSerializable|null
     */
    public function responsesDefinitions(): ?\JsonSerializable
    {
       return null;
    }

    /**
     * Additional external documentation.
     *
     * https://github.com/OAI/OpenAPI-Specification/blob/master/versions/2.0.md#externalDocumentationObject
     *
     * @return \JsonSerializable|null
     */
    public function externalDocs(): ?\JsonSerializable
    {
        return null;
    }
}
