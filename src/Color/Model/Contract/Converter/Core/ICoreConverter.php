<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Contract\Converter\Core;

use AlecRabbit\Color\Model\Contract\Converter\IConverter;

interface ICoreConverter extends IConverter
{
    final public const CALC_PRECISION = 6;
}
