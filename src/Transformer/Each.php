<?php
declare(strict_types=1);

namespace Digitalnoise\Behat\TableTools\Transformer;

use Webmozart\Assert\Assert;

/**
 * @author Philip Weinke <philip.weinke@digitalnoise.de>
 */
final class Each
{
    /**
     * @var callable
     */
    private $transformer;

    /**
     * @param callable $transformer
     */
    public function __construct(callable $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * @param array $value
     *
     * @return array
     */
    public function __invoke($value)
    {
        Assert::isArray($value);

        return array_map($this->transformer, $value);
    }
}
