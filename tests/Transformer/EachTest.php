<?php

namespace Digitalnoise\Behat\TableTools\Tests\Transformer;

use Digitalnoise\Behat\TableTools\Transformer\Each;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @author Philip Weinke <philip.weinke@digitalnoise.de>
 *
 * @covers \Digitalnoise\Behat\TableTools\Transformer\Each
 */
class EachTest extends TestCase
{
    public function test_each_item_should_be_transformed()
    {
        $transformer = new Each('strtoupper');

        $result = $transformer(['a', 'b', 'c']);

        self::assertEquals(['A', 'B', 'C'], $result);
    }

    public function test_transforming_non_array_should_throw_exception()
    {
        $transformer = new Each('strtoupper');

        self::expectExceptionObject(new InvalidArgumentException('Expected an array. Got: string'));

        $transformer('a');
    }
}
