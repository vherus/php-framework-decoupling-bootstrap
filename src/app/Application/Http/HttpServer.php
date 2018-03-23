<?php

namespace Vherus\Application\Http;

use Vherus\Framework\Middleware\Auth\Stratigility\SessionGuard;
use Vherus\Framework\Http\Router\Router;
use Vherus\Framework\Middleware\Auth\Stratigility\TokenGuard;
use Vherus\Framework\Middleware\Stratigility\ErrorHandler;
use Vherus\Framework\Middleware\Stratigility\Logging\PsrLogger;
use Vherus\Framework\Middleware\Stratigility\Response\HtmlErrorResponseFactory;
use Interop\Container\ContainerInterface as IContainer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use PSR7Sessions\Storageless\Http\SessionMiddleware;
use Zend\Diactoros\Response;
use Zend\Stratigility\Middleware\DoublePassMiddlewareDecorator;
use Zend\Stratigility\Middleware\OriginalMessages;
use Zend\Stratigility\Middleware\PathMiddlewareDecorator;
use Zend\Stratigility\MiddlewarePipe;

class HttpServer
{
    private $container;

    public function __construct(IContainer $container)
    {
        $this->container = $container;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $pipe = (new MiddlewarePipe);

        return $pipe

            ->pipe(new PathMiddlewareDecorator('/', new DoublePassMiddlewareDecorator(new OriginalMessages, new Response)))

            ->pipe(new PathMiddlewareDecorator('/', new ErrorHandler(
                $this->container->get(HtmlErrorResponseFactory::class),
                $this->container->get(PsrLogger::class)
            )))

            // Api specific middleware
            ->pipe(new PathMiddlewareDecorator('/api', $this->container->get(TokenGuard::class)))

            ->process($request, $this->container->get(Router::class));
    }
}
