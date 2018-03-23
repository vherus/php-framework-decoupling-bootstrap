<?php

namespace Vherus\Testing\Traits;

use Vherus\Bootstrap\Config;
use Vherus\Bootstrap\ConfigFactory;

trait UsesConfig
{
    protected function createConfig(): Config
    {
        return ConfigFactory::create();
    }
}
