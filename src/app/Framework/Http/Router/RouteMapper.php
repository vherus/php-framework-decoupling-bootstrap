<?php

namespace Vherus\Framework\Http\Router;

use FastRoute\RouteCollector;

interface RouteMapper
{
    public function map(RouteCollector $router): void;
}
