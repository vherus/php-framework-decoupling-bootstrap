<?php

namespace Vherus\Application\Http\Healthcheck;

use GuzzleHttp\Psr7\ServerRequest;
use Vherus\Testing\Traits\UsesContainer;
use Vherus\Testing\Traits\UsesHttpServer;
use PHPUnit\Framework\TestCase;

class HealthcheckIntegrationTest extends TestCase
{
    use UsesContainer, UsesHttpServer;

    public function test_200_response_returned()
    {
        $response = $this->handle($this->createContainer(), new ServerRequest('GET', '/healthcheck'));
        $this->assertEquals(200, $response->getStatusCode());
    }
}
