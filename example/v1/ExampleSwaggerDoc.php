<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado - https://github.com/diomac
 * Date: 25/12/2018
 * Time: 15:13
 */

namespace example\v1;

use Diomac\API\Swagger;

class ExampleSwaggerDoc implements Swagger
{
    public function info(): array
    {
        return [
            'description' => 'API SADWEB',
            'version' => '1.0.0',
            'title' => 'SAD - Sistema de Apoio à Decisão',
        ];
    }

    public function host(): string
    {
        return 'http://apps2hom.correiosnet.int/sadweb';
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
            Response::OK => 'Esta requisição foi bem sucessida.'
        ];
    }
}