<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Contract\Converter\Core;

interface ILabNormalizer
{
    public function normalizeL(float $l): float;

    public function normalizeA(float $a): float;

    public function normalizeB(float $b): float;
}
