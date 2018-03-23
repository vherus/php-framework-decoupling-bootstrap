<?php

namespace Vherus\Framework\Middleware\Stratigility\Response;

use InvalidArgumentException;
use Vherus\Framework\Exception\NotFoundException;
use Vherus\Framework\Exception\UnauthorisedException;
use Psr\Http\Message\ResponseInterface as IResponse;
use Throwable;
use Vherus\Framework\Exception\UnauthenticatedException;
use Zend\Diactoros\Response\TextResponse;

class HtmlErrorResponseFactory implements ErrorResponseFactory
{
    /**
     * @throws InvalidArgumentException
     * @todo Replace with more user-friendly HTML response
     */
    public function create(Throwable $exception): IResponse
    {
        if ($exception instanceof UnauthenticatedException) {
            return new TextResponse(
                'You are not authenticated to perform that action',
                401
            );
        }

        if ($exception instanceof UnauthorisedException) {
            return new TextResponse(
                'You are not authorized to perform that action',
                403
            );
        }

        if ($exception instanceof NotFoundException) {
            return new TextResponse(
                'Page not found',
                404
            );
        }

        return new TextResponse(
            'Server Unavailable',
            500
        );
    }
}
