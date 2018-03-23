<?php

namespace Vherus\Framework\IO;

use PHPUnit\Framework\TestCase;

class OutputBufferTest extends TestCase
{
    public function test_capture()
    {
        $output = OutputBuffer::capture(function () {
            echo "1\n";
            echo "foo";
        });

        $this->assertEquals("1\nfoo", $output);
    }
}
