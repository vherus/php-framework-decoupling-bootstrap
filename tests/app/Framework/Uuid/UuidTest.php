<?php

namespace Vherus\Framework\Uuid;

use PHPUnit\Framework\TestCase;

class UuidTest extends TestCase
{
    public function test_generate_created_36_byte_uuid()
    {
        $id = new Uuid(null);
        $this->assertNotEmpty((string) $id);
        $this->assertEquals(36, strlen($id));
    }

    public function test_uuid_is_32_hexidecimal_bytes_once_dashes_are_removed()
    {
        $id = new Uuid(null);
        $this->assertNotEmpty((string) $id);
        $this->assertEquals(32, strlen(str_replace('-', '', $id)));
    }

    public function test_uuid_can_be_easily_converted_to_hex()
    {
        $id = new Uuid(null);
        $this->assertNotEmpty((string) $id);
        $this->assertEquals(str_replace('-', '', $id), $id->getHex());
    }

    public function test_uuids_always_unique_and_valid_binary()
    {
        $ids = [];

        foreach (range(1, 1000) as $i) {
            $id = new Uuid(null);
            $ids[$id->getBinary()] = $id;
        }

        $this->assertEquals(1000, count($ids));

        foreach ($ids as $binary => $id) {
            $this->assertEquals($id, Uuid::createFromBinary($binary));
        }
    }
}
