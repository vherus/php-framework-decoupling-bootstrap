<?php

namespace Vherus\Application\Http\Healthcheck;

use FastRoute\RouteCollector;
use Vherus\Framework\Http\Router\RouteMapper as IRouteMapper;

class RouteMapper implements IRouteMapper
{
    public function map(RouteCollector $router): void
    {
        $router->addRoute('GET', '/healthcheck', HealthcheckController::class);
    }
}
