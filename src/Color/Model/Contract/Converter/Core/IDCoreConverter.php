<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Contract\Converter\Core;

use AlecRabbit\Color\Model\Contract\Converter\IDColorConverter;

interface IDCoreConverter extends IDColorConverter
{
    final public const CALC_PRECISION = 6;
}
