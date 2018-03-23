<?php

namespace Vherus\Testing\Traits;

use Vherus\Bootstrap\Config;
use Vherus\Bootstrap\ConfigFactory;
use Vherus\Bootstrap\ContainerFactory;
use Interop\Container\ContainerInterface as IContainer;

trait UsesContainer
{
    protected function createContainer(Config $config = null): IContainer
    {
        return (new ContainerFactory)->create($config ?: ConfigFactory::create());
    }
}
