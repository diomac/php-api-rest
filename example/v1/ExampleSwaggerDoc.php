<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado - https://github.com/diomac
 * Date: 25/12/2018
 * Time: 15:13
 */

namespace example\v1;

use Diomac\API\Swagger;
use Diomac\API\Response;
use Diomac\API\SwaggerInfo;
use example\core\doc\Definitions;
use example\core\doc\NewPet;
use example\core\doc\Pet;

class ExampleSwaggerDoc extends Swagger
{
    public function info(): SwaggerInfo
    {
        $this->info->setVersion('1.0.0');
        $this->info->setTitle('Swagger Sample App');
        $this->info->setDescription('This is a sample server Petstore server.');
        $this->info->setTermsOfService('http://swagger.io/terms/');

        $this->info->getContact()->setName('API Support');
        $this->info->getContact()->setEmail('support@swagger.io');
        $this->info->getContact()->setUrl('"http://swagger.io');

        $this->info->getLicense()->setName('Apache 2.0');
        $this->info->getLicense()->setUrl('http://www.apache.org/licenses/LICENSE-2.0.html');

        return $this->getInfo();
    }

    public function host(): string
    {
        return 'localhost';
    }

    public function basePath(): string
    {
        return '/vendor/example/v1';
    }

    public function schemes(): array
    {
        return ['http', 'https'];
    }

    public function definitions(): \JsonSerializable
    {
        $d = new Definitions();
        $d->setPet(new Pet());
        $d->setNewPet(new NewPet());
        return $d;
    }

    public function securityDefinitions(): array
    {
        return [
            'php_api_rest_auth' => [
                'type' => 'basic',
            ]
        ];
    }


    public function defaultResponsesDescription(): array
    {
        return [
            Response::OK => 'Success request.'
        ];
    }
}
