<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Contract\Converter\Core;

interface ILABRange
{
    public function getL(): float;

    public function getA(): float;

    public function getB(): float;
}
