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
            'version' => '3.0.0',
            'title' => 'Diomac PHP API Rest',
        ];
    }

    public function host(): string
    {
        return 'https://github.com/diomac/php-api-rest';
    }

    public function basePath(): string
    {
        return '/v1';
    }

    public function schemes(): array
    {
        return ['http'];
    }

    public function definitions(): array
    {
        return [];
    }

    public function defaultResponsesDescription(): array
    {
        return [
            Response::OK => 'Success request.'
        ];
    }
}