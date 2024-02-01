<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\DTO;

use AlecRabbit\Color\Model\Contract\DTO\DColor;

/**
 * @codeCoverageIgnore
 */
final readonly class DCMY implements DColor
{
    public function __construct(
        public float $cyan,
        public float $magenta,
        public float $yellow,
        public float $alpha = 1.0,
    ) {
    }
}
