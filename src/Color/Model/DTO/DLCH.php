<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\DTO;

use AlecRabbit\Color\Model\Contract\DTO\DColor;

/**
 * @codeCoverageIgnore
 */
final readonly class DLCH implements DColor
{
    public function __construct(
        public float $lightness,
        public float $chroma,
        public float $hue,
        public float $alpha = 1.0,
    ) {
    }
}
