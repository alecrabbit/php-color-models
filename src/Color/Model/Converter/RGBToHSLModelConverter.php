<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter;

use AlecRabbit\Color\Model\Converter\A\AModelConverter;
use AlecRabbit\Color\Model\Converter\Core\RGBToHSL;
use AlecRabbit\Color\Model\ModelHSL;
use AlecRabbit\Color\Model\ModelRGB;

/** @internal */
final readonly class RGBToHSLModelConverter extends AModelConverter
{
    protected static function getSourceModelClass(): string
    {
        return ModelRGB::class;
    }

    protected static function getTargetModelClass(): string
    {
        return ModelHSL::class;
    }

    protected static function getConverterClass(): string
    {
        return RGBToHSL::class;
    }
}
