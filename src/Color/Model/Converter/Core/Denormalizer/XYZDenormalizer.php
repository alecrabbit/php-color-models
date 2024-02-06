<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\Core\Denormalizer;

use AlecRabbit\Color\Model\Contract\Converter\Core\IIlluminant;
use AlecRabbit\Color\Model\Contract\Converter\Core\IXYZDenormalizer;
use AlecRabbit\Color\Model\Converter\Core\Illuminant\D65Deg2;

final readonly class XYZDenormalizer implements IXYZDenormalizer
{
    public function __construct(
        private IIlluminant $illuminant = new D65Deg2(),
    ) {
    }

    public function denormalizeX(float $x): float
    {
        return $x / $this->illuminant->referenceX();
    }

    public function denormalizeY(float $y): float
    {
        return $y / $this->illuminant->referenceY();
    }

    public function denormalizeZ(float $z): float
    {
        return $z / $this->illuminant->referenceZ();
    }
}
