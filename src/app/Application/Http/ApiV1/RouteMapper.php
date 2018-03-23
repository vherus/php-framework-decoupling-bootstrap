<?php

namespace Vherus\Application\Http\ApiV1;

use FastRoute\RouteCollector;
use Vherus\Framework\Http\Router\RouteMapper as IRouteMapper;

class RouteMapper implements IRouteMapper
{
    public function map(RouteCollector $router): void
    {
        $router->addRoute('GET', '/api/v1/hello', Controller\HelloController::class);
    }
}
