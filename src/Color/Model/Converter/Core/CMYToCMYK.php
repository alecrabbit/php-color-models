<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\Core;

use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\Converter\Core\A\ACoreConverter;
use AlecRabbit\Color\Model\DTO\DCMY as CMY;
use AlecRabbit\Color\Model\DTO\DCMYK as CMYK;

final readonly class CMYToCMYK extends ACoreConverter
{
    public function __construct(int $precision = self::CALC_PRECISION)
    {
        parent::__construct(CMY::class, $precision);
    }

    protected function doConvert(DColor $color): DColor
    {
        /** @var CMY $color */
        $k = min(
            $color->cyan,
            $color->magenta,
            $color->yellow,
        );

        if ($k === 1.0) {
            return new CMYK(0, 0, 0, 1); // black
        }

        return new CMYK(
            round(($color->cyan - $k) / (1 - $k), $this->precision),
            round(($color->magenta - $k) / (1 - $k), $this->precision),
            round(($color->yellow - $k) / (1 - $k), $this->precision),
            round($k, $this->precision),
            round($color->alpha, $this->precision),
        );
    }
}
