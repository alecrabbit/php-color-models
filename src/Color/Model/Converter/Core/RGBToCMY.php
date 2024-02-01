<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\Core;

use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\Converter\Core\A\ACoreConverter;
use AlecRabbit\Color\Model\DTO\DCMY as CMY;
use AlecRabbit\Color\Model\DTO\DRGB as RGB;

final readonly class RGBToCMY extends ACoreConverter
{
    public function __construct(int $precision = self::CALC_PRECISION)
    {
        parent::__construct(RGB::class, $precision);
    }

    protected function doConvert(DColor $color): DColor
    {
        /** @var RGB $color */
        return new CMY(
            round(1 - $color->red, $this->precision),
            round(1 - $color->green, $this->precision),
            round(1 - $color->blue, $this->precision),
            round($color->alpha, $this->precision),
        );
    }
}
