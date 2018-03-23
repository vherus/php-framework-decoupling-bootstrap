<?php

/**
 * This bootstrap file simply loads in any environment config ($_ENV), the creates and returns the ContainerInterface
 */

require __DIR__ . '/vendor/autoload.php';

if (file_exists(__DIR__ . '/.env')) {
    (new \josegonzalez\Dotenv\Loader(__DIR__ . '/.env'))
        ->parse()
        ->putenv(true);
}

return (new \Vherus\Bootstrap\ContainerFactory)->create(
    \Vherus\Bootstrap\ConfigFactory::create()
);
