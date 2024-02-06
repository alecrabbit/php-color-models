<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Contract\Converter\Core;

interface ILABRange
{
    public function maxL(): float;

    public function maxA(): float;

    public function maxB(): float;

    public function minL(): float;

    public function minA(): float;

    public function minB(): float;
}
