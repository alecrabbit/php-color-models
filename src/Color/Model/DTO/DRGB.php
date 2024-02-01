<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\DTO;

use AlecRabbit\Color\Model\Contract\DTO\DColor;

/**
 * @codeCoverageIgnore
 */
final readonly class DRGB implements DColor
{
    public function __construct(
        public float $red,
        public float $green,
        public float $blue,
        public float $alpha = 1.0,
    ) {
    }
}
