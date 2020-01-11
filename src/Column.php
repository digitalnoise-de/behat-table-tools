<?php
declare(strict_types=1);

namespace Digitalnoise\Behat\TableTools;

use InvalidArgumentException;

/**
 * @author Philip Weinke <philip.weinke@digitalnoise.de>
 */
final class Column
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var bool
     */
    private $required;

    /**
     * @var mixed
     */
    private $default;

    /**
     * @var callable|null
     */
    private $transformer;

    /**
     * @param string        $name
     * @param bool          $required
     * @param null          $default
     * @param callable|null $transformers
     */
    private function __construct(string $name, bool $required, $default, ?callable $transformers)
    {
        $this->name     = $name;
        $this->required = $required;

        if ($required && !$default instanceof NoValue) {
            throw new InvalidArgumentException('A required column may not have a default value');
        }

        $this->default     = $default;
        $this->transformer = $transformers;
    }

    /**
     * @param string $name
     *
     * @return static
     */
    public static function create(string $name): self
    {
        return new self($name, false, NoValue::instance(), null);
    }

    /**
     * @param $default
     *
     * @return $this
     */
    public function withDefault($default): self
    {
        return new self($this->name, $this->required, $default, $this->transformer);
    }

    /**
     * @return $this
     */
    public function withRequired(): self
    {
        return new self($this->name, true, $this->default, $this->transformer);
    }

    /**
     * @param callable $transformer
     *
     * @return $this
     */
    public function withTransformer(callable $transformer): self
    {
        return new self($this->name, $this->required, $this->default, $transformer);
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->required;
    }

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function extract(array $data)
    {
        $value = array_key_exists($this->name, $data) ? $data[$this->name] : $this->default();

        if ($this->required && $value instanceof NoValue) {
            throw new InvalidArgumentException(sprintf('Array has not value for key "%s"', $this->name));
        }

        return $this->transform($value);
    }

    /**
     * @return mixed
     */
    private function default()
    {
        if (is_callable($this->default)) {
            return call_user_func($this->default);
        }

        return $this->default;
    }

    /**
     * @param mixed $input
     *
     * @return mixed
     */
    private function transform($input)
    {
        if (null === $this->transformer) {
            return $input;
        }

        return ($this->transformer)($input);
    }
}
