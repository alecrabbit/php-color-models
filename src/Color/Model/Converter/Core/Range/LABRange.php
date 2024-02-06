<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\Core\Range;

use AlecRabbit\Color\Model\Contract\Converter\Core\ILABRange;

final readonly class LABRange implements ILABRange
{
    private float $minL;
    private float $minA;
    private float $minB;

    public function __construct(
        private float $maxL = 100,
        private float $maxA = 127,
        private float $maxB = 127,
    ) {
        $this->minL = 0;
        $this->minA = -$this->maxA;
        $this->minB = -$this->maxB;
    }

    public function maxL(): float
    {
        return $this->maxL;
    }

    public function maxA(): float
    {
        return $this->maxA;
    }

    public function maxB(): float
    {
        return $this->maxB;
    }

    public function minL(): float
    {
        return $this->minL;
    }

    public function minA(): float
    {
        return $this->minA;
    }

    public function minB(): float
    {
        return $this->minB;
    }
}
