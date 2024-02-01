<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\DTO;

use AlecRabbit\Color\Model\Contract\DTO\DColor;

/**
 * @codeCoverageIgnore
 */
final readonly class DCMYK implements DColor
{
    public function __construct(
        public float $cyan,
        public float $magenta,
        public float $yellow,
        public float $black,
        public float $alpha = 1.0,
    ) {
    }
}
