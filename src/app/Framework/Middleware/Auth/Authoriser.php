<?php

namespace Vherus\Framework\Middleware\Auth;

use Psr\Http\Message\RequestInterface as IRequest;

interface Authoriser
{
    public function shouldAuthorise(IRequest $request): bool;

    public function isAllowed(string $token, IRequest $request): bool;
}
