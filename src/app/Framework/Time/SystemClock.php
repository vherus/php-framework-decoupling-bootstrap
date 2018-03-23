<?php

namespace Vherus\Framework\Time;

use Cake\Chronos\Chronos;
use DateTimeZone;

class SystemClock implements Clock
{
    private $timeZone;

    public function __construct(?DateTimeZone $timeZone)
    {
        $this->timeZone = $timeZone ?: new DateTimeZone(date_default_timezone_get());
    }

    public function getCurrentDateTime(): Chronos
    {
        return new Chronos('now', $this->timeZone);
    }

    public function now(): Chronos
    {
        return $this->getCurrentDateTime();
    }
}
