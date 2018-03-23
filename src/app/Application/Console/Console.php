<?php

namespace Vherus\Application\Console;

use Doctrine\DBAL\Migrations\OutputWriter;
use Doctrine\DBAL\Migrations\Tools\Console\Command\DiffCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\ExecuteCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\GenerateCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\MigrateCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\StatusCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\VersionCommand;
use Vherus\Application\Console\Command\HelloWorld;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\DBAL\Migrations\Configuration\Configuration;
use Doctrine\DBAL\Migrations\Finder\GlobFinder;
use Doctrine\DBAL\Migrations\Tools\Console\Helper\ConfigurationHelper;
use Interop\Container\ContainerInterface as IContainer;
use Psr\Log\LoggerInterface as ILogger;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface as IInput;
use Symfony\Component\Console\Output\OutputInterface as IOutput;

class Console
{
    private $container;

    public function __construct(IContainer $container)
    {
        $this->container = $container;
    }

    public function run(IInput $input, IOutput $output): int
    {
        $app = new Application('CLI Application');

        $app->setAutoExit(false);
        $app->setCatchExceptions(false);

        $app->setHelperSet(new HelperSet([
            'dialog' => new QuestionHelper,
            'configuration' => $this->configureDoctrineHelper($output),
        ]));

        $app->addCommands([
            $this->container->get(HelloWorld::class),

            new DiffCommand,
            new ExecuteCommand,
            new GenerateCommand,
            new MigrateCommand,
            new StatusCommand,
            new VersionCommand
        ]);

        try {
            return $app->run($input, $output);
        } catch (\Throwable $e) {
            $message = get_class($e) . " during '{$input->getFirstArgument()}' with message: {$e->getMessage()}";

            $output->writeln("<error>$message</error>");

            $this->container->get(ILogger::class)->error(
                $message,
                ['exception' => $e]
            );

            return 1;
        }
    }

    private function configureDoctrineHelper(IOutput $output): ConfigurationHelper
    {
        $doctrineConfig = new Configuration(
            $this->container->get(Connection::class),
            null,
            new GlobFinder
        );

        $configHelper = new ConfigurationHelper($this->container->get(Connection::class), $doctrineConfig);

        $doctrineConfig->setMigrationsNamespace(__NAMESPACE__ . '\\Command\\Migration');
        $doctrineConfig->setMigrationsDirectory(__DIR__ . '/Command/Migration');
        $doctrineConfig->setOutputWriter(new OutputWriter(function (string $message) use ($output) {
            $output->writeln($message);
        }));

        return $configHelper;
    }
}
