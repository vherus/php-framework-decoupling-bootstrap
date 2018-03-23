<?php

namespace Vherus\Application\Http\App\Controller;

use Vherus\Framework\IO\OutputBuffer;
use Psr\Http\Message\ResponseInterface as IResponse;
use Psr\Http\Message\ServerRequestInterface as IRequest;
use PSR7Sessions\Storageless\Http\SessionMiddleware;
use Zend\Diactoros\Response\HtmlResponse;

class HomepageController
{
    public function __invoke(IRequest $request): IResponse
    {
        return new HtmlResponse(OutputBuffer::capture(function () use ($request) {
            $token = 'aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee';
            require __DIR__ . '/../resources/template/app.php';
        }));
    }
}
