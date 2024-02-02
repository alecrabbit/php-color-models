<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Contract\Converter;

use AlecRabbit\Color\Model\Contract\DTO\DColor;

interface IConverter
{
    public function convert(DColor $color): DColor;
}
