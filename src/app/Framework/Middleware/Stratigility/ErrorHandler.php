<?php

namespace Vherus\Framework\Middleware\Stratigility;

use Interop\Http\ServerMiddleware\DelegateInterface as IDelegate;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface as IResponse;
use Throwable;
use Vherus\Framework\Middleware\Stratigility\Logging\ErrorLogger;
use Vherus\Framework\Middleware\Stratigility\Response\ErrorResponseFactory;
use Psr\Http\Message\ServerRequestInterface as IRequest;

class ErrorHandler implements MiddlewareInterface
{
    private $presenter;
    private $logger;

    public function __construct(ErrorResponseFactory $presenter, ErrorLogger $logger)
    {
        $this->presenter = $presenter;
        $this->logger = $logger;
    }

    public function process(IRequest $request, IDelegate $delegate): IResponse
    {
        try {
            return $delegate->process($request);
        } catch (Throwable $e) {
            $this->logger->log($e);
            return $this->presenter->create($e);
        }
    }
}
