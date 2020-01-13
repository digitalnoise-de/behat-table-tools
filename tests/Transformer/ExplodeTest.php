<?php

namespace Digitalnoise\Behat\TableTools\Tests\Transformer;

use Digitalnoise\Behat\TableTools\Transformer\Explode;
use PHPUnit\Framework\TestCase;

/**
 * @author Philip Weinke <philip.weinke@digitalnoise.de>
 *
 * @covers \Digitalnoise\Behat\TableTools\Transformer\Explode
 */
class ExplodeTest extends TestCase
{
    public function test_transform_should_explode_by_the_given_delimiter()
    {
        $transformer = new Explode(',');

        $result = $transformer('a, b, c');

        self::assertEquals(['a', 'b', 'c'], $result);
    }

    public function test_transform_should_keep_spaces_when_trim_is_set_to_false()
    {
        $transformer = new Explode(',', false);

        $result = $transformer('a, b, c');

        self::assertEquals(['a', ' b', ' c'], $result);
    }

    public function test_transform_should_return_empty_array_for_empty_string()
    {
        $transformer = new Explode(',');

        $result = $transformer('');

        self::assertEquals([], $result);
    }
}
