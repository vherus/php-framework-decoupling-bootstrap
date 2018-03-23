<?php

namespace Vherus\Framework\Middleware\Stratigility\Logging;

use Closure;
use Psr\Log\LoggerInterface as ILogger;
use Throwable;

class PsrLogger implements ErrorLogger
{
    private $logger;
    private $logLevelCallback;

    /**
     * @param ILogger $logger
     * @param callable $logLevelCallback
     *  When an exception occurs, this callable will be called and passed a single argument (the
     *  Throwable). This callable should return a string which is a log level that can be passed
     *  to the PSR LoggerInterface.
     */
    public function __construct(ILogger $logger, Closure $logLevelCallback = null)
    {
        $this->logger = $logger;
        $this->logLevelCallback = $logLevelCallback ?: function () {
            return 'error';
        };
    }

    public function log(Throwable $exception): void
    {
        $class = get_class($exception);
        $message = "$class caught with message '{$exception->getMessage()}'";

        $context = ['exception' => $exception];

        $level = call_user_func($this->logLevelCallback, $exception);

        $this->logger->log($level, $message, $context);
    }
}
