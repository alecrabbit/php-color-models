<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\DTO;

use AlecRabbit\Color\Model\Contract\DTO\DColor;

/**
 * @codeCoverageIgnore
 */
final readonly class DHSL implements DColor
{
    public function __construct(
        public float $hue,
        public float $saturation,
        public float $lightness,
        public float $alpha = 1.0,
    ) {
    }
}
