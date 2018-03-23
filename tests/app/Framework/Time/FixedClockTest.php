<?php

namespace Vherus\Framework\Time;

use Cake\Chronos\Chronos;
use PHPUnit\Framework\TestCase;

class FixedClockTest extends TestCase
{
    public function test_instance_is_of_type_clock()
    {
        $this->assertInstanceOf(Clock::class, new FixedClock(null));
    }

    public function test_clock_fixed_at_given_time()
    {
        $clock = new FixedClock(new \DateTimeImmutable('2018-01-01 01:28:54'));

        $this->assertEquals(new Chronos('2018-01-01 01:28:54'), $clock->now());
    }
}
