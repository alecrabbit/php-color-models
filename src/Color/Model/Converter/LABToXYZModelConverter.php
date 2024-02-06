<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter;

use AlecRabbit\Color\Model\Converter\A\AModelConverter;
use AlecRabbit\Color\Model\Converter\Core\LABToXYZ;
use AlecRabbit\Color\Model\ModelLAB;
use AlecRabbit\Color\Model\ModelXYZ;

/** @internal */
final readonly class LABToXYZModelConverter extends AModelConverter
{
    protected static function getSourceModelClass(): string
    {
        return ModelLAB::class;
    }

    protected static function getTargetModelClass(): string
    {
        return ModelXYZ::class;
    }

    protected static function getCoreConverterClass(): string
    {
        return LABToXYZ::class;
    }
}
