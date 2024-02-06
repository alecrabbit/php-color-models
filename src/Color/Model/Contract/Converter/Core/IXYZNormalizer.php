<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Contract\Converter\Core;

interface IXYZNormalizer
{
    public function normalizeX(float $x): float;

    public function normalizeY(float $y): float;

    public function normalizeZ(float $z): float;
}
