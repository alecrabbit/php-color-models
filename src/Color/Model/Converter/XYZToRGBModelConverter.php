<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter;

use AlecRabbit\Color\Model\Converter\A\AModelConverter;
use AlecRabbit\Color\Model\Converter\Core\XYZToRGB;
use AlecRabbit\Color\Model\ModelRGB;
use AlecRabbit\Color\Model\ModelXYZ;

/** @internal */
final readonly class XYZToRGBModelConverter extends AModelConverter
{
    protected static function getSourceModelClass(): string
    {
        return ModelXYZ::class;
    }

    protected static function getTargetModelClass(): string
    {
        return ModelRGB::class;
    }

    protected static function getCoreConverterClass(): string
    {
        return XYZToRGB::class;
    }
}
