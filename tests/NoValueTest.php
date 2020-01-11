<?php

namespace Digitalnoise\Behat\TableTools\Tests;

use Digitalnoise\Behat\TableTools\NoValue;
use PHPUnit\Framework\TestCase;

/**
 * @author Philip Weinke <philip.weinke@digitalnoise.de>
 *
 * @covers \Digitalnoise\Behat\TableTools\NoValue
 */
class NoValueTest extends TestCase
{
    public function test_instance_should_always_return_the_same_instance()
    {
        $instance = NoValue::instance();

        self::assertSame($instance, NoValue::instance());
    }
}
