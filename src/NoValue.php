<?php
declare(strict_types=1);

namespace Digitalnoise\Behat\TableTools;

/**
 * @author Philip Weinke <philip.weinke@digitalnoise.de>
 */
final class NoValue
{
    /**
     * @var self|null
     */
    private static $instance = null;

    private function __construct()
    {
    }

    /**
     * @return static
     */
    public static function instance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
