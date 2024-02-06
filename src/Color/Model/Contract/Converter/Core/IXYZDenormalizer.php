<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Contract\Converter\Core;

interface IXYZDenormalizer
{
    public function denormalizeX(float $x): float;

    public function denormalizeY(float $y): float;

    public function denormalizeZ(float $z): float;
}
