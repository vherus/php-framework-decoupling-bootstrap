<?php

namespace Vherus\Framework\Time;

use PHPUnit\Framework\TestCase;

class SystemClockTest extends TestCase
{
    public function test_is_of_type_clock()
    {
        $this->assertInstanceOf(Clock::class, new SystemClock(null));
    }

    public function test_expected_timezone_is_used()
    {
        $clock = new SystemClock(new \DateTimeZone('Africa/Harare'));
        $this->assertEquals(new \DateTimeZone('Africa/Harare'), $clock->now()->getTimezone());
    }
}
