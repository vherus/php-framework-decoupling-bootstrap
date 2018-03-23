<?php

namespace Vherus\Framework\Http\Router;

use FastRoute\Dispatcher as FastRouteDispatcher;
use Vherus\Framework\Exception\NotFoundException;
use Psr\Container\ContainerInterface as IContainer;
use Psr\Http\Message\RequestInterface as IRequest;
use Psr\Http\Message\ResponseInterface as IResponse;

class Dispatcher
{
    private $container;

    public function __construct(IContainer $container)
    {
        $this->container = $container;
    }

    /** @throws NotFoundException */
    public function dispatch(IRequest $request, FastRouteDispatcher $dispatcher): IResponse
    {
        $routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getUri()->getPath());

        switch ($routeInfo[0]) {
            case FastRouteDispatcher::FOUND:

                $target = $routeInfo[1];
                $bits = explode('@', $target);
                $controller = $bits[0];
                $method = $bits[1] ?? '__invoke';
                $vars = $routeInfo[2];

                $instance = $this->container->get($controller);

                $response = $instance->$method($request);

                if (!$response instanceof IResponse) {
                    throw new \RuntimeException("Return value of $controller::$method is not an instance of " . IResponse::class);
                }

                return $response;

            case FastRouteDispatcher::METHOD_NOT_ALLOWED:
            case FastRouteDispatcher::NOT_FOUND:
                throw new NotFoundException('Page not found');

            default:
                throw new \RuntimeException("Unexpected dispatcher code returned: {$routeInfo[0]}");

        }
    }
}
