<?php

declare(strict_types=1);

namespace AlecRabbit\Builder;

use AlecRabbit\Builder\Dummy\IDummy;

abstract class AbstractBuilder
{
    abstract public function build(): mixed;

    /**
     * @param mixed $value
     * @return ($value is IDummy ? true : false)
     */
    protected function isDummy(mixed $value): bool
    {
        return $value instanceof IDummy;
    }

    abstract protected function validate(): void;
}
