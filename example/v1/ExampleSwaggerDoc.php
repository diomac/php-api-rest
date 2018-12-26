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
            'description' => 'Diomac PHP API Rest',
            'version' => '1.0.0',
            'title' => 'Diomac PHP API Rest',
        ];
    }

    public function host(): string
    {
        return 'example_php_api_rest.com';
    }

    public function basePath(): string
    {
        return '/example/v1';
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
                'type' => 'Bearer',
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