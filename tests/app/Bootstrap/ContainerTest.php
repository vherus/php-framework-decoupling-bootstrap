<?php

namespace Vherus\Bootstrap;

use Illuminate\Database\Connection;
use Vherus\Testing\Traits\RunsMigrations;
use Vherus\Testing\Traits\UsesContainer;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    use UsesContainer, RunsMigrations;

    public function test_db_can_be_created()
    {
        $container = $this->runMigrations($this->createContainer());
        $this->assertInstanceOf(Connection::class, $container->get(Connection::class));
    }
}
