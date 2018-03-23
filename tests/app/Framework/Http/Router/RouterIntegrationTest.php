<?php

namespace Vherus\Framework\Http\Router;

use FastRoute\RouteCollector;
use Vherus\Framework\Exception\NotFoundException;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Container\ContainerInterface as IContainer;
use Zend\Diactoros\Response\TextResponse;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Uri;

class RouterIntegrationTest extends TestCase
{
    public function test_bound_routes_are_processed()
    {
        $request = new ServerRequest;
        $request = $request->withMethod('get')->withUri(new Uri('/foobar'));

        /** @var IContainer|ObjectProphecy $container */
        $container = $this->prophesize(IContainer::class);

        $container->get('mycontroller')->willReturn(new class () {
            public function __invoke()
            {
                return new TextResponse('hello world', 202);
            }
        });

        $router = new Router(new Dispatcher($container->reveal()));

        $router->addRoutes(new class implements RouteMapper {
            public function map(RouteCollector $router): void
            {
                $router->addRoute('get', '/foobar', 'mycontroller');
            }
        });

        $response = $router->process($request);
        $this->assertEquals(202, $response->getStatusCode());
    }

    public function test_notfound_exception_thrown_on_404()
    {
        $request = new ServerRequest();
        $request = $request->withMethod('get')->withUri(new Uri('/no-found'));

        /** @var IContainer|ObjectProphecy $container */
        $container = $this->prophesize(IContainer::class);

        $container->get('mycontroller')->willReturn(new class () {
            public function __invoke()
            {
                return new TextResponse('hello world', 202);
            }
        });

        $router = new Router(new Dispatcher($container->reveal()));

        $router->addRoutes(new class implements RouteMapper {
            public function map(RouteCollector $router): void
            {
                $router->addRoute('get', '/foobar', 'mycontroller');
            }
        });

        $this->expectException(NotFoundException::class);
        $router->process($request);
    }
}
