<?php
declare(strict_types=1);

namespace Digitalnoise\Behat\TableTools;

use InvalidArgumentException;

/**
 * @author Philip Weinke <philip.weinke@digitalnoise.de>
 */
final class Row
{
    /**
     * @var array
     */
    private $values;

    /**
     * @param array $values
     */
    public function __construct(array $values)
    {
        $this->values = $values;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->values;
    }

    /**
     * @param string $column
     *
     * @return mixed
     */
    public function get(string $column)
    {
        if (!$this->has($column)) {
            throw new InvalidArgumentException(sprintf('Column "%s" does not exists', $column));
        }

        return $this->values[$column];
    }

    /**
     * @param string $column
     *
     * @return bool
     */
    public function has(string $column): bool
    {
        return array_key_exists($column, $this->values);
    }
}
