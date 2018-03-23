<?php

namespace Vherus\Framework\Jsend;

use PHPUnit\Framework\TestCase;

class JsendResponseTest extends TestCase
{
    public function test_it_can_be_instantiated()
    {
        $response = new JsendResponse(['foo' => 'bar', 'fizz' => [4, 5]]);

        $expectedData = (object) [
            'status' => 'success',
            'data' => (object) [
                'foo' => 'bar',
                'fizz' => [4, 5]
            ]
        ];

        $this->assertEquals($expectedData, json_decode($response->getBody()));
    }

    public function test_instance_cannot_be_created_with_invalid_status()
    {
        $this->expectException(\InvalidArgumentException::class);
        new JsendResponse([], 'whoops');
    }

    public function test_success_factory_method()
    {
        $response = JsendResponse::success('foobar');
        $expectedData = (object) [
            'status' => 'success',
            'data' => 'foobar'
        ];
        $this->assertEquals($expectedData, json_decode($response->getBody()));
    }

    public function test_fail_factory_method()
    {
        $response = JsendResponse::fail('foobar');
        $expectedData = (object) [
            'status' => 'fail',
            'data' => 'foobar'
        ];
        $this->assertEquals($expectedData, json_decode($response->getBody()));
    }

    public function test_error_factory_method()
    {
        $response = JsendResponse::error('foobar');
        $expectedData = (object) [
            'status' => 'error',
            'data' => 'foobar'
        ];
        $this->assertEquals($expectedData, json_decode($response->getBody()));
    }
}
