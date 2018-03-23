<?php

namespace Vherus\Framework\Middleware\Auth\Stratigility;

use Psr\Http\Message\ServerRequestInterface;
use PSR7Sessions\Storageless\Http\SessionMiddleware;

class StoragelessSession implements SessionStore
{
    public function get(ServerRequestInterface $request, string $key)
    {
        return $request->getAttribute(SessionMiddleware::SESSION_ATTRIBUTE)->get($key);
    }

    public function set(ServerRequestInterface $request, string $key, $value): void
    {
        $request->getAttribute(SessionMiddleware::SESSION_ATTRIBUTE)->set($key, $value);
    }
}
