<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\Core\Illuminant;

use AlecRabbit\Color\Model\Contract\Converter\Core\IIlluminant;

/**
 * @see https://en.wikipedia.org/wiki/Illuminant_D65
 * @see https://en.wikipedia.org/wiki/CIELAB_color_space
 */
final readonly class D65Deg10 implements IIlluminant
{
    private const XN = 0.948_110;
    private const YN = 1.0;
    private const ZN = 1.073_040;

    public function __construct(
        public float $x = self::XN,
        public float $y = self::YN,
        public float $z = self::ZN,
    ) {
    }
}
