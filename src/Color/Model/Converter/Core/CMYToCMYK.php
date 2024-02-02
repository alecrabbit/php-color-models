<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\Core;

use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\Converter\Core\A\ACoreConverter;
use AlecRabbit\Color\Model\DTO\DCMY as CMY;
use AlecRabbit\Color\Model\DTO\DCMYK as CMYK;

/** @internal */
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
            $color->c,
            $color->m,
            $color->y,
        );

        if ($k === 1.0) {
            return new CMYK(0, 0, 0, 1); // black
        }

        return new CMYK(
            round(($color->c - $k) / (1 - $k), $this->precision),
            round(($color->m - $k) / (1 - $k), $this->precision),
            round(($color->y - $k) / (1 - $k), $this->precision),
            round($k, $this->precision),
            round($color->alpha, $this->precision),
        );
    }
}
