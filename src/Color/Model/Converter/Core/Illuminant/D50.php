<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\Core\Illuminant;

use AlecRabbit\Color\Model\Contract\Converter\Core\IIlluminant;

/**
 * @see https://en.wikipedia.org/wiki/CIELAB_color_space
 */
final readonly class D50 implements IIlluminant
{
    private const XN = 0.964_212;
    private const YN = 1.0;
    private const ZN = 0.825_188;

    public function __construct(
        public float $x = self::XN,
        public float $y = self::YN,
        public float $z = self::ZN,
    ) {
    }
}
