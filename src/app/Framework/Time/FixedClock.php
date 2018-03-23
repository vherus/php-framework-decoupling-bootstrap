<?php

namespace Vherus\Framework\Time;

use Cake\Chronos\Chronos;
use DateTimeImmutable;

class FixedClock implements Clock
{
    private $current;

    public function __construct(?DateTimeImmutable $current)
    {
        $this->current = $current ?: new DateTimeImmutable;
    }

    public function getCurrentDateTime(): Chronos
    {
        return Chronos::instance(
            new DateTimeImmutable(
                $this->current->format(DateTimeImmutable::ATOM)
            )
        );
    }

    public function now(): Chronos
    {
        return $this->getCurrentDateTime();
    }
}
