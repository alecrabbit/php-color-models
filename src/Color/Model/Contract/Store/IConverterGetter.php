<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Contract\Store;

use AlecRabbit\Color\Model\Contract\Converter\IConverter;
use AlecRabbit\Color\Model\Contract\IColorModel;

interface IConverterGetter
{
    public function get(IColorModel $from, IColorModel $to): IConverter;
}
