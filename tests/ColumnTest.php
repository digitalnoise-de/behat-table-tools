<?php

namespace Digitalnoise\Behat\TableTools\Tests;

use Digitalnoise\Behat\TableTools\Column;
use Digitalnoise\Behat\TableTools\NoValue;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @author Philip Weinke <philip.weinke@digitalnoise.de>
 *
 * @covers \Digitalnoise\Behat\TableTools\Column
 */
class ColumnTest extends TestCase
{
    public function test_extract_should_return_the_columns_value_from_array()
    {
        $column = Column::create('name');

        $result = $column->extract(['name' => 'John']);

        self::assertEquals('John', $result);
    }

    public function test_extract_should_return_NoValue_if_the_column_does_not_exists_and_there_is_no_default()
    {
        $column = Column::create('name');

        $result = $column->extract([]);

        self::assertInstanceOf(NoValue::class, $result);
    }

    public function test_extract_should_return_the_default_value_if_the_column_does_not_exists()
    {
        $column = Column::create('name')->withDefault('Peter');

        $result = $column->extract([]);

        self::assertEquals('Peter', $result);
    }

    public function test_default_should_be_executed_for_each_row_if_its_a_callable()
    {
        $i      = 0;
        $column = Column::create('name')->withDefault(
            function () use (&$i) {
                return sprintf('Name %d', $i++);
            }
        );

        self::assertEquals('Name 0', $column->extract([]));
        self::assertEquals('Name 1', $column->extract([]));
    }

    public function test_extract_should_throw_exception_if_required_column_is_missing()
    {
        $column = Column::create('name')->withRequired();

        self::expectExceptionMessage('Array has no value for key "name"');

        $column->extract([]);
    }

    public function test_extract_should_accept_null_as_value_for_required_column()
    {
        $column = Column::create('name')->withRequired();

        $result = $column->extract(['name' => null]);

        self::assertEquals(null, $result);
    }

    public function test_extract_should_transform_the_value()
    {
        $column = Column::create('name')->withTransformer('strtoupper');

        $result = $column->extract(['name' => 'John']);

        self::assertEquals('JOHN', $result);
    }

    public function test_extract_should_transform_the_default_value()
    {
        $column = Column::create('name')->withDefault('PAUL')->withTransformer('strtolower');

        $result = $column->extract([]);

        self::assertEquals('paul', $result);
    }

    public function test_extract_should_not_transform_NoValue()
    {
        $column = Column::create('name')->withTransformer(
            function () {
                return false;
            }
        );

        $result = $column->extract([]);

        self::assertInstanceOf(NoValue::class, $result);
    }

    public function test_a_required_column_must_not_have_a_default_value()
    {
        self::expectExceptionObject(new InvalidArgumentException('A required column may not have a default value'));

        Column::create('name')->withRequired()->withDefault('Test');
    }

    public function test_an_optional_column_with_default_can_not_become_required()
    {
        self::expectExceptionObject(new InvalidArgumentException('A required column may not have a default value'));

        Column::create('name')->withDefault('Test')->withRequired();
    }
}
