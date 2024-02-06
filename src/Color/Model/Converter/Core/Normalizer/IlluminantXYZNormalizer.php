<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\Core\Normalizer;

use AlecRabbit\Color\Model\Contract\Converter\Core\IXYZDenormalizer;
use AlecRabbit\Color\Model\Contract\Converter\Core\IXYZNormalizer;

final readonly class IlluminantXYZNormalizer implements IXYZNormalizer
{
    public function __construct(
        private IXYZDenormalizer $denormalizer,
        private IXYZNormalizer $normalizer,
    ) {
    }

    public function normalizeX(float $x): float
    {
        return $this->normalizer->normalizeX(
            $this->denormalizer->denormalizeX($x)
        );
    }

    public function normalizeY(float $y): float
    {
        return $this->normalizer->normalizeY(
            $this->denormalizer->denormalizeY($y)
        );
    }

    public function normalizeZ(float $z): float
    {
        return $this->normalizer->normalizeZ(
            $this->denormalizer->denormalizeZ($z)
        );
    }
}
