<?php

namespace Vherus\Framework\Jsend;

use PHPUnit\Framework\TestCase;

class JsendFailResponseTest extends TestCase
{
    public function test_it_can_be_instantiated()
    {
        $response = new JsendFailResponse([
            new JsendError('Page not found', 4),
            new JsendError('User does not exist', 3),
        ]);

        $expectedData = (object) [
            'status' => 'fail',
            'data' => (object) [
                'errors' => [
                    (object) [
                        'message' => 'Page not found',
                        'code' => 4,
                    ],
                    (object) [
                        'message' => 'User does not exist',
                        'code' => 3,
                    ],
                ],
            ]
        ];

        $this->assertEquals($expectedData, json_decode($response->getBody()));
    }

    public function test_it_can_be_instantiated_with_no_errors()
    {
        $response = new JsendFailResponse();

        $expectedData = (object) [
            'status' => 'fail',
            'data' => (object) [
                'errors' => []
            ]
        ];

        $this->assertEquals($expectedData, json_decode($response->getBody()));
    }
}
