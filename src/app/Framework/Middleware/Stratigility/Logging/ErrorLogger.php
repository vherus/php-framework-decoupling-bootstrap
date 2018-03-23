<?php

namespace Vherus\Framework\Middleware\Stratigility\Logging;

use Throwable;

interface ErrorLogger
{
    public function log(Throwable $exception): void;
}
