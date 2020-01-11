<?php

namespace Digitalnoise\Behat\TableTools\Tests;

use Digitalnoise\Behat\TableTools\Row;
use Digitalnoise\Behat\TableTools\Table;
use PHPUnit\Framework\TestCase;

/**
 * @author Philip Weinke <philip.weinke@digitalnoise.de>
 *
 * @covers \Digitalnoise\Behat\TableTools\Table
 */
class TableTest extends TestCase
{
    public function test_row_should_be_returned_by_index()
    {
        $table = Table::fromArray([['name' => 'John'], ['name' => 'Abe']]);

        $result = $table->row(1);

        self::assertEquals(new Row(['name' => 'Abe']), $result);
    }

    public function test_rows_should_return_all_rows()
    {
        $table = Table::fromArray([['name' => 'John'], ['name' => 'Abe']]);

        $result = $table->rows();

        self::assertEquals([new Row(['name' => 'John']), new Row(['name' => 'Abe'])], $result);
    }

    public function test_create_func_for_every_row_should_have_been_called()
    {
        $table = Table::fromArray([['name' => 'John', 'age' => 18], ['name' => 'Abe', 'age' => 68]]);

        $result = $table->map(
            function (Row $row) {
                return sprintf('Name: %s, Age: %d', $row->get('name'), $row->get('age'));
            }
        );

        self::assertEquals(['Name: John, Age: 18', 'Name: Abe, Age: 68'], $result);
    }
}
