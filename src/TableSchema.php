<?php
declare(strict_types=1);

namespace Digitalnoise\Behat\TableTools;

use Behat\Gherkin\Node\TableNode;
use Exception;
use InvalidArgumentException;

/**
 * @author Philip Weinke <philip.weinke@digitalnoise.de>
 */
final class TableSchema
{
    /**
     * @var Column[]
     */
    private $columns;

    /**
     * @var string[]
     */
    private $requiredColumnNames;

    /**
     * @param Column[] $columns
     */
    public function __construct(array $columns)
    {
        $this->columns             = [];
        $this->requiredColumnNames = [];

        foreach ($columns as $column) {
            $name = $column->name();

            if (array_key_exists($name, $this->columns)) {
                throw new InvalidArgumentException(sprintf('Column "%s" already exists', $name));
            }

            if ($column->isRequired()) {
                $this->requiredColumnNames[] = $name;
            }

            $this->columns[$name] = $column;
        }
    }

    /**
     * @param TableNode $tableNode
     *
     * @return Table
     * @throws Exception
     */
    public function transform(TableNode $tableNode): Table
    {
        $allColumnNames = array_keys($this->columns);

        $columnsNames = $tableNode->getRow(0);
        $missing      = array_diff($this->requiredColumnNames, $columnsNames);
        if (count($missing) > 0) {
            throw new InvalidArgumentException(sprintf('Missing columns: %s', implode(', ', $missing)));
        }

        $unexpected = array_diff($columnsNames, $allColumnNames);
        if (count($unexpected) > 0) {
            throw new InvalidArgumentException(sprintf('Unexpected columns: %s', implode(', ', $unexpected)));
        }

        return Table::fromArray(array_map([$this, 'extractValues'], $tableNode->getHash()));
    }

    /**
     * @param array $data
     *
     * @return array
     */
    private function extractValues(array $data): array
    {
        $values = [];

        foreach ($this->columns as $column) {
            $extractedValue = $column->extract($data);

            if (!$extractedValue instanceof NoValue) {
                $values[$column->name()] = $extractedValue;
            }
        }

        return $values;
    }
}
