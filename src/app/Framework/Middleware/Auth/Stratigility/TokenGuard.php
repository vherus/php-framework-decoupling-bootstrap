<?php

namespace Vherus\Framework\Middleware\Auth\Stratigility;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Vherus\Framework\Middleware\Auth\Authoriser;
use Psr\Http\Message\ServerRequestInterface as IRequest;
use Psr\Http\Message\ResponseInterface as IResponse;
use Vherus\Framework\Exception\UnauthorisedException;

class TokenGuard implements MiddlewareInterface
{
    private $authoriser;

    public function __construct(Authoriser $authoriser)
    {
        $this->authoriser = $authoriser;
    }

    /** @throws UnauthorisedException */
    public function process(IRequest $request, DelegateInterface $delegate): IResponse
    {
        if (!$this->authoriser->shouldAuthorise($request)) {
            return $delegate->process($request);
        }

        if (!$token = $this->getToken($request)) {
            throw new UnauthorisedException('Missing `AuthorizationToken` HTTP header');
        }

        if (!$this->authoriser->isAllowed($token, $request)) {
            throw new UnauthorisedException("Invalid `AuthorizationToken` HTTP header provided");
        }

        return $delegate->process($request);
    }

    private function getToken(IRequest $request): ?string
    {
        return $request->getHeader('AuthorizationToken')[0] ?? null;
    }
}
