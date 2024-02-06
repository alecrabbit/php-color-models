<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\Core\Normalizer;

use AlecRabbit\Color\Model\Contract\Converter\Core\IIlluminant;
use AlecRabbit\Color\Model\Contract\Converter\Core\IXYZNormalizer;
use AlecRabbit\Color\Model\Converter\Core\Illuminant\D65Deg2;

final readonly class XYZNormalizer implements IXYZNormalizer
{
    public function __construct(
        private IIlluminant $illuminant = new D65Deg2(),
    ) {
    }

    public function normalizeX(float $x): float
    {
        return $x * $this->illuminant->referenceX();
    }

    public function normalizeY(float $y): float
    {
        return $y * $this->illuminant->referenceY();
    }

    public function normalizeZ(float $z): float
    {
        return $z * $this->illuminant->referenceZ();
    }
}
