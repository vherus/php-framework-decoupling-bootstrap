<?php

namespace Vherus\Application\Http\ApiV1;

use DI\Container;
use GuzzleHttp\Psr7\ServerRequest;
use Vherus\Framework\Jsend\JsendSuccessResponse;
use Vherus\Bootstrap\ConfigFactory;
use Vherus\Testing\Traits\UsesContainer;
use Vherus\Testing\Traits\UsesHttpServer;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class ApiV1HelloIntegrationTest extends TestCase
{
    use UsesContainer, UsesHttpServer;

    public function test_403_returned_when_no_auth_token()
    {
        $response = $this->handle($this->createContainer(), (new ServerRequest('GET', 'https://example.com/api/v1/hello'))->withHeader('AuthorizationToken', '11111111-2222-3333-4444-555555555555'));
        $this->assertEquals(403, $response->getStatusCode());
    }

    public function test_200_response_returned_when_auth_token_present_and_valid()
    {
        $config = ConfigFactory::create([
            'auth.authorized-keys' => ['aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee']
        ]);

        $container = $this->createContainer($config);

        $response = $this->handle(
            $container,
            (new ServerRequest('GET', 'https://example.com/api/v1/hello'))->withHeader('AuthorizationToken', 'aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee')
        );

        $this->assertEquals(200, $response->getStatusCode());
    }
}
