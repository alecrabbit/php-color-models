<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\Core\Normalizer;

use AlecRabbit\Color\Model\Contract\Converter\Core\ILABRange;

final readonly class LABRange implements ILABRange
{
    public function __construct(
        private float $l = 100,
        private float $a = 127,
        private float $b = 127,
    ) {
    }

    public function getL(): float
    {
        return $this->l;
    }

    public function getA(): float
    {
        return $this->a;
    }

    public function getB(): float
    {
        return $this->b;
    }
}
