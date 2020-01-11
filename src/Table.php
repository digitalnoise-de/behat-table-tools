<?php
declare(strict_types=1);

namespace Digitalnoise\Behat\TableTools;

use Webmozart\Assert\Assert;

/**
 * @author Philip Weinke <philip.weinke@digitalnoise.de>
 */
final class Table
{
    /**
     * @var Row[]
     */
    private $rows;

    /**
     * @param Row[] $rows
     */
    public function __construct(array $rows)
    {
        Assert::allIsInstanceOf($rows, Row::class);

        $this->rows = $rows;
    }

    /**
     * @param array $tableData
     *
     * @return static
     */
    public static function fromArray(array $tableData): self
    {
        return new self(
            array_map(
                function (array $rowData) {
                    return new Row($rowData);
                },
                $tableData
            )
        );
    }

    /**
     * @param callable $param
     *
     * @return array
     */
    public function map(callable $param): array
    {
        return array_map($param, $this->rows);
    }

    /**
     * @param int $int
     *
     * @return Row
     */
    public function row(int $int): Row
    {
        return $this->rows[$int];
    }

    /**
     * @return Row[]
     */
    public function rows(): array
    {
        return $this->rows;
    }
}
