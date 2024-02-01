<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\Core;

use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\Converter\Core\A\ACoreConverter;
use AlecRabbit\Color\Model\DTO\DHSL as HSL;
use AlecRabbit\Color\Model\DTO\DRGB as RGB;

final readonly class RGBToHSL extends ACoreConverter
{
    public function __construct(int $precision = self::CALC_PRECISION)
    {
        parent::__construct(RGB::class, $precision);
    }

    protected function doConvert(DColor $color): DColor
    {
        /** @var RGB $color */
        $r = $color->red;
        $g = $color->green;
        $b = $color->blue;

        $max = max($r, $g, $b);
        $min = min($r, $g, $b);

        $h = 0;
        $s = 0;
        $l = ($max + $min) / 2;

        if ($max !== $min) {
            $d = $max - $min;

            $s = $l > 0.5
                ? $d / (2 - $max - $min)
                : $d / ($max + $min);

            $h = match (true) {
                    $r === $max => ($g - $b) / $d + ($g < $b ? 6 : 0),
                    $g === $max => ($b - $r) / $d + 2,
                    $b === $max => ($r - $g) / $d + 4,
                } / 6;
        }

        return new HSL(
            round($h, $this->precision),
            round($s, $this->precision),
            round($l, $this->precision),
            round($color->alpha, $this->precision),
        );
    }
}
