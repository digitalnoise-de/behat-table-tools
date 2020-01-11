<?php
declare(strict_types=1);

namespace Digitalnoise\Behat\TableTools\Transformer;

/**
 * @author Philip Weinke <philip.weinke@digitalnoise.de>
 */
final class Chain
{
    /**
     * @var callable[]
     */
    private $transformers;

    /**
     * @param callable ...$transformers
     */
    public function __construct(callable  ...$transformers)
    {
        $this->transformers = $transformers;
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function __invoke($value)
    {
        foreach ($this->transformers as $transformer) {
            $value = $transformer($value);
        }

        return $value;
    }
}
