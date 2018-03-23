<?php

namespace Vherus\Application\Http\Healthcheck;

use Zend\Diactoros\Response\HtmlResponse;

class HealthcheckController
{
    public function __invoke()
    {
        return new HtmlResponse("Everything is OK!\n");
    }
}
