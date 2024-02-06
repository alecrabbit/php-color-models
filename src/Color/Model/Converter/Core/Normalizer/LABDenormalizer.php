<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\Core\Normalizer;

use AlecRabbit\Color\Model\Contract\Converter\Core\ILabDenormalizer;

final readonly class LabDenormalizer implements ILabDenormalizer
{
    public function denormalizeL(float $l): float
    {
        return $l / 100;
    }

    public function denormalizeA(float $a): float
    {
        return $a / 127;
    }

    public function denormalizeB(float $b): float
    {
        return $b / 127;
    }
}
