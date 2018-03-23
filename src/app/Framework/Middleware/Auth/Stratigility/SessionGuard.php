<?php

namespace Vherus\Framework\Middleware\Auth\Stratigility;

use function GuzzleHttp\Psr7\parse_query;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Vherus\Framework\Exception\NotFoundException;
use Vherus\Framework\Exception\UnauthorisedException;
use Vherus\Framework\Middleware\Auth\Authoriser;
use Psr\Http\Message\ResponseInterface as IResponse;
use Psr\Http\Message\ServerRequestInterface as IRequest;
use Zend\Diactoros\Response\RedirectResponse;

class SessionGuard implements MiddlewareInterface
{
    private const SESSION_VAR = 'auth_token';

    private $authoriser;

    private $session;

    public function __construct(Authoriser $authoriser, SessionStore $session)
    {
        $this->authoriser = $authoriser;
        $this->session = $session;
    }

    /**
     * @throws NotFoundException when no auth token has been provided in the request
     * @throws UnauthorisedException when the provided auth token is invalid
     */
    public function process(IRequest $request, DelegateInterface $delegate): IResponse
    {
        if (!$this->authoriser->shouldAuthorise($request)) {
            return $delegate->process($request);
        }

        if ($token = $this->getQueryStringToken($request)) {
            $this->session->set($request, self::SESSION_VAR, $token);
            return $this->redirectRemoveTokenFromUri($request);
        }

        if (!$token = $this->session->get($request, self::SESSION_VAR)) {
            throw new NotFoundException("Could not retrieve an authentication token from the request.");
        }

        if (!$this->authoriser->isAllowed($token, $request)) {
            throw new UnauthorisedException("The auth token retrieved from the request is invalid.");
        }

        return $delegate->process($request);
    }

    private function getQueryStringToken(IRequest $request): string
    {
        parse_str($request->getUri()->getQuery(), $args);
        return $args[self::SESSION_VAR] ?? '';
    }

    /**
     * @param IRequest $request
     * @return mixed|\Psr\Http\Message\UriInterface
     */
    private function getUri(IRequest $request)
    {
        $uri = $request->getUri();

        // Stratigility mutates the `Uri` object before passing it to middleware by
        // removing the path used to bind the middleware. If the OriginalMessages
        // middleware is used we can access the originalUri attribute.
        if ($request->getAttribute('originalUri')) {
            $uri = $request->getAttribute('originalUri');
        }
        return $uri;
    }

    private function redirectRemoveTokenFromUri(IRequest $request): RedirectResponse
    {
        $uri = $this->getUri($request);

        $query = parse_query($uri->getQuery());

        unset($query['auth_token']);
        $uri = $uri->withQuery(http_build_query($query));


        return new RedirectResponse((string) $uri);
    }
}
