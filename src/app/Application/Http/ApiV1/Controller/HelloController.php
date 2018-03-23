<?php

namespace Vherus\Application\Http\ApiV1\Controller;

use Vherus\Framework\Jsend\JsendSuccessResponse;

class HelloController
{
    public function __invoke()
    {
        return new JsendSuccessResponse([
            'message' => 'Hello, world!'
        ]);
    }
}
