<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Contract\Converter\Core;

interface ILabDenormalizer
{
    public function denormalizeL(float $l): float;

    public function denormalizeA(float $a): float;

    public function denormalizeB(float $b): float;
}
