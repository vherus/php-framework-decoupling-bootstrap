<?php

namespace Vherus\Application\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface as IInput;
use Symfony\Component\Console\Output\OutputInterface as IOutput;

class HelloWorld extends Command
{
    protected function configure()
    {
        $this->setName("hello")
            ->setDescription("This test command says hello");
    }

    protected function execute(IInput $input, IOutput $output)
    {
        $output->writeln('Hello, world!');
    }
}
