<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter;

use AlecRabbit\Color\Model\Converter\A\AModelConverter;
use AlecRabbit\Color\Model\Converter\Core\CMYToRGB;
use AlecRabbit\Color\Model\ModelCMY;
use AlecRabbit\Color\Model\ModelRGB;

/** @internal */
final readonly class CMYToRGBModelConverter extends AModelConverter
{
    protected static function getSourceModelClass(): string
    {
        return ModelCMY::class;
    }

    protected static function getTargetModelClass(): string
    {
        return ModelRGB::class;
    }

    protected static function getConverterClass(): string
    {
        return CMYToRGB::class;
    }

}
