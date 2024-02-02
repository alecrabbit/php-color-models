<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\DTO;

use AlecRabbit\Color\Model\Contract\DTO\DColor;

/**
 * @codeCoverageIgnore
 */
final readonly class DXYZ implements DColor
{
    public function __construct(
        public float $x,
        public float $y,
        public float $z,
        public float $alpha = 1.0,
    ) {
    }
}
