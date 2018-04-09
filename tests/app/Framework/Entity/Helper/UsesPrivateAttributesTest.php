<?php

namespace Vherus\Framework\Entity\Helper;

use PHPUnit\Framework\TestCase;
use Vherus\Framework\Exception\UndefinedException;

class UsesPrivateAttributesTest extends TestCase
{
    public function test_attributes_are_stored_as_expected()
    {
        $mock = new class {
            use UsesPrivateAttributes;

            public function setName(string $name): self
            {
                return $this->set('name', $name);
            }

            public function getName(): string
            {
                return $this->get('name', '');
            }
        };

        $mock->setName('Test');
        $this->assertEquals('Test', $mock->getName());
        $mock->setName('Changed');
        $this->assertEquals('Changed', $mock->getName());
    }

    public function test_default_is_used_if_property_does_not_exist()
    {
        $mock = new class {
            use UsesPrivateAttributes;

            public function setName(string $name): self
            {
                return $this->set('name', $name);
            }

            public function getName(): string
            {
                return $this->get('name', 'Default value');
            }
        };

        $this->assertEquals('Default value', $mock->getName());
        $mock->setName('Has been set');
        $this->assertEquals('Has been set', $mock->getName());
    }

    public function test_closures_can_be_supplied_as_default_value()
    {
        $mock = new class {
            use UsesPrivateAttributes;

            public function setName(string $name): self
            {
                return $this->set('name', $name);
            }

            public function getName(): string
            {
                return $this->get('name', function () {
                    return 'Closure';
                });
            }
        };

        $this->assertEquals('Closure', $mock->getName());
    }

    public function test_undefined_exceptions_can_be_thrown()
    {
        $mock = new class {
            use UsesPrivateAttributes;

            public function setName(string $name): self
            {
                return $this->set('name', $name);
            }

            public function getName(): string
            {
                return $this->get('name', $this->throwUndefined('name'));
            }
        };

        $this->expectException(UndefinedException::class);
        $this->expectExceptionMessage('Property `name` is not defined.');
        $mock->getName();
    }
}
