<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Contract\Converter;

use AlecRabbit\Color\Model\Contract\IColorModel;

interface IModelConverter extends IConverter
{
    public static function to(): IColorModel;

    public static function from(): IColorModel;
}
