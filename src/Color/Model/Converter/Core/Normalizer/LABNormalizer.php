<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\Core\Normalizer;

use AlecRabbit\Color\Model\Contract\Converter\Core\ILABNormalizer;

final readonly class LabNormalizer implements ILABNormalizer
{
    public function normalizeL(float $l): float
    {
        return $l * 100;
    }

    public function normalizeA(float $a): float
    {
        return $a * 127;
    }

    public function normalizeB(float $b): float
    {
        return $b * 127;
    }
}
