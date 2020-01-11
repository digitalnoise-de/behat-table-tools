<?php

namespace Digitalnoise\Behat\TableTools\Tests;

use Digitalnoise\Behat\TableTools\Row;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @author Philip Weinke <philip.weinke@digitalnoise.de>
 *
 * @covers \Digitalnoise\Behat\TableTools\Row
 */
class RowTest extends TestCase
{
    public function test_has_should_return_whether_the_row_has_a_column()
    {
        $row = new Row(['name' => 'Peter']);

        self::assertTrue($row->has('name'));
        self::assertFalse($row->has('age'));
    }

    public function test_get_should_return_the_column_value()
    {
        $row = new Row(['name' => 'Peter']);

        $result = $row->get('name');

        self::assertEquals('Peter', $result);
    }

    public function test_get_should_throw_an_exception_when_requesting_a_non_existing_column()
    {
        $row = new Row(['name' => 'Peter']);

        self::expectExceptionObject(new InvalidArgumentException('Column "age" does not exists'));

        $row->get('age');
    }

    public function test_toArray_should_return_the_row_as_an_associated_array()
    {
        $row = new Row(['name' => 'Peter']);

        $result = $row->toArray();

        self::assertEquals(['name' => 'Peter'], $result);
    }
}
