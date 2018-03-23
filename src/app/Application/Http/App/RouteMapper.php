<?php

namespace Vherus\Application\Http\App;

use FastRoute\RouteCollector;
use Vherus\Framework\Http\Router\RouteMapper as IRouteMapper;

class RouteMapper implements IRouteMapper
{
    public function map(RouteCollector $router): void
    {
        $router->addRoute('GET', '/app', Controller\HomepageController::class);
    }
}
