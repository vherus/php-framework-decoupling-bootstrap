<?php

namespace Vherus\Framework\Time;

use Cake\Chronos\Chronos;

interface Clock
{
    public function getCurrentDateTime(): Chronos;

    /** @alias Clock::getCurrentDateTime() */
    public function now(): Chronos;
}
