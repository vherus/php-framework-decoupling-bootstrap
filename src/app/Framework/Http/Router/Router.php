<?php

namespace Vherus\Framework\Http\Router;

use FastRoute\RouteCollector;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Psr\Http\Message\ServerRequestInterface as IRequest;
use Psr\Http\Message\ResponseInterface as IResponse;
use Vherus\Framework\Exception\NotFoundException;

class Router implements DelegateInterface
{
    private $dispatcher;

    /** @var RouteMapper[] */
    private $mappers = [];

    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function addRoutes(RouteMapper $mapper): Router
    {
        $this->mappers[] = $mapper;
        return $this;
    }

    /** @throws NotFoundException */
    public function process(IRequest $request): IResponse
    {
        $dispatcher = \FastRoute\simpleDispatcher(function(RouteCollector $r) {
            foreach ($this->mappers as $mapper) {
                $mapper->map($r);
            }
        });

        return $this->dispatcher->dispatch($request, $dispatcher);
    }
}
