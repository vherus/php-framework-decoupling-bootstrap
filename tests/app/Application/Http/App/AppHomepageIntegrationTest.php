<?php

namespace Vherus\Application\Http\App;

use GuzzleHttp\Psr7\ServerRequest;
use Vherus\Testing\Traits\UsesContainer;
use Vherus\Testing\Traits\UsesHttpServer;
use PHPUnit\Framework\TestCase;

class AppHomepageIntegrationTest extends TestCase
{
    use UsesContainer, UsesHttpServer;

    public function test_200_response_returned_when_logged_in()
    {
        $container = $this->createContainer();

        $request = (new ServerRequest('GET', 'https://example.com/app'));

        $response = $this->handle($container, $request);

        $this->assertEquals(200, $response->getStatusCode());
    }
}
