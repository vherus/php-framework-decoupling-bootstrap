<?php

namespace Vherus\Framework\Middleware\Auth;

use Psr\Http\Message\RequestInterface as IRequest;

class ArrayAuthoriser implements Authoriser
{
    private $allowedTokens;
    private $ignoredPaths;

    public function __construct(array $allowedTokens, array $ignoredPaths)
    {
        $this->allowedTokens = $allowedTokens;
        $this->ignoredPaths = $ignoredPaths;
    }

    public function shouldAuthorise(IRequest $request): bool
    {
        return !in_array($request->getUri()->getPath(), $this->ignoredPaths, true);
    }

    public function isAllowed(string $token, IRequest $request): bool
    {
        return in_array($token, $this->allowedTokens, false);
    }
}
