<?php

namespace Digitalnoise\Behat\TableTools\Tests\Transformer;

use DateTime;
use Digitalnoise\Behat\TableTools\Transformer\DateExpr;
use PHPUnit\Framework\TestCase;

/**
 * @author Philip Weinke <philip.weinke@digitalnoise.de>
 *
 * @covers \Digitalnoise\Behat\TableTools\Transformer\DateExpr
 */
class DateExprTest extends TestCase
{
    public function test_date_string_in_expected_format_should_be_transformed_to_datetime_object()
    {
        $transformer = new DateExpr('d.n.Y H:i:s');

        $result = $transformer('31.12.2019 12:13:14');

        self::assertEquals(new DateTime('2019-12-31 12:13:14'), $result);
    }
}
