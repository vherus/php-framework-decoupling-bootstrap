<?php

namespace Vherus\Testing\Traits;

use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Vherus\Application\Console\Console;
use Interop\Container\ContainerInterface as IContainer;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\BufferedOutput;

trait RunsMigrations
{
    protected function runMigrations(IContainer $container): IContainer
    {
        // Drop the DB
        $db = $container->get(AbstractSchemaManager::class);
        foreach ($db->listTableNames() as $table) {
            $db->dropTable($table);
        }

        $console = $container->get(Console::class);
        $console->run(new StringInput('migrations:migrate --no-interaction --quiet'), $output = new BufferedOutput);

        $output = $output->fetch();

        if ($output) {
            $this->fail("Migrations output something that wasn't expected: \n\n $output");
        }

        return $container;
    }
}
