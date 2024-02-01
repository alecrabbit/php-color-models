<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter;

use AlecRabbit\Color\Model\Converter\A\AModelConverter;
use AlecRabbit\Color\Model\Converter\Core\HSLToRGB;
use AlecRabbit\Color\Model\ModelHSL;
use AlecRabbit\Color\Model\ModelRGB;

/** @internal */
final readonly class HSLToRGBModelConverter extends AModelConverter
{
    protected static function getSourceModelClass(): string
    {
        return ModelHSL::class;
    }

    protected static function getTargetModelClass(): string
    {
        return ModelRGB::class;
    }

    protected static function getConverterClass(): string
    {
        return HSLToRGB::class;
    }
}
