<?php

namespace Vherus\Testing\Traits;

use Vherus\Application\Http\HttpServer;
use Psr\Container\ContainerInterface as IContainer;
use Psr\Http\Message\ResponseInterface as IResponse;
use Psr\Http\Message\ServerRequestInterface as IRequest;

trait UsesHttpServer
{
    private $authorizedTestUserToken = 'd321854a-581d-4b5b-b299-15b2288bbee4';
    private $authorizedTestUserId = '3495c1ce-b2a9-4be4-938b-9bf56522bc3b';
    private $unauthorizedTestUserToken = 'dfbb1300-a0f1-4e76-86f1-cfa6bb3f5843';

    protected function handle(IContainer $container, IRequest $request): IResponse
    {
        return $container->get(HttpServer::class)->handle($request);
    }
}
