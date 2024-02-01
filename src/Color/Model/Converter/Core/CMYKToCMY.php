<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\Core;

use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\Converter\Core\A\ACoreConverter;
use AlecRabbit\Color\Model\DTO\DCMY as CMY;
use AlecRabbit\Color\Model\DTO\DCMYK as CMYK;

final readonly class CMYKToCMY extends ACoreConverter
{
    public function __construct(int $precision = self::CALC_PRECISION)
    {
        parent::__construct(CMYK::class, $precision);
    }

    protected function doConvert(DColor $color): DColor
    {
        /** @var CMYK $color */
        return new CMY(
            round($color->cyan * (1 - $color->black) + $color->black, $this->precision),
            round($color->magenta * (1 - $color->black) + $color->black, $this->precision),
            round($color->yellow * (1 - $color->black) + $color->black, $this->precision),
            round($color->alpha, $this->precision),
        );
    }
}
