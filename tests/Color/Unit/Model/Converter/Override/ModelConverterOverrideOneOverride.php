<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Model\Converter\Override;

use AlecRabbit\Color\Model\Contract\Converter\IModelConverter;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\Contract\IColorModel;
use RuntimeException;

final class ModelConverterOverrideOneOverride implements IModelConverter
{

    public static function to(): IColorModel
    {
        return new ColorModelOverrideOne();
    }

    public static function from(): IColorModel
    {
        return new ColorModelOverrideTwo();
    }

    public function convert(DColor $color): DColor
    {
        throw new RuntimeException(__METHOD__ . ' INTENTIONALLY Not implemented.');
    }
}
