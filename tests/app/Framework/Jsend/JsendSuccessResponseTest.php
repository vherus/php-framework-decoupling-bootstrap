<?php

namespace Vherus\Framework\Jsend;

use PHPUnit\Framework\TestCase;

class JsendSuccessResponseTest extends TestCase
{
    public function test_it_can_be_instantiated()
    {
        $response = new JsendSuccessResponse((object) [
            'foo' => 'bar',
            'fizz' => [4, 5]
        ]);

        $expectedData = (object) [
            'status' => 'success',
            'data' => (object) [
                'foo' => 'bar',
                'fizz' => [4, 5]
            ]
        ];

        $this->assertEquals($expectedData, json_decode($response->getBody()));
    }

    public function test_it_can_be_instantiated_with_null_data()
    {
        $response = new JsendSuccessResponse();

        $expectedData = (object) [
            'status' => 'success',
            'data' => null
        ];

        $this->assertEquals($expectedData, json_decode($response->getBody()));
    }
}
