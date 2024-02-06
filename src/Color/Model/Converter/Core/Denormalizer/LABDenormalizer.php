<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\Core\Denormalizer;

use AlecRabbit\Color\Model\Contract\Converter\Core\ILABDenormalizer;
use AlecRabbit\Color\Model\Contract\Converter\Core\ILABRange;
use AlecRabbit\Color\Model\Converter\Core\Range\LABRange;

final readonly class LABDenormalizer implements ILABDenormalizer
{
    public function __construct(
        private ILABRange $range = new LABRange()
    ) {
    }

    public function denormalizeL(float $l): float
    {
        return $l / $this->range->maxL();
    }

    public function denormalizeA(float $a): float
    {
        return $a / $this->range->maxA();
    }

    public function denormalizeB(float $b): float
    {
        return $b / $this->range->maxB();
    }
}
