<?php
declare(strict_types=1);

namespace Digitalnoise\Behat\TableTools\Transformer;

/**
 * @author Philip Weinke <philip.weinke@digitalnoise.de>
 */
final class Explode
{
    /**
     * @var string
     */
    private $delimiter;

    /**
     * @var bool
     */
    private $trim;

    /**
     * @param string $delimiter
     * @param bool   $trim
     */
    public function __construct(string $delimiter, bool $trim = true)
    {
        $this->delimiter = $delimiter;
        $this->trim      = $trim;
    }

    /**
     * @param string $value
     *
     * @return array
     */
    public function __invoke($value)
    {
        if (empty($value)) {
            return [];
        }

        $values = explode($this->delimiter, $value);
        if (!$this->trim) {
            return $values;
        }

        return array_map('trim', $values);
    }
}
