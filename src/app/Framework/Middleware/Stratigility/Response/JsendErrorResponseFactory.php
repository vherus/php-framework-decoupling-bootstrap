<?php

namespace Vherus\Framework\Middleware\Stratigility\Response;

use Vherus\Framework\Exception\ValidationException;
use Vherus\Framework\Jsend\JsendError;
use Vherus\Framework\Jsend\JsendErrorResponse;
use Vherus\Framework\Jsend\JsendFailResponse;
use Vherus\Framework\Exception\UnauthorisedException;
use Psr\Http\Message\ResponseInterface as IResponse;
use Throwable;
use Vherus\Framework\Exception\UnauthenticatedException;

class JsendErrorResponseFactory implements ErrorResponseFactory
{
    public function create(Throwable $exception): IResponse
    {
        if ($exception instanceof ValidationException) {
            return (new JsendFailResponse([
                new JsendError($exception->getMessage())
            ]))->withStatus(400);
        }

        if ($exception instanceof UnauthenticatedException) {
            return (new JsendErrorResponse([
                new JsendError($exception->getMessage() ?: 'Unauthenticated', 401)
            ]))->withStatus(401);
        }

        if ($exception instanceof UnauthorisedException) {
            return (new JsendErrorResponse([
                new JsendError($exception->getMessage() ?: 'Forbidden', 403)
            ]))->withStatus(403);
        }

        return new JsendErrorResponse;
    }
}
