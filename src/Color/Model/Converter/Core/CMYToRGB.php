<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\Core;

use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\Converter\Core\A\ACoreConverter;
use AlecRabbit\Color\Model\DTO\DCMY as CMY;
use AlecRabbit\Color\Model\DTO\DRGB as RGB;

final readonly class CMYToRGB extends ACoreConverter
{
    public function __construct(int $precision = self::CALC_PRECISION)
    {
        parent::__construct(CMY::class, $precision);
    }

    protected function doConvert(DColor $color): DColor
    {
        /** @var CMY $color */
        return new RGB(
            round((1 - $color->cyan), $this->precision),
            round((1 - $color->magenta), $this->precision),
            round((1 - $color->yellow), $this->precision),
            round($color->alpha, $this->precision),
        );
    }
}
