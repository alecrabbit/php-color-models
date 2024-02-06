<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\Core\Illuminant;

use AlecRabbit\Color\Model\Contract\Converter\Core\IIlluminant;

/**
 * @see https://en.wikipedia.org/wiki/CIELAB_color_space
 */
final readonly class D50Deg10 implements IIlluminant
{
    private const XN = 0.967_20;
    private const YN = 1.0;
    private const ZN = 0.814_270;

    public function __construct(
        private float $x = self::XN,
        private float $y = self::YN,
        private float $z = self::ZN,
    ) {
    }

    public function referenceX(): float
    {
        return $this->x;
    }

    public function referenceY(): float
    {
        return $this->y;
    }

    public function referenceZ(): float
    {
        return $this->z;
    }
}