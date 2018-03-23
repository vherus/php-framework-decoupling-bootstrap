<?php

namespace Vherus\Framework\Depot;

use Depot\Container as IContainer;
use Interop\Container\ContainerInterface as InnerContainer;

class Container implements IContainer
{
    private $inner;

    public function __construct(InnerContainer $inner)
    {
        $this->inner = $inner;
    }

    public function make(string $class)
    {
        return $this->inner->get($class);
    }
}
