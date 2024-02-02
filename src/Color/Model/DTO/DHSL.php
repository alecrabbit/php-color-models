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
        public float $h,
        public float $s,
        public float $l,
        public float $alpha = 1.0,
    ) {
    }
}
