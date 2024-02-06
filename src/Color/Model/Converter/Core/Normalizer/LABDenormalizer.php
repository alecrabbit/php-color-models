<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\Core\Normalizer;

use AlecRabbit\Color\Model\Contract\Converter\Core\ILABDenormalizer;
use AlecRabbit\Color\Model\Contract\Converter\Core\ILABRange;

final readonly class LABDenormalizer implements ILABDenormalizer
{
    public function __construct(
        private ILABRange $range = new LABRange()
    ) {
    }

    public function denormalizeL(float $l): float
    {
        return $l / $this->range->getL();
    }

    public function denormalizeA(float $a): float
    {
        return $a / $this->range->getA();
    }

    public function denormalizeB(float $b): float
    {
        return $b / $this->range->getB();
    }
}
