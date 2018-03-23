<?php

namespace Vherus\Framework\Middleware\Stratigility\Response;

use Psr\Http\Message\ResponseInterface as IResponse;
use Throwable;

interface ErrorResponseFactory
{
    public function create(Throwable $exception): IResponse;
}
