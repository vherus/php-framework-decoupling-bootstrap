<?php

namespace Vherus\Framework\Middleware\Auth\Stratigility;

use Psr\Http\Message\ServerRequestInterface as IRequest;

interface SessionStore
{
    /** @return mixed */
    public function get(IRequest $request, string $key);

    public function set(IRequest $request, string $key, $value): void;
}
