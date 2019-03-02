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

class ExampleSwaggerDoc implements Swagger
{
    public function info(): array
    {
        return [
            'title' => 'Swagger Sample App',
            'description' => 'This is a sample server Petstore server.',
            'termsOfService' => 'http://swagger.io/terms/',
            'contact' => [
                'name' => 'API Support',
                'url' => 'http://www.swagger.io/support',
                'email' => 'support@swagger.io',
            ],
            'license' => [
                'name' => 'Apache 2.0',
                'url' => 'http://www.apache.org/licenses/LICENSE-2.0.html'
            ],
            'version' => '1.0.1',
        ];
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

    public function definitions(): array
    {
        return [
            'value1' => [
                'type' => 'integer'
            ],
            'value2' => [
                'type' => 'integer'
            ]
        ];
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