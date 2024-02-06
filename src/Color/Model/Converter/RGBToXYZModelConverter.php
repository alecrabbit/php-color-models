<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter;

use AlecRabbit\Color\Model\Converter\A\AModelConverter;
use AlecRabbit\Color\Model\Converter\Core\RGBToXYZ;
use AlecRabbit\Color\Model\ModelRGB;
use AlecRabbit\Color\Model\ModelXYZ;

/** @internal */
final readonly class RGBToXYZModelConverter extends AModelConverter
{
    protected static function getSourceModelClass(): string
    {
        return ModelRGB::class;
    }

    protected static function getTargetModelClass(): string
    {
        return ModelXYZ::class;
    }

    protected static function getCoreConverterClass(): string
    {
        return RGBToXYZ::class;
    }
}
