<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\Core\Normalizer;

use AlecRabbit\Color\Model\Contract\Converter\Core\IXYZNormalizer;

final readonly class NoOpXYZNormalizer implements IXYZNormalizer
{

    public function normalizeX(float $x): float
    {
        return $x;
    }

    public function normalizeY(float $y): float
    {
        return $y;
    }

    public function normalizeZ(float $z): float
    {
        return $z;
    }
}
