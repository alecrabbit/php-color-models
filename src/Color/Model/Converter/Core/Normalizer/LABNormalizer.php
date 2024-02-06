<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\Core\Normalizer;

use AlecRabbit\Color\Model\Contract\Converter\Core\ILABNormalizer;
use AlecRabbit\Color\Model\Contract\Converter\Core\ILABRange;
use AlecRabbit\Color\Model\Converter\Core\Range\LABRange;

final readonly class LABNormalizer implements ILABNormalizer
{
    public function __construct(
        private ILABRange $range = new LABRange()
    ) {
    }

    public function normalizeL(float $l): float
    {
        return $l * $this->range->maxL();
    }

    public function normalizeA(float $a): float
    {
        return $a * $this->range->maxA();
    }

    public function normalizeB(float $b): float
    {
        return $b * $this->range->maxB();
    }
}