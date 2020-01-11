<?php

namespace Digitalnoise\Behat\TableTools\Tests\Transformer;

use Digitalnoise\Behat\TableTools\Transformer\Chain;
use PHPUnit\Framework\TestCase;

/**
 * @author Philip Weinke <philip.weinke@digitalnoise.de>
 *
 * @covers \Digitalnoise\Behat\TableTools\Transformer\Chain
 */
class ChainTest extends TestCase
{
    public function test_all_callables_should_be_called()
    {
        $transformer = new Chain(
            function ($value) {
                return $value.':A';
            },
            function ($value) {
                return $value.':B';
            },
            function ($value) {
                return $value.':C';
            }
        );

        $result = $transformer('test');

        self::assertEquals('test:A:B:C', $result);
    }
}
