<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter;

use AlecRabbit\Color\Model\Converter\A\AModelConverter;
use AlecRabbit\Color\Model\Converter\Core\RGBToCMY;
use AlecRabbit\Color\Model\ModelCMY;
use AlecRabbit\Color\Model\ModelRGB;

/** @internal */
final readonly class RGBToCMYModelConverter extends AModelConverter
{
    protected static function getSourceModelClass(): string
    {
        return ModelRGB::class;
    }

    protected static function getTargetModelClass(): string
    {
        return ModelCMY::class;
    }

    protected static function getConverterClass(): string
    {
        return RGBToCMY::class;
    }

}
