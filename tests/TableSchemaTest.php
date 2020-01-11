<?php

namespace Digitalnoise\Behat\TableTools\Tests;

use Behat\Gherkin\Node\TableNode;
use Digitalnoise\Behat\TableTools\Column;
use Digitalnoise\Behat\TableTools\Row;
use Digitalnoise\Behat\TableTools\TableSchema;
use PHPUnit\Framework\TestCase;

/**
 * @author Philip Weinke <philip.weinke@digitalnoise.de>
 *
 * @covers \Digitalnoise\Behat\TableTools\TableSchema
 */
class TableSchemaTest extends TestCase
{
    public function test_there_can_not_be_two_columns_with_the_same_name()
    {
        self::expectExceptionMessage('Column "name" already exists');

        new TableSchema([Column::create('name'), Column::create('name')]);
    }

    public function test_load_throws_exception_when_required_key_is_missing()
    {
        $schema = new TableSchema(
            [
                Column::create('id')->withRequired(),
                Column::create('name'),
            ]
        );

        self::expectExceptionMessage('Missing columns: id');

        $schema->transform(new TableNode([['name'], ['John']]));
    }

    public function test_load_throws_exception_for_columns_not_defined_in_schema()
    {
        $schema = new TableSchema([Column::create('name')->withRequired()]);

        self::expectExceptionMessage('Unexpected columns: age');

        $schema->transform(new TableNode([['name', 'age'], ['John', '68']]));
    }

    public function test_load_should_return_a_table()
    {
        $schema = new TableSchema(
            [
                Column::create('name')->withRequired(),
                Column::create('age'),
            ]
        );

        $table = $schema->transform(new TableNode([['name', 'age'], ['Jane', 34], ['John', 68]]));

        self::assertCount(2, $table->rows());
        self::assertEquals(new Row(['name' => 'Jane', 'age' => 34]), $table->row(0));
        self::assertEquals(new Row(['name' => 'John', 'age' => 68]), $table->row(1));
    }

    public function test_optional_field_may_be_missing()
    {
        $schema = new TableSchema(
            [
                Column::create('name')->withRequired(),
                Column::create('age'),
            ]
        );

        $table = $schema->transform(new TableNode([['name'], ['John']]));

        self::assertFalse($table->row(0)->has('age'));
    }

    public function test_field_should_be_transformed()
    {
        $schema = new TableSchema(
            [
                Column::create('name')->withRequired(),
                Column::create('age')->withTransformer('intval'),
            ]
        );

        $table = $schema->transform(new TableNode([['name', 'age'], ['John', '68']]));

        self::assertSame(68, $table->row(0)->get('age'));
    }
}
