<?php
declare(strict_types=1);

namespace Digitalnoise\Behat\TableTools\Transformer;

use DateTime;

/**
 * @author Philip Weinke <philip.weinke@digitalnoise.de>
 */
final class DateExpr
{
    /**
     * @var string
     */
    private $format;

    /**
     * @param string $format
     */
    public function __construct(string $format)
    {
        $this->format = $format;
    }

    /**
     * @param string $value
     *
     * @return DateTime
     */
    public function __invoke($value)
    {
        return DateTime::createFromFormat($this->format, $value);
    }
}
